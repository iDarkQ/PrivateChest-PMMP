<?php

namespace PrivateChest\listener\events;

use pocketmine\block\Block;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\event\Listener;
use PrivateChest\manager\ChestManager;

class ExplodeListener implements Listener {

    /**
     * @param EntityExplodeEvent $e
     * @priority HIGHEST
     * @ignoreCancelled true
     */

    public function onExplosion(EntityExplodeEvent $e) : void {
        $blocks = $e->getBlockList();

        foreach($blocks as $num => $block) {
            if($block->getId() !== Block::CHEST)
                continue;

            if(!ChestManager::isLocked($block->asPosition()))
                continue;

            unset($blocks[$num]);
        }
        $e->setBlockList($blocks);
    }
}