<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Tvshow;

try{
    if (isset($_GET['tvshowId'])) {
        $tvshowId = $_GET['tvshowId'];
        if (!ctype_digit($tvshowId)) {
            throw new ParameterException('ID invalide');
        } else {
            $tvshow = Tvshow::findById((int)$tvshowId);
        }
    }else{
        $tvshow=null;
    }
    $form = new \Html\Form\TvshowForm($tvshow);
    $formulaire=$form->getHtmlForm("/Admin/show-save.php");
    echo $formulaire;
} catch (ParameterException){
    http_response_code(400);
}catch (EntityNotFoundException){
    http_response_code(404);
}catch (Exception) {
    http_response_code(500);
}