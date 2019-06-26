<?php

namespace Virtualorz\Fileupload\Facades;

use Illuminate\Support\Facades\Facade;

class Fileupload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fileupload';
    }
}
