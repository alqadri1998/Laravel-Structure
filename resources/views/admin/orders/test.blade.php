<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #{{$order->invoice->id}}</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
            border: 1px solid #222222;
        }
        thead{
            background: #222222;
            color: white;
        }
        tbody td{
            padding: 15px;
        }
        th{
            color: white;
            height: 30px;
        }
        tfoot{
            background: #555555;
            color: #ffffff;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
            padding: 15px;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #222222;
            color: #FFF;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="98%">
        <tr width="100%">
            <td align="left" style="width: 33.3%;">
                <h3>{{$order->admin->full_name}}</h3>
                <p>{{$order->address}}</p>
                <p>Date: {{\Carbon\Carbon::createFromTimestamp($order->invoice->created_at)->format('d-m-Y')}}
                    {{--Status: Not Paid--}}</p>
            </td>
            <td align="center"  style="width: 33.3%;">
                <img style="height: 90px;" src="{{url(config('settings.logo'))}}" alt="Logo"  class="logo"/>
            </td>
            <td align="right" style="width: 40%;"  style="width: 33.3%;">

                <h3>{{config('settings.company_name')}}</h3>
                <pre>
                    {{config('settings.site_url')}}
                    {{config('settings.email')}}
                   {{config('settings.address')}}
                </pre>
            </td>
        </tr>

    </table>
</div>


<br/>

<div class="invoice" style="margin-bottom: 68px;">
    <h3>Invoice Number #{{$order->invoice->id}}</h3>
    <h3 class="padding-top:5px;">Total Amount #{{$order->total_amount}}</h3>
    <h3 class="padding-top:5px;">Vat Tax Amount #{{$order->vat_amount}}</h3>

    <table width="100%">
        <thead>
        <tr>
            <th scope="col">System#</th>
            <th scope="col">Brand</th>
            <th scope="col">Quantity</th>
            <th scope="col">Gross Price</th>
            <th scope="col">Total Amount</th>

        </tr>
        </thead>
        <tbody>

        @foreach($order->orderDetails as $key=>$orderDetail)
            <tr>
                <td>{{$orderDetail->id}}</td>
                <td>{{$orderDetail->brand->translation->title}}</td>
                <td>{{$orderDetail->quantity}}</td>
                <td>{{$orderDetail->gross_price}}</td>
                <td>{{$orderDetail->total_amount}}</td>

            </tr>
        @endforeach



        </tbody>

        {{--<tfoot>--}}
        {{--<tr>--}}
            {{--<td colspan="1"></td>--}}
            {{--<td align="left">Total</td>--}}
            {{--<td align="left" class="gray">{{$order->total_amount}}</td>--}}
        {{--</tr>--}}
        {{--</tfoot>--}}
    </table>
</div>

<div class="information" style="position: fixed; bottom: 0; width: 100%;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ config('settings.site.url') }} - All rights reserved.
            </td>
            <td align="right" style="width: 50%;">
                Company Slogan
            </td>
        </tr>

    </table>
</div>
</body>
</html>