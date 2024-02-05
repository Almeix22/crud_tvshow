<?php
declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    public static function escapeString(?string $text):string
    {
        $txt='';
        if($text != null){
            $txt = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);
        }
        return $txt;
    }
    public static function stripTagsAndTrim(?string $res):string
    {
        $txt ='';
        if( $res != null){
            $txt = strip_tags($res);
            $txt = trim($txt);
        }
        return $txt;
    }
}