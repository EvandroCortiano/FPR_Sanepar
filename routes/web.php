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
        Route::put('/alterarDoacao', ['as' => 'alterarDoacao', 'uses' => 'DoadorController@alterarDoacao']);
        //Nome cartao
        Route::post('/pesCartaoStore', ['as' => 'pesCartaoStore', 'uses' => 'DoadorController@pesCartaoStore']);
        Route::get('/listNomesCar/{ccp_ddr_id}', ['as' => 'listNomesCar', 'uses' => 'DoadorController@listNomesCar']);
        Route::get('/editCcps/{ccp_id}', ['as' => 'editCcps', 'uses' => 'DoadorController@editCcps']);
        Route::put('/updateCcps', ['as' => 'updateCcps', 'uses' => 'DoadorController@updateCcps']);
        Route::put('/destroyCcps', ['as' => 'destroyCcps', 'uses' => 'DoadorController@destroyCcps']);
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
        //gera arquivo
        Route::get('/downloadExcelProducao', ['as' => 'downloadExcelProducao', 'uses' => 'RepasseController@downloadExcelProducao']);
        Route::get('/downloadExcelFiltro', ['as' => 'downloadExcelFiltro', 'uses' => 'RepasseController@downloadExcelFiltro']);
        Route::get('/downloadExcelCancelados', ['as' => 'downloadExcelCancelados', 'uses' => 'RepasseController@downloadExcelCancelados']);
        Route::get('/downloadExcelVencer', ['as' => 'downloadExcelVencer', 'uses' => 'RepasseController@downloadExcelVencer']);
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

    //Controle Sanepar
    Route::group(['prefix'=>'sanepar', 'as'=>'sanepar.'], function(){
        Route::get('/', ['as'=>'index','uses'=>'SaneparRetornoController@index']);
        //arquivo excel de repasse para sanepar
        Route::get('/downloadExcelRepasse', ['as' => 'downloadExcelRepasse', 'uses' => 'SaneparRetornoController@downloadExcelRepasse']);
        // Route::get('/downloadExcelRepasseList', ['as' => 'downloadExcelRepasseList', 'uses' => 'SaneparRetornoController@downloadExcelRepasseList']);
        //criar lista e listar ja enviados (datatable)
        Route::get('/findRepasseSanepar', ['as' => 'findRepasseSanepar', 'uses' => 'SaneparRetornoController@findRepasseSanepar']);
        Route::get('/findRepasseSaneparList', ['as' => 'findRepasseSaneparList', 'uses' => 'SaneparRetornoController@findRepasseSaneparList']);
        //receber arquivo da senapar
        Route::post('/importSanepar', ['as' => 'importSanepar', 'uses' => 'SaneparRetornoController@importSanepar']);
        Route::post('/storeReturnSanepar', ['as' => 'storeReturnSanepar', 'uses' => 'SaneparRetornoController@storeReturnSanepar']);
        //criar arquivo com os erros
        Route::post('/storeReturnSaneparError', ['as' => 'storeReturnSaneparError', 'uses' => 'SaneparRetornoController@storeReturnSaneparError']);
        //Lista os recebidos da Sanepar
        Route::get('/downloadExcelRecebidosList', ['as' => 'downloadExcelRecebidosList', 'uses' => 'SaneparRetornoController@downloadExcelRecebidosList']);
        Route::get('/findRecebidosSaneparList', ['as' => 'findRecebidosSaneparList', 'uses' => 'SaneparRetornoController@findRecebidosSaneparList']);
        //Route::get('/findSaneparDate', ['as' => 'findSaneparDate', 'uses' => 'SaneparRetornoController@findSaneparDate']);
    });

    // Auth::routes();
    Route::get('/home', 'HomeController@index')->name('welcome');
});
