<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

use App\Document;
use App\TextField;
use App\User;

use Auth;
use Storage;
use PDF;
use Zipper;
use LaravelLocalization;

class Project extends Model {

   use Sortable;

   protected $table = 'projects';
   protected $fillable = ['id', 'initiator_id', 'company_id', 'code_name', 'short_name', 'type', 'mbi', 'industrial_merge', 'currency', 'company_name', 'company_registration_number', 'company_address_1', 'company_address_2', 'company_zipcode', 'company_city', 'company_country_id', 'company_region_id', 'representative_id', 'representative_status', 'representative_last_name', 'representative_first_name', 'representative_email', 'representative_phone', 'amount_searched', 'dilution', 'development_stage_id', 'valuation_expected_min', 'valuation_expected_max', 'social_impact', 'company_creation_date', 'average_basket', 'acquisition_cost', 'has_account', 'turnover_m_1', 'turnover_m_2', 'turnover_m_3', 'gross_margin_m_1', 'gross_margin_m_2', 'gross_margin_m_3', 'ebitda_m_1', 'ebitda_m_2', 'ebitda_m_3', 'ebit_m_1', 'ebit_m_2', 'ebit_m_3', 'net_profit_m_1', 'net_profit_m_2', 'net_profit_m_3', 'turnover_p_0', 'turnover_p_1', 'turnover_p_2', 'turnover_p_3', 'turnover_p_4', 'gross_margin_p_0', 'gross_margin_p_1', 'gross_margin_p_2', 'gross_margin_p_3', 'gross_margin_p_4', 'ebitda_p_0', 'ebitda_p_1', 'ebitda_p_2', 'ebitda_p_3', 'ebitda_p_4', 'ebit_p_0', 'ebit_p_1', 'ebit_p_2', 'ebit_p_3', 'ebit_p_4', 'net_profit_p_0', 'net_profit_p_1', 'net_profit_p_2', 'net_profit_p_3', 'net_profit_p_4', 'need_nda', 'licence_id', 'signatory_id', 'step1_duration', 'step2_duration', 'step3_duration', 'step4_duration', 'confirmed', 'locked', 'canceled', 'stopped', 'cancel_comment', 'cancel_purpose', 'comment_equiteasy', 'export_uri', 'export_date', 'start_date'];

   public $incrementing = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */

   public function text_fields() {
      return $this->hasMany('App\TextField', 'project_id');
   }

   public function initiator() {
      return $this->belongsTo('App\User', 'initiator_id');
   }

   public function company() {
      return $this->belongsTo('App\Company', 'company_id');
   }

   public function representative() {
      return $this->belongsTo('App\User', 'representative_id');
   }

   public function guests() {
      return $this->belongsToMany('App\User', 'user_project', 'project_id', 'user_id')->withPivot('admin');
   }

   public function signatory() {
      return $this->belongsTo('App\User', 'signatory_id');
   }

   public function licence() {
      return $this->belongsTo('App\Document', 'licence_id');
   }

   public function company_country() {
      return $this->belongsTo('App\Zone', 'company_country_id');
   }

   public function company_region() {
      return $this->belongsTo('App\Zone', 'company_region_id');
   }

   public function search_zones() {
      return $this->belongsToMany('App\Zone', 'project_zone', 'project_id', 'zone_id');
   }

   public function development_stage() {
      return $this->belongsTo('App\DevelopmentStage', 'development_stage_id');
   }

   public function events() {
      return $this->hasMany('App\Event', 'project_id')->orderBy('date', 'desc');
   }

   public function activity_areas() {
      return $this->belongsToMany('App\ActivityArea', 'project_activity_area', 'project_id', 'activity_area_id');
   }

   public function branches() {
      return $this->hasMany('App\Branch', 'project_id');
   }

   public function competitors() {
      return $this->hasMany('App\Competitor', 'project_id');
   }

   public function managers() {
      return $this->hasMany('App\Manager', 'project_id');
   }

