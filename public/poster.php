<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\AppWebPage;

try {
    $PosterId=intval(isset($_GET['posterId']));
    if (isset($_GET['posterId']) and ctype_digit($_GET['posterId'])) {
        $PosterId=(int)($_GET['posterId']);
        header('Content-Type: image/jpeg');
        $PosterPage = new AppWebPage();
        $poster = new \Entity\Poster();
        $stmt = $poster->findById($PosterId);
        echo($stmt->getJpeg());
    } else {
        echo "<img src='img/default.png' alt='defaultImg'>";
    }
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
