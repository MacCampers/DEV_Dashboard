<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Mail\Project\ProjectValidationRequest;
use App\Mail\Project\ProjectAccountCreation;
use App\Mail\Project\ProjectInvitation;
use App\Mail\Project\ProjectGuestRemoval;
use App\Mail\Signature;

use App\Project;
use App\Zone;
use App\DevelopmentStage;
use App\ActivityArea;
use App\Branch;
use App\Competitor;
use App\Document;
use App\Event;
use App\Manager;
use App\Shareholder;
use App\Transaction;
use App\User;
use App\Match;
use App\LoiRequirement;
use App\MatchEvent;
use App\DocumentComment;

use Auth;
use Storage;
use Mail;
use Hash;
use Validator;

class ProjectsController extends Controller {

   /**
   * Show creation form
   *
   * @return View|Redirect
   */
   public function create() {
      $user = Auth::user();

      if( $user->canCreateProject() ) {
         if( $user->type === 'advisor' ) {
            $zones = Zone::all();
            $countries = $zones->where('type', 'country');
            $regions = $zones->where('type', 'region');

            return view('front.dashboard.project.form.pre_form', ['user' => $user, 'countries' => $countries, 'regions' => $regions]);
         } else {
            // Create project
            $project = Project::create([
               'initiator_id' => $user->id,
               'company_name' => $user->company->name,
               'company_registration_number' => $user->company->registration_number,
               'company_address_1' => $user->company->address_1,
               'company_address_2' => $user->company->address_2,
               'company_city' => $user->company->city,
               'company_zipcode' => $user->company->zipcode,
               'company_country_id' => $user->company->country_id,
               'company_region_id' => $user->company->region_id,
               'signatory_id' => $user->id,
               'currency' => 'eur',
            ]);

            $companyAddress = $user->company->address_1 . ', ' . $user->company->zipcode . ' ' . $user->company->city;

            // Generate licence document
            $licence = $project->generateLicence($user, $user->company->name, $user->company->registration_number, $companyAddress);

            return redirect()->route('project_edit', ['id' => $project->id, 'step' => 'synthesis']);
         }
      }

      abort(403);
   }


   /**
   * Create new project
   *
   * @return Redirect
   */
   public function createFromPreform(Request $request) {
      $user = Auth::user();

      if( $user->canCreateProject() ) {
         $licenceSignatory = $user;

         if( $user->type === 'advisor' ) {
            $validator = Validator::make($request->all(), [
               'certified' => 'required',
               'company_name' => 'max:80|required',
               'code_name' => 'max:80|required',
               'company_registration_number' => 'max:50|required',
               'company_address_1' => 'max:191|required',
               'company_address_2' => 'max:191',
               'company_zipcode' => 'max:10|required',
               'company_city' => 'max:191|required',
               'company_country_id' => 'exists:zones,id|required',
               'company_region_id' => 'exists:zones,id|nullable',
               'representative_status' => 'max:60|required',
               'representative_first_name' => 'max:60|required',
               'representative_last_name' => 'max:60|required',
               'representative_email' => 'email|unique:users,email|required',
               'representative_phone' => 'max:25|required',
               'signatory_phone' => 'max:25|required',
            ]);

            if( $validator->fails() ) {
               return redirect()->route('project_create')->withErrors($validator)->withInput();
            }

            // Generate random password
            $password = str_random(16);

            // Create representative's account
            $representative = User::create([
               'type' => 'guest',
               'first_name' => $request->input('representative_first_name'),
               'last_name' => $request->input('representative_last_name'),
               'email' => $request->input('representative_email'),
               'password' => Hash::make($password),
               'phone_mobile' => $request->input('representative_phone'),
               'default_language' => 'fr',
               'confirmed' => true
            ]);

            // Set licence signatory and update phone number if needed
            if( $request->input('signatory') === 'representative' ) {
               $licenceSignatory = $representative;
            } else {
               $user->update(['phone_mobile' => $request->input('signatory_phone')]);
            }

            // Create project
            $project = Project::create([
               'initiator_id' => $user->id,
               'company_name' => $request->input('company_name'),
               'code_name' => $request->input('code_name'),
               'company_registration_number' => $request->input('company_registration_number'),
               'company_address_1' => $request->input('company_address_1'),
               'company_address_2' => $request->input('company_address_2'),
               'company_city' => $request->input('company_city'),
               'company_zipcode' => $request->input('company_zipcode'),
               'company_country_id' => $request->input('company_country_id'),
               'company_region_id' => $request->input('company_region_id'),
               'representative_id' => $representative->id,
               'type' => $request->input('project_type'),
               'representative_status' => $request->input('representative_status'),
               'currency' => 'eur',
               'signatory_id' => $licenceSignatory->id,
            ]);

            // Add representative as guest
            $project->guests()->attach($representative, ['admin' => 1]);

            // Send credentials to the representative
            Mail::to($representative)->send(new ProjectAccountCreation($representative, $project, $password, Auth::user()->full_name));
         }

         $companyAddress = $project->company_address_1 . ', ' . $project->company_zipcode . ' ' . $project->company_city;

         // Generate licence document
         if( !$project->generateLicence($licenceSignatory, $project->company_name, $project->company_registration_number, $companyAddress) ) {
            return redirect()->route('project_overview', ['id' => $project->id])->with('popup', trans('popups.project.licence_error'));
         }

         return redirect()->route('project_edit', ['id' => $project->id, 'step' => 'synthesis'])->with('popup', trans('popups.project.creation_success'));
      } else {
         return redirect()->route('project_create')->with('error_message', trans('dashboard.overview.not_certified'));
      }
   }


