<?php

namespace App\Http\Controllers\Front;

use App\Events\CartChangeNotifications;
use App\Http\Requests\CheckoutLocationRequest;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Foreach_;
use stdClass;


class CartController extends Controller
{
    public $branch;
    public $cart;

    public function __construct(Branch $branch, Cart $cart)
    {
        $this->middleware('auth');
        parent::__construct();
        $this->branch = $branch;
        $this->cart = $cart;
    }

    public function add(Request $request)
    {
        $products = Product::where('id', $request->product_id)->with(['attributes', 'origin','brand', 'promotion'])->get();

        $product = $products->first();
        $this->setTranslations($products, 'languages', ['attributes' => 'languages','origin' => 'languages', 'brand' => 'languages','promotion' => 'languages' ]);
        $attributes = $this->getAttributes($product->attributes,$product->origin, $product->brand, $product->promotion);
//        return response($attributes)->throwResponse();

        $product = Product::find($request->product_id);

        if ($product->quantity == 0) {
            if ($request->ajax()){
                return response()->json(__('Product Is Out Of Stock'));
            }else{
                return redirect()->back()->with('err', __('Product Is Out Of Stock'));
            }
        }
        if ($request->quantity > $product->quantity) {
            if ($request->ajax()){
                return response()->json(__('Your Quantity Is Greater Than Stock'));
            }else{
                return redirect()->back()->with('err', __('Your Quantity Is Greater Than Stock'));
            }
        }
        $quantity = $product->quantity - $request->quantity;
        $data['product_price'] = $product->price;
        if ($product->offer) {
            $data['product_price'] = $product->discount;
        }
        $data['brand_id'] = $product->brand_id;
        $data['origin_id'] = $product->origin_id;
        $data['promotion_id'] = $product->promotion_id;
        $data['quantity'] = $request->quantity;
        $data['total_price'] = $data['product_price'] * $data['quantity'];
        $data['user_id'] = auth()->user()->id;
        $data['extras'] = '';
        if (count($attributes) > 0) {
            $data['extras'] = json_encode($attributes);
        }
        $data['product_id'] = $request->product_id;
        $data['image'] = $request->image;
//            dd($data);
        $cartData = Cart::where('user_id', auth()->user()->id)->get();
        if (count($cartData) > 0) {
            $cartProductExist = $cartData->where('product_id', $request->product_id)->where('extras', $data['extras'])->first();
            $diffAttribute = false;
//            if ($cartProductExist !== null) {
//                $extras = json_decode($cartProductExist->extras);
//
//                foreach ($subattribute as $key => $value) {
//                    if (!in_array($value, $extras->subAttributes)) {
//                        $diffAttribute = true;
//                    }
//                }
//            }
            if ($cartProductExist !== null) {
                $productQuantity = $cartProductExist->quantity + $request->quantity;
                $cartProductExist->update(['quantity' => $productQuantity]);
                $product->update(['quantity' => $quantity]);

                event(new CartChangeNotifications('cart', auth()->id()));

                session()->put('cart', $cartCount = Cart::where('user_id', auth()->user()->id)->count());
                if ($request->ajax()){
                    return response()->json('Product Added to Cart', 200);
                }else {
                    return redirect(route('front.cart.index'));
                }
            }
            if ($diffAttribute == true && $cartProductExist !== null) {
                $cart = Cart::create($data);
                $product->update(['quantity' => $quantity]);
                session()->put('cart', $cartCount = Cart::where('user_id', auth()->user()->id)->count());
                if ($request->ajax()){
                    return response()->json('Product Added to Cart', 200);
                }else {
                    return redirect(route('front.cart.index'));
                }
            }
        }
//        return response($data)->throwResponse();
        $cart = Cart::create($data);
        $product->update(['quantity' => $quantity]);
        session()->put('cart', $cartCount = Cart::where('user_id', auth()->user()->id)->count());
        if ($request->ajax()){
            return response()->json('Product Added to Cart', 200);
        }else{
            return redirect(route('front.cart.index'));
        }
    }

