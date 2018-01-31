# Equiteasy

Ce repository contient le site web et la plateforme Equiteasy, développés avec Laravel 5.5.

### Prérequis ###

 * PHP >= 7.0
 * MySQL >= 5.5
 * Composer
 * Node.js

### Installation ###

Après avoir cloné le repository, créer une base de données nommée **equiteasy** puis créer un fichier **.env** à la racine du répertoire de l'application avec les informations suivantes :
```
APP_NAME=Equiteasy
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=equiteasy
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=sendinblue
MAIL_FROM_ADDRESS=noreply@equiteasy.com
MAIL_FROM_NAME=Equiteasy
SENDINBLUE_URL=https://api.sendinblue.com/v2.0
SENDINBLUE_KEY=*****

STRIPE_SECRET=*****
STRIPE_KEY=*****

CASHIER_ENV=testing

NOCAPTCHA_SECRET=*****
NOCAPTCHA_SITEKEY=*****

SUPPORT_EMAIL=marc@pixelparfait.fr

FILESYSTEM_DRIVER=s3

AWS_KEY=*****
AWS_SECRET=*****
AWS_REGION=eu-central-1
AWS_BUCKET=equiteasy-documents

NGROK_URL=

YOUSIGN_ENV="demo"
YOUSIGN_LOGIN="marc@pixelparfait.fr"
YOUSIGN_PASSWORD=*****
YOUSIGN_KEY=*****

SESSION_LIFETIME=120
```

Installer les dépendances PHP
```
composer install
```

Installer les dépendances Javascript
```
npm install
```

Lancer la compilation des assets
```
gulp watch
```

Installer la base de données  
Utiliser **--seed** pour insérer les administrateurs et valeurs de test dans la base de données.
```
php artisan migrate --seed
```

Démarrer le serveur
```
php artisan serve
```

Pour pouvoir recevoir les documents signés depuis YouSign, il est impératif d'utiliser l'utilitaire Ngrok qui permet de faire un tunnel entre une URL publique et localhost.  
Pour l'installer : https://ngrok.com/  
Dézipper l'archive à la racine du projet puis lancer la commande suivante :
```
./ngrok http 8000
```

Récupérer ensuite l'URL en .ngrok.io et la copier-coller dans la valeur NGROK_URL du fichier .env.   
**Attention :** Il est nécessaire de redémarrer le serveur après avoir éditer le fichier .env.