@extends('emails.layouts.app')

@section('content')
<table border='0' cellpadding='0' cellspacing='0' bgcolor="#ffffff" style="width: 100%;">
    <tr>
        <td style="width: 100%; padding:0 50px 28px;background: #ffffff; box-sizing: border-box;">
            <span style="font-size: 22px;margin-bottom: 15px; display: block; color: #7d7d7d;">Hi {!! $receiver_name !!},</span>
            <span style="color: #7d7d7d; font-size: 20px; display: block;">Email verification required</span>
            <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">To activate your <a href="{!! url('/') !!}" style="color:#ff6900!important;text-decoration:none;font-weight:bold;">{!! config('settings.company_name') !!}</a> account please use <b style="color:#ff6900!important;font-weight:bold;">{!! $verification_code !!}</b> as your email verification code.</p>
            <span style="color: #7d7d7d; font-size: 22px; display: block;padding:15px 0 5px;">Team {!! config('settings.company_name') !!}</span>
        </td>
    </tr>
</table>
@endsection 
