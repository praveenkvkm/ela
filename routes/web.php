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

Auth::routes();

// Clear view cache:
 Route::get('/view-clear', function() {
     $exitCode = Artisan::call('view:clear');
     //return 'View cache cleared';
 });

Route::get('/', function () {return view('/auth/login-ela');});

Route::get('/ela-admin', function () {return view('/auth/login-ela-admin');});
Route::get('/copyreg', 'UserController@copy_reg_number_to_ela_user');
Route::get('/messenger', function () {return view('admin.messenger-admin');});
Route::post('/send_mail_forgot_pwd', 'MailController@send_mail_forgot_pwd');
Route::post('/check_forgot_pwd', 'MailController@check_forgot_pwd');

Route::get('/stud-reg-basic', function () {return view('/auth/stud-reg-step1');}); 
Route::get('/stud-reg-academic', function () {return view('/auth/stud-reg-step2');}); 
Route::get('/stud-reg-bio', function () {return view('/auth/stud-reg-step3');}); 

Route::post('/insert_stud_reg_basic', 'UserController@insert_stud_reg_basic');
Route::post('/insert_stud_reg_academic', 'UserController@insert_stud_reg_academic');
Route::post('/insert_stud_reg_bio', 'UserController@insert_stud_reg_bio');

Route::post('/insert_admin', 'UserController@insert_admin');
Route::post('/insert_mentor', 'UserController@insert_mentor');
Route::post('/insert_student', 'UserController@insert_student');
Route::post('/insert_user', 'UserController@insert_user');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', function () {return view('/auth/login-ela');}); 
Route::post('/attempt_user_login', 'UserController@attempt_user_login');
Route::post('/check_unique_username', 'UserController@check_unique_username');
Route::post('/get_genders', 'CommonController@get_genders');

