<?php

declare(strict_types=1);

namespace RandomTeleport;

use pocketmine\plugin\PluginBase;
use RandomTeleport\command\RandomTeleportCommand;
use RandomTeleport\utils\ConfigManager;

class RandomTeleport extends PluginBase
{
    private static self $instance;

    private ConfigManager $cfg;

    /** @var array<string, int> */
    private array $cooldowns = [];

    protected function onEnable(): void
    {
        self::$instance = $this;

        $this->saveDefaultConfig();
        $this->saveResource('lang/en.json', false);
        $this->saveResource('lang/ru.json', false);
        $this->saveResource('lang/custom.json', false);
        $this->reloadCfg();

        $this->getServer()->getCommandMap()->register(
            '',
            new RandomTeleportCommand($this)
        );

        $this->getLogger()->info('§aRandomTeleport v' . $this->getDescription()->getVersion() . ' enabled.');
    }

    protected function onDisable(): void
    {
        $this->getLogger()->info('§cRandomTeleport disabled.');
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function getCfg(): ConfigManager
    {
        return $this->cfg;
    }

    public function reloadCfg(): void
    {
        $this->cfg = new ConfigManager($this);

        foreach ($this->cfg->warnings as $warn) {
            $this->getLogger()->warning(strip_tags($warn));
        }
    }

    public function getCooldownRemaining(string $playerName): int
    {
        if (!isset($this->cooldowns[$playerName])) {
            return 0;
        }
        $remaining = $this->cooldowns[$playerName] - time();
        if ($remaining <= 0) {
            unset($this->cooldowns[$playerName]);
            return 0;
        }
        return $remaining;
    }

    public function setCooldown(string $playerName): void
    {
        $this->cooldowns[$playerName] = time() + $this->cfg->cooldownSeconds;
    }

    public function clearCooldown(string $playerName): void
    {
        unset($this->cooldowns[$playerName]);
    }
}
