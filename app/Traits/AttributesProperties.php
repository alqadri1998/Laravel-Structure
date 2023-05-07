<?php

namespace App\Traits;

use App\Models\Attribute;
use Tymon\JWTAuth\Facades\JWTAuth;

trait AttributesProperties {
    private function getAttributesProperties($car)
    {
        if(count($car->attributes) > 0){
            $properties = function($properties) use ($car){
                $properties->whereIn('id', $car->properties->pluck('id')->toArray());
            };
            $attributes = Attribute::with(['languages', 'properties'=> $properties, 'properties.languages'])->whereIn('id', $car->attributes->pluck('id')->toArray())->get();
            $this->pluckPivot($attributes);
            if(count($attributes) > 0){
                $attributesSinglePropertyArray = [];
                $attributesMultiplePropertyArray = [];
                foreach ($attributes as $attribute){
                    $temp = new \stdClass();
                    $temp->attribute_id = $attribute->id;
                    $temp->languages = $attribute->languages;
                    $temp->property = $attribute->properties[0];
                    if($attribute->select_many == 0){
                        $this->pluckPivot($attribute->properties);
                        $attributesSinglePropertyArray[] = $temp;
                    }else{
                        $properties = [];
                        if(count($attribute->properties) > 0){
                            $this->pluckPivot($attribute->properties);
                            foreach ($attribute->properties as $property){
                                $temp1 = new \stdClass();
                                $temp1->image = $property->image;
                                $temp1->languages = $property->languages;
                                $properties[] = $temp1;
                            }
                        }
                        $temp->property = $properties;
                        $attributesMultiplePropertyArray[] = $temp;
                    }
                }
                unset($car->attributes, $car->productProperty);
//                dd($attributesMultiplePropertyArray, $attributesSinglePropertyArray);
                $car->product_attributes = $attributesSinglePropertyArray;
                $car->product_features = $attributesMultiplePropertyArray;
            }
        }
    }

}