Route::group(['middleware' => 'ela_user'], function () 
{
	
	Route::get('admin/dashboard', function () {return view('/admin/landing-admin');});  
	Route::get('mentor/dashboard', function () {return view('/mentor/landing-mentor');}); 
	Route::get('student/dashboard', function () {return view('/student/landing-student');}); 
	
	Route::post('update_edit_student', 'UserController@update_edit_student');
	Route::post('update_approve_student', 'UserController@update_approve_student');
	Route::post('update_activate_student', 'UserController@update_activate_student');
	Route::post('upload_profile_pic', 'UserController@upload_profile_pic');
	Route::post('update_non_approved_mentor', 'UserController@update_non_approved_mentor');
	Route::post('update_approved_mentor', 'UserController@update_approved_mentor');
	Route::post('reset_password', 'UserController@reset_password');
	Route::post('set_password', 'UserController@set_password');
	Route::get('copy_stud_grades_to_stud_in_grades', 'UserController@copy_stud_grades_to_stud_in_grades');
	Route::post('insert_mentor', 'UserController@insert_mentor'); 
	Route::get('/elauserlogout', 'UserController@elauserlogout');
		
	Route::get('admin/stud-group', function () {return view('/admin/add-stud-group');}); 
	Route::get('admin/stud-grade', function () {return view('/admin/add-stud-grade');}); 
	Route::get('admin/add-mentor', function () {return view('/admin/add-mentor');}); 
	Route::get('admin/add-student', function () {return view('/admin/add-student');}); 
	Route::get('admin/stud-in-group', function () {return view('/admin/add-stud-in-group');}); 
	Route::get('admin/add-activity', function () {return view('/admin/add-activity');}); 
	Route::get('admin/activity/dashboard', function () {return view('/admin/activity/dashboard-activity');}); 
	Route::get('admin/activity/add-media', function () {return view('/admin/activity/add-media');}); 
	Route::get('admin/activity/add-invite-students', function () {return view('/admin/activity/add-invite-students');}); 
	Route::get('admin/activity/send-for-approval', function () {return view('/admin/activity/send-for-approval');}); 
	Route::get('admin/activity/activity-list', function () {return view('/admin/activity/activity-list');}); 
	Route::get('admin/activity/activity-pool', function () {return view('/admin/activity/activity-pool');}); 
	Route::get('admin/activity/create-activity', function () {return view('/admin/activity/create-activity');}); 
	Route::get('admin/view-activity/{id}', 'ActivityController@open_activity_for_approval');
	Route::get('admin/student/admin-students-list', function () {return view('/admin/student/admin-students-list');}); 
	Route::get('admin/student/admin-students-pool', function () {return view('/admin/student/admin-students-pool');}); 
	Route::get('admin/student/stud-reg-basic', function () {return view('/admin/student/stud-reg-step1');}); 
	Route::get('admin/student/stud-reg-academic', function () {return view('/admin/student/stud-reg-step2');}); 
	Route::get('admin/student/stud-reg-bio', function () {return view('/admin/student/stud-reg-step3');}); 
	Route::get('admin/student/stud-registration', function () {return view('/admin/student/stud-registration');}); 
	Route::get('admin/student/stud-reg-div2', function () {return view('/admin/student/stud-reg-div2');}); 
	Route::get('admin/student/stud-reg-div3', function () {return view('/admin/student/stud-reg-div3');}); 
	Route::get('admin/mentor/admin-mentor-list', function () {return view('/admin/mentor/admin-mentor-list');}); 
	Route::get('admin/mentor/admin-mentor-pool', function () {return view('/admin/mentor/admin-mentor-pool');}); 
	Route::get('admin/mentor/add-mentor', function () {return view('/admin/mentor/add-mentor');}); 
	Route::post('admin/insert_user', 'UserController@insert_user');
	
	Route::post('insert_stud_group', 'AdminController@insert_stud_group'); 
	Route::post('insert_stud_grade', 'AdminController@insert_stud_grade'); 
	Route::post('insert_stud_in_group', 'AdminController@insert_stud_in_group'); 
	Route::post('get_studs_by_group_id', 'AdminController@get_studs_by_group_id'); 
	Route::post('allocate_stud_in_group', 'AdminController@allocate_stud_in_group'); 
	Route::post('allocate_group_to_student', 'AdminController@allocate_group_to_student'); 
	Route::post('allocate_mentor_to_student', 'AdminController@allocate_mentor_to_student'); 
	Route::post('allocate_grade_to_mentor', 'AdminController@allocate_grade_to_mentor'); 
	Route::post('update_motivation_text', 'AdminController@update_motivation_text'); 
	Route::post('set_session_add_new_student_from_page', 'AdminController@set_session_add_new_student_from_page'); 
	
	Route::post('insert_activity_content', 'ActivityController@insert_activity_content');
	Route::post('upload_act_acs', 'ActivityController@upload_act_acs'); 
	Route::post('allocate_student_in_activity', 'ActivityController@allocate_student_in_activity'); 
	Route::post('allocate_group_in_activity', 'ActivityController@allocate_group_in_activity'); 
	Route::post('allocate_grade_in_activity', 'ActivityController@allocate_grade_in_activity'); 
	Route::post('insert_activity_publish_subjects', 'ActivityController@insert_activity_publish_subjects'); 
	Route::post('insert_send_for_approval', 'ActivityController@insert_send_for_approval'); 
	Route::post('approve_activity_publish', 'ActivityController@approve_activity_publish'); 
	Route::post('change_activity_expiry_date', 'ActivityController@change_activity_expiry_date'); 
	Route::post('approve_activity_rejection', 'ActivityController@approve_activity_rejection'); 
	Route::post('delete_activity_publish', 'ActivityController@delete_activity_publish'); 
	Route::post('return_activity_detail_by_id', 'ActivityController@return_activity_detail_by_id'); 
	Route::get('student/activity/students-activity/{room_id}', 'ActivityController@open_student_activity');
	Route::post('upload_stud_act_acs', 'ActivityController@upload_stud_act_acs'); 
	Route::post('update_student_room_statuses', 'ActivityController@update_student_room_statuses'); 
	Route::get('act_allocations', 'ActivityController@act_allocations'); 
	Route::post('insert_mentor_room_evaluations', 'ActivityController@insert_mentor_room_evaluations'); 
	Route::post('update_mentor_room_evaluation_statuses', 'ActivityController@update_mentor_room_evaluation_statuses'); 
	Route::post('insert_mentor_room_reminders', 'ActivityController@insert_mentor_room_reminders'); 
	Route::post('update_reminder_readed', 'ActivityController@update_reminder_readed'); 
	Route::post('insert_ev_criterias', 'ActivityController@insert_ev_criterias'); 
	Route::post('update_approve_evaluation', 'ActivityController@update_approve_evaluation'); 
	Route::post('update_finish_activity', 'ActivityController@update_finish_activity'); 
	Route::post('make_or_select_room', 'ActivityController@make_or_select_room'); 
	Route::post('delete_student_act_upload', 'ActivityController@delete_student_act_upload'); 
	
	
	Route::post('edit_allocate_student_in_activity', 'EditActivityAllocationController@edit_allocate_student_in_activity'); 
	Route::post('edit_allocate_group_in_activity', 'EditActivityAllocationController@edit_allocate_group_in_activity'); 
	Route::post('edit_allocate_grade_in_activity', 'EditActivityAllocationController@edit_allocate_grade_in_activity'); 	

	
	Route::get('mentor/add-student', function () {return view('/mentor/add-student');}); 
	Route::get('mentor/mentor-my-students', function () {return view('/mentor/mentor-my-students');}); 
	Route::get('mentor/mentor-my-activities', function () {return view('/mentor/mentor-my-activities');}); 
	Route::get('mentor/activity/activity-evaluation/{room_id}', function () {return view('/mentor/activity/activity-evaluation', compact('room_id'));}); 
	Route::get('mentor/activity/activity-evaluation/{room_id}', 'ActivityController@open_activity_evaluation');
	Route::get('mentor/activity/create-activity', function () {return view('/mentor/activity/create-activity');}); 
	Route::get('mentor/activity/dashboard', function () {return view('/mentor/activity/dashboard-activity');}); 
	Route::get('mentor/activity/add-media', function () {return view('/mentor/activity/add-media');}); 
	Route::get('mentor/activity/add-invite-students', function () {return view('/mentor/activity/add-invite-students');}); 
	Route::get('mentor/activity/send-for-approval', function () {return view('/mentor/activity/send-for-approval');}); 
	
	Route::post('get_student_detail', 'CommonController@get_student_detail'); 
	Route::post('get_groups_own_students', 'CommonController@get_groups_own_students'); 
	Route::post('get_mentor_full_detail_by_id', 'CommonController@get_mentor_full_detail_by_id'); 
	Route::post('get_students_responses_to_activity', 'CommonController@get_students_responses_to_activity'); 
	Route::post('get_student_full_detail_by_id', 'CommonController@get_student_full_detail_by_id'); 
	Route::post('get_mentor_room_evaluations_by_room_by_student', 'CommonController@get_mentor_room_evaluations_by_room_by_student'); 
	Route::post('get_allocations_by_room_id', 'CommonController@get_allocations_by_room_id'); 
	
	Route::post('insert_notifications', 'NotificationController@insert_notifications'); 
	Route::get('/admin/student/students-list-print', function () {return view('/admin/student/students-list-print');}); 
	Route::post('get_students_by_stud_grade_id', 'StudentController@get_students_by_stud_grade_id'); 
	Route::get('/admin/student/single-student-print/{id}', 'StudentController@open_print_single_student'); 
	
	Route::post('insert_message', 'MessengerController@insert_message');
	Route::post('read_non_viewed_messages', 'MessengerController@read_non_viewed_messages');
	Route::post('read_and_mark_non_viewed_messages', 'MessengerController@read_and_mark_non_viewed_messages');
	Route::post('read_all_messages_with_reply', 'MessengerController@read_all_messages_with_reply');
	Route::get('read', 'MessengerController@read_all_messages_with_reply');
	
	
});


Route::group(['middleware' => 'admin','prefix' => 'admin'], function () 
{

	//Route::get('/dashboard', function () {return view('/admin/dashboard-admin');}); 

	//Route::get('/add-mentor', function () {return view('/admin/add-mentor');}); 

	//Route::get('/logout', 'UserController@adminlogout');
	
	//Route::post('/insert_mentor_by_admin', 'MentorController@insert_mentor_by_admin');
	
	
});

Route::group(['middleware' => 'mentor','prefix' => 'mentor'], function () 
{

	//Route::get('/dashboard', function () {return view('/mentor/dashboard-mentor');}); 

	//Route::get('/logout', 'UserController@mentorlogout');
	
	
});

Route::group(['middleware' => 'student', 'prefix' => 'student'], function () 
{

	//Route::get('/dashboard', function () {return view('/student/dashboard-student');}); 

	//Route::get('/logout', 'UserController@studentlogout');
	
	
});

