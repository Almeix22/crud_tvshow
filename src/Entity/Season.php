<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Season
{
    private int $id;
    private int $tvshowId;
    private string $name;
    private int $seasonNumber;
    private int $posterId;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTvshowId(): int
    {
        return $this->tvshowId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $tvshowId
     */
    public function setTvshowId(int $tvshowId): void
    {
        $this->tvshowId = $tvshowId;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $seasonNumber
     */
    public function setSeasonNumber(int $seasonNumber): void
    {
        $this->seasonNumber = $seasonNumber;
    }

    /**
     * @param int $posterId
     */
    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    public static function findById(?int $id): Season
    {
        $season = MyPDO::getInstance()->prepare(
            <<<'SQL'
    select *
    from season
    where id =:id 
SQL
        );
        $season->bindParam('id', $id);
        $season->execute();
        $season->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Season::class);
        $Season = $season->fetch();
        if ($Season) {
            return $Season;
        } else {
            throw new EntityNotFoundException('Entité introuvable');
        }
    }
}
