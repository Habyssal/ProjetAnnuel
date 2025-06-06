<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\world\generator;

use pocketmine\data\bedrock\BiomeIds;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\LegacyStringToItemParserException;
use pocketmine\world\World;
use function array_map;
use function explode;
use function preg_match;
use function preg_match_all;
use const PHP_INT_MAX;

/**
 * @internal
 */
final class FlatGeneratorOptions{

	/**
	 * @param int[]   $structure
	 * @param mixed[] $extraOptions
	 * @phpstan-param array<int, int> $structure
	 * @phpstan-param array<string, array<string, string>|true> $extraOptions
	 */
	public function __construct(
		private array $structure,
		private int $biomeId,
		private array $extraOptions = []
	){}

	/**
	 * @return int[]
	 * @phpstan-return array<int, int>
	 */
	public function getStructure() : array{ return $this->structure; }

	public function getBiomeId() : int{ return $this->biomeId; }

	/**
	 * @return mixed[]
	 * @phpstan-return array<string, array<string, string>|true>
	 */
	public function getExtraOptions() : array{ return $this->extraOptions; }

	/**
	 * @return int[]
	 * @phpstan-return array<int, int>
	 *
	 * @throws InvalidGeneratorOptionsException
	 */
	public static function parseLayers(string $layers) : array{
		$result = [];
		$split = array_map('\trim', explode(',', $layers, limit: World::Y_MAX - World::Y_MIN));
		$y = 0;
		$itemParser = LegacyStringToItemParser::getInstance();
		foreach($split as $line){
			if(preg_match('#^(?:(\d+)[x|*])?(.+)$#', $line, $matches) !== 1){
				throw new InvalidGeneratorOptionsException("Invalid preset layer \"$line\"");
			}

			$cnt = $matches[1] !== "" ? (int) $matches[1] : 1;
			try{
				$b = $itemParser->parse($matches[2])->getBlock();
			}catch(LegacyStringToItemParserException $e){
				throw new InvalidGeneratorOptionsException("Invalid preset layer \"$line\": " . $e->getMessage(), 0, $e);
			}
			for($cY = $y, $y += $cnt; $cY < $y; ++$cY){
				$result[$cY] = $b->getStateId();
			}
		}

		return $result;
	}

	/**
	 * @throws InvalidGeneratorOptionsException
	 */
	public static function parsePreset(string $presetString) : self{
		$preset = explode(";", $presetString, limit: 4);
		$blocks = $preset[1] ?? "";
		$biomeId = (int) ($preset[2] ?? BiomeIds::PLAINS);
		$optionsString = $preset[3] ?? "";
		$structure = self::parseLayers($blocks);

		$options = [];
		//TODO: more error checking
		preg_match_all('#(([0-9a-z_]{1,})\(?([0-9a-z_ =:]{0,})\)?),?#', $optionsString, $matches);
		foreach($matches[2] as $i => $option){
			$params = true;
			if($matches[3][$i] !== ""){
				$params = [];
				$p = explode(" ", $matches[3][$i], limit: PHP_INT_MAX);
				foreach($p as $k){
					//TODO: this should be limited to 2 parts, but 3 preserves old behaviour when given e.g. treecount=20=1
					$k = explode("=", $k, limit: 3);
					if(isset($k[1])){
						$params[$k[0]] = $k[1];
					}
				}
			}
			$options[$option] = $params;
		}
		return new self($structure, $biomeId, $options);
	}

}
