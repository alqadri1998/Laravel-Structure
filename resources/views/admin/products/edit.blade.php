@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
<style>
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
        display: none !important;
    }
</style>
@endpush

@push('script-page-level')
<script>
    let productId = '{!! $productId !!}'
</script>
<script src="{{ asset('assets/admin/js/app/controllers/form-prodsuct.js')}}" type="text/javascript"></script>
@include('admin.common.upload-gallery-js-links')

@endpush

@section('content')

<div class="row" ng-controller="productFormController" ng-cloak>
    <div class="col-12">
        <div class="alert alert-danger alert-dismissable text-left" ng-if="errors.length > 0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" ng-click="removeErrors()"></button>
            <ul>
                <li ng-repeat="error in errors">{! error !}</li>

            </ul>
        </div>
    </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-8 m-portlet m-portlet--mobile pt-5">
            <form name="productForm" ng-submit="submitProduct(productForm.$valid)">
                {{--Title English--}}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row ">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Title English
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <input class="form-control" placeholder="Title" name="titleEn" ng-model="formData.titleEn" ng-required="required">
                        </div>
                    </div>
                    {{--Title Arabic--}}
            {{--        <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Title Arabic
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <input class="form-control" placeholder="Title" name="titleAr" ng-model="formData.titleAr" required>
                        </div>
                    </div>--}}
                    <div class="form-group m-form__group row mb-0" ng-show="formData.imagesDependent == false">
                        <label for="example-text-input" class="col-3 col-form-label">
                            <span class="text-danger"></span>

                        </label>
                        <div class="col-7">
                            <button type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom product-upload-image" ng-click="imageUploadButton()">
                                <i class="fa fa-spinner fa-spin" style=" display: none"></i>
                                Upload Image
                            </button>
                            {{--@php dd($product->image1); @endphp--}}
                            <input type="file" id="upload_image_input" class="hide product_upload_image_input" ng-model="test" accept="image/*" onchange="angular.element(this).scope().uploadImage(this.files)">

                            <p class="mx-0 text-danger smaller-font-size mt-2">Recommended size 104 x 130</p>
                        </div>
                    </div>
                    <div class="form-group m-form__group row image-product" ng-show="formData.imagesDependent == false">                        
                        <div class="col-3"></div>                        
                        <div class="col-3 border height-width-set" ng-repeat="image in formData.images">
                            <div class="button-groups d-flex justify-content-around" ng-if="!image.isDefault">
                                <button type="button" class="float-left right " ng-click='makeDefault($index)'><i class="fa fa-check"></i></button>
                                <button type="button" class="float-right left" ng-click='deleteImage($index)'><i class="fa fa-times"></i></button>
                            </div>
                            <div class="button-groups d-flex justify-content-around" ng-if="image.isDefault">
                                <button  type="button" class="float-left right icon-active"><i class="fa fa-check"></i></button>
                            </div>
                            <img src="{! image.path !}" class="img-fluid ">
                        </div>                        

                    </div>

                    {{--Category--}}
                    <div class="form-group m-form__group row" ng-if="categories.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Vehicle
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            {{--{!! Form::select('category_id', $category, old('category_id',$product->category_id), ['class' => 'form-control category_id', 'id' => 'category_id' ,'required'=>'required']) !!}--}}
                            <select id="category_id" name="category"  class="form-control category_id" required  ng-model="formData.category"
                                    ng-change="selectedCategory()" >
                                <option disabled selected value="">Select Vehicle</option>
                                <option ng-repeat="category in categories" value="{! category.id !}">{! category.translation.name !}</option>
                            </select>
                            <br>
                        </div>
                    </div>
                    {{--Model--}}
                    <div class="form-group m-form__group row subcategories" ng-if="subcategories.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Model
                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7">
                            <select  id="subCategory" name="subCategory"
                                     class="form-control subCategory" ng-model="formData.subcategory"
                                     ng-change="selectedSubCategory()">
                                <option value="">Select Vehicle Model</option>
                                <option ng-repeat="category in subcategories" value="{! category.id !}">{! category.translation.name !}</option>
                            </select>
                            <br>
                        </div>
                    </div>
                    {{--Brands--}}
                    <div class="form-group m-form__group row" ng-if="brands.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Brands
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <select id="brand_id" name="brand"  class="form-control category_id" required  ng-model="formData.brand"
{{--                                    ng-change="selectedBrand()"--}}
                            >
                                <option disabled selected value="">Select Brand</option>
                                <option ng-repeat="brand in brands" value="{! brand.id !}">{! brand.translation.title !}</option>
                            </select>
                            <br>
                        </div>
                    </div>
                    {{--Origin--}}
                    <div class="form-group m-form__group row" ng-if="origins.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Origin of Tyre
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <select id="origin_id" name="origin"  class="form-control origin_id" required  ng-model="formData.origin"
{{--                                    ng-change="selectedOrigin()"--}}
                            >
                                <option disabled selected value="">Select Origin Country</option>
                                <option ng-repeat="origin in origins" value="{! origin.id !}">{! origin.translation.title !}</option>
                            </select>
                            <br>
                        </div>
                    </div>
                    {{--Promotions--}}
                    <div class="form-group m-form__group row" ng-if="promotions.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Promotion on Tyre
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <select id="promotion_id" name="promotion"  class="form-control promotion_id"  ng-model="formData.promotion">
                                <option disabled selected value="">Select Promotion</option>
                                <option ng-repeat="promotion in promotions" value="{! promotion.id !}">{! promotion.translation.title !}</option>
                            </select>
                            <br>
                        </div>
                    </div>

                    {{--Subcategory of Subcategory--}}
                    <div class="form-group m-form__group row versions" ng-if="subsubcategories.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label subcategoryName">
                            Select Sub-Model
                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7">
                            <select  id="version" name="version"
                                     class="form-control version" ng-model="formData.subsubcategory">
                                <option value="">Select Value</option>
                                <option ng-repeat="category in subsubcategories" value="{! category.id !}">{! category.translation.name !}</option>
                            </select>
                            <br>
                        </div>
                    </div>

                    {{--Attributes--}}
                    <div id="selectAttribute" class="form-group m-form__group row mainAttribute " ng-if="attributes.length > 0">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Attribute
                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7">
                            <select   multiple="multiple"
                                      name="attribute[]" class="form-control attribute" ng-model="formData.attributes"
                                      ng-change="selectedAttributes()">
                                <option ng-repeat="attribute in attributes" value="{! attribute.id !}">{! attribute.translation.name !}</option>
                            </select>
                        </div>
                    </div>

                    {{--SubAttributes--}}
                    <div  class=" subAttribute" ng-if="properties.length > 0">
                        <div class="form-group m-form__group row" ng-repeat="attribute in properties"  ng-init="aIndex = $index">
                            <label for="example-text-input" class="col-3 col-form-label">
                                {! attribute.title !}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <select name="properties[{! $index !}].selectSubAttributes[]"    class="form-control" ng-model="properties[$index].selectSubAttributes" ng-change="selectedSubAttributes($index)">
                                    <option value="">Select</option>
                                    <option ng-repeat="subattribute in attribute.subAttributes" value="{! subattribute.id !}">{! subattribute.translation.name !}</option>
                                </select>
                                <p ng-show="attribute.id == 82">Images Depends On {! attribute.title !}? <input type="checkbox"  name="test" ng-click="attributesDependentImages($index)" ng-checked="properties[$index].imagesDependent == true"></p>

                                <div ng-if="attribute.imagesDependent">
                                    <div ng-repeat="sub_attribute in attribute.sub_attributes" ng-init="sAindex = $index">
                                        <p>Upload Images of {! sub_attribute.title !}</p>
                                        <button type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom product-upload-image" ng-click="imageUploadButton($parent.$index, $index)">
                                            <i class="fa fa-spinner fa-spin" style=" display: none"></i>
                                            Upload Image
                                        </button>
                                        <input type="file" id="upload_image_input-{! $parent.$index !}-{! $index !}" class="hide product_upload_image_input"  accept="image/*" data-attributeIndex="{! $parent.$index !}" data-sunattributeIndex="{! $index !}" onchange="angular.element(this).scope().uploadImage(this.files, this)">
                                        <p class="mx-0 text-danger smaller-font-size mt-2">Recommended size 482 x 526</p>
                                        <div class="form-group m-form__group row image-product" ng-if="sub_attribute.images.length > 0">
                                            <div class="col-3 border height-width-set" ng-repeat="image in sub_attribute.images">
                                                <div class="button-groups d-flex justify-content-around" ng-if="!image.isDefault">
                                                    <button class="float-left right " type="button" ng-click='makeDefault($index, aIndex, sAindex)'><i class="fa fa-check"></i></button>
                                                    <button  class="float-right left" type="button" ng-click='deleteImage($index, aIndex, sAindex)'><i class="fa fa-times"></i></button>
                                                </div>
                                                <div class="button-groups d-flex justify-content-around" ng-if="image.isDefault">
                                                    <button type="button" class="float-left right icon-active"><i class="fa fa-check"></i></button>
                                                </div>
                                                <img src="{! image.path !}" class="img-fluid ">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    {{--Price--}}
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label mb-4">
                            Price
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <input type="number" class="form-control" placeholder="price"  step="0.01" min="0" name="price" required  ng-model="formData.price">

                        </div>
                    </div>

                    {{--Year--}}
                    <div class="form-group m-form__group row" ng-if="years.length > 0">
                        <label for="year" class="col-3 col-form-label">
                            Year
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <select id="year" name="year"  class="form-control" required  ng-model="formData.year">
                                <option disabled selected value="">Select Year</option>
                                <option ng-repeat="oneYear in years" value="{! oneYear !}">{! oneYear !}</option>
                            </select>
                            <br>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            SKU
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <input type="text" class="form-control" placeholder="STG - 12000028724 - 2020" name="sku" required  ng-model="formData.sku">

                        </div>
                    </div>

                    {{--Include Vat--}}
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Include Vat
                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7 mt-2 pt-1">
                            <input class="" type="checkbox"   name="vat"
                                   data-ng-checked="(formData.vat == 1) ? true: false"  data-ng-click="includingVat()" >
                        </div>
                    </div>

                    {{--Quantity--}}
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Quantity
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-7">
                            <input type="number" class="form-control" placeholder="quantity" name="quantity" required  ng-model="formData.quantity">
                        </div>
                    </div>
                    {{--Create Offer--}}
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Create Offer
                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7 mt-2 pt-1">

                            <input class="offer-create" type="checkbox"   name="offer" data-ng-checked="(formData.offer == 1) ? true: false"  data-ng-click="isOffer()">
                        </div>
                    </div>

                    <div class="discount-offer"  ng-if="formData.offer == 1">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-3 col-form-label">
                                Discount Percentage
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <input type="number" name="discount_percent" class="form-control" required step="1" min="0" max="99" placeholder="discount percentage" ng-model="formData.discount_percent" >

                            </div>
                        </div>
                    </div>
                    {{--Description English--}}
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Description English

                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7">
                            <textarea name="descriptionEn" id="" cols="30" rows="10" class="form-control" placeholder="Description English" ng-model="formData.descriptionEn"></textarea>
                        </div>
                    </div>
                    {{--Discription Arabic--}}
             {{--       <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-3 col-form-label">
                            Description Arabic

                            <span class="text-danger"></span>
                        </label>
                        <div class="col-7">
                            <textarea name="descriptionAr" id="" cols="30" rows="10" class="form-control" placeholder="Description Arabic" ng-model="formData.descriptionAr"></textarea>
                        </div>
                    </div>--}}


                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <div class="row mt-4 mb-4">
                            <input type="hidden" value="PUT" name="_method">
                            <div class="col-4"></div>
                            <div class="col-7">
                                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3" ng-disabled="working == true">
                                    Save Changes <i class="fa fa-spinner fa-spin" ng-show="working == true"></i>
                                </button>
                                <a href="{!! route('admin.products.index') !!}"
                                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

