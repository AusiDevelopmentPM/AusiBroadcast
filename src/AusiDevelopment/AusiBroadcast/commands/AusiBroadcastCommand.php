<?php
/*
 * @author vNoaaah
 * @DATE 07.02.2025
 * @PROJECT AusiBroadcast
 * @LICENSE Just Dont Steal
 * 
 * Copyright (c) Noah Weixelbaum
 * All rights reserved.
 * 
 */

namespace AusiDevelopment\AusiBroadcast\commands;

use AusiDevelopment\AusiBroadcast\Loader;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\utils\Config;

class AusiBroadcastCommand extends VanillaCommand {

    public function __construct()
    {
        $cmdcfg = new Config(Loader::getLoader()->getDataFolder() . "command.yml", Config::YAML);
        parent::__construct($cmdcfg->getAll()["Commands"]["AusiBroadcast"]["name"], "AusiBroadcast Command");
        $this->setLabel("ausi");
        $this->setPermission($cmdcfg->getAll()["Commands"]["AusiBroadcast"]["permission"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        // TODO: Implement execute() method.
    }
}