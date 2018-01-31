<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('projects', function (Blueprint $table) {
         $table->uuid('id');

         $table->integer('initiator_id')->unsigned();

         // Synthesis
         $table->string('code_name', 80)->nullable();
         $table->string('short_name', 5)->default('P');
         $table->string('type', 80)->default('fundraising');

         $table->string('company_name', 80)->nullable();
         $table->string('company_registration_number', 50)->nullable();
         $table->string('company_address_1')->nullable();
         $table->string('company_address_2')->nullable();
         $table->string('company_zipcode', 10)->nullable();
         $table->string('company_city')->nullable();
         $table->integer('company_country_id')->unsigned()->nullable();
         $table->integer('company_region_id')->unsigned()->nullable();

         $table->integer('representative_id')->unsigned()->nullable();
         $table->string('representative_status', 60)->nullable();
         $table->string('representative_last_name', 60)->nullable();
         $table->string('representative_first_name', 60)->nullable();
         $table->string('representative_email')->nullable();
         $table->string('representative_phone', 25)->nullable();

         $table->bigInteger('amount_searched')->nullable();
         $table->boolean('dilution')->nullable();
         $table->boolean('mbi')->nullable();
         $table->boolean('industrial_merge')->nullable();
         $table->integer('development_stage_id')->unsigned()->nullable();
         $table->string('currency', 3)->default('eur');
         $table->bigInteger('valuation_expected_min')->nullable();
         $table->bigInteger('valuation_expected_max')->nullable();
         $table->boolean('social_impact')->nullable();

         $table->date('company_creation_date')->nullable();

         // Activities
         $table->integer('average_basket')->nullable();
         $table->integer('acquisition_cost')->nullable();

         // Elements
         $table->boolean('has_account')->default(1);

         $table->bigInteger('turnover_m_1')->nullable();
         $table->bigInteger('turnover_m_2')->nullable();
         $table->bigInteger('turnover_m_3')->nullable();

         $table->bigInteger('gross_margin_m_1')->nullable();
         $table->bigInteger('gross_margin_m_2')->nullable();
         $table->bigInteger('gross_margin_m_3')->nullable();

         $table->bigInteger('ebitda_m_1')->nullable();
         $table->bigInteger('ebitda_m_2')->nullable();
         $table->bigInteger('ebitda_m_3')->nullable();

         $table->bigInteger('ebit_m_1')->nullable();
         $table->bigInteger('ebit_m_2')->nullable();
         $table->bigInteger('ebit_m_3')->nullable();

         $table->bigInteger('net_profit_m_1')->nullable();
         $table->bigInteger('net_profit_m_2')->nullable();
         $table->bigInteger('net_profit_m_3')->nullable();

         // Business plan
         $table->bigInteger('turnover_p_0')->nullable();
         $table->bigInteger('turnover_p_1')->nullable();
         $table->bigInteger('turnover_p_2')->nullable();
         $table->bigInteger('turnover_p_3')->nullable();
         $table->bigInteger('turnover_p_4')->nullable();

         $table->bigInteger('gross_margin_p_0')->nullable();
         $table->bigInteger('gross_margin_p_1')->nullable();
         $table->bigInteger('gross_margin_p_2')->nullable();
         $table->bigInteger('gross_margin_p_3')->nullable();
         $table->bigInteger('gross_margin_p_4')->nullable();

         $table->bigInteger('ebitda_p_0')->nullable();
         $table->bigInteger('ebitda_p_1')->nullable();
         $table->bigInteger('ebitda_p_2')->nullable();
         $table->bigInteger('ebitda_p_3')->nullable();
         $table->bigInteger('ebitda_p_4')->nullable();

         $table->bigInteger('ebit_p_0')->nullable();
         $table->bigInteger('ebit_p_1')->nullable();
         $table->bigInteger('ebit_p_2')->nullable();
         $table->bigInteger('ebit_p_3')->nullable();
         $table->bigInteger('ebit_p_4')->nullable();

         $table->bigInteger('net_profit_p_0')->nullable();
         $table->bigInteger('net_profit_p_1')->nullable();
         $table->bigInteger('net_profit_p_2')->nullable();
         $table->bigInteger('net_profit_p_3')->nullable();
         $table->bigInteger('net_profit_p_4')->nullable();

         // Agreements
         $table->boolean('need_nda')->default(1);
         $table->integer('signatory_id')->unsigned()->nullable();
         $table->uuid('licence_id')->nullable();

         // Steering
         $table->tinyInteger('step1_duration')->nullable();
         $table->tinyInteger('step2_duration')->nullable();
         $table->tinyInteger('step3_duration')->nullable();
         $table->tinyInteger('step4_duration')->nullable();
         $table->boolean('confirmed')->default(0);

         $table->boolean('locked')->default(0);
         $table->boolean('canceled')->default(0);
         $table->date('start_date')->nullable();
         $table->text('comment_equiteasy');
         $table->string('export_uri')->nullable();
         $table->timestamp('export_date')->nullable();

         $table->timestamps();

         $table->primary('id');

         $table->foreign('initiator_id')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('representative_id')->references('id')->on('users')->onDelete('set null');
         $table->foreign('development_stage_id')->references('id')->on('development_stages')->onDelete('set null');
         $table->foreign('company_country_id')->references('id')->on('zones')->onDelete('set null');
         $table->foreign('company_region_id')->references('id')->on('zones')->onDelete('set null');
         $table->foreign('signatory_id')->references('id')->on('users')->onDelete('set null');
      });

      // Documents
      Schema::create('documents', function (Blueprint $table) {
         $table->uuid('id');
         $table->uuid('project_id');
         $table->string('name');
         $table->string('uri');
         $table->integer('size');
         $table->string('section', 40);
         $table->integer('uploaded_by')->unsigned()->nullable();
         $table->boolean('signed')->default(0);
         $table->text('comment')->nullable();

         $table->timestamps();

         $table->primary('id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
      });

      // Add foreign key on projects licence_id
      Schema::table('projects', function (Blueprint $table) {
         $table->foreign('licence_id')->references('id')->on('documents')->onDelete('set null');
      });

      // Synthesis - Events
      Schema::create('events', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->date('date');
         $table->text('description');
         $table->uuid('project_id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
      });

      // Synthesis - Activity areas
      Schema::create('project_activity_area', function (Blueprint $table) {
         $table->increments('id');
         $table->uuid('project_id');
         $table->integer('activity_area_id')->unsigned();

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('activity_area_id')->references('id')->on('activity_areas')->onDelete('cascade');
      });

      // Activities - Competitors
      Schema::create('competitors', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->bigInteger('turnover');
         $table->text('description');
         $table->uuid('project_id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
      });

      //structure & organization - shareholder
      Schema::create('shareholders', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->string('security_type_1')->nullable();
         $table->integer('security_number_1')->nullable();
         $table->string('security_type_2')->nullable();
         $table->integer('security_number_2')->nullable();
         $table->string('security_type_3')->nullable();
         $table->integer('security_number_3')->nullable();
         $table->uuid('project_id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
      });

      // Structure & Organization - Branches
      Schema::create('branches', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name', 80);
         $table->string('registration_number', 50);
         $table->string('address_1');
         $table->string('address_2')->nullable();
         $table->string('zipcode', 10);
         $table->string('city');
         $table->integer('country_id')->unsigned();
         $table->integer('region_id')->unsigned()->nullable();
         $table->string('corporate_representative');
         $table->string('shareholding');
         $table->uuid('project_id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('country_id')->references('id')->on('zones')->onDelete('cascade');
         $table->foreign('region_id')->references('id')->on('zones')->onDelete('cascade');
      });

      // Structure & Organization - Transactions
      Schema::create('transactions', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('amount');
         $table->date('date');
         $table->bigInteger('valuation');
         $table->text('context');
         $table->uuid('project_id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
      });

      // Structure & Organization - Managers
      Schema::create('managers', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->string('position');
         $table->text('description')->nullable();
         $table->text('url', 255)->nullable();
         $table->uuid('resume_id')->nullable();
         $table->uuid('project_id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('resume_id')->references('id')->on('documents')->onDelete('set null');
      });

      // User relationship
      Schema::create('user_project', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('user_id')->unsigned();
         $table->uuid('project_id');
         $table->boolean('admin')->default(1);

         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::table('projects', function (Blueprint $table) {
         $table->dropForeign('projects_licence_id_foreign');
      });

      Schema::dropIfExists('user_project');
      Schema::dropIfExists('transactions');
      Schema::dropIfExists('managers');
      Schema::dropIfExists('shareholders');
      Schema::dropIfExists('branches');
      Schema::dropIfExists('events');
      Schema::dropIfExists('competitors');
      Schema::dropIfExists('project_activity_area');
      Schema::dropIfExists('documents');
      Schema::dropIfExists('projects');
   }
}
