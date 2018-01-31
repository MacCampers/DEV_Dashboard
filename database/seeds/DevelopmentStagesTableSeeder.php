<?php

use Illuminate\Database\Seeder;

class DevelopmentStagesTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      DB::table('development_stages')->insert([
         'id' => 1,
         'code' => 'amorcage'
      ]);

      DB::table('development_stages')->insert([
         'id' => 2,
         'code' => 'capital_risque'
      ]);

      DB::table('development_stages')->insert([
         'id' => 3,
         'code' => 'capital_developpement'
      ]);

      DB::table('development_stages')->insert([
         'id' => 4,
         'code' => 'capital_transmission'
      ]);

      DB::table('development_stages')->insert([
         'id' => 5,
         'code' => 'capital_retournement'
      ]);

      DB::table('development_stages')->insert([
         'id' => 6,
         'code' => 'mezzanine'
      ]);

      DB::table('development_stages')->insert([
         'id' => 7,
         'code' => 'dette'
      ]);
   }
}
