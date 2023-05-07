@section('mail_header')
<tr>
    <td style="padding: 25px 40px; background: #ebebeb;">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tr>
                <td>
                    <img src="{!! asset('assets/img/logo.png') !!}" alt="BizBay">
                </td>
                <td style="text-align: right; font-size: 14px;">
                    <img src="{!! asset('assets/img/calendar-blue.png') !!}" alt="Date"> &#160;&#160;{!! $mailDate !!}
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding: 40px 25px 0; background: #353433;color: #7d7d7d;">
        <!--<img src="Img/news-banner.jpg" style="display: block;" alt="">-->
        <!--<div style="width: 100%; padding:28px 50px;background: #ebebeb; box-sizing: border-box;">-->
            <!--<span style="font-size: 22px;margin-bottom: 10px;">Lorem Ipsum</span>-->
            <!--<p style="font-size: 12px;line-height: 2;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim</p>-->
        <!--</div>-->
        <div style="height: 50px; background: #ebebeb; margin-top: 40px;"></div>
    </td>
</tr>
@endsection 
