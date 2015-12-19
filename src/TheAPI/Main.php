<?php

namespace TheAPI;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\entity\Entity;

class Main extends PluginBase implements Listener{

// ЧТО НАДА - 1. Увеличить кол-во блоков в инвентаре 2. Ломаем блоки, получаем бонус 3. Запрет выкидывать предметы от вип и далее


// РЕГИСТЕРИМ ИВЕНТЫ С САМОГО ЗАПУСКА
public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
}


//СЕРВЕР ИНВЕНТАРЬ
public function onJoin(PlayerJoinEvent $inv){ 
	$p = $inv->getPlayer(); 
		$p->getName(); 
			if($inv->getPlayer()->hasPermission("inv.vip")){ 
					$p->getInventory()->setSize(10); 
									}
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
