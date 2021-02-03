<?php

namespace PrivateChest\block;

use pocketmine\block\BlockFactory;
use PrivateChest\block\blocks\Chest;

class BlockManager{

    public static function init() : void{
        $blocks = [
            new Chest()
        ];

        foreach($blocks as $block)
            BlockFactory::registerBlock($block, true);
    }
}