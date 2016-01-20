<?php

namespace TheAPI;

// ЮЗИМ ВСЁ ЧТО ВАЗМОЖНА!
use pocketmine\command\Command; 
use pocketmine\command\CommandSender; 
use pocketmine\command\CommandExecutor; 
use pocketmine\command\PluginCommand; 

use pocketmine\event\Listener; 
use pocketmine\event\server\QueryRegenerateEvent; 
use pocketmine\event\block\SignChangeEvent; 
use pocketmine\event\block\BlockBreakEvent; 
use pocketmine\event\block\BlockPlaceEvent; 
use pocketmine\event\entity\EntityDamageByEntityEvent; 
use pocketmine\event\entity\EntityDamageEvent; 
use pocketmine\event\entity\EntityRegainHealthEvent; 
use pocketmine\event\player\PlayerDropItemEvent; 
use pocketmine\event\player\PlayerDeathEvent; 
use pocketmine\event\player\PlayerRespawnEvent; 
use pocketmine\event\player\PlayerInteractEvent; 
use pocketmine\event\player\PlayerKickEvent; 
use pocketmine\event\player\PlayerPreLoginEvent; 
use pocketmine\event\player\PlayerCommandPreprocessEvent; 
use pocketmine\event\player\PlayerJoinEvent; 
use pocketmine\event\player\PlayerLoginEvent; 
use pocketmine\event\player\PlayerQuitEvent; 
use pocketmine\event\player\PlayerMoveEvent; 
use pocketmine\event\player\PlayerChatEvent; 

use pocketmine\entity\Entity; 
use pocketmine\entity\Effect; 
use pocketmine\item\Item; 
use pocketmine\item\enchantment\Enchantment; 
use pocketmine\block\Block; 

use pocketmine\math\Vector3; 
use pocketmine\plugin\Plugin; 
use pocketmine\scheduler\PluginTask; 
use pocketmine\scheduler\CallbackTask; 
use pocketmine\network\protocol\AddEntityPacket; 
use pocketmine\permission\PermissionAttachment; 
use pocketmine\IPlayer; 
use pocketmine\Player; 
use pocketmine\Server; 
use pocketmine\plugin\PluginBase; 

use pocketmine\tile\Sign; 
use pocketmine\tile\Chest; 

use pocketmine\utils\Utils; 
use pocketmine\utils\Config; 
use pocketmine\utils\Random; 
use pocketmine\utils\TextFormat; 
use pocketmine\utils\TextFormat as F; 

use pocketmine\level\particle\FloatingTextParticle; 
use pocketmine\level\Level; 
use pocketmine\level\particle\HeartParticle; 
use pocketmine\level\sound\PopSound; 
use pocketmine\level\Position; 
use pocketmine\math\AxisAlignedBB; 
use pocketmine\nbt\tag\Byte; 
use pocketmine\nbt\tag\Compound; 
use pocketmine\nbt\tag\Double; 
use pocketmine\nbt\tag\Enum; 
use pocketmine\nbt\tag\Float; 
use pocketmine\network\protocol\SetTimePacket;
//АГА ЛОЛ

class Main extends PluginBase implements Listener{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЧТО НАДА - 1. Увеличить кол-во блоков в инвентаре 2. Ломаем блоки, получаем бонус 3. Запрет выкидывать предметы от вип и далее


// РЕГИСТЕРИМ ИВЕНТЫ С САМОГО ЗАПУСКА/////////////////////////////////////////
public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
@mkdir($this->getDataFolder());
@mkdir($this->getDataFolder() . "data/killanddeeath");
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
			else {$p->getInventory()->setSize(25);}
}



################################################################################################################################

// Анти дроп в креативе 
public function dropEvent(PlayerDropItemEvent $e){$p = $e->getPlayer();if($p instanceof Player && !$p->hasPermission("fapi.prm.owner")){ 
if($p->getGamemode() != 0){$e->setCancelled();$p->sendTip(F::RED."Ты не можешь скидывать предметы!");return false;}}}


#################################################################################################################################
// Смерти и убийства

public function onDeath(PlayerDeathEvent $event)
	{
		$victim = $event->getEntity();
		if ($victim instanceof Player){
			$data = new Config($this->getDataFolder() . "data/killanddeeath/" . strtolower($victim->getName()) . ".yml", Config::YAML);
			if ($data->exists("kills") and $data->exists("deaths")){
			 	$data->set("deaths", $data->get("deaths") + 1);
			 	$data->save();
			}
			 else	{$data->setAll(array("kills" => 0, "deaths" => 1));
			 	$data->save();
			 }
			
			$cause = $event->getEntity()->getLastDamageCause()->getCause(); 
			if($cause == 1){ 
			$killer = $event->getEntity()->getLastDamageCause()->getDamager(); 
				if($killer instanceof Player){ 
				$kdata = new Config($this->getDataFolder() . "data/killanddeeath/" . strtolower($killer->getName()) . ".yml", Config::YAML); 
			if($kdata->exists("kills") && $kdata->exists("deaths")){ 
			$kdata->set("kills", $kdata->get("kills") + 1); 
			$kdata->save(); 
			}else{ 
			$kdata->setAll(array("kills" => 1, "deaths" => 0)); 
			$kdata->save(); 
} 
} 
}
			
			
			
			
			
		}
	}
	
####################################################################################################################################################

// Получить кол-во киллов из конфига

public function getKills($player){ 
$data = new Config($this->getDataFolder() . "data/killanddeeath/" . strtolower($player) . ".yml", Config::YAML); 
if($data->exists("kills") && $data->exists("deaths")){ 
return $data->get("kills"); 
}else{ 
$data->setAll(array("kills" => 0, "deaths" => 0)); 
$data->save(); 
} 
} 

// Получить кол-во смертей из конфига 

public function getDeaths($player){ 
$data = new Config($this->getDataFolder() . "data/killanddeeath/" . strtolower($player) . ".yml", Config::YAML); 
if($data->exists("kills") && $data->exists("deaths")){ 
return $data->get("deaths"); 
}else{ 
$data->setAll(array("kills" => 0, "deaths" => 0)); 
$data->save(); 
} 
}

######################################################################################################################################################
//Статистика игры на сервере 

public function onCommand(CommandSender $entity, Command $cmd, $label, array $args){ 
			$level = $this->getServer()->getDefaultLevel(); 
			$x = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getX(); 
			$y = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getY(); 
			$z = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getZ(); 
				switch($cmd->getName()){
	
					case "info": 
					if($entity Instanceof Player){ 
									if($entity->hasPermission("fapi.prm.info")){ 
									$name = $entity->getName(); 
									if($entity->hasPermission("fapi.prm.vip")){ 
$group = "GUEST"; 
}elseif($entity->hasPermission("fapi.prm.prem")){ 
$group = "VIP"; 
}elseif($entity->hasPermission("fapi.prm.creat")){ 
$group = "GM"; 
}elseif($entity->hasPermission("fapi.prm.moder")){ 
$group = "ADMIN"; 
}elseif($entity->hasPermission("fapi.prm.admin")){ 
$group = "OWNER"; 
}elseif($entity->hasPermission("fapi.prm.gladm")){ 
$group = "OP"; 
}elseif($entity->hasPermission("fapi.prm.owner")){ 
$group = "Основатель"; 
}else{ 
$group = "GUEST"; 
} 
}else{ 
$entity->sendMessage(F::RED. "Тебе не доступна данная команда!"); }
$name = $entity->getName(); 
$money = $this->eco->mymoney($name); 
$kills = $this->getKills($name); 
$death = $this->getDeaths($name); 
$plus = 3; 
$datemsk = gmdate("H:i:s", time() + ($plus*3600)); 
$x = $entity->getFloorX(); 
$y = $entity->getFloorY(); 
$z = $entity->getFloorZ(); 
$entity->sendMessage(F::YELLOW. "Ваш ник: " .F::AQUA. "$name"); 
$entity->sendMessage(F::YELLOW. "Ваш баланс: " .F::GOLD. "$money" .F::YELLOW. "$"); 
$entity->sendMessage(F::YELLOW. "Ваши права: " .F::DARK_AQUA. "$group"); 
$entity->sendMessage(F::YELLOW. "Сейчас время: " .F::GREEN. "$datemsk " .F::GRAY. "(МСК)"); 
$entity->sendMessage(F::YELLOW. "Ваши киллы: " .F::RED. "$kills"); 
$entity->sendMessage(F::YELLOW. "Ваши смерти: " .F::RED. "$death"); 
$entity->sendMessage(F::YELLOW. "Ваши координаты: " .F::RED. "$x, $y, $z"); 
} 
break;
		}
	}

	













































}
