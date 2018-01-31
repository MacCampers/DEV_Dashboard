<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Admin;

class CompanyTest extends DuskTestCase {
   /**
   * Test creation form
   *
   * @return void
   */
   public function testCreation() {
      $admin = Admin::first();

      $this->browse(function (Browser $browser) use ($admin) {
         $browser->loginAs($admin, 'admin')
                  ->visit('/admin/companies/create')
                  ->type('company[name]', 'Pixel Parfait')
                  ->select('company[type]', 'company')
                  ->type('company[registration_number]', '824414478')
                  ->type('company[email]', 'marc@pixelparfait.fr')
                  ->type('company[website]', 'http://www.pixelparfait.fr')
                  ->press('Enregistrer');
      });
   }
}
