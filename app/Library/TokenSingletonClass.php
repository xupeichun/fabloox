<?php

namespace App\Library\TokenSingletonClass;

use Carbon\Carbon;

class TokenSingletonClass
{

    private static $instance = null;
    private $time = null;

    private function __construct($carbonTime)
    {
        $this->time =$carbonTime;
    }

    public static function getTime()
    {
        if (self::$instance == null) {
            self::$instance = new TokenSingletonClass(Carbon::now());
        }
        return self::$instance;
    }

/*    private function __clone()
    {
        // Stopping Clonning of Object
    }*/

/*    private function __wakeup()
    {
        // Stopping unserialize of object
    }*/
}