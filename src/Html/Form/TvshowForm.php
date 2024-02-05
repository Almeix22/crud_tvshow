<?php

namespace Html\Form;

use Entity\Tvshow;
use Entity\Exception\ParameterException;
use Html\StringEscaper;

class TvshowForm
{
    use StringEscaper;
    private ?Tvshow $show;
    public function __construct($show=null)
    {
        $this->show=$show;
    }

    /**
     * @return Tvshow|null
     */
    public function getShow(): ?Tvshow
    {
        return $this->show;
    }
    public function getHtmlForm(string $action): string
    {
        $action=self::escapeString($action);
        $nom=self::escapeString($this->show?->getName());
        $originalName=self::escapeString($this->show?->getOriginalName());
        $homepage=self::escapeString($this->show?->getHomepage());
        $overview=self::escapeString($this->show?->getOverview());
        $html=<<<HTML
        <form action="$action" method="post">
        <div>
            <label for="Nom">Nom</label>
            <input type="text" name="name" value="$nom" required>
        </div>
        <div>
        <label for="Nom">Lien home page</label>
            <input type="text" name="homepage" value="$homepage" required>
        </div>
        <div>
            <label for="Nom">Nom original</label>
            <input type="text" name="originalName" value="$originalName" required>
        </div> 
        <div>
            <label for="Nom">Description</label>
            <input type="text" name="overview" value="$overview" required>
        </div>    
        <div>
            <input name="id" type="hidden" value="{$this->show?->getId()}">
        </div>
        <input type="submit" value="Enregistrer">
        
</form>
HTML;
        return $html;
    }

    /**
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {
        if ((isset($_POST['name']))&& isset($_POST['homepage'])&& isset($_POST['originalName'])&& isset($_POST['overview'])) {
            $name=$_POST['name'];
            $homepage=$_POST['homepage'];
            $originalName=$_POST['originalName'];
            $overview=$_POST['overview'];
            $name=self::stripTagsAndTrim($name);
            $homepage=self::stripTagsAndTrim($homepage);
            $originalName=self::stripTagsAndTrim($originalName);
            $overview=self::stripTagsAndTrim($overview);
            if ($name==='' && $homepage==='' && $originalName==='' && $overview==='') {
                throw new ParameterException("Paramètre vide");
            }
        } else {
            throw new ParameterException("Parametre non valide");
        }
        if (isset($_POST['id'])&& ctype_digit($_POST['id'])) {
            $id=$_POST['id'];
        } else {
            $id=null;
        }
        $show=Tvshow::create($name, $id, $homepage, $originalName, $overview, $this->getShow()?->getPosterId());
        $this->show=$show;
    }
}
