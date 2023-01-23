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
Route::get('/cal-kar/{date1}/{date2}','EnteringindividualController@calculate_karkard');
Route::get('/datetest','CarController@datetest');

Route::get('/vue-individuals-presence','EnteringindividualController@vue_individuals_presence');
Route::get('/vue-total-individuals','EnteringindividualController@vue_total_individuals');
Route::get('/vue-individuals-with-permission/{date1}/{date2}','EnteringindividualController@vue_individuals_with_permission');
Route::get('/vue-individuals-without-permission/{date1}/{date2}','EnteringindividualController@vue_individuals_without_permission');
Route::get('/vue-individuals-karkard/{date1}/{date2}/{id}','EnteringindividualController@vue_individuals_karkard');
Route::get('/vue-individuals-karkard2/{date1}/{date2}','EnteringindividualController@vue_individuals_karkard2');
Route::get('/vue-individuals-enterexit/{date1}/{date2}/{id}','EnteringindividualController@vue_individuals_enterexit');
Route::get('/vue-waiting-for-exit/{date1}/{date2}','EnteringindividualController@vue_waiting_for_exit');
Route::get('/vue-waiting-for-enter/{date1}/{date2}','EnteringindividualController@vue_waiting_for_enter');
Route::get('/vue-in-process/{date1}/{date2}','EnteringindividualController@vue_in_process');
Route::get('/vue-not-accepted/{date1}/{date2}','EnteringindividualController@vue_not_accepted');

Route::get('/amar1','MobileController@amar1');
Route::get('/show-archive','confirm2@show_archive');
Route::get('/amar2','MobileController@amar2');
Route::get('/savabegh','CarController@savabegh');
Route::get('/m-savabegh','CarController@m_savabegh');
Route::get('/fsavabegh','CarController@fsavabegh');
Route::get('/herasat2','CarController@herasat2');
Route::get('/herasat','CarController@herasat');
Route::get('/sms','CarController@sms');
//Route::get('/home','CarController@test3');
//Route::get('/','CarController@test3');
Route::get('/out','CarController@test3');
Route::get('/home','Exit_goods_permissionController@test3');
Route::get('/undercons','Exit_goods_permissionController@undercons');
Route::get('/notfound','Exit_goods_permissionController@notfound');
Route::get('/usernotfound','Exit_goods_permissionController@usernotfound');
Route::get('/duplicateduser','Exit_goods_permissionController@duplicateduser');
Route::get('/education01','Exit_goods_permissionController@education01');
Route::get('/education02','Exit_goods_permissionController@education02');
Route::get('/education03','Exit_goods_permissionController@education03');
Route::get('/education04','Exit_goods_permissionController@education04');
Route::get('/education05','Exit_goods_permissionController@education05');
//entering_people_uniques
Route::get('/unique-store','enteringPersonelUniqueController@store');
//Cars
Route::get('/test','CarController@test');
Route::get('/car-reg','CarController@create');
Route::post('/car-store','CarController@store')->name('cars.store');
Route::get('/cars-edit-form/{id}', 'CarController@editform');
Route::post('/cars-edit','CarController@edit')->name('cars.edit');
Route::get('/cars-delete/{id}', 'CarController@delete');
//Goods
Route::get('/goods-reg','GoodsController@create');
Route::get('/goodstotal','GoodsController@goodstotal');
Route::post('/goods-store','GoodsController@store')->name('goods.store');
Route::get('/goods-edit-form/{id}', 'GoodsController@editform');
Route::post('/goods-edit','GoodsController@edit')->name('goods.edit');
Route::delete('/goods-delete/{id}', 'GoodsController@delete');
Route::post('/editgoods', 'GoodsController@editgoods')->name('editform8.edit');
//Parts
Route::get('/parts-reg','RequestpartController@create')->name('parts.reg');
Route::get('/partstotal','RequestpartController@partstotal');
Route::post('/parts-store','RequestpartController@store')->name('parts.store');
Route::get('/parts-edit-form/{id}', 'RequestpartController@editform');
Route::post('/parts-edit','RequestpartController@edit')->name('parts.edit');
Route::get('/parts-delete/{id}', 'RequestpartController@delete');
Route::delete('/parts-delete/{id}', 'RequestpartController@delete');
Route::post('/editparts', 'RequestpartController@editparts')->name('editform9.edit');
//Exit
Route::post('/exit-store','Exit_goods_permissionController@store')->name('exit.store');
Route::post('/exit-edit','Exit_goods_permissionController@edit')->name('exit.edit');
Route::get('/exit1-show', 'Exit_goods_permissionController@showlist');
Route::delete('/exit-delete/{id}', 'Exit_goods_permissionController@delete');
Route::post('/editform', 'Exit_goods_permissionController@editform')->name('editform.edit');
Route::post('/editformm', 'Exit_goods_permissionController@editformm')->name('editformm.edit44');
Route::post('/editform2', 'Exit_goods_permissionController@editform2')->name('editform.edit');
Route::post('/editform3', 'Exit_goods_permissionController@editform3')->name('editform3.edit3');
Route::post('/editform22', 'Exit_goods_permissionController@editform22')->name('editform22.edit22');
Route::post('/editform33', 'Exit_goods_permissionController@editform33')->name('editform33.edit33');


