<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      // Create companies
      $smartketing = DB::table('companies')->insertGetId([
         'name' => "[Smartketing]",
         'type' => 'investment',
         'category' => 'investment_fund',
         'registration_number' => '555000555',
         'address_1' => '84 avenue du Général Leclerc',
         'zipcode' => '92100',
         'city' => 'Boulogne-Billancourt',
         'phone' => '+33685525406',
         'website' => 'http://www.smartketing.fr',
         'email' => 'contact@equiteasy.com',
         'country_id' => 69,
         'region_id' => 207,
         'confirmed' => 1,
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      $pixelparfait = DB::table('companies')->insertGetId([
         'name' => "[Pixel Parfait]",
         'type' => 'investment',
         'category' => 'investment_fund',
         'registration_number' => '824414478',
         'address_1' => '14 rue Charles V',
         'zipcode' => '75004',
         'city' => 'Paris',
         'phone' => '+33676925404',
         'website' => 'http://www.pixelparfait.fr',
         'email' => 'contact@pixelparfait.fr',
         'country_id' => 69,
         'region_id' => 207,
         'confirmed' => 1,
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      // Create users
      $quentin = DB::table('users')->insertGetId([
         'title' => 'M.',
         'first_name' => 'Quentin',
         'last_name' => 'SMARTKETING',
         'type' => 'investor',
         'email' => 'quentin@smartketing.fr',
         'password' => Hash::make('pass'),
         'default_language' => 'fr',
         'company_id' => 1,
         'company_role' => 'representative',
         'confirmed' => 1,
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);
      $barth = DB::table('users')->insertGetId([
         'title' => 'M.',
         'first_name' => 'Barthélémy',
         'last_name' => 'SMARTKETING',
         'type' => 'investor',
         'email' => 'barthelemy@smartketing.fr',
         'password' => Hash::make('pass'),
         'default_language' => 'fr',
         'company_id' => 1,
         'company_role' => 'admin',
         'confirmed' => 1,
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);
      $thibault = DB::table('users')->insertGetId([
         'title' => 'M.',
         'first_name' => 'Thibault',
         'last_name' => 'Pellequer',
         'type' => 'investor',
         'email' => 'thibault@equiteasy.com',
         'password' => Hash::make('pass'),
         'default_language' => 'fr',
         'company_id' => 1,
         'company_role' => 'admin',
         'confirmed' => 1,
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      $marc = DB::table('users')->insertGetId([
         'title' => 'M.',
         'first_name' => 'Marc',
         'last_name' => 'Bellêtre',
         'type' => 'investor',
         'email' => 'marc@pixelparfait.fr',
         'password' => Hash::make('pass'),
         'default_language' => 'fr',
         'company_id' => 2,
         'company_role' => 'admin',
         'confirmed' => 1,
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      // Create strategies
      for( $i=1; $i<=10; $i++ ) {
         factory(App\Strategy::class, 1)->create([
            'name' => 'Stratégie de test ' . $i,
            'company_id' => $smartketing,

            'value_min' => null,
            'value_max' => 1000000,
            'amount_min' => null,
            'amount_max' => 1000000,
            'revenues_min' => null,
            'revenues_max' => 1000000,
            'value_min_equiteasy' => null,
            'value_max_equiteasy' => 1000000,
            'amount_min_equiteasy' => null,
            'amount_max_equiteasy' => 1000000,
            'revenues_min_equiteasy' => null,
            'revenues_max_equiteasy' => 1000000,

            'majority' => false,
            'minority' => false,
            'profitable' => false,

            'company_size' => 'pme',
            'mbi' => false,

            'confirmed' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
         ])->each(function($strategy) use($barth) {
            // Attach location
            $strategy->zones()->attach(3, ['type' => 'location']);

            // Attach investment zone
            $strategy->zones()->attach(1, ['type' => 'investment']);
            $strategy->zones()->attach(2, ['type' => 'investment']);
            $strategy->zones()->attach(3, ['type' => 'investment']);
            $strategy->zones()->attach(4, ['type' => 'investment']);
            $strategy->zones()->attach(5, ['type' => 'investment']);
            $strategy->zones()->attach(6, ['type' => 'investment']);

            // Attach activity areas
            $strategy->activity_areas()->attach([
               17 => ['type' => 'official'],
               17 => ['type' => 'privileged']
            ]);

            // Attach development stages
            $strategy->development_stages()->attach([1,2,3,4,5,6,7]);

            // Attach user
            $strategy->users()->attach($barth);
         });
      }

      factory(App\Strategy::class, 1)->create([
         'name' => 'Stratégie Pixel Parfait',
         'company_id' => $pixelparfait,

         'value_min' => null,
         'value_max' => 1000000,
         'amount_min' => null,
         'amount_max' => 1000000,
         'revenues_min' => null,
         'revenues_max' => 1000000,
         'value_min_equiteasy' => null,
         'value_max_equiteasy' => 1000000,
         'amount_min_equiteasy' => null,
         'amount_max_equiteasy' => 1000000,
         'revenues_min_equiteasy' => null,
         'revenues_max_equiteasy' => 1000000,

         'majority' => false,
         'minority' => false,
         'profitable' => false,

         'company_size' => 'pme',
         'mbi' => false,

         'confirmed' => 1,

         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ])->each(function($strategy) use($marc) {
         // Attach location
         $strategy->zones()->attach(3, ['type' => 'location']);

         // Attach investment zone
         $strategy->zones()->attach(1, ['type' => 'investment']);
         $strategy->zones()->attach(2, ['type' => 'investment']);
         $strategy->zones()->attach(3, ['type' => 'investment']);
         $strategy->zones()->attach(4, ['type' => 'investment']);
         $strategy->zones()->attach(5, ['type' => 'investment']);
         $strategy->zones()->attach(6, ['type' => 'investment']);

         // Attach activity areas
         $strategy->activity_areas()->attach([
            17 => ['type' => 'official'],
            17 => ['type' => 'privileged']
         ]);

         // Attach development stages
         $strategy->development_stages()->attach([1,2,3,4,5,6,7]);

         // Attach user
         $strategy->users()->attach($marc);
      });
   }
}
