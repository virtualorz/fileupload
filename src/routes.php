<?php

Route::post('/virtualorz/upload',
    [
        'as' => 'virtualorz.upload' ,
        'uses' => 'Virtualorz\Fileupload\Fileupload@index',
        'permission' => false
    ]);
