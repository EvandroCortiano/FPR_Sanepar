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
    Route::get('/doador/cadastro','DoadorController@create');
    Route::get('/doador/doadores','DoadorController@index');
    Route::get('/doador/edit/{ddr_id}','DoadorController@edit');
    Route::get('/doador/show','DoadorController@show');
    Route::get('/doador/find/{ddr_id}', 'DoadorController@find');
    Route::post('/doador/store','DoadorController@store');
    Route::put('/doador/update', 'DoadorController@update');

    //doador/contato
    Route::post('/doador/contatoStore', 'DoadorController@contatoStore');

    //doacao
    Route::post('/doacao/store','DoacaoController@store');

    //pessoas
    Route::group(['prefix'=>'pessoas','as'=>'pessoas.'], function(){
        Route::get('/', ['as' => 'index', 'uses' => 'PessoasController@index']);
        Route::get('/show', ['as' => 'show', 'uses' => 'PessoasController@show']);
        Route::get('/find/{pes_id}', ['as' => 'find/{pes_id}', 'uses' => 'PessoasController@find']);
        Route::post('/contatoStorePessoas', ['as' => 'contatoStorePessoas', 'uses' => 'PessoasController@contatoStorePessoas']);
        Route::post('/doacaoDoador', ['as' => 'doacaoDoador', 'uses' => 'PessoasController@doacaoDoador']);
        Route::put('/deleteTelefonePessoas', ['as' => 'deleteTelefonePessoas', 'uses' => 'PessoasController@deleteTelefonePessoas']);
    });

    // Auth::routes();
    Route::get('/home', 'HomeController@index')->name('welcome');
});
