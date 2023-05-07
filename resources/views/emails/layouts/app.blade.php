<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{!! config('settings.company_name') !!}</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400" rel="stylesheet">
    </head>
    <body>
        <table id="main" width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F9F9F9" style="font-family: 'Open Sans', sans-serif;">
            <tbody>
                <tr>
                    <td valign="top">
                        <table class="innermain" cellpadding="0" width="620" cellspacing="0" border="0" bgcolor="#F9F9F9" align="center" style="margin:0 auto;table-layout:fixed">
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                    <table class="m_logo" width="100%" cellpadding="0" cellspacing="0" border="0">
            			        		<tbody>
            			        			
            			        			<tr><td height="50px"></td></tr>
            			        			
            			        		</tbody>
            			        	</table>
            			        	<table class="m_logo" width="100%" cellpadding="0" cellspacing="0" border="0" background="{!!imageUrl(url(config('settings.email_logo')),620,198, 100,1)  !!}">
            			        		<tbody>
            			        			
            			        			<tr><td height="170px" align="center">
												<!-- <img src="images/logo.png" alt=""> -->
											</td></tr>
            			        			<tr>
            			        				<td height="45px" align="center">
            			        					<table width="90%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-width:1px;border-color:#efefef;border-style:solid;border-bottom-width:0px;"><tbody><tr><td height="45px"></td></tr></tbody></table>
            			        				</td>
            			        			</tr>
            			        			
            			        		</tbody>
            			        	</table>
                                        @yield('content')
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff6900">
                                            <tbody>
                                                <tr>
                                                    <td height="50px" align="center">
                                                        <table width="90%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-width:1px;border-color:#efefef;border-style:solid;border-top-width:0px;"><tbody><tr><td height="50px"></td></tr></tbody></table>
                                                    </td>
                                                </tr>
                                                <tr><td height="30"></td></tr>
                                               <tr>
                                                   <td valign="middle" align="center" style="padding-left:30px;padding-right:30px">
{{--                                                       <a href="{!! Config::get('settings.facebook_url') !!}" target="_blank" style="width:30px;height:26px;margin:0 5px;display:inline-block;"><img src="{{asset('assets/email/fbpng-min.png')}}" alt="facebook" width="24"/></a>--}}
{{--                                                       <a href="{!! Config::get('settings.twitter_url') !!}" target="_blank" style="width:30px;height:26px;margin:0 5px;display:inline-block;"><img src="{{asset('assets/email/twipng-min.png')}}" alt="twitter" width="24"/></a>--}}
{{--                                                       <a href="{!! Config::get('settings.instagram_url') !!}" target="_blank" style="width:30px;height:26px;margin:0 5px;display:inline-block;"><img src="{{asset('assets/email/instpng-min.png')}}" alt="Instagram" width="24"/></a>--}}
{{--                                                       <a href="https://wa.me/{!! Config::get('settings.contact_number')  !!}/?text=contactus" data-text="share"  target="_blank" style="width:30px;height:26px;margin:0 5px;display:inline-block;"><img src="{{asset('assets/email/whtspng-min.png')}}" alt="whatsapp" width="24"/></a>--}}

{{--                                                        <a href="{!! Config::get('settings.youtube_url') !!}" style="width:30px;height:26px;margin:0 5px;display:inline-block;"><img src="{{asset('assets/front/email/youtube-logo.png')}}" alt="Youtube" width="24"/></a>--}}
{{--                                                       <a href="{!! Config::get('settings.linkedin_url') !!}" style="width:30px;height:26px;margin:0 5px;display:inline-block;"><img src="{{asset('assets/front/email/linkedin-logo.png')}}" alt="Linkdin" width="24"/></a>--}}
                                                   </td>
                                               </tr>
                                               <tr><td valign="middle" align="center" style="font-size: 14px;line-height: 26px;color: #fff;padding-left:30px;padding-right:30px">{!! Config::get('settings.telephone_number') !!}</td></tr>
                                               <tr><td valign="middle" align="center" style="font-size: 14px;line-height: 26px;color: #fff;padding-left:30px;padding-right:30px">{!! Config::get('settings.contact_email') !!}</td></tr>
                                                <tr><td height="15"></td></tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <tr><td height="10">&nbsp;</td></tr>
                                <tr><td valign="top" align="center"><span style="color:#333;font-size:12px">© <a href="{!! url('/') !!}" style="color:#ff6900;font-weight: 500; font-size:12px;text-decoration:none;">{!! config('settings.company_name') !!}</a> {!! \Carbon\Carbon::now()->format('Y') !!}</span></td></tr>
                                <tr><td height="50">&nbsp;</td></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
