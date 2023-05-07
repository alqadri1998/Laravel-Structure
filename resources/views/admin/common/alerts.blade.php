@if (count($errors->messages()) > 0)
<div class="alert alert-danger alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <ul>
        @foreach($errors->messages() as $key => $message)
        <li>{!! __($message[0]) !!}</li>
        @endforeach 
    </ul>
</div>
@endif 
@if(session()->has('status'))
<div class="alert alert-success alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! __(session()->get('status')) !!}
</div>
@endif 
@if (session('err'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! __(session('err')) !!}
</div>
@endif

@if($maintenance_mode == 0)
    <div class="alert alert-info">
        <strong>Maintenance Mode is activated!</strong> Your site is down at this moment.
        <a href="{!! url('en/maintenance_mode') !!}" class="btn btn-accent" target="_blank">
            {!! __('Visit Site') !!}
        </a>
    </div>
@endif