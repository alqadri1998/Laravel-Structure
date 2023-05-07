<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{!! config('settings.company_name') !!}</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400" rel="stylesheet">
    </head>
    <div style="width: 600px !important;margin: 0 auto;">
        <table style="width: 100%; font-family: 'Montserrat', sans-serif; font-weight: 300;" border="0" cellpadding="0" cellspacing="0">
            @yield('mail_header')
            <tr>
                <td style="padding:0 25px 0;">
                    @yield('mail_body')
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
