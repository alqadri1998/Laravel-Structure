<?php namespace App\Http\Controllers\Admin;

use App\Events\newNotifications;
use App\Models\Admin;
use App\Models\Attribute;
use App\Models\Notification;
use App\Models\Order;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Traits\CartTotal;
use App\Traits\GetAttributes;
use Carbon\Carbon;
use App\Traits\EMails;
use DB;

class OrdersController extends Controller
{
    use GetAttributes, CartTotal;

    public function __construct()
    {

        parent::__construct('adminData', 'admin');
//        $this->middleware('admin.role:crud', ['only' => ['index']]);
//        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
//        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
//        $this->middleware('admin.role:read', ['only' => ['show']]);
//        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
//        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
//        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Orders';
    }

    public function order($status)
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Orders'];
        return view('admin.orders.index', ['status' => $status, 'previous' => '']);
    }

    public function all($status)
    {
        if ($status == 'pending') {
            $status = 'confirmed';
        }
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'order_number', 'dt' => 'order_number'],
            ['db' => 'order_status', 'dt' => 'order_status'],
            ['db' => 'payment_status', 'dt' => 'payment_status'],
            ['db' => 'payment_method', 'dt' => 'payment_method'],
            ['db' => 'charges', 'dt' => 'charges'],
            ['db' => 'currency', 'dt' => 'currency'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'total_amount', 'dt' => 'total_amount'],
            ['db' => 'coupon_code', 'dt' => 'coupon_code'],
            ['db' => 'coupon_percent', 'dt' => 'coupon_percent'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at']
        ];
        $count = 0;
        DataTable::init(new Order, $columns);
        DataTable::with('user');
        DataTable::where('order_status', '=', $status);
        $createdAt = \request('datatable.query.createdAt', '');
        $payment_method = \request('datatable.query.payment_method', '');
        $order_status = \request('datatable.query.order_status', '');
        $order_number = \request('datatable.query.order_number', '');
        $updatedAt = \request('datatable.query.updatedAt', '');
        $deletedAt = \request('datatable.query.deletedAt', '');
        $sortOrder = \request('datatable.sort.sort');
        $sortColumn = \request('datatable.sort.field');

        if ($createdAt != '') {
            $createdAt = Carbon::createFromFormat('m/d/Y', $createdAt);
            $cBetween = [$createdAt->hour(0)->minute(0)->second(0)->timestamp, $createdAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('created_at', $cBetween);
        }
        if ($updatedAt != '') {
            $updatedAt = Carbon::createFromFormat('m/d/Y', $updatedAt);
            $uBetween = [$updatedAt->hour(0)->minute(0)->second(0)->timestamp, $updatedAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('updated_at', $uBetween);
        }

        if ($payment_method != '') {
            DataTable::where('payment_method', '=', $payment_method);
        }
        if ($order_status != '') {
            DataTable::where('order_status', '=', $order_status);
        }
        if ($order_number != '') {
            DataTable::where('order_number', '=', $order_number);
        }
        DataTable::orderBy('id', 'desc');
        $order = DataTable::get();
        $dateFormat = config('settings.date-format');
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($order['data']) > 0) {
            foreach ($order['data'] as $key => $data) {
                $count = $count + 1;
                $order['data'][$key]['id'] = $count + $perPage;
                $order['data'][$key]['name'] = $data['user']['full_name'];
                $order['data'][$key]['amount'] = $data['charges'] . ' ' . $data['currency'];
                $order['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $order['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $order['data'][$key]['actions'] =
                    '<a href="' . route('admin.orders.order-detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Order Details"><i class="fas fa-eye"></i></a>';
                unset($data['user']);
            }
        }
        return response($order);
    }

    public function save($id = 0)
    {

        DB::beginTransaction();
        try {
            $admin = Admin::where('id', '=', $this->user['id'])->first();
            $data['address'] = $admin->address;
            $data['admin_id'] = $this->user['id'];
            $data['vat'] = config('settings.value_added_tax');
            $data['vat_amount'] = $this->vatTax(Cart::total(null, null, ''));
            $data['total_amount'] = $data['vat_amount'] + Cart::total(null, null, '');

            $creditAmount = $admin->credit_limit - $data['total_amount'];
            if ($data['total_amount'] < $admin->credit_limit) {
                Admin::where('id', '=', $this->user['id'])->update(['credit_limit' => $creditAmount]);


                $order = Order::updateOrCreate(['id' => $id], $data);

                foreach (Cart::content() as $key => $cart) {
                    $orderItems = [
                        'product_id' => $cart->id,
                        'brand_id' => $cart->options->brandsId,
                        'order_id' => $order->id,
                        'price' => $cart->price,
                        'gross_price' => $cart->options->grossPrice,
                        'quantity' => $cart->qty,
                        'reference' => $cart->options->reference,
                        'item_code' => $cart->options->itemCode,
                        'dg' => $cart->options->dg,
                        'discount' => $cart->options->discount,
                        'total_amount' => $cart->qty * $cart->price,
                        'delivery_type_id' => $cart->options->deliveryType
                    ];
                    $orderDetailId = OrderDetail::create($orderItems)->id;
                }
                DB::commit();

                $data['receiver_email'] = config('settings.email');
                $data['receiver_name'] = config('settings.company_name');
                $data['message_text'] = 'Order Received';
                $data['full_name'] = $admin->full_name;
                $data['sender_name'] = $admin->full_name;
                $data['subject'] = 'Order Received';
                $data['email'] = $admin->email;
                $data['orderDetailsHeading'] = 'Order Details';
                $data['check'] = 1;
                $data['status'] = ' Created an order #' . $order->id;
                $data['order'] = Order::with('orderDetails')->where('id', '=', $order->id)->first();
//            $this->sendMail($data, 'emails.contact_us', $data['subject'], $data['receiver_email'], $data['email']);
                if ($order) {
                    Cart::destroy();
                    session()->forget('CART_PRODUCTS');
                    return redirect()->route('admin.orders.index')->with('status', 'Order Is Placed Successfully');
                }
//            set_alert('success', __('We received your mail successfully'));
            } else {
                return redirect()->back()->with('status', 'You Are Exceeding From Credit Limit');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('status', 'There Is some Error Plz Try again ');
        }
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Order' : 'Add Order');
        $this->breadcrumbs[route('admin.orders.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Orders'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.orders.edit', [
            'method' => 'PUT',
            'orderId' => $id,
            'action' => route('admin.orders.update', $id),
            'heading' => $heading,
            'regions' => $this->getRegions(),
            'order' => $this->getViewParams($id)
        ]);
    }

    public function update(OrderRequest $request, $id)
    {
        $err = $this->save($request, $id);
        return ($err) ? $err : redirect(route('admin.orders.index'))->with('status', 'Order updated successfully.');
    }

    private function getViewParams($id = 0)
    {
        $order = new Order();
        if ($id > 0) {
            $order = Order::findOrFail($id);
        }
        return $order;
    }

    public function destroy($id)
    {
        $order = Order::where('id', '=', $id)->first();
        $admin = Admin::where('id', '=', $order->admin_id)->first();
        $totalCreditLimit = $admin->credit_limit + $order->total_amount;
        Admin::where('id', '=', $order->admin_id)
            ->update(['credit_limit' => $totalCreditLimit]);
        $orderDetail = OrderDetail::where('order_id', '=', $id)->get();
        foreach ($orderDetail as $orderDetailData) {
            OrderDetail::destroy($orderDetailData->id);
        }
        Order::destroy($id);
        return response(['msg' => 'Order deleted successfully']);
    }

    public function orderDetail($orderId)
    {
        $this->breadcrumbs[route('admin.orders.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Orders'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Order Detail'];

        $order = Order::whereHas('orderDetails')->with('user', 'orderDetails.product.languages')->where('id', $orderId)->first();
        $previous = $order->order_status;
        foreach ($order->orderDetails as $key => $orderDetail) {
            $orderDetail->product->translation = $this->translateRelation($orderDetail->product, 'languages');
            unset($orderDetail->product->languages);
            $extras = json_decode($orderDetail['extras']);
            $list = '';
            if ($extras !== NULL) {
                /* We are no longer saving attribute ID in the extras, instead we are saving attribute as name and its subAttribute as value*/
//                $tempsubAttributes = implode(',', $extras->subAttributes);
//                $tempAttributes = implode(',', $extras->attributes);
//                $attributes = Attribute::whereIn('id',$extras->attributes)->with('languages')->orderByRaw(DB::raw("FIELD(id, $tempAttributes)"))->get();
//                $attributes =  $this->setTranslations($attributes);
//                $subAttributes = Attribute::whereIn('id' , $extras->subAttributes)->with('languages')->orderByRaw(DB::raw("FIELD(id, $tempsubAttributes)"))->get();
//                $subAttributes =   $this->setTranslations($subAttributes);
                foreach ($extras as $extra) {
                    $list .= '<li class="nav-item pr-2 d-flex"><span class="attribute-heading font-weight-bold">' . $extra->name . '</span> : ' . $extra->value . '</li>';
                }
            }
            $orderDetail->list = $list;
        }
        return view('admin.orders-detail.index', [
            'orderID' => $orderId, 'billing' => json_decode($order->billing_address), 'shipping' => json_decode($order->shipping_address), 'orderNotes' => $order->order_note, 'previous' => $previous, 'orderDetails' => $order->orderDetails, 'order_amount' => $order->total_amount, 'user' => $order->user,
            'coupon' => $order->coupon_code

        ]);
    }

    public function ordersDetailAll($id)
    {
        $this->breadcrumbs[route('admin.orders.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Orders'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Orders Detail'];
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'item_status', 'dt' => 'item_status'],
            ['db' => 'product_id', 'dt' => 'product_id'],
            ['db' => 'quantity', 'dt' => 'quantity'],
            ['db' => 'extras', 'dt' => 'extras'],
            ['db' => 'order_id', 'dt' => 'order_id'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at']
        ];
        DataTable::init(new OrderDetail, $columns);

        DataTable::where('order_id', '=', $id);
        $createdAt = \request('datatable.query.createdAt', '');
        $item_status = \request('datatable.query.item_status', '');
        $updatedAt = \request('datatable.query.updatedAt', '');
        if ($createdAt != '') {
            $createdAt = Carbon::createFromFormat('m/d/Y', $createdAt);
            $cBetween = [$createdAt->hour(0)->minute(0)->second(0)->timestamp, $createdAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('created_at', $cBetween);
        }
        if ($updatedAt != '') {
            $updatedAt = Carbon::createFromFormat('m/d/Y', $updatedAt);
            $uBetween = [$updatedAt->hour(0)->minute(0)->second(0)->timestamp, $updatedAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('updated_at', $uBetween);
        }
        DataTable::orderBy('id', 'desc');
        $order = DataTable::get();
        $dateFormat = config('settings.date-format');
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * 10) - $perPage;
        if (sizeof($order['data']) > 0) {
            foreach ($order['data'] as $key => $data) {
                $count = $count + 1;
                $product = App\Models\Product::where('id', $data['product_id'])->whereHas('languages')->with('languages')->first();
                $product = $this->translateRelation($product, 'languages');
                $list = '';
                $extras = json_decode($data['extras']);
                if ($extras !== NULL) {
                    $tempsubAttributes = implode(',', $extras->subAttributes);
                    $tempAttributes = implode(',', $extras->attributes);
                    $attributes = Attribute::whereIn('id', $extras->attributes)->with('languages')->orderByRaw(DB::raw("FIELD(id, $tempAttributes)"))->get();
                    $attributes = $this->setTranslations($attributes);
                    $subAttributes = Attribute::whereIn('id', $extras->subAttributes)->with('languages')->orderByRaw(DB::raw("FIELD(id, $tempsubAttributes)"))->get();
                    $subAttributes = $this->setTranslations($subAttributes);
                    foreach ($attributes as $attributeKey => $attributeValue) {
                        $list .= $attributeValue->translation->name . ' : ' . $subAttributes[$attributeKey]->translation->name . "<br>";
                    }
                }
                $order['data'][$key]['extras'] = $list;
                $order['data'][$key]['id'] = $count + $perPage;
                $order['data'][$key]['name'] = $product->title;
                $order['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $order['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                if ($data['item_status'] == 'complete' || $data['item_status'] == 'canceled') {
                    $order['data'][$key]['actions'] = '';
                } else {
                    $order['data'][$key]['actions'] = ($data['item_status'] == 'pending' ? '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill status-record-button" href="javascript:{};" data-id="' . $data['id'] . '" data-status="shipping" title="ship"><i class="fas  fa-truck"></i></a>' :
                            '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill status-record-button" href="javascript:{};" data-id="' . $data['id'] . '" data-status="complete" title="complete"><i class="fas  fa-check"></i></a>') . '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill status-record-button" href="javascript:{};" data-id="' . $data['id'] . '" data-status="canceled" title="Cancel Order"><i class="fas  fa-times"></i></a>';
                }
            }
        }
        return response($order);

    }

    public function changeStatus($orderId, $status)
    {
        $orderDetail = OrderDetail::whereHas('order')->with('order')->where('id', $orderId)->with('order')->firstOrFail();
        if ($status == 'canceled') {

            $rate = getConversionRate();
            $amount = round($orderDetail->total_price / $rate, 2);
            if ($orderDetail->order->coupon_percent > 0) {
                $discountamount = $orderDetail->total_price / 100 * $orderDetail->order->coupon_percent;
                $amount = $orderDetail->total_price - $discountamount;
                $amount = round($amount / $rate, 2);
            }
            $paypalResponse = json_decode($orderDetail->order->paypal_response);
            if ($paypalResponse) {
                $saleId = $paypalResponse->transactions[0]->related_resources[0]->sale->id;
                $this->initPayPal();
                $response = $this->refundPayment($amount, $saleId);
                if ($response == 'error') {
                    return 'failed';
                }
            }
            $product = App\Models\Product::find($orderDetail->product_id);

            $productQuantity = $product->quantity + $orderDetail->quantity;
            $product->update(['quantity' => $productQuantity]);
            $orderDetail->update(['item_status' => $status]);
            $orderItems = OrderDetail::where('order_id', $orderDetail->order_id)->get();
            $title_ar = 'تم إلغاء الطلب';
            $description_ar = 'تم إلغاء المنتج من طلبك. تم استرداد المبلغ المدفوع لهذا المنتج';
            $title_en = 'Order Canceled';
            $description_en = 'product from your order has been canceled. payement for that product has been refund';
            $notification = Notification::create([
                'user_id' => $orderDetail->user_id,
                'extras' => json_encode(['order_id' => $orderDetail->order_id, 'product_id' => $orderDetail->product_id]),
                'type' => 'user'
            ]);
            $notification->languages()->attach([2 => ['title' => $title_en, 'description' => $description_en],
                1 => ['title' => $title_ar, 'description' => $description_ar]]);
            event(new newNotifications($notification, $orderDetail->user_id));
            $orderStatus = true;
            $status = 'canceled';
            foreach ($orderItems as $key => $item) {
                if ($item->item_status == 'pending' || $item->item_status == 'shipping') {
                    $orderStatus = false;
                    exit;
                }
                if ($item->item_status == 'complete') {
                    $status = 'completed';
                }
            }
            if ($orderStatus == true) {
                Order::where('id', $orderDetail->order_id)->update(['order_status' => $status]);
            }

            return 'canceled';
        }
        $orderDetail->update(['item_status' => $status]);
        if ($status == 'shipping') {
            Order::where('id', $orderDetail->order_id)->update(['order_status' => 'In Progress']);
            $title_ar = 'في تقدم';
            $description_ar = 'طلبك ' . $orderDetail->order->order_number . 'في تقدم';
            $title_en = 'In Progress';
            $description_en = 'Your Order ' . $orderDetail->order->order_number . ' is in progress';
        }
        if ($status == 'complete') {
            $orderItems = OrderDetail::where('order_id', $orderDetail->order_id)->get();
            $orderStatus = true;
            $status = 'canceled';
            foreach ($orderItems as $key => $item) {
                if ($item->item_status == 'pending' || $item->item_status == 'shipping') {
                    $orderStatus = false;
                    exit;
                }
                if ($item->item_status == 'complete') {
                    $status = 'completed';
                }
            }
            if ($orderStatus == true) {
                Order::where('id', $orderDetail->order_id)->update(['order_status' => $status]);
            }
            $title_ar = 'اكتمال';
            $description_ar = 'طلبك ' . $orderDetail->order->order_number . 'قد اكتمل';
            $title_en = 'Order Completed';
            $description_en = 'Your Order ' . $orderDetail->order->order_number . ' is completed';
            $notification = Notification::create([
                'user_id' => $orderDetail->user_id,
                'extras' => json_encode(['order_id' => $orderDetail->order_id, 'product_id' => $orderDetail->product_id]),
                'type' => 'user'
            ]);
            $notification->languages()->attach([2 => ['title' => $title_en, 'description' => $description_en],
                1 => ['title' => $title_ar, 'description' => $description_ar]]);
            event(new newNotifications($notification, $orderDetail->user_id));
            return 'completed';
        }

        $notification = Notification::create([
            'user_id' => $orderDetail->user_id,
            'extras' => json_encode(['order_id' => $orderDetail->order_id, 'product_id' => $orderDetail->product_id]),
            'type' => 'user'
        ]);
        $notification->languages()->attach([2 => ['title' => $title_en, 'description' => $description_en],
            1 => ['title' => $title_ar, 'description' => $description_ar]]);
        event(new newNotifications($notification, $orderDetail->user_id));
        return 'status';
    }
}
