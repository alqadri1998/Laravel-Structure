<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 1/7/2019
 * Time: 6:51 PM
 */

namespace App\Traits;

use App\Jobs\SendEmail;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use function Couchbase\defaultDecoder;
use Illuminate\Support\Arr;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use function MongoDB\BSON\toJSON;

trait GetAttributes
{
    use Translations, EMails;

    public function vatTax($price)
    {

        $tax = config('settings.value_added_tax');
        $valueAddedTax = 0;
        if ($tax != 0) {
            $valueAddedTax = ($tax / 100) * $price;
        }
        return $valueAddedTax;
    }

    public function discount($discount, $price)
    {
        $discountAmount = 0;
        if ($discount != 0) {
            $discountAmount = ($discount / 100) * $price;
        }
        return $discountAmount;
    }

    public function getRegions()
    {
        $regions = [];
        $regions = ['' => 'Select Region', 'EU' => 'EU', 'E' => 'E'];
        return $regions;
    }

    public function getTrashedProducts()
    {
        $products = function ($products) {
            $products->withTrashed();
            $products->with('languages');
            $products->whereHas('languages');
        };
        return $products;
    }

    public function getTrashedBrands()
    {
        $brands = function ($brands) {
            $brands->withTrashed();
            $brands->with('languages');
            $brands->whereHas('languages');
        };
        return $brands;
    }

    public function getTrashedDeliveries()
    {
        $deliveryType = function ($delivery) {
            $delivery->withTrashed();
            $delivery->with('languages');
            $delivery->whereHas('languages');
        };
        return $deliveryType;
    }

    public function getOrderDetails($orderId)
    {

        $products = function ($products) {
            $products->withTrashed();
            $products->with('languages');
            $products->whereHas('languages');
        };
        $brands = function ($brands) {
            $brands->withTrashed();
            $brands->with('languages');
            $brands->whereHas('languages');
        };
        $deliveryType = function ($delivery) {
            $delivery->withTrashed();
            $delivery->with('languages');
            $delivery->whereHas('languages');
        };

        $order = Order::with(['orderDetails', 'orderDetails.product' => $products, 'orderDetails.brand' => $brands, 'orderDetails.deliveryType' => $deliveryType])
            ->whereHas('orderDetails')
            ->where('id', '=', $orderId)
            ->first();

        if ($order != null) {
            $this->setTranslations($order->orderDetails, '', ['product' => 'languages', 'brand' => 'languages', 'deliveryType' => 'languages']);
        }
        return $order;
    }

    public function getOrderDetailsDetail($orderId, $orderDetailId)
    {

        $delivery = $this->getTrashedDeliveries();
        $orderDetails = OrderDetail::with(['order', 'deliveryType', 'product' => $this->getTrashedProducts(), 'brand' => $this->getTrashedBrands()])
            ->where('id', '=', $orderDetailId)
            ->firstOrFail();

        $orderDetails->deliveryType->translation = $this->translateRelation($orderDetails->deliveryType);
        $orderDetails->product->translation = $this->translateRelation($orderDetails->product);

        $orderDetails->brand->translation = $this->translateRelation($orderDetails->brand);

        return $orderDetails;
    }

    public function invoice($orderId)
    {
        $deliveryType = function ($delivery) {
            $delivery->withTrashed();
            $delivery->with('languages');
            $delivery->whereHas('languages');
        };
        $products = function ($products) use ($deliveryType) {
            $products->with(['deliveryType' => $deliveryType]);
            $products->withTrashed();
            $products->with('languages');
            $products->whereHas('languages');
        };
        $brands = function ($brands) {
            $brands->withTrashed();
            $brands->with('languages');
            $brands->whereHas('languages');
        };

        $order = Order::with(['orderDetails', 'admin', 'orderDetails.product' => $products, 'orderDetails.brand' => $brands])
            ->whereHas('orderDetails')
            ->where('id', '=', $orderId)
            ->first();
//      $order->deliveryType->translation=$this->translateRelation($order->deliveryType);
        $this->setTranslations($order->orderDetails, '', ['product' => 'languages', 'brand' => 'languages']);
        foreach ($order->orderDetails as $key => $orderDetail) {
            $order->orderDetails[$key]->product->deliveryType->translation = $this->translateRelation($orderDetail->product->deliveryType);
        }

        return $order;
    }

    public function getAdmins()
    {
        $admin = Admin::all()->pluck('full_name', 'id')->toArray();
        $admin = arr::prepend($admin, 'Select  Customer', '');
        return $admin;
    }

