@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <!-- pormotions html start -->
    <section class="location-main-sec center-page">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="appoint-tittle">Contact Information</h2>
                        </div>

                    </div>
                    <!-- new code -->
                    <div class="col-md-12 px-0">
                        <div class="appoint-ment-main-fieldss">
                            <form action="{{route('front.make.appointment')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group  m-b-25">
                                            <input type="text" class="form-control required form-con-appointment"
                                                id="text"  placeholder="First Name" value="{{old('first_name')}}" name="first_name" required>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/user-app.png')}}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  m-b-25">
                                            <input type="text" class="form-control required form-con-appointment"
                                                id="text" placeholder="last Name" value="{{old('last_name')}}" name="last_name" required>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/user-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group  m-b-25">
                                            <input type="text" class="form-control required form-con-appointment"
                                                id="text" placeholder="phone number" value="{{old('phone')}}" name="phone" required>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/phone-app.png')}}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  m-b-25">
                                            <input type="email" class="form-control required form-con-appointment"
                                                id="email" placeholder="email" value="{{old('email')}}" name="email" required>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/mail-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- 2nd row -->
                                <div class="row">
                                    <div class="col-md-12 mt-4 pt-1">
                                        <h2 class="appoint-tittle">Appointment Details</h2>
                                    </div>

                                </div>

                                <div class="row">
                                    @if($details == 0)
                                    {{--location--}}
                                    <div class="col-md-4">
                                        <div class="form-group  m-b-25">
                                            <select class="form-control select-field" name="location" id="locations" required>
                                                <option selected="true" disabled="disabled" value="" >Select Branch</option>
                                                    @forelse($branches as $branch)
                                                        <option value="{{$branch->slug}}">{{$branch->translation->title}}</option>
                                                    @empty
                                                        <option disabled>No Branches Available</option>
                                                    @endforelse
                                            </select>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/loc-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                    {{--Date--}}
                                    <div class="col-md-4">
                                        <div class="form-group  m-b-25">
                                            <select class="form-control select-field" name="date" id="dates" required>
                                                <option selected="true" disabled="disabled" value="" >Select Date</option>
                                                @forelse($dates as $date)
                                                    <option value="{{$date}}">{{$date}}</option>
                                                @empty
                                                    <option disabled>No Dates Available</option>
                                                @endforelse
                                            </select>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/caln-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                    {{--time--}}
                                    <div class="col-md-4">
                                        <div class="form-group  m-b-25">
                                            <select class="form-control select-field" name="time" id="times" required>
                                                <option selected="true" disabled="disabled" value="" >Select Time</option>
                                                @forelse($times as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @empty
                                                    <option disabled>No Time Available</option>
                                                @endforelse
                                            </select>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/clock-app.png')}}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    {{--Categories--}}
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group  m-b-25">
                                            <select class="form-control select-field" name="vehicle" id="vehicles" required>
                                                <option selected="true" disabled="disabled" value="" >Select Vehicle</option>
                                                @forelse($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->translation->name}}</option>
                                                @empty
                                                    <option disabled>No Vehicle Available</option>
                                                @endforelse
                                            </select>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/car-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                    {{--Models--}}
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group  m-b-25">

                                            <select class="form-control select-field" name="model" id="models" required>
                                                <option selected="true" disabled="disabled" value="" >Select Model</option>

                                            </select>

                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/make-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                    {{--Year--}}
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group  m-b-25">
                                            <select class="form-control select-field" name="year" id="years" required>
                                                <option selected="true" disabled="disabled" value="">Select Year</option>
                                            </select>

                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/year-app.png')}}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group  m-b-25">
                                            <input type="text" class="form-control required form-con-appointment"
                                                id="text" placeholder="Current Kilometers" name="meter" required>
                                            <div class="icons-append">
                                                <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/kilo-app.png')}}">

                                            </div>
                                        </div>
                                    </div>

                                    <!-- check boxes start -->
                                    <div class="appoint-check-box">
                                        <div class="inner-appoint-check">
                                            <div class="form-check">
                                                <label class="container">
                                                    <input type="checkbox" name="oil">
                                                    <span class="checkmark"></span>Oil Service
                                                </label>

                                            </div>
                                        </div>
                                        <div class="inner-appoint-check">
                                            <div class="form-check">
                                                <label class="container">
                                                    <input type="checkbox" name="battery">
                                                    <span class="checkmark"></span>Battery
                                                </label>

                                            </div>
                                        </div>
                                        <div class="inner-appoint-check ">
                                            <div class="form-check">
                                                <label class="container">
                                                    <input type="checkbox" name="brakes">
                                                    <span class="checkmark"></span>Brakes
                                                </label>

                                            </div>
                                        </div>
                                        <div class="inner-appoint-check ">
                                            <div class="form-check">
                                                <label class="container">
                                                    <input type="checkbox" name="ac">
                                                    <span class="checkmark"></span>AC Service
                                                </label>

                                            </div>
                                        </div>
                                        <div class="inner-appoint-check ">
                                            <div class="form-check">
                                                <label class="container">
                                                    <input type="checkbox" name="other">
                                                    <span class="checkmark"></span>Other
                                                </label>

                                            </div>
                                        </div>

                                    </div>

                                    <!-- text area  -->
                                    <div class="col-md-12">
                                        <div class="form-group text-area-appoint">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name="notes"
                                                placeholder="Notes"></textarea>
                                        </div>
                                        @if($details != 0)
                                        <input type="text" hidden class="form-control required form-con-appointment"
                                               placeholder="location" value="{{$details['location']}}" name="location">
                                        <input type="text" hidden class="form-control required form-con-appointment"
                                               placeholder="location" value="{{$details['date']}}" name="date">
                                        <input type="text" hidden class="form-control required form-con-appointment"
                                               placeholder="location" value="{{$details['time']}}" name="time">
                                        @endif
                                        <div class="appoint-btn-m d-flex justify-content-end">
                                            <button class="btn btn--primary btn--animate" >{{__('Book Appointment')}}</button>
                                        </div>

                                    </div>
                                    <!-- end text area  -->
                                    <!-- end check boxes -->


                                    <!-- end col 33 -->

                                </div>
                                <!-- end 2nd row -->
                            </form>
                        </div>
                    </div>
                    <!-- end new code  -->
                </div>
            </section>
    <!-- end pormotion html -->
