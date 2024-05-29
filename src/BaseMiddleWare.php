<?php

namespace Azcend\Core;

class BaseMiddleWare
{

    public static function redirect($url, $statusCode = 303): void
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
}
