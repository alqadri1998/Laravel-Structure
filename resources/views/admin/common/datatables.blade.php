@push('stylesheet-page-level')
<!--page level css -->
<link rel="stylesheet" type="text/css" href="{!! asset('assets/vendors/datatables/css/dataTables.bootstrap.css') !!}"/>
<link rel="stylesheet" type="text/css" href="{!! asset('assets/css/custom.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! asset('assets/css/custom_css/datatables_custom.css') !!}">
<!--end of page level css-->
@endpush 

@push('script-page-level')
<!-- begining of page level js -->
<script type="text/javascript" src="{!! asset('assets/vendors/datatables/js/jquery.dataTables.js') !!}"></script>
<script type="text/javascript" src="{!! asset('assets/vendors/datatables/js/dataTables.bootstrap.js') !!}"></script>
<script type="text/javascript" src="{!! asset('assets/js/custom_js/datatables_custom.js') !!}"></script>
<!-- end of page level js -->
@endpush 