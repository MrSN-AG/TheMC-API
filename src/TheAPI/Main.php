<?php

namespace TheAPI;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

// ЧТО НАДА - 1. Увеличить кол-во блоков в инвентаре 2. Ломаем блоки, получаем бонус 3. Запрет выкидывать предметы от вип и далее


// РЕГИСТЕРИМ ИВЕНТЫ С САМОГО ЗАПУСКА
public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
}

public function onJoin(PlayerJoinEvent $inv)
	{
		$player = $inv->getPlayer()->getName();
			if ($inv->getPlayer()->hasPermission("inv.vip")) {
				$inv->getPlayer()->getInventory()->setSize(50);	
			}
			else { $inv->getPlayer()->getInventory()->setSize(36);}
		
	}
				
		



//Персональная фича для Сани (P.S чтоб не заходили какашки)
/*
public function onJoin(PlayerJoinEvent $e){
	$p = $e->getPlayer();
				if($p->getName() == "MrSN" && $a = $p->getAddress() == "192.168.0.1")
				$p->sendMessage("TheMC: Succsessful");
				 else  $p->kick(); 
                }
}
*/

}
