<?php

use LeoRalph\Core\Application;

function view(string $view, array $data = [], string $ext = '.twig')
{
    return Application::$view->render($view.$ext, $data);
}

function config(string $key)
{
    $explode = explode('.', $key);

    return empty($explode[2]) ? (include ROOT . "/config/{$explode[0]}.php")[$explode[1]] : (include ROOT . "/config/{$explode[0]}.php")[$explode[1]][$explode[2]];
}