    public function changeOrderStatusData($orderId, $status)
    {
        $current_time = Carbon::now()->timestamp;
        $routeData = null;

        if ($status == 'complete') {
            $data['order_status'] = $status;
            $data['complete_date'] = $current_time;
            $order = Order::updateOrCreate(['id' => $orderId], $data);
            $routeData = 'deliver';
            $admin = Admin::where('id', '=', $order->admin_id)->first();
            $amount = $admin->credit_limit + $order->total_amount;
            Admin::where('id', '=', $order->admin_id)->update(['credit_limit' => $amount]);
            $data['receiver_email'] = $admin->email;
            $data['receiver_name'] = $admin->full_name;
            $data['message_text'] = 'Order Complete';
            $data['full_name'] = $admin->full_name;
            $data['sender_name'] = config('settings.company_name');
            $data['subject'] = 'Order Complete';
            $data['email'] = config('settings.email');
            $data['orderDetailsHeading'] = 'Order Details ';
            $data['check'] = 0;
            $data['order_id'] = $orderId;
            $data['status'] = ' Order Number ' . $orderId . ' Complete';
            $data['order'] = null;
//            SendEmail::dispatch($data, 'emails.contact_us', $data['subject'], $data['receiver_email'], $data['email']);
            $this->sendMail($data, 'emails.contact_us', $data['subject'], $data['receiver_email'], $data['email']);

        } else if ($status == 'delivered') {
            $data['delivery_date'] = $current_time;
            $data['order_status'] = $status;
            $order = Order::updateOrCreate(['id' => $orderId], $data);
            $routeData = 'order';
            $admin = Admin::where('id', '=', $order->admin_id)->first();
            $data['receiver_email'] = $admin->email;
            $data['receiver_name'] = $admin->full_name;
            $data['message_text'] = 'Order Delivered';
            $data['full_name'] = $admin->full_name;
            $data['sender_name'] = config('settings.company_name');
            $data['subject'] = 'Order Delivered';
            $data['email'] = config('settings.email');
            $data['orderDetailsHeading'] = 'Order Details ';
            $data['check'] = 0;
            $data['order_id'] = $orderId;
            $data['status'] = ' Order Number ' . $orderId . ' Delivered';
            $data['order'] = null;
//            SendEmail::dispatch($data, 'emails.contact_us', $data['subject'], $data['receiver_email'], $data['email']);
//
            $this->sendMail($data, 'emails.contact_us', $data['subject'], $data['receiver_email'], $data['email']);

        } else if ($status == 'order') {
            $data['delivery_date'] = $current_time;
            $data['order_status'] = $status;
            $order = Order::updateOrCreate(['id' => $orderId], $data);

        }

        return $routeData;
    }

    public function getCategories()
    {
        $categories = Category::whereHas('languages')->with('languages')->where('parent_id', '=', 0)->get();
        $categoryData = [];
        $this->setTranslations($categories);
        if (count($categories) > 0) {
            foreach ($categories as $key => $category) {
                $categoryData[$category->id] = $category->translation->name;
            }
        }
        $categoryData = arr::prepend($categoryData, 'Select Category ', 0);
        return $categoryData;
    }

    public function getSubCategories($id)
    {
        $categories = Category::whereHas('languages')->with('languages')->where('parent_id', $id)->get();
        $categoryData = [];
        $this->setTranslations($categories);
        foreach ($categories as $key => $category) {
            $categoryData[$category->id] = $category->translation->name;
        }
//        $categoryData = arr::prepend($categoryData, 'Select sub category ', 0);
        return $categoryData;
    }

    public function getSubSubCategories($id)
    {
        $categories = Category::whereHas('languages')->with('languages')->where('parent_id', $id)->get();
        $categoryData = [];
        $this->setTranslations($categories);
        foreach ($categories as $key => $category) {
            $categoryData[$category->id] = $category->translation->name;
        }
//        $categoryData = arr::prepend($categoryData, 'Select sub category ', 0);
        return $categoryData;
    }

    public function getBrands(){
        $brands = Brand::whereHas('languages')->with('languages')->get();
        $this->setTranslations($brands);
        $brandData = [];
        if (count($brands) > 0) {
            foreach ($brands as $key => $brand) {
                $brandData[$brand->id] = $brand->translation->title;
            }
        }
        return $brandData;
    }

    public function getAttributes()
    {
        $categoryData[] = '';
        $attributes = Attribute::whereHas('languages')->with('languages')->where(['parent_id' => 0])->get();

        $this->setTranslations($attributes);
        if (count($attributes) > 0) {

            foreach ($attributes as $key => $attribute) {
                $categoryData[$attribute->id] = $attribute->translation->name;
            }
        }
        $categoryData = arr::prepend($categoryData, 'Select Attribute ', 0);

        return $categoryData;
    }

    public function getCategoryAttributes($id)
    {
        $checkAttributes = function ($attribute) {
            $attribute->whereHas('languages')->with(['languages', 'subAttributes' => function ($query) {
                $query->whereHas('languages')->with('languages');
            }]);
        };
        $attributesData = [];
        $category = Category::whereHas('attributes')->with(['attributes' => $checkAttributes])->where('id', $id)->first();
        if ($category == null) {
            return $attributesData;
        }
        $attributes = $category->attributes;
        $this->setTranslations($attributes, 'languages', ['subAttributes' => 'languages']);
        if ($attributes !== null) {

            foreach ($attributes as $key => $attribute) {
                $temp = new \stdClass();
                $temp->id = $attribute->id;
                $temp->title = $attribute->translation->name;
                $temp->subAttributes = [];

                foreach ($attribute->subAttributes as $subAttributes => $subAttribute) {
                    $temp->subAttributes[$subAttribute->translation->attribute_id] = $subAttribute->translation->name;

                }


                $attributesData[] = $temp;
            }
        }

        return $attributesData;
    }

    public function getsubAttriutes($array)
    {
        $attributes = Attribute::whereHas('languages')->with(['languages', 'subAttributes' => function ($query) {
            $query->whereHas('languages')->with('languages');
        }])->whereIn('id', $array)->get();
        $this->setTranslations($attributes, 'languages', ['subAttributes' => 'languages']);
        return $attributes;

    }


    public function getVehicleModels($vehicle_id)
    {
        $models = Category::where('parent_id', $vehicle_id)->whereHas('languages')->with('languages')->get();
        $this->setTranslations($models);
        return $models;
    }

    public function getModelYears($model_id)
    {
        $models = Category::where('id', $model_id)->whereHas('languages')->with(['languages', 'products' => function ($product) {
            $product->whereHas('languages')->with('languages');
        }])->get();

        $this->setTranslations($models, 'languages', ['products' => 'languages']);
        $model = $models->first();

        $productYear = [];
        foreach ($model->products as $product) {
            array_push($productYear, $product->year);
        }

        return array_values(array_unique($productYear));

    }


}