Route::get('/first-station','Exit_goods_permissionController@firststation');
Route::get('/sendagain/{id}','Exit_goods_permissionController@returnform');
Route::get('/not-confirmed','Exit_goods_permissionController@not_confirmed');
Route::get('/not-confirmed-boss','Exit_goods_permissionController@not_confirmed_boss');
Route::get('/total-sent','Exit_goods_permissionController@total_sent');
Route::get('/returned','Exit_goods_permissionController@returned');
Route::get('/requester','Exit_goods_permissionController@create2');
Route::get('/exit-reg','Exit_goods_permissionController@create');

Route::get('/report1','Exit_goods_permissionController@report1');
Route::get('/report2','Exit_goods_permissionController@report2');
Route::get('/report3','Exit_goods_permissionController@report3');
Route::get('/report4','Exit_goods_permissionController@report4');
Route::get('/report5','Exit_goods_permissionController@report5');
Route::get('/report','Exit_goods_permissionController@report');
Route::post('/report_query','Exit_goods_permissionController@report_query')->name('exit.report');
Route::get('/second-reciever','Exit_goods_permissionController@create_second_reciever');
Route::get('/third-reciever','Exit_goods_permissionController@create_third_reciever');
Route::get('/print3', 'Exit_goods_permissionController@report_prev');
Route::get('/selectrecord/{id}','Exit_goods_permissionController@selectrecord');
//User
Route::get('/user-reg','userController@regform');
Route::get('/getuserinfo/{user}/{pass}','userController@getuserinfo');
Route::post('/users-edit','userController@edit')->name('user.edit');
Route::get('/users-edit-form/{id}', 'userController@editform');
Route::get('/users-delete/{id}', 'userController@delete');
Route::get('/user-role','userController@roletouser');
Route::get('/user-role/{id}','userController@recieve_roles');
Route::post('/reset','userController@reset')->name('user.reset');
Route::get('/changepass','formcreate@changepass');
Route::post('/roletouser','userController@rolestore')->name('roles.store');
Route::get('/totalusers','userController@totalusers');

//Confirm1
Route::get('/first-reciever','confirm1@create_first_reciever');
Route::get('/level1','confirm1@level1');
Route::get('/level2','confirm1@level2');
Route::get('/level-1','confirm1@level_1');
Route::get('/level-2','confirm1@level_2');
Route::get('/confirm1/{id}', 'confirm1@confirm1');
Route::get('/return1/{id}', 'confirm1@return1');
Route::post('/returnform', 'confirm1@returnform')->name('returnform.edit');
Route::get('/kartabl/{id}', 'confirm1@to_kartabl');
Route::get('/not-confirmed-boss2','confirm1@not_confirmed_boss');
Route::get('/to-requester/{id}', 'confirm1@to_requester');
Route::post('/updaterequest1', 'confirm1@updaterequest1');
//Confirm2
Route::get('/second-reciever','confirm2@create_second_reciever');
Route::get('/archive/{id}', 'confirm2@archive');
Route::get('/return-archive/{id}', 'confirm2@return_archive');
Route::get('/2level1','confirm2@level1');
Route::get('/2level2','confirm2@level2');
Route::get('/level3','confirm2@level3');
Route::get('/level-3','confirm2@level_3');
Route::get('/2level-1','confirm2@level_1');
Route::get('/2level-2','confirm2@level_2');
Route::get('/confirm2/{id}', 'confirm2@confirm2');
Route::get('/return2/{id}', 'confirm2@return1');
Route::post('/returnform2', 'confirm2@returnform')->name('returnform.edit');
Route::get('/kartabl2/{id}', 'confirm2@to_kartabl');
Route::get('/2not-confirmed-boss2','confirm2@not_confirmed_boss');
Route::get('/to-requester2/{id}', 'confirm2@to_requester');
//Confirm3
Route::get('/third-reciever','confirm3@create_third_reciever');
Route::get('/level3','confirm2@level3');
Route::get('/level4','confirm3@level4');
Route::get('/confirm3/{id}', 'confirm3@confirm3');
Route::post('/returnform3', 'confirm3@returnform')->name('returnform.edit');
Route::get('/kartabl3/{id}', 'confirm3@to_kartabl');
Route::get('/to-requester3/{id}', 'confirm3@to_requester');
Route::get('/sms-send/{id}','confirm3@sms_send');
Route::get('/sent-sms','confirm3@sent_sms');
//Route::post('/confirm_req1','confirm3@confirm_req1');
Route::get('/confirm_req1/{id}','confirm3@confirm_req1');
Route::get('/notconfirm_req1/{id}/{reason3}','confirm3@notconfirm_req1');
//Confirm4
Route::get('/fourth-reciever','confirm4@create_fourth_reciever');
Route::get('/level4-1','confirm4@level4_1');
Route::get('/level4-2','confirm4@level4_2');
Route::get('/level5','confirm4@level5');
Route::get('/level6','confirm4@level6');
Route::get('/level7','confirm4@level7');
Route::get('/confirm4/{id}', 'confirm4@confirm4');
Route::get('/confirm4-2/{id}', 'confirm4@confirm4_2');
Route::get('/confirm6/{id}', 'confirm4@confirm6');
Route::get('/confirm7/{id}', 'confirm4@confirm7');
Route::get('/return4/{id}', 'confirm4@return4');
Route::get('/print1', 'confirm4@print1');
Route::get('/print2', 'confirm4@print2');