   public function transactions() {
      return $this->hasMany('App\Transaction', 'project_id')->orderBy('date', 'desc');
   }

   public function shareholders() {
      return $this->hasMany('App\Shareholder', 'project_id');
   }

   public function documents() {
      return $this->hasMany('App\Document', 'project_id');
   }

   public function matches() {
      return $this->hasMany('App\Match', 'project_id')->orderBy('score', 'desc');
   }

   public function export() {
      return $this->belongsTo('App\ProjectExport', 'project_id');
   }

   public function loi_requirements() {
      return $this->belongsToMany('App\LoiRequirement', 'project_loi_requirement', 'project_id', 'loi_requirement_id');
   }

   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getNameAttribute() {
      return $this->code_name ? $this->code_name : trans('dashboard.project.untitled');
   }

   public function getLocationAttribute() {
      return $this->company_region ? $this->company_region : $this->company_country;
   }

   public function getDurationAttribute() {
      return $this->step1_duration + $this->step2_duration + $this->step3_duration + $this->step4_duration;
   }

   public function getStartDateAttribute($date) {
      return $date ? $date : Carbon::today();
   }

   public function getEndDateAttribute() {
      $startDate = Carbon::parse($this->start_date);

      return $startDate->addDays($this->duration);
   }

   public function getSelectedMatchesAttribute() {
      return $this->matches->where('selected', 1);
   }

   public function getPendingMatchesAttribute() {
      return $this->matches->where('selected', 0);
   }

   public function getCompletionAttribute() {
      $startDate = Carbon::parse($this->start_date);
      $today = Carbon::today();

      return $startDate->diffInDays($today) / $this->duration * 100;
   }

   public function getCurrentStepAttribute() {
      $startDate = Carbon::parse($this->start_date);
      $today = Carbon::today();

      if( $startDate->addDays($this->step1_duration)->gte($today) ) {
         return 1;
      }
      if( $startDate->addDays($this->step2_duration)->gte($today) ) {
         return 2;
      }
      if( $startDate->addDays($this->step3_duration)->gte($today) ) {
         return 3;
      }
      if( $startDate->addDays($this->step4_duration)->gte($today) ) {
         return 4;
      }

      return 4;
   }

   public function getCurrencySymbolAttribute() {
      if( $this->currency === 'usd' ) {
         return '$';
      } elseif( $this->currency === 'gbp' ) {
         return '£';
      }

      return '€';
   }

   public function getCreationYearAttribute() {
      return Carbon::parse($this->created_at)->year;
   }

   public function getStatusAttribute() {
      if( $this->canceled ) {
         return 'canceled';
      }
      if( $this->locked ) {
         if( $this->confirmed ) {
            if( $this->getOriginal('start_date') ) {
               return 'running';
            } else {
               return 'confirmed';
            }
         } else {
            return 'awaiting_validation';
         }
      } else {
         return 'pending';
      }
   }

   // List of users to notify
   public function getUsersAttribute() {
      return collect([$this->initiator])->merge($this->guests);
   }

   // List of admins to notify
   public function getAdminsAttribute() {
      return collect([$this->initiator])->merge($this->guests()->wherePivot('admin', 1)->get());
   }


   /*
   |--------------------------------------------------------------------------
   | Getters
   |--------------------------------------------------------------------------
   */

   // Get text field by name
   public function getField($field) {
      $field = $this->text_fields->where('field', $field)->first();

      return $field ? $field->value : null;
   }