   /**
   * Show overview
   *
   * @return View
   */
   public function overview(Request $request, $id) {
      $project = Project::with(['matches', 'matches.nda'])->find($id);

      $data = [
         'project' => $project,
         'completion' => !$project->locked ? $project->getFormCompletion() : [],
      ];

      return view('front.dashboard.project.overview', $data);
   }


   /**
   * Show steering
   *
   * @return View
   */
   public function steering($id) {
      $project = Project::find($id);
      $loiRequirements = LoiRequirement::with('children')->whereNull('parent')->get();

      $warning = false;

      if( !$project->hasDurations() ) {
         $warning = true;

         $project->step1_duration = 60;
         $project->step2_duration = 15;
         $project->step3_duration = 45;
         $project->step4_duration = 60;
      }

      return view('front.dashboard.project.steering', ['project' => $project, 'warning' => $warning, 'loiRequirements' => $loiRequirements]);
   }


   /**
   * Update LOI requirements
   *
   * @return View
   */
   public function updateRequirements(Request $request, $id) {
      $project = Project::find($id);
      $loiRequirements = LoiRequirement::all()->keyBy('id');

      // Detach existing requirements
      $project->loi_requirements()->detach();

      // Attach requirements
      $selectedRequirements = $request->input('loi_requirements') ? $request->input('loi_requirements') : [];
      $requirementsToRemove = [];

      foreach( $selectedRequirements as $id ) {
         $requirementsToRemove = array_merge($requirementsToRemove, $loiRequirements[$id]->children()->pluck('id')->toArray());
         $selectedRequirements = array_diff($selectedRequirements, $requirementsToRemove);
      }

      $project->loi_requirements()->attach($selectedRequirements);

      return redirect()->back()->with('success_message', trans('dashboard.project.update_success'));
   }


   /**
   * Show guests
   *
   * @return View
   */
   public function guests($id) {
      $project = Project::with('guests')->find($id);

      return view('front.dashboard.project.guests', ['project' => $project]);
   }


   /**
   * Edit project
   *
   * @return View|Redirect
   */
   public function edit(Request $request, $id, $step) {
      $project = Project::find($id);

      if( $project->locked || Auth::user()->getProjectAccess($project) === 'guest' ) {
         return redirect()->route('project_view', ['id' => $id, 'step' => $step]);
      }

      $load = ['documents'];

      $zones = Zone::all();
      $return = [
         'countries' => $zones->where('type', 'country'),
         'regions' => $zones->where('type', 'region'),
      ];

      if( $step === 'synthesis' ) {
         array_push($load, 'events', 'search_zones');

         $return['developmentStages'] = DevelopmentStage::all();
         $return['activityAreas'] = ActivityArea::with('children')->whereNull('parent')->get();
         $return['zones'] = $zones->where('parent', null);
      } elseif( $step === 'activities' ) {
         array_push($load, 'competitors');
      }

      $project->load($load);

      $return['project'] = $project;
      $return['step'] = $step;

      return view('front.dashboard.project.form.form', $return);
   }


   /**
   * View project
   *
   * @return View
   */
   public function view($id, $step = 'synthesis') {
      $project = Project::find($id);

      return view('front.dashboard.project.view.view' , ['project' => $project, 'step' => $step]);
   }


   /**
   * Preview project
   *
   * @return View
   */
   public function preview($projectId, $step) {
      $project = Project::find($projectId);

      return view('front.dashboard.project.view.preview', ['step' => $step, 'project' => $project]);
   }


   /**
   * Upload file
   *
   * @return Response
   */
   public function uploadFile(Request $request, $id) {
      $project = Project::find($id);
      $user = Auth::user();

      $this->validate($request, [
         'file' => 'max:15000|mimes:pdf,xls,xlsx,ppt,pptx,doc,docx',
      ]);

      return $project->uploadSingleDocument($request->file('file'), $request->input('section'), $request->input('name'));
   }


