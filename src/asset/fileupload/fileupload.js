$(".file_input").change(function(){

    var upload_target = $(this).parents('.form-group').first().next();
    if(typeof $(this).attr('multiple') == typeof undefined) {
        upload_target.find('.upload_result').remove();
    }
    for(var key in $(this).prop('files')){
        if(!isNaN(key)) {

            //顯示loading
            var upload_show_area = upload_target.find('.upload_show_area').clone();
            upload_show_area.removeAttr("id");
            upload_show_area.show();
            var uuid = _uuid();
            upload_show_area.addClass("upload_result");
            upload_show_area.addClass("upload_"+uuid);
            upload_target.find('.upload_file_area').append($(upload_show_area)[0].outerHTML);

            var file = $(this).prop('files')[key];
            var form_data = new FormData();
            form_data.append('file', file);
            form_data.append('uuid', uuid);
            form_data.append('_token', "{{ csrf_token() }}");
            if( typeof $(this).attr('data-is_image') != 'undefined'){
                form_data.append('is_image', $(this).attr('data-is_image'));
            }
            if( typeof $(this).attr('data-size') != 'undefined'){
                form_data.append('size', $(this).attr('data-size'));
            }
            if( typeof $(this).attr('accept') != 'undefined'){
                form_data.append('accept', $(this).attr('accept'));
            }

            $.ajax({
                url: upload_target.find('.virtualorz_upload_path').val(),
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    if (data['status'] == 1) {
                        var template = upload_target.find('.upload_temp_area').clone();
                        template.removeAttr("id");
                        template.find(".upload_name").attr('data-url',data['data']['url']);
                        template.find(".upload_name").html(data['data']['data']['org_name']);
                        template.find(".upload_file").val(JSON.stringify(data['data']['data']));
                        template.show();

                        var uuid = this.data.get('uuid');
                        $(".upload_"+uuid).html($(template)[0].outerHTML);
                    }
                    else{
                        var uuid = this.data.get('uuid');
                        var error_template = $("#show_error").clone();
                        if(typeof data['message'] !='undefined' && data['message'] != ''){
                            error_template.find('.error_message').html(data['message']);
                        }
                        error_template.show();
                        $(".upload_"+uuid).html($(error_template)[0].outerHTML);
                    }
                },
                error: function (jqXHR, exception) {
                    var uuid = this.data.get('uuid');
                    var error_template = $("#show_error").clone();
                    if(typeof data['message'] !='undefined' && data['message'] != ''){
                        error_template.find('error_message').html(data['message']);
                    }
                    error_template.show();
                    $(".upload_"+uuid).html($(error_template)[0].outerHTML);
                }
            });
        }
    }
});
$(document).on("click",".upload_remove",function (e) {
    e.preventDefault();
    $(this).parents('.upload_temp').remove();
});

function _uuid() {
    var d = Date.now();
    if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
        d += performance.now(); //use high-precision timer if available
    }
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}
