<?php

namespace Monolyth\Booby;

class Flash
{
    private $msg;
    private $options;
    private $index;

    private static $store = [];

    public function __construct($msg, array $options = [])
    {
        $this->msg = $msg;
        $this->options = $options;
        $this->index = spl_object_hash($this);
    }

    public function __get($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }
        return null;
    }

    public function __isset($name)
    {
        return isset($this->options[$name]);
    }

    public function __toString()
    {
        $msg = $this->msg;
        unset(self::$store[$this->index]);
        return $msg;
    }

    public static function me($msg, array $options = [])
    {
        self::init();
        $msg = new static($msg, $options);
        self::$store[spl_object_hash($msg)] = $msg;
        return $msg;
    }

    public static function each()
    {
        self::init();
        foreach (self::$store as $msg) {
            yield $msg;
        }
    }

    public static function all()
    {
        self::init();
        return self::$store;
    }

    private static function init()
    {
        static $inited = false;
        if (!$inited) {
            if (!isset($_SESSION['Booby']) || !$_SESSION['Booby']) {
                $_SESSION['Booby'] = [];
            }
            self::$store =& $_SESSION['Booby'];
            $inited = true;
        }
    }
}

