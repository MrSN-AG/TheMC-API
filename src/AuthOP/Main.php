<?php

namespace AuthOP;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
}

public function onJoin(PlayerJoinEvent $e){
	$p = $e->getPlayer();
				if($p->getName() == "MrSN" && $a = $p->getAddress() == "addressip"){
				$p->sendMessage("TheMC: Succsessful");
				} else { $p->kickPlayer();
                        }
                }
}
?>
