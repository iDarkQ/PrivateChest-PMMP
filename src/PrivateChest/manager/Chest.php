<?php

namespace PrivateChest\manager;

use pocketmine\level\Position;

class Chest{

    private string $owner;
    private Position $position;
    private ?int $expire;

    public function __construct(string $owner, Position $position, ?int $expire) {
        $this->owner = $owner;
        $this->position = $position;
        $this->expire = $expire;
    }

    public function getOwner() : string{
        return $this->owner;
    }

    public function getChestPosition() : Position{
        return $this->position;
    }

    public function getExpireTime() : ?int{
        return $this->expire;
    }
}