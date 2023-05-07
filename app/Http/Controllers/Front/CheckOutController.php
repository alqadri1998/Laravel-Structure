<?php

namespace App\Http\Controllers\Front;

use App\Events\newAdminNotifications;
use App\Events\newNotifications;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Origin;
use App\Models\Product;
use App\Models\Promotion;
use App\Traits\GetAttributes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Ramsey\Uuid\Uuid;
use stdClass;

class CheckOutController extends Controller
{
    use GetAttributes;

    public $category;
    public $cart;
    public $branch;
    public $address;
    public $brand;
    public $origin;
    public $promotion;
    public $coupon;

    public function __construct(Category $category, Cart $cart, Branch $branch, Address $address, Brand $brand, Origin $origin, Promotion $promotion)
    {
        parent::__construct();
        $this->category = $category;
        $this->cart = $cart;
        $this->branch = $branch;
        $this->address = $address;
        $this->brand = $brand;
        $this->origin = $origin;
        $this->promotion = $promotion;
    }

    public function index()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->with('product')->get();
        $user = auth()->user();
        $booking = 1;
        if ($cart->first()->with_fitting == 1){
            if (is_null($user->branch_detail)){
                return back()->with('err', 'Please select a branch for fitting before going to checkout.');
            }else{
                $booking = $user->branch_detail;
            }
        }
        $this->breadcrumbTitle = __('CHECKOUT');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('CHECKOUT')];

        $categories = Category::whereHas('languages')->where('parent_id', 0)->with('languages')->get();
        $this->setTranslations($categories);
        $subTotal = 0;
        $total_with_vat = 0;
        foreach ($cart as $key => $value) {
            $check = $this->checkRelations($value->brand_id, $value->origin_id, $value->promotion_id);
            if ($check == false) {
                $deleted = $this->deleteItem($value);
                if ($deleted == 'deleted') return back()->with('err', 'One of your cart item is not available anymore and has been deleted');
            }

            $this->coupon = $value->coupon;
            if ($value->product->vat == 0) {
                $total_with_vat += $value->product_price * $value->quantity;
            }
            $subTotal += $value->product_price * $value->quantity;
        }
        $vat = $subTotal * config('settings.value_added_tax')/100;
        $address = $this->address->getDefaultShipping();

        $data = [];
        $data['total'] = $total_with_vat + $vat;
