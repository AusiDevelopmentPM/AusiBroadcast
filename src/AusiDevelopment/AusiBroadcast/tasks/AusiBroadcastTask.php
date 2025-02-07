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

namespace AusiDevelopment\AusiBroadcast\tasks;

use AusiDevelopment\AusiBroadcast\Loader;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class AusiBroadcastTask extends Task {

    private Loader $loader;
    private int $i;

    public function __construct(Loader $loader) {
        $this->loader = $loader;
        $this->i = 0;
    }

    public function onRun() : void {
        $title = $this->loader->getConfigYml()->get("Title");
        $messages = $this->loader->getConfigYml()->getAll()["AusiBroadcast"]["Messages"];
        $mode = $this->loader->getConfigYml()->getAll()["AusiBroadcast"]["Mode"];
        back:
        if ($this->i < count($messages)) {
            $msg = str_replace(["&", "{PREFIX}", "{api}", "{online}", "{max}", "{motd}"], ["§", Loader::getLoader()->getPrefix(), Server::getInstance()->getApiVersion(), count(Server::getInstance()->getOnlinePlayers()), 25, Server::getInstance()->getMotd()], $messages[$this->i]);
            if ($mode === "message") {
                Server::getInstance()->broadcastMessage($title . " " . $msg);
            } elseif ($mode === "tip") {
                Server::getInstance()->broadcastMessage($title . " " . $msg);
            }

            $this->i++;
        } else {
            $this->i = 0;
            goto back;
        }
    }

}