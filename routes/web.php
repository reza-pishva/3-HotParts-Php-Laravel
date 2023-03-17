

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




