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
    return view('welcome');
});

//doador
Route::get('/doador/cadastro','DoadorController@create');
Route::get('/doador/doadores','DoadorController@index');
Route::post('/doador/store','DoadorController@store');
Route::get('/doador/edit/{ddr_id}','DoadorController@edit');
Route::get('/doador/show','DoadorController@show');

//doacao
Route::post('/doacao/store','DoacaoController@store');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
