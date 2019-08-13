<?php

namespace Virtualorz\Fileupload;

use Illuminate\Http\Request;
use Storage;
use Validator;

class Fileupload
{

    public static $message = [
        'status' => 2,
        'status_string' => '錯誤',
        'message' => '',
        'data' => []
    ];

    public function index(Request $request){

        self::$message['data']['is_image'] = false;
        if($request->get('is_image') !== null && $request->get('is_image') == true) {

            //整理副檔名
            $mimes = '';
            if($request->get('accept') != null){
                $mimes = str_replace('.','image/',$request->get('accept'));
            }
            //整理圖片尺寸限制
            $dimensions = '';
            if($request->get('size') != null){
                $size = explode('*',$request->get('size'));
                if(count($size) == 2){
                    $dimensions = 'dimensions:width='.$size[0].',height='.$size[1];
                }
            }
            //產生validate string
            $v_string = '';
            if($mimes != ''){
                $v_string .= 'mimetypes:'.$mimes.'|';
            }
            if($dimensions != ''){
                $v_string .= $dimensions;
            }

            if($v_string != ''){
                $validator = Validator::make($request->all(), [
                    'file' => $v_string
                ]);

                if ($validator->fails()) {
                    $error = $validator->errors()->toArray();
                    $error = reset($error);

                    self::$message['status_string'] = '驗證錯誤';
                    self::$message['message'] = $error[0];

                    return self::$message;
                }
            }
            self::$message['data']['is_image'] = true;
        }

        try {

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
