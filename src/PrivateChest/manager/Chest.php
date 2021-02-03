<?php

namespace PrivateChest\manager;

use pocketmine\level\Position;

class Chest{

    private string $owner;
    private Position $position;

    public function __construct(string $owner, Position $position) {
        $this->owner = $owner;
        $this->position = $position;
    }

    public function getOwner() : string{
        return $this->owner;
    }

    public function getChestPosition() : Position{
        return $this->position;
    }
}