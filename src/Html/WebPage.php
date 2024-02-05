<?php

namespace Html;

use DateTime;
use IntlDateFormatter;

class WebPage
{
    private string $head='';
    private string $title='';
    private string $body='';

    public function __construct(string $title='')
    {
        $this->setTitle($title);
    }

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    public function appendCss(string $css): void
    {
        $css2 = '<style>'.$css.'</style>';
        $this->appendToHead($css2);
    }

    public function appendCssUrl(string $url): void
    {
        $url2 = '<link href ='.$url.' rel="stylesheet">';
        $this->appendToHead($url2);
    }

    public function appendJs(string $js): void
    {
        $js2 = '<script>'.$js.'</script>';
        $this->appendToHead($js2);
    }

    public function appendJsUrl(string $url): void
    {
        $url2 = '<script src ='.$url.'></script>';
        $this->appendToHead($url2);
    }

    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    public function toHTML(): string
    {
        $html ="<!doctype html> \n";
        $html .= "<HTML lang='fr'> \n";
        $html .= "<head>\n";
        $html .= "<meta charset = 'utf-8' >\n";
        $html .= "<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
        $html .= "<title>";
        $html .= $this->getTitle().'</title>';
        $html .= $this->getHead().'</head>';
        $html .= "<body>\n";
        $html .= $this->getBody();
        $html .= "<div style='display: flex; font-style: italic; flex-direction: row-reverse'>".self::getLastModification()."</div>\n";
        $html .= "</body> \n";
        $html .= "</HTML> \n";
        return $html;
    }

    public static function getLastModification(): string
    {
        $date = new DateTime();
        $date->setTimestamp(getlastmod());

        return "Dernière modification le " . IntlDateFormatter::formatObject($date, 'd/M/Y')." à ". IntlDateFormatter::formatObject($date, 'H:m:s');
    }

    public static function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_HTML5 | ENT_QUOTES, 'UTF-8');
    }
}