//lastlevelexit
Route::get('/lastlevelexit', 'lastlevelexit@lastlevelexit');
Route::get('/lastdetailexit/{id}', 'lastlevelexit@lastdetailexit');
Route::post('/exitupdate','lastlevelexit@exitupdate')->name('exit.update');
//lastlevelenter
Route::get('/lastlevelenter', 'lastlevelenter@lastlevelenter');
Route::get('/lastdetailenter/{id}', 'lastlevelenter@lastdetailenter');
Route::post('/enterupdate','lastlevelenter@enterupdate')->name('enter.update');
//return
Route::get('/return1list', 'return1@return1list');
Route::get('/return2list', 'return2@return2list');
Route::get('/return3list', 'return3@return3list');
//form
Route::get('/formcreate', 'formcreate@create');
Route::post('/formreg','formcreate@store')->name('form.store');
//reasons
Route::post('/reasons1store','reasons1@store')->name('reasons1.store');
Route::post('/reasons2store','reasons2@store')->name('reasons2.store');
Route::post('/reasons3store','reasons3@store')->name('reasons3.store');
//group
Route::post('/groupstore','groupController@store')->name('group.store');
Route::post('/rolestore','groupController@store2')->name('role.store');
Route::post('/usertogroup','groupController@usertogroup');
Route::post('/roletogroup','groupController@roletogroup');
Route::get('/groupcreate', 'groupController@create');
Route::get('/groupstotal', 'groupController@group_total');
Route::get('/rolestotal', 'groupController@role_total');
Route::get('/userstotal', 'groupController@user_total');
Route::get('/userstotal2', 'groupController@user_total2');
Route::post('/edituser', 'groupController@editform3')->name('editform3.edit');
Route::post('/editgroup', 'groupController@editform1')->name('editform1.edit');
Route::post('/editrole', 'groupController@editform2')->name('editform2.edit');
Route::post('/recover', 'groupController@editform4')->name('editform4.edit');
Route::delete('/group-delete/{id}', 'groupController@delete');
Route::delete('/role-delete/{id}', 'groupController@delete2');
Route::delete('/user-delete/{id}', 'groupController@delete3');
Route::get('/group-persons/{id}', 'groupController@group_persons');
Route::get('/group-levels/{id}', 'groupController@group_levels');
Route::get('/out','groupController@out');
Route::get('/mygroup','groupController@mygroup');
//workflow
Route::get('/workflow/{id}', 'WorkflowsController@workflow');
Route::get('/workflow2/{id}', 'WorkflowsController@workflow2');

//enteringforms
Route::get('/enteringform','enteringformsController@create');
Route::get('/enteringfirstrequester','enteringformsController@enteringfirstrequester');
Route::get('/reportp','enteringformsController@reportp');


Route::get('/firstreport','enteringformsController@firstreport');
Route::get('/secondreport','enteringformsController@secondreport');
Route::get('/thirdreport','enteringformsController@thirdreport');
Route::get('/fourthreport','enteringformsController@fourthreport');

Route::post('/entering-store','enteringformsController@store')->name('create_request.store');
Route::post('/updatepermission1', 'enteringformsController@updatepermission1')->name('permission1.edit');
Route::post('/updatepermission2', 'enteringformsController@updatepermission2')->name('permission2.edit');
Route::post('/updatepermission3', 'enteringformsController@updatepermission3')->name('permission3.edit');
Route::post('/baseform-update','enteringformsController@editform')->name('create_request.store');
Route::get('/recivefirstreport1/{id}','enteringformsController@recivefirstreport1');
Route::delete('/enter-delete_main/{id}', 'enteringformsController@delete');
Route::get('/send-again/{id}', 'enteringformsController@send');
Route::post('/edit-title', 'enteringformsController@editform4')->name('create_request.update');
Route::post('/report_queryp','enteringformsController@report_queryp')->name('exit.report29');
//enteringpeoples
Route::post('/addpersons','enteringpeoplesController@store')->name('addpersons.store');
Route::post('/addpersons2','enteringpeoplesController@store2')->name('addpersons.store2');
Route::delete('/enter-delete/{id}', 'enteringpeoplesController@delete');
Route::delete('/enter-delete2/{id}', 'enteringpeoplesController@delete2');
Route::post('/updatepersons', 'enteringpeoplesController@editform1')->name('updatepersons.update');
Route::post('/updatepersons2', 'enteringpeoplesController@editform2')->name('updatepersons.update');
//Route::post('/updatepersons2', 'enteringpeoplesController@editform1')->name('updatepersons.update');
//Route::post('/updatepersons3', 'enteringpeoplesController@editform3')->name('updatepersons222.update2');
Route::get('/hefazat_cond/{id}', 'enteringpeoplesController@hefazat_cond');
Route::get('/personinfo/{id}', 'enteringpeoplesController@person_info');
Route::get('/personinfo2/{id}', 'enteringpeoplesController@person_info2');
Route::get('/get-date12/{code}', 'enteringpeoplesController@get_date12');
Route::get('/enterexit-history/{code}', 'enteringpeoplesController@enterexit_history');
Route::get('/auth-peaple-not-block', 'enteringpeoplesController@auth_duration_not_block');
Route::get('/auth-peaple-not-block2', 'enteringpeoplesController@auth_duration_not_block2');
Route::get('/auth-peaple-block', 'enteringpeoplesController@auth_duration_block');
Route::get('/block-history', 'enteringpeoplesController@block_history');
Route::get('/set-block/{id}','enteringpeoplesController@set_block');
Route::get('/reset-block/{id}','enteringpeoplesController@reset_block');
Route::get('/exist-peaple', 'enteringpeoplesController@exist_peaple');
//enteringcars
Route::post('/addcars','enteringcarsController@store')->name('addcars.store');
Route::post('/addcars2','enteringcarsController@store2')->name('addcars.store');
Route::delete('/car-delete/{id}', 'enteringcarsController@delete');
Route::delete('/car-delete2/{id}', 'enteringcarsController@delete2');
Route::post('/updatecars', 'enteringcarsController@editcar')->name('updatecars.edit');
Route::delete('/car-delete2/{id}', 'enteringcarsController@delete2');
Route::delete('/car-delete-all/{id}', 'enteringcarsController@delete_all');
Route::get('/truecars', 'enteringcarsController@truecars');
Route::get('/falsecars', 'enteringcarsController@falsecars');
Route::get('/selectcar/{id}', 'enteringcarsController@selectcar');

