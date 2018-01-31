<?php

return array(
   'pdf' => array(
      'enabled' => true,
      'binary'  => env('APP_ENV') === 'local' ? '/usr/local/bin/wkhtmltopdf' : base_path('vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386'),
      'timeout' => false,
      'options' => array(),
      'env'     => array(),
   ),
   'image' => array(
      'enabled' => true,
      'binary'  => env('APP_ENV') === 'local' ? '/usr/local/bin/wkhtmltoimage' : base_path('vendor/h4cc/wkhtmltoimage-i386/bin/wkhtmltoimage-i386'),
      'timeout' => false,
      'options' => array(),
      'env'     => array(),
   ),
);
