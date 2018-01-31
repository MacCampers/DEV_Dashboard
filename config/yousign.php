<?php
return [
   /*
   # Environnements de la l'API possibles
   *   - demo
   *       Environnement de démo.
   *       Les signatures de cette environnement ne sont pas légales.
   *   - prod
   *       Environnement de production.
   *       Les signatures de cette environnement sont (bien sûr) légales.
   *
   */
   'environment' => env('YOUSIGN_ENV'),
   // Votre identifiant Yousign
   'login' =>  env('YOUSIGN_LOGIN'),
   // Votre mot de passe Yousign
   'password' => env('YOUSIGN_PASSWORD'),
   // Indique si le mot de passe passé et crypté ou non (A décommenter si le mot de passe passé et crypté)
   'isEncryptedPassword' => true,
   // clef d'api
   'api_key' => env('YOUSIGN_KEY'),
];
