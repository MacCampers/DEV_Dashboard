<?php
namespace App\Extensions;

use YousignAPI\YsApi;
use Illuminate\Support\Facades\Config;

class YouSignApiClient extends YsApi {

   public function __construct(){
      parent::__construct(null);

      $this->setLogin(Config::get('yousign.login'));

      if( !Config::get('yousign.isEncryptedPassword') ) {
         $this->setPassword($this->encryptPassword(Config::get('yousign.password')));
      } else {
         $this->setPassword(Config::get('yousign.password'));
      }
      $this->setApiKey(Config::get('yousign.api_key'));
      $this->setEnvironment(Config::get('yousign.environment'));
   }

}
