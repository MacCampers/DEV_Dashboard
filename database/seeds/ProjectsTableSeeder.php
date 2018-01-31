<?php

use Illuminate\Database\Seeder;

use Webpatser\Uuid\Uuid;

class ProjectsTableSeeder extends Seeder {
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run() {
      $uuid = Uuid::generate();

      DB::table('projects')->insert([
         'id' => $uuid,
         'initiator_id' => 1,
         'code_name' => 'Pixel Parfait',
         'short_name' => 'PP',
         'type' => 'fundraising',
         'company_name' => 'Pixel Parfait',
         'company_registration_number' => '824414478',
         'company_address_1' => '14 rue Charles V',
         'company_zipcode' => '75004',
         'company_city' => 'Paris',
         'company_country_id' => 69,
         'company_region_id' => 207,
         'representative_id' => 2,
         'representative_status' => 'Président',
         'amount_searched' => 1000000,
         'mbi' => 0,
         'development_stage_id' => 4,
         'social_impact' => 1,
         'company_creation_date' => "2016-12-23",
         'turnover_m_1' => 800000,
         'ebitda_m_1' => 12000,
         'turnover_p_0' => 1000000,
         'ebitda_p_0' => 10000,
         'ebit_p_0' => 10000,

         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('project_activity_area')->insert([
         'project_id' => $uuid,
         'activity_area_id' => 17
      ]);
      DB::table('shareholders')->insert([
         'name' => 'Marc Bellêtre',
         'security_type_1' => 'Actions',
         'security_number_1' => 300,
         'project_id' => $uuid
      ]);

      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'fundraising_objective',
         'value' => "Pour acheter des nouveaux ordis"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'teaser_mail',
         'value' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla augue tellus, posuere ac orci sed, cursus laoreet ante. Nam sed erat venenatis ex laoreet placerat. Cras vitae sapien diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse a commodo dolor."
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'teaser_welcome',
         'value' => "Suspendisse potenti. Maecenas placerat eros quis nisl fringilla rutrum. Nulla semper dui in arcu aliquet, sit amet facilisis lectus eleifend. Aliquam id massa libero. Proin lacus risus, ullamcorper a ante fermentum, vulputate hendrerit dolor. Etiam aliquam felis sed nisi ullamcorper, eget pulvinar neque tincidunt. Morbi lectus odio, iaculis nec consectetur a, elementum at diam. Morbi id sagittis arcu. Fusce tempus bibendum nisl, ut tempor lorem. Nulla tempor scelerisque orci eget ultricies. Fusce eget eros urna. Duis ac urna justo. Curabitur iaculis mattis dolor, ut maximus enim congue congue. Phasellus a turpis vel libero posuere congue sit amet eleifend purus."
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'activity_description',
         'value' => "Développement de sites web"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'organization_functioning',
         'value' => "Organigramme fonctionnel"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'development_plan_explanation',
         'value' => "Explication du plan de développement et des grands axes stratégiques"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'sales_variation',
         'value' => "Évolution des ventes"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'gross_margin_variation',
         'value' => "Évolution de la marge brute"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'cost_variation',
         'value' => "Évolution des charges"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'use_of_funds',
         'value' => "Utilisation des fonds"
      ]);
      DB::table('text_fields')->insert([
         'project_id' => $uuid,
         'field' => 'nda',
         'value' => "<h1 style=\"text-align: center;\">ACCORD DE CONFIDENTIALIT&Eacute;</h1>
         <h4>Entre les soussign&eacute;s</h4>
         <p>Pixel Parfait, immatricul&eacute;e sous le num&eacute;ro suivant : 824 414 478</p>
         <p>dont le si&egrave;ge social est sis &agrave; l'adresse suivante :</p>
         <p>14 rue Charles V</p>
         <p>75004 Paris</p>
         <p>FRANCE</p>
         <p>&nbsp;</p>
         <p>D'une part,</p>
         <p>&nbsp;</p>
         <p><strong>ET</strong></p>
         <p>&nbsp;</p>
         <p>_______________, immatricul&eacute;e sous le num&eacute;ro suivant : _______________</p>
         <p>dont le si&egrave;ge social est sis &agrave; l'adresse suivante :</p>
         <p>&nbsp;</p>
         <p>_______________<br />_______________</p>
         <p>&nbsp;</p>
         <p>D'autre part,</p>
         <p>&nbsp;</p>
         <p>D&eacute;nomm&eacute;s ci-apr&egrave;s individuellement la \"<strong>Partie</strong>\" ou collectivement les \"<strong>Parties</strong>\"</p>
         <p>&nbsp;</p>"
      ]);
   }
}
