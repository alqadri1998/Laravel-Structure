<!-- Book an appointment Section Start-->
{{--<section class="book-an-appointment-section spacing mb-20">
    <div class="container">
        <div class="row appointment-row">
            <div class="col-sm-6 cols">
                <h2 class="secondary-headline text-white">
                    Book An Appointment <br> For Your Car!
                </h2>
                <div class="form-sec">
                    <form action="{{route('front.appointment')}}" method="get">
                        <div class="form-group date">
                            <label for="Date">Date</label>
                            <select class="form-control" id="Date" name="date" required>
                                <option selected="true" value="" disabled="disabled">Select Date</option>
                                @foreach($dates as $date)
                                    <option value="{{$date}}">{{$date}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group time">
                            <label for="Time">Time</label>
                            <select class="form-control" id="Time" name="time" required>
                                <option selected="true" value="" disabled="disabled">Select Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time}}">{{$time}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group location">
                            <label for="Location">Location</label>
                            <select class="form-control" id="Location" name="location" required>
                                <option selected="true" value="" disabled="disabled">Select Location</option>
                                @forelse($branches as $branch)
                                    <option value="{{$branch->slug}}">{{$branch->translation->title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="submit-btn">
                            <button type="submit" class="btn btn--primary btn--animate">{{__('Book an appointment')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 cols">
                <div class="img-block">
                    <img class="img-fluid right-car-img" src="{{asset('assets/front-tyre-shop/images/right-car.jpg')}}"
                         alt="right-car-img">
                </div>
            </div>
        </div>
    </div>
</section>--}}
<!-- Book an appointment Section End-->

<section class="book-an-appointment-section spacing">
    <div class="container">
        <div class="row appointment-row">
            <div class="col-sm-6 cols">
                <h2 class="secondary-headline text-white text-capitalize">
                    Book service at your<br class="d-none d-md-inline-block"> nearest location!
                </h2>
                <div class="form-sec">
                    <form action="{{route('front.make.appointment.index.page')}}" method="post" id="book-appointment-form">
                        @csrf
                        <div class="row">
                            <div class="form-group m-b-25 col-sm-6">
                                <label for="first_name" class="required">Name</label>
                                <input type="text" class="form-control rm-arrow" maxlength="32" id="first_name" placeholder="E.g John" name="name" required="">
                            </div>
                            <div class="form-group m-b-25 col-sm-6">
                                <label for="first_name" class="required">Phone No</label>
                                <input type="tel" class="form-control rm-arrow" maxlength="15" placeholder="E.g +9712345678901" name="phone" required="">
                            </div>
                        </div>
                        <div class="form-group date">
                            <label for="Date">Date</label>
                            <select class="form-control" id="Date" name="date" required>
                                <option selected="true" value="" disabled="disabled">Select Date</option>
                                @foreach($dates as $date)
                                    <option value="{{$date}}">{{$date}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group time">
                            <label for="Time">Time</label>
                            <select class="form-control" id="Time" name="time" required>
                                <option selected="true" value="" disabled="disabled">Select Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time}}">{{$time}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group location">
                            <label for="Location">Location</label>
                            <select class="form-control" id="Location" name="location" required>
                                <option selected="true" value="" disabled="disabled">Select Location</option>
                                @forelse($branches as $branch)
                                    <option value="{{$branch->slug}}">{{$branch->translation->title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group location">
                            <label for="Location">Book Your Services </label>
                            <select class="form-control" name="services" required>
                                <option selected="true" value="" disabled="disabled">Select Services</option>
                                <option value="Wheel Alignment">Wheel Alignment</option>
                                <option value="Tire Balancing">Tire Balancing</option>
                                <option value="Tire Rotation">Tire Rotation</option>
                                <option value="Flat tire Repair">Flat tire Repair</option>
                                <option value="Engine & Suspensions">Engine & Suspensions</option>
                                <option value="Transmission & belt">Transmission & belt</option>
                                <option value="Radiator">Radiator</option>
                                <option value="Brake pads">Brake pads</option>
                                <option value="Oil">Oil</option>
                                <option value="Battery">Battery</option>
                                <option value="Ac">Ac</option>
                                <option value="other">other</option>
                            </select>
                        </div>
                        <div class="submit-btn">
                            <button type="submit" class="btn btn--primary btn--animate">Book an appointment</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 cols">
                <div class="img-block">
                    <img class="img-fluid right-car-img" src="{{asset('assets/front-tyre-shop/images/right-car.jpg')}}"
                         alt="right-car-img">
                </div>
            </div>
        </div>
    </div>
</section>

@push('script-page-level')
<script>
    jQuery.validator.addMethod("tel", function (value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /((\(\d{3,4}\)|\d{3,4}-)\d{4,9}(-\d{1,5}|\d{0}))|(\d{4,12})/.test(value);
    }, "Not valid phone number.");

    $('#book-appointment-form').validate()
</script>
@endpush