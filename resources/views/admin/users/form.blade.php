{!! Form::model($user, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'col s12', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('First Name') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => __('e.g John'), 'onkeypress'=>'return specialCharacters(/^[A-Za-z0-9]+$/)', 'maxlength'=> 32, 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Last Name') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => __('e.g Doe'), 'onkeypress'=>'return specialCharacters(/^[A-Za-z0-9]+$/)',  'maxlength'=> 32, 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Email') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email','placeholder' => __('e.g johndoe@mail.com '), 'onkeypress'=>'return specialCharacters(/^[A-Za-z0-9-@+.]+$/)', 'required' => 'required']) !!}
            <span class="help-block" onkeypress="">
                <small class="text-danger font-weight-bold gothic-normel" id="email_error">{{ __($errors->first('email')) }}</small>
            </span>
        </div>
    </div>
{{--    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Address') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'placeholder' => __('Address'), 'id' => 'user_address', 'required' => 'required']) !!}
        </div>
    </div>--}}

{{--    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Phone') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('user_phone', old('user_phone'), ['class' => 'form-control', 'id' => 'user_phone', 'placeholder' => __('e.g +97 123 456 789'), 'required' => 'required']) !!}
        </div>
    </div>--}}

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Password') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            @if($user->id > 0)
                {!! Form::password('password', ['class' => 'form-control','placeholder' => __('******'), 'maxlength'=> 32, 'id' => 'password']) !!}
            @else
                {!! Form::password('password', ['class' => 'form-control','maxlength'=> 32, 'id' => 'password', 'placeholder' => __('******'), 'required' => 'required']) !!}
            @endif
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Confirm Password') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            @if($user->id > 0)
                {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder' => __('******'), 'id' => 'password_confirmation']) !!}
            @else
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => __('******'), 'required' => 'required']) !!}
            @endif
        </div>
    </div>
{{--    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Gender') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c">
                <input type="radio" {!! ($user->gender == 'male')?'checked':'' !!} name="gender" ngModel value="male">
                <span class="log checkmark"></span>Male
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c">
                <input type="radio" {!! ($user->gender == 'female')?'checked':'' !!} name="gender" ngModel value="female">
                <span class="log checkmark"></span>Female
            </label>
        </div>
    </div>--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Image') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-9">
            <label class="choose-image">
                {!! Form::file('user_image', ['accept' => 'image/*']) !!}
                Choose Image
                </label>
 
        <span class="text-danger smaller-font-size my-2 d-block">Recommended size 262 x 262</span>
    
        </div>
        
    </div>
    @if($user->id > 0)
        @if(!empty($user->user_image))
            <div class="col-8 text-center">
                <div class="d-flex justify-content-center align-items-center">
                <img src="{!! imageUrl(asset($user->user_image), 150, 150, 100, 1) !!}" alt="{!! $user->first_name !!}" class="img-fluid">
                </div>
            </div>
        @endif
    @endif
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
                <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value={!! $id !!} name="user_id">
            <div class="col-4"></div>
            <div class="col-7 mb-4 mt-4">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    @if($user->id > 0)
                        Save Changes
                        @else
                        Add user
                        @endif
                </button>
                <a href="{!! route('admin.users.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

