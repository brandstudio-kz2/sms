<?php
namespace BrandStudio\Sms;

use Illuminate\Support\ServiceProvider;
use BrandStudio\Sms\SmsService;

class SmsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->configure();
        $this->bindings();
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/sms.php' => config_path('brandstudio/sms.php')
            ], 'config');
        }
    }

    private function configure()
    {
        $this->mergeConfigFrom(__DIR__.'/config/sms.php', 'brandstudio.sms');
    }


    private function bindings()
    {
        $this->app->bind('brandstudio_sms',function() {
            return new SmsService(config('brandstudio.sms'));
        });
    }

}
