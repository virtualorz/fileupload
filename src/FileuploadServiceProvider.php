<?php

namespace Virtualorz\Fileupload;

use Illuminate\Support\ServiceProvider;

class FileuploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('fileupload',function(){
            return new Fileupload();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(__DIR__.'/view', 'fileupload');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}
