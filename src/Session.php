<?php

namespace Azcend\Core;

class Session
{
    public static function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public static function get($name) {
        return $_SESSION[$name] ?? null;
    }

    public static function destroy() {
        session_destroy();
    }

    public static function refresh(): void
    {
        session_destroy();
        session_start();
    }
}