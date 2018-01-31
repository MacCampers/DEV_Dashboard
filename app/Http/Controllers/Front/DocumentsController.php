<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Extensions\YouSignApiClient;
use Carbon\Carbon;

use App\Document;
use App\Signatory;
use App\Match;
use App\MatchEvent;

use App\Mail\Project\SignedLicenceNotification;
use App\Mail\Match\SignedNdaNotification;

use Auth;
use Storage;
use Mail;

class DocumentsController extends Controller {

   /**
   * Serve file from S3
   *
   * @return Response
   */
   public function serve($id) {
      $document = Document::find($id);

      // Check access
      if( Auth::guard('admin')->check() || Auth::user()->hasDocumentAccess($document) ) {
         $file = $document->uri;

         return response()->stream(function() use($file) {
            $stream = Storage::readStream($file);
            fpassthru($stream);
            if( is_resource($stream) ) {
               fclose($stream);
            }
         }, 200, [
            "Content-Type" => Storage::mimeType($file),
            "Content-Length" => Storage::size($file),
            "Content-disposition" => "inline; filename=\"" . $document->name. "\"",
         ]);
      }

      abort(403);
   }

   /**
   * Show YouSign iframe
   *
   * @return View
   */
   public function signature(Request $request, $signatoryId) {
      $client = new YouSignApiClient();
      $client->connect();

      $signatory = Signatory::find($signatoryId);

      $token = $request->input('token');

      // Check if the token is the same as the one stored with the signatory
      if( $signatory->yousign_token !== $token ) {
         abort(404);
      }

      // Check if we are authenticated
      if( !$client->isAuthenticated() ) {
         abort(403);
      }

      if( env('APP_ENV') === 'local' ) {
         $callbackUrl = env('NGROK_URL') . "/signature/callback/" . $signatoryId;
      } else {
         $callbackUrl = route('signature_callback', ['signatoryId' => $signatoryId]);
      }

      $iframeUrl = $client->getIframeUrl($token) . '?urlcallback=' . urlencode($callbackUrl);

      // Return view with iframe URL
      return view('front.signature.yousign', ['iframeUrl' => $iframeUrl]);
   }

   /**
   * YouSign callback function
   *
   * @return void
   */
   public function signatureCallback(Request $request, $signatoryId) {
      $signatory = Signatory::where(['id' => $signatoryId, 'yousign_token' => $request->input('token')])->first();

      if( $request->input('status') === 'signed_complete' ) {
         if( !$signatory->document->signed ) {
            $client = new YouSignApiClient();
            $client->connect();

            $file = $client->getCosignedFileFromIdDemand($signatory->yousign_id_demand, $signatory->yousign_id_file);

            if( !$file ) {
               dump($client->getErrors());
               exit;
            }

            // Store file
            Storage::put($signatory->document->uri, base64_decode($file['file']));

            // Update document
            $signatory->document->update([
               'size' => Storage::size($signatory->document->uri),
               'signed' => 1
            ]);

            // NDA
            if( $signatory->document->section === 'nda' ) {
               $match = Match::where('nda_id', $signatory->document_id)->first();

               // Create event if it doesn't exist yet
               $eventExists = MatchEvent::where(['match_id' => $match->id, 'description' => 'nda_signed_complete'])->count();

               if( !$eventExists ) {
                  MatchEvent::create([
                     'match_id' => $match->id,
                     'description' => 'nda_signed_complete'
                  ]);
               }

               // Send email to cosigners
               foreach( $signatory->document->signatories as $s ) {
                  Mail::to($s->user)->send(new SignedNdaNotification($s, $match));
               }
            }
            // Licence
            elseif( $signatory->document->section === 'licence' ) {
               // Send email to cosigners
               foreach( $signatory->document->signatories as $s ) {
                  Mail::to($s->user)->send(new SignedLicenceNotification($s));
               }
            }
         }
      } else {
         // Update status
         $signatory->update([
            'status' => $request->input('status'),
            'signed_at' => $request->input('status') === 'signed' ? Carbon::now() : null,
         ]);
      }
   }

}
