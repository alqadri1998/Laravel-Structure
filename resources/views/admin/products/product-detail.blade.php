@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                {{--<div class="m-portlet__head">--}}
                    {{--<div class="m-portlet__head-tools">--}}
                        {{--<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">                                                            <li class="nav-item m-tabs__item">--}}
                                {{--<a class="nav-link m-tabs__link " data-toggle="tab" href="#tab_ar" role="tab" id="test0" >--}}
                                    {{--<i class="flaticon-share m--hide"></i>--}}
                                    {{--????--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item m-tabs__item">--}}
                                {{--<a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_en" role="tab" id="test1">--}}
                                    {{--<i class="flaticon-share m--hide"></i>--}}
                                    {{--English--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {!! Form::model( '',['url' =>  $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
                <div class="tab-content">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Title
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->translation->title}}
                                </label>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Tire Brand
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->brand->translation->title}}
                                </label>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Item Code
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->item_code}}
                                </label>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Car Model
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->carModel->translation->title}}
                                </label>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Quantity
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->quantity}}
                                </label>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    DG Tax
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->dg}}
                                </label>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Price
                                    <span class="text-danger"></span>
                                </label>
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {{$product->price}}
                                </label>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Add Cart
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    {!! Form::number('quantity', old('quantity'), ['class' => 'form-control', 'placeholder' => 'Quantity', 'required'=>'required']) !!}
                                </div>
                            </div>
                           
                    </div>

                </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <div class="row">
                                <input type="hidden" value="create" name="action_check">
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="col-4"></div>
                                <div class="col-7">
                                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                        Add Cart
                                    </button>
                                    <a href="{!! route('admin.products.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                    </div>
            </div>
    </div>

@endsection
