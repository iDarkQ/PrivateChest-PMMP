<?php

namespace PrivateChest\listener;

use pocketmine\Server;
use PrivateChest\listener\events\BlockBreakListener;
use PrivateChest\listener\events\ExplodeListener;
use PrivateChest\listener\events\InteractListener;
use PrivateChest\Main;

class ListenerManager {

    public static function init() : void {

        $events = [
            new InteractListener(),
            new BlockBreakListener(),
            new ExplodeListener()
        ];

        foreach($events as $listener)
            Server::getInstance()->getPluginManager()->registerEvents($listener, Main::getInstance());
    }
}