<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function() {
   $faker = Faker\Factory::create('fr_FR');

   static $title;
   static $userType;
   static $registrationDate;
   static $gender;

   $title = $faker->randomElement(['M.', 'Mme', 'Mlle']);
   $userType = $faker->randomElement(['investor', 'contractor', 'advisor', 'manager']);
   $registrationDate = $faker->dateTime();

   if( $title === 'M.' ) {
      $gender = 'male';
   } else {
      $gender = 'female';
   }

   return [
      'title' => $title,
      'first_name' => $faker->firstName($gender),
      'last_name' => $faker->lastName,
      'type' => $userType,
      'email' => $faker->unique()->safeEmail,
      'phone_fixed' => $faker->e164PhoneNumber,
      'phone_mobile' => $faker->e164PhoneNumber,
      'password' => bcrypt('secret'),
      'birth_date' => $faker->date('Y-m-d', '- 18 years'),
      'default_language' => $faker->randomElement(['fr', 'en']),
      'confirmed' => true,
      'created_at' => $registrationDate,
      'updated_at' => $registrationDate
   ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Company::class, function() {
   $faker = Faker\Factory::create('fr_FR');

   static $createdAt;
   static $companyType;
   static $userType;

   $createdAt = $faker->dateTime();
   $companyType = $faker->randomElement(['company', 'counsel', 'investment']);

   if( $companyType === 'company' ) {
      $userType = 'contractor';
   } else if( $companyType === 'counsel' ) {
      $userType = 'advisor';
   } else {
      $userType = 'investor';
   }

   return [
      'name' => $faker->company,
      'type' => $companyType,
      'registration_number' => str_replace(' ', '', $faker->siren),
      'address_1' => $faker->streetAddress,
      'zipcode' => str_replace(' ', '', $faker->postcode),
      'city' => $faker->city,
      'country_id' => 69,
      'region_id' => rand(200,212),
      'email' => $faker->unique()->safeEmail,
      'phone' => $faker->e164PhoneNumber,
      'website' => $faker->url,
      'confirmed' => true,
      'created_at' => $createdAt,
      'updated_at' => $createdAt
   ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Strategy::class, function() {
   $faker = Faker\Factory::create('fr_FR');

   static $createdAt;

   $createdAt = $faker->dateTime();

   return [
      'name' => $faker->company,

      'value_min' => $faker->numberBetween(0, 10),
      'value_max' => $faker->numberBetween(10, 1000),
      'amount_min' => $faker->numberBetween(0, 10),
      'amount_max' => $faker->numberBetween(10, 1000),
      'revenues_min' => $faker->numberBetween(0, 10),
      'revenues_max' => $faker->numberBetween(10, 1000),
      'value_min_equiteasy' => $faker->numberBetween(0, 10),
      'value_max_equiteasy' => $faker->numberBetween(10, 1000),
      'amount_min_equiteasy' => $faker->numberBetween(0, 10),
      'amount_max_equiteasy' => $faker->numberBetween(10, 1000),
      'revenues_min_equiteasy' => $faker->numberBetween(0, 10),
      'revenues_max_equiteasy' => $faker->numberBetween(10, 1000),

      'majority' => $faker->boolean,
      'minority' => $faker->boolean,
      'profitable' => $faker->boolean,

      'company_size' => $faker->randomElement(['pme', 'tpe', 'eti']),
      'mbi' => $faker->boolean,
      'social_impact' => $faker->boolean,

      'confirmed' => true,
      'created_at' => $createdAt,
      'updated_at' => $createdAt
   ];
});
