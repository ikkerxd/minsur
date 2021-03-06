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
Route::get('/anexo4/{id}/', 'CertificateController@anexo4')->name('an   exo4');
Route::get('/constacia-covid/{id}/', 'CertificateController@covid')->name('covid');
Route::get('/constacia-covid/{id}/', 'CertificateController@covid')->name('covid');

Route::get('/certificado/list/cursos/', 'CertificateController@course')->name('list_course');
// Route::get('/sustitutorio2', 'CertificateController@ingresar')->name('carga_import');
// Route::post('/sustitutorio2', 'CertificateController@cargardni')->name('cargardni');

Route::get('/certificado/course/{id}/', 'CertificateController@course_certificado_pisco')->name('course_certificado');
Route::get('/export/certificado/course/{id}/', 'CertificateController@export_certification')->name('export_course');
Route::get('/user/all_certificado/{id}/', 'CertificateController@all_certification')->name('all_certificado');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//route medina
Route::get('company/company_contacts', 'CompanyController@listconctact')->name('company_contacts');
Route::get('company/company_detail', 'CompanyController@detailsCompany')->name('company_detail');
Route::get('company/reportedp', 'CompanyController@reportEDP')->name('reportedp');
Route::get('company/company', 'CompanyController@reportpendingp')->name('pending_payment_report');
Route::get('company/statusUpdate', 'CompanyController@statusUpdate')->name('statusUpdate');
//end route medina
Route::get('/buscar_dni/{dni}', 'InscriptionController@buscar_dniuserInscription');

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

	

	Route::resource('roles','RoleController');

	Route::resource('users','UserController');

	Route::resource('companies','CompanyController');

	Route::resource('type_courses','TypeCourseController');

	Route::resource('courses','CourseController');

	Route::resource('locations','LocationController');

	Route::resource('inscriptions','InscriptionController');

	Route::get('pic','CompanyController@report_menejoDefensivo')->name('pic');

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
    Route::post('company/deactivate/{id}','UserController@desactivateUser')->name('desactivate_participant');

    Route::get('participant/detail/{id}','UserController@detail_participant')->name('detail-participant');

    Route::post('json_list_historico','UserController@json_list_historico')->name('json_list_historico');

	Route::post('json_list_fys','UserController@json_list_fys')->name('json_list_fys');

	Route::get('detail_history/{dni}','UserController@detail_history')->name('detail_history');

	Route::post('register_participant','UserController@register_participant')->name('register_participant');

	Route::resource('participants','ParticipantController');
	Route::post('sendmail','HomeController@sendMail_UserInscriptions')->name('sendmail');
	Route::get('json_list_user','UserController@json_list_user')->name('json_list_user');

	Route::get('report/company/u','UserController@list_participants')->name('list_participants');

    Route::get('upload_participant_validate_participant','UserController@new_participant')->name('new_participant');
    Route::get('edit_participant/{id}','UserController@edit_participants')->name('edit_participant');
    Route::get('upload_participant','UserController@upload_participant')->name('upload_participant');
    Route::post('participant/upload-participant-validate','UserController@upload_participant_validate')->name('upload_participant_validate');

    Route::get('user/company/edit/{id}','UserController@editUserCompany')->name('edit_user_company');
    Route::put('user/company/update/{id}','UserController@updateUserCompany')->name('update_user_company');

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


    Route::get('report/company/{id_user_inscription}/{startDate}/{endDate}','CompanyController@report_company_participant')->name('report_company_participant');
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

    /*Route::post('/invoice/valorization', 'InvoiceController@valorization')->name('invoice-val');
    Route::post('/invoice/billing', 'InvoiceController@report_valorization')->name('invoice-billing');
    Route::post('/invoice/paid', 'InvoiceController@report_valorization')->name('invoice-paid');
    Route::post('/invoice/anulate', 'InvoiceController@report_valorization')->name('invoice-anulate');
    Route::post('/invoice/observation', 'InvoiceController@report_valorization')->name('invoice-observation');*/

    Route::post('/user-inscriptions/{id}', 'UserInscriptionController@anulateUserInscription')->name('anulate_user_inscription');

    Route::get('reporte/curso/obligatorio/', 'CourseController@reportRequiredCourses')->name('required_courses');
    Route::get('export/curso/obligatorio/participante', 'CourseController@exportRequiredCourses')->name('export_required_courses_participants');

    Route::get('reporte/curso/obligatorio/contrata', 'CourseController@reportDailyRequied')->name('daily_report_required');
    Route::get('export/curso/obligatorio/contrata', 'CourseController@exportDailyRequiedCourses')->name('export_daily_report_required');
    Route::get('export/curso/obligatorio/list/contrata', 'CourseController@exportStatusContrataList')->name('export_status_list_contrata');

    Route::get('reporte/curso/obligatorio/company', 'CourseController@statusCompany')->name('status_company');
    Route::get('export/curso/obligatorio/company', 'CourseController@exportStatusCompany')->name('export_status_company');
    Route::get('export/curso/obligatorio/list/company', 'CourseController@exportStatusCompanyList')->name('export_status_list_company');


	
    Route::get('all-um','ChartController@index')->name('chart_all');
    Route::get('raura','ChartController@raura')->name('chart_raura');
    Route::get('san-rafael','ChartController@sanrafael')->name('chart_sanrafael');
    Route::get('pucamarca','ChartController@pucamarca')->name('chart_pucamarca');

    /********* Proceso de facturacion de por cada unidad minera *********/
    Route::get('report/company/um/{id}','CompanyController@report_list_company')->name('companies_um');
    Route::post('report/company/um/{id}','CompanyController@report_list_company')->name('companies_um');

    /********* Reporte de de partcipante del client *********/
    Route::get('report/participante','CompanyController@report_list_participants')->name('report_participants');
    Route::post('report/participante','CompanyController@report_list_participants')->name('report_participants');
    Route::get('export_list_participant/participante/{id}/{startDate}/{endDate}', 'CompanyController@export_list_participant')
        ->name('export_list_participant');

    /********* Reporte de de partcipante del client *********/

    Route::get('export/participante/{id}/{startDate}/{endDate}', 'CompanyController@export_consolidado')
		->name('export_consolidado');
	
	//fotocheck
	Route::get('participant/{user}/fotocheck', 'FotocheckController@solicited')
		->name('fotocheck.solicited')/*->middleware('permission:fotocheck.solicited')*/;
	Route::get('participant/fotocheck/list', 'FotocheckController@list')
		->name('fotochecks.list');
	Route::get('participant/fotocheck/{fotocheck}/detail', 'FotocheckController@detail')
		->name('fotocheck.detail');
	Route::get('participant/fotocheck/{user}/index', 'FotocheckController@index')
	->name('fotochecks.index');
	route::post('participant/fotocheck/{user}/store','FotocheckController@store')->name('fotocheck.store');
	Route::get('participant/fotocheck/{fotocheck}/cancel','FotocheckController@cancel')->name('fotocheck.cancel');
	Route::get('participant/fotocheck/{fotocheck}/accept','FotocheckController@accept')->name('fotocheck.accept');
	Route::get('participant/fotocheck/exportRequirements','FotocheckController@exportRequeriments')->name('fotochecks.export');
	Route::get('participant/fotocheck/{fotocheck}/download','FotocheckController@download')->name('fotocheck.download');
	Route::get('participant/fotocheck/{fotocheck}/download','FotocheckController@download')->name('fotocheck.download');
	//
	Route::get('participant/fotocheck/{fotocheck}/fotocheck_course/{id_course}/download','FotocheckController@downloadDocs')->name('fotocheck_course.download');

});