   /**
   * Update project
   *
   * @return Redirect
   */
   public function update(Request $request, $id, $step) {
      $project = Project::find($id);
      $user = Auth::user();

      // Remove old documents
      if( $request->input('files_to_remove') !== '' ) {
         $fileIds = explode(',', $request->input('files_to_remove'));
         $files = Document::whereIn('id', $fileIds)->where('project_id', $project->id)->get();

         foreach( $files as $file ) {
            Storage::delete($file->uri);
            $file->delete();
         }
      }

      /*
      |--------------------------------------------------------------------------
      | Synthesis
      |--------------------------------------------------------------------------
      */
      if( $step === 'synthesis' ) {

         // Set validation rules
         $rules = [
            'kbis' => 'max:15000',
            'statutes' => 'max:15000',
            'sharehold_agreement' => 'max:15000',
            'synthesis_misc_documents' => 'max:15000',

            'code_name' => 'max:80',

            'company_name' => 'max:80',
            'company_registration_number' => 'max:50',
            'company_address_1' => 'max:191',
            'company_address_2' => 'max:191',
            'company_city' => 'max:191',
            'company_zipcode' => 'max:10',
            'company_country_id' => 'exists:zones,id',

            'representative_status' => 'max:60',
            'representative_last_name' => 'max:60',
            'representative_first_name' => 'max:60',
            'representative_email' => 'email|nullable',
            'representative_phone' => 'max:25',

            'amount_searched' => 'numeric|nullable',
            'dilution' => 'nullable',
            'project_mbi' => 'nullable',
            'industrial_merge' => 'nullable',
            'fundraising_objective' => 'max:5000',
            'handover_objective' => 'max:5000',
            'development_stage_id' => 'exists:development_stages,id',
            'social_impact' => 'nullable',
            'valuation_expected_min' => 'integer|nullable',
            'valuation_expected_max' => 'integer|nullable',

            'company_creation_date' => 'date_format:d/m/Y|nullable',
            'events.*.name' => 'max:191|required_with:events.*.date,events.*.description',
            'events.*.date' => 'date_format:d/m/Y|nullable|required_with:events.*.name,events.*.description',
            'events.*.description' => 'max:500|required_with:events.*.name,events.*.date',

            'swot_strengths' => 'max:5000',
            'swot_weaknesses' => 'max:5000',
            'swot_opportunities' => 'max:5000',
            'swot_threats' => 'max:5000',

            'teaser_mail' => 'max:600',
            'teaser_welcome' => 'max:1500',

            'synthesis_misc' => 'max:5000',
         ];

         // Validate form
         $this->validate($request, $rules);

         // Update events
         $project->events()->delete();
         foreach( $request->input('events') as $event ) {
            if( $event['name'] ) {
               Event::create([
                  'name' => $event['name'],
                  'date' => Carbon::createFromFormat('d/m/Y', $event['date']),
                  'description' => $event['description'],
                  'project_id' => $project->id,
               ]);
            }
         }

         // Detach activity areas
         $project->activity_areas()->detach();

         // Attach activity areas
         $activityAreas = ActivityArea::all()->keyBy('id');
         $selectedAreas = $request->input('activity_areas') ? $request->input('activity_areas') : [];
         $areasToRemove = [];
         foreach( $selectedAreas as $id ) {
            $areasToRemove = array_merge($areasToRemove, $activityAreas[$id]->children()->pluck('id')->toArray());
            $selectedAreas = array_diff($selectedAreas, $areasToRemove);
         }

         $project->activity_areas()->attach($selectedAreas);

         // Detach Project zones
         $project->search_zones()->detach();

         // Attach Project Zones
         $projectZones = Zone::all()->keyBy('id');
         $selectedZones = $request->input('project_zones') ? $request->input('project_zones') : [];
         $zonesToRemove = [];
         foreach( $selectedZones as $id ) {
            $zonesToRemove = array_merge($zonesToRemove, $projectZones[$id]->children()->pluck('id')->toArray());
            $selectedZones = array_diff($selectedZones, $zonesToRemove);
         }

         $project->search_zones()->attach($selectedZones);

         // Create short name
         $shortName = '';
         $words = explode(' ', $request->input('code_name'));
         foreach( $words as $word ) {
            if( strlen($word) > 0 && preg_match('/[a-zA-Z0-9]/', $word[0]) ) {
               $shortName .= $word[0];
            }
         }

         // Set data
         $data = [
            'valuation_expected_min' => $request->input('valuation_expected_min'),
            'valuation_expected_max' => $request->input('valuation_expected_max'),
         ];

         $textFields = [
            'swot_strengths' => $request->input('swot_strengths'),
            'swot_weaknesses' => $request->input('swot_weaknesses'),
            'swot_opportunities' => $request->input('swot_opportunities'),
            'swot_threats' => $request->input('swot_threats'),

            'synthesis_misc' => $request->input('synthesis_misc'),
         ];

         if( !$project->locked ) {
            $data += [
               'code_name' => $request->input('code_name'),
               'short_name' => $shortName !== '' ? $shortName : 'P',

               'type' => $request->input('project_type'),

               'company_name' => $request->input('company_name'),
               'company_registration_number' => $request->input('company_registration_number'),
               'company_address_1' => $request->input('company_address_1'),
               'company_address_2' => $request->input('company_address_2'),
               'company_city' => $request->input('company_city'),
               'company_zipcode' => $request->input('company_zipcode'),
               'company_country_id' => $request->input('company_country_id'),
               'company_region_id' => $request->input('company_region_id'),

               'representative_status' => $request->input('representative_status'),
               'amount_searched' => $request->input('project_type') === 'fundraising' ? $request->input('amount_searched') : null,
               'dilution' => $request->input('project_type') === 'handover' && $request->input('dilution') !== '' ? $request->input('dilution') : null,

               'mbi' =>  $request->input('project_type') === 'handover' ? ($request->input('project_mbi') ? true : false) : null,
               'industrial_merge' => $request->input('project_type') === 'handover' ?  ($request->input('industrial_merge') ? true : false) : null,
               'development_stage_id' => $request->input('development_stage_id'),
               'social_impact' => intval($request->input('social_impact')),

               'company_creation_date' => $request->input('company_creation_date') ? Carbon::createFromFormat('d/m/Y', $request->input('company_creation_date')) : null,
            ];

            if( $user->type !== 'advisor' ) {
               $data += [
                  'representative_first_name' => $request->input('representative_first_name'),
                  'representative_last_name' => $request->input('representative_last_name'),
                  'representative_email' => $request->input('representative_email'),
                  'representative_phone' => $request->input('representative_phone'),
               ];
            }

            $textFields += [
               'fundraising_objective' => $request->input('project_type') === 'fundraising' ? $request->input('fundraising_objective') : null,
               'handover_objective' => $request->input('project_type') === 'handover' ?  $request->input('handover_objective') : null,

               'teaser_mail' => $request->input('teaser_mail'),
               'teaser_welcome' => $request->input('teaser_welcome'),
            ];
         }

         // Update project
         $project->update($data);
         $project->updateFields($textFields);
      }


      /*
      |--------------------------------------------------------------------------
      | Activities
      |--------------------------------------------------------------------------
      */
      if( $step === 'activities' ) {

         // Set validation rules
         $rules = [
            'activities_description_documents' => 'max:15000',
            'business_model_documents' => 'max:15000',
            'suppliers_documents' => 'max:15000',
            'customers_documents' => 'max:15000',
            'market_documents' => 'max:15000',
            'activities_misc_documents' => 'max:15000',

            'activity_description' => 'max:5000',

            'sales_channels' => 'max:5000',
            'client_types' => 'max:5000',
            'items_sold' => 'max:5000',
            'pricing_info' => 'max:5000',
            'particular_items' => 'max:5000',
            'average_basket' => 'numeric|nullable',
            'acquisition_cost' => 'numeric|nullable',

            'suppliers_type' => 'max:5000',
            'suppliers_name' => 'max:5000',
            'suppliers_evolution_analysis' => 'max:5000',
            'suppliers_relationship' => 'max:5000',
            'suppliers_certification' => 'max:5000',

            'customers_segmentation' => 'max:5000',
            'customers_names' => 'max:5000',
            'customers_analysis' => 'max:5000',
            'customers_relationship' => 'max:5000',
            'customers_recurrence' => 'max:5000',

            'target_market_presentation' => 'max:5000',

            'competitors.*.name' => "max:191|required_with:competitors.*.turnover,competitors.*.description",
            'competitors.*.turnover' => 'numeric|nullable|required_with:competitors.*.name,competitors.*.description',
            'competitors.*.description' => "max:5000|required_with:competitors.*.name,competitors.*.turnover",

            'barriers_to_entry' => 'max:5000',

            'activities_misc' => 'max:5000',
         ];

         // Validate form
         $this->validate($request, $rules);

         // Update branches
         $project->competitors()->delete();
         foreach( $request->input('competitors') as $competitor ) {
            if( $competitor['name'] ) {
               Competitor::create([
                  'name' => $competitor['name'],
                  'turnover' => $competitor['turnover'],
                  'description' => $competitor['description'],
                  'project_id' => $project->id,
               ]);
            }
         }

         // Set data
         $data = [
            'average_basket' => $request->input('average_basket'),
            'acquisition_cost' => $request->input('acquisition_cost'),
         ];

         $textFields = [
            'sales_channels' => $request->input('sales_channels'),
            'client_types' => $request->input('client_types'),
            'items_sold' => $request->input('items_sold'),
            'pricing_info' => $request->input('pricing_info'),
            'particular_items' => $request->input('particular_items'),

            'suppliers_type' => $request->input('suppliers_type'),
            'suppliers_name' => $request->input('suppliers_name'),
            'suppliers_evolution_analysis' => $request->input('suppliers_evolution_analysis'),
            'suppliers_relationship' => $request->input('suppliers_relationship'),
            'suppliers_certification' => $request->input('suppliers_certification'),

            'customers_segmentation' => $request->input('customers_segmentation'),
            'customers_names' => $request->input('customers_names'),
            'customers_analysis' => $request->input('customers_analysis'),
            'customers_relationship' => $request->input('customers_relationship'),
            'customers_recurrence' => $request->input('customers_recurrence'),

            'target_market_presentation' => $request->input('target_market_presentation'),
            'barriers_to_entry' => $request->input('barriers_to_entry'),

            'activities_misc' => $request->input('activities_misc'),
         ];

         if( !$project->locked ) {
            $textFields['activity_description'] = $request->input('activity_description');
         }

         // Update project
         $project->update($data);
         $project->updateFields($textFields);
      }

      /*
      |--------------------------------------------------------------------------
      | Structure
      |--------------------------------------------------------------------------
      */

      if( $step === 'structure' ) {

         // Set validation rules
         $rules = [
            'organization_structure_documents' => 'max:15000',
            'shareholding_details_documents' => 'max:15000',
            'functional_organization' => 'max:15000',
            'structure_misc_documents' => 'max:15000',

            'branches.*.name' => "max:191|required_with:branches.*.registration_number,branches.*.address_1,branches.*.zipcode,branches.*.city,branches.*.corporate_representative,branches.*.shareholding",
            'branches.*.registration_number' => "max:191|required_with:branches.*.name,branches.*.address_1,branches.*.zipcode,branches.*.city,branches.*.corporate_representative,branches.*.shareholding",
            'branches.*.address_1' => "max:191|required_with:branches.*.registration_number,branches.*.name,branches.*.zipcode,branches.*.city,branches.*.corporate_representative,branches.*.shareholding",
            'branches.*.address_2' => "max:191",
            'branches.*.zipcode' => "numeric|required_with:branches.*.registration_number,branches.*.address_1,branches.*.name,branches.*.city,branches.*.corporate_representative,branches.*.shareholding|nullable",
            'branches.*.city' => "max:191|required_with:branches.*.registration_number,branches.*.address_1,branches.*.zipcode,branches.*.name,branches.*.corporate_representative,branches.*.shareholding",
            'branches.*.region_id' => "exists:zones,id|nullable",
            'branches.*.country_id' => "exists:zones,id|required_with:branches.*.registration_number,branches.*.address_1,branches.*.zipcode,branches.*.city,branches.*.name,branches.*.corporate_representative,branches.*.shareholding",
            'branches.*.corporate_representative' => "max:191|required_with:branches.*.registration_number,branches.*.address_1,branches.*.zipcode,branches.*.city,branches.*.name,branches.*.shareholding",
            'branches.*.shareholding' => "max:5000|required_with:branches.*.registration_number,branches.*.address_1,branches.*.zipcode,branches.*.city,branches.*.corporate_representative,branches.*.name",

            'managers.*.name' => "max:191|required_with:managers.*.position,managers.*.description",
            'managers.*.position' => "max:191|required_with:managers.*.name,managers.*.description",
            'managers.*.description' => "max:5000|required_with:managers.*.position,managers.*.name",
            'managers.*.url' => "max:255|url|nullable",

            'transactions.*.date' => "date_format:d/m/Y|required_with:transactions.*.context|nullable",
            // 'transactions.*.amount' => "max:191|required_with:transactions.*.date|required_with:transactions.*.valuation|required_with:transactions.*.context",
            // 'transactions.*.valuation' => "max:191|required_with:transactions.*.date|required_with:transactions.*.amount|required_with:transactions.*.context",
            'transactions.*.context' => "max:5000|required_with:transactions.*.date",

            'corporate_structure_description' => 'max:5000',
            'organization_functioning' => 'max:5000',
            'organization_misc' => 'max:5000',

            'shareholders.*.name' => "nullable|required_with:shareholders.*.security_number_1,shareholders.*.security_type_1|max:191",
            'shareholders.*.security_type_1' => "nullable|required_with:shareholders.*.name|required_with:shareholders.*.security_number_1||max:191",
            'shareholders.*.security_number_1' => "required_with:shareholders.*.security_type_1, shareholders.*.name|numeric|nullable",
            'shareholders.*.security_type_2' => "nullable|max:191",
            'shareholders.*.security_number_2' =>  "nullable|numeric",
            'shareholders.*.security_type_3' => "nullable||max:191",
            'shareholders.*.security_number_3' => "nullable|numeric",
         ];

         // Validate form
         $this->validate($request, $rules);

         // Update branches
         $project->branches()->delete();
         foreach( $request->input('branches') as $branch ) {
            if( $branch['name'] ) {
               Branch::create([
                  'name' => $branch['name'],
                  'registration_number' => $branch['registration_number'],
                  'address_1' => $branch['address_1'],
                  'address_2' => $branch['address_2'],
                  'zipcode' => $branch['zipcode'],
                  'city' => $branch['city'],
                  'region_id' => $branch['region_id'],
                  'country_id' => $branch['country_id'],
                  'corporate_representative' => $branch['corporate_representative'],
                  'shareholding' => $branch['shareholding'],

                  'project_id' => $project->id,
               ]);
            }
         }

         // Update managers
         $project->managers()->delete();
         foreach( $request->managers as $manager ) {
            if( $manager['name'] ) {
               // Upload resume
               $resumeId = null;
               if( isset($manager['resume']) ) {
                  $resume = $project->uploadSingleDocument($manager['resume'], 'structure', 'managers_resume');
                  $resumeId = $resume->id;
               } elseif( isset($manager['old_resume']) ) {
                  $resumeId = $manager['old_resume'];
               }

               Manager::create([
                  'name' => $manager['name'],
                  'position' => $manager['position'],
                  'description' => $manager['description'],
                  'project_id' => $project->id,
                  'resume_id' => $resumeId,
                  'url' => $manager['url']
               ]);
            }
         }

         // Update transactions
         $project->transactions()->delete();
         foreach( $request->input('transactions') as $transaction ) {
            if( $transaction['date'] ) {
               Transaction::create([
                  'date' => Carbon::createFromFormat('d/m/Y', $transaction['date']),
                  'context' => $transaction['context'],
                  'project_id' => $project->id,
               ]);
            }
         }

         // Update shareholders
         $project->shareholders()->delete();
         foreach( $request->input('shareholders') as $shareholder ) {
            if( $shareholder['name'] ) {
               Shareholder::create([
                  'name' => $shareholder['name'],
                  'security_type_1' => $shareholder['security_type_1'],
                  'security_number_1' => $shareholder['security_number_1'],
                  'security_type_2' => $shareholder['security_type_2'],
                  'security_number_2' => $shareholder['security_number_2'],
                  'security_type_3' => $shareholder['security_type_3'],
                  'security_number_3' => $shareholder['security_number_3'],
                  'project_id' => $project->id,
               ]);
            }
         }

         // Set data
         $textFields = [
            'corporate_structure_description' => $request->input('corporate_structure_description'),
            'organization_misc' => $request->input('organization_misc'),
         ];

         if( !$project->locked ) {
            $textFields['organization_functioning'] = $request->input('organization_functioning');
         }

         // Update project
         $project->updateFields($textFields);
      }

      /*
      |--------------------------------------------------------------------------
      | Elements
      |--------------------------------------------------------------------------
      */
      if( $step === 'elements' ) {

         // Set validation rules
         if( $request->input('has_account') ) {
            $rules = [
               'account_m_1_documents' => 'max:15000',
               'account_m_2_documents' => 'max:15000',
               'account_m_3_documents' => 'max:15000',
            ];
         } else {
            $rules = [
               'last_report_documents' => 'max:15000',
            ];
         }

         $rules = [
            'elements_review_documents' => 'max:15000',
            'elements_turnover_documents' => 'max:15000',
            'elements_margin_documents' => 'max:15000',
            'elements_ebitda_documents' => 'max:15000',
            'elements_ebit_documents' => 'max:15000',
            'elements_net_profit_documents' => 'max:15000',
            'elements_misc_documents' => 'max:15000',

            'company_involved_in_transaction' => 'max:5000',
            'accounts_explanation' => 'max:5000',
            'has_account' => 'integer',
            'financial_organization' => 'max:5000',

            'wcr_description' => 'max:5000',
            'off_balance_sheet_items' => 'max:5000',
            'cash_and_debts' => 'max:5000',
            'balance_sheet_explanation' => 'max:5000',

            'turnover_description' => 'max:5000',
            'turnover_m_1' => 'numeric|nullable',
            'turnover_m_2' => 'numeric|nullable',
            'turnover_m_3' => 'numeric|nullable',
            'turnover_explanation' => 'max:5000',

            'gross_margin_description' => 'max:5000',
            'gross_margin_m_1' => 'numeric|nullable',
            'gross_margin_m_2' => 'numeric|nullable',
            'gross_margin_m_3' => 'numeric|nullable',
            'gross_margin_explanation' => 'max:5000',

            'ebitda_m_1' => 'numeric|nullable' . ($request->input('turnover_m_1') ? '|max:' . $request->input('turnover_m_1') : ''),
            'ebitda_m_2' => 'numeric|nullable' . ($request->input('turnover_m_2') ? '|max:' . $request->input('turnover_m_2') : ''),
            'ebitda_m_3' => 'numeric|nullable' . ($request->input('turnover_m_3') ? '|max:' . $request->input('turnover_m_3') : ''),
            'ebitda_explanation' => 'max:5000',

            'ebit_m_1' => 'numeric|nullable',
            'ebit_m_2' => 'numeric|nullable',
            'ebit_m_3' => 'numeric|nullable',
            'ebit_explanation' => 'max:5000',

            'net_profit_m_1' => 'numeric|nullable',
            'net_profit_m_2' => 'numeric|nullable',
            'net_profit_m_3' => 'numeric|nullable',
            'net_profit_explanation' => 'max:5000',

            'last_reporting_elements' => 'max:5000',
            'current_budget_confidence' => 'max:5000',
            'short_term_perspectives' => 'max:5000',
            'other_elements' => 'max:5000',

            'elements_misc' => 'max:5000',
         ];

         // Validate form
         $this->validate($request, $rules);



         // Set data
         $data = [
            'turnover_m_2' => $request->input('turnover_m_2'),
            'turnover_m_3' => $request->input('turnover_m_3'),

            'gross_margin_m_1' => $request->input('gross_margin_m_1'),
            'gross_margin_m_2' => $request->input('gross_margin_m_2'),
            'gross_margin_m_3' => $request->input('gross_margin_m_3'),

            'ebitda_m_2' => $request->input('ebitda_m_2'),
            'ebitda_m_3' => $request->input('ebitda_m_3'),

            'ebit_m_1' => $request->input('ebit_m_1'),
            'ebit_m_2' => $request->input('ebit_m_2'),
            'ebit_m_3' => $request->input('ebit_m_3'),

            'net_profit_m_1' => $request->input('net_profit_m_1'),
            'net_profit_m_2' => $request->input('net_profit_m_2'),
            'net_profit_m_3' => $request->input('net_profit_m_3'),
         ];

         $textFields = [
            'company_involved_in_transaction' => $request->input('company_involved_in_transaction'),

            'accounts_explanation' => $request->input('accounts_explanation'),
            'financial_organization' => $request->input('financial_organization'),

            'wcr_description' => $request->input('wcr_description'),
            'off_balance_sheet_items' => $request->input('off_balance_sheet_items'),
            'cash_and_debts' => $request->input('cash_and_debts'),
            'balance_sheet_explanation' => $request->input('balance_sheet_explanation'),

            'turnover_description' => $request->input('turnover_description'),
            'turnover_explanation' => $request->input('turnover_explanation'),

            'gross_margin_description' => $request->input('gross_margin_description'),
            'gross_margin_explanation' => $request->input('gross_margin_explanation'),

            'ebitda_explanation' => $request->input('ebitda_explanation'),

            'ebit_explanation' => $request->input('ebit_explanation'),

            'net_profit_explanation' => $request->input('net_profit_explanation'),

            'last_reporting_elements' => $request->input('last_reporting_elements'),
            'current_budget_confidence' => $request->input('current_budget_confidence'),
            'short_term_perspectives' => $request->input('short_term_perspectives'),
            'other_elements' => $request->input('other_elements'),

            'elements_misc' => $request->input('elements_misc'),
         ];

         if( !$project->locked ) {
            $data += [
               'has_account' => $request->input('has_account'),
               'turnover_m_1' => $request->input('turnover_m_1'),
               'ebitda_m_1' => $request->input('ebitda_m_1'),
            ];
         }

         // Update project
         $project->update($data);
         $project->updateFields($textFields);
      }

      /*
      |--------------------------------------------------------------------------
      | Business plan
      |--------------------------------------------------------------------------
      */
      if( $step === 'business_plan' ) {

         // Set validation rules
         $rules = [
            'business_plan_presentation' => 'max:15000',
            'business_plan_misc_documents' => 'max:15000',

            'development_plan_explanation' => 'max:5000',

            'turnover_p_0' => 'numeric|nullable',
            'turnover_p_1' => 'numeric|nullable',
            'turnover_p_2' => 'numeric|nullable',
            'turnover_p_3' => 'numeric|nullable',
            'turnover_p_4' => 'numeric|nullable',

            'gross_margin_p_0' => 'numeric|nullable',
            'gross_margin_p_1' => 'numeric|nullable',
            'gross_margin_p_2' => 'numeric|nullable',
            'gross_margin_p_3' => 'numeric|nullable',
            'gross_margin_p_4' => 'numeric|nullable',

            'ebitda_p_0' => 'numeric|nullable' . ($request->input('turnover_p_0') ? '|max:' . $request->input('turnover_p_0') : ''),
            'ebitda_p_1' => 'numeric|nullable' . ($request->input('turnover_p_1') ? '|max:' . $request->input('turnover_p_1') : ''),
            'ebitda_p_2' => 'numeric|nullable' . ($request->input('turnover_p_2') ? '|max:' . $request->input('turnover_p_2') : ''),
            'ebitda_p_3' => 'numeric|nullable' . ($request->input('turnover_p_3') ? '|max:' . $request->input('turnover_p_3') : ''),
            'ebitda_p_4' => 'numeric|nullable' . ($request->input('turnover_p_4') ? '|max:' . $request->input('turnover_p_4') : ''),

            'ebit_p_0' => 'numeric|nullable',
            'ebit_p_1' => 'numeric|nullable',
            'ebit_p_2' => 'numeric|nullable',
            'ebit_p_3' => 'numeric|nullable',
            'ebit_p_4' => 'numeric|nullable',

            'net_profit_p_0' => 'numeric|nullable',
            'net_profit_p_1' => 'numeric|nullable',
            'net_profit_p_2' => 'numeric|nullable',
            'net_profit_p_3' => 'numeric|nullable',
            'net_profit_p_4' => 'numeric|nullable',

            'sales_variation' => 'max:5000',

            'gross_margin_variation' => 'max:5000',
            'cost_variation' => 'max:5000',
            'use_of_funds' => 'max:5000',

            'business_plan_misc' => 'max:5000',
         ];

         // Validate form
         $this->validate($request, $rules);



         // Set data
         $data = [
            'turnover_p_1' => $request->input('turnover_p_1'),
            'turnover_p_2' => $request->input('turnover_p_2'),
            'turnover_p_3' => $request->input('turnover_p_3'),
            'turnover_p_4' => $request->input('turnover_p_4'),

            'gross_margin_p_0' => $request->input('gross_margin_p_0'),
            'gross_margin_p_1' => $request->input('gross_margin_p_1'),
            'gross_margin_p_2' => $request->input('gross_margin_p_2'),
            'gross_margin_p_3' => $request->input('gross_margin_p_3'),
            'gross_margin_p_4' => $request->input('gross_margin_p_4'),

            'ebitda_p_1' => $request->input('ebitda_p_1'),
            'ebitda_p_2' => $request->input('ebitda_p_2'),
            'ebitda_p_3' => $request->input('ebitda_p_3'),
            'ebitda_p_4' => $request->input('ebitda_p_4'),

            'ebit_p_1' => $request->input('ebit_p_1'),
            'ebit_p_2' => $request->input('ebit_p_2'),
            'ebit_p_3' => $request->input('ebit_p_3'),
            'ebit_p_4' => $request->input('ebit_p_4'),

            'net_profit_p_0' => $request->input('net_profit_p_0'),
            'net_profit_p_1' => $request->input('net_profit_p_1'),
            'net_profit_p_2' => $request->input('net_profit_p_2'),
            'net_profit_p_3' => $request->input('net_profit_p_3'),
            'net_profit_p_4' => $request->input('net_profit_p_4'),
         ];

         $textFields = [
            'business_plan_misc' => $request->input('business_plan_misc'),
         ];

         // Update project
         if( !$project->locked ) {
            $data += [
               'turnover_p_0' => $request->input('turnover_p_0'),
               'ebitda_p_0' => $request->input('ebitda_p_0'),
               'ebit_p_0' => $request->input('ebit_p_0'),
            ];

            $textFields += [
               'development_plan_explanation' => $request->input('development_plan_explanation'),
               'sales_variation' => $request->input('sales_variation'),
               'gross_margin_variation' => $request->input('gross_margin_variation'),
               'cost_variation' => $request->input('cost_variation'),
               'use_of_funds' => $request->input('use_of_funds'),
            ];
         }

         // Update project
         $project->update($data);
         $project->updateFields($textFields);
      }

      /*
      |--------------------------------------------------------------------------
      | Agreements
      |--------------------------------------------------------------------------
      */
      if( $step === 'agreements' ) {
         // Set validation rules
         $rules = [];

         // Validate form
         $this->validate($request, $rules);

         // Set data
         if( !$project->locked ) {
            $data = ['need_nda' => $request->input('need_nda')];
            $textFields = ['nda' => $request->input('nda') !== '' ? $request->input('nda') : null];

            $project->update($data);
            $project->updateFields($textFields);
         }
      }

      if( $request->input('redirect_to') ) {
         return redirect($request->input('redirect_to'));
      }

      // Go back to form and display success message
      return redirect()->back()->with('success_message', trans('dashboard.project.update_success'));
   }


