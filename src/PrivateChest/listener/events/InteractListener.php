<?php

namespace PrivateChest\listener\events;

use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use PrivateChest\forms\LockForm;
use PrivateChest\forms\ManageChestForm;
use PrivateChest\manager\ChestManager;
use PrivateChest\utils\Utils;
use pocketmine\tile\Chest as TileChest;

class InteractListener implements Listener{

    /**
     * @param PlayerInteractEvent $e
     * @priority HIGHEST
     * @ignoreCancelled true
     */

    public function ChestInteract(PlayerInteractEvent $e) : void{

        if($e->isCancelled())
            return;

        if($e->getAction() !== PlayerInteractEvent::RIGHT_CLICK_BLOCK)
            return;

        $block = $e->getBlock();

        if($block->getId() !== Block::CHEST)
            return;

        $player = $e->getPlayer();
        $tile = $block->getLevel()->getTile($block->asVector3());

        if(!$tile instanceof TileChest)
            return;

        $blocks = [];

        array_push($blocks, $block);

        if($tile->isPaired())
            array_push($blocks, $tile->getPair());

        if(ChestManager::isLocked($block->asPosition())) {

            if(!$player->hasPermission(Utils::getFromConfig("chest-op-permission", false))) {
                if(ChestManager::getChest($block->asPosition())->getOwner() !== $player->getName()) {
                    $player->sendMessage(Utils::getFromConfig("chest-locked-message"));
                    $e->setCancelled(true);
                    return;
                }
            }

            if($player->isSneaking()) {
                $player->sendForm(new ManageChestForm($blocks));
                $e->setCancelled(true);
            }

            return;
        }

        if(ChestManager::getPlayerChestCount($player->getName()) >= Utils::getFromConfig("max-lock-chest", false)) {
            $player->sendMessage(Utils::getFromConfig("limit-message"));
            $e->setCancelled(true);
            return;
        }

        if($player->isSneaking()) {
            $player->sendForm(new LockForm($blocks));
            $e->setCancelled(true);
        }
    }
}