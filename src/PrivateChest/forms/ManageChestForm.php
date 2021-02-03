<?php

namespace PrivateChest\forms;

use pocketmine\Player;
use PrivateChest\manager\ChestManager;
use PrivateChest\utils\Utils;

class ManageChestForm extends Form {

    private array $blocks;

    public function __construct(array $blocks) {
        $data = [
            "type" => "form",
            "title" => Utils::getFromConfig("manage-form-title", false),
            "content" => Utils::getFromConfig("manage-form-description", false),
            "buttons" => []
        ];

        $data["buttons"][] = ["text" => Utils::getFromConfig("manage-form-button-name", false), "image" => ["type" => Utils::getFromConfig("manage-form-button-image-type", false), "data" => Utils::getFromConfig("lock-form-button-image-url", false)]];

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
                    if(!$player->getLevel()->getBlock($block->asVector3()))
                        continue;

                    ChestManager::unlockChest($block->asPosition());
                }
                $player->sendMessage(Utils::getFromConfig("successful-unlock-chest"));
                break;
        }
    }
}