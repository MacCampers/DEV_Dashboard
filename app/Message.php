<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Auth;

class Message extends Model {

   protected $table = 'messages';
   protected $fillable = ['match_id', 'sender', 'user_id', 'content', 'read'];
   public $with = ['user', 'attachments'];

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */

   public function match() {
      return $this->belongsTo('App\Match', 'match_id');
   }

   public function user() {
      return $this->belongsTo('App\User', 'user_id');
   }

   public function attachments() {
      return $this->belongsToMany('App\Document', 'message_attachments', 'message_id', 'document_id');
   }

   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */
   public function getDateTimeAttribute() {
      $dateTime = Carbon::parse($this->created_at);

      return $dateTime->isToday() ? $dateTime->format('H:i') : $dateTime->format('d/m/Y - H:i');
   }

   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   // Upload attachments
   public function uploadAttachments($input) {
      if( sizeof($input) > 0 ) {
         foreach( $input as $attachment ) {
            $uri = $attachment->store($this->match->project_id . '/' . $this->match_id . '/attachments');

            $document = Document::create([
               'project_id' => $this->match->project_id,
               'name' => $attachment->getClientOriginalName(),
               'uri' => $uri,
               'size' => $attachment->getClientSize(),
               'section' => 'attachment',
               'uploaded_by' => Auth::id()
            ]);

            $this->attachments()->attach($document->id);
         }

         return true;
      }

      return false;
   }

}
