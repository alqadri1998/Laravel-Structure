

@push('stylesheet-end')
<!-- Tree css -->
<link href="{!! asset('assets/admin/js/tree/css/jqx.base.css') !!}" type="text/css" rel="stylesheet">
@endpush 

@push('script-end')
<script src="{!! asset('assets/admin/js/tree/js/jqxcore.js') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/admin/js/tree/js/jqxtree.js') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/admin/js/tree/js/jqxcheckbox.js') !!}" type="text/javascript"></script>
<script>
$(document).ready(function() {
    $('#jqxTree').jqxTree({height: 'auto', hasThreeStates: true, checkboxes: true});
    $('#jqxTree').css('visibility', 'visible');
    $('#jqcheckbox-region').mouseleave(function () {
        get_jqbox_values();
    });
    $(document).delegate('#admin-role-form', 'submit', function(e){
        $(this).append('<input type="hidden" id="role_sub_modules" name="role_sub_modules"/>');
        $('#role_sub_modules').val(JSON.stringify(getRoleSubModules()));
    });
});
</script>
@endpush 

{!! Form::model($role, ['url' => $action, 'method' => 'post', 'role' => 'form','class' => 'm-form m-form--fit m-form--label-align-right',  'id' => 'admin-role-form']) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                {!! __('Title') !!}
                <span class="text-danger">*</span>
            </label>
            <div class="col-7">
                {!! Form::text('title', old('title'), ['class' => 'form-control', 'id' => 'title', 'placeholder' => __('Role Name')]) !!}
            </div>

        </div>

        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                {!! __('Description') !!}
            </label>
            <div class="col-7">
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'placeholder' => __('Description')]) !!}
            </div>

        </div>

        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                {!! __('Active') !!}
            </label>
            <div class="col-7">
                {!! Form::select('is_active', ['0' => 'In-Active', '1' => 'Active'], old('is_active'), ['class' => 'form-control', 'id' => 'is_active']) !!}
            </div>

        </div>
        <div  id="jqcheckbox-region">
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                {!! __('Permissions') !!}
            </label>
            <div class="col-7">
                <div id="jqxTree" class="custom-jqxtree">
                    <ul>
                        @forelse($subModules as $subModule)
                            <li item-value="{!! $subModule['id'] !!}" data-id="{!! $subModule['id'] !!}" class="top_mod">{!! $subModule['module']['title'].' -> '.$subModule['title'] !!}
                                <ul>
                                    <li data-right="mp_create" item-checked="{!! ((isset($role->subModules[$subModule['id']])) ? (($role->subModules[$subModule['id']]['pivot']['mp_create']==1) ? 'true':'false'):'false') !!}" >Create</li>
                                    <li data-right="mp_read" item-checked="{!! ((isset($role->subModules[$subModule['id']])) ? (($role->subModules[$subModule['id']]['pivot']['mp_read']==1) ? 'true':'false'):'false') !!}">Read</li>
                                    <li data-right="mp_update" item-checked="{!! ((isset($role->subModules[$subModule['id']])) ? (($role->subModules[$subModule['id']]['pivot']['mp_update']==1) ? 'true':'false'):'false') !!}">Update</li>
                                    <li data-right="mp_delete" item-checked="{!! ((isset($role->subModules[$subModule['id']])) ? (($role->subModules[$subModule['id']]['pivot']['mp_delete']==1) ? 'true':'false'):'false') !!}">Delete</li>
                                </ul>
                            </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
        </div>

    </div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            @if ($role->id > 0)
                <input type="hidden" value="PUT" name="_method">
            @endif
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                    Save changes
                </button>
                &nbsp;&nbsp;
                <a href="{!! route('admin.roles.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}