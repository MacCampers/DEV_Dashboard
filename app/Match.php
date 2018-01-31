<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Document;

use Auth;
use PDF;
use Zipper;
use Storage;

class Match extends Model {

   protected $table = 'matches';
   protected $fillable = ['project_id', 'matchable_id', 'matchable_type', 'score', 'selected', 'viewed', 'accepted', 'declined', 'nda_text', 'nda_accepted_company', 'nda_accepted_strategy', 'nda_bypass', 'nda_id', 'loi_id', 'loi_accepted', 'binding_offer_id', 'binding_offer_accepted', 'strategy_signatory_id', 'ended_at', 'ended_by', 'end_comment', 'last_email'];

   public $incrementing = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function project() {
      return $this->belongsTo('App\Project', 'project_id');
   }

   public function matchable() {
      return $this->morphTo();
   }

   public function strategy_signatory() {
      return $this->belongsTo('App\User', 'strategy_signatory_id');
   }

   public function messages() {
      return $this->hasMany('App\Message', 'match_id');
   }

   public function events() {
      return $this->hasMany('App\MatchEvent', 'match_id')->orderBy('created_at', 'desc')->take(10);
   }

   public function nda() {
      return $this->belongsTo('App\Document', 'nda_id');
   }

   public function loi() {
      return $this->belongsTo('App\Document', 'loi_id');
   }

   public function binding_offer() {
      return $this->belongsTo('App\Document', 'binding_offer_id');
   }

   public function offers() {
      return $this->hasMany('App\Offer', 'match_id')->orderBy('id', 'desc');
   }


   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   // Get match status
   public function getStatusAttribute() {
      if( !$this->viewed && !$this->declined ) {
         return 'not_viewed';
      } elseif( !$this->accepted && !$this->declined ) {
         return 'not_accepted';
      } elseif( $this->declined ) {
         return 'declined';
      } elseif( $this->ended_at ) {
         return 'ended';
      } elseif( !$this->nda_bypass && !$this->hasSignedNda() ) {
         if( $this->nda ) {
            return 'nda_signature';
         }
         return 'nda_validation';
      } elseif( $this->canUploadLoi() ) {
         if( $this->loi && $this->getCurrentOffer('loi')->declined ) {
            return 'loi_declined';
         } elseif( $this->loi ) {
            return 'loi_uploaded';
         }
         return 'loi_pending';
      } elseif( $this->canUploadBindingOffer() ) {
         if( $this->binding_offer && $this->getCurrentOffer('binding_offer')->declined ) {
            return 'binding_offer_declined';
         } elseif( $this->binding_offer ) {
            return 'binding_offer_uploaded';
         }
         return 'binding_offer_pending';
      } elseif( $this->binding_offer_accepted ) {
         return 'finished';
      }

      return 'ended';
   }

   public function getCompletionAttribute() {
      if( $this->binding_offer_accepted ) {
         return 100;
      }

      $completion = $this->project->completion;

      if( $this->loi_accepted ) {
         $step2 = ($this->project->step1_duration + $this->project->step2_duration) / $this->project->duration * 100;

         if( $step2 > $completion ) {
            return $step2;
         }
      }

      return $completion;
   }


   /*
   |--------------------------------------------------------------------------
   | Getters
   |--------------------------------------------------------------------------
   */

   // Get current offer by type
   public function getCurrentOffer($type) {
      return $this->$type ? $this->offers->where('document_id', $this->$type->id)->first() : null;
   }

   // Get offers history by type
   public function getOffersHistory($type) {
      return $this->offers->where('type', $type);
   }

   // Get participants
   public function getParticipants() {
      if( $this->matchable_type === 'strategy' ) {
         return $this->matchable->users;
      } else {
         return collect([$this->matchable]);
      }
   }


   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   // Check if the match hasn't been stopped by the project manager
   public function isRunning() {
      return $this->ended_at === null;
   }

   // Check if the match is still viewable by the strategy
   public function isViewable() {
      return $this->isRunning() || !$this->isRunning() && Carbon::parse($this->ended_at)->addDays(2)->gt(Carbon::now());
   }

   // Check if NDA is signed or bypassed (or the project does not need any NDA)
   public function hasSignedNda() {
      if( !$this->project->need_nda || $this->nda && $this->nda->signed || $this->nda_bypass ) {
         return true;
      }

      return false;
   }

   // Check if the NDA must be edited (first time only)
   public function mustEditNda() {
      return $this->isRunning() && !$this->nda_accepted_company && !$this->nda_accepted_strategy;
   }

   // Check if an LOI can be uploaded
   public function canUploadLoi() {
      return ($this->hasSignedNda() || $this->nda_bypass) && $this->isRunning() && !$this->loi_accepted;
   }

   // Check if a binding offer can be uploaded
   public function canUploadBindingOffer() {
      return ($this->hasSignedNda() || $this->nda_bypass) && $this->isRunning() && $this->loi_accepted && !$this->binding_offer_accepted;
   }

   // Check if the matching email can be sent again
   public function canResendEmail() {
      return $this->selected && !$this->viewed && Carbon::parse($this->last_email)->lt(Carbon::now()->subDays(2));
   }

   // Upload offer
   public function uploadOffer($file, $type, $comment = null) {
      $fileName = date('YmdHis') . '_' . str_slug($this->matchable->full_name) . '_' . $type . '.pdf';

      if( $file ) {
         $uri = $file->storeAs($this->project_id . '/' . $this->id . '/offers', $fileName);

         $document = Document::create([
            'project_id' => $this->project_id,
            'name' => $fileName,
            'uri' => $uri,
            'size' => $file->getClientSize(),
            'section' => $type,
            'uploaded_by' => Auth::id(),
         ]);

         Offer::create([
            'match_id' => $this->id,
            'document_id' => $document->id,
            'type' => $type,
            'owner_comment' => $comment,
         ]);

         $this->update([
            $type . '_id' => $document->id
         ]);

         return $document;
      }

      return false;
   }

   // Generate zip
   public function generate() {
      $zipName = str_slug($this->project->code_name).'.zip';
      $zipUri = $this->project_id .'/'. $this->id .'/'. $zipName;

      $tmpPath = storage_path('app/tmp/' . $zipUri);

      // Create zip
      $zipper = Zipper::make($tmpPath);

      // Generate project PDF
      $pdf = PDF::loadView('front.dashboard.project.export.pdf', ['project' => $this->project]);

      // Add PDF to zip
      $zipper->addString('project.pdf', $pdf->inline());

      // Get documents
      $documents = $this->project->documents->keyBy('uri');

      // Get folders to copy from S3
      $foldersToCopy = ['synthesis', 'activities', 'structure', 'elements', 'business_plan'];

      foreach( $foldersToCopy as $folder ) {
         $files = Storage::allFiles($this->project_id . '/' . $folder);

         $i = 1;
         foreach( $files as $file ) {
            $fileName = $i . '_' . $documents[$file]->name;

            // Put file in zip
            $zipper->folder($folder)->addString($fileName, Storage::get($file));
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

   // Download zip
   public function download() {
      // If there is no zip file for this match, download the project's zip
      if( !$this->export_uri ) {
         return $this->project->download();
      }

      // Otherwise, download the zip that has been generated for this match
      $zipUri = $this->export_uri;

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
