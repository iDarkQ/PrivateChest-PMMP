<?php

namespace PrivateChest\user;

class User {

    private string $name;
    private string $xuid;

    public function __construct(string $name, string $xuid) {
        $this->name = $name;
        $this->xuid = $xuid;
    }

    public function getXUID() : string {
        return $this->xuid;
    }

    public function getName() : string {
        return $this->name;
    }

    /*
     *
     * CHEST MANAGER
     *
     */

    public function addPlayerChest() : void{

    }
}