<?php

declare(strict_types=1);

namespace RandomTeleport\utils;

use pocketmine\entity\effect\Effect;
use pocketmine\world\sound\Sound;
use RandomTeleport\RandomTeleport;

final class ConfigManager
{
    public readonly int $minCoord;
    public readonly int $maxCoord;

    /** @var array<string, string> */
    public readonly array $worlds;

    public readonly bool $cooldownEnabled;
    public readonly int  $cooldownSeconds;

    public readonly bool $checkSurface;

    public readonly bool    $effectEnabled;
    public readonly ?Effect $effect;
    public readonly int     $effectDuration;
    public readonly int     $effectAmplifier;

    public readonly bool   $soundEnabled;
    public readonly ?Sound $sound;

    public readonly bool $chatEnabled;
    public readonly bool $titleEnabled;
    public readonly int  $titleFadeIn;
    public readonly int  $titleStay;
    public readonly int  $titleFadeOut;
    public readonly bool $actionbarEnabled;

    public readonly LangManager $lang;

    /** @var string[] */
    public readonly array $warnings;

    public function __construct(RandomTeleport $plugin)
    {
        $cfg   = $plugin->getConfig()->getAll();
        $warns = [];

        $langName   = (string)($cfg['lang'] ?? 'en');
        $this->lang = new LangManager($plugin, $langName);

        $this->minCoord = (int)($cfg['coordinates']['min'] ?? -1000);
        $this->maxCoord = (int)($cfg['coordinates']['max'] ?? 1000);

        $rawWorlds    = $cfg['worlds'] ?? [];
        $this->worlds = is_array($rawWorlds) ? array_map('strval', $rawWorlds) : [];

        $this->cooldownEnabled = (bool)($cfg['cooldown']['enabled'] ?? false);
        $this->cooldownSeconds = max(1, (int)($cfg['cooldown']['seconds'] ?? 60));

        $this->checkSurface = (bool)($cfg['check_surface'] ?? false);

        $this->effectEnabled   = (bool)($cfg['effect']['enabled'] ?? false);
        $this->effectDuration  = max(1, (int)($cfg['effect']['duration'] ?? 60));
        $this->effectAmplifier = max(0, (int)($cfg['effect']['amplifier'] ?? 0));

        $effectName     = (string)($cfg['effect']['name'] ?? 'BLINDNESS');
        $resolvedEffect = EffectResolver::resolve($effectName);
        if ($this->effectEnabled && $resolvedEffect === null) {
            $warns[] = $this->lang->get('invalid_effect', ['{effect}' => $effectName]);
        }
        $this->effect = $resolvedEffect;

        $this->soundEnabled = (bool)($cfg['sound']['enabled'] ?? false);
        $soundName          = (string)($cfg['sound']['name'] ?? 'EndermanTeleportSound');
        $resolvedSound      = SoundResolver::resolve($soundName);
        if ($this->soundEnabled && $resolvedSound === null) {
            $warns[] = $this->lang->get('invalid_sound', ['{sound}' => $soundName]);
        }
        $this->sound = $resolvedSound;

        $this->chatEnabled = (bool)($cfg['messages']['chat']['enabled'] ?? false);

        $this->titleEnabled  = (bool)($cfg['messages']['title']['enabled'] ?? false);
        $this->titleFadeIn   = max(0, (int)($cfg['messages']['title']['fade_in'] ?? 10));
        $this->titleStay     = max(1, (int)($cfg['messages']['title']['stay'] ?? 40));
        $this->titleFadeOut  = max(0, (int)($cfg['messages']['title']['fade_out'] ?? 10));

        $this->actionbarEnabled = (bool)($cfg['messages']['actionbar']['enabled'] ?? false);

        $this->warnings = $warns;
    }
}