   /**
   * Update steering
   *
   * @return Redirect
   */
   public function updateSteering(Request $request, $id) {
      $project = Project::find($id);

      if( !$project->locked ) {
         $rules = [
            'step1_duration' => 'integer|min:20|max:120',
            'step2_duration' => 'integer|min:2|max:30',
            'step3_duration' => 'integer|min:20|max:120',
            'step4_duration' => 'integer|min:20|max:120',
         ];
      } else {
         // Values of previous steps must not change
         for( $i=1; $i<$project->current_step; $i++ ) {
            $stepAttr = 'step'. $i .'_duration';
            $rules[$stepAttr] = 'in:'. $project->$stepAttr;
         }

         // Value of current step can only be increased
         $stepAttr = 'step'. $project->current_step .'_duration';
         $rules[$stepAttr] = 'integer|min:'. $project->$stepAttr .'|max:60';

         // Values of next steps can change
         if( $project->current_step < 4 ) {
            for( $i=$project->current_step+1; $i<=4; $i++ ) {
               $rules['step'. $i .'_duration'] = 'integer|min:1|max:60';
            }
         }
      }

      // Validate form
      $this->validate($request, $rules);

      // Update project
      $project->update([
         'step1_duration' => $request->input('step1_duration'),
         'step2_duration' => $request->input('step2_duration'),
         'step3_duration' => $request->input('step3_duration'),
         'step4_duration' => $request->input('step4_duration'),
      ]);

      // Go back to form and display success message
      return redirect()->back()->with('success_message', trans('dashboard.steering.update_success'));
   }


