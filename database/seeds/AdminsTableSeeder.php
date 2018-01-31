<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      DB::table('admins')->insert([
         'firstname' => 'Marc',
         'lastname' => 'Bellêtre',
         'email' => 'marc@pixelparfait.fr',
         'password' => Hash::make('pass'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('admins')->insert([
         'firstname' => 'Benoit',
         'lastname' => 'Tabry',
         'email' => 'benoit@pixelparfait.fr',
         'password' => Hash::make('pass'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);




      DB::table('admins')->insert([
         'firstname' => 'Quentin',
         'lastname' => 'Ducouret',
         'email' => 'quentin@smartketing.fr',
         'password' => Hash::make('NyX^+zBjSth#9g$Q'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('admins')->insert([
         'firstname' => 'Barthélémy',
         'lastname' => 'Nevot',
         'email' => 'barthelemy@smartketing.fr',
         'password' => Hash::make('7VWjN+eNt%NG?fWS'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('admins')->insert([
         'firstname' => 'Florian',
         'lastname' => 'Ano',
         'email' => 'florian@smartketing.fr',
         'password' => Hash::make('Fj5RYqJe%TTAV6t7'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('admins')->insert([
         'firstname' => 'Thibault',
         'lastname' => 'Pellequer',
         'email' => 'thibault@smartketing.fr',
         'password' => Hash::make('U?EN-RJsSHU9Bw*w'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('admins')->insert([
         'firstname' => 'Serge',
         'lastname' => 'Bueno',
         'email' => 'serge@smartketing.fr',
         'password' => Hash::make('8$ahbVbH\]4AV#TC'),
         'role' => 'admin',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('admins')->insert([
         'firstname' => 'Louis',
         'lastname' => 'CDD3',
         'email' => 'louis@equiteasy.com',
         'password' => Hash::make('bnq@/"3Yyu\Fwh3D'),
         'role' => 'cdd',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);
      DB::table('admins')->insert([
         'firstname' => 'Pierre',
         'lastname' => 'CDD3',
         'email' => 'pierre@equiteasy.com',
         'password' => Hash::make('6k&8"GXpN;d74jjD'),
         'role' => 'cdd',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

   }
}
