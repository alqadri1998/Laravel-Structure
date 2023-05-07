@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <!-- category-section -->
    <section class="category category-section-page padding-to-sec">
        <div class="container text-center font-weight-bold">
            <div class="row">
                <div class="col-12">
                    <div class="catalogs-page text-left mb-5">
                        <h3 class="title-page "> {!! __('Welcome to Our Online Catalogues') !!}!</h3>
                        <div class="des">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Velit nesciunt ducimus minima illum rerum voluptatibus incidunt esse, amet dolores at repellendus assumenda id quaerat totam doloribus, consequatur harum nostrum architecto.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($catalogs as $key => $catalog)
                    <div class="col-md-4 col-lg-2 mb-4">
                       <div class="m-catalog-mt mx-auto">
                       <div class="catalogue-card d-flex justify-content-center align-items-center">
                            <a href="{!! url($catalog->pdf_name) !!}" target="_blank">
                                <div class=" catalogue-img d-flex align-items-center justify-content-center">
                                    <img src="{{imageUrl(url($catalog->image),160,160)}}" alt="Catalog" class="d-block m-auto img-fluid">
                                </div>
                            </a>
                        </div>
                       <div class="mt-2">
                       <a href="{!! asset($catalog->pdf_name) !!}" class="w-100 btn-pdf" target="__blank"> {!! __('Download') !!} <i class="fas fa-file-pdf"></i></a>
                       </div>
                       </div>


                    </div>
                @empty
                    <div class="alert alert-danger" role="alert">
                        {!! __('No Catalog Found') !!}
                    </div>
                @endforelse
                {!! $catalogs->links() !!}
            </div>
        </div>
    </section>
    <!-- /category-section -->

@endsection