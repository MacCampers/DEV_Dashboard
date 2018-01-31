<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

use Laravel\Dusk\DuskServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;

use Laravel\Cashier\Cashier;

use Uuid;

use App\Project;
use App\Match;
use App\Document;
use App\Signatory;

class AppServiceProvider extends ServiceProvider {
   /**
   * Bootstrap any application services.
   *
   * @return void
   */
   public function boot() {
      Schema::defaultStringLength(191);

      Cashier::useCurrency('eur', '€');

      Project::creating(function ($model) {
         do {
            $uuid = Uuid::generate()->string;
         } while( $model::find($uuid) instanceof User);

         $model->{$model->getKeyName()} = $uuid;
      });

      Match::creating(function ($model) {
         do {
            $uuid = Uuid::generate()->string;
         } while( $model::find($uuid) instanceof Match);

         $model->{$model->getKeyName()} = $uuid;
      });

      Document::creating(function ($model) {
         do {
            $uuid = Uuid::generate()->string;
         } while( $model::find($uuid) instanceof Match);

         $model->{$model->getKeyName()} = $uuid;
      });

      Signatory::creating(function ($model) {
         do {
            $uuid = Uuid::generate()->string;
         } while( $model::find($uuid) instanceof Match);

         $model->{$model->getKeyName()} = $uuid;
      });

      Relation::morphMap([
         'user' => 'App\User',
         'strategy' => 'App\Strategy',
      ]);
   }

   /**
   * Register any application services.
   *
   * @return void
   */
   public function register() {
      if( $this->app->environment('local') ) {
         $this->app->register(DuskServiceProvider::class);
         $this->app->register(DebugbarServiceProvider::class);
      }
   }
}
