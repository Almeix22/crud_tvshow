<?php
declare(strict_types=1);

use Entity\Exception\ParameterException;

try{
    $form = new \Html\Form\TvshowForm();
    $form->setEntityFromQueryString();
    $form->getShow()?->save();
    header("Location: /index.php");
    exit;
} catch (ParameterException){
    http_response_code(400);
}catch (Exception) {
    http_response_code(500);
}