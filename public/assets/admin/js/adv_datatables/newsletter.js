$(document).ready(function () {
    $('.templates').on('change', function () {
        var value = $(this).val();
        var templateId = {
            templateId : value
        };
        $.ajax({
            type: 'GET',
            url: url,
            data: templateId,
            dataType: 'json',
            encode: true,
            success: function (response) {
                var template = response.data;
                tinyMCE.activeEditor.setContent(template);
            },
            error: function (response) {

            }
        });
    });
});