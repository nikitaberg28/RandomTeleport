<div align="center">

# RandomTeleport

[![API](https://img.shields.io/badge/API-5.0.0+-blue?style=flat-square)](https://github.com/pmmp/PocketMine-MP)
[![PMMP](https://img.shields.io/badge/PocketMine--MP-5.0.0+-green?style=flat-square)](https://github.com/pmmp/PocketMine-MP)
[![NetherGames](https://img.shields.io/badge/NetherGames-5.0.0+-orange?style=flat-square)](https://github.com/NetherGamesMC)

[English](#english) / [Русский](#русский)

</div>

---

<a name="english"></a>
## English

### What it does

Teleports players to a random location with a single command. Supports cross-world teleportation, cooldowns, effects, sounds, per-world mapping, and multilingual messages — all controlled from one config file.

### Commands

| Command | Description | Permission |
|---|---|---|
| `/rtp` | Teleport to a random location | `rtp.use` |
| `/randomteleport` | Alias for `/rtp` | `rtp.use` |
| `/rtp reload` | Reload config and lang files | `rtp.reload` |

### Permissions

| Permission | Description | Default |
|---|---|---|
| `rtp.use` | Use `/rtp` | `true` |
| `rtp.reload` | Use `/rtp reload` | `op` |
| `rtp.bypass.cooldown` | Skip cooldown | `op` |

### Configuration

```yaml
# en / ru / custom
lang: en

coordinates:
  min: -1000
  max: 1000

# key is the world where /rtp is typed, value is the world to teleport into
worlds:
  world: world
  world_nether: world
  world_the_end: world

cooldown:
  enabled: false
  seconds: 60

# check that 2 air blocks exist above the landing spot
check_surface: false

effect:
  enabled: false
  name: BLINDNESS      # see full list below
  duration: 60         # ticks (20 = 1 second)
  amplifier: 0

sound:
  enabled: false
  name: EndermanTeleportSound   # see full list below

messages:
  chat:
    enabled: false
  title:
    enabled: false
    fade_in: 10
    stay: 40
    fade_out: 10
  actionbar:
    enabled: false
```

### Available effects

`ABSORPTION` `BLINDNESS` `CONDUIT_POWER` `DARKNESS` `FATAL_POISON` `FIRE_RESISTANCE`
`HASTE` `HEALTH_BOOST` `HUNGER` `INSTANT_DAMAGE` `INSTANT_HEALTH` `INVISIBILITY`
`JUMP_BOOST` `LEVITATION` `MINING_FATIGUE` `NAUSEA` `NIGHT_VISION` `POISON`
`REGENERATION` `RESISTANCE` `SATURATION` `SLOWNESS` `SPEED` `STRENGTH`
`WATER_BREATHING` `WEAKNESS` `WITHER`

### Available sounds

`EndermanTeleportSound` `BellRingSound` `BowShootSound` `BurpSound` `ChorusFlowerGrowSound`
`ExplodeSound` `FireworkExplosionSound` `FireworkLargeExplosionSound` `FireworkLaunchSound`
`FizzSound` `FlintSteelSound` `GhastShootSound` `GhastSound` `IgniteSound` `LaunchSound`
`PopSound` `PotionSplashSound` `ThrowSound` `TotemUseSound` `WaterSplashSound`
`XpCollectSound` `XpLevelUpSound`

### Custom language

Set `lang: custom` in config, then edit `plugins/RandomTeleport/lang/custom.json`:

```json
{
  "teleported": "§aTeleported! §7({x}, {y}, {z})",
  "on_cooldown": "§cWait §e{seconds}s.",
  "no_safe_spot": "§cNo safe spot found.",
  "only_in_game": "§cIn-game only.",
  "world_not_allowed": "§cNot allowed from this world.",
  "world_not_loaded": "§cWorld §e{world}§c is not loaded.",
  "config_reloaded": "§aReloaded.",
  "invalid_effect": "§cEffect §e{effect}§c not found. Disabled.",
  "invalid_sound": "§cSound §e{sound}§c not found. Disabled.",
  "no_permission": "§cNo permission.",
  "title_title": "§9RTP",
  "title_subtitle": "§aTeleported!",
  "actionbar_teleported": "§aTeleported! §7({x}, {y}, {z})",
  "actionbar_cooldown": "§cWait §e{seconds}s"
}
```

Placeholders: `{x}` `{y}` `{z}` `{seconds}` `{world}` `{effect}` `{sound}`

---

<a name="русский"></a>
## Русский

### Подробнее

Телепортирует игрока в случайное место одной командой. Поддерживает телепортацию между мирами, кулдауны, эффекты, звуки, маппинг миров и мультиязычные сообщения всё настраивается в одном конфиге.

### Команды

| Команда | Описание                          | Права |
|---|-----------------------------------|---|
| `/rtp` | Телепортация в случайное место    | `rtp.use` |
| `/randomteleport` | Алиас `/rtp`                      | `rtp.use` |
| `/rtp reload` | Перезагрузить конфиг и файл языка | `rtp.reload` |

### Права

| Право | Описание | По умолчанию |
|---|---|---|
| `rtp.use` | Использовать `/rtp` | `true` |
| `rtp.reload` | Использовать `/rtp reload` | `op` |
| `rtp.bypass.cooldown` | Пропускать кулдаун | `op` |

### Конфигурация

```yaml
# en / ru / custom
lang: ru

coordinates:
  min: -1000
  max: 1000

# ключ — мир где вводят /rtp, значение — мир куда телепортирует
worlds:
  world: world
  world_nether: world
  world_the_end: world

cooldown:
  enabled: false
  seconds: 60

# проверять 2 блока воздуха над точкой приземления
check_surface: false

effect:
  enabled: false
  name: BLINDNESS      # полный список ниже
  duration: 60         # тики (20 = 1 секунда)
  amplifier: 0

sound:
  enabled: false
  name: EndermanTeleportSound   # полный список ниже

messages:
  chat:
    enabled: false
  title:
    enabled: false
    fade_in: 10
    stay: 40
    fade_out: 10
  actionbar:
    enabled: false
```

### Доступные эффекты

`ABSORPTION` `BLINDNESS` `CONDUIT_POWER` `DARKNESS` `FATAL_POISON` `FIRE_RESISTANCE`
`HASTE` `HEALTH_BOOST` `HUNGER` `INSTANT_DAMAGE` `INSTANT_HEALTH` `INVISIBILITY`
`JUMP_BOOST` `LEVITATION` `MINING_FATIGUE` `NAUSEA` `NIGHT_VISION` `POISON`
`REGENERATION` `RESISTANCE` `SATURATION` `SLOWNESS` `SPEED` `STRENGTH`
`WATER_BREATHING` `WEAKNESS` `WITHER`

### Доступные звуки

`EndermanTeleportSound` `BellRingSound` `BowShootSound` `BurpSound` `ChorusFlowerGrowSound`
`ExplodeSound` `FireworkExplosionSound` `FireworkLargeExplosionSound` `FireworkLaunchSound`
`FizzSound` `FlintSteelSound` `GhastShootSound` `GhastSound` `IgniteSound` `LaunchSound`
`PopSound` `PotionSplashSound` `ThrowSound` `TotemUseSound` `WaterSplashSound`
`XpCollectSound` `XpLevelUpSound`

### Свой язык

Установи `lang: custom` в конфиге, затем редактируй `plugins/RandomTeleport/lang/custom.json`:

```json
{
  "teleported": "§aВы телепортировались! §7({x}, {y}, {z})",
  "on_cooldown": "§cПодождите §e{seconds} сек.",
  "no_safe_spot": "§cНе найдено безопасное место.",
  "only_in_game": "§cТолько в игре.",
  "world_not_allowed": "§cТелепортация из этого мира запрещена.",
  "world_not_loaded": "§cМир §e{world}§c не загружен.",
  "config_reloaded": "§aКонфиг перезагружен.",
  "invalid_effect": "§cЭффект §e{effect}§c не найден. Отключён.",
  "invalid_sound": "§cЗвук §e{sound}§c не найден. Отключён.",
  "no_permission": "§cНет прав.",
  "title_title": "§9RTP",
  "title_subtitle": "§aТелепортирован!",
  "actionbar_teleported": "§aТелепортирован! §7({x}, {y}, {z})",
  "actionbar_cooldown": "§c/rtp — подождите §e{seconds} сек."
}
```

Плейсхолдеры: `{x}` `{y}` `{z}` `{seconds}` `{world}` `{effect}` `{sound}`