//enteringins
Route::post('/addins','enteringinsController@store')->name('addins.store');
Route::post('/addins2','enteringinsController@store2')->name('addins.store');
Route::delete('/ins-delete/{id}', 'enteringinsController@delete');
Route::delete('/ins-delete2/{id}', 'enteringinsController@delete2');
Route::delete('/ins-delete-all/{id}', 'enteringinsController@delete_all');
Route::post('/updateins', 'enteringinsController@editins')->name('updateins.edit');
//enteringeq
Route::post('/addeq','enteringeqsController@store')->name('addeq.store');
Route::post('/addeq2','enteringeqsController@store2')->name('addeq.store');
Route::delete('/eq-delete/{id}', 'enteringeqsController@delete');
Route::post('/updateeq', 'enteringeqsController@editeq')->name('updateeq.edit');
Route::delete('/eq-delete2/{id}', 'enteringeqsController@delete2');
Route::delete('/eq-delete-all/{id}', 'enteringeqsController@delete_all');
//enteringuploads
Route::delete('/eup-delete/{id}', 'enteringuploadsController@delete');
Route::post('/store-file', 'enteringuploadsController@store_file')->name('equpload.store');
Route::post('/store-file2', 'enteringuploadsController@store_file2')->name('equpload.store');
//Confirm1_entering
Route::get('/level1-entering','confirm1_entering@level1');
Route::get('/level2-entering','confirm1_entering@level2');
Route::get('/not-confirmed-boss2-entering','confirm1_entering@not_confirmed_boss');
Route::get('/not-confirmed-boss3-entering','confirm1_entering@not_confirmed_boss2');
Route::get('/totalparts','confirm1_entering@totalparts');

Route::get('/first-reciever-entering','confirm1_entering@create_first_reciever');
Route::get('/level-1-entering','confirm1_entering@level_1');
Route::get('/level-2-entering','confirm1_entering@level_2');
Route::get('/confirm1-entering/{id}', 'confirm1_entering@confirm1');
Route::get('/return1-entering/{id}', 'confirm1_entering@return1');
Route::post('/returnform-entering', 'confirm1_entering@returnform')->name('returnform.edit');
Route::get('/kartabl-entering/{id}', 'confirm1_entering@to_kartabl');


Route::get('/to-requester-entering/{id}', 'confirm1_entering@to_requester');
//Confirm2_entering  مدیریت
Route::get('/second-reciever-entering','confirm2_entering@create_second_reciever');
Route::get('/2level1-entering','confirm2_entering@level1');
//Route::get('/level2-entering','confirm2_entering@level2');
Route::get('/level3-entering','confirm2_entering@level3');
//modir
Route::get('/3not-confirmed-boss3-entering','confirm2_entering@not_confirmed_boss');
Route::get('/level6-entering','confirm2_entering@level6');
Route::get('/level5-entering','confirm2_entering@level5');
Route::get('/2level-1-entering','confirm2_entering@level_1');
Route::get('/2level-2-entering','confirm2_entering@level_2');
Route::get('/confirm6-entering/{id}', 'confirm2_entering@confirm6');
Route::get('/return2-entering/{id}', 'confirm2_entering@return1');
Route::post('/returnform4-entering', 'confirm2_entering@returnform')->name('returnform4.edit');
Route::get('/kartabl5-entering/{id}', 'confirm2_entering@to_kartabl5');