   /**
   * Add new guest
   *
   * @return Redirect
   */
   public function addGuest(Request $request, $id) {
      $project = Project::find($id);

      $this->validate($request, [
         'user_first_name' => 'required|max:60',
         'user_last_name' => 'required|max:60',
         'user_email' => 'required|email',
         'user_phone_number' => 'max:25',
      ]);

      $user = User::where('email', $request->input('user_email'))->first();

      if( $user ) {
         if( $user->type === 'investor' ) {
            return redirect()->back()->with('error_message', trans('dashboard.guests.error_investor', ['email' => $user->email]));
         } elseif( $project->guests->contains($user->id) ) {
            return redirect()->back()->with('success_message', trans('dashboard.guests.user_already_attached'));
         }

         Mail::to($user)->send(new ProjectInvitation($user, $project, Auth::user()->full_name));
      } else {
         // Generate random password
         $password = str_random(16);

         $user = User::create([
            'type' => 'guest',
            'first_name' => $request->input('user_first_name'),
            'last_name' => $request->input('user_last_name'),
            'email' => $request->input('user_email'),
            'password' => Hash::make($password),
            'phone_mobile' => $request->input('user_phone_number'),
            'confirmed' => true,
         ]);

         Mail::to($user)->send(new ProjectAccountCreation($user, $project, $password, Auth::user()->full_name));
      }

      // Attach user to the project
      $project->guests()->attach($user->id, ['admin' => intval($request->input('user_role'))]);

      return redirect()->back()->with('success_message', trans('dashboard.guests.guest_added', ['user_name' => $user->full_name]));
   }

