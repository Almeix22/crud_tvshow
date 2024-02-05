<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Album;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    public static function findBySeasonId(int $saisonId, int $tvshowId): array|bool
    {
        $episode = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT e.id, e.seasonId,e.name,e.overview,e.episodeNumber
    FROM episode e, season s 
    where s.id = e.seasonId
    And e.seasonId= :id
    And s.tvshowId= :id2
    ORDER BY e.id
SQL
        );
        $episode->bindParam('id', $saisonId);
        $episode->bindParam('id2', $tvshowId);
        $episode->execute();

        return $episode->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Episode::class);
;
    }
}