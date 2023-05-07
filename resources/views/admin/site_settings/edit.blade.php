@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    @include('admin.common.upload-gallery-js-links')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary"
                            role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1"
                                   role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Update Site Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        {!! Form::open(['route' => 'admin.site-settings.store', 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

                        @if(!empty($result['key']))
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">
                                        Key
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-7">
                                        {!! Form::text('key', old('key', $result['key']), ['class' => 'form-control', 'id' => 'key', 'placeholder' =>'Key','readonly'=>'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">
                                        Key
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-7">
                                        {!! Form::text('key', old('key', $result['key']), ['class' => 'form-control', 'id' => 'key', 'placeholder' => 'Key']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($result['key']=='logo' || $result['key']=='login_page_image' || $result['key']=='email_logo' || $result['key'] == 'product_slider' )


                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Image
                                    <span class="text-danger"></span>

                                </label>
                                <div class="col-7">
                                    @include('admin.common.upload-gallery-modal',['languageId'=>1])
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    Current Image
                                </label>
                                <div class="col-3 ml-4">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{!! url($result['value']) !!}" id="image"
                                             class="selected-image remove-style img-fluid">
                                    </div>
                                    @if($result['key'] == 'product_slider')
                                        <span class="text-danger smaller-font-size">Recommended size 1920 x 294</span>
                                    @else
                                        <span class="text-danger smaller-font-size">Recommended size 620 x 198</span>
                                    @endif
                                </div>

                            </div>

                        @else
                            @if($result['key']=='show_promotion_slider')
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-3 col-form-label">
                                            Value
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-7">
                                            <select id="type" name="value"  class="form-control" required>
                                                <option disabled selected value="">Select Type</option>
                                                <option @if($result['value'] == '1') selected @endif value="1">Show</option>
                                                <option @if($result['value'] == '0') selected @endif value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-3 col-form-label">
                                            Value
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-7">
                                            {!! Form::text('value', old('value', $result['value']), ['class' => 'form-control', 'id' => 'value', 'placeholder' => 'Value']) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                            Save changes
                                        </button>
                                        &nbsp;
                                        <a href="{!! route('admin.site-settings.index') !!}"
                                           class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