   /**
   * Delete guest from project
   *
   * @return Redirect
   */
   public function deleteGuest(Request $request, $projectId, $userId) {
      $project = Project::find($projectId);
      $user = User::find($userId);

      // Send an email to the user
      Mail::to($user)->send(new ProjectGuestRemoval($user, $project));

      // Detach user from the project
      $project->guests()->detach($userId);

      return redirect()->back()->with('success_message', trans('dashboard.guests.guest_removed', ['user_name' => $user->full_name]));
   }

   /**
   * Switch guest role
   *
   * @return Response
   */
   public function switchGuestRole(Request $request, $projectId, $userId) {
      $project = Project::find($projectId);
      $user = User::find($userId);

      $project->guests()->updateExistingPivot($userId, ['admin' => $request->input('admin') === 'true' ? 1 : 0]);

      return response()->json(['error' => false]);
   }


   /**
   * Request project validation
   *
   * @return Redirect
   */
   public function requestValidation(Request $request, $id) {
      $project = Project::find($id);

      $project->update(['locked' => true]);

      Mail::to(env('SUPPORT_EMAIL'))->send(new ProjectValidationRequest($project));

      return redirect()->back()->with('success_message', trans('dashboard.overview.validation_request_success'));
   }


   /**
   * Lock project
   *
   * @return View
   */
   public function lock($id) {
      $project = Project::find($id);

      // Lock project and set start date
      $project->update([
         'locked' => 1,
         'start_date' => Carbon::today()
      ]);

      return redirect()->route('project_matching_results', ['id' => $project->id]);
   }