    public function index()
    {
        $user = auth()->user();
        $selectedBranch = [];
        if (!is_null($user->branch_detail) || !empty($user->branch_detail)){
            $selectedBranch = json_decode($user->branch_detail);
        }


        $this->breadcrumbTitle = __('Cart');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Cart')];
        $productLanguage = function ($productLanguage) {
            $productLanguage->whereHas('languages');
        };
        $cart = Cart::whereHas('product', $productLanguage)->with('product.categories.languages')->where('user_id', auth()->user()->id)->get();
        session()->put('cart', count($cart));
        $subTotal = 0;
        $subTotal_with_vat = 0;
        $subTotal_without_vat = 0;
        $cartData = [];
        $vat = config('settings.value_added_tax');
        $mif = config('settings.mobile_installation_fee');
        $with_fitting = '';
        if (count($cart) > 0) {
            $attributes = [];
            $subAttributes = [];
            $with_fitting = [];
            foreach ($cart as $key => $value) {
                $temp = new \stdClass();
                if ($value->product->vat == 0) {
                    $subTotal_with_vat += $value->product_price * $value->quantity;
                }
                $subTotal += $value->product_price * $value->quantity;
                $extras = json_decode($value->extras);
                if ($extras !== Null) {
                    $temp->attributes = $extras;
                }
                $temp->productQuantity = $value->product->quantity;
                $temp->cart_id = $value->id;
                $temp->product_id = $value->product_id;
                $temp->product_price = $value->product_price;
                $temp->quantity = $value->quantity;
                $temp->total_price = $value->total_price;
                if (empty($value->image)) {
                    $temp->image = $value->product->image;
                } else {
                    $temp->image = $value->image;
                }
                $temp->product_vat = $value->product->vat;
                $temp->year = $value->product->year;
                $temp->with_fitting = $value->with_fitting;
//                $temp->itemTotal = $value->product_price * $value->quantity;
                $temp->translation = $this->translateRelation($value->product, 'languages');
                $temp->categoriesTranslation = [];
                foreach ($value->product->categories as $key1 => $category) {
                    $temp->categoriesTranslation[] = $this->translateRelation($category, 'languages');
                }
                $cartData[] = $temp;
                array_push($with_fitting,$value->with_fitting);
                // dd($cartData);
            }

            $fitting =  array_first($with_fitting);

//            return $cartData;

            return view('front.cart.cart', ['products' => $cartData, 'subTotal' => $subTotal, 'vat' => $vat,'mif'=> $mif, 'total_with_vat' => $subTotal_with_vat, 'with_fitting'=>$fitting, 'selectedBranch'=>$selectedBranch]);
        }

        return view('front.cart.cart', ['products' => $cartData, 'subTotal' => $subTotal, 'total_with_vat' => $subTotal_with_vat, 'mif'=> $mif, 'selectedBranch'=>$selectedBranch]);


    }

    public function updateCart(Request $request)
    {
        $cart_id = array_keys($request->quantity);
        $quantity = array_values($request->quantity);
        $cart = Cart::whereHas('product')->with('product')->where('user_id', auth()->user()->id)->whereIn('id', $cart_id)->get();
        foreach ($cart as $key => $value) {
            $productQuantity = $value->product['quantity'];
            if ($quantity[$key] > $value->quantity) {
                $productQuantity = $quantity[$key] - $value->quantity;
                $productQuantity = $value->product['quantity'] - $productQuantity;
                if ($productQuantity < 0) {
                    return redirect()->back()->with('err', __('Quantity Is Greater Than Stock '));
                }

            }
            if ($quantity[$key] <= $value->quantity) {
                $productQuantity = $value->quantity - $quantity[$key];
                $productQuantity = $value->product['quantity'] + $productQuantity;
            }
            Product::where('id', $value->product->id)->update(['quantity' => $productQuantity]);
            Cart::where('id', $value->id)->update(['quantity' => $quantity[$key], 'total_price' => $value->product_price * $quantity[$key], 'with_fitting' => $request->with_fitting]);
        }
        return redirect()->back();
    }

    public function deleteCart($id)
    {
        $cart = Cart::whereHas('product')->with('product')->where('id', $id)->firstOrFail();
        $productQuantity = $cart->product->quantity + $cart->quantity;
        $cart->product()->update(['quantity' => $productQuantity]);
        $cart->delete();
        return response('succcess');
    }

