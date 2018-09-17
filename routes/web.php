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
        Route::get('/findFiltersRepasse', ['as' => 'findFiltersRepasse', 'uses' => 'RepasseController@findFiltersRepasse']);
        Route::get('/findFilterProducao', ['as' => 'findFilterProducao', 'uses' => 'RepasseController@findFilterProducao']);
        Route::get('/findFilterCancelados', ['as' => 'findFilterCancelados', 'uses' => 'RepasseController@findFilterCancelados']);
        Route::get('/findFilterVencer', ['as' => 'findFilterVencer', 'uses' => 'RepasseController@findFilterVencer']);
        Route::get('/findRepasseSanepar', ['as' => 'findRepasseSanepar', 'uses' => 'RepasseController@findRepasseSanepar']);
        Route::get('/findRepasseSaneparList', ['as' => 'findRepasseSaneparList', 'uses' => 'RepasseController@findRepasseSaneparList']);
        //gera arquivo
        Route::get('/downloadExcelProducao', ['as' => 'downloadExcelProducao', 'uses' => 'RepasseController@downloadExcelProducao']);
        Route::get('/downloadExcelFiltro', ['as' => 'downloadExcelFiltro', 'uses' => 'RepasseController@downloadExcelFiltro']);
        Route::get('/downloadExcelCancelados', ['as' => 'downloadExcelCancelados', 'uses' => 'RepasseController@downloadExcelCancelados']);
        Route::get('/downloadExcelVencer', ['as' => 'downloadExcelVencer', 'uses' => 'RepasseController@downloadExcelVencer']);
        Route::get('/downloadExcelRepasse', ['as' => 'downloadExcelRepasse', 'uses' => 'RepasseController@downloadExcelRepasse']);
        Route::get('/downloadExcelRepasseList', ['as' => 'downloadExcelRepasseList', 'uses' => 'RepasseController@downloadExcelRepasseList']);
    });

    //Cartao + pro renal
    Route::group(['prefix'=>'cartaoPro','as'=>'cartaoPro.'], function(){
        //get
        Route::get('/', ['as' => 'index', 'uses' => 'CartaoController@index']);
        Route::get('/findProducaoCartao', ['as' => 'findProducaoCartao', 'uses' => 'CartaoController@findProducaoCartao']);
        Route::get('/findListCartao', ['as' => 'findListCartao', 'uses' => 'CartaoController@findListCartao']);
        //gera arquivo
        Route::get('/downloadExcelProducao', ['as' => 'downloadExcelProducao', 'uses' => 'CartaoController@downloadExcelProducao']);
        Route::get('/downloadExcelList', ['as' => 'downloadExcelList', 'uses' => 'CartaoController@downloadExcelList']);
    });

    // Auth::routes();
    Route::get('/home', 'HomeController@index')->name('welcome');
});
