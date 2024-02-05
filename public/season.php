<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\ParameterException;
use Entity\Poster;
use Html\WebPage;
use Html\AppWebPage;

$tvshowPage = new AppWebPage();
$tvshowId=intval($_GET['tvshowId']);

$tvshow= new \Entity\Tvshow();
$tvshow= $tvshow->findById($tvshowId);

$season= new \Entity\Collection\SeasonCollection();
$stmt=$season->findByTvshowId($tvshowId);

$tvshowPage->appendContent(
    <<<HTML
    <div class="buttonmenuseason">
        <form action="http://localhost:8000?genre=Tout">
        <button type="submit">Retour Menu</button>
        </form>
    </div>
HTML
);
if(isset($_GET['tvshowId'])&&ctype_digit($_GET['tvshowId'])){
    $tvshowId=$_GET['tvshowId'];
    $tvshowPage->appendContent("<nav><a id='delete' href='http://localhost:8000/Admin/show-delete.php?tvshowId=$tvshowId'><button type='submit'> Supprimer la série</button></a></nav>");
}else{
    throw new ParameterException();
}
$tvshowPage->setTitle("Série TV : ".$tvshow->getName());
$titreSerie= WebPage::escapeString($tvshow->getName());
$TitreOriginale=WebPage::escapeString($tvshow->getOriginalName());
$Description=WebPage::escapeString($tvshow->getOverview());
if (is_null($tvshow->getPosterId())){
    $tvshowPage->appendContent( "<div class='season'><img  class='season__poster'<img  class='season__poster' src='Img/default.png' alt='defaultImg'></p>");}
else {
    $PosterId = Poster::findById($tvshow->getPosterId());
    $tvshowPage->appendContent("<div class='season'><p class='image'><img  class='season__poster' src =/poster.php?posterId={$PosterId->getId()} ></img></p>");
}
$tvshowPage->appendContent("<div class ='season__texte'><p class='season__name'>".$titreSerie." </p> <p class='season__original'>".$TitreOriginale."</p><p class='season__desc'>".$Description."</p></div></a></div>");


for ($i=0;$i<count($stmt);$i++) {
    $c= WebPage::escapeString(strval($stmt[$i]->getId()));
    if (is_null($stmt[$i]->getPosterId())){
        $tvshowPage->appendContent( "<a href='episode.php?tvshowId=$tvshowId&seasonId=$c'><div class='season'><a href='episode.php?tvshowId=$tvshowId&seasonId=$c'><p class='image'><img  class='season__poster' src='Img/default.png' alt='defaultImg'></p>");}
    else {
        $PosterId = Poster::findById($stmt[$i]->getPosterId());
        $tvshowPage->appendContent("<a href='episode.php?tvshowId=$tvshowId&seasonId=$c'><div class='season'><a href='episode.php?tvshowId=$tvshowId&seasonId=$c'><p class='image'><img  class='season__poster' src =/poster.php?posterId={$PosterId->getId()} ></img></p>");
    }
    $TitreSeason=WebPage::escapeString($stmt[$i]->getName());
    $tvshowPage->appendContent(" <div class ='season_info'><p class='season_title'>".$TitreSeason." </p> </div></a></div>");
}

echo $tvshowPage->toHTML();
