<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Strategy;
use App\Zone;
use App\ActivityArea;
use App\DevelopmentStage;
use App\Company;

use Auth;

class StrategiesController extends Controller {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Show strategies list
   *
   * @return View
   */
   public function index(Request $request) {

      // TEMPORARY REDIRECTION BASED ON ADMIN ROLE
      if( Auth::guard('admin')->user()->role === 'cdd' ) {
         return redirect('/admin/companies/create');
      }

      if( $request->input('s') !== null && $request->input('s') !== '' ) {
         $search = '%'.$request->input('s').'%';

         $strategies = Strategy::with('company')
                     ->where('name', 'like', $search)
                     ->orWhereHas('company', function($q) use($search) {
                        $q->where('name', 'like', $search);
                     })
                     ->sortable(['created_at' => 'desc'])->paginate(100);
      } else {
         $strategies = Strategy::with('company')->sortable(['created_at' => 'desc'])->paginate(100);
      }

      return view('back.strategies.index')->with(['strategies' => $strategies]);
   }

   /**
   * Show edition form
   *
   * @return View
   */
   public function edit($id) {
      $strategy = Strategy::find($id);

      $zones = Zone::all()->groupBy('type');
      $activityAreas = ActivityArea::whereNull('parent')->get();
      $developmentStages = DevelopmentStage::all();

      return view('back.strategies.edit')->with(['strategy' => $strategy, 'zones' => $zones, 'activityAreas' => $activityAreas, 'developmentStages' => $developmentStages]);
   }

   /**
   * Create strategy
   *
   * @return Redirect
   */
   public function store(Request $request) {
      $company = Company::findOrFail($request->input('company_id'));

      $strategy = Strategy::create([
         'name' => $request->input('strategy.name') ? $request->input('strategy.name') : $company->name,
         'company_id' => $company->id,

         'value_min' => $request->input('strategy.value_min'),
         'value_max' => $request->input('strategy.value_max'),
         'amount_min' => $request->input('strategy.amount_min'),
         'amount_max' => $request->input('strategy.amount_max'),
         'revenues_min' => $request->input('strategy.revenues_min'),
         'revenues_max' => $request->input('strategy.revenues_max'),

         'value_min_equiteasy' => $request->input('strategy.value_min_equiteasy'),
         'value_max_equiteasy' => $request->input('strategy.value_max_equiteasy'),
         'amount_min_equiteasy' => $request->input('strategy.amount_min_equiteasy'),
         'amount_max_equiteasy' => $request->input('strategy.amount_max_equiteasy'),
         'revenues_min_equiteasy' => $request->input('strategy.revenues_min_equiteasy'),
         'revenues_max_equiteasy' => $request->input('strategy.revenues_max_equiteasy'),

         'majority' => $request->input('strategy.majority'),
         'minority' => $request->input('strategy.minority'),
         'profitable' => $request->input('strategy.profitable'),

         'company_size' => $request->input('strategy.company_size'),
         'mbi' => $request->input('strategy.mbi'),
         'social_impact' => $request->input('strategy.social_impact'),

         'notes' => $request->input('strategy.notes'),

         'confirmed' => true,
      ]);

      // Attach zones and activity areas
      // Here we remove all children when parent is selected
      $zones = Zone::all()->keyBy('id');
      $activityAreas = ActivityArea::all()->keyBy('id');

      // Attach locations
      $selectedLocations = $request->input('strategy.locations') ? $request->input('strategy.locations') : [];
      $locationsToRemove = [];
      foreach( $selectedLocations as $id ) {
         $locationsToRemove = array_merge($locationsToRemove, $zones[$id]->children()->pluck('id')->toArray());
         $selectedLocations = array_diff($selectedLocations, $locationsToRemove);
      }

      $attach = [];
      foreach( $selectedLocations as $location ) {
         $attach[$location] = ['type' => 'location'];
      }
      $strategy->zones()->attach($attach);

      // Attach investment zones
      $selectedInvestmentZones = $request->input('strategy.investment_zones') ? $request->input('strategy.investment_zones') : [];
      $investmentZonesToRemove = [];
      foreach( $selectedInvestmentZones as $id ) {
         $investmentZonesToRemove = array_merge($investmentZonesToRemove, $zones[$id]->children()->pluck('id')->toArray());
         $selectedInvestmentZones = array_diff($selectedInvestmentZones, $investmentZonesToRemove);
      }

      $attach = [];
      foreach( $selectedInvestmentZones as $investmentZone ) {
         $attach[$investmentZone] = ['type' => 'investment'];
      }
      $strategy->zones()->attach($attach);

      // Attach official activity areas
      $selectedAreas = $request->input('strategy.activity_areas_official') ? $request->input('strategy.activity_areas_official') : [];
      $areasToRemove = [];
      foreach( $selectedAreas as $id ) {
         $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
         $selectedAreas = array_diff($selectedAreas, $areasToRemove);
      }

      $attach = [];
      foreach( $selectedAreas as $area ) {
         $attach[$area] = ['type' => 'official'];
      }

      $strategy->activity_areas()->attach($attach);

      // Attach privileged activity areas
      $selectedAreas = $request->input('strategy.activity_areas_privileged') ? $request->input('strategy.activity_areas_privileged') : [];
      $areasToRemove = [];
      foreach( $selectedAreas as $id ) {
         $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
         $selectedAreas = array_diff($selectedAreas, $areasToRemove);
      }

      $attach = [];
      foreach( $selectedAreas as $area ) {
         $attach[$area] = ['type' => 'privileged'];
      }

      $strategy->activity_areas()->attach($attach);

      // Attach development stages
      $selectedStages = $request->input('strategy.development_stages') ? $request->input('strategy.development_stages') : [];
      $strategy->development_stages()->attach($selectedStages);

      // Attach representative by default
      $strategy->users()->attach($company->representative->id);

      return redirect()->back()->with('success_message', "La stratégie a été créée avec succès.");
   }

