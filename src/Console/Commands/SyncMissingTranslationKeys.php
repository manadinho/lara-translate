<?php

namespace Manadinho\LaraTranslate\Console\Commands;

use Illuminate\Console\Command;
use Manadinho\LaraTranslate\Console\CommandsHelper\Helper;

class SyncMissingTranslationKeys extends Command
{
    private $helper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara-translate:sync-missing-translation-keys {--lang= : The language code to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all of the translation keys against locales';

    public function __construct(Helper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lang = $this->option('lang') ?? $this->option('lang');
        [$got_missing_keys, $result] = $this->helper->getMissingTranslationKeys($lang);
        
        if(!$got_missing_keys) {
            return $this->info($result);
        }

        // sync missing keys
        $synced = $this->helper->syncTranslationKeys($result);
        if($synced) {
            return $this->info("Synced successfully");
        }
    }
}
