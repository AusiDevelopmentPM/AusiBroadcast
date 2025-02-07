<?php
/*
 * @author vNoaaah
 * @DATE 06.02.2025
 * @PROJECT AusiBroadcast
 * @LICENSE Just Dont Steal
 * 
 * Copyright (c) Noah Weixelbaum
 * All rights reserved.
 * 
 */

namespace AusiDevelopment\AusiBroadcast;

use asiope\lobby\LobbyNavigator;
use AusiDevelopment\AusiBroadcast\commands\AusiBroadcastCommand;
use AusiDevelopment\AusiBroadcast\tasks\AusiBroadcastTask;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Loader extends PluginBase {

    private static Loader $loader;

    public function onLoad(): void
    {
        self::$loader = $this;
        $cmdcfg = new Config($this->getDataFolder() . "command.yml", Config::YAML);
        $perm = new Permission($cmdcfg->getAll()["Commands"]["AusiBroadcast"]["permission"]);
        PermissionManager::getInstance()->addPermission($perm);
    }

    public function getConfigYml(): Config
    {
        return new Config(Loader::getLoader()->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onEnable(): void
    {
        $this->getLogger()->info("Enabled AusiBroadcast");
        $this->saveDefaultConfig();
        $this->saveResource("command.yml");

        $map = Server::getInstance()->getCommandMap();

        $map->registerAll("AusiBroadcast", [
            new AusiBroadcastCommand(),
        ]);




        $this->getScheduler()->scheduleRepeatingTask(new AusiBroadcastTask($this), 20 * $this->getConfigYml()->getAll()["AusiBroadcast"]["Delay"]);

    }


    public function getPrefix(): string
    {
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        return str_replace(["&"], ["§"], $cfg->get("Prefix"));
    }

    public static function getLoader(): Loader
    {
        return self::$loader;
    }

}