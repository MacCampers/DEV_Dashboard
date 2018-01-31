<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Company;
use App\Zone;
use App\ActivityArea;
use App\DevelopmentStage;
use App\User;
use App\Strategy;

use Carbon\Carbon;
use Excel;
use Auth;

class CompaniesController extends Controller {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Show companies list
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

         $companies = Company::with(['strategies', 'representative'])
                     ->where('name', 'like', $search)
                     ->sortable(['created_at' => 'desc'])->paginate(100);
      } else {
         $companies = Company::with(['strategies', 'representative'])->sortable(['created_at' => 'desc'])->paginate(100);
      }

      return view('back.companies.index')->with(['companies' => $companies]);
   }

   /**
   * Show creation form
   *
   * @return View
   */
   public function create() {
      $zones = Zone::all()->groupBy('type');
      $activityAreas = ActivityArea::whereNull('parent')->get();

      return view('back.companies.create')->with(['zones' => $zones, 'activityAreas' => $activityAreas]);
   }

   /**
   * Show edition form
   *
   * @return View
   */
   public function edit($id) {
      $company = Company::with('representative', 'users', 'strategies', 'strategies.users')->find($id);
      $zones = Zone::where('type', 'country')->orWhere('type', 'region')->get()->groupBy('type');

      return view('back.companies.edit')->with(['company' => $company, 'zones' => $zones]);
   }

   /**
   * Create company
   *
   * @return Redirect
   */
   public function store(Request $request) {

      // Validate form
      $this->validate($request, [
         'company.name' => 'required',
         'company.registration_number' => 'max:50',
         'company.email' => 'email|nullable',
         'company.phone' => 'between:6,25|nullable',
         'company.website' => 'url|nullable',
         'company.deals_per_year' => 'integer|nullable',
         'company.zipcode' => 'max:10|nullable',

         'strategy.*.value_min' => 'integer|nullable',
         'strategy.*.value_max' => 'integer|nullable',
         'strategy.*.amount_min' => 'integer|nullable',
         'strategy.*.amount_max' => 'integer|nullable',
         'strategy.*.revenues_min' => 'integer|nullable',
         'strategy.*.revenues_max' => 'integer|nullable',
         'strategy.*.value_min_equiteasy' => 'integer|nullable',
         'strategy.*.value_max_equiteasy' => 'integer|nullable',
         'strategy.*.amount_min_equiteasy' => 'integer|nullable',
         'strategy.*.amount_max_equiteasy' => 'integer|nullable',
         'strategy.*.revenues_min_equiteasy' => 'integer|nullable',
         'strategy.*.revenues_max_equiteasy' => 'integer|nullable',

         'representative.first_name' => 'required',
         'representative.last_name' => 'required',
         'representative.email' => 'email|required|unique:users,email',
         'representative.phone_fixed' => 'between:6,25|nullable',
         'representative.phone_mobile' => 'between:6,25|nullable',
         'representative.birth_date' => 'date_format:d/m/Y|nullable',
      ]);

      // Create company
      $company = Company::create([
         'name' => $request->input('company.name'),
         'type' => $request->input('company.type'),
         'category' => $request->input('company.category'),
         'registration_number' => $request->input('company.registration_number'),
         'address_1' => $request->input('company.address_1'),
         'address_2' => $request->input('company.address_2'),
         'zipcode' => $request->input('company.zipcode'),
         'city' => $request->input('company.city'),
         'country_id' => $request->input('company.country_id'),
         'region_id' => $request->input('company.region_id'),
         'email' => $request->input('company.email'),
         'phone' => $request->input('company.phone'),
         'website' => $request->input('company.website'),
         'deals_per_year' => $request->input('company.deals_per_year'),
         'confirmed' => 1,
      ]);

      if( $company ) {

         // Set user account type based on company type
         if( $request->input('company.type') === 'company' ) {
            $userType = 'contractor';
         } elseif( $request->input('company.type') === 'investment' ) {
            $userType = 'investor';
         } elseif( $request->input('company.type') === 'counsel' ) {
            $userType = 'advisor';
         } else {
            $userType = 'guest';
         }

         // Create user for representative
         $representative = User::create([
            'type' => $userType,
            'title' => $request->input('representative.title'),
            'first_name' => $request->input('representative.first_name'),
            'last_name' => $request->input('representative.last_name'),
            'job' => $request->input('representative.job'),
            'birth_date' => $request->input('representative.birth_date') ? Carbon::createFromFormat('d/m/Y', $request->input('representative.birth_date'))->format('Y-m-d') : null,
            'email' => $request->input('representative.email'),
            'phone_fixed' => $request->input('representative.phone_fixed'),
            'phone_mobile' => $request->input('representative.phone_mobile'),
            'linkedin_url' => $request->input('representative.linkedin_url'),
            'viadeo_url' => $request->input('representative.viadeo_url'),
            'company_id' => $company->id,
            'company_role' => 'representative',
            'default_language' => 'fr',
            'confirmed' => 1,
         ]);

         $strategies = $request->input('strategy');

         if( sizeof($strategies) > 0 ) {

            $number = 1;

            // Create strategies
            foreach( $strategies as $strategy ) {

               $s = Strategy::create([
                  'name' => $strategy['name'] ? $strategy['name'] : $company->name.' '.$number,
                  'company_id' => $company->id,

                  'value_min' => $strategy['value_min'],
                  'value_max' => $strategy['value_max'],
                  'amount_min' => $strategy['amount_min'],
                  'amount_max' => $strategy['amount_max'],
                  'revenues_min' => $strategy['revenues_min'],
                  'revenues_max' => $strategy['revenues_max'],

                  'value_min_equiteasy' => $strategy['value_min_equiteasy'],
                  'value_max_equiteasy' => $strategy['value_max_equiteasy'],
                  'amount_min_equiteasy' => $strategy['amount_min_equiteasy'],
                  'amount_max_equiteasy' => $strategy['amount_max_equiteasy'],
                  'revenues_min_equiteasy' => $strategy['revenues_min_equiteasy'],
                  'revenues_max_equiteasy' => $strategy['revenues_max_equiteasy'],

                  'majority' => $strategy['majority'],
                  'minority' => $strategy['minority'],
                  'profitable' => $strategy['profitable'],

                  'company_size' => $strategy['company_size'],
                  'mbi' => $strategy['mbi'],
                  'social_impact' => $strategy['social_impact'],

                  'notes' => $strategy['notes'],

                  'confirmed' => true,
               ]);

               // Attach zones and activity areas
               // Here we remove all children when parent is selected
               $zones = Zone::all()->keyBy('id');
               $activityAreas = ActivityArea::all()->keyBy('id');

               // Attach locations
               $selectedLocations = array_key_exists('locations', $strategy) ? $strategy['locations'] : [];
               $locationsToRemove = [];
               foreach( $selectedLocations as $id ) {
                  $locationsToRemove = array_merge($locationsToRemove, $zones[$id]->children()->pluck('id')->toArray());
                  $selectedLocations = array_diff($selectedLocations, $locationsToRemove);
               }

               $attach = [];
               foreach( $selectedLocations as $location ) {
                  $attach[$location] = ['type' => 'location'];
               }
               $s->zones()->attach($attach);

               // Attach investment zones
               $selectedInvestmentZones = array_key_exists('investment_zones', $strategy) ? $strategy['investment_zones'] : [];
               $investmentZonesToRemove = [];
               foreach( $selectedInvestmentZones as $id ) {
                  $investmentZonesToRemove = array_merge($investmentZonesToRemove, $zones[$id]->children()->pluck('id')->toArray());
                  $selectedInvestmentZones = array_diff($selectedInvestmentZones, $investmentZonesToRemove);
               }

               $attach = [];
               foreach( $selectedInvestmentZones as $investmentZone ) {
                  $attach[$investmentZone] = ['type' => 'investment'];
               }
               $s->zones()->attach($attach);

               // Attach official activity areas
               $selectedAreas = array_key_exists('activity_areas_official', $strategy) ? $strategy['activity_areas_official'] : [];
               $areasToRemove = [];
               foreach( $selectedAreas as $id ) {
                  $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
                  $selectedAreas = array_diff($selectedAreas, $areasToRemove);
               }

               $attach = [];
               foreach( $selectedAreas as $area ) {
                  $attach[$area] = ['type' => 'official'];
               }

               $s->activity_areas()->attach($attach);

               // Attach privileged activity areas
               $selectedAreas = array_key_exists('activity_areas_privileged', $strategy) ? $strategy['activity_areas_privileged'] : [];
               $areasToRemove = [];
               foreach( $selectedAreas as $id ) {
                  $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
                  $selectedAreas = array_diff($selectedAreas, $areasToRemove);
               }

               $attach = [];
               foreach( $selectedAreas as $area ) {
                  $attach[$area] = ['type' => 'privileged'];
               }

               $s->activity_areas()->attach($attach);

               // Attach development stages
               $selectedStages = array_key_exists('development_stages', $strategy) ? $strategy['development_stages'] : [];
               $s->development_stages()->attach($selectedStages);

               // Attach representative by default
               $s->users()->attach($representative->id);

               $number++;

            }
         }

         return redirect('/admin/companies/'. $company->id .'/edit')->with('success_message', "La société a été créée avec succès.");
      }

      return redirect('/admin/companies/create')->with('error_message', "Une erreur est survenue lors de l'enregistrement.");
   }

   /**
   * Update company
   *
   * @return Redirect
   */
   public function update(Request $request, $id) {
      // Validate form
      $this->validate($request, [
         'company.name' => 'required',
         'company.registration_number' => 'max:50',
         'company.email' => 'email|nullable',
         'company.phone' => 'between:6,25|nullable',
         'company.website' => 'url|nullable',
         'company.deals_per_year' => 'integer|nullable',
         'company.zipcode' => 'max:10|nullable'
      ]);

      $company = Company::find($id);
      $company->update([
         'name' => $request->input('company.name'),
         'type' => $request->input('company.type'),
         'category' => $request->input('company.category'),
         'registration_number' => $request->input('company.registration_number'),
         'address_1' => $request->input('company.address_1'),
         'address_2' => $request->input('company.address_2'),
         'zipcode' => $request->input('company.zipcode'),
         'city' => $request->input('company.city'),
         'country_id' => $request->input('company.country_id'),
         'region_id' => $request->input('company.region_id'),
         'email' => $request->input('company.email'),
         'phone' => $request->input('company.phone'),
         'website' => $request->input('company.website'),
         'deals_per_year' => $request->input('company.deals_per_year'),
         'confirmed' => true,
      ]);

      if( $company->representative !== null ) {
         // Set user account type based on company type
         if( $request->input('company.type') === 'company' ) {
            $userType = 'contractor';
         } elseif( $request->input('company.type') === 'investment' ) {
            $userType = 'investor';
         } elseif( $request->input('company.type') === 'counsel' ) {
            $userType = 'advisor';
         } else {
            $userType = 'guest';
         }

         $company->representative->update([
            'type' => $userType
         ]);
      }

      return redirect('/admin/companies/'. $id .'/edit')->with('success_message', "La société a été mise à jour.");
   }

   /**
   * Delete company
   *
   * @return Redirect
   */
   public function destroy($id) {
      Company::findOrFail($id)->delete();

      return redirect('/admin/companies')->with('success_message', "La société a été supprimée.");
   }

   /**
   * Add new strategy
   *
   * @return View
   */
   public function addStrategy(Request $request) {
      $zones = Zone::all()->groupBy('type');
      $activityAreas = ActivityArea::whereNull('parent')->get();
      $developmentStages = DevelopmentStage::all();

      return view('back.companies.strategy')->with(['index' => $request->input('index'), 'zones' => $zones, 'activityAreas' => $activityAreas, 'developmentStages' => $developmentStages]);
   }

   /**
   * Show strategy creation popup
   *
   * @return View
   */
   public function popupCreateStrategy(Request $request) {
      $zones = Zone::all()->groupBy('type');
      $activityAreas = ActivityArea::whereNull('parent')->get();
      $developmentStages = DevelopmentStage::all();

      return view('back.companies.strategies.create')->with(['companyId' => $request->input('company_id'), 'zones' => $zones, 'activityAreas' => $activityAreas, 'developmentStages' => $developmentStages]);
   }

   /**
   * Show strategy edition popup
   *
   * @return View
   */
   public function popupEditStrategy(Request $request) {
      $strategy = Strategy::findOrFail($request->input('strategy_id'));

      $zones = Zone::all()->groupBy('type');
      $activityAreas = ActivityArea::whereNull('parent')->get();
      $developmentStages = DevelopmentStage::all();

      return view('back.companies.strategies.edit')->with(['strategy' => $strategy, 'zones' => $zones, 'activityAreas' => $activityAreas, 'developmentStages' => $developmentStages]);
   }

   /**
   * Show user creation popup
   *
   * @return View
   */
   public function popupCreateUser(Request $request) {
      return view('back.companies.users.create')->with(['companyId' => $request->input('company_id')]);
   }

   /**
   * Show user edition popup
   *
   * @return View
   */
   public function popupEditUser(Request $request) {
      $user = User::findOrFail($request->input('user_id'));

      return view('back.companies.users.edit')->with(['user' => $user, 'companyId' => $request->input('company_id')]);
   }

   /**
   * Add user
   *
   * @return Redirect
   */
   public function addUser(Request $request, $companyId) {
      $company = Company::findOrFail($companyId);

      // Validate form
      $this->validate($request, [
         'first_name' => 'required',
         'last_name' => 'required',
         'email' => 'email|required|unique:users,email',
         'phone' => 'between:6,25|nullable',
         'birth_date' => 'date_format:d/m/Y|nullable',
      ]);

      // Set user account type based on company type
      if( $company->type === 'company' ) {
         $userType = 'contractor';
      } elseif( $company->type === 'investment' ) {
         $userType = 'investor';
      } elseif( $company->type === 'counsel' ) {
         $userType = 'advisor';
      } else {
         $userType = 'guest';
      }

      // Create user
      $user = User::create([
         'type' => $userType,
         'title' => $request->input('title'),
         'first_name' => $request->input('first_name'),
         'last_name' => $request->input('last_name'),
         'job' => $request->input('job'),
         'birth_date' => $request->input('birth_date') ? Carbon::createFromFormat('d/m/Y', $request->input('birth_date'))->format('Y-m-d') : null,
         'email' => $request->input('email'),
         'phone_fixed' => $request->input('phone_fixed'),
         'phone_mobile' => $request->input('phone_mobile'),
         'linkedin_url' => $request->input('linkedin_url'),
         'viadeo_url' => $request->input('viadeo_url'),
         'company_id' => $company->id,
         'company_role' => $request->input('role'),
         'default_language' => 'fr',
         'confirmed' => 1,
      ]);

      return redirect('/admin/companies/'. $companyId .'/edit')->with('success_message', $user->full_name." a été ajouté à la société.");
   }

   /**
   * Remove user
   *
   * @return Redirect
   */
   public function removeUser($companyId, $userId) {
      $user = User::findOrFail($userId);

      $user->update([
         'company_id' => null,
         'company_role' => null
      ]);

      return redirect('/admin/companies/'. $companyId .'/edit')->with('success_message', $user->full_name." a été supprimé de la société.");
   }

   /**
   * Show representative creation popup
   *
   * @return View
   */
   public function popupCreateRepresentative(Request $request) {
      return view('back.companies.representative.create')->with(['companyId' => $request->input('company_id')]);
   }

   /**
   * Change representative
   *
   * @return Redirect
   */
   public function changeRepresentative(Request $request, $companyId) {
      // Validate form
      $this->validate($request, [
         'first_name' => 'required',
         'last_name' => 'required',
         'email' => 'email|required|unique:users,email',
         'phone_fixed' => 'between:6,25|nullable',
         'phone_mobile' => 'between:6,25|nullable',
         'birth_date' => 'date_format:d/m/Y|nullable',
      ]);

      $company = Company::findOrFail($companyId);

      // Change role for old representative
      $company->representative->update([
         'company_role' => 'admin'
      ]);

      // Set user account type based on company type
      if( $company->type === 'company' ) {
         $userType = 'contractor';
      } elseif( $company->type === 'investment' ) {
         $userType = 'investor';
      } elseif( $company->type === 'counsel' ) {
         $userType = 'advisor';
      } else {
         $userType = 'guest';
      }

      // Create new user
      $user = User::create([
         'type' => $userType,
         'title' => $request->input('title'),
         'first_name' => $request->input('first_name'),
         'last_name' => $request->input('last_name'),
         'job' => $request->input('job'),
         'birth_date' => $request->input('birth_date') ? Carbon::createFromFormat('d/m/Y', $request->input('birth_date'))->format('Y-m-d') : null,
         'email' => $request->input('email'),
         'phone_fixed' => $request->input('phone_fixed'),
         'phone_mobile' => $request->input('phone_mobile'),
         'linkedin_url' => $request->input('linkedin_url'),
         'viadeo_url' => $request->input('viadeo_url'),
         'company_id' => $company->id,
         'company_role' => 'representative',
         'default_language' => 'fr',
         'confirmed' => 1,
      ]);

      return redirect('/admin/companies/'. $companyId .'/edit')->with('success_message', $user->full_name." a été désigné représentant légal de la société.");
   }

   /**
   * Export companies
   */
   public function export(Request $request) {
      $companies = Company::all();

      $excelData = [];

      foreach( $companies as $company ) {
         $address = $company->address_1;
         $address .= $company->address_2 !== null ? "\n" . $company->address_2 : "";
         $address .= "\n" . $company->zipcode . " " . $company->city;
         $address .= $company->country ? "\n" . $company->country->name : "";
         $address .= $company->region ? "\n" . $company->region->name : "";

         $excelData[] = array(
            '#' => $company->id,
            'Nom' => $company->name,
            'Type' => trans('fields.company_types.'.$company->type, [], 'fr'),
            'Catégorie' => $company->category !== null ? trans('fields.company_categories.'.$company->category, [], 'fr') : '',
            "Numéro d'identification" => $company->registration_number,
            'Adresse' => $address,
            'Email' => $company->email,
            'Téléphone' => $company->phone,
            'Site web' => $company->website,
            'Signataire' => $company->representative->full_name,
            'Deals/an' => $company->deals_per_year,
            'Ajoutée le' => \PHPExcel_Shared_Date::PHPToExcel(Carbon::createFromFormat('Y-m-d H:i:s', $company->created_at)->timestamp),
            'Modifiée le' => \PHPExcel_Shared_Date::PHPToExcel(Carbon::createFromFormat('Y-m-d H:i:s', $company->updated_at)->timestamp)
         );
      }

      Excel::create('Sociétés', function($excel) use($excelData) {
         $excel->sheet('Sociétés', function($sheet) use($excelData) {
            // Set multiple column formats
            $sheet->setColumnFormat(array(
               'A' => '0',
               'L:M' => 'dd/mm/yyyy hh:mm'
            ));

            $sheet->freezeFirstRow();
            $sheet->setAutoFilter('A1:M1');
            $sheet->setHeight(1, 25);

            $sheet->fromArray($excelData, null, 'A1', true);

            $sheet->getStyle('F2:F'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);

            // Styles
            $sheet->cells('A1:M1', function($cells) {
               $cells->setBackground('#00b2ff');
               $cells->setFontColor('#ffffff');
               $cells->setFontWeight('bold');
               $cells->setValignment('center');
            });
            $sheet->cells('A2:M'.$sheet->getHighestRow(), function($cells) {
               $cells->setValignment('top');
            });
         });
      })->download('xlsx');
   }

}