Route::get('/to-requester2-entering/{id}', 'confirm2_entering@to_requester');
//Confirm3_entering حراست
Route::get('/level4-entering','confirm3_entering@level4');
Route::get('/level5-entering','confirm3_entering@level5');
Route::get('/level3-3entering','confirm3_entering@level3_3');
Route::get('/total-peaple','confirm3_entering@total_peaple');


Route::get('/report_people1','confirm3_entering@report1');
Route::get('/third-reciever-entering','confirm3_entering@create_third_reciever');
Route::get('/2level1-entering','confirm3_entering@level1');
Route::get('/persons_recieve/{id}','confirm3_entering@persons');


Route::get('/level-3-entering','confirm3_entering@level_3');

Route::get('/2level-1-entering','confirm3_entering@level_1');
Route::get('/2level-2-entering','confirm3_entering@level_2');
Route::get('/confirm3-entering/{id}', 'confirm3_entering@confirm2');
Route::get('/return2-entering/{id}', 'confirm3_entering@return1');
Route::post('/returnform3-entering', 'confirm3_entering@returnform')->name('returnform.edit');
Route::get('/kartabl3-entering/{id}', 'confirm3_entering@to_kartabl');
Route::get('/2not-confirmed-boss2-entering','confirm3_entering@not_confirmed_boss');
Route::get('/to-requester2-entering/{id}', 'confirm3_entering@to_requester');
Route::post('/update-conditions', 'confirm3_entering@updatecondition')->name('updatecondition.edit');
//Route::get('/auth-peaple', 'confirm4_entering@auth_duration');
Route::get('/unauth-peaple', 'confirm3_entering@unauth_duration');
Route::get('/auth-cards', 'confirm3_entering@auth_cards');
Route::get('/unauth-cards', 'confirm3_entering@unauth_cards');
Route::post('/returnform-entering-herasat', 'confirm3_entering@returnform')->name('returnform.edit');
//Confirm4_entering
Route::get('/fourth-reciever-entering2','confirm4_entering@create_fourth_reciever');//it exists
Route::get('/fourth-reciever-entering','confirm4_entering@create_fourth_reciever2');//it exists
Route::get('/persons_recieve2/{code}','confirm4_entering@persons2');//it exists
Route::get('/auth-peaple2', 'confirm4_entering@auth_duration');//it exists
Route::get('/unauth-peaple2', 'confirm4_entering@unauth_duration');//it exists
Route::get('/presence', 'confirm4_entering@presence');//it exists
Route::get('/auth-cards2', 'confirm4_entering@auth_cards');//it exists
Route::get('/unauth-cards2', 'confirm4_entering@unauth_cards');//it exists
Route::get('/withoutcard', 'confirm4_entering@withoutcard');//it exists
//enteringindividuals
Route::post('/addindividuals','EnteringindividualController@store')->name('addindividuals.store');
Route::post('/addindividuals2','EnteringindividualController@store2')->name('addindividuals.store2');
Route::get('/personinfo3/{id}/{date1}/{date2}', 'EnteringindividualController@personinfo3');//it exists

Route::get('/set-entering/{id}/{date}/{time}', 'EnteringindividualController@set_entering');
Route::get('/set-exiting/{id}/{date}/{time}', 'EnteringindividualController@set_exiting');
Route::get('/set-entering2/{id}/{date}/{time}', 'EnteringindividualController@set_entering2');
Route::get('/set-exiting2/{id}/{date}/{time}', 'EnteringindividualController@set_exiting2');

Route::get('/personinfo4/{id}', 'EnteringindividualController@personinfo4');
Route::delete('/deleteindividuals/{id}', 'EnteringindividualController@deleteindividuals');
Route::get('/selectindividuals/{id}', 'EnteringindividualController@selectindividuals');
Route::get('/selectindividuals2/{date1}/{date2}', 'EnteringindividualController@selectindividuals2');
Route::get('/total-individuals/{date1}/{date2}', 'EnteringindividualController@total_individuals');
Route::post('/updateindividuals', 'EnteringindividualController@updateindividuals')->name('updateindividuals.store');
Route::get('/selectindividuals', 'EnteringindividualController@selectindp');
Route::get('/reporti','EnteringindividualController@reporti');
Route::get('/reporti2','EnteringindividualController@reporti2');
Route::post('/report_queryi','EnteringindividualController@report_queryi')->name('exit.report29');
//Confirm_imeni_entering
Route::get('/level2-imeni_entering','confirm_imeni_entering@level2');
Route::get('/level-herasatboss-entering','confirm_imeni_entering@herasatboss');
Route::get('/not-confirmed-imeni-entering','confirm_imeni_entering@not_confirmed_boss');


Route::get('/imeni-reciever-entering','confirm_imeni_entering@create_imeni_reciever');
Route::get('/persons_recieve/{id}','confirm_imeni_entering@persons');
Route::get('/level3-entering','confirm_imeni_entering@level3');
Route::get('/2level-1-entering','confirm_imeni_entering@level_1');
Route::get('/2level-2-entering','confirm_imeni_entering@level_2');
Route::get('/confirm_imeni-entering/{id}', 'confirm_imeni_entering@confirm2');
Route::get('/return2-entering/{id}', 'confirm_imeni_entering@return1');
Route::post('/returnform2-entering', 'confirm_imeni_entering@returnform')->name('returnform.edit');
Route::get('/kartablherasat-entering/{id}', 'confirm_imeni_entering@to_kartabl');
Route::get('/to-requester2-entering/{id}', 'confirm_imeni_entering@to_requester');
Route::post('/update-conditions2', 'confirm_imeni_entering@updatecondition')->name('updatecondition.edit');

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

