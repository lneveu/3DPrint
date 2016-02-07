# 3DPrint

## Sommaire
* Prérequis
* Serveur de vérification
* Installation sur un envrionnement Linux

## Prérequis
- NodeJS (version >= 5.4.0)
- Python 2.7 (version >= 3 ne fonctionne pas)


## Serveur de vérification
Le serveur écoute sur le port 8080.

Avant de lancer le server, s'assurer que tous les modules sont installés en exécutant dans le dossier 'models-validation' la commande 

	$ npm install

Lancer le serveur avec

	$ node server.js


## Installation sur un environnement Linux

###I) Installer composer:
Installation

	$ curl -sS https://getcomposer.org/installer | php
	$ sudo mv composer.phar /usr/local/bin/composer

Verification de l'installation

	$ composer --version

Update composer

	$ composer self-update

###II) Cloner le projet
	$ git init
	$ git clone https://github.com/LoannNeveu/3DPrint.git

###III) Installation des dépendances (laravel + plugins)
Dans le dossier 3DPrint

	$ composer install
	
(générer un token d'authentification via Github->settings->Personnal Access Tokens)

	$ composer update

###IV) Configurer la base
Créer une nouvelle base de données (utf8-general-ci)

Renomer .env.example en .env et renseigner les infos pour la BDD (DB_HOST,...)

Générer les tables:

  $ php artisan migrate
  
###V) Configurer le driver de mail + social connection url (il faut que l'url de redirection soit configurer dans les applications (fb, google) également)
Dans le fichier .env, remplacer

	MAIL_DRIVER=mailgun
	MAIL_HOST=mailtrap.io
	MAIL_PORT=2525
	MAIL_USERNAME=null
	MAIL_PASSWORD=null
	MAIL_ENCRYPTION=null

Et ajouter:
	
	MAILGUN_DOMAIN=sandbox0cab25f24064433890b3338acf5d51a8.mailgun.org
	MAILGUN_SECRET=key-6f1f977bf637f6a9e3532a38fe012573

	FACEBOOK_REDIRECT={Your domain}/login/facebook
    GOOGLE_REDIRECT={Your domain}/login/google

###VI) Clé et droits
Générer l'APP_KEY:
 
  $ php artisan key:generate
  
Donner les droits au serveur d'écrire dans les dossiers "storage" et "bootstrap/cache"

###VII) Configurer un virtual host
Créer un fichier 3dprint.conf dans /etc/httpd/conf.d/ et y ajouter (en remplacant les champs)

	<VirtualHost *:80>
	        ServerName [nom de domaine]
	        DocumentRoot "[chemin]/3DPrint/public"
	        <Directory "[chemin]/3DPrint">
	                AllowOverride All
	        </Directory>
	</VirtualHost>

Redémarer apache:

	$ service httpd restart