   /**
   * Update strategy
   *
   * @return Redirect
   */
   public function update(Request $request, $id) {
      $strategy = Strategy::findOrFail($id);

      $strategy->update([
         'name' => $request->input('strategy.name') ? $request->input('strategy.name') : $company->name,

         'value_min' => $request->input('strategy.value_min'),
         'value_max' => $request->input('strategy.value_max'),
         'amount_min' => $request->input('strategy.amount_min'),
         'amount_max' => $request->input('strategy.amount_max'),
         'revenues_min' => $request->input('strategy.revenues_min'),
         'revenues_max' => $request->input('strategy.revenues_max'),

         'value_min_equiteasy' => $request->input('strategy.value_min_equiteasy'),
         'value_max_equiteasy' => $request->input('strategy.value_max_equiteasy'),
         'amount_min_equiteasy' => $request->input('strategy.amount_min_equiteasy'),
         'amount_max_equiteasy' => $request->input('strategy.amount_max_equiteasy'),
         'revenues_min_equiteasy' => $request->input('strategy.revenues_min_equiteasy'),
         'revenues_max_equiteasy' => $request->input('strategy.revenues_max_equiteasy'),

         'majority' => $request->input('strategy.majority'),
         'minority' => $request->input('strategy.minority'),
         'profitable' => $request->input('strategy.profitable'),

         'company_size' => $request->input('strategy.company_size'),
         'mbi' => $request->input('strategy.mbi'),
         'social_impact' => $request->input('strategy.social_impact'),

         'notes' => $request->input('strategy.notes'),

         'confirmed' => true,
      ]);

      // Detach all relations
      $strategy->zones()->detach();
      $strategy->activity_areas()->detach();
      $strategy->development_stages()->detach();

      // Attach zones and activity areas
      // Here we remove all children when parent is selected
      $zones = Zone::all()->keyBy('id');
      $activityAreas = ActivityArea::all()->keyBy('id');

      // Attach locations
      $selectedLocations = $request->input('strategy.locations') ? $request->input('strategy.locations') : [];
      $locationsToRemove = [];
      foreach( $selectedLocations as $id ) {
         $locationsToRemove = array_merge($locationsToRemove, $zones[$id]->children()->pluck('id')->toArray());
         $selectedLocations = array_diff($selectedLocations, $locationsToRemove);
      }

      $attach = [];
      foreach( $selectedLocations as $location ) {
         $attach[$location] = ['type' => 'location'];
      }
      $strategy->zones()->attach($attach);

      // Attach investment zones
      $selectedInvestmentZones = $request->input('strategy.investment_zones') ? $request->input('strategy.investment_zones') : [];
      $investmentZonesToRemove = [];
      foreach( $selectedInvestmentZones as $id ) {
         $investmentZonesToRemove = array_merge($investmentZonesToRemove, $zones[$id]->children()->pluck('id')->toArray());
         $selectedInvestmentZones = array_diff($selectedInvestmentZones, $investmentZonesToRemove);
      }

      $attach = [];
      foreach( $selectedInvestmentZones as $investmentZone ) {
         $attach[$investmentZone] = ['type' => 'investment'];
      }
      $strategy->zones()->attach($attach);

      // Attach official activity areas
      $selectedAreas = $request->input('strategy.activity_areas_official') ? $request->input('strategy.activity_areas_official') : [];
      $areasToRemove = [];
      foreach( $selectedAreas as $id ) {
         $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
         $selectedAreas = array_diff($selectedAreas, $areasToRemove);
      }

      $attach = [];
      foreach( $selectedAreas as $area ) {
         $attach[$area] = ['type' => 'official'];
      }

      $strategy->activity_areas()->attach($attach);

      // Attach privileged activity areas
      $selectedAreas = $request->input('strategy.activity_areas_privileged') ? $request->input('strategy.activity_areas_privileged') : [];
      $areasToRemove = [];
      foreach( $selectedAreas as $id ) {
         $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
         $selectedAreas = array_diff($selectedAreas, $areasToRemove);
      }

      $attach = [];
      foreach( $selectedAreas as $area ) {
         $attach[$area] = ['type' => 'privileged'];
      }

      $strategy->activity_areas()->attach($attach);

      // Attach development stages
      $selectedStages = $request->input('strategy.development_stages') ? $request->input('strategy.development_stages') : [];
      $strategy->development_stages()->attach($selectedStages);

      return redirect()->back()->with('success_message', "La stratégie a été mise à jour.");
   }

