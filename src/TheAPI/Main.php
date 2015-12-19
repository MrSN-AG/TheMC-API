<?php

namespace TheAPI;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\entity\Entity;
use pocketmine\event\server\QueryRegenerateEvent;

class Main extends PluginBase implements Listener{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЧТО НАДА - 1. Увеличить кол-во блоков в инвентаре 2. Ломаем блоки, получаем бонус 3. Запрет выкидывать предметы от вип и далее


// РЕГИСТЕРИМ ИВЕНТЫ С САМОГО ЗАПУСКА/////////////////////////////////////////
public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

#########################################################################################################################
//Инвентарь игроков
public function onDonateJoinINV(PlayerJoinEvent $inv){ 
	$p = $inv->getPlayer(); 
		$p->getName(); 
			if($inv->getPlayer()->hasPermission("inv.vip")){ 
					$p->getInventory()->setSize(50);}
			elseif ($inv->getPlayer()->hasPermission("inv.creative")){ 
					$p->getInventory()->setSize(70);} 
			elseif ($inv->getPlayer()->hasPermission("inv.admin")){ 
					$p->getInventory()->setSize(100);}
			else {$p->getInventory()->setSize(25)}
}

###########################################################################################################################
//Добавляем фэйк онлайн
				
public function fakeOnline(QueryRegenerateEvent $fakeon)		

	{
		
	$r = mt_rand(1, 2);
	$fakeon->setMaxPlayerCount(1);
	if ($r == 1) {
		$fakeon->setPlayerCount($fakeon->getPlayerCount() + mt_rand(10, 50));
	}
	else {$fakeon->setPlayerCount($fakeon->getPlayerCount() + mt_rand(10, 50));}
	
	}
	
#############################################################################################################################
	
	












































}
