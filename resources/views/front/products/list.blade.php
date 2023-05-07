@extends('front.layouts.app')
@section('content')
    <!-- product-listing-->
    @include('front.common.breadcrumb')

    <section class="tyres spacing">
        <div class="container">
            <div class="row tyres-row">
                <div class="col-12 col-sm-5 col-lg-4 tyres-left-col">
                    <form action="{{route('front.product.index')}}" method="get" enctype="multipart/form-data"
                          id="filter-from">
                        <!-- <div class="row filter-option-price-row">
                    <div class="col-6"> -->
                        <div class="filter-option-sm">
                            <button type="button" class="filter-btn"><i class="fas fa-filter pr-3"></i>Filter</button>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-6">         -->
                        <div class="text-right">
                            <div class="sort-filter">
                                <select class="dropdown-toggle custom-select" name="sort" onchange="submitFilterForm()">
                                    <option disabled selected value="">Sort By</option>
                                    <option value="price_low_to_high" {{$sort == 'price_low_to_high' ? 'selected' : ''}}>
                                        Price low to high
                                    </option>
                                    <option value="price_high_low" {{$sort == 'price_high_low' ? 'selected' : ''}}>Price
                                        high to low
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- </div> -->
                        <div class="filter-option">
                            <button type="button" class="close-filter"><i class="far fa-times-circle"></i></button>
                            <div class="title-box">
                                <h3 class="title">
                                    Filter Options
                                </h3>
                            </div>
                            {{--              @csrf--}}
                            <div class="options">
                                {{--Attributes filter--}}
                                @foreach($attributes as $attribute)
                                    @if($attribute->id != 154 && $attribute->id != 153 && $attribute->id != 152 && $attribute->id != 137 && $attribute->id != 135)
                                        <div class="accordion">
                                            <a class="type" data-toggle="collapse"
                                               data-target="#demo-{{$attribute->id}}">
                                                {{$attribute->translation->name}}
                                                <i class="fas fa-caret-down"></i>
                                            </a>
                                            <div id="demo-{{$attribute->id}}"
                                                 class="collapse accordion-data @if(in_array($attribute->id, $filterAttributesId)) show @endif ">
                                                <input type="search" id="filter-search-{{$attribute->id}}"
                                                       class="search-option"
                                                       placeholder="Search an option..."/>
                                                <div class="acc-scroll" id="checkbox-{{$attribute->id}}">
                                                    @forelse($attribute->subAttributes as $subAttribute)
                                                        <label class="checkbox-container">{{$subAttribute->translation->name}}
                                                            ({{$subAttribute->products_count}})
                                                            <input type="checkbox" onclick="actAsRadio(this)"
                                                                   class="attribute-{{$attribute->id}}"
                                                                   @if(in_array($subAttribute->id, $filterSubAttributesId)) checked
                                                                   @endif name="attribute[{{$subAttribute->id}}]">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                                {{--/ attributes--}}

                                {{--Brands--}}
                                <div class="accordion">
                                    <a class="type" data-toggle="collapse" data-target="#demo-brands">
                                        Brands
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                    <div id="demo-brands"
                                         class="collapse accordion-data @if(count($filteredBrandsId)>0) show @endif">
                                        <input type="search" class="search-option" id="filter-search-brand"
                                               placeholder="Search an option..."/>
                                        <div id="checkbox-brand" class="acc-scroll">
                                            @forelse($brands as $brand)
                                                <label class="checkbox-container">{{$brand->translation->title}}
                                                    ({{$brand->products_count}})
                                                    <input type="checkbox" onclick="actAsRadio(this)"
                                                           class="brand-checkbox"
                                                           @if(in_array($brand->id, $filteredBrandsId)) checked
                                                           @endif name="brand[{{$brand->id}}]">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                {{--/ Brands--}}

                                {{--Origins--}}
                                <div class="accordion">
                                    <a class="type" data-toggle="collapse" data-target="#demo-origin">
                                        Origins
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                    <div id="demo-origin"
                                         class="collapse accordion-data @if(count($filteredOriginsId)>0) show @endif">
                                        <input type="search" class="search-option" id="filter-search-origin"
                                               placeholder="Search an option..."/>
                                        <div id="checkbox-origin" class="acc-scroll">
                                            @forelse($origins as $origin)
                                                <label class="checkbox-container">{{$origin->translation->title}}
                                                    ({{$origin->products_count}})
                                                    <input type="checkbox" onclick="actAsRadio(this)"
                                                           class="origin-checkbox"
                                                           @if(in_array($origin->id, $filteredOriginsId)) checked
                                                           @endif name="origin[{{$origin->id}}]">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                {{--/origins--}}

                                {{--Vehicle--}}
                                {{--<div class="accordion">
                                  <a class="type" data-toggle="collapse" data-target="#demo-vehicle">
                                    {{__('Vehicle')}}
                                    <i class="fas fa-caret-down"></i>
                                  </a>
                                  <div id="demo-vehicle" class="collapse accordion-data @if(count($filteredVehiclesId)>0) show @endif">
                                    <input type="search" class="search-option" id="filter-search-vehicle"
                                           placeholder="Search an option..." />
                                    <div id="checkbox-vehicle" class="acc-scroll">
                                      @forelse($tyreCategories as $category)
                                        <label class="checkbox-container">{{$category->translation->name}}({{$category->products_count}})
                                          <input type="checkbox" onclick="actAsRadio(this)" class="vehicle-checkbox" @if(in_array($category->id, $filteredVehiclesId)) checked @endif name="vehicle[{{$category->id}}]">
                                          <span class="checkmark"></span>
                                        </label>
                                      @empty
                                      @endforelse
                                    </div>
                                  </div>
                                </div>--}}
                                {{--/Vehicle--}}

                                {{--Promotions--}}
                                <div class="accordion">
                                    <a class="type" data-toggle="collapse" data-target="#demo-promotions">
                                        Promotions
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                    <div id="demo-promotions"
                                         class="collapse accordion-data @if(count($filteredPromotionsId)>0) show @endif">
                                        <input type="search" class="search-option" id="filter-search-promotion"
                                               placeholder="Search an option..."/>
                                        <div id="checkbox-promotion" class="acc-scroll">
                                            @forelse($promotions as $promotion)
                                                <label class="checkbox-container">{{$promotion->translation->title}}
                                                    ({{$promotion->products_count}})
                                                    <input type="checkbox" onclick="actAsRadio(this)"
                                                           class="promotion-checkbox"
                                                           @if(in_array($promotion->id, $filteredPromotionsId)) checked
                                                           @endif name="promotion[{{$promotion->id}}]">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                {{--/ Promotions--}}

                                {{--years--}}
                                <div class="accordion">
                                    <a class="type" data-toggle="collapse" data-target="#demo-years">
                                        Year
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                    <div id="demo-years"
                                         class="collapse accordion-data @if(count($filteredYears)>0) show @endif">
                                        <input type="search" class="search-option" id="filter-search-year"
                                               placeholder="Search an option..."/>
                                        <div id="checkbox-year" class="acc-scroll">
                                            @forelse($years as $year)
                                                <label class="checkbox-container">{{$year->year}}({{$year->count}})
                                                    <input type="checkbox" onclick="actAsRadio(this)"
                                                           class="year-checkbox"
                                                           @if(in_array($year->year, $filteredYears)) checked
                                                           @endif name="year[{{$year->year}}]">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                {{--/ years--}}


                            </div>
                            <input hidden name="search" value="1">
                            @if(isset($tyre_width))
                                <input hidden name="width" value="{{$tyre_width}}">
                            @endif
                            @if(isset($tyre_height))
                                <input hidden name="height" value="{{$tyre_height}}">
                            @endif
                            @if(isset($rim))
                                <input hidden name="rim" value="{{$rim}}">
                            @endif
                            @if(isset($width_back))
                                <input hidden name="width_back" value="{{$width_back}}">
                            @endif
                            @if(isset($height_back))
                                <input hidden name="height_back" value="{{$height_back}}">
                            @endif
                            @if(isset($rim_back))
                                <input hidden name="rim_back" value="{{$rim_back}}">
                            @endif
                            <button class="btn btn-block btn--primary btn--animate"
                                    type="submit">Search</button>
                            <a href="{{route('front.product.index')}}"
                               class="btn btn--black btn--animate btn-block">Reset</a>
                    </form>
                </div>
            </div>

            {{--List of tyres--}}
            <div class="col-12 col-sm-7 col-lg-8 tyres-right-col">
                <div class="tyres-detail">
                    @forelse($products as $product )
                        @include('front.common.product',['product' => $product])
                    @empty
                    @endforelse
                </div>
            </div>
        </div>

        {!! $products->appends(request()->query())->links() !!}

    </section>
