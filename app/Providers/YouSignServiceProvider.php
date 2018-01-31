<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class YouSignServiceProvider extends ServiceProvider {
   /**
   * Bootstrap the application services.
   *
   * @return void
   */
   public function boot() {
      $this->app->booting(function() {
         $loader = AliasLoader::getInstance();
         $loader->alias('YouSignApiClient', 'Wooxo\YouSignApiClientLaravel\YouSignApiClientLaravel');
      });
   }

   /**
   * Register the application services.
   *
   * @return void
   */
   public function register() {
      //
   }
}
