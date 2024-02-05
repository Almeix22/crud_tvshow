<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Entity\Poster;
use Html\AppWebPage;
use Entity\Tvshow;
use Entity\Collection\tvshowCollection;
use Html\WebPage;

$webPage = new AppWebPage();
$webPage->setTitle(" Séries Tv");
$webPage->appendContent("<nav><a id='Add' href='Admin/show-form.php'><button>Ajouter</button></a></nav>");
$collection = new tvshowCollection();
$stmt = $collection->findAll();

$listgenre = new GenreCollection();
$listgenre = $listgenre->findAll();
$webPage->appendContent(
    <<<HTML
    <div class="buttonmenuindex">
    <form>
        <label>
        Filtrage par genre
            <select name="genre" required>
                <option value="Tout">Tout</option>
HTML
);
for ($j=0;$j<count($listgenre);$j++) {
    $name = WebPage::escapeString($listgenre[$j]->getName());
    $webPage->appendContent("<option value='$name'>$name</option>");
}
$webPage->appendContent(
    <<<HTML
            </select>
        </label>
        <button type="submit">Appliquer</button>
    </form>
    </div>
    <div class="list">
HTML
);

$stm= new tvshowCollection();
$filtre = $_GET['genre'];
if ($filtre == null) {
    header("Location: http://localhost:8000?genre=Tout");
    $stmt= $stm->findAll();
}
elseif ($_GET['genre']!="Tout") {
    $stmt = $stm->findByGenreName($filtre);
}
else {
    $stmt = $stm->findAll();
}

for ($i=0;$i<count($stmt);$i++) {
    $c= WebPage::escapeString(strval($stmt[$i]->getId()));
    if (is_null($stmt[$i]->getPosterId())){
        $webPage->appendContent( "<div class='serie'><a href='season.php?tvshowId=$c'><p class='image'><img class='serie__cover' src='Img/default.png' alt='defaultImg'></p>");}
    else {
        $PosterId = Poster::findById($stmt[$i]->getPosterId());
        $webPage->appendContent("<div class='serie'><a href='season.php?tvshowId=$c'><p class='image'><img  class='serie__cover' src=/poster.php?posterId={$PosterId->getId()} ></img></a></p>");
    }
    $a = WebPage::escapeString($stmt[$i]->getName());
    $b= WebPage::escapeString($stmt[$i]->getOverview());
    $webPage->appendContent("<a href='season.php?tvshowId=$c'><div class ='texte'><p class='texte__titre'>".$a."</p> <p class='texte__desc'>".$b."</p></div></a></div>");
}
echo $webPage->toHTML();
