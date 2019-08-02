<?php

namespace Virtualorz\Fileupload;

use Illuminate\Http\Request;
use Storage;

class Fileupload
{

    public static $message = [
        'status' => 2,
        'status_string' => '錯誤',
        'message' => '',
        'data' => []
    ];

    public function index(Request $request){

        try {
            $image_file_subname = [
                'jpg','jpeg','png','gif','bmp'
            ];

            $item = $request->file('file');
            $path = $item->store(env('UPLOADDIR','virtualorz_upload'));
            $size = Storage::size($path);
            $info = pathinfo($path);
            $tmp = [
                'dir' => $info['dirname'],
                'name' => $info['basename'],
                'org_name' => $item->getClientOriginalName(),
                'content_type' => $info['extension'],
                'file_size' => $size
            ];
            self::$message['status'] =1;
            self::$message['status_string'] = "上傳成功";
            self::$message['data']['url'] = Storage::url($info['dirname'].'/'.$info['basename']);
            self::$message['data']['data'] = $tmp;
            self::$message['data']['is_image'] = false;
            if(in_array(strtolower($info['extension']),$image_file_subname)){
                self::$message['data']['is_image'] = true;
            }
        }catch(\Exception $ex){
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    public function createUploadArea($target_name = 'upload_file',$files = null){

        return view('fileupload::uploadArea',[
            'target_name' => $target_name,
            'files' => $files
        ])->render();

    }

    public function createUploadResult($files = null){

        return view('fileupload::uploadResult',[
            'files' => $files
        ])->render();

    }

}
