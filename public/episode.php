<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Poster;
use Html\AppWebPage;
use Html\WebPage;

$seasonPage = new AppWebPage();
$seasonId=intval($_GET['seasonId']);
$tvshowId=intval($_GET['tvshowId']);

$tvshow= new \Entity\Tvshow();
$tvshow= $tvshow->findById($tvshowId);

$season= new \Entity\Season();
$season= $season->findById($seasonId);

$episode= new \Entity\Collection\EpisodeCollection();
$stmt=$episode->findBySeasonId($seasonId, $tvshowId);

$seasonPage->setTitle("Série TV : ".$tvshow->getName()."<br>".$season->getName());


$titreSerie= WebPage::escapeString($tvshow->getName());
$titreSeason = WebPage::escapeString($season->getName());
$PosterId = Poster::findById($season->getPosterId());

$seasonPage->appendContent(
    <<<HTML
    <div class="buttonmenuepisode">
        <form action="http://localhost:8000?genre=Tout">
        <button type="submit">Retour Menu</button>
        </form>
    </div>
HTML
);

$seasonPage->appendContent("<div class='seasoninfo'><img  class='season__poster' src =/poster.php?posterId={$PosterId->getId()} ></img> <div class ='seasonserie'><a href='season.php?tvshowId=$tvshowId'><p class='seasonserie__titleserie'>".$titreSerie." </p></a> <p class='seasonserie__titleseason'>".$titreSeason."</p></div></div>");


for ($i=0;$i<count($stmt);$i++) {
    $EpisodeNumber= WebPage::escapeString((string)$stmt[$i]->getEpisodeNumber());
    $EpisodeTitle= WebPage::escapeString($stmt[$i]->getName());
    $Description= WebPage::escapeString($stmt[$i]->getOverview());
    $seasonPage->appendContent("<div class='episode'><p class='episode_num'>".$EpisodeNumber." - ".$EpisodeTitle."</p> <p class='episode_desc'> $Description</p></div>");
}

echo $seasonPage->toHTML();