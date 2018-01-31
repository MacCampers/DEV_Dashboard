<?php
namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use App\Document;

use Storage;

class DocumentsController extends Controller {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Serve file from S3
   *
   * @return Response
   */
   public function serve($id) {
      $document = Document::find($id);

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
         "Content-disposition" => "inline; filename=\"" . basename($file). "\"",
      ]);
   }

}
