<?php

namespace PrivateChest\listener\events;

use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use PrivateChest\manager\ChestManager;
use PrivateChest\utils\Utils;

class BlockBreakListener implements Listener{

    /**
     * @param BlockBreakEvent $e
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function BreakChest(BlockBreakEvent $e) : void{

        if($e->isCancelled())
            return;

        $block = $e->getBlock();

        if($block->getId() !== Block::CHEST)
            return;

        if(!ChestManager::isLocked($block->asPosition()))
            return;

        $player = $e->getPlayer();
        $chest = ChestManager::getChest($block->asPosition());

        if($chest->getOwner() === $player->getName() || $player->hasPermission(Utils::getFromConfig("chest-op-permission", false))){
            ChestManager::unlockChest($block->asPosition());
            $player->sendMessage(Utils::getFromConfig("break-locked-chest"));
            return;
        }

        $e->setCancelled(true);
        $player->sendMessage(Utils::getFromConfig("chest-locked-message"));
    }
}
