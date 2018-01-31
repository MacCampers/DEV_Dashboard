<?php

return [

   /*
   |--------------------------------------------------------------------------
   | Automatic emails Language Lines
   |--------------------------------------------------------------------------
   */

   'activation' => [
      'subject' => 'Account activation',
      'title' => 'Account activation',
      'text' => "Hello :name,<br />Thank you for your subscription to Equiteasy.<br /> Please click on the button below to activate your account:",
      'button' => 'Activate your account',
      'link_text' => "If the button doesn't work, please copy-paste the following link into your browser: :link",
   ],
   'company_user_request' => [
      'subject' => "Registration via your company's license",
      'title' => "Request to register via your company's license",
      'text' => "Hello :representative_name,<br />The user :user_name (:user_email) has indicated that he is employed by your company <strong>:company_name</strong>. In order to confirm or decline this request, please click on the button below which will direct you to your personal space.",
      'button' => 'Access the request',
      'link_text' => "If the button doesn't work, please copy-paste the following link into your browser: :link",
   ],

];
