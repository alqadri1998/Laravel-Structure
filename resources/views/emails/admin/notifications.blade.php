@extends('emails.layouts.template')

@include('emails.layouts.simple_header', ['mailTitle' => 'Notification Mail'])

@section('mail_body')
    <table border='0' cellpadding='0' cellspacing='0' style="width: 100%;">
        <tr>
            <td style="width: 100%; padding:0 50px 28px;background: #ebebeb; box-sizing: border-box;">
                <div style="text-align: center;margin-bottom: 40px;">
                    <a href="{!! url('/') !!}"><img src="{!! asset('assets/img/logo.png') !!}" border="0" alt=""></a>
                </div>
                <span style="font-size: 22px;margin-bottom: 15px; display: block; color: #7d7d7d;">Hi, {!! ucwords($receiver_name) !!}</span>
                <p style="color: #7d7d7d; font-size: 20px; display: block;">Notification</p>
                <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">You are receiving this email because some other admin perform some action in admin panel.</p>
                <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">{!! $description !!}</p>
                <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">Click <a href="{!! $url !!}">here</a> to see the activity.</p>
                <span style="color: #7d7d7d; font-size: 18px; display: block;padding:15px 0 5px;">{!! $sender_name !!}</span>
            </td>
        </tr>
    </table>
    <div style="height:40px; background:#fff; "></div>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
            <td style="width: 100%; padding:28px 50px;background: #353433; box-sizing: border-box; font-size: 14px; color: #7d7d7d; margin-top: 40px; text-align: center;">
                <div style="margin-bottom: 5px;" style="color: #7d7d7d;">454545454545</div>
                <div><a href="mailto:" style="color: #7d7d7d;">mtesting</a></div>
            </td>
        </tr>
    </table>

@endsection
