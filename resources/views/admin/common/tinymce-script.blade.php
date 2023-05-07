<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 500,
        width : 730,
        theme: 'modern',
        valid_elements : '*[*]',
        verify_html : false,
        valid_children : false,
        plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker fullpage",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker"
        ],
        toolbar1: 'code | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        toolbar2: 'undo redo | styleselect | bold italic | link image | alignjustify | formatselect | fontselect | fontsizeselect | cut | copy | paste | outdent | indent | blockquote | alignleft | aligncenter | alignright | spellchecker | searchreplace | fullscreen | insertdatetime | media | table | ltr | rtl ',
        image_advtab: true,
        automatic_uploads: false,
        images_upload_credentials: true,
        //images_upload_base_path: '{!! url('/').'/' !!}',
        remove_script_host : false,
        convert_urls : false,
        relative_urls : false,
        images_upload_url: "{!! route('admin.home.save-image') !!}",
//            templates: [
//                { title: 'Test template 1', content: 'Test 1' },
//                { title: 'Test template 2', content: 'Test 2' }
//            ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    }).then(function(editors) {
        console.log('its should run')
        setTimeout(()=>{
            $('.mce-widget.mce-notification.mce-notification-warning.mce-has-close.mce-in').hide();
        }, 300)

    });
</script>