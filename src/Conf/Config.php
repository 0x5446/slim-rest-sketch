<?php
namespace App\Conf;

class Config
{
    public $path;
    private static $pool;

    public function __construct() {
        $this->path = __DIR__;
    }
    public function __get($name) {
        if (empty(self::$pool[$name])) {
            self::$pool[$name] = include $this->path . '/' . $name . '.php';
        }
        return self::$pool[$name];
    }
}
