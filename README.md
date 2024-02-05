<h1> Développement d'une application Web de consultation et modification de série de TV</h1>
<h2> Auteur : François Axel (fran0138), Franck Tony (fran0124) </h2>
<br>

<h2>Serveur Web local :</h2>
<p>Afin de lancer le serveur Web locale, il est nécesaire de taper la commande suivante dans un terminal :</p>
<p><strong>php -d display_errors -S localhost:8000 -t public/</strong></p>

<p>Un script à été rajouté dans le fichier composer.json afin de faciliter le travail du developpeur et de lancer directement le serveur locale sans passer par la commande ; Pour cela, il suffit de taper la commande suivante dans un terminale :</p>
<p><strong>composer run-script run-server</strong></p>
<br>


<h2>Style de codage :</h2>
<p> Il est possible de lancer une première verification manuelle "test à blanc" c'est à dire sans que aucun fichier ne sois modifié avec la commande :</p>
<p><strong>php vendor/bin/php-cs-fixer fix --dry-run</strong></p>

<p> Il est possible de lancer une verification et d'afficher les différences entre l'original et ce qui est ou serait corrigé avec la commande :</p>
<p><strong>php vendor/bin/php-cs-fixer fix --dry-run --diff</strong></p>

<p> Il est possible de corriger le fichier avec la commande :</p>
<p><strong>php vendor/bin/php-cs-fixer fix</strong></p>
<br>


<h2>Configuration de la Base de Données : </h2>
<p> L'utilisation d'un fichier .mypdo.ini permet tout simplement de recueillir les informations nécéssaire à l'accès à la base de donnée tel que le DNS, L'utilisateur et le mot de passe afin de l'utilisé pour se connecter à cette dernière.</p>
<br>

<h2>Filtrage des données : </h2>
<p> Afin d'assurer un filtrage des données de la base de données, une classe genre.php à été rajouté au dossier afin de filtrer les série. Le filtrage s'effectue via un formulaire ou il suffit de séléctionner le genre souhaité et de cliquer sur le boutton appliquer. </p>
<br>

<h2>Fonctionnalité du CRUD :</h2>
<p> Afin d'assurer les fonctionnalités du CRUD, les méthodes d'insertion, de modification, de suppression, de création et de sauvegarde ont été ajouté a la classe Tvshow.php. De plus, les fichiers show-delete.php, show-form.php et show-save.php ont été crée dans le répertoire Admin situé dans le répertoire Public afin d'appliquer les modifications réalisé avec les méthodes du CRUD sur la base de données. Tout le système est relié via des bouttons qui permettent la navigation entre chaque page. </p>
<p> Le fichier StringEscaper.php à été crée afin de remplacer la fonctionnalité escapeString() qui n'est pas accessible dans la classe TvshowForm.php </p>
