<?php

declare(strict_types=1);

namespace PlayerShop;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEntityInteractEvent;


/** Squelette principal, meme format que /heal -> Logique et travail dans les fonctions. */

final class PlayerShop extends PluginBase implements Listener{

	/** TODO : Mettre le shopmanager(fonctions gestion du shop) et le lien discord (api,token?,on fait quoi?) */

	protected function onEnable() : void{
		/** call du gestionnaire, call & enregistrement des command dans "getCommandMap();"  */

		/** Clic sur NPC  */
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		/** Lien Discord call api etc ? surement ici... */

		/** logs */
		$this->getLogger()->info("§a[PlayerShop] Activé");
	}
	protected function onDisable() : void{
		$this->shopManager->shutdown(); /** auto sync (forced) */
		$this->/** discord call */->shutdown();  /** shutdown discord link */
		$this->getLogger()->info("§c[PlayerShop] Désactivé"); /** log  */
	}

	/** TODO : D'après la doc de Pocketmine il faudrais faire une fonction pour capter le clic (pas automatique)  */
}

