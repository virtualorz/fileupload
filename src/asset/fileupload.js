$("#file").change(function(){

    $(".upload_result").remove();
    for(var key in $(this).prop('files')){
        if(!isNaN(key)) {

            //顯示loading
            var upload_show_area = $("#upload_show_area").clone();
            upload_show_area.removeAttr("id");
            upload_show_area.show();
            var uuid = _uuid();
            upload_show_area.addClass("upload_result");
            upload_show_area.addClass("upload_"+uuid);
            $("#upload_file_area").append($(upload_show_area)[0].outerHTML);

            var file = $(this).prop('files')[key];
            var form_data = new FormData();
            form_data.append('file', file);
            form_data.append('uuid', uuid);
            form_data.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: $("#virtualorz_upload_path").val(),
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    if (data['status'] == 1) {
                        var template = $("#upload_temp").clone();
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
                        error_template.show();
                        $(".upload_"+uuid).html($(error_template)[0].outerHTML);
                    }
                },
                error: function (jqXHR, exception) {
                    var uuid = this.data.get('uuid');
                    var error_template = $("#show_error").clone();
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
