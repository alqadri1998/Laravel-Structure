
{!! Form::model($admin, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Full Name') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('full_name', old('full_name'), ['class' => 'form-control', 'id' => 'full_name', 'placeholder' => __('Full Name'), 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('User Name') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('user_name', old('user_name'), ['class' => 'form-control', 'id' => 'user_name', 'placeholder' => __('User Name'), 'required' => 'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Total Credit Limit') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::number('total_credit_limit', old('total_credit_limit'), ['class' => 'form-control', 'id' => 'total_credit_limit', 'placeholder' => __('Total Credit Limit')]) !!}
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Email') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'placeholder' => __('Email'), 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Address') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('address', old('address', $admin->address), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'searchmap'.$languageId]) !!}
            {!! Form::hidden('longitude', old('longitude', $admin->longitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'longitude'.$languageId]) !!}
            {!! Form::hidden('latitude', old('latitude', $admin->latitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'latitude'.$languageId]) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Change Position') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <div id="map{!! $languageId !!}" style="height:500px; width:auto;margin-top: 48px"></div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Role') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control', 'id' => 'role_id', 'required' => 'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Password') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            @if($admin->id > 0)
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => __('Password')]) !!}
            @else
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => __('Password'), 'required' => 'required']) !!}
            @endif
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Confirm Password') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            @if($admin->id > 0)
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => __('Password Confirmation')]) !!}
            @else
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => __('Password Confirmation'), 'required' => 'required']) !!}
            @endif
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Image') !!}
            <span class="text-danger">*</span>

        </label>

        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['languageId'=>$languageId])
        </div>
    </div>

    @if(!empty($admin['profile_pic']))
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Old Image
            </label>
            <div class="col-3" style="padding-top: 140px">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{!! imageUrl(url($admin['profile_pic']), 120, 120, 100, 1) !!}" class="img-fluid">
                </div>
            </div>
            <label for="example-text-input" class="col-2 col-form-label">
                Selected Image
            </label>
            <div class="col-3" style="padding-top: 10px;padding-left: 38px;">
            <div class="d-flex justify-content-center align-items-center">

                <img src="{!! asset('images/image.png') !!}" style="height: 120px;width: 120px;" id="image" class="selected-image img-fluid" >
                </div>
            </div>
        </div>
    @else
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Selected Image
            </label>
            <div class="col-7" style="padding-top: 10px">
                <img   src="{!! asset('images/image.png') !!}" style="height: 120px;width: 120px;" id="image"  class="selected-image">
            </div>
        </div>
    @endif

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Active') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::select('is_active', ['0' => 'In-Active', '1' => 'Active'], old('is_active'), ['class' => 'form-control', 'id' => 'is_active', 'required' => 'required']) !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            @if ($admin->id > 0)
                <input type="hidden" value="PUT" name="_method">
                <input type="hidden" value="{{$admin->total_credit_limit}}" name="old_credit_limit">
                <input type="hidden" value="{{$admin->credit_limit}}" name="credit_limit">

            @endif
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                    Save changes
                </button>
                <a href="{!! route('admin.administrators.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

