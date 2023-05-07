@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')

@endpush

@section('content')
    <div class="row">

        @if($order!= null)
        <div class="col-lg-12">
            @if($userData['role_id']!= config('settings.supplier_role') && $hasInvoice==0)
            <div class="invoice-btn" style="background: #f2f6f8; margin-bottom: 15px;">
                <a   href="{!! route('admin.invoice.edit-invoice', ['orderId'=>$order->id,'invoice' => 0]) !!}" class="mr-2 " style="background: #256ab7; text-align: right; color: #fff;font-weight: 600;font-size: 13px;text-align: center;border-radius: 50px;height: 27px;width: 150px;display: inline-block;line-height: 27px;"> Make Invoice  </a>
            </div>
            @endif
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                {{--<div class="m-portlet__head">--}}
                {{--<div class="m-portlet__head-tools">--}}
                {{--<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">                                                            <li class="nav-item m-tabs__item">--}}
                {{--<a class="nav-link m-tabs__link " data-toggle="tab" href="#tab_ar" role="tab" id="test0" >--}}
                {{--<i class="flaticon-share m--hide"></i>--}}
                {{--????--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item m-tabs__item">--}}
                {{--<a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_en" role="tab" id="test1">--}}
                {{--<i class="flaticon-share m--hide"></i>--}}
                {{--English--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--{!! Form::model( '',['url' =>  $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}--}}

                <div class="tab-content">
                    <div class="m-portlet__body"  style="background:#e5e5e5ad">
                        <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-12 col-form-label text-center">
                                    <h4>{!! __('Order Number') !!} <span class="text-danger">#</span> {{$order->id}}</h4>

                                </label>
                        </div>
                        <div class="form-group m-form__group row">
                            {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                {{--<h6>{!! __('Driver Code') !!}<span class="text-danger"></span></h6>--}}

                            {{--</label>--}}
                            {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                {{--{{$order->driver_code}}--}}
                            {{--</label>--}}
                            <label for="example-text-input" class="col-3 col-form-label">
                                <h6>{!! __('Order Date') !!}<span class="text-danger"></span></h6>

                            </label>
                            <label for="example-text-input" class="col-3 col-form-label">
                                {{\Carbon\Carbon::createFromTimestamp($order->created_at)->format('d-m-Y')}}
                            </label>

                            <label for="example-text-input" class="col-3 col-form-label">
                                <h6>{!! __('Total Amount') !!}<span class="text-danger"></span></h6>

                            </label>
                            <label for="example-text-input" class="col-3 col-form-label">
                                {{$order->total_amount}}
                            </label>



                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-3 col-form-label">
                                <h6>{!! __('Currency') !!}<span class="text-danger"></span></h6>

                            </label>
                            <label for="example-text-input" class="col-3 col-form-label">
                                {!! __('EUR') !!}
                            </label>

                            <label for="example-text-input" class="col-3 col-form-label">
                                <h6>{!! __('VAT') !!}<span class="text-danger"></span></h6>

                            </label>
                            <label for="example-text-input" class="col-3 col-form-label">
                              {{$order->vat}}
                            </label>
                        </div>

                            <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-3 col-form-label">
                               <h6>{!! __('Order address') !!}<span class="text-danger"></span></h6>

                            </label>
                            <label for="example-text-input" class="col-3 col-form-label">
                                {{$order->address}}
                            </label>
                        </div>
                        <div class="form-group m-form__group row">

                        </div>
                            <div class="order-card-mt">
                    <div class="card-img-mt">
                        <img src="{{imageUrl(url($orderDetail->product->image),161,177,95,3)}}" alt="" class="img-fluid d-block m-auto">

                    </div>

                        {{--<div class="form-group m-form__group row">--}}
                            {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                {{--<h6>{!! __('Delivery Type') !!}<span class="text-danger">*</span></h6>--}}

                            {{--</label>--}}
                            {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                {{--{{$order->deliveryType->translation->title}}--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="form-group m-form__group row">--}}
                            {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                {{--{!! __('VAT Amount ') !!}--}}
                                {{--<span class="text-danger">*</span>--}}
                            {{--</label>--}}
                            {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                {{--{{$order->vat_amount}}--}}
                            {{--</label>--}}
                        {{--</div>--}}

                    </div>

                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Item Code </th>
                        <th scope="col">Title </th>
                        <th scope="col">Brand</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Discount %</th>
                        <th scope="col">D G Tax</th>
                        <th scope="col">Gross Price</th>
                        <th scope="col">Delivery Type</th>
                        <th scope="col">Price EUR</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderDetails as $key=>$orderDetail)
                    <tr>
                        <td>{{$orderDetail->id}}</td>
                        <td>{{$orderDetail->item_code}}</td>
                        <td>{{$orderDetail->product->translation->title}}</td>
                        <td>{{$orderDetail->brand->translation->title}}</td>
                        <td>{{$orderDetail->quantity}}</td>
                        <td>{{$orderDetail->discount}}</td> 
                        <td>{{$orderDetail->dg}}</td>
                        <td>{{$orderDetail->gross_price}}</td>
                        <td>{{$orderDetail->deliveryType->translation->title}}</td>

                        <td>{{$orderDetail->total_amount}}</td>

                        <td><a href="{{route('admin.orders.order-detail-data',['orderId'=>$order->id,'orderDetail'=>$orderDetail->id])}}" class="mr-2 detail-btn" >Detail</a></td>
                        {{--<a  href="{{route('admin.my-claims.edit-claim',['orderDetailId'=>$orderDetail->id,'claimId'=>0])}}" style="background: #c51313;color: #fff;font-weight: 600;font-size: 13px;text-align: center;border-radius: 50px;height: 27px;width: 75px;display: inline-block;line-height: 27px;">Claim</a></td>--}}
                    </tr>
                    @endforeach

                    </tbody>
                </table>

                {{--<div class="m-portlet__foot m-portlet__foot--fit">--}}
                    {{--<div class="m-form__actions">--}}
                        {{--<div class="row">--}}
                            {{--<input type="hidden" value="create" name="action_check">--}}
                            {{--<input type="hidden" name="product_id" value="{{$product->id}}">--}}
                            {{--<div class="col-4"></div>--}}
                            {{--<div class="col-7">--}}
                                {{--<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">--}}
                                    {{--Add Cart--}}
                                {{--</button>--}}
                                {{--<a href="{!! route('admin.orders.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--{!! Form::close() !!}--}}
            </div>
        </div>
            @else
            <div class="col-md-12" style="text-align: center">
                <h1 style="color: #FF0000"> Order Has Been Deleted </h1>
            </div>


            @endif


    </div>



@endsection