   /**
   * Unlock project
   *
   * @return View
   */
   public function unlock($id) {
      $project = Project::find($id);

      $project->update([
         'locked' => 0,
         'confirmed' => 0,
      ]);

      return redirect()->route('project_edit', ['id' => $project->id, 'step' => 'synthesis']);
   }


   /**
   * Generate licence (in case there is no licence attached to a project)
   *
   * @return Redirect
   */
   public function generateLicence(Request $request, $id) {
      $project = Project::find($id);

      $this->validate($request, [
         'signatory_phone' => 'max:25|required',
      ]);

      $user = Auth::user();
      $user->update(['phone_mobile' => $request->input('signatory_phone')]);

      $companyAddress = $user->company->address_1 . ', ' . $user->company->zipcode . ' ' . $user->company->city;

      // Generate licence document
      $licence = $project->generateLicence($user, $user->company->name, $user->company->registration_number, $companyAddress);

      return redirect()->back()->with('popup', trans('popups.licence.generated', ['email' => $user->email]));
   }


   /**
   * Send licence
   *
   * @return Redirect
   */
   public function sendLicence(Request $request, $id) {
      $project = Project::find($id);
      $signatory = $project->licence->signatories[0];

      Mail::to($signatory)->send(new Signature($project, $signatory));

      return redirect()->back()->with('popup', trans('popups.licence.resent', ['email' => $signatory->email]));
   }

