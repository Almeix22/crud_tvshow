<?php

declare(strict_types=1);

namespace Html;

use Entity\Artist;

class AppWebPage extends WebPage
{
    public function __construct()
    {
        WebPage::__construct(WebPage::getTitle());
        $this->appendCssUrl("css/style.css");
    }

    public function toHTML(): string
    {
        $html = "<!DOCTYPE html> \n";
        $html .= "<html lang='fr'> \n";
        $html .= "<head>";
        $html .= "<meta charset='utf-8'>\n";
        $html .= "<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
        $html .= "<title>\n";
        $html .= $this->getTitle() . "</title>\n";
        $html .= $this->getHead() . "</head>\n";
        $html .= "<body>\n";
        $html .= "<header class='header'> <h1>".$this->getTitle()."</h1></header>\n";
        $html .= "<div class='content'> <main class='list'>\n".$this->getBody()."</main></div>\n";
        $html .= "<div class='footer'>";
        $html .= "<footer>";
        $html .= self::getLastModification();
        $html .= "</footer>";
        $html .= "</div>\n";
        $html .= "</body> \n";
        $html .= "</html> \n";
        return $html;
    }
}
