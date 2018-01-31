<?php

use Illuminate\Database\Seeder;

class ActivityAreasTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      DB::table('activity_areas')->insert([
         'id' => 1,
         'code' => 'agro_alimentaire'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 2,
         'code' => 'hotelerie'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 3,
         'code' => 'audiovisuel'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 4,
         'code' => 'finance'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 5,
         'code' => 'defense'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 6,
         'code' => 'distribution'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 7,
         'code' => 'environment'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 8,
         'code' => 'immobilier',
      ]);

      DB::table('activity_areas')->insert([
         'id' => 9,
         'code' => 'industrie',
      ]);
      DB::table('activity_areas')->insert([
         'id' => 10,
         'code' => 'industrie_aerospatial',
         'parent' => 9
      ]);
      DB::table('activity_areas')->insert([
         'id' => 11,
         'code' => 'industrie_automobile',
         'parent' => 9
      ]);
      DB::table('activity_areas')->insert([
         'id' => 12,
         'code' => 'industrie_navale',
         'parent' => 9
      ]);
      DB::table('activity_areas')->insert([
         'id' => 13,
         'code' => 'industrie_chimique',
         'parent' => 9
      ]);

      DB::table('activity_areas')->insert([
         'id' => 14,
         'code' => 'sante'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 15,
         'code' => 'mode'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 16,
         'code' => 'tourisme'
      ]);

      DB::table('activity_areas')->insert([
         'id' => 17,
         'code' => 'tic'
      ]);
      DB::table('activity_areas')->insert([
         'id' => 18,
         'code' => 'tic_logiciels',
         'parent' => 17
      ]);
      DB::table('activity_areas')->insert([
         'id' => 19,
         'code' => 'tic_telecom',
         'parent' => 17
      ]);
      DB::table('activity_areas')->insert([
         'id' => 20,
         'code' => 'tic_internet',
         'parent' => 17
      ]);

      DB::table('activity_areas')->insert([
         'id' => 21,
         'code' => 'education'
      ]);

   }
}
