<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[route('front.dashboard.index')] = ['title' => __('Profile')];

    }

    public function index($status)
    {
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Orders')];
        $this->breadcrumbTitle = __('Orders');
        $pending = function ($pending) {
            $pending->where('item_status', 'pending');
        };
        $shipping = function ($pending) {
            $pending->where('item_status', 'shipping');
        };
        $canceled = function ($canceled) {
            $canceled->where('item_status', 'canceled');
        };
        $complete = function ($complete) {
            $complete->where('item_status', 'complete');
        };


        $orders = Order::whereHas('orderDetails')->withcount(['orderDetails', 'orderDetails as pending' => $pending, 'orderDetails as shipping' => $shipping, 'orderDetails as canceled' => $canceled, 'orderDetails as completed' => $complete])->with('orderDetails')->where(['user_id' => auth()->user()->id, 'order_status' => $status])->orderBy('updated_at', 'DESC')->paginate(5);
//        return $orders;
        return view('front.dashboard.order', ['orders' => $orders]);
    }

    public function OrderDetail($id)
    {
        $this->breadcrumbTitle = __('Order Detail');

        $checkProduct = function ($checkProduct) {
            $checkProduct->whereHas('product', function ($product) {
                $product->whereHas('languages');
            });
        };

        $pending = function ($pending) {
            $pending->where('item_status', 'pending');


        };
        $shipping = function ($pending) {
            $pending->where('item_status', 'shipping');
        };
        $canceled = function ($canceled) {
            $canceled->where('item_status', 'canceled');
        };
        $complete = function ($complete) {
            $complete->where('item_status', 'complete');
        };

        $order = Order::whereHas('orderDetails', $checkProduct)->with('orderDetails.product.languages')->withCount(['orderDetails', 'orderDetails as pending' => $pending, 'orderDetails as shipping' => $shipping, 'orderDetails as canceled' => $canceled, 'orderDetails as completed' => $complete])->where(['id' => $id, 'user_id' => auth()->user()->id])->firstOrFail();
//        dd($order);

        foreach ($order->orderDetails as $key => $value) {
            $value->product->translation = $this->translateRelation($value->product, 'languages');
            $extras = json_decode($value['extras']);
            $list = '';
            if ($extras !== NULL) {
                /* We are no longer saving attribute ID in the extras, instead we are saving attribute as name and its subAttribute as value*/

//                $tempsubAttributes = implode(',', $extras->subAttributes);
//                $tempAttributes = implode(',', $extras->attributes);
//                $attributes = Attribute::whereIn('id', $extras->attributes)->with('languages')->orderByRaw(DB::raw("FIELD(id, $tempAttributes)"))->get();
//                $attributes = $this->setTranslations($attributes);
//                $subAttributes = Attribute::whereIn('id', $extras->subAttributes)->with('languages')->orderByRaw(DB::raw("FIELD(id, $tempsubAttributes)"))->get();
//                $subAttributes = $this->setTranslations($subAttributes);
//                foreach ($attributes as $attributeKey => $attributeValue) {
//                    $list .= '<li class="nav-item pr-2 d-flex"><span class="attribute-heading font-weight-bold">' . $attributeValue->translation->name . '</span> : ' . $subAttributes[$attributeKey]->translation->name . '</li>';
//                }
              foreach ($extras as $extra) {
                    $list .= '<li class="nav-item pr-2 d-flex"><span class="attribute-heading font-weight-bold">' . $extra->name . '</span> : ' . $extra->value . '</li>';
                }
            }
            $value->list = $list;
        }
        if ($order->order_status == 'confirmed') {
            $this->breadcrumbs[route('front.dashboard.order.index', ['status' => 'confirmed'])] = ['title' => __('Confirmed Orders')];
        }
        if ($order->order_status == 'In Progress') {
            $this->breadcrumbs[route('front.dashboard.order.index', ['status' => 'In progress'])] = ['title' => __('In Progress Orders')];
        }
        if ($order->order_status == 'completed') {
            $this->breadcrumbs[route('front.dashboard.order.index', ['status' => 'completed'])] = ['title' => __('Completed Orders')];
        }
        if ($order->order_status == 'canceled') {
            $this->breadcrumbs[route('front.dashboard.order.index', ['status' => 'canceled'])] = ['title' => __('Canceled Orders')];
        }
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Order Detail')];

        $order->billing_address =  json_decode($order->billing_address);
        $order->vehicle =  json_decode($order->vehicle);
        $order->branch =  json_decode($order->branch);
        return view('front.dashboard.order-detail', ['order' => $order]);
    }

    public function orderCanceled($orderDetailId)
    {
        $orderDetail = OrderDetail::find($orderDetailId);
        $rate = getConversionRate();
        $amount = round($orderDetail->total_price / $rate, 2);
        $paypalResponse = json_decode($orderDetail->order->paypal_response);
        if ($paypalResponse) {
            $saleId = $paypalResponse->transactions[0]->related_resources[0]->sale->id;
            $this->initPayPal();
            $response = $this->refundPayment($amount, $saleId);
            if ($response == 'error') {
                return redirect()->back()->with('err', __('order cancelation failed'));
            }
        }
        $orderDetail->update(['item_status' => 'canceled']);
        $items = OrderDetail::where('order_id', $orderDetail->order_id)->get();
        $itemsCount = count($items);
        $canceledItems = $items->where('item_status', '=', 'canceled')->count();
        if ($canceledItems == $itemsCount) {
            Order::where('id', $orderDetail->order_id)->update(['order_status' => 'canceled']);
        }
        return redirect()->back()->with('status', __('Order canceled successfully'));
    }
}
