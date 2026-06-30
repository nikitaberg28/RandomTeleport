<?php

declare(strict_types=1);

namespace RandomTeleport\utils;

use RandomTeleport\RandomTeleport;

final class LangManager
{
    /** @var array<string, string> */
    private array $strings = [];

    private const FALLBACK_LANG = 'en';

    /** @var string[] */
    private const VALID_LANGS = ['en', 'ru', 'custom'];

    public function __construct(private RandomTeleport $plugin, string $lang)
    {
        $lang = strtolower(trim($lang));
        if (!in_array($lang, self::VALID_LANGS, true)) {
            $plugin->getLogger()->warning("Unknown lang '{$lang}', falling back to 'en'.");
            $lang = self::FALLBACK_LANG;
        }

        $this->load($lang);
    }

    private function load(string $lang): void
    {
        $path    = $this->plugin->getDataFolder() . "lang/{$lang}.json";
        $decoded = json_decode(file_get_contents($path), true);

        if (!is_array($decoded)) {
            $this->plugin->getLogger()->warning("Lang file '{$lang}.json' is invalid JSON, falling back to 'en'.");
            $fallback = $this->plugin->getDataFolder() . 'lang/en.json';
            $decoded  = json_decode(file_get_contents($fallback), true);
        }

        $this->strings = is_array($decoded) ? array_map('strval', $decoded) : [];
    }

    /**
     * @param array<string, string> $placeholders
     */
    public function get(string $key, array $placeholders = []): string
    {
        $str = $this->strings[$key] ?? $key;
        return $placeholders !== [] ? strtr($str, $placeholders) : $str;
    }
}
