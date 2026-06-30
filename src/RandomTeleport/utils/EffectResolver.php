<?php

declare(strict_types=1);

namespace RandomTeleport\utils;

use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\VanillaEffects;

final class EffectResolver
{
    /** @var array<string, callable(): Effect> */
    private static array $map = [
        'absorption'      => [VanillaEffects::class, 'ABSORPTION'],
        'blindness'       => [VanillaEffects::class, 'BLINDNESS'],
        'conduit_power'   => [VanillaEffects::class, 'CONDUIT_POWER'],
        'darkness'        => [VanillaEffects::class, 'DARKNESS'],
        'fatal_poison'    => [VanillaEffects::class, 'FATAL_POISON'],
        'fire_resistance' => [VanillaEffects::class, 'FIRE_RESISTANCE'],
        'haste'           => [VanillaEffects::class, 'HASTE'],
        'health_boost'    => [VanillaEffects::class, 'HEALTH_BOOST'],
        'hunger'          => [VanillaEffects::class, 'HUNGER'],
        'instant_damage'  => [VanillaEffects::class, 'INSTANT_DAMAGE'],
        'instant_health'  => [VanillaEffects::class, 'INSTANT_HEALTH'],
        'invisibility'    => [VanillaEffects::class, 'INVISIBILITY'],
        'jump_boost'      => [VanillaEffects::class, 'JUMP_BOOST'],
        'levitation'      => [VanillaEffects::class, 'LEVITATION'],
        'mining_fatigue'  => [VanillaEffects::class, 'MINING_FATIGUE'],
        'nausea'          => [VanillaEffects::class, 'NAUSEA'],
        'night_vision'    => [VanillaEffects::class, 'NIGHT_VISION'],
        'poison'          => [VanillaEffects::class, 'POISON'],
        'regeneration'    => [VanillaEffects::class, 'REGENERATION'],
        'resistance'      => [VanillaEffects::class, 'RESISTANCE'],
        'saturation'      => [VanillaEffects::class, 'SATURATION'],
        'slowness'        => [VanillaEffects::class, 'SLOWNESS'],
        'speed'           => [VanillaEffects::class, 'SPEED'],
        'strength'        => [VanillaEffects::class, 'STRENGTH'],
        'water_breathing' => [VanillaEffects::class, 'WATER_BREATHING'],
        'weakness'        => [VanillaEffects::class, 'WEAKNESS'],
        'wither'          => [VanillaEffects::class, 'WITHER'],
    ];

    public static function resolve(string $name): ?Effect
    {
        $callable = self::$map[strtolower($name)] ?? null;
        return $callable !== null ? ($callable)() : null;
    }
}