@endsection
@push('script-page-level')

<script>
    $("#vehicles").on("change", function () {
        var vehicle_id =$(this).val();
        $('#models')
            .find('option')
            .remove()
            .end()
            .append('<option>Select Model</option>')
        // .val()
        ;
        $.ajax({
            url : window.Laravel.apiUrl+"models/"+vehicle_id,
            success:function (data) {
                // console.log(window.Laravel.apiUrl+"models/"+vehicle_id)
                if (data.length > 0){
                    $.each(data, function (key,value){
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#models").append(option);
                        // $('#models').
                        // console.log('key', key, 'value', value.id)
                    })
                }else{
                    var option = new Option("No model is available", 0);
                    $(option).html("No model is available");
                    $("#models").append(option);
                }

            }
        });
    });


    $("#models").on("change", function () {
        $('#years')
            .find('option')
            .remove()
            .end()
            .append('<option>Select Year</option>')
        // .val()
        ;
        var model_id =$(this).val();
        $.ajax({
            url : window.Laravel.apiUrl+"years/"+model_id,
            success:function (data) {
                if (data.length > 0){
                    $.each(data, function (key,value){
                        var option = new Option(value, value);
                        $(option).html(value);
                        $("#years").append(option);
                    })
                }else{
                    var option = new Option("No year is available", 0);
                    $(option).html("No year is available");
                    $("#years").append(option);
                }

            }
        });
    });
</script>
@endpush