//Mitsubishi
Route::get('/m-bazsaz-form','MitsubishiBazsazController@create');

Route::get('/m-bazsaz-total','MitsubishiBazsazController@bazsaz_total');
Route::post('/m-bazsaz-store', 'MitsubishiBazsazController@bazsaz_store')->name('bazsaz.store');
Route::delete('/m-bazsaz-delete/{id}', 'MitsubishiBazsazController@delete');
Route::post('/m-bazsaz-edit', 'MitsubishiBazsazController@bazsaz_edit')->name('bazsaz.edit');

Route::get('/m-seller-total','MitsubishiSellerController@seller_total');
Route::post('/m-seller-store', 'MitsubishiSellerController@seller_store')->name('seller.store');
Route::delete('/m-seller-delete/{id}', 'MitsubishiSellerController@delete');
Route::post('/m-seller-edit', 'MitsubishiSellerController@seller_edit')->name('seller.edit');

Route::get('/m-tamirkar-total','MitsubishiTamirkarController@tamirkar_total');
Route::post('/m-tamirkar-store', 'MitsubishiTamirkarController@tamirkar_store')->name('tamirkar.store');
Route::delete('/m-tamirkar-delete/{id}', 'MitsubishiTamirkarController@delete');
Route::post('/m-tamirkar-edit', 'MitsubishiTamirkarController@tamirkar_edit')->name('tamirkar.edit');

Route::get('/m-tamiratty-total','MitsubishiTamirattyController@tamiratty_total');
Route::post('/m-tamiratty-store', 'MitsubishiTamirattyController@tamiratty_store')->name('tamiratty.store');
Route::delete('/m-tamiratty-delete/{id}', 'MitsubishiTamirattyController@delete');
Route::post('/m-tamiratty-edit', 'MitsubishiTamirattyController@tamiratty_edit')->name('tamiratty.edit');

Route::get('/m-typgha-total','MitsubishiTypGhaController@typgha_total');
Route::post('/m-typgha-store', 'MitsubishiTypGhaController@store')->name('typgha.store');
Route::delete('/m-typgha-delete/{id}', 'MitsubishiTypGhaController@delete');
Route::post('/m-typgha-edit', 'MitsubishiTypGhaController@edit')->name('typgha.edit');

Route::get('/m-nir-total','MitsubishiNirNaController@total');
Route::post('/m-nir-store', 'MitsubishiNirNaController@store')->name('nir.store');
Route::delete('/m-nir-delete/{id}', 'MitsubishiNirNaController@delete');
Route::post('/m-nir-edit', 'MitsubishiNirNaController@edit')->name('nir.edit');

Route::get('/m-un-total','MitsubishiUniNuController@total');
Route::post('/m-un-store', 'MitsubishiUniNuController@store')->name('un.store');
Route::delete('/m-un-delete/{id}', 'MitsubishiUniNuController@delete');
Route::post('/m-un-edit', 'MitsubishiUniNuController@edit')->name('un.edit');

Route::get('/m-tapr-form','MitsubishiTamiratProgramController@create');
Route::get('/m-tapr-total','MitsubishiTamiratProgramController@total');
Route::post('/m-tapr-store', 'MitsubishiTamiratProgramController@store')->name('tp.store');
Route::delete('/m-tapr-delete/{id}', 'MitsubishiTamiratProgramController@delete');
Route::post('/m-tapr-edit', 'MitsubishiTamiratProgramController@edit')->name('tp.edit');
Route::post('/m-tapr-rep', 'MitsubishiTamiratProgramController@report_queryp')->name('tp.store');
Route::get('/m-tapr-rep2','MitsubishiTamiratProgramController@report_queryp2');
Route::get('/m-tapr-rep3/{id}','MitsubishiTamiratProgramController@report_queryp3');

Route::get('/m-tasepr-form','MitsubishiSendBazsaziGhataatController@create');
Route::post('/m-tasepr-store', 'MitsubishiSendBazsaziGhataatController@store')->name('tps.store');
Route::get('/m-tasepr-total','MitsubishiSendBazsaziGhataatController@total');
Route::get('/m-tasepr-total-today','MitsubishiSendBazsaziGhataatController@total_today');
Route::get('/m-tasepr-onlyone','MitsubishiSendBazsaziGhataatController@onlyone');
Route::get('/m-tasepr-onlyone2/{id}','MitsubishiSendBazsaziGhataatController@onlyone2');
Route::post('/m-tapsr-rep', 'MitsubishiSendBazsaziGhataatController@report_queryp')->name('tps2.store');
Route::get('/m-tapsr-rep2','MitsubishiSendBazsaziGhataatController@report_queryp2');
Route::get('/m-tapsr-rep3/{id}','MitsubishiSendBazsaziGhataatController@report_queryp3');
Route::get('/m-tapsr-rep4/{id}','MitsubishiSendBazsaziGhataatController@report_queryp4');
Route::post('/m-tapsr-edit', 'MitsubishiSendBazsaziGhataatController@edit')->name('tps.edit');
Route::delete('/m-tapsr-delete/{id}', 'MitsubishiSendBazsaziGhataatController@delete');

