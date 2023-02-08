<?php

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

//Ansaldo
Route::get('/bazsaz-form','AnsaldoBazsazController@create');

Route::get('/bazsaz-total','AnsaldoBazsazController@bazsaz_total');
Route::post('/bazsaz-store', 'AnsaldoBazsazController@bazsaz_store')->name('bazsaz.store');
Route::delete('/bazsaz-delete/{id}', 'AnsaldoBazsazController@delete');
Route::post('/bazsaz-edit', 'AnsaldoBazsazController@bazsaz_edit')->name('bazsaz.edit');

Route::get('/seller-total','AnsaldoSellerController@seller_total');
Route::post('/seller-store', 'AnsaldoSellerController@seller_store')->name('seller.store');
Route::delete('/seller-delete/{id}', 'AnsaldoSellerController@delete');
Route::post('/seller-edit', 'AnsaldoSellerController@seller_edit')->name('seller.edit');

Route::get('/tamirkar-total','AnsaldoTamirkarController@tamirkar_total');
Route::post('/tamirkar-store', 'AnsaldoTamirkarController@tamirkar_store')->name('tamirkar.store');
Route::delete('/tamirkar-delete/{id}', 'AnsaldoTamirkarController@delete');
Route::post('/tamirkar-edit', 'AnsaldoTamirkarController@tamirkar_edit')->name('tamirkar.edit');

Route::get('/tamiratty-total','AnsaldoTamirattyController@tamiratty_total');
Route::post('/tamiratty-store', 'AnsaldoTamirattyController@tamiratty_store')->name('tamiratty.store');
Route::delete('/tamiratty-delete/{id}', 'AnsaldoTamirattyController@delete');
Route::post('/tamiratty-edit', 'AnsaldoTamirattyController@tamiratty_edit')->name('tamiratty.edit');

Route::get('/typgha-total','AnsaldoTypGhaController@typgha_total');
Route::post('/typgha-store', 'AnsaldoTypGhaController@store')->name('typgha.store');
Route::delete('/typgha-delete/{id}', 'AnsaldoTypGhaController@delete');
Route::post('/typgha-edit', 'AnsaldoTypGhaController@edit')->name('typgha.edit');

Route::get('/nir-total','AnsaldoNirNaController@total');
Route::post('/nir-store', 'AnsaldoNirNaController@store')->name('nir.store');
Route::delete('/nir-delete/{id}', 'AnsaldoNirNaController@delete');
Route::post('/nir-edit', 'AnsaldoNirNaController@edit')->name('nir.edit');

Route::get('/un-total','AnsaldoUniNuController@total');
Route::post('/un-store', 'AnsaldoUniNuController@store')->name('un.store');
Route::delete('/un-delete/{id}', 'AnsaldoUniNuController@delete');
Route::post('/un-edit', 'AnsaldoUniNuController@edit')->name('un.edit');

Route::get('/tapr-form','AnsaldoTamiratProgramController@create');
Route::get('/tapr-total','AnsaldoTamiratProgramController@total');
Route::post('/tapr-store', 'AnsaldoTamiratProgramController@store')->name('tp.store');
Route::delete('/tapr-delete/{id}', 'AnsaldoTamiratProgramController@delete');
Route::post('/tapr-edit', 'AnsaldoTamiratProgramController@edit')->name('tp.edit');
Route::post('/tapr-rep', 'AnsaldoTamiratProgramController@report_queryp')->name('tp.store');
Route::get('/tapr-rep2','AnsaldoTamiratProgramController@report_queryp2');
Route::get('/tapr-rep3/{id}','AnsaldoTamiratProgramController@report_queryp3');

Route::get('/tasepr-form','AnsaldoSendBazsaziGhataatController@create');
Route::post('/tasepr-store', 'AnsaldoSendBazsaziGhataatController@store')->name('tps.store');
Route::get('/tasepr-total','AnsaldoSendBazsaziGhataatController@total');
Route::get('/tasepr-total-today','AnsaldoSendBazsaziGhataatController@total_today');
Route::get('/tasepr-onlyone','AnsaldoSendBazsaziGhataatController@onlyone');
Route::get('/tasepr-onlyone2/{id}','AnsaldoSendBazsaziGhataatController@onlyone2');
Route::post('/tapsr-rep', 'AnsaldoSendBazsaziGhataatController@report_queryp')->name('tps2.store');
Route::get('/tapsr-rep2','AnsaldoSendBazsaziGhataatController@report_queryp2');
Route::get('/tapsr-rep3/{id}','AnsaldoSendBazsaziGhataatController@report_queryp3');
Route::get('/tapsr-rep4/{id}','AnsaldoSendBazsaziGhataatController@report_queryp4');
Route::post('/tapsr-edit', 'AnsaldoSendBazsaziGhataatController@edit')->name('tps.edit');
Route::delete('/tapsr-delete/{id}', 'AnsaldoSendBazsaziGhataatController@delete');

