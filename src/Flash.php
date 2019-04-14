<?php

namespace Monolyth\Booby;

use Generator;

class Flash
{
    private $msg;
    private $options;
    private $index;

    private static $store = [];

    /**
     * @param string $msg
     * @param array $options
     * @return void
     */
    public function __construct(string $msg, array $options = [])
    {
        $this->msg = $msg;
        $this->options = $options;
        $this->index = spl_object_hash($this);
    }

    /**
     * @param string $name
     * @return mixed The value of the option, or null if not found.
     */
    public function __get(string $name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }
        return null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name) : bool
    {
        return isset($this->options[$name]);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        $msg = $this->msg;
        unset(self::$store[$this->index]);
        return $msg;
    }

    /**
     * @param string $msg
     * @param array $options
     * @return Monolyth\Booby\Flash
     */
    public static function me(string $msg, array $options = []) : Flash
    {
        self::init();
        $msg = new static($msg, $options);
        self::$store[spl_object_hash($msg)] = $msg;
        return $msg;
    }

    /**
     * Get messages one by one.
     *
     * @return Generator
     */
    public static function each() : Generator
    {
        self::init();
        foreach (self::$store as $msg) {
            yield $msg;
        }
    }

    /**
     * Get all current messages.
     *
     * @return array
     */
    public static function all() : array
    {
        self::init();
        return self::$store;
    }

    /**
     * Flush all messages (i.e., discard regardless of whether they were
     * shown to the user).
     *
     * @return void
     */
    public static function flush() : void
    {
        self::init();
        self::$store = [];
        $_SESSION['Booby'] = [];
    }

    /**
     * Helper to check if we were initialized.
     *
     * @return void
     */
    private static function init() : void
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

