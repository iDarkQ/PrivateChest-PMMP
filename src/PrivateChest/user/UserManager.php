<?php

namespace PrivateChest\user;

use PrivateChest\Main;
use pocketmine\Player;

class UserManager {

    private static array $users = [];

    public static function init() : void {
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS 'users' (nick TEXT, xuid TEXT)");
        self::loadAllUsers();
    }

    public static function createUser(Player $user) : void {
        self::$users[$user->getName()] = new User($user->getName(), $user->getXuid());
    }

    public static function getUser(string $user) : ?User {
        return self::userExists($user) ? self::$users[$user] : null;
    }

    public static function userExists(string $user) : bool {
        return isset(self::$users[$user]);
    }

    public static function saveAllUsers() : void {
        foreach(self::$users as $row => $value) {
            $name = $value->getName();
            $xuid = $value->getXUID();
            if(empty(Main::getDb()->query("SELECT * FROM 'users' WHERE nick = '$name'")->fetchArray()))
                Main::getDb()->query("INSERT INTO 'users' (nick, xuid) VALUES ('$name', '$xuid')");
        }
    }

    public static function loadAllUsers() : void {
        $db = Main::getDb()->query("SELECT * FROM 'users'");

        $users = [];

        while($row = $db->fetchArray(SQLITE3_ASSOC))
            $users[$row["nick"]] = new User($row["nick"], $row["xuid"]);

        self::$users = $users;
    }
}