<?php

namespace LeoRalph\Core;

class Request
{
    public static function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function path()
    {
        return $_SERVER['PATH_INFO'] ?? '/';
    }

    public static function body()
    {
        switch (self::method()) {
            case 'get':
                $return = filter_input_array(1);
                break;

            default:
                $return = filter_input_array(0);
                break;
        }

        return $return ?? [];
    }
}
