<?php

namespace Manadinho\LaraTranslate\Console\CommandsHelper;

use Manadinho\LaraTranslate\Http\Services\LanguageService;
use Illuminate\Filesystem\Filesystem;

class Helper {

    private $language_service;

    public function __construct(LanguageService $language_service)
    {
        $this->language_service = $language_service;
    }

    public function getMissingTranslationKeys($lang=null)
    {
        if(!$lang)
        {
            $langs = $this->language_service->getTranslationLangs();
            $all_keys = $this->getAllTranslationKeys();
            return [true, $this->prepareMissingKeysDataForLangs($langs->keys()->toArray(), $all_keys)];
        }

        $langs = $this->language_service->getTranslationLangs();

        if(!$langs->has($lang)) {
            return [false, "invalid lang"];
        }   

        $all_keys = $this->getAllTranslationKeys();
        return [true, $this->prepareMissingKeysDataForLangs([$lang], $all_keys)];
    }

    public function syncTranslationKeys($translation_keys)
    {
        foreach ($translation_keys as $lang_key_arr) {
            $this->language_service->addNewTranslationInLangFile($lang_key_arr[0], [$lang_key_arr[1] => $lang_key_arr[1]]);
        }
        return true;
    }

    private function getAllTranslationKeys()
    {
        $matching_pattern = '[^\w](?<!->)('.implode('|', config('laraTranslate.translation_methods')).')'."\("."\s*"."[\'\"]".'(.+)'."[\'\"]\s*"."[\),]";
        $file_system = new Filesystem();
        $files = $file_system->allFiles(config('laraTranslate.scan_paths'));
        $all_keys = [];
        foreach ($files as $file) {
            if (preg_match_all("/$matching_pattern/siU", $file->getContents(), $matches)) {
                foreach ($matches[2] as $key) {
                    $all_keys[$key] = '';
                }
            }
        }
        return $all_keys;
    }

    private function prepareMissingKeysDataForLangs($langs_arr, $all_keys)
    {
        $missing_keys = [];
        foreach ($langs_arr as $lang) {
            foreach ($all_keys as $key => $value) {
                $translation_content = $this->language_service->getLangFileContent($lang);
                if(!property_exists($translation_content, $key)) {
                    $missing_keys[] = [$lang, $key];
                }
            }
        }
        return $missing_keys;
    }

}