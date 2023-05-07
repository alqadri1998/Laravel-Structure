@extends('emails.layouts.app')

@section('content')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" height="360">
        <tbody>
        <tr>
            <td align="center">
                <table width="90%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff"
                       style="font-family: 'Open Sans', sans-serif;color:#666666;font-size:14px;line-height:20px;border-width:1px;border-color:#efefef;border-style:solid;border-bottom-width: 0px;border-top-width: 0px;">
                    <tbody>
                    <tr>
                        <td height="50"></td>
                    </tr>
                    <tr>
                        <td class="content" valign="top" align="left"
                            style="font-size:24px;font-weight: 500;color:#333;line-height:32px; padding-left:30px;padding-right:30px">
                            Hi !
                        </td>
                    </tr>
                    <tr>
                        <td class="content" valign="top" align="left"
                            style="font-size:24px;font-weight: 500;color:#333;line-height:32px; padding-left:30px;padding-right:30px">{!! $sender_name !!}
                            Left a Message
                        </td>
                    </tr>
                    <tr>
                        <td class="content" valign="top" align="left"
                            style="font-size:24px;font-weight: 500;color:#333;line-height:32px; padding-left:30px;padding-right:30px">
                            Subject {!! $subject !!}</td>
                    </tr>
                    <tr>
                        <td height="30"></td>
                    </tr>
                    <tr>
                        <td style="padding-left:30px;padding-right:30px">
                            <table width="100%" cellpadding="12" cellspacing="0" border="0"
                                   style="border-collapse: collapse;">
                                <tbody>
                                <tr>
                                    <td valign="center" align="left"
                                        style="width: 95px;padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>what we can help you with ?</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $subject !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="width: 95px;padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Full Name</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $sender_name !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Email Address</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $email !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Phone</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $phone !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Vehicle</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $vehicle !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Model</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $model !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Year</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $year !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Total Kilometers</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $meter !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Selected Location</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $location !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Selected Date</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $date !!}</td>
                                </tr>
                                <tr>
                                    <td valign="center" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Selected Time</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $time !!}</td>
                                </tr>
                                @if(isset($oil))
                                    <tr>
                                        <td valign="center" align="left"
                                            style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                            <label>Oil Service</label></td>
                                        <td colspan="2" valign="center" align="left"
                                            style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">
                                            Yes
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($battery))
                                    <tr>
                                        <td valign="center" align="left"
                                            style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                            <label>Battery</label></td>
                                        <td colspan="2" valign="center" align="left"
                                            style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">
                                            Yes
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($brakes))
                                    <tr>
                                        <td valign="center" align="left"
                                            style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                            <label>Brake</label></td>
                                        <td colspan="2" valign="center" align="left"
                                            style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">
                                            Yes
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($ac))
                                    <tr>
                                        <td valign="center" align="left"
                                            style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                            <label>AC Service</label></td>
                                        <td colspan="2" valign="center" align="left"
                                            style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">
                                            Yes
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($other))
                                    <tr>
                                        <td valign="center" align="left"
                                            style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                            <label>Other Services</label></td>
                                        <td colspan="2" valign="center" align="left"
                                            style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">
                                            Yes
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td valign="top" align="left"
                                        style="padding-left:30px;padding-right:30px;border-width:1px;border-color:#efefef;border-style:solid">
                                        <label>Message</label></td>
                                    <td colspan="2" valign="center" align="left"
                                        style="padding-left:15px;padding-right:15px;border-width:1px;border-color:#efefef;border-style:solid">{!! $notes !!}</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td valign="top" align="left" style="padding-left:30px;padding-right:30px"><h2
                                    style="margin-bottom: 0px;">{!! config('app.name') !!}</h2></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>


@endsection