   /**
   * Download project
   *
   * @return Redirect
   */
   public function download($id) {
      $project = Project::find($id);

      // Download zip
      return $project->download();
   }


   /**
   * Annex documents
   *
   * @return Redirect
   */
   public function addAnnexDocuments(Request $request, $id) {
      $project = Project::find($id);

      $this->validate($request, [
         'annex_document' => 'required|max:15000|mimes:pdf,xls,xlsx,ppt,pptx,doc,docx',
         'annex_section' => 'required',
         'annex_comment' => 'max:5000',
      ]);

      $project->updated_at = Carbon::now();
      $project->save();

      if( $request->annex_document ) {
         $document = $project->uploadSingleDocument($request->file('annex_document'), $request->input('annex_section'), $request->input('annex_section').'_annex', trans('dashboard.project.' . $request->input('annex_section')).'_'.$request->annex_document->getClientOriginalName());
      }

      DocumentComment::create([
         'document_id' => $document->id,
         'comment' => $request->input('annex_comment'),
      ]);

      foreach( $project->matches as $match ) {
         MatchEvent::create([
            'match_id' => $match->id,
            'description' => 'new_annex',
         ]);
      }

      return redirect()->back()->with('success_message', trans('dashboard.overview.validation_request_success'));
   }


   /**
   * Cancel project
   *
   * @return Redirect
   */
   public function cancelProject(Request $request, $id) {
      $project = Project::find($id);

      $this->validate($request, [
         'cancel_comment' => 'max:2000'
      ]);

      $project->update([
         'stopped' => 1,
         'cancel_comment' => $request->input('cancel_comment'),
         'cancel_purpose' => $request->input('cancel_purpose')
      ]);

      foreach ($project->matches as $match) {
         $match->update([
            'ended_at' => Carbon::now(),
         ]);

         MatchEvent::create([
            'match_id' => $match->id,
            'description' => 'project_ended',
         ]);
      }
      return redirect()->route('projects');
   }
}
