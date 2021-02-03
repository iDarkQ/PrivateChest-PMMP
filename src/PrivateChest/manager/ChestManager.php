<?php

namespace PrivateChest\manager;

use pocketmine\level\Position;
use pocketmine\Server;
use PrivateChest\Main;

class ChestManager{

    private static array $chests = [];

    public static function init() : void{
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS ChestManager (owner TEXT, x INT, y INT, z INT, level TEXT)");
    }

    public static function loadChests() : void {

        $chest = [];
        $db = Main::getDb()->query("SELECT * FROM ChestManager");

        while($row = $db->fetchArray(SQLITE3_ASSOC)) {
            Server::getInstance()->loadLevel($row["level"]);
            $level = Server::getInstance()->getLevelByName($row["level"]);

            $chest[] = new Chest($row["owner"], new Position($row["x"], $row["y"], $row["z"], $level));
        }

        self::$chests = $chest;
    }

    public static function saveChests() : void {

        $db = Main::getDb()->query("SELECT * FROM 'ChestManager'");

        while($row = $db->fetchArray(SQLITE3_ASSOC)){
            foreach(self::$chests as $index => $value){
                if(!self::getChest(new Position($row["x"], $row["y"], $row["z"], Server::getInstance()->getLevelByName($row["level"]))))
                    Main::getDb()->query("DELETE FROM 'ChestManager' WHERE x = '{$row['x']}' AND y = '{$row['y']}' AND z = '{$row['z']}' AND level = '{$row['level']}'");
            }
        }

        foreach(self::$chests as $row => $value) {

            $pos = $value->getChestPosition();
            if(empty(Main::getDb()->query("SELECT * FROM 'ChestManager' WHERE owner = '{$value->getOwner()}' AND x = '{$pos->x}' AND y = '{$pos->y}' AND z = '{$pos->z}' AND level = '{$pos->level->getName()}'")->fetchArray()))
                Main::getDb()->query("INSERT INTO 'ChestManager' (owner, x, y, z, level) VALUES ('{$value->getOwner()}', '{$pos->x}', '{$pos->y}', '{$pos->z}', '{$pos->level->getName()}')");
        }
    }

    public static function setChest(string $owner, Position $position) : void{
        self::$chests[] = new Chest($owner, $position);
    }

    public static function getChest(Position $position) : ?Chest{

        foreach(self::$chests as $index => $chest){
            $chestPosition = $chest->getChestPosition();
            if($chestPosition->equels($position))
                return $chest;
        }

        return null;
    }

    public static function isLocked(Position $position) : bool{

        foreach(self::$chests as $index => $chest){
            $chestPosition = $chest->getChestPosition();
            if($chestPosition->equals($position))
                return true;
        }

        return false;
    }

    public static function unlockChest(Position $position) : void{
        foreach(self::$chests as $index => $chest){
            $chestPosition = $chest->getChestPosition();
            if($chestPosition->equals($position))
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
