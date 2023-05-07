<?php
echo '
@extends(\'admin.layouts.app\')
@section(\'breadcrumb\')
    @include(\'admin.common.breadcrumbs\')
@endsection

@push(\'stylesheet-page-level\')
@endpush

@push(\'script-page-level\')

@endpush

@section(\'content\')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">'; ?>
                            @foreach($languages['tabs'] as $title=>$tabs)
                                {!! $tabs !!}
                            @endforeach
                        <?php echo '</ul>
                    </div>
                </div>
                <div class="tab-content">'; ?>
                    @foreach($languages['forms'] as $title=>$forms)
                        {!! $forms !!}
                    @endforeach
                <?php echo '</div>
            </div>
        </div>
    </div>
@endsection
';