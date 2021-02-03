<?php

namespace PrivateChest;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use PrivateChest\block\BlockManager;
use PrivateChest\listener\ListenerManager;
use PrivateChest\manager\ChestManager;
use PrivateChest\user\UserManager;

class Main extends PluginBase{

    private static self $instance;
    private static \SQLite3 $db;
    private static Config $cfg;

    public function onEnable() : void{

        $this->saveResource("Config.yml");

        self::$instance = $this;
        self::$db = new \SQLite3($this->getDataFolder()."DataBase.db");
        self::$cfg = new Config($this->getDataFolder()."Config.yml", Config::YAML);

        ListenerManager::init();
        BlockManager::init();
        ChestManager::init();
        ChestManager::LoadChests();
    }

    public function onDisable() : void{
        ChestManager::saveChests();
    }

    public static function getInstance() : self{
        return self::$instance;
    }

    public static function getDb() : \SQLite3{
        return self::$db;
    }

    public static function getCfg() : Config{
        return self::$cfg;
    }
}