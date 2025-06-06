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

namespace pocketmine\world\biome\model;

/**
 * Model for loading biome definition entries data from JSON.
 */
final class BiomeDefinitionEntryData{
	/** @required */
	public ?int $id;

	/** @required */
	public float $temperature;

	/** @required */
	public float $downfall;

	/** @required */
	public float $redSporeDensity;

	/** @required */
	public float $blueSporeDensity;

	/** @required */
	public float $ashDensity;

	/** @required */
	public float $whiteAshDensity;

	/** @required */
	public float $depth;

	/** @required */
	public float $scale;

	/** @required */
	public ColorData $mapWaterColour;

	/** @required */
	public bool $rain;

	/**
	 * @required
	 * @var string[]
	 * @phpstan-var list<string>
	 */
	public array $tags;
}
