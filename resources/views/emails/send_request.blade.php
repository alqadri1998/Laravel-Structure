@extends('emails.layouts.app')


@section('content')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" height="360">
        <tbody>
        <tr>
            <td align="center">
                <table width="90%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family: 'Open Sans', sans-serif;color:#666666;font-size:14px;line-height:20px;border-width:1px;border-color:#efefef;border-style:solid;border-bottom-width: 0px;border-top-width: 0px;">
                    <tbody>
                    <tr><td height="50"></td></tr>
                    <tr><td class="content" valign="top" align="left" style="font-size:24px;font-weight: 500;color:#333;line-height:32px; padding-left:30px;padding-right:30px">Hi !</td></tr>
                    <tr><td class="content" valign="top" align="left" style="font-size:24px;font-weight: 500;color:#333;line-height:32px; padding-left:30px;padding-right:30px">{!! $full_name !!} Send a Request</td></tr>
                    <tr><td height="30"></td></tr>
                    <tr>
                        <td style="padding-left:30px;padding-right:30px">
                            <table width="100%" cellpadding="12" cellspacing="0" border="0" style="border-collapse: collapse;">
                                <tbody>
                                <tr>
                                    <td valign="center" align="left" style="width: 95px;padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid"><label>Full Name</label></td>
                                    <td colspan="2" valign="center" align="left" style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $full_name !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left" style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid"><label>Email Address</label></td>
                                    <td colspan="2" valign="center" align="left" style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $email !!}</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr><td height="20"></td></tr>
                    <tr><td valign="top" align="left" style="padding-left:30px;padding-right:30px"><h2 style="margin-bottom: 0px;">Dr. Sawsan</h2></td></tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>


@endsection
