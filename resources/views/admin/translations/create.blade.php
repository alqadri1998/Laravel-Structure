@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{!! $heading !!}</h1>
    @include('admin.common.breadcrumbs')
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav  nav-tabs ">
                <li class="active">
                    <a href="#english" data-toggle="tab">English</a>
                </li>
            </ul>
            <div class="tab-content m-t-10">
                <div id="english" class="tab-pane fade active in">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-files-o"></i> {!! $heading !!}
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    @include('admin.pages.form', ['languageId' => $locales['en']])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
