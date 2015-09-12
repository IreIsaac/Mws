<?php
namespace Ire\Mws\Support;

use Ire\Mws\Collection;
use Ire\Mws\Signature;
use Ire\Mws\Amazon;
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
        //
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
