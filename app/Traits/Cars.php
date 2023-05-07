<?php

namespace App\Traits;

use App\Http\Libraries\Uploader;
use App\Models\Car;
use App\Models\CarAttributeProperty;
use App\Models\CarImage;
use App\Models\ProductImage;

trait Cars {
    public function saveCars($request)
    {
        $slug=str_slug($request);
        $data = $request->only('', 'rent_perday', 'security_amount');
        if ($request->hasFile('image')) {
            $uploader = new Uploader('image');
            if ($uploader->isValidFile()) {
                $uploader->upload('pages', $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $data['image'] = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                return redirect()->back()->with('err', $uploader->getMessage())->withInput();
            }
        }
        $car = Car::updateOrCreate(['id' => $request->get('car_id', 0), 'company_id' => $request->get('company_id')], $data);
        $car->languages()->syncWithoutDetaching([
            $request->get('language_id') => [
                'title' => $request->get('title'),
                'detail' => $request->get('detail'),
                'fuel_policy' => $request->get('fuel_policy'),
            ]
        ]);
        if ($request->get('car_id') == 0){
            $car->carImages()->create([
                    'car_id' => $request->get('car_id'),
                    'image' => $data['image'],
                    'is_default' => 1
            ]);
        }
        CarAttributeProperty::where(['car_id' => $car->id])->delete();
        if (count($request->get('attributes')) > 0){
            foreach ($request->get('attributes') as $key=>$attribute){
                if (isset($attribute['properties'])){
                    foreach ($attribute['properties'] as $key2=>$propertyId){
                        if (!empty($propertyId)){
                            $car->properties()->syncWithoutDetaching([
                                $propertyId => ['attribute_id' => $attribute['attribute_id']]
                            ]);
                        }
                    }
                }
            }
        }
        \Cache::forget('latestCars');
    }

    public function saveCarImages($request)
    {
        $productImages = [];
        $data = $request->except('_token');
        $uploader = new Uploader();
        if(count($data['images']) > 0){
            foreach ($data['images'] as $key => $img) {
                if(is_object($img)){
                    $uploader->setFile($img);
                    if ($uploader->isValidFile()) {
                        $uploader->upload('product-images/'.$data['product_id'], $uploader->fileName);
                        if ($uploader->isUploaded()) {
                            $productImages[] = $uploader->getUploadedPath();
                        }
                    }
                }
            }
        }
        foreach ($productImages as $key=>$image){
            ProductImage::create(['product_id' => $data['product_id'], 'image' => $image]);
        }
    }
}