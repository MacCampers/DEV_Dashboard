<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      $this->call(AdminsTableSeeder::class);

      $this->call(ZonesTableSeeder::class);
      $this->call(ActivityAreasTableSeeder::class);
      $this->call(LoiRequirementsTableSeeder::class);
      $this->call(DevelopmentStagesTableSeeder::class);

      // Factories
      if( env('APP_ENV') !== 'production' ) {
         $this->call(CompaniesTableSeeder::class);
      }
   }
}
