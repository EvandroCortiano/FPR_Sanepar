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

Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => 'web'], function () {
    Auth::routes();
    Route::auth();

    //doador
    Route::group(['prefix'=>'doador','as'=>'doador.'], function(){
        //get
        Route::get('/cadastro', ['as' => 'cadastro', 'uses' => 'DoadorController@create']);
        Route::get('/doadores', ['as' => 'doadores', 'uses' => 'DoadorController@index']);
        Route::get('/show', ['as' => 'show', 'uses' => 'DoadorController@show']);
        Route::get('/edit/{ddr_id}', ['as' => 'edit/{ddr_id}', 'uses' => 'DoadorController@edit']);
        Route::get('/find/{ddr_id}', ['as' => 'find/{ddr_id}', 'uses' => 'DoadorController@find']);
        //post put
        Route::post('/store', ['as' => 'store', 'uses' => 'DoadorController@store']);
        Route::post('/foneStore', ['as' => 'foneStore', 'uses' => 'DoadorController@foneStore']);
        Route::put('/update', ['as' => 'update', 'uses' => 'DoadorController@update']);
        //doador/contato
        Route::post('/contatoStore', ['as' => 'contatoStore', 'uses' => 'DoadorController@contatoStore']);
        //delete doacao
        Route::put('/destroyDoacao', ['as' => 'destroyDoacao', 'uses' => 'DoadorController@destroyDoacao']);
    });

    //doacao
    Route::post('/doacao/store','DoacaoController@store');

    //pessoas
    Route::group(['prefix'=>'pessoas','as'=>'pessoas.'], function(){
        //get
        Route::get('/', ['as' => 'index', 'uses' => 'PessoasController@index']);
        Route::get('/show', ['as' => 'show', 'uses' => 'PessoasController@show']);
        Route::get('/find/{pes_id}', ['as' => 'find/{pes_id}', 'uses' => 'PessoasController@find']);
        //post put
        Route::post('/contatoStorePessoas', ['as' => 'contatoStorePessoas', 'uses' => 'PessoasController@contatoStorePessoas']);
        Route::post('/doacaoDoador', ['as' => 'doacaoDoador', 'uses' => 'PessoasController@doacaoDoador']);
        Route::put('/deleteTelefonePessoas', ['as' => 'deleteTelefonePessoas', 'uses' => 'PessoasController@deleteTelefonePessoas']);
    });

    //doador
    Route::group(['prefix'=>'repasse','as'=>'repasse.'], function(){
        //get
        Route::get('/', ['as' => 'index', 'uses' => 'RepasseController@index']);
        Route::get('/findAllDoacao', ['as' => 'findAllDoacao', 'uses' => 'RepasseController@findAllDoacao']);
        Route::get('/downloadExcel/{type}', ['as' => 'downloadExcel', 'uses' => 'RepasseController@downloadExcel']);
    });

    // Auth::routes();
    Route::get('/home', 'HomeController@index')->name('welcome');
});
