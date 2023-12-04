<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Source Language Configuration
    |--------------------------------------------------------------------------
    |
    | This is related to translating a key from one language to other.
    | source_language determins that from which language we want to translate
    |
    */
    "source_language" => "en",

    /*
    |--------------------------------------------------------------------------
    | Translate button Configuration
    |--------------------------------------------------------------------------
    |
    | This is related to showing translate button in actions.
    |
    */
    "show_translate_button" => true,


    /*
    |--------------------------------------------------------------------------
    | Delete button Configuration
    |--------------------------------------------------------------------------
    |
    | This is related to showing delete button in actions.
    |
    */
    "show_delete_button" => true,

    /*
    |--------------------------------------------------------------------------
    | Middleware Configuration
    |--------------------------------------------------------------------------
    |
    | You can specify the middlewares here that you want to apply
    |
    */
    'middlewares' => [],

    /*
    |--------------------------------------------------------------------------
    | URI start segment
    |--------------------------------------------------------------------------
    |
    | You can specify the URI first segment in if you want to change the url
    |
    */
    'uri_start' => 'lara-translate',

       /*
    |--------------------------------------------------------------------------
    | Translation methods
    |--------------------------------------------------------------------------
    |
    | You can specify like with method should be considered while getting keys 
    | from application
    |
    */
    'translation_methods' => ['trans', '__'],

    /*
    |--------------------------------------------------------------------------
    | Scan paths
    |--------------------------------------------------------------------------
    |
    | You can specify the directories from where keys need to be looked for
    |
    */
    'scan_paths' => [app_path(), resource_path()."/views"],

    /*
    |--------------------------------------------------------------------------
    | Lang directory paths
    |--------------------------------------------------------------------------
    |
    | It will try to detect the lang directory path automatically but if you
    | have path different from standard path then you can specify the path here
    |
    */

    'lang_directory_path' => 'default',
    
];