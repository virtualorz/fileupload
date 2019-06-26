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
edit .env file add UPLOADDIR for dir name to save files under public dir

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
   
