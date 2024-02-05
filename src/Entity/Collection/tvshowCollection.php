<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Tvshow;
use PDO;

class tvshowCollection
{
    /**
     *  Retourne un tableau contenant tous les tvShow triés par ordre alphabétique.
     * @return Tvshow[]
     */
    public static function findAll(): array
    {
        $stmt=MyPdo::getInstance()->prepare(
            <<<'SQL'
            select *
            from tvshow
            order by name
            SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Entity\Tvshow');
    }

    public static function findByGenreName(string $GenreName): array
    {
        $genre = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT t.id,t.name,t.homepage,t.originalname,t.overview,t.posterId
    FROM tvshow t
    INNER JOIN tvshow_genre tv ON (t.id=tv.tvShowId)
    INNER JOIN genre g ON (g.id=tv.genreId)
    Where g.name= :name
    ORDER BY name
SQL
        );
        $genre->bindParam(':name', $GenreName);
        $genre->execute();
        return $genre->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Entity\TvShow');
    }
}