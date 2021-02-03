<?php

namespace PrivateChest\manager;

use pocketmine\level\Position;
use PrivateChest\Main;

class ChestManager{

    private static array $chests = [];

    public static function init() : void{
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS ChestManager (nick TEXT, x INT, y INT, z INT, expire INT)");
    }

    public static function setChest(string $owner, Position $position, int $expire) : void{
        self::$chests[] = new Chest($owner, $position, $expire);
    }

    public static function getChest(Position $position) : ?Chest{

        foreach(self::$chests as $index => $chest){
            $chestPosition = $chest->getChestPosition();
            if($chestPosition->asVector3()->equals($position) && $chestPosition->level === $position->level)
                return $chest;
        }

        return null;
    }

    public static function isLocked(Position $position) : bool{

        foreach(self::$chests as $index => $chest){
            $chestPosition = $chest->getChestPosition();
            if($chestPosition->asVector3()->equals($position) && $chestPosition->level === $position->level)
                return true;
        }

        return false;
    }

    public static function unlockChest(Position $position) : void{
        foreach(self::$chests as $index => $chest){
            $chestPosition = $chest->getChestPosition();
            if($chestPosition->asVector3()->equals($position) && $chestPosition->level === $position->level)
                unset(self::$chests[$index]);
        }
    }

    public static function getPlayerChestCount(string $nick) : int{

        $chests = 0;

        foreach(self::$chests as $index => $chest){
            if($chest->getOwner() === $nick)
                $chests++;
        }

        return $chests;
    }
}