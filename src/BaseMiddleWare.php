<?php

namespace Azcend\Core;

use JetBrains\PhpStorm\NoReturn;

class BaseMiddleWare
{

    #[NoReturn]public static function redirect($url, $statusCode = 303): void
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
}