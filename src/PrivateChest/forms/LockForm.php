<?php

namespace PrivateChest\forms;

use pocketmine\level\Position;
use pocketmine\Player;
use PrivateChest\manager\ChestManager;
use PrivateChest\utils\Utils;

class LockForm extends Form {

    private array $blocks;

    public function __construct(array $blocks) {
        $data = [
            "type" => "form",
            "title" => Utils::getFromConfig("lock-form-title", false),
            "content" => Utils::getFromConfig("lock-form-description", false),
            "buttons" => []
        ];

        $data["buttons"][] = ["text" => Utils::getFromConfig("lock-form-button-name", false), "image" => ["type" => Utils::getFromConfig("lock-form-button-image-type", false), "data" => Utils::getFromConfig("lock-form-button-image-url", false)]];

        $this->data = $data;
        $this->blocks = $blocks;
    }

    public function handleResponse(Player $player, $data) : void {

        $formData = json_decode($data);

        if($formData === null)
            return;

        switch($formData){
            case 0:
                foreach($this->blocks as $block) {
                    if($player->getLevel()->getBlock($block->asVector3())->getId() !== Block::CHEST)
                        continue;

                    ChestManager::setChest($player->getName(), $block->asPosition());
                }

                $player->sendMessage(Utils::getFromConfig("successful-lock-chest"));
                break;
        }
    }
}