   // Get mandatory fields
   public function getMandatoryFields() {
      $fields = [];

      $fields['synthesis'] = ['code_name', 'company_name', 'company_registration_number', 'company_address_1', 'company_city', 'company_zipcode', 'company_country_id', 'representative_status', 'development_stage_id', 'currency', 'social_impact', 'teaser_mail', 'teaser_welcome', 'company_creation_date'];
      $fields['activities'] = ['activity_description'];
      $fields['structure'] = ['organization_functioning'];
      $fields['elements'] = ['turnover_m_1', 'ebitda_m_1'];
      $fields['business_plan'] = ['development_plan_explanation', 'turnover_p_0', 'ebitda_p_0', 'ebit_p_0', 'sales_variation', 'gross_margin_variation', 'cost_variation', 'use_of_funds'];
      $fields['agreements'] = [];

      if( !$this->representative ) {
         $fields['synthesis'][] = 'representative_last_name';
         $fields['synthesis'][] = 'representative_first_name';
         $fields['synthesis'][] = 'representative_email';
         $fields['synthesis'][] = 'representative_phone';
      }

      if( $this->type == 'fundraising' ) {
         $fields['synthesis'][] = 'amount_searched';
         $fields['synthesis'][] = 'fundraising_objective';
      } else {
         $fields['synthesis'][] = 'handover_objective';
      }

      if( $this->need_nda ) {
         $fields['agreements'][] = 'nda';
      }

      return $fields;
   }

   // Get form completion
   public function getFormCompletion() {
      $missingFields = [];

      // Get mandatory fields
      $mandatoryFields = $this->getMandatoryFields();

      $size = 0;
      $completion = 0;

      // Check fields
      foreach( $mandatoryFields as $section => $fields ) {
         foreach( $fields as $field ) {
            if( $this->$field !== null || $this->getField($field) !== null ) {
               $completion++;
            } else {
               if( !array_key_exists($section, $missingFields) ) {
                  $missingFields[$section] = [];
               }
               $missingFields[$section][] = $field;
            }

            $size++;
         }
      }

      // Check account documents
      if( $this->has_account ) {
         if( $this->getDocuments('account_m_1_documents')->count() > 0 ) {
            $completion++;
         } else {
            $missingFields['elements'][] = 'account_m_1';
         }
      } else {
         if( $this->getDocuments('last_report_documents')->count() > 0 ) {
            $completion++;
         } else {
            $missingFields['elements'][] = 'last_report';
         }
      }

      if( $this->getDocument('kbis') ) {
         $completion++;
      } else {
         $missingFields['synthesis'][] = 'kbis';
      }

      // Check activity areas
      if( $this->activity_areas->count() > 0 ) {
         $completion++;
      } else {
         $missingFields['synthesis'][] = 'activity_areas';
      }

      // Check shareholders
      if( $this->shareholders->count() > 0 ) {
         $completion++;
      } else {
         $missingFields['structure'][] = 'shareholders';
      }

      // Increment size
      $size += 4;

      return ['amount' => round($completion / $size * 100), 'missing' => $missingFields];
   }

   // Check if durations have been set
   public function hasDurations() {
      return $this->step1_duration && $this->step2_duration && $this->step3_duration && $this->step4_duration;
   }

   // Check if licence has been signed
   public function hasSignedLicence() {
      return $this->licence && $this->licence->signed;
   }

   // Get all documents for a specific section
   public function getDocuments($section) {
      $documents = $this->documents->where('section', $section);

      return $documents ? $documents : [];
   }

   // Get a single document for a specific section
   public function getDocument($name) {
      return $this->documents->where('section', $name)->first();
   }

   // Get remaining time of current step
   public function getCurrentStepRemainingTime() {
      $currentStep = $this->current_step;
      $startDate = Carbon::parse($this->start_date);
      $endDate = $startDate->copy();

      for( $i=1; $i<=$currentStep; $i++ ) {
         $stepDuration = 'step'. $i .'_duration';
         $endDate->addDays($this->$stepDuration);
      }

      return Carbon::today()->diffInDays($endDate);
   }


   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   // Generate licence document
   public function generateLicence(User $user, $companyName, $companyRegistrationNumber, $companyAddress) {
      $pdf = PDF::loadView('documents.licence', ['user' => $user, 'companyName' => $companyName, 'companyRegistrationNumber' => $companyRegistrationNumber, 'companyAddress' => $companyAddress])->setPaper('a4');
      $fileName = 'licence.pdf';
      $uri = $this->id . '/' . $fileName;

      // Save file
      Storage::put($uri, $pdf->output());

      $size = Storage::size($uri);

      // Save document
      $document = Document::create([
         'project_id' => $this->id,
         'name' => $fileName,
         'uri' => $uri,
         'size' => $size,
         'section' => 'licence'
      ]);

      // Init signature
      $users = collect([$user]);
      $options = [
         [
            'page' => '2',
            'position' => '298,159,436,220',
         ]
      ];

      if( $document->initSignature($users, $options) ) {
         // Update project
         $this->update(['licence_id' => $document->id]);

         return true;
      }

      return false;
   }

