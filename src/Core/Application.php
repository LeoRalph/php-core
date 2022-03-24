<?php

namespace LeoRalph\Core;

use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Application
{
    public static DB $db;
    public static Environment $view;
    public static Dotenv $env;

    public static function boot(string $root)
    {
        define("ROOT", $root);

        self::$view = new Environment(new FilesystemLoader(ROOT . "/views"));
        self::$env = Dotenv::createImmutable(ROOT);
        self::$env->load();
        self::$db = new DB();
        self::$db->addConnection(config('database.conexoes.' . env('DB_CONEXAO')));
        self::$db->setAsGlobal();

        Rota::resolver();
    }
}
