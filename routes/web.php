
﻿<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

Auth::routes();


Route::get('/group-form','AnsaldoGroupNamesController@create');
Route::post('/group-store', 'AnsaldoGroupNamesController@store')->name('group1.store');
Route::get('/group-total','AnsaldoGroupNamesController@total');
Route::get('/group-total-today','AnsaldoGroupNamesController@total_today');
Route::get('/group-onlyone','AnsaldoGroupNamesController@onlyone');
Route::get('/group-onlyone2/{id}','AnsaldoGroupNamesController@onlyone2');
Route::post('/group-rep', 'AnsaldoGroupNamesController@report_queryp')->name('group2.store');
Route::post('/group-edit', 'AnsaldoGroupNamesController@edit')->name('group.edit');
Route::delete('/group-delete/{id}', 'AnsaldoGroupNamesController@delete');

Route::get('/equ-form','AnsaldoGhataatsController@create');
Route::post('/equ-store', 'AnsaldoGhataatsController@store')->name('equ1.store');
Route::get('/equ-total','AnsaldoGhataatsController@total');
Route::get('/equ-total-today','AnsaldoGhataatsController@total_today');
Route::get('/equ-onlyone','AnsaldoGhataatsController@onlyone');
Route::get('/equ-onlyone2/{id}','AnsaldoGhataatsController@onlyone2');
Route::post('/equ-rep', 'AnsaldoGhataatsController@report_queryp')->name('equ2.store');
Route::post('/equ-edit', 'AnsaldoGhataatsController@edit')->name('equ.edit');
Route::post('/equ-edit2', 'AnsaldoGhataatsController@edit2')->name('equ2.edit');
Route::delete('/equ-delete/{id}', 'AnsaldoGhataatsController@delete');
Route::get('/gh-gr/{id}','AnsaldoGhataatsController@gh_gr');
Route::get('/gh-ie/{id}','AnsaldoGhataatsController@gh_ie');
Route::get('/gh-gr1/{id}','AnsaldoGhataatsController@gh_gr1');
Route::get('/gh-gr2/{group2}/{ghataats}','AnsaldoGhataatsController@gh_gr2');
Route::get('/gh-gr3/{group1}/{ghataats}','AnsaldoGhataatsController@gh_gr3');

Route::get('/saz-total','AnsaldoSazandehController@total');
Route::post('/saz-store', 'AnsaldoSazandehController@store')->name('saz.store');
Route::delete('/saz-delete/{id}', 'AnsaldoSazandehController@delete');
Route::post('/saz-edit', 'AnsaldoSazandehController@edit')->name('saz.edit');

Route::get('/group-change','AnsaldoGroupChangeController@create');
Route::get('/group-total2/{id}','AnsaldoGroupChangeController@total2');

Route::get('/savabegh-form','AnsaldoSavabeghController@create');
Route::get('/savabegh-search-by-ide','AnsaldoSavabeghController@create_search_by_ide');
Route::get('/savabegh-insert/{type_sabegheh}/{mizan_kharabi}/{vaz_nasb}/{karkard}/{description}/{id_t1}/{id_sub}/{id_g_global}/{insert_type}/{ghataat4}/{radif1}/{radif2}/{program}/{id_t_bazsazi1}/{id_t_bazsazi2}','AnsaldoSavabeghController@savabegh_insert');
Route::get('/savabegh-update/{sav_type}/{mizan_kharabi}/{vaz_nasb}/{karkard}/{description}/{insert_type}/{id_s}/{id_g_global}/{id_sub}/{id_t1}/{id_e}/{id_t_prev}/{radif1}/{radif2}','AnsaldoSavabeghController@savabegh_update');
Route::get('/savabegh-delete/{sav_type}/{mizan_kharabi}/{vaz_nasb}/{karkard}/{description}/{id_t1}/{id_sub}/{id_g_global}/{insert_type}/{id_s}/{id_t2}/{id_t3}/{ghataat4}/{radif1}/{radif2}/{id_t_bazsazi1}/{id_t_bazsazi2}/{radif3}','AnsaldoSavabeghController@savabegh_delete');
Route::get('/inserted-rows/{id}','AnsaldoSavabeghController@inserted_rows');
Route::get('/get-history/{id}','AnsaldoSavabeghController@get_history');
Route::delete('/history-delete/{id}', 'AnsaldoSavabeghController@delete');
Route::get('/get-history-tamirat-prog/{id}','AnsaldoTamiratProgramController@get_history');
Route::get('/get-history-bazsazi-prog/{id}','AnsaldoResvBazsaziGhataatController@get_history');
Route::get('/get-history-bazsazi-prog2/{id}','AnsaldoResvBazsaziGhataatController@get_history2');
Route::get('/get-history-anbar-prog/{id}','AnsaldoStoreProgramOutController@get_history');
Route::get('/get-history-anbar-prog2/{id}','AnsaldoStoreProgramOutController@get_history2');
Route::get('/get-history-buy-prog/{id}','AnsaldoBuyGhataatController@get_history');
Route::get('/get-history-out-prog/{id}','AnsaldoBuyGhataatController@get_history');
Route::get('/get-history-enter_exit-prog/{id}','AnsaldoOutGhataatController@get_history');

Route::get('/jalali','AnsaldoTamiratProgramController@convert_to_jalali');
Route::get('/update_exit_no','AnsaldoStoreProgramOutController@update_exit_no');

