<?php
namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;
use Entity\Collection\SeasonCollection;

class Tvshow
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private ?int $posterId;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @param string $homepage
     */
    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @param int $posterId
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    public static function findById(?int $id): Tvshow
    {
        $tvshow = MyPDO::getInstance()->prepare(
            <<<'SQL'
    select *
    from tvshow
    where id =:id 
SQL
        );
        $tvshow->bindParam('id', $id);
        $tvshow->execute();
        $tvshow->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Tvshow::class);
        $Tvshow = $tvshow->fetch();
        if ($Tvshow) {
            return $Tvshow;
        } else {
            throw new EntityNotFoundException('Entité introuvable');
        }
    }

    public function getSeason(): array
    {
        $season = new SeasonCollection();
        return $season->findByTvShowId($this->getId());
    }

    public function delete(): self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    DELETE FROM tvshow
    WHERE id = :id
SQL
        );
        $stmt->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);

        return $this;
    }

    private function update(): self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    UPDATE tvshow
    SET name = :name,originalname=:orignalname,homepage=:homepage,overview=:overview
    WHERE id = :id
SQL
        );
        $stmt->execute([
            ':name' => $this->name,
            ':originalname' => $this->getOriginalName(),
            ':homepage' => $this->getHomepage(),
            ':overview' => $this->getOverview(),
            ':id' => $this->getId()
        ]);

        return $this;
    }

    private function insert(): self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    INSERT INTO tvshow(name,originalname,homepage,overview)
    VALUES (:name,:originalname,:homepage,:overview)
SQL
        );
        $stmt->execute([
            ':name' => $this->name,
            ':originalname' => $this->getOriginalName(),
            ':homepage' => $this->getHomepage(),
            ':overview' => $this->getOverview()
        ]);
        $this->setId((int)MyPdo::getInstance()->lastInsertId());

        return $this;
    }

    public function save()
    {
        if(($this->getId())!=null){
            $this->update();
        }else {
            $this->insert();
        }
        return $this;
    }

    public static function create(string $name, ?int $id=null, string $homepage, string $originalname, string $overview, int $posterId=null):Tvshow
    {
        $tvshow = new Tvshow();
        $tvshow->setId($id);
        $tvshow->setName($name);
        $tvshow->setHomepage($homepage);
        $tvshow->setOriginalName($originalname);
        $tvshow->setPosterId($posterId);
        $tvshow->setOverview($overview);
        return $tvshow;
    }
}
