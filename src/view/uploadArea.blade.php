<div class="upload_file_area">
    <div class="btn-group upload_temp_area" style="display:none">
        <button type="button" class="btn btn-success upload_name btn-url-black"></button>
        <div class="col-sm-3 target_img_div"><img class="img-responsive target_img"></div>
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" class="upload_remove">移除</a></li>
        </ul>
        <input type="hidden" class="upload_file" name="{{ $target_name }}[]">
    </div>

    <div id="show_error" class="alert alert-danger alert-dismissible alert_show_error" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="$(this).hide()">×</button>
        <h4><i class="icon fa fa-ban"></i> 錯誤!</h4>
        上傳錯誤，請重新操作
    </div>

    <span class="upload_show_area" style="display:none">
                <div class="progress active progress-upload">
                    <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" style="width: 100%">
                    </div>
                </div>
            </span>

    @if(isset($files))
        @foreach($files as $k=>$v)
            <span>
                        <div class="btn-group upload_temp upload_result">
                            <button type="button" class="btn btn-success upload_name btn-url-black" data-url="{{ Storage::url($v['dir'].'/'.$v['name']) }}">{{ $v['org_name'] }}</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" class="upload_remove">移除</a></li>
                            </ul>
                            <input type="hidden" class="upload_file" name="{{ $target_name }}[]" value="{{ json_encode($v) }}">
                        </div>
                    </span>
        @endforeach
    @endif
</div>
<input type="hidden" class="virtualorz_upload_path" value="{{ Route('virtualorz.upload') }}">
