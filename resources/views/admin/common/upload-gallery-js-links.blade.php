<script>
    var folders = {!! json_encode(scandir(env('GALLERY_BASE_PATH'))) !!};
</script>
<script src="{!! asset('assets/admin/js/custom/image-gallery.js') !!}"></script>
<div id="directory" class="directory" data-directory="{!! env('GALLERY_BASE_PATH') !!}"></div>