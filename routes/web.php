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

Route::get('/',function(){
	return view('auth.login');
});

Route::get('/certificado/search', 'CertificateController@search')->name('certificate_search');
Route::post('/certificado/search/', 'CertificateController@search')->name('certificate_search');
Route::get('/certificado/{id}/', 'CertificateController@certification')->name('certificado');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/buscar_dni/{dni}', 'InscriptionController@buscar_dni');

Route::post('search_ruc','CompanyController@search_ruc')->name('search_ruc');

Route::post('/register_company','CompanyController@register_company');

Route::get('/registerCompany','CompanyController@register_companyg');

Route::post('/register_company_user','CompanyController@register_companyp');


Route::middleware(['auth'])->group(function(){	

	Route::get('export/{id}', 'UserController@export')->name('export');
    Route::get('descriptions/export/{id}', 'InscriptionController@export_inscription')->name('export_inscription');
    Route::post('descriptions/upload/{id}', 'InscriptionController@import_inscription')->name('import_inscription');

    Route::get('report/export/participant/{id}/{startDate}/{endDate}', 'CompanyController@export_participant')
        ->name('export_company_participant');

	// Route::get('/enviar', 'testPHPMailerController@index');
	
	Route::resource('roles','RoleController');

	Route::resource('users','UserController');

	Route::resource('companies','CompanyController');

	Route::resource('type_courses','TypeCourseController');

	Route::resource('courses','CourseController');

	Route::resource('locations','LocationController');

	Route::resource('inscriptions','InscriptionController');

	Route::get('profile','UserController@profile')->name('profile');

	Route::post('json_inscription','InscriptionController@json_inscription')->name('json_inscription');

	Route::get('/inscription','InscriptionController@user_inscription');

	Route::get('detail_inscription/{id}','InscriptionController@detail_inscription')->name('detail_inscription');

	Route::get('detail-inscriptionc/{id}','InscriptionController@detail_inscription_contrata')->name('detail-inscriptionc');

	Route::get('/inscription_participants/{id}','InscriptionController@inscription_participants')->name('inscription_participants');

	Route::get('/details','InscriptionController@details')->name('inscription_participants_details');

	Route::post('reschedule','InscriptionController@reschedule')->name('reschedule');

	Route::post('reschedule_start','UserInscriptionController@reschedule_start')->name('reschedule_start');

	Route::post('cancel','InscriptionController@cancel')->name('cancel');

	Route::post('cancel_start','UserInscriptionController@cancel_start')->name('cancel_start');

	Route::get('userInscription/{id}','InscriptionController@userInscription')->name('userInscription');

	Route::get('download_file/{file}','UserInscriptionController@download_file')->name('download_file');

	Route::resource('userInscriptions','UserInscriptionController');

    Route::get('validate-participant','UserController@validate_participant')->name('validate-participant');

    Route::get('participant/search','UserController@search_participant')->name('search-participant');


    Route::post('company/search-participant','UserController@company_participant')->name('search_participant_contrata');
    Route::get('company/search-participant','UserController@company_participant')->name('search_participant_contrata');

    Route::post('company/change/{id}','UserController@changeCompany')->name('change_company');


    Route::get('participant/detail/{id}','UserController@detail_participant')->name('detail-participant');

    Route::post('json_list_historico','UserController@json_list_historico')->name('json_list_historico');

	Route::post('json_list_fys','UserController@json_list_fys')->name('json_list_fys');

	Route::get('detail_history/{dni}','UserController@detail_history')->name('detail_history');

	Route::post('register_participant','UserController@register_participant')->name('register_participant');

	Route::resource('participants','ParticipantController');
	Route::post('sendmail','HomeController@sendMail_UserInscriptions')->name('sendmail');
	Route::get('json_list_user','UserController@json_list_user')->name('json_list_user');

	Route::get('list_participants','UserController@list_participants')->name('list_participants');

	Route::get('edit_participant/{id}','UserController@edit_participants')->name('edit_participant');
    Route::get('new_participant','UserController@new_participant')->name('new_participant');
    Route::get('upload_participant','UserController@upload_participant')->name('upload_participant');
    Route::post('participant/upload-participant-validate','UserController@upload_participant_validate')->name('upload_participant_validate');

	Route::put('update_participants/{id}','UserController@update_participant')->name('update_participants');

	Route::post('user_store','UserController@register_participant')->name('user_store');
	Route::get('register_point/{id}','InscriptionController@register_point')->name('register_point');
	Route::post('update_point','InscriptionController@update_point')->name('update_point');
	Route::get('medical_center','InscriptionController@medical_center')->name('medical_center');
	Route::get('show_participant/{id}','UserController@show_participant')->name('show_participant');
	Route::get('/json_list_medical','InscriptionController@json_list_medical')->name('json_list_medical');
	Route::get('/json_list_prom_curso','InscriptionController@json_list_prom_curso')->name('json_list_prom_curso');
    Route::get('report/company','CompanyController@report_company')->name('report_company');
    Route::post('report/company','CompanyController@report_company')->name('report_company');
    Route::get('report/company/{id}/{startDate}/{endDate}','CompanyController@report_company_participant')->name('report_company_participant');
    Route::get('report/company/{id}','CompanyController@report_company_participant')->name('report_company_participant');

	Route::get('check','BuildingController@check')->name('check');
	Route::post('/val-company', 'BuildingController@valCompany');
	Route::post('/val-participant', 'BuildingController@valUser');
	Route::get('register_participants/{id}','InscriptionController@register_participants')->name('register_participants');
	Route::post('register_upload_participants','BuildingController@register_upload_participants')->name('register_upload_participants');
	Route::get('centroMedico','InscriptionController@centroMedico')->name('centroMedico');
	Route::get('createInscription','InscriptionController@createInscription')->name('createInscription');
	Route::post('save_cm','InscriptionController@save_cm')->name('save_cm');
	Route::get('register_cm/{id}','InscriptionController@register_cm')->name('register_cm');
	//HENRY
	Route::post('/delete-inscription/{id}','InscriptionController@delete_inscription_participante')->name('delete-inscription');
	Route::post('/reschedule-validate/{id}','InscriptionController@reschedule_validate')->name('reschedule-validate');
	Route::post('/reschedule-user/{id}', 'InscriptionController@reschedule_user')->name('reschedule_user');
	Route::get('/cons_part', 'CompanyController@cons_part')->name('cons_part');
	Route::get('register_part_manual/{id}','InscriptionController@register_part_manual')->name('register_part_manual');

	Route::post('register_part_manual_post','InscriptionController@register_part_manual_post')->name('register_part_manual_post');

	Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('permission:users.edit');

    Route::post('/invoice/contrata', 'InvoiceController@invoice')->name('invoice-contrata');
    Route::get('/invoice/valorizacion/{id}', 'InvoiceController@report_valorization')->name('invoice-valorizacion');

    Route::post('/user-inscriptions/{id}', 'UserInscriptionController@anulateUserInscription')->name('anulate_user_inscription');

    Route::get('all-um','ChartController@index')->name('chart_all');
    Route::get('raura','ChartController@raura')->name('chart_raura');
    Route::get('san-rafael','ChartController@sanrafael')->name('chart_sanrafael');
    Route::get('pucamarca','ChartController@pucamarca')->name('chart_pucamarca');

});
