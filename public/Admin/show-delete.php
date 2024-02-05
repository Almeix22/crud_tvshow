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
            $tvshowId = (int)$tvshowId;
            $tvshow = Tvshow::findById((int)$tvshowId);
            $tvshow->delete();
        }
    }else{
        throw new ParameterException('ID non enregisté');
    }
    header('Location: /index.php');
    exit();
} catch (ParameterException){
    http_response_code(400);
}catch (EntityNotFoundException){
    http_response_code(404);
}catch (Exception) {
    http_response_code(500);
}