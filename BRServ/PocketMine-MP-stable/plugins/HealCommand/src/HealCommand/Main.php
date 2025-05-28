<?php
declare(strict_types=1);

namespace HealCommand;

use healCommand\command\HealCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

/** Final class existe pour "lock" la fonction, très peux de dif a notre niveu pour sans/avec*/
final class Main extends PluginBase implements Listener{

	protected function onEnable() : void{
		/** enregistrement dans la liste des commandes*/
		$this->getServer()->getCommandMap()->register(
			"heal",
			new command/HealCommand($this)
		);

		/** Log à l'activation*/
		$this->getlogger()->info("§a[HealCommand] activé !");
	}

	protected function onDisable() : void{
		/** Log à la desactivation*/
		$this->GetLogger()->info("§a[HealCommand] désactivé !");
	}
}