Route::post('/m-tarepr-store', 'MitsubishiResvBazsaziGhataatController@store')->name('tpr.store');
Route::get('/m-resvs_for_send/{id}','MitsubishiResvBazsaziGhataatController@resvs_for_send');
Route::post('/m-taprr-edit', 'MitsubishiResvBazsaziGhataatController@edit')->name('tpr.edit');
Route::delete('/m-taprr-delete/{id}', 'MitsubishiResvBazsaziGhataatController@delete');

Route::get('/m-tain-form','MitsubishiStoreProgramInController@create');
Route::post('/m-tain-store', 'MitsubishiStoreProgramInController@store')->name('tpi.store');
Route::get('/m-tain-total','MitsubishiStoreProgramInController@total');
Route::get('/m-tain-total-today','MitsubishiStoreProgramInController@total_today');
Route::get('/m-tain-onlyone','MitsubishiStoreProgramInController@onlyone');
Route::get('/m-tain-onlyone2/{id}','MitsubishiStoreProgramInController@onlyone2');
Route::post('/m-tain-rep', 'MitsubishiStoreProgramInController@report_queryp')->name('tpi2.store');
Route::post('/m-tain-rep3', 'MitsubishiStoreProgramInController@report_queryp3')->name('tpi4.store');
Route::get('/m-tain-rep4/{id}','MitsubishiStoreProgramInController@report_queryp4');
Route::get('/m-tain-rep5/{id}','MitsubishiStoreProgramInController@report_queryp5');
Route::get('/m-tain-rep2','MitsubishiStoreProgramInController@report_queryp2');
Route::post('/m-tain-edit', 'MitsubishiStoreProgramInController@edit')->name('tpi.edit');
Route::delete('/m-tain-delete/{id}', 'MitsubishiStoreProgramInController@delete');

Route::post('/m-taout-store', 'MitsubishiStoreProgramOutController@store')->name('tpo.store');
Route::get('/m-resvs_for_out/{id}','MitsubishiStoreProgramOutController@resvs_for_out');
Route::post('/m-taout-edit', 'MitsubishiStoreProgramOutController@edit')->name('tpo.edit');
Route::delete('/m-taout-delete/{id}/{id_t}', 'MitsubishiStoreProgramOutController@delete');
Route::get('/m_resvs_for_send/{id}','MitsubishiResvBazsaziGhataatController@resvs_for_send');

Route::get('/m-out-form','MitsubishiOutGhataatController@create');
Route::post('/m-out-store', 'MitsubishiOutGhataatController@store')->name('out.store');
Route::get('/m-out-total','MitsubishiOutGhataatController@total');
Route::get('/m-out-total-today','MitsubishiOutGhataatController@total_today');
Route::get('/m-out-onlyone','MitsubishiOutGhataatController@onlyone');
Route::get('/m-out-onlyone2/{id}','MitsubishiOutGhataatController@onlyone2');
Route::post('/m-out-rep', 'MitsubishiOutGhataatController@report_queryp')->name('out2.store');
Route::get('/m-out-rep2','MitsubishiOutGhataatController@report_queryp2');
Route::get('/m-out-rep5/{id}','MitsubishiOutGhataatController@report_queryp5');
Route::post('/m-out-edit', 'MitsubishiOutGhataatController@edit')->name('out.edit');
Route::delete('/m-out-delete/{id}', 'MitsubishiOutGhataatController@delete');

Route::get('/m-buy-form','MitsubishiBuyGhataatController@create');
Route::post('/m-buy-store', 'MitsubishiBuyGhataatController@store')->name('buy.store');
Route::get('/m-buy-total','MitsubishiBuyGhataatController@total');
Route::get('/m-buy-total-today','MitsubishiBuyGhataatController@total_today');
Route::get('/m-buy-onlyone','MitsubishiBuyGhataatController@onlyone');
Route::get('/m-buy-onlyone2/{id}','MitsubishiBuyGhataatController@onlyone2');
Route::post('/m-buy-rep', 'MitsubishiBuyGhataatController@report_queryp')->name('buy.store');
Route::get('/m-buy-rep5/{id}','MitsubishiBuyGhataatController@report_queryp5');
Route::post('/m-buy-edit', 'MitsubishiBuyGhataatController@edit')->name('buy.edit');
Route::delete('/m-buy-delete/{id}', 'MitsubishiBuyGhataatController@delete');

