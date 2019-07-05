# Usage
Use for bootstap and Laravel project to upload file <br />
Use Laravel storage to store upload files <br />
This project require PHP imagick extension to save thumb and fit jpg file

# Install
    composer require virtualorz/fileupload
    
# Config
edit config/app.php
    
    'providers' => [
        ...
        Virtualorz\Fileupload\FileuploadServiceProvider::class
    ]
    
    'aliases' => [
        ...
        'Fileupload' => Virtualorz\Fileupload\Facades\Fileupload::class,
    ]
   
# Publish data
    php artisan vendor:publish --provider="Virtualorz\Fileupload\FileuploadServiceProvider"
    
# Edit .env
edit .env file add UPLOADDIR for dir name to save files under public dir <br>
edit .env file add FILESYSTEM_DRIVER=public

# Edit config/filesystems.php
edit the 'disks' area, replace the 'public' to 

    'public' => [
                'driver' => 'local',
                'root' => public_path('uploads'),
                'url' => env('APP_URL').'uploads',
                'visibility' => 'public',
            ],

# Usage
    In view:
    <script src="{{ asset('vendor/fileupload/fileupload.js') }}"></script>
    And need an file element like :
    <input type="file" name="file" id="file" class="file_input" accept=".jpeg">
    accept attribute can edit to the file type you want
    
    And after file element call {!! Fileupload::createUploadArea($files)!!}
    
# Method

###### createUploadArea($files = null)
`return bload html for view to generate file upload html area, in edit mode you can put the uploed file to $files variable`
   
# 中文版本文件
[Fileupload : 快速產生檔案上傳介面及管理](http://www.alvinchen.club/2019/07/03/%e4%bd%9c%e5%93%81laravel-package-fileupload-%e5%bf%ab%e9%80%9f%e7%94%a2%e7%94%9f%e6%aa%94%e6%a1%88%e4%b8%8a%e5%82%b3%e4%bb%8b%e9%9d%a2%e5%8f%8a%e7%ae%a1%e7%90%86/)
