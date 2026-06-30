<?php

declare(strict_types=1);

namespace RandomTeleport\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\format\Chunk;
use RandomTeleport\RandomTeleport;

class RandomTeleportCommand extends Command
{
    public function __construct(private RandomTeleport $plugin)
    {
        parent::__construct(
            'rtp',
            'Random teleportation',
            '/rtp [reload]',
            ['randomteleport']
        );
        $this->setPermission('rtp.use');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        $cfg  = $this->plugin->getCfg();
        $lang = $cfg->lang;

        if (isset($args[0]) && strtolower($args[0]) === 'reload') {
            if (!$sender->hasPermission('rtp.reload')) {
                $sender->sendMessage($lang->get('no_permission'));
                return;
            }
            $this->plugin->reloadConfig();
            $this->plugin->reloadCfg();
            $sender->sendMessage($this->plugin->getCfg()->lang->get('config_reloaded'));
            foreach ($this->plugin->getCfg()->warnings as $warn) {
                $sender->sendMessage($warn);
            }
            return;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage($lang->get('only_in_game'));
            return;
        }

        if (!$sender->hasPermission('rtp.use')) {
            $sender->sendMessage($lang->get('no_permission'));
            return;
        }

        $currentWorld = $sender->getWorld()->getFolderName();
        if (!isset($cfg->worlds[$currentWorld])) {
            $sender->sendMessage($lang->get('world_not_allowed'));
            return;
        }

        $targetWorldName = $cfg->worlds[$currentWorld];
        $targetWorld     = $this->plugin->getServer()->getWorldManager()->getWorldByName($targetWorldName);
        if ($targetWorld === null) {
            $sender->sendMessage($lang->get('world_not_loaded', ['{world}' => $targetWorldName]));
            return;
        }

        if ($cfg->cooldownEnabled && !$sender->hasPermission('rtp.bypass.cooldown')) {
            $remaining = $this->plugin->getCooldownRemaining($sender->getName());
            if ($remaining > 0) {
                $replace = ['{seconds}' => (string)$remaining];
                if ($cfg->chatEnabled) {
                    $sender->sendMessage($lang->get('on_cooldown', $replace));
                }
                if ($cfg->actionbarEnabled) {
                    $sender->sendTip($lang->get('actionbar_cooldown', $replace));
                }
                return;
            }
        }

        $x = mt_rand($cfg->minCoord, $cfg->maxCoord);
        $z = mt_rand($cfg->minCoord, $cfg->maxCoord);

        if ($cfg->effectEnabled && $cfg->effect !== null) {
            $sender->getEffects()->add(new EffectInstance(
                $cfg->effect,
                $cfg->effectDuration,
                $cfg->effectAmplifier,
                false
            ));
        }

        $targetWorld->orderChunkPopulation(
            $x >> Chunk::COORD_BIT_SIZE,
            $z >> Chunk::COORD_BIT_SIZE,
            null
        )->onCompletion(
            function () use ($sender, $targetWorld, $x, $z, $cfg, $lang): void {
                if (!$sender->isOnline()) {
                    return;
                }

                $y = $targetWorld->getHighestBlockAt($x, $z);
                if ($y === null) {
                    if ($cfg->chatEnabled) {
                        $sender->sendMessage($lang->get('no_safe_spot'));
                    }
                    return;
                }

                if ($cfg->checkSurface) {
                    $b1 = $targetWorld->getBlockAt($x, $y + 1, $z);
                    $b2 = $targetWorld->getBlockAt($x, $y + 2, $z);
                    if ($b1->isSolid() || $b2->isSolid()) {
                        if ($cfg->chatEnabled) {
                            $sender->sendMessage($lang->get('no_safe_spot'));
                        }
                        return;
                    }
                }

                $position = new Vector3($x + 0.5, $y + 1, $z + 0.5);

                $sender->teleport(Location::fromObject(
                    $position,
                    $targetWorld,
                    $sender->getLocation()->yaw,
                    $sender->getLocation()->pitch
                ));

                if ($cfg->cooldownEnabled && !$sender->hasPermission('rtp.bypass.cooldown')) {
                    $this->plugin->setCooldown($sender->getName());
                }

                if ($cfg->soundEnabled && $cfg->sound !== null) {
                    $sound = $cfg->sound;
                    $pos   = $position;
                    $this->plugin->getScheduler()->scheduleDelayedTask(
                        new ClosureTask(static function () use ($targetWorld, $pos, $sound, $sender): void {
                            if ($sender->isOnline()) {
                                $targetWorld->addSound($pos, $sound, [$sender]);
                            }
                        }),
                        5
                    );
                }

                $replace = [
                    '{x}' => (string)(int)$position->x,
                    '{y}' => (string)(int)$position->y,
                    '{z}' => (string)(int)$position->z,
                ];

                if ($cfg->chatEnabled) {
                    $sender->sendMessage($lang->get('teleported', $replace));
                }

                if ($cfg->titleEnabled) {
                    $sender->sendTitle(
                        $lang->get('title_title'),
                        $lang->get('title_subtitle'),
                        $cfg->titleFadeIn,
                        $cfg->titleStay,
                        $cfg->titleFadeOut
                    );
                }

                if ($cfg->actionbarEnabled) {
                    $sender->sendTip($lang->get('actionbar_teleported', $replace));
                }
            },
            fn() => null
        );
    }
}