Route::get('/m-group-form','MitsubishiGroupNamesController@create');
Route::post('/m-group-store', 'MitsubishiGroupNamesController@store')->name('group1.store');
Route::get('/m-group-total','MitsubishiGroupNamesController@total');
Route::get('/m-group-total-today','MitsubishiGroupNamesController@total_today');
Route::get('/m-group-onlyone','MitsubishiGroupNamesController@onlyone');
Route::get('/m-group-onlyone2/{id}','MitsubishiGroupNamesController@onlyone2');
Route::post('/m-group-rep', 'MitsubishiGroupNamesController@report_queryp')->name('group2.store');
Route::post('/m-group-edit', 'MitsubishiGroupNamesController@edit')->name('group.edit');
Route::delete('/m-group-delete/{id}', 'MitsubishiGroupNamesController@delete');

Route::get('/m-equ-form','MitsubishiGhataatsController@create');
Route::post('/m-equ-store', 'MitsubishiGhataatsController@store')->name('equ1.store');
Route::get('/m-equ-total','MitsubishiGhataatsController@total');
Route::get('/m-equ-total-today','MitsubishiGhataatsController@total_today');
Route::get('/m-equ-onlyone','MitsubishiGhataatsController@onlyone');
Route::get('/m-equ-onlyone2/{id}','MitsubishiGhataatsController@onlyone2');
Route::post('/m-equ-rep', 'MitsubishiGhataatsController@report_queryp')->name('equ2.store');
Route::post('/m-equ-edit', 'MitsubishiGhataatsController@edit')->name('equ.edit');
Route::post('/m-equ-edit2', 'MitsubishiGhataatsController@edit2')->name('equ2.edit');
Route::delete('/m-equ-delete/{id}', 'MitsubishiGhataatsController@delete');
Route::get('/m-gh-gr/{id}','MitsubishiGhataatsController@gh_gr');
Route::get('/m-gh-ie/{id}','MitsubishiGhataatsController@gh_ie');
Route::get('/m-gh-gr1/{id}','MitsubishiGhataatsController@gh_gr1');
Route::get('/m-gh-gr2/{group2}/{ghataats}','MitsubishiGhataatsController@gh_gr2');
Route::get('/m-gh-gr3/{group1}/{ghataats}','MitsubishiGhataatsController@gh_gr3');

Route::get('/m-saz-total','MitsubishiSazandehController@total');
Route::post('/m-saz-store', 'MitsubishiSazandehController@store')->name('saz.store');
Route::delete('/m-saz-delete/{id}', 'MitsubishiSazandehController@delete');
Route::post('/m-saz-edit', 'MitsubishiSazandehController@edit')->name('saz.edit');

Route::get('/m-group-change','MitsubishiGroupChangeController@create');
Route::get('/m-group-total2/{id}','MitsubishiGroupChangeController@total2');

Route::get('/m-savabegh-search-by-ide','MitsubishiSavabeghController@create_search_by_ide');
Route::get('/m-savabegh-form','MitsubishiSavabeghController@create');
Route::get('/m-savabegh-insert/{type_sabegheh}/{mizan_kharabi}/{vaz_nasb}/{karkard}/{description}/{id_t1}/{id_sub}/{id_g_global}/{insert_type}/{ghataat4}/{radif1}/{radif2}/{program}/{id_t_bazsazi1}/{id_t_bazsazi2}','MitsubishiSavabeghController@savabegh_insert');
Route::get('/m-savabegh-update/{sav_type}/{mizan_kharabi}/{vaz_nasb}/{karkard}/{description}/{insert_type}/{id_s}/{id_g_global}/{id_sub}/{id_t1}/{id_e}/{id_t_prev}/{radif1}/{radif2}','MitsubishiSavabeghController@savabegh_update');
Route::get('/m-savabegh-delete/{sav_type}/{mizan_kharabi}/{vaz_nasb}/{karkard}/{description}/{id_t1}/{id_sub}/{id_g_global}/{insert_type}/{id_s}/{id_t2}/{id_t3}/{ghataat4}/{radif1}/{radif2}/{id_t_bazsazi1}/{id_t_bazsazi2}/{radif3}','MitsubishiSavabeghController@savabegh_delete');
Route::get('/m-inserted-rows/{id}','MitsubishiSavabeghController@inserted_rows');
Route::get('/m-get-history/{id}','MitsubishiSavabeghController@get_history');
Route::delete('/m-history-delete/{id}', 'MitsubishiSavabeghController@delete');
Route::get('/m-get-history-tamirat-prog/{id}','MitsubishiTamiratProgramController@get_history');
Route::get('/m-get-history-bazsazi-prog/{id}','MitsubishiResvBazsaziGhataatController@get_history');
Route::get('/m-get-history-bazsazi-prog2/{id}','MitsubishiResvBazsaziGhataatController@get_history2');
Route::get('/m-get-history-anbar-prog/{id}','MitsubishiStoreProgramOutController@get_history');
Route::get('/m-get-history-anbar-prog2/{id}','MitsubishiStoreProgramOutController@get_history2');
Route::get('/m-get-history-buy-prog/{id}','MitsubishiBuyGhataatController@get_history');
Route::get('/m-get-history-out-prog/{id}','MitsubishiBuyGhataatController@get_history');
Route::get('/m-get-history-enter_exit-prog/{id}','MitsubishiOutGhataatController@get_history');

Route::get('/m-jalali','MitsubishiTamiratProgramController@convert_to_jalali');
Route::get('/m-update_exit_no','MitsubishiStoreProgramOutController@update_exit_no');