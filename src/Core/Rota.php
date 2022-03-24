<?php

namespace LeoRalph\Core;

class Rota
{
    protected string $uri;
    protected mixed $callback;
    protected string $metodo;

    protected string $nome;

    public static array $rotas = [
        'get' => [],
        'post' => [],
        'put' => [],
        'delete' => [],
        'nomes' => []
    ];

    protected function __construct(string $uri, mixed $callback, string $metodo)
    {
        $this->uri = $uri;
        $this->callback = $callback;
        $this->metodo = $metodo;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public static function get(string $uri, $callback)
    {
        $rota = new self($uri, $callback, 'get');
        self::$rotas['get'][$uri] = $rota;
        return $rota;
    }

    public static function post(string $uri, $callback)
    {
        $rota = new self($uri, $callback, 'post');
        self::$rotas['post'][$uri] = $rota;
        return $rota;
    }

    public static function put(string $uri, $callback)
    {
        $rota = new self($uri, $callback, 'put');
        self::$rotas['put'][$uri] = $rota;
        return $rota;
    }

    public static function delete(string $uri, $callback)
    {
        $rota = new self($uri, $callback, 'delete');
        self::$rotas['delete'][$uri] = $rota;
        return $rota;
    }

    public static function listar()
    {
        return self::$rotas;
    }

    public static function resolver()
    {
        $metodo = Request::method();
        $uri = Request::path();

        $rota = self::$rotas[$metodo][$uri] ?? null;

        if (!$rota) {
            die('Rota não encontrada');
        }

        $callback = $rota->callback;

        if (is_array($callback)) {
            $callback[0] = new $callback[0];
            $resultado = call_user_func($callback);
        } else if (is_string($callback) && str_contains($callback, '@')) {
            $callback = explode('@', $callback);
            $callback[0] = new ("App\\Controllers\\" . $callback[0]);
            $resultado = call_user_func($callback);
        } else if (is_string($callback)) {
            $resultado = $callback;
        } else {
            $resultado = call_user_func($callback);
        }

        echo $resultado;
    }

    public function nome(string $nome)
    {
        self::$rotas['nomes'][$nome] = $this;
        $this->nome = $nome;
        return $this;
    }
}