@endsection

@push('script-page-level')

    <script>

        function submitFilterForm() {
            $('#filter-from').submit();
        }


        // function actAsRadio(className) {
        //   alert(className);
        //   if ($("."+className+"").hasClass(className)){
        //
        //   }
        function actAsRadio(element) {
            var oldCheck = element.checked;
            // console.log('is checked',oldCheck)
            $("." + element.className).each(function () {
                $(this).prop("checked", false)
            })

            if (!oldCheck) {
                element.checked = false;
            } else {
                element.checked = true;
            }
        }

        $(document).ready(function () {
            /*Filter search subattributes*/
            @foreach($attributes as $attribute)
            $("#filter-search-{{$attribute->id}}").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                var type = 'attribute';
                var parent = {{$attribute->id}};
                setTimeout(() => {
                    $.ajax({
                        url: window.Laravel.apiUrl + 'search/filters',
                        data: {value: value, type: type, parent: parent},
                        success: function (data) {
                            console.log('success')
                            var SubAttributes = JSON.parse('{!! json_encode($attribute->subAttributes) !!}');
                            var filterArray = JSON.parse('{!! json_encode($filterSubAttributesId) !!}');

                            if (data.length > 0) {
                                $("#checkbox-{{$attribute->id}}").empty();
                                $.each(data, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-{{$attribute->id}}").append(
                                        ` <label class="checkbox-container">` + value.translation.name + `(` + value.products_count + `)
                        <input type="checkbox"` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );
                                });
                            } else {
                                $("#checkbox-{{$attribute->id}}").empty();
                            }
                            if ($("#filter-search-{{$attribute->id}}").val() === "") {
                                $("#checkbox-{{$attribute->id}}").empty();

                                $.each(SubAttributes, function (key, value) {
                                    $("#checkbox-{{$attribute->id}}").append(
                                        ` <label class="checkbox-container">` + value.translation.name + `(` + value.products_count + `)
                        <input type="checkbox" name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );

                                });

                            }


                        }
                    })
                }, 1000)

            });
            @endforeach

            /*Filter search Brands*/
            $("#filter-search-brand").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                var type = 'brand';
                var parent = 0;

                console.log(window.Laravel.apiUrl + 'search/filters/' + value + '/' + type + '/' + parent)
                setTimeout(() => {
                    $.ajax({
                        url: window.Laravel.apiUrl + 'search/filters',
                        data: {value: value, type: type, parent: parent},
                        success: function (data) {
                            console.log('success')
                            var brands = JSON.parse('{!! json_encode($brands) !!}');
                            var filterArray = JSON.parse('{!! json_encode($filteredBrandsId) !!}');

                            if (data.length > 0) {
                                $("#checkbox-brand").empty();
                                $.each(data, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-brand").append(
                                        ` <label class="checkbox-container">` + value.translation.title + `(` + value.products_count + `)
                        <input type="checkbox"` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );
                                });
                            } else {
                                $("#checkbox-brand").empty();
                            }
                            if ($("#filter-search-brand").val() === "") {
                                $("#checkbox-brand").empty();

                                $.each(brands, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-brand").append(
                                        ` <label class="checkbox-container">` + value.translation.title + `(` + value.products_count + `)
                        <input type="checkbox"` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );

                                });

                            }


                        }
                    })
                }, 1000)
            });

            /*Filter search origins*/
            $("#filter-search-origin").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                var type = 'origin';
                var parent = 0;

                console.log(window.Laravel.apiUrl + 'search/filters/' + value + '/' + type + '/' + parent)
                setTimeout(() => {

                    $.ajax({
                        url: window.Laravel.apiUrl + 'search/filters',
                        data: {value: value, type: type, parent: parent},
                        success: function (data) {
                            console.log('success')
                            var brands = JSON.parse('{!! json_encode($origins) !!}');
                            var filterArray = JSON.parse('{!! json_encode($filteredOriginsId) !!}');

                            if (data.length > 0) {
                                $("#checkbox-origin").empty();
                                $.each(data, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-origin").append(
                                        ` <label class="checkbox-container">` + value.translation.title + `(` + value.products_count + `)
                        <input type="checkbox" ` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );
                                });
                            } else {
                                $("#checkbox-origin").empty();
                            }
                            if ($("#filter-search-origin").val() === "") {
                                $("#checkbox-origin").empty();

                                $.each(brands, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-origin").append(
                                        ` <label class="checkbox-container">` + value.translation.title + `(` + value.products_count + `)
                        <input type="checkbox" ` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );

                                });

                            }


                        }
                    })
                }, 1000)

            });

            /*Filter search vehicle*/
            $("#filter-search-vehicle").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                var type = 'vehicle';
                var parent = 0;

                console.log(window.Laravel.apiUrl + 'search/filters/' + value + '/' + type + '/' + parent)
                setTimeout(() => {

                    $.ajax({
                        url: window.Laravel.apiUrl + 'search/filters',
                        data: {value: value, type: type, parent: parent},
                        success: function (data) {
                            console.log('success', data)
                            var categories = JSON.parse('{!! json_encode($tyreCategories) !!}');
                            var filterArray = JSON.parse('{!! json_encode($filteredVehiclesId) !!}');

                            if (data.length > 0) {
                                $("#checkbox-vehicle").empty();
                                $.each(data, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-vehicle").append(
                                        ` <label class="checkbox-container">` + value.translation.name + `(` + value.products_count + `)
                        <input type="checkbox" ` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );
                                });
                            } else {
                                $("#checkbox-vehicle").empty();
                            }
                            if ($("#filter-search-vehicle").val() === "") {
                                $("#checkbox-vehicle").empty();

                                $.each(categories, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-vehicle").append(
                                        ` <label class="checkbox-container">` + value.translation.name + `(` + value.products_count + `)
                        <input type="checkbox" ` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );

                                });

                            }


                        }
                    })
                }, 1000)

            });

            /*Filter search Promotions*/
            $("#filter-search-promotion").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                var type = 'promotion';
                var parent = 0;

                // console.log(window.Laravel.apiUrl + 'search/filters/' + value + '/' + type + '/' + parent)
                setTimeout(() => {

                    $.ajax({
                        url: window.Laravel.apiUrl + 'search/filters',
                        data: {value: value, type: type, parent: parent},
                        success: function (data) {
                            console.log('success')
                            var brands = JSON.parse('{!! json_encode($promotions) !!}');
                            var filterArray = JSON.parse('{!! json_encode($filteredPromotionsId) !!}');

                            if (data.length > 0) {
                                $("#checkbox-promotion").empty();
                                $.each(data, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-promotion").append(
                                        ` <label class="checkbox-container">` + value.translation.title + `(` + value.products_count + `)
                        <input type="checkbox"` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );
                                });
                            } else {
                                $("#checkbox-promotion").empty();
                            }
                            if ($("#filter-search-promotion").val() === "") {
                                $("#checkbox-promotion").empty();

                                $.each(brands, function (key, value) {
                                    if ($.inArray(value.id, filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-promotion").append(
                                        ` <label class="checkbox-container">` + value.translation.title + `(` + value.products_count + `)
                        <input type="checkbox"` + checked + ` name="attribute[` + value.id + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );

                                });

                            }


                        }
                    })
                }, 1000)

            });

            /*Filter search for Years*/
            $("#filter-search-year").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                var type = 'year';
                var parent = 0;
                if ($("#filter-search-year").val() === "") {
                    value = "";
                }
                console.log(window.Laravel.apiUrl + 'search/filters/' + value + '/' + type + '/' + parent)
                setTimeout(() => {

                    $.ajax({
                        // url: window.Laravel.apiUrl + 'search/filters/' + value + '/' + type + '/' + parent,
                        url: window.Laravel.apiUrl + 'search/filters',
                        data: {value: value, type: type, parent: parent},
                        success: function (data) {
                            // console.log('success', data)
                            var years = JSON.parse('{!! json_encode($years) !!}');
                            {{--          var brands = JSON.parse('{!! json_encode($years) !!}');--}}
                            var filterArray = JSON.parse('{!! json_encode($filteredYears) !!}');
                            console.log('these are the filtered years =>', filterArray )
                            if (data.length > 0) {
                                $("#checkbox-year").empty();
                                $.each(data, function (key, value) {
                                    console.log('This is the value of ajax call =>', value)
                                    if ($.inArray(parseInt(value.year), filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-year").append(
                                        ` <label class="checkbox-container">` + value.year + `(` + value.count + `)
                        <input type="checkbox"` + checked + ` name="year[` + value.year + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );
                                });
                            } else {
                                $("#checkbox-year").empty();
                            }
                            if ($("#filter-search-year").val() === "") {
                                $("#checkbox-year").empty();
                                console.log('filter search input is empty', years)
                                $.each(years, function (key, value) {
                                    if ($.inArray(parseInt(value.year), filterArray) !== -1) {
                                        var checked = 'checked'
                                    }
                                    $("#checkbox-year").append(
                                        ` <label class="checkbox-container">` + value.year + `(` + value.count + `)
                        <input type="checkbox"` + checked + ` name="year[` + value.year + `]">
                          <span class="checkmark"></span>
                      </label>`
                                    );

                                });

                            }


                        }
                    })
                }, 1000)

            });

        });

    </script>

@endpush
