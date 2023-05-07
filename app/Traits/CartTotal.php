<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Product;
use App\Models\ProductPropertiesParing;
use App\Models\ProductProperty;
use App\Models\UserAddress;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Validation\Rule;


/**
 * Created by PhpStorm.
 * User: Malik
 * Date: 8/21/2017
 * Time: 6:31 PM
 */
trait CartTotal
{
    /**
     * @param $itemId
     * @return float
     * @throws Exception
     */

    public function refreshCart()
    {
        foreach (Cart::content() as $item) {
        }
    }

    public function getCartParameters()
    {
        $data = [];
        foreach (Cart::content() as $item) {
            $temp = new \stdClass();
            $temp->id = $item->id;
            $temp->quantity = $item->qty;
            $temp->rowId = $item->rowId;
            $data[] = $temp;
        }

        $products = $this->getParameters($data);
        return $products;
    }

    public function getParameters($data)
    {
        $products = [];
        foreach ($data as $item) {
            $product = Product::with(['languages'])->find($item->id);
            $productLanguage = $this->translateRelation($product);
            $products[] = [
                'title' => $productLanguage->title,
                'quantitySelected' => $item->quantity,
                'totalQuantity' => $product->quantity,
                'price' => $product->price,
                'totalPrice' => ($product->price * $item->quantity),
                'image' => $product->default_image,
                'rowId' => $item->rowId,
                'productId' => $product->id,
                'storeId' => $product->user_id,
                'currencyId' => 2,
            ];
        }

        return $products;
    }

    public function cartTotal()
    {
        $totalPrice = 0;
        foreach (Cart::content() as $item) {
            $totalPrice = $totalPrice + $this->itemTotal($item->price, $item->qty);
        }

        return $totalPrice;
    }

    public function itemTotal($itemPrice, $quantity)
    {
        return $itemPrice * $quantity;
    }

    public function addUserAddresses($request, $userId, $from_api = 0)
    {

        $response = array();
        $rules = [
            'first_name' => 'required|max:45',
            'last_name' => 'required|max:45',
            'phone' => 'numeric',
            'address_1' => 'required',
            'billing_zip'=>'numeric'
        ];
        if ($from_api) {
            $rules['address_type'] = [
                'required',
                Rule::in(['billing', 'shipping']),
            ];
        }
        $this->validate($request, $rules);
        $dataBilling = $request->only(
            'first_name',
            'last_name',
            'phone',
            'billing_zip'
        );
        if ($request->get('billing_zip')) {
            $dataBilling['zip'] = $request->get('billing_zip');
        }
        if ($request->get('address_2')) {
            $dataBilling['address_2'] = $request->get('address_2');
        }
        if ($request->get('address_3')) {
            $dataBilling['address_3'] = $request->get('address_3');
        }
        $dataBilling['address_type'] = 'billing';
        if ($from_api) {
            $dataBilling['address_type'] = $request->get('address_type');
        }
        $dataBilling['user_id'] = $userId;


        if ($request->get('shippingFlag') == 1 && !$from_api) {
            $rules = [
                'shipping_first_name' => 'required|max:45',
                'shipping_last_name' => 'required|max:45',
                'shipping_address_1' => 'required',
                'shipping_phone' => 'required|numeric',
                'shipping_zip'=>'numeric'
            ];
            $this->validate($request, $rules);
            $shipinfo['first_name'] = $request->shipping_first_name;
            $shipinfo['last_name'] = $request->shipping_last_name;
            $shipinfo['phone'] = $request->shipping_phone;
            if ($request->shipping_zip) {
                $shipinfo['zip'] = $request->shipping_zip;
            }
            $shipinfo['address_1'] = $request->shipping_address_1;
            if ($request->shipping_address_2) {
                $shipinfo['address_2'] = $request->shipping_address_2;
            }
            if ($request->shipping_address_2) {
                $shipinfo['address_3'] = $request->shipping_address_3;
            }
            $shipinfo['address_type'] = 'shipping';
            $shipinfo['user_id'] = $userId;
            $shippingAddress = Address::updateOrCreate(['user_id' => $userId, 'address_type' => 'shipping'], $shipinfo);
            $response['shippingAddress'] = $shippingAddress;
        }

        $billingAddress = Address::updateOrCreate(['user_id' => $userId, 'address_type' => $dataBilling['address_type']], $dataBilling);

        $response['billingAddress'] = $billingAddress;

        if (!isset($response['shippingAddress'])) {
            $response['shippingAddress'] = $response['billingAddress'];
        }
        return $response;
    }
}