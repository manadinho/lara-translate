<?php

namespace Manadinho\LaraTranslate\Console\Commands;

use Illuminate\Console\Command;
use Manadinho\LaraTranslate\Console\CommandsHelper\Helper;

class ShowMissingTranslationKeys extends Command
{
    private $helper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara-translate:show-missing-translation-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all of the translation keys against locales that are not been added yet';

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
        [$got_missing_keys, $result] = $this->helper->getMissingTranslationKeys();
        
        if(!$got_missing_keys) {
            return $this->info($result);
        }

        // render the table of results
        $this->table(["lang", "key"], $result);
    }
}
