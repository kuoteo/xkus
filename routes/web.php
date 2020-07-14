<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * 星空网后台管理
 */

Route::group([
    'prefix'=>'admin',
    'namespace'=>'Admin',
    'middleware'=>['auth.admin'],
    'as'=>'admin.'
],function($router){
    //Login && Logout
    $router->match(['get','post'],'index','LoginController@index')
        ->name('login');
    $router->get('logout', 'LoginController@logout')
        ->name('logout');

    $router->get('product', 'ProductController@product')
    ->name('product');


    $router::group([
        'prefix'=>'product','as'=>'product.'
    ],function($product) {
        $product->get('import/index', 'ProductController@importIndex')
            ->name('import.index');
        $product->any('import', 'ProductController@import')
            ->name('import');
        $product->any('update/index/{id}', 'ProductController@updateIndex')
            ->name('update.index');
        $product->any('delete/{id}', 'ProductController@delete')
            ->name('delete');
        $product->any('flush', 'ProductController@flushcache')
            ->name('flush.cache');
    });

    $router::group([
        'prefix'=>'homepage','as'=>'homepage.'
    ],function($homepage){
        $homepage->any('index','HomepageController@homepage')
            ->name('index');
        $homepage->any('import/index/{type}','HomepageController@importIndex')
            ->name('import.index');
        $homepage->any('import/{type}','HomepageController@import')
            ->name('import');
        $homepage->any('update/index/{id}','HomepageController@updateIndex')
            ->name('update.index');
        $homepage->any('delete/{id}','HomepageController@delete')
            ->name('delete');
        $homepage->get('flush', 'HomepageController@flushcache')
            ->name('flush.cache');
    });

    $router::group([
        'prefix'=>'photo','as'=>'photo.'
    ],function($photo){
        $photo->any('index','PhotoController@photo')
            ->name('index');
        $photo->any('import/index/{type}','PhotoController@importIndex')
            ->name('import.index');
        $photo->any('import/{type}','PhotoController@import')
            ->name('import');
        $photo->any('update/index/{type}/{id}','PhotoController@updateIndex')
            ->name('update.index');
        $photo->any('delete/{id}','PhotoController@delete')
            ->name('delete');
        $photo->get('flush', 'PhotoController@flushcache')
            ->name('flush.cache');
    }
        );

    $router::group([
        'prefix'=>'video','as'=>'video.'
    ],function($video){
        $video->any('index','VideoController@video')
            ->name('index');
        $video->any('import/index/{type}','VideoController@importIndex')
            ->name('import.index');
        $video->any('import/{type}','VideoController@import')
            ->name('import');
        $video->any('update/index/{type}/{id}','VideoController@updateIndex')
            ->name('update.index');
        $video->any('delete/{id}','VideoController@delete')
            ->name('delete');
        $video->get('flush', 'VideoController@flushcache')
            ->name('flush.cache');
    }
    );

    $router::group([
        'prefix'=>'vision','as'=>'vision.'
    ],function($vision){
        $vision->any('index','VisionController@vision')
            ->name('index');
        $vision->any('import/index','VisionController@importIndex')
            ->name('import.index');
        $vision->any('import','VisionController@import')
            ->name('import');
        $vision->any('update/index/{id}','VisionController@updateIndex')
            ->name('update.index');
        $vision->any('delete/{id}','VisionController@delete')
            ->name('delete');
        $vision->get('flush', 'VisionController@flushcache')
            ->name('flush.cache');
    });

});