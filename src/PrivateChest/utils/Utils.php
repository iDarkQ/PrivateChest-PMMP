<?php

namespace PrivateChest\utils;

use PrivateChest\Main;

class Utils{

    public static function getFormat() : string{
        return Main::getCfg()->get("format");
    }

    public static function getFromConfig(string $name, bool $format = true) : string{

        $message = "";

        if(self::getFormat() !== "null" && $format)
            $message = self::getFormat();

        $message .= Main::getCfg()->get($name);

        return str_replace("&", "§", $message);
    }
}