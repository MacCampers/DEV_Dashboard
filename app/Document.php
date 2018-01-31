<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Extensions\YouSignApiClient;
use App\Mail\Signature;

use App\Signatory;

use Storage;
use Mail;

class Document extends Model {

   protected $table = 'documents';
   protected $fillable = ['project_id', 'name', 'uri', 'size', 'section', 'signed', 'uploaded_by', 'signed', 'comment'];

   public $incrementing = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function signatories() {
      return $this->hasMany('App\Signatory', 'document_id');
   }

   public function project() {
      return $this->belongsTo('App\Project', 'project_id');
   }

   public function document_comments() {
      return $this->hasOne('App\DocumentComment', 'document_id');
   }


   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   // Initialize signature
   public function initSignature($users, $options) {
      /*
      |--------------------------------------------------------------------------
      | Check connection with YouSign API
      |--------------------------------------------------------------------------
      */

      $client = new YouSignApiClient();
      $client->connect();

      // Check if we are authenticated
      if( !$client->isAuthenticated() ) {
         abort(403);
      }

      /*
      |--------------------------------------------------------------------------
      | Send information to YouSign
      |--------------------------------------------------------------------------
      */

      // Create array of documents
      $filesArray = [
         [
            'name' => $this->name,
            'content' => base64_encode(Storage::get($this->uri)),
            'idFile' => $this->id
         ]
      ];

      // Set visible options
      $visibleOptions = [
         $filesArray[0]['idFile'] => []
      ];

      // Create array of signatories
      $signatoriesArray = [];
      $i = 0;
      foreach( $users as $user ) {
         $signatoriesArray[] = [
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'mail' => $user->email,
            'phone' => $user->phone_mobile ?: false,
            'proofLevel' => 'LOW',
            'authenticationMode' => 'sms'
         ];

         $visibleOptions[$filesArray[0]['idFile']][] = [
            'visibleSignaturePage' => $options[$i]['page'],
            'isVisibleSignature' => true,
            'visibleRectangleSignature' => $options[$i]['position'],
            'mail' => $user->email,
         ];

         $i++;
      }

      // Set empty message because we will show an iframe
      $message = '';

      // Send data to YouSign
      try {
         $result = $client->initCoSign($filesArray, $signatoriesArray, $visibleOptions, $message, ['mode' => 'IFRAME']);
      } catch(\Exception $e) {
         return false;
      }

      if( $result ) {
         if( isset($result['tokens']['token']) ) {
            $result['tokens'] = array($result['tokens']);
         }

         // Create signatories
         foreach( $result['tokens'] as $index => $value ) {
            $signatory = Signatory::create([
               'document_id' => $this->id,
               'user_id' => $users[$index]->id,
               'email' => $users[$index]->email,
               'phone' => $users[$index]->phone_mobile,
               'yousign_token' => $value['token'],
               'yousign_id_demand' => $result['idDemand'],
               'yousign_id_file' => $result['fileInfos']['idFile'],
               'signature_page' => $options[$index]['page'],
               'signature_position' => $options[$index]['position'],
            ]);

            Mail::to($signatory)->send(new Signature($this->project, $signatory));
         }

         return true;
      }

      return false;
   }

}
