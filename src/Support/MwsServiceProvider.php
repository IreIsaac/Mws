<?php
namespace IreIsaac\Mws\Support;

use IreIsaac\Mws\Collection;
use IreIsaac\Mws\Signature;
use IreIsaac\Mws\Amazon;
use Illuminate\Support\ServiceProvider;

class MwsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/amazon.php' => config_path('amazon.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mws', function ($app) {
            
            $collection = new Collection();
            $endpoint = 'https://mws.amazonservices.com';

            return new Amazon($collection, $endpoint);
        });
    }
}