    public function validCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->where('is_used', '!=', 'used')->first();
        //Check expiry or return false
        if ($coupon !== null) {
            $copounExpirytime = $coupon->end_date - Carbon::today()->timestamp;
        } else {
            $coupon = '';
            return 'false';
        }

        if ($coupon != 'null' && $copounExpirytime >= 0) {
            $carts = $this->cart->findByUserId();
            foreach ($carts as $cart){
                $cart->update(['coupon' => $code]);
            }
            return $coupon->percent;
        }
        if ($copounExpirytime < 0) {
            $coupon = 'expired';
            return $coupon;
        } else {
            $coupon = '';
            return $coupon;
        }


    }

    /**
     * Get all the attributes of the product, divide them into attributes and subattributes, and only send back the subattributes which are featured.
     * Only return array of attribute's name and subattribute's name
     * @param $attributes
     * @return array
     */
    public function getAttributes($attributes, $origin, $brand, $promotion)
    {
        $featured = [];
        $tempArray = [];

        foreach ($attributes as $attribute){
            if ($attribute->is_featured == 1){
                array_push($featured,$attribute);
            }
        }
        foreach ($featured as $attribute){
            foreach ($attributes as $subAttribute){
                if ($subAttribute->parent_id == $attribute->id){
                    $attribute['subAttribute'] = $subAttribute;
                }
            }
        }
//        return $featured;
        foreach ($featured as $attribute){
            $temp = new \stdClass();
            $temp->name = $attribute->translation->name;
            $temp->value = $attribute->subAttribute->translation->name;
            array_push($tempArray, $temp);
        }
        if (!is_null($origin)){
            $temp = new \stdClass();
            $temp->name = 'origin';
            $temp->value = $origin->translation->title;
            array_push($tempArray, $temp);
        }
        if (!is_null($brand)){
            $temp = new \stdClass();
            $temp->name = 'brand';
            $temp->value = $brand->translation->title;
            array_push($tempArray, $temp);
        }
        if (!is_null($promotion)){
            $temp = new \stdClass();
            $temp->name = 'promotion';
            $temp->value = $promotion->translation->title;
            array_push($tempArray, $temp);
        }

        return $tempArray;





        /*   $attributesArray = [];
           $attributesId = [];

           foreach ($attributes as $attribute) {
               if ($attribute->parent_id == 0) {
                   array_push($attributesArray, $attribute);
                   array_push($attributesId, $attribute->id);
               }
           }
           $assArray = [];
           foreach ($attributes as $attribute) {
               if ($attribute->parent_id != 0) {
                   $index = array_search($attribute->parent_id,$attributesId);
                   $assArray[$attributesId[$index]] = $attribute->id;
               }
           }

           return $assArray;*/
    }

    public function selectBranch(CheckoutLocationRequest $request){

        if ($request->has('location')){
            $booking =  $this->getBooking($request->all());
        }
        if ($booking == false){
            return back()->with('err', 'selected date is not available, select another date');
        }

        $user = auth()->user();
        $user->update(['branch_detail' =>$booking]);
        return redirect(route('front.cart.index'));

    }

    public function getBooking($request){
        $branch = $this->branch->findBySlug($request['location']);
        $check = $this->branch->checkBranchDays($request['booking_date'], $branch);
        if ($check){
            $temp = new StdClass();
            $temp->name = $branch->translation->title;
            $temp->branch_id = $branch->id;
            $temp->address = $branch->address;
            $temp->latitude = $branch->latitude;
            $temp->longitude = $branch->longitude;
            $temp->date = $request['booking_date'];
            $temp->time = $request['booking_time'];
            $temp = json_encode($temp);

            return $temp;

        }else{
            return false;
        }

    }

    public function removeLocation(){
        $user = auth()->user();
        $user->update(['branch_detail' => null]);
        return redirect(route('front.cart.index'));
    }


//    public function getFeaturedSubAttributes($attributes, $subAttributes)
//    {
//        $attributes[] = $attributes;
//        $subAttributes[] = $subAttributes;
//        $featuredId = [];
//
//        foreach ($attributes as $attribute){
//            if ($attribute)
//        }
//
//    }
}
