<?php

namespace Manadinho\LaraTranslate\Http\Controllers;

use Manadinho\LaraTranslate\Http\Services\LanguageService;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class LanguageController extends Controller {

    protected $language_service;

    public function __construct(LanguageService $language_service)
    {
        $this->language_service = $language_service;
    }

    public function index() 
    {
        $langs = $this->language_service->getTranslationLangs();

        return view('lara-translate::languages.index', ['langs' => $langs]);
    }

    public function create()
    {
        return view('lara-translate::languages.create');
    }

    public function store(Request $request)
    {
        $langs = $this->language_service->getTranslationLangs();

        if($langs->has($request->name)) {
            return redirect()->route('lara-translate.index');
        }  

        $this->language_service->saveLangFile($request->name, new \stdClass());
        Artisan::call("lara-translate:sync-missing-translation-keys --lang=".$request->name);
        return redirect()->route('lara-translate.index');
    }
}