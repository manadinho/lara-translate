<?php

use Manadinho\LaraTranslate\Http\Controllers\LanguageController;
use Manadinho\LaraTranslate\Http\Controllers\TranslationController;

Route::group(['prefix' => config('laraTranslate.uri_start'), 'as' => 'lara-translate.', 'middleware' => config('laraTranslate.middlewares')], function(){
    Route::get('/', [LanguageController::class,'index'])->name('index');
    Route::get('/create', [LanguageController::class,'create'])->name('create');
    Route::post('/store', [LanguageController::class,'store'])->name('store');

    Route::group(['prefix' => 'translations', 'as' => 'translations.'], function(){
        Route::get('/{lang}/index', [TranslationController::class,'translationIndex'])->name('index');
        Route::post('/update', [TranslationController::class,'updateTranslation'])->name('update');
        Route::post('/translate', [TranslationController::class,'translate'])->name('translate');
        Route::get('/{lang}/create', [TranslationController::class,'createTranslation'])->name('create');
        Route::post('/translations/store', [TranslationController::class,'storeTranslation'])->name('store');
        Route::post('/delete', [TranslationController::class,'delete'])->name('delete');
    });
});