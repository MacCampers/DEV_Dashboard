<?php

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      /*
      |--------------------------------------------------------------------------
      | Continents
      |--------------------------------------------------------------------------
      */

      DB::table('zones')->insert([
         'id' => 1,
         'type' => 'continent',
         'code' => 'africa'
      ]);

      DB::table('zones')->insert([
         'id' => 2,
         'type' => 'continent',
         'code' => 'asia'
      ]);

      DB::table('zones')->insert([
         'id' => 3,
         'type' => 'continent',
         'code' => 'europe'
      ]);

      DB::table('zones')->insert([
         'id' => 4,
         'type' => 'continent',
         'code' => 'north_america'
      ]);

      DB::table('zones')->insert([
         'id' => 5,
         'type' => 'continent',
         'code' => 'oceania'
      ]);

      DB::table('zones')->insert([
         'id' => 6,
         'type' => 'continent',
         'code' => 'south_america'
      ]);

      /*
      |--------------------------------------------------------------------------
      | Countries
      |--------------------------------------------------------------------------
      */

      DB::table('zones')->insert([
         'id' => 8,
         'type' => 'country',
         'code' => 'af',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 9,
         'type' => 'country',
         'code' => 'za',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 10,
         'type' => 'country',
         'code' => 'al',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 11,
         'type' => 'country',
         'code' => 'dz',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 12,
         'type' => 'country',
         'code' => 'de',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 13,
         'type' => 'country',
         'code' => 'ad',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 14,
         'type' => 'country',
         'code' => 'ao',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 15,
         'type' => 'country',
         'code' => 'ag',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 16,
         'type' => 'country',
         'code' => 'sa',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 17,
         'type' => 'country',
         'code' => 'ar',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 18,
         'type' => 'country',
         'code' => 'am',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 19,
         'type' => 'country',
         'code' => 'au',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 20,
         'type' => 'country',
         'code' => 'at',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 21,
         'type' => 'country',
         'code' => 'az',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 22,
         'type' => 'country',
         'code' => 'bs',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 23,
         'type' => 'country',
         'code' => 'bh',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 24,
         'type' => 'country',
         'code' => 'bd',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 25,
         'type' => 'country',
         'code' => 'bb',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 26,
         'type' => 'country',
         'code' => 'be',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 27,
         'type' => 'country',
         'code' => 'bz',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 28,
         'type' => 'country',
         'code' => 'bt',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 29,
         'type' => 'country',
         'code' => 'bo',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 30,
         'type' => 'country',
         'code' => 'ba',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 31,
         'type' => 'country',
         'code' => 'bw',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 32,
         'type' => 'country',
         'code' => 'bn',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 33,
         'type' => 'country',
         'code' => 'br',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 34,
         'type' => 'country',
         'code' => 'bg',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 35,
         'type' => 'country',
         'code' => 'bf',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 36,
         'type' => 'country',
         'code' => 'bi',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 37,
         'type' => 'country',
         'code' => 'by',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 38,
         'type' => 'country',
         'code' => 'bj',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 39,
         'type' => 'country',
         'code' => 'kh',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 40,
         'type' => 'country',
         'code' => 'cm',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 41,
         'type' => 'country',
         'code' => 'ca',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 42,
         'type' => 'country',
         'code' => 'cl',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 43,
         'type' => 'country',
         'code' => 'cn',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 44,
         'type' => 'country',
         'code' => 'cy',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 45,
         'type' => 'country',
         'code' => 'co',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 46,
         'type' => 'country',
         'code' => 'km',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 47,
         'type' => 'country',
         'code' => 'cg',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 48,
         'type' => 'country',
         'code' => 'kp',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 49,
         'type' => 'country',
         'code' => 'kr',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 50,
         'type' => 'country',
         'code' => 'cr',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 51,
         'type' => 'country',
         'code' => 'hr',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 52,
         'type' => 'country',
         'code' => 'cu',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 53,
         'type' => 'country',
         'code' => 'ci',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 54,
         'type' => 'country',
         'code' => 'dk',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 55,
         'type' => 'country',
         'code' => 'dj',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 56,
         'type' => 'country',
         'code' => 'dm',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 57,
         'type' => 'country',
         'code' => 'sv',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 58,
         'type' => 'country',
         'code' => 'es',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 59,
         'type' => 'country',
         'code' => 'ee',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 60,
         'type' => 'country',
         'code' => 'eg',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 61,
         'type' => 'country',
         'code' => 'ae',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 62,
         'type' => 'country',
         'code' => 'ec',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 63,
         'type' => 'country',
         'code' => 'er',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 64,
         'type' => 'country',
         'code' => 'fm',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 65,
         'type' => 'country',
         'code' => 'us',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 66,
         'type' => 'country',
         'code' => 'et',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 67,
         'type' => 'country',
         'code' => 'fj',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 68,
         'type' => 'country',
         'code' => 'fi',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 69,
         'type' => 'country',
         'code' => 'fr',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 70,
         'type' => 'country',
         'code' => 'ga',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 71,
         'type' => 'country',
         'code' => 'gm',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 72,
         'type' => 'country',
         'code' => 'gh',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 73,
         'type' => 'country',
         'code' => 'gd',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 74,
         'type' => 'country',
         'code' => 'gr',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 75,
         'type' => 'country',
         'code' => 'gt',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 76,
         'type' => 'country',
         'code' => 'gn',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 77,
         'type' => 'country',
         'code' => 'gq',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 78,
         'type' => 'country',
         'code' => 'gw',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 79,
         'type' => 'country',
         'code' => 'gy',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 80,
         'type' => 'country',
         'code' => 'ge',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 81,
         'type' => 'country',
         'code' => 'ht',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 82,
         'type' => 'country',
         'code' => 'hn',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 83,
         'type' => 'country',
         'code' => 'hu',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 84,
         'type' => 'country',
         'code' => 'in',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 85,
         'type' => 'country',
         'code' => 'id',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 86,
         'type' => 'country',
         'code' => 'iq',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 87,
         'type' => 'country',
         'code' => 'ir',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 88,
         'type' => 'country',
         'code' => 'ie',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 89,
         'type' => 'country',
         'code' => 'is',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 90,
         'type' => 'country',
         'code' => 'il',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 91,
         'type' => 'country',
         'code' => 'it',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 92,
         'type' => 'country',
         'code' => 'mh',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 93,
         'type' => 'country',
         'code' => 'sb',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 94,
         'type' => 'country',
         'code' => 'jm',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 95,
         'type' => 'country',
         'code' => 'jp',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 96,
         'type' => 'country',
         'code' => 'jo',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 97,
         'type' => 'country',
         'code' => 'kz',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 98,
         'type' => 'country',
         'code' => 'ke',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 99,
         'type' => 'country',
         'code' => 'kg',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 100,
         'type' => 'country',
         'code' => 'ki',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 101,
         'type' => 'country',
         'code' => 'kw',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 102,
         'type' => 'country',
         'code' => 'ls',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 103,
         'type' => 'country',
         'code' => 'lv',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 104,
         'type' => 'country',
         'code' => 'lb',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 105,
         'type' => 'country',
         'code' => 'ly',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 106,
         'type' => 'country',
         'code' => 'lr',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 107,
         'type' => 'country',
         'code' => 'li',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 108,
         'type' => 'country',
         'code' => 'lt',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 109,
         'type' => 'country',
         'code' => 'lu',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 110,
         'type' => 'country',
         'code' => 'md',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 111,
         'type' => 'country',
         'code' => 'mk',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 112,
         'type' => 'country',
         'code' => 'mg',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 113,
         'type' => 'country',
         'code' => 'my',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 114,
         'type' => 'country',
         'code' => 'mw',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 115,
         'type' => 'country',
         'code' => 'mv',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 116,
         'type' => 'country',
         'code' => 'ml',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 117,
         'type' => 'country',
         'code' => 'mt',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 118,
         'type' => 'country',
         'code' => 'ma',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 119,
         'type' => 'country',
         'code' => 'mu',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 120,
         'type' => 'country',
         'code' => 'mr',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 121,
         'type' => 'country',
         'code' => 'mx',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 122,
         'type' => 'country',
         'code' => 'mc',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 123,
         'type' => 'country',
         'code' => 'mn',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 124,
         'type' => 'country',
         'code' => 'me',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 125,
         'type' => 'country',
         'code' => 'mz',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 126,
         'type' => 'country',
         'code' => 'mm',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 127,
         'type' => 'country',
         'code' => 'na',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 128,
         'type' => 'country',
         'code' => 'nr',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 129,
         'type' => 'country',
         'code' => 'ni',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 130,
         'type' => 'country',
         'code' => 'ne',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 131,
         'type' => 'country',
         'code' => 'ng',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 132,
         'type' => 'country',
         'code' => 'no',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 133,
         'type' => 'country',
         'code' => 'nz',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 134,
         'type' => 'country',
         'code' => 'np',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 135,
         'type' => 'country',
         'code' => 'om',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 136,
         'type' => 'country',
         'code' => 'ug',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 137,
         'type' => 'country',
         'code' => 'uz',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 138,
         'type' => 'country',
         'code' => 'pk',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 139,
         'type' => 'country',
         'code' => 'pw',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 140,
         'type' => 'country',
         'code' => 'pa',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 141,
         'type' => 'country',
         'code' => 'pg',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 142,
         'type' => 'country',
         'code' => 'py',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 143,
         'type' => 'country',
         'code' => 'nl',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 144,
         'type' => 'country',
         'code' => 'ph',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 145,
         'type' => 'country',
         'code' => 'pl',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 146,
         'type' => 'country',
         'code' => 'pt',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 147,
         'type' => 'country',
         'code' => 'pe',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 148,
         'type' => 'country',
         'code' => 'qa',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 149,
         'type' => 'country',
         'code' => 'ro',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 150,
         'type' => 'country',
         'code' => 'gb',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 151,
         'type' => 'country',
         'code' => 'ru',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 152,
         'type' => 'country',
         'code' => 'rw',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 153,
         'type' => 'country',
         'code' => 'cf',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 154,
         'type' => 'country',
         'code' => 'do',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 155,
         'type' => 'country',
         'code' => 'cd',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 156,
         'type' => 'country',
         'code' => 'cz',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 157,
         'type' => 'country',
         'code' => 'kn',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 158,
         'type' => 'country',
         'code' => 'sm',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 159,
         'type' => 'country',
         'code' => 'vc',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 160,
         'type' => 'country',
         'code' => 'lc',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 161,
         'type' => 'country',
         'code' => 'ws',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 162,
         'type' => 'country',
         'code' => 'st',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 163,
         'type' => 'country',
         'code' => 'rs',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 164,
         'type' => 'country',
         'code' => 'sc',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 165,
         'type' => 'country',
         'code' => 'sl',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 166,
         'type' => 'country',
         'code' => 'sg',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 167,
         'type' => 'country',
         'code' => 'sk',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 168,
         'type' => 'country',
         'code' => 'si',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 169,
         'type' => 'country',
         'code' => 'so',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 170,
         'type' => 'country',
         'code' => 'sd',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 171,
         'type' => 'country',
         'code' => 'lk',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 172,
         'type' => 'country',
         'code' => 'ch',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 173,
         'type' => 'country',
         'code' => 'sr',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 174,
         'type' => 'country',
         'code' => 'se',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 175,
         'type' => 'country',
         'code' => 'sz',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 176,
         'type' => 'country',
         'code' => 'sy',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 177,
         'type' => 'country',
         'code' => 'sn',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 178,
         'type' => 'country',
         'code' => 'tj',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 179,
         'type' => 'country',
         'code' => 'tz',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 180,
         'type' => 'country',
         'code' => 'tw',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 181,
         'type' => 'country',
         'code' => 'td',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 182,
         'type' => 'country',
         'code' => 'ps',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 183,
         'type' => 'country',
         'code' => 'th',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 184,
         'type' => 'country',
         'code' => 'tl',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 185,
         'type' => 'country',
         'code' => 'tg',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 186,
         'type' => 'country',
         'code' => 'to',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 187,
         'type' => 'country',
         'code' => 'tt',
         'parent' => 4
      ]);

      DB::table('zones')->insert([
         'id' => 188,
         'type' => 'country',
         'code' => 'tn',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 189,
         'type' => 'country',
         'code' => 'tm',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 190,
         'type' => 'country',
         'code' => 'tr',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 191,
         'type' => 'country',
         'code' => 'tv',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 192,
         'type' => 'country',
         'code' => 'ua',
         'parent' => 3
      ]);

      DB::table('zones')->insert([
         'id' => 193,
         'type' => 'country',
         'code' => 'uy',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 194,
         'type' => 'country',
         'code' => 'vu',
         'parent' => 5
      ]);

      DB::table('zones')->insert([
         'id' => 195,
         'type' => 'country',
         'code' => 've',
         'parent' => 6
      ]);

      DB::table('zones')->insert([
         'id' => 196,
         'type' => 'country',
         'code' => 'vn',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 197,
         'type' => 'country',
         'code' => 'ye',
         'parent' => 2
      ]);

      DB::table('zones')->insert([
         'id' => 198,
         'type' => 'country',
         'code' => 'zm',
         'parent' => 1
      ]);

      DB::table('zones')->insert([
         'id' => 199,
         'type' => 'country',
         'code' => 'zw',
         'parent' => 1
      ]);






      /*
      |--------------------------------------------------------------------------
      | Regions
      |--------------------------------------------------------------------------
      */

      DB::table('zones')->insert([
         'id' => 200,
         'type' => 'region',
         'code' => 'auvergne',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 201,
         'type' => 'region',
         'code' => 'bourgogne',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 202,
         'type' => 'region',
         'code' => 'bretagne',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 203,
         'type' => 'region',
         'code' => 'centre',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 204,
         'type' => 'region',
         'code' => 'corse',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 205,
         'type' => 'region',
         'code' => 'grand_est',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 206,
         'type' => 'region',
         'code' => 'hauts_de_france',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 207,
         'type' => 'region',
         'code' => 'idf',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 208,
         'type' => 'region',
         'code' => 'normandie',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 209,
         'type' => 'region',
         'code' => 'nouvelle_aquitaine',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 210,
         'type' => 'region',
         'code' => 'occitanie',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 211,
         'type' => 'region',
         'code' => 'pays_de_la_loire',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 212,
         'type' => 'region',
         'code' => 'paca',
         'parent' => 69
      ]);

      DB::table('zones')->insert([
         'id' => 213,
         'type' => 'region',
         'code' => 'dom_tom',
         'parent' => 69
      ]);

   }
}