Route::post('/tarepr-store', 'AnsaldoResvBazsaziGhataatController@store')->name('tpra.store');
Route::get('/resvs_for_send/{id}','AnsaldoResvBazsaziGhataatController@resvs_for_send');
Route::post('/taprr-edit', 'AnsaldoResvBazsaziGhataatController@edit')->name('tpr2.edit');
Route::delete('/taprr-delete/{id}', 'AnsaldoResvBazsaziGhataatController@delete');

Route::get('/tain-form','AnsaldoStoreProgramInController@create');
Route::post('/tain-store', 'AnsaldoStoreProgramInController@store')->name('tpi.store');
Route::get('/tain-total','AnsaldoStoreProgramInController@total');
Route::get('/tain-total-today','AnsaldoStoreProgramInController@total_today');
Route::get('/tain-onlyone','AnsaldoStoreProgramInController@onlyone');
Route::get('/tain-onlyone2/{id}','AnsaldoStoreProgramInController@onlyone2');
Route::post('/tain-rep', 'AnsaldoStoreProgramInController@report_queryp')->name('tpi2.store');
Route::post('/tain-rep3', 'AnsaldoStoreProgramInController@report_queryp3')->name('tpi3.store');
Route::get('/tain-rep4/{id}','AnsaldoStoreProgramInController@report_queryp4');
Route::get('/tain-rep5/{id}','AnsaldoStoreProgramInController@report_queryp5');
Route::get('/tain-rep2','AnsaldoStoreProgramInController@report_queryp2');
Route::post('/tain-edit', 'AnsaldoStoreProgramInController@edit')->name('tpi.edit');
Route::delete('/tain-delete/{id}', 'AnsaldoStoreProgramInController@delete');

Route::post('/taout-store', 'AnsaldoStoreProgramOutController@store')->name('tpo.store');
Route::get('/resvs_for_out/{id}','AnsaldoStoreProgramOutController@resvs_for_out');
Route::post('/taout-edit', 'AnsaldoStoreProgramOutController@edit')->name('tpoa.edit');
Route::delete('/taout-delete/{id}/{id_t}', 'AnsaldoStoreProgramOutController@delete');

Route::get('/out-form','AnsaldoOutGhataatController@create');
Route::post('/out-store', 'AnsaldoOutGhataatController@store')->name('out.store');
Route::get('/out-total','AnsaldoOutGhataatController@total');
Route::get('/out-total-today','AnsaldoOutGhataatController@total_today');
Route::get('/out-onlyone','AnsaldoOutGhataatController@onlyone');
Route::get('/out-onlyone2/{id}','AnsaldoOutGhataatController@onlyone2');
Route::post('/out-rep', 'AnsaldoOutGhataatController@report_queryp')->name('out3.store');
Route::get('/out-rep2','AnsaldoOutGhataatController@report_queryp2');
Route::get('/out-rep5/{id}','AnsaldoOutGhataatController@report_queryp5');
Route::post('/out-edit', 'AnsaldoOutGhataatController@edit')->name('out.edit');
Route::delete('/out-delete/{id}', 'AnsaldoOutGhataatController@delete');

Route::get('/buy-form','AnsaldoBuyGhataatController@create');
Route::post('/buy-store', 'AnsaldoBuyGhataatController@store')->name('buy.store');
Route::get('/buy-total','AnsaldoBuyGhataatController@total');
Route::get('/buy-total-today','AnsaldoBuyGhataatController@total_today');
Route::get('/buy-onlyone','AnsaldoBuyGhataatController@onlyone');
Route::get('/buy-onlyone2/{id}','AnsaldoBuyGhataatController@onlyone2');
Route::post('/buy-rep', 'AnsaldoBuyGhataatController@report_queryp')->name('buy.store');
Route::get('/buy-rep5/{id}','AnsaldoBuyGhataatController@report_queryp5');
Route::post('/buy-edit', 'AnsaldoBuyGhataatController@edit')->name('buy.edit');
Route::delete('/buy-delete/{id}', 'AnsaldoBuyGhataatController@delete');

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