   /**
   * Delete strategy
   *
   * @return Redirect
   */
   public function destroy($id) {
      Strategy::findOrFail($id)->delete();

      return redirect()->back()->with('success_message', "La stratégie a été supprimée.");
   }

   /**
   * Duplicate strategy
   *
   * @return Redirect
   */
   public function duplicate($id) {
      $strategy = Strategy::find($id);

      $clone = $strategy->replicate();
      $clone->push();

      foreach( $strategy->zones as $zone ) {
         $clone->zones()->attach($zone, ['type' => $zone->pivot->type]);
      }
      foreach( $strategy->activity_areas as $activityArea ) {
         $clone->activity_areas()->attach($activityArea, ['type' => $activityArea->pivot->type]);
      }
      foreach( $strategy->development_stages as $developmentStage ) {
         $clone->development_stages()->attach($developmentStage);
      }
      foreach( $strategy->users as $user ) {
         $clone->users()->attach($user);
      }

      return redirect()->back()->with('success_message', "La stratégie a été dupliquée.");
   }

   /**
   * Attach users to strategy
   *
   * @return Redirect
   */
   public function attachUsers(Request $request, $id) {
      $this->validate($request, [
         'users' => 'required',
      ]);

      $strategy = Strategy::findOrFail($id);

      $strategy->users()->detach();
      $strategy->users()->attach($request->input('users'));

      return redirect()->back()->with('success_message', "Les contacts associés à la stratégie ". $strategy->name ." ont été mis à jour.");
   }

}
