<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Album;
use PDO;

class SeasonCollection
{
    public static function findByTvShowId(int $tvShowId): array|bool
    {
        $season = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT *
    FROM season
    Where tvShowId= :id
    ORDER BY name
SQL
        );
        $season->bindParam('id', $tvShowId);
        $season->execute();
        return $season->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Entity\Season');
    }
}
