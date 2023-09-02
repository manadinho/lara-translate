<?php

namespace Manadinho\LaraTranslate\Http\Controllers;

use Manadinho\LaraTranslate\Http\Services\LanguageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TranslationController extends Controller {

    protected $language_service;

    public function __construct(LanguageService $language_service)
    {
        $this->language_service = $language_service;
    }

    public function translationIndex($lang) 
    {
        $langs = $this->language_service->getTranslationLangs();

        if(!$langs->has($lang)) {
            return redirect()->route('lara-translate.index');
        }   

        $translation_content = $this->language_service->getLangFileContent($lang);
        
        return view("lara-translate::translations.index", ['translation_content' => $translation_content, 'langs' => $langs]);
    }

    public function updateTranslation(Request $request)
    {
        $this->language_service->addNewTranslationInLangFile($request->translation, [$request->key => $request->value]);

        return response()->json(['success' => true]);
    }

    public function translate(Request $request)
    {
        $translation = $this->language_service->performTranslation($request->translation, $request->key);
        if(!$translation) {
            return response()->json(['success' => false]);
        }

        $this->language_service->addNewTranslationInLangFile($request->translation, [$request->key => $translation]);

        return response()->json(['success' => true, 'translation' => $translation]);
    }

    public function createTranslation($lang)
    {
        $langs = $this->language_service->getTranslationLangs();

        if(!$langs->has($lang)) {
            return redirect()->route('lara-translate.index');
        }   

        return view('lara-translate::translations.create', ['language' => $lang]);
    }

    public function storeTranslation(Request $request)
    {
        $translation_content = $this->language_service->getLangFileContent($request->language);
        $key = $request->key;
        $translation_content->$key = ($request->value) ? $request->value:"" ;
        
        $this->language_service->saveLangFile($request->language, $translation_content);

        return redirect()->route('lara-translate.translations.index', $request->language);
    }

    public function delete(Request $request)
    {
        $translation_content = $this->language_service->getLangFileContent($request->translation);

        $key = $request->key;
        unset($translation_content->$key);

        $this->language_service->saveLangFile($request->translation, $translation_content);

        return response()->json(['success' => true]);
    }
}