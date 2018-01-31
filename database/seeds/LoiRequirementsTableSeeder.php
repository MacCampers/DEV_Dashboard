<?php

use Illuminate\Database\Seeder;

class LoiRequirementsTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      DB::table('loi_requirements')->insert([
         'id' => 1,
         'code' => 'transaction',
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 2,
         'code' => 'transaction_perimeter',
         'parent' => 1,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 3,
         'code' => 'transaction_valuation',
         'parent' => 1,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 4,
         'code' => 'transaction_amount',
         'parent' => 1,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 5,
         'code' => 'transaction_governance',
         'parent' => 1,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 6,
         'code' => 'preconditions',
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 7,
         'code' => 'preconditions_diligence',
         'parent' => 6,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 8,
         'code' => 'preconditions_agreements',
         'parent' => 6,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 9,
         'code' => 'preconditions_funding',
         'parent' => 6,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 10,
         'code' => 'preconditions_shareholder',
         'parent' => 6,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 11,
         'code' => 'preconditions_gap',
         'parent' => 6,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 12,
         'code' => 'calendar',
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 13,
         'code' => 'calendar_timing',
         'parent' => 12,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 14,
         'code' => 'calendar_validity',
         'parent' => 12,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 15,
         'code' => 'calendar_exclusiveness',
         'parent' => 12,
      ]);

      DB::table('loi_requirements')->insert([
         'id' => 16,
         'code' => 'annex',
      ]);
      
      DB::table('loi_requirements')->insert([
         'id' => 17,
         'code' => 'fees',
         'parent' => 16,
      ]);
   }
}