//        $iframeUrl = $this->getCreateOrderUrl($data);
//        $user->update(['telr_reference'=>$iframeUrl['ref']]);

        if ($address) {
            return view('front.checkout.checkout', ['address' => $address, 'subTotal' => $subTotal, 'vat_total' => $total_with_vat, 'categories' => $categories, 'booking' => $booking, 'coupon' => $this->coupon, /*'iframeUrl'=>$iframeUrl['url']*/]);
        } else {
            $address = new Address();
            $address->id = 0;
            return view('front.checkout.checkout', ['address' => $address, 'subTotal' => $subTotal, 'vat_total' => $total_with_vat, 'categories' => $categories, 'booking' => $booking, 'coupon' => $this->coupon,/*'iframeUrl'=>$iframeUrl['url']*/]);
        }
    }

    public function updateAddress(UserRequest $request)
    {
//        dd('this is address method');
        $data = $request->only('first_name', 'last_name', 'email', 'user_phone', 'address', 'street_address', 'post_code');
        $data['user_id'] = auth()->user()->id;
        $data['type'] = 'billing';

        Address::updateOrCreate(['user_id' => $data['user_id'], 'type' => 'billing'], $data);
        if ($request->shipping_to == '0') {
            $data['first_name'] = $request->shipping_first_name;
            $data['last_name'] = $request->shipping_last_name;
            $data['email'] = $request->shipping_email;
            $data['user_phone'] = $request->shipping_user_phone;
            $data['address'] = $request->shipping_address;
            $data['street_address'] = $request->shipping_street_address;
            $data['post_code'] = $request->shipping_post_code;
            $data['type'] = 'shiping';
            Address::updateOrCreate(['user_id' => $data['user_id'], 'type' => 'shiping'], $data);
            if ($request->coupon_code != '') {
                return redirect(route('front.checkout.index', ['code' => $request->coupon_code, 'shipping' => 'shipping']))->with('status', __('Address Saved SuccessFully'));

            }
            return redirect(route('front.checkout.index', ['shipping' => 'shipping']))->with('status', __('Address Saved SuccessFully'));

        }
        return redirect()->back()->with('status', __('Address Saved SuccessFully'));
    }

    public function processPayment(CheckoutRequest $request)
    {
        $vehicle = [];
        $VehicleEncoded = '';
        if ($request->has(['vin_number', 'number_plate', 'vehicle', 'model', 'year'])){
            $vehicle = $request->only('vin_number', 'number_plate', 'vehicle', 'model', 'year');
            $VehicleEncoded = $this->getVehicleDetails($vehicle);
        }
//        dd($vehicle);
        $address = $request->except('_token', 'payment_method', 'order_notes', 'coupon', 'vehicle', 'model', 'year', 'booking', 'number_plate', 'vin_number');
        if ($request->has('address_id')) {
            $address = Address::create($address);
            $address['find_us'] = $request->find_us;
            $address['country'] = $request->country;
        }
//        dd($request->all(), route('front.user.checkout.payment-success'));
        $coupon = '';
        $couponPercent = '';
        if ($request->coupon != '') {
            $coupon = Coupon::where('code', $request->coupon)->where('is_used', '!=', 'used')->first();
            if ($coupon == null) {
                return redirect()->back()->with('err', __('Coupon Is Not Valid'));
            } else {
                $couponPercent = $coupon->percent;
            }
        }
//        $billing = Address::where(['user_id' => auth()->user()->id, 'type' => 'billing'])->first();
//        if ($billing == null) {
//            return redirect()->back()->with('err', __('Update Your Billling Address First'));
//        }
        $productIds = [];
        $billingAddress = null;
        $outOfStockProduct = [];
        $error = null;
        $cartData = Cart::whereHas('product')->with('product.languages')->where('user_id', auth()->user()->id)->get();
        foreach ($cartData as $cartItem) {
            $productIds[$cartItem->product->id] = $cartItem->product->id;
        }
        if (count($productIds) > 0) {
            $products = Product::whereIn('id', $productIds)->get();
            if (count($products) > 0) {
                if (count($productIds) == count($products)) {
                    $subTotal_with_vat = 0;
//                    $this->initPayPal();
                    $aedPrice = 0;
//                    $this->itemList = new ItemList();
                    $rate = getConversionRate();
                    foreach ($cartData as $cartItem) {
                        if ($cartItem->product->vat == 0) {
//                            $price_with_vat = round( $cartItem->product_price / $rate,2);
                            $subTotal_with_vat += $cartItem->product_price * $cartItem->quantity;
                        }
                        $cartItem->product->translation = $this->translateRelation($cartItem->product);
                        $aedPrice += $cartItem->product_price * $cartItem->quantity;
                        $price = round($cartItem->product_price / $rate, 2);
//                        $this->subTotal += $price * $cartItem->quantity;

//                        $paypalItem = new Item();
//                        $paypalItem->setName(str_limit($cartItem->product->translation->title, 250))
//                            ->setCurrency('USD')
//                            ->setQuantity($cartItem->quantity)
//                            ->setPrice($price);
//                        $this->itemList->addItem($paypalItem);
                    }
                    if ($couponPercent != '') {
//                        $discount = round($this->subTotal / 100 * $couponPercent, 2);
//                        $this->subTotal = round($this->subTotal - $discount, 2);
                        $aedDiscount = round($aedPrice / 100 * $couponPercent, 2);
                        $aedPrice = round($aedPrice - $aedDiscount, 2);
//                        $paypalItem = new Item();
//                        $paypalItem->setName(str_limit('Discount', 250))
//                            ->setCurrency('USD')
//                            ->setQuantity(1)
//                            ->setPrice(-$discount);
//                        $this->itemList->addItem($paypalItem);
                    }
                    $vat = config('settings.value_added_tax');
                    $vat = ($subTotal_with_vat / $rate) / 100 * $vat;
                    $details = new \stdClass();
                    $details->tax = number_format($vat, 2);
//                    $details->subtotal = number_format($this->subTotal, 2);
//                    $details->tax_rate = config('app.vat',2);
                    $this->details = $details;
//                    $this->subTotal = round($this->subTotal + $vat, 2);

//                    if ($request->shipping_to_diff == '') {
//                        $shipping = $billing;
//                    } else {
//                        $shipping = Address::where(['user_id' => auth()->user()->id, 'type' => 'shiping'])->first();
//                    }

                    $data['address'] = json_encode($address);
//                    $data['shipping'] = json_encode($shipping);
                    $data['aedPrice'] = $aedPrice;
                    $data['aedRate'] = getConversionRate();
                    $today = Carbon::now();
                    $orderNumber = $today->yearIso . $today->month . $today->day . '-' . $today->timestamp;
                    $vat = round($subTotal_with_vat / 100 * config('settings.value_added_tax'), 2);
                    $mobile_install_fee = round(config('settings.mobile_installation_fee'), 2);
                    $aedPrice = round($aedPrice, 2);
                    $image = (empty($cartData[0]->image)) ? $cartData[0]->product->image : $cartData[0]->image;
//                    dd('not so fast in making the order');
                    $order = Order::create([
                        'user_id' => auth()->user()->id,
                        'billing_address' => $data['address'],
                        'shipping_address' => $data['address'],
                        'order_number' => $orderNumber,
                        'payment_status' => 'pending',
                        'order_status' => 'confirmed',
                        'image' => $image,
                        'payment_method' => $request->payment_method,
                        'order_note' => $request->order_notes,
                        'total_amount' => $aedPrice + $vat + $mobile_install_fee,
                        'aed_price' => $aedPrice,
                        'coupon_code' => ($request->coupon !== '') ? $request->coupon : '',
                        'coupon_percent' => ($couponPercent !== '') ? $couponPercent : '',
                        'vat' => round($vat, 2),
                        'find_us' => $request->find_us,
                        'mobile_install_fee' => round($mobile_install_fee, 2),
                        'vehicle' => $VehicleEncoded,
                        'branch' => $request->booking
                    ]);
                    foreach ($cartData as $cartKey => $cartValue) {
                        $image = (empty($cartValue->image)) ? $cartValue->product->image : $cartValue->image;
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'user_id' => $cartValue->user_id,
                            'product_id' => $cartValue->product_id,
                            'name' => $cartValue->product->translation->title,
                            'product_price' => $cartValue->product_price,
                            'quantity' => $cartValue->quantity,
                            'total_price' => $cartValue->total_price,
                            'image' => $image,
                            'with_fitting' => $cartValue->with_fitting,
                            'brand_image' => is_null($cartValue->product->brand_id) ? null : $cartValue->product->brand->image,
                            'extras' => $cartValue->extras
                        ]);
                    }
                    if (!$order) {
                        set_alert("danger", __('Something Going Wrong'));
                        return redirect()->back();
                    }
                    if ($order->payment_method == 'pay at branch' || $order->payment_method == 'cash on delivery') {
                        if ($coupon != '') {
                            $coupon->update(['is_used' => 'used']);
                        }
                        Cart::where('user_id', auth()->user()->id)->delete();
                        session()->put('cart', 0);
                        $user = auth()->user();
                        $user->update(['branch_detail' => null]);
                        $notification = Notification::create([
                            'user_id' => auth()->user()->id,
                            'extras' => json_encode(['order_id' => $order->id, 'product_id' => $cartData->pluck('product_id')]),
                            'type' => 'user'
                        ]);
                        $notification->languages()->attach([2 => ['title' => 'Order Placed', 'description' => 'New Order Placed'],
                            1 => ['title' => 'أجل خلق', 'description' => 'ترتيب جديد تم إنشاؤه']]);

                        $adminNotification = Notification::create([
                            'admin_id' => env('Admin_id'),
                            'extras' => json_encode(['order_id' => $order->id, 'product_id' => $cartData->pluck('product_id')]),
                            'type' => 'admin'
                        ]);
                        $adminNotification->languages()->attach([2 => ['title' => 'Order Received', 'description' => 'New Order Received'],
                            1 => ['title' => 'طلب وارد', 'description' => 'تلقى طلب جديد']]);
                        event(new newNotifications($notification, auth()->user()->id));
                        event(new newAdminNotifications($notification, env('Admin_id')));
                        return redirect(route('front.dashboard.order.index', ['status' => 'confirmed']))->with('status', __('Your Order Has Been Placed'));
                    } else {
                        Order::where('id', $order->id)->update([
                            'order_status' => 'empty'
                        ]);
                    }

                    if ($order->payment_method == 'telr'){
                        $telrManager = new \TelrGateway\TelrManager();

                        $billingParams = [
                            'first_name' => $address['first_name'],
                            'sur_name' => $address['last_name'],
                            'address_1' => $address['address'],
                            'city' => $address['city'],
//                            'region' => $address['city'],
                            'zip' =>  $address['post_code'],
                            'country' => 'AE',
                            'email' => $address['email'],
                        ];
                        return $telrManager->pay($order->id, $order->total_amount, 'SD Tyres order payment', $billingParams)->redirect();
                        dd('in the name of the developer redirect...');
                    }
//                    $couponCode = '';
//                    if ($request->coupon != '') {
//                        $couponCode = $request->coupon;
//                    }
//                    $returnUrl = route('front.user.checkout.payment-response', ['order_id' => $order->id, 'coupon' => $couponCode]);
//                    set_time_limit(240);
//                    $url = $this->doExpressCheckout($returnUrl, $returnUrl);
//                    if ($url) {
//                        return redirect($url);
//                    } else {
//                        return redirect(route('cart.index'))->with('err', __('An Unknown Error Occurred, Try Later'));
//                    }
                } else {
                    $error = __('One Or More product(s) Were Not Available And Removed From Your Cart, Please Try Again');
                }
            }
        }
        set_alert('info', __('Cart Is Empty.'));
        return redirect()->back()->with('err', __('cart is empty'));
    }

    public function paymentResponse(Request $request)
    {

        $payerId = $request->get('PayerID');
        $token = $request->get('token');
        $this->initPayPal();
        $paymentId = session()->get('paypal_payment_id');
        $order = Order::find($request->get('order_id'));
        if (empty($payerId) || empty($token)) {

            $order->orderDetails()->delete();
            $order->delete();
            session()->forget('paypal_payment_id');
            return redirect(route('front.cart.index'))->with('err', __('Payment Failed! Your Order Is Canceled.'));
        }
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $result = $payment->execute($execution, $this->apiContext);
        if ($result->getState() == 'approved') {
            $today = Carbon::now();
            $paymentData = $payment->toArray();
            $order->update([
                'user_id' => auth()->user()->id,
                'payment_status' => 'confirmed',
                'order_status' => 'confirmed',
                'payment_id' => (isset($paymentData['id'])) ? $paymentData['id'] : '',
                'payer_status' => (isset($paymentData['payer']['status'])) ? $paymentData['payer']['status'] : '',
                'payer_email' => (isset($paymentData['payer']['payer_info']['email'])) ? $paymentData['payer']['payer_info']['email'] : '',
                'first_name' => (isset($paymentData['payer']['payer_info']['first_name'])) ? $paymentData['payer']['payer_info']['first_name'] : '',
                'last_name' => (isset($paymentData['payer']['payer_info']['last_name'])) ? $paymentData['payer']['payer_info']['last_name'] : '',
                'payer_id' => (isset($paymentData['payer']['payer_info']['payer_id'])) ? $paymentData['payer']['payer_info']['payer_id'] : '',
                'charges' => (isset($paymentData['transactions'][0]['amount']['total'])) ? $paymentData['transactions'][0]['amount']['total'] : 0,
                'currency' => (isset($paymentData['transactions'][0]['amount']['currency'])) ? $paymentData['transactions'][0]['amount']['currency'] : 'USD',
                'transaction_details' => (isset($paymentData['transactions'][0]['amount']['details'])) ? json_encode($paymentData['transactions'][0]['amount']['details']) : '',
                'paypal_response' => $payment->toJSON(),
                'payment_method' => 'paypal',
            ]);
            $cartData = Cart::where('user_id', auth()->user()->id)->pluck('product_id');
            Cart::where('user_id', auth()->user()->id)->delete();
            $user = auth()->user();
            $user->update(['branch_detail' => null]);
            $when = Carbon::now()->addSeconds(10);
            set_alert('success', __('Products purchased successfully'));
//            return redirect(route('orders.my-orders','confirmed'))->with('status', __('Products purchased successfully'));
            if ($request->coupon != '') {
                $coupon = Coupon::where('code', $request->coupon)->first();
                $coupon->update(['is_used' => 'used']);
            }
            $notification = Notification::create([
                'user_id' => auth()->user()->id,
                'extras' => json_encode(['order_id' => $order->id, 'product_id' => $cartData]),
                'type' => 'admin'
            ]);
            $notification->languages()->attach([2 => ['title' => 'Order Placed', 'description' => 'New Order Placed'],
                1 => ['title' => 'أجل خلق', 'description' => 'ترتيب جديد تم إنشاؤه']]);
            event(new newNotifications($notification, auth()->user()->id));
            $adminNotification = Notification::create([
                'admin_id' => env('Admin_id'),
                'extras' => json_encode(['order_id' => $order->id, 'product_id' => $cartData]),
                'type' => 'admin'
            ]);
            $adminNotification->languages()->attach([2 => ['title' => 'Order received', 'description' => 'New order Received'],
                1 => ['title' => 'طلب وارد', 'description' => 'تلقى طلب جديد']]);
            event(new newAdminNotifications($adminNotification, env('Admin_id')));

            return redirect(route('front.dashboard.order.index', ['status' => 'confirmed']))->with('status', __('Your Order Has Been Placed'));
        } else {
            $order->orderDetails()->detach();
            $order::destory($request->get('order_id'));
            session()->forget('paypal_payment_id');
            set_alert('danger', __('Payment failed! Your order is canceled.'));
            return redirect(route('front.dashboard.index'))->with('err', __('Payment Failed! Your Order Is Canceled.'));
        }
    }

    public function getCreateOrderUrl($data){
        $cart_id = Uuid::uuid4()->toString().'-'.time();
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => config('telr.create.ivp_store'),
            'ivp_authkey' => config('telr.create.ivp_authkey'),
            'ivp_cart' => $cart_id,
            'ivp_test' => config('telr.test_mode'),
            'ivp_amount' => $data['total'],
            'ivp_currency' => config('telr.currency'),
            'ivp_desc' => 'Product Description',
//            'return_auth' => config('telr.create.return_auth'),
            'return_auth' => route('front.user.checkout.payment-success',['cart_id'=>$cart_id]),
            'return_can' => config('telr.create.return_can'),
            'return_decl' => config('telr.create.return_decl'),
            'ivp_framed' => 2,
//            'bill_fname' => 'Test',
//            'bill_sname' => 'User',
//            'bill_addr1' => 'Test User address',
//            'bill_city' => 'Dubai',
//            'bill_country' => 'AE',
//            'bill_zip' => '54123',
//            'bill_email' => 'testuser@user.com',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($results,true);
        $ref= trim($results['order']['ref']);
        $url= trim($results['order']['url']);
        if (empty($ref) || empty($url)) {
            # Failed to create order
        }
        return ['url'=>$url, 'ref'=>$ref];

    }

    public function checkTransactionTelr($user){
        $params = array(
            'ivp_method' => 'check',
            'ivp_store' => config('telr.create.ivp_store'),
            'ivp_authkey' => config('telr.create.ivp_authkey'),
            'order_ref' => $user->telr_reference,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);
        $results = json_decode($results,true);
        return $results;
    }

    public function paymentResponseTelr(request $request){
        $user = auth()->user();
        $paymentDetails = $this->checkTransactionTelr($user);
        $telrManager = new \TelrGateway\TelrManager();
        $transaction = $telrManager->handleTransactionResponse($request);
        $order = Order::find($transaction->order_id);

        if ($transaction->approved == 0){
            $order->orderDetails()->delete();
            $order->delete();
            return redirect(route('front.cart.index'))->with('err', __('Payment Failed! Your Order Is Canceled.'));

        }else{

            $carts = Cart::where('user_id', $user->id)->get();

            $order->update([
                'user_id' => auth()->user()->id,
                'payment_status' => 'confirmed',
                'order_status' => 'confirmed',
                'payment_id' => $transaction->trx_reference,
                'payer_status' => $transaction->status,
                'payer_email' => $transaction->billing_email,
                'first_name' => $transaction->billing_fname,
                'last_name' => $transaction->billing_sname,
//                'payer_id' => (isset($paymentData['payer']['payer_info']['payer_id'])) ? $paymentData['payer']['payer_info']['payer_id'] : '',
                'charges' => $transaction->amount,
                'currency' => 'aed',
                'transaction_details' => $transaction->description,
                'paypal_response' => json_encode($transaction->response),
            ]);

            $coupon = Coupon::where('code',$order->coupon_code)->first();
            if ($coupon != '') {
                $coupon->update(['is_used' => 'used']);
            }

            $user->update(['branch_detail' => null]);

            foreach ($carts as $cart){
                $notification = Notification::create([
                    'user_id' => auth()->user()->id,
                    'extras' => json_encode(['order_id' => $order->id, 'product_id' => $cart->product_id]),
                    'type' => 'user'
                ]);
                $notification->languages()->attach([2 => ['title' => 'Order Placed', 'description' => 'New Order Placed'],
                    1 => ['title' => 'أجل خلق', 'description' => 'ترتيب جديد تم إنشاؤه']]);

                $adminNotification = Notification::create([
                    'admin_id' => env('Admin_id'),
                    'extras' => json_encode(['order_id' => $order->id, 'product_id' => $cart->product_id]),
                    'type' => 'admin'
                ]);
                $adminNotification->languages()->attach([2 => ['title' => 'Order Received', 'description' => 'New Order Received'],
                    1 => ['title' => 'طلب وارد', 'description' => 'تلقى طلب جديد']]);
                event(new newNotifications($notification, auth()->user()->id));
                event(new newAdminNotifications($notification, env('Admin_id')));
                $cart->delete();
            }
            session()->put('cart', 0);

            return redirect(route('front.dashboard.order.index', ['status' => 'confirmed']))->with('status', __('Your Order Has Been Placed'));
        }

    }

    public function getVehicleDetails($vehicle)
    {
        $objVehicle = (object)$vehicle;
        $category = $this->category->findById($objVehicle->vehicle);
        $subcategory = $this->category->findById($objVehicle->model);

        $temp = new \stdClass();
        $temp->vin_number = $objVehicle->vin_number;
        $temp->number_plate = $objVehicle->number_plate;
        $temp->vehicle = $category->translation->name;
        $temp->model = $subcategory->translation->name;
        $temp->year = $objVehicle->year;

        return json_encode($temp);
    }

    public function selectLocation()
    {
        $carts = $this->cart->findByUserId();
        $this->breadcrumbTitle = __('Select Location');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Select Location')];

        $branches = $this->branch->all();
        $this->setTranslations($branches);

        $dates = [];
        for ($i = 0; $i < 14; $i++) {
            array_push($dates, Carbon::now()->addDays($i)->toDateString());
        }

        foreach ($carts as $cart) {
            if ($cart->with_fitting == 1) {
                return view('front.checkout.locations', compact('branches', 'dates'));

            } else {
                return redirect(route('front.checkout.index'));
            }
        }
    }

    public function getBooking($request)
    {
        $branch = $this->branch->findBySlug($request['location']);
        $check = $this->branch->checkBranchDays($request['booking_date'], $branch);
        if ($check) {
            $temp = new StdClass();
            $temp->name = $branch->translation->title;
            $temp->date = $request['booking_date'];
            $temp->time = $request['booking_time'];
            $temp = json_encode($temp);

            return $temp;

        } else {
            return false;
        }

    }

    public function checkRelations($brand, $origin, $promotion)
    {
        if (!is_null($brand)) {
            $brand = $this->brand->findWithProducts($brand);
            if (is_null($brand)) {
                return false;
            }

        }

        if (!is_null($origin)) {
            $origin = $this->origin->findWithProducts($origin);
            if (is_null($origin)) {
                return false;
            }
        }

        if (!is_null($promotion) && $promotion > 0) {
            $promotion = $this->promotion->findWithProducts($promotion);
            if (is_null($promotion)) {
                return false;
            }
        }

        return true;
    }

    public function deleteItem($item)
    {
        if ($item->delete()) return 'deleted';
    }

}
