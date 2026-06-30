<?php

declare(strict_types=1);

namespace RandomTeleport\utils;

use pocketmine\world\sound\BellRingSound;
use pocketmine\world\sound\BowShootSound;
use pocketmine\world\sound\BurpSound;
use pocketmine\world\sound\ChorusFlowerGrowSound;
use pocketmine\world\sound\EndermanTeleportSound;
use pocketmine\world\sound\ExplodeSound;
use pocketmine\world\sound\FireworkExplosionSound;
use pocketmine\world\sound\FireworkLargeExplosionSound;
use pocketmine\world\sound\FireworkLaunchSound;
use pocketmine\world\sound\FizzSound;
use pocketmine\world\sound\FlintSteelSound;
use pocketmine\world\sound\GhastShootSound;
use pocketmine\world\sound\GhastSound;
use pocketmine\world\sound\IgniteSound;
use pocketmine\world\sound\LaunchSound;
use pocketmine\world\sound\PopSound;
use pocketmine\world\sound\PotionSplashSound;
use pocketmine\world\sound\Sound;
use pocketmine\world\sound\ThrowSound;
use pocketmine\world\sound\TotemUseSound;
use pocketmine\world\sound\WaterSplashSound;
use pocketmine\world\sound\XpCollectSound;
use pocketmine\world\sound\XpLevelUpSound;

final class SoundResolver
{
    /** @var array<string, class-string<Sound>> */
    private static array $map = [
        'endermanteleportsound'       => EndermanTeleportSound::class,
        'bellringsound'               => BellRingSound::class,
        'bowshootsound'               => BowShootSound::class,
        'burpsound'                   => BurpSound::class,
        'chorusflowergrowsound'       => ChorusFlowerGrowSound::class,
        'explodesound'                => ExplodeSound::class,
        'fireworkexplosionsound'      => FireworkExplosionSound::class,
        'fireworklargeexplosionsound' => FireworkLargeExplosionSound::class,
        'fireworklaunchsound'         => FireworkLaunchSound::class,
        'fizzsound'                   => FizzSound::class,
        'flintsteelsound'             => FlintSteelSound::class,
        'ghastshootsound'             => GhastShootSound::class,
        'ghostsound'                  => GhastSound::class,
        'igniteSound'                 => IgniteSound::class,
        'launchsound'                 => LaunchSound::class,
        'popsound'                    => PopSound::class,
        'potionsplashsound'           => PotionSplashSound::class,
        'throwsound'                  => ThrowSound::class,
        'totemusesound'               => TotemUseSound::class,
        'watersplashsound'            => WaterSplashSound::class,
        'xpcollectsound'              => XpCollectSound::class,
        'xplevelupsound'              => XpLevelUpSound::class,
    ];

    public static function resolve(string $name): ?Sound
    {
        $class = self::$map[strtolower($name)] ?? null;
        return $class !== null ? new $class() : null;
    }
}
