<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->collectLocalesStrings() as $locale) {
            // * Suported locales
            Cache::rememberForever(sprintf('translations.%s', $locale), function () use ($locale) {
                $translations = [
                    'php' => $this->phpTranslations($locale),
                    'json' => $this->jsonTranslations($locale),
                ];
                return $translations;
            });
        }
    }

    /**
     * Gather provided langs checking from files
     *
     * @return Collection
     */
    private function collectLocalesStrings(): Collection
    {
        return collect(File::allFiles(resource_path('lang/')))->flatMap(function ($file) {
            if ($file->getRelativePath()) {
                return [$file->getRelativePath() => ''];
            }
        })->keys();
    }

    /**
     * Gather all php translations
     *
     * @param string $locale
     * @return array
     */
    private function phpTranslations(string $locale): array
    {
        $path = resource_path("lang/$locale");

        return collect(File::allFiles($path))->flatMap(function ($file) use ($locale) {
            $translation = $file->getBasename('.php');
            return [$translation => trans($translation, [], $locale)];
        })->all();
    }

    /**
     * Gather json translations
     *
     * @param string $locale
     * @return array
     */
    private function jsonTranslations(string $locale): array
    {
        $path = resource_path("lang/$locale.json");

        if (is_string($path) && is_readable($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }

        return [];
    }
}