   // Update text fields
   public function updateFields($array) {
      foreach( $array as $field => $value ) {
         $textField = TextField::where(['project_id' => $this->id, 'field' => $field])->first();

         if( $textField ) {
            $textField->update([
               'value' => $value
            ]);
         } else {
            TextField::create([
               'project_id' => $this->id,
               'field' => $field,
               'value' => $value
            ]);
         }
      }
   }

   // Upload one single document
   public function uploadSingleDocument($file, $directory, $section, $name = null) {
      if( $file ) {
         $uri = $file->store($this->id . '/' . $directory);

         $document = Document::create([
            'project_id' => $this->id,
            'name' => $name ?: $file->getClientOriginalName(),
            'uri' => $uri,
            'size' => $file->getClientSize(),
            'section' => $section,
            'uploaded_by' => Auth::id()
         ]);

         return $document;
      }

      return false;
   }

   // Download project in a zip file
   public function download() {
      LaravelLocalization::setLocale('fr');

      $zipName = str_slug($this->code_name).'.zip';

      // If the project has already been zipped, check the export date
      if( $this->export_uri && $this->export_date && Carbon::parse($this->export_date)->gt(Carbon::parse($this->updated_at)) ) {
         $zipUri = $this->export_uri;
      } else {
         $zipUri = $this->id .'/'. $zipName;

         $tmpPath = storage_path('app/tmp/' . $zipUri);

         // Create zip
         $zipper = Zipper::make($tmpPath);

         // Generate project PDF
         $pdf = PDF::loadView('front.dashboard.project.export.pdf', ['project' => $this]);

         // Add PDF to zip
         $zipper->addString(str_slug($this->code_name).'.pdf', $pdf->inline());

         // Get documents
         $documents = $this->documents->keyBy('uri');

         // Get folders to copy from S3
         $foldersToCopy = ['synthesis', 'activities', 'structure', 'elements', 'business_plan'];
         $foldersFrench = [
            'synthesis' => 'synthese',
            'activities' => 'activites',
            'structure' => 'structure_organisation',
            'elements' => 'elements_chiffres',
            'business_plan' => 'business_plan',
         ];

         foreach( $foldersToCopy as $folder ) {
            $files = Storage::allFiles($this->id . '/' . $folder);

            $i = 1;
            foreach( $files as $file ) {
               $fileName = $i . '_' . $documents[$file]->name;

               // Put file in zip
               $zipper->folder($foldersFrench[$folder])->addString($fileName, Storage::get($file));
               $i++;
            }
         }

         $zipper->close();

         // Put zip file to S3
         $zipContent = Storage::disk('local')->get('tmp/' . $zipUri);
         Storage::put($zipUri, $zipContent);

         // Remove file from local storage
         Storage::disk('local')->delete('tmp/' . $zipUri);

         // Disable timestamps update
         $this->timestamps = false;

         // Update export
         $this->update([
            'export_uri' => $zipUri,
            'export_date' => Carbon::now(),
         ]);
      }

      // Download file
      return response()->stream(function() use($zipUri) {
         $stream = Storage::readStream($zipUri);
         fpassthru($stream);
         if( is_resource($stream) ) {
            fclose($stream);
         }
      }, 200, [
         "Content-Type" => Storage::mimeType($zipUri),
         "Content-Length" => Storage::size($zipUri),
         "Content-disposition" => "inline; filename=\"" . $zipName. "\"",
      ]);
   }

}
