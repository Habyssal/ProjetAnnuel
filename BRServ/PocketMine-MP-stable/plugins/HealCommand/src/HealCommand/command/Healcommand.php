<?php
declare(strict_types = 1);

namespace healCommand\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\player\Player;
use pocketmine\Plugin\plugin;

final class HealCommand extends Command{

	/** @var Plugin */
	private Plugin $plugin;

	public function __construct(Plugin $plugin){
		parent::__construct(
			"heal",
			"Heal command",
			"/heal [joueur]",
			["heal"]
		);
		$this->setPermission("heal.use");
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $label, array $args): bool{
		if($this->testPermission($sender)){
			return true;
		}
		if(count($args) === 0){
			if($sender instanceof Player){
				$sender->sendMessage("§cUtilisez /heal <joueur> depuis la console.");
				return true;
			}
			$this->healPlayer($sender);
			$sender->sendMessage("§c You got healed!");
			return true;
		}
		if(!$sender->hasPermission("heal.use")){
			$sender->sendMessage("No Permission to heal other players.");
			return true;
		}
		$targetName = array_shift($args);;
		$target = $this->plugin->getServer()->getPlayerExact($targetName);

		if($target instanceof Player){
			$this->healPlayer($target);
			$target ->sendMessage("You got healed by ".$sender->getName()."§a !");
			$sender->sendMessage("You healed ".$target->getName()."§a !" );
		}else{
			$sender->sendMessage("§cPlayer §e".$targetName." §cnot found!.");
		}
		return true;
	}
	private function healPlayer(Player $player) : void {
		$player-> setHealth($player->getMaxHealth());
		$player-> getHungerManager()->setFood($player->getHungerManager()->getMaxFood());
		$player-> getHungerManager()->setSaturation(20);
		$player-> extinguish();
	}
}