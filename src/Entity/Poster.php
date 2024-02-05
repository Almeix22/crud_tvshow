<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @param string $jpeg
     */
    public function setJpeg(string $jpeg): void
    {
        $this->jpeg = $jpeg;
    }

    public static function findById(int $id=null): Poster
    {
        $poster = MyPDO::getInstance()->prepare(
            <<<'SQL'
    select id,jpeg
    from poster
    where id =:id 
SQL
        );
        $poster->bindParam(':id', $id);
        $poster->execute();
        $poster->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Poster::class);
        $Poster = $poster->fetch();
        if ($Poster === false) {
            throw new EntityNotFoundException('Paramètre invalide');
        }
        return $Poster;
    }
}