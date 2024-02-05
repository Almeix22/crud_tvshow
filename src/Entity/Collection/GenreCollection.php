<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection

{
    /**
     *  Retourne un tableau contenant tous les Genre triés par ordre alphabétique.
     * @return Genre[]
     */
    public static function findAll(): array
    {
        $stmt=MyPdo::getInstance()->prepare(
            <<<'SQL'
            select id,name
            from genre
            order by name
            SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Entity\Genre');
    }
}
