<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase {
   /**
   * Test creation form
   *
   * @return void
   */
   public function testCreation() {
      $this->visit('/admin/companies/create')
            ->type('Pixel Parfait', 'company.name')
            ->select('company', 'company.type')
            ->type('824414478', 'company.registration_number')
            ->type('marc@pixelparfait.fr', 'company.email')
            ->type('http://www.pixelparfait.fr', 'company.website')
            ->press('Enregistrer');
   }
}
