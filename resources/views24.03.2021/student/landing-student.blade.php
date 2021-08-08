@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$sc = app()->make('App\Http\Controllers\StudentController');
$ac = app()->make('App\Http\Controllers\AdminController');

$stud_groups =  app()->call([$cc, 'get_stud_groups']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);
$genders =  app()->call([$cc, 'get_genders']);
$school_manage_categories =  app()->call([$cc, 'get_school_manage_categories']);
$parent_relationships =  app()->call([$cc, 'get_parent_relationships']);
$guardian_employers =  app()->call([$cc, 'get_guardian_employers']);
$districts =  app()->call([$cc, 'get_districts']);
$blood_groups =  app()->call([$cc, 'get_blood_groups']);
$physical_statuses =  app()->call([$cc, 'get_physical_statuses']);
$motivation_text =  app()->call([$ac, 'get_motivation_text']);

$return_data =  app()->call([$cc, 'get_students_approved_activities']);

$students_approved_activities = $return_data['students_approved_activities'];
	
$count_students_approved_activities = count($students_approved_activities);

$students_approved_activities_completed = $return_data['students_approved_activities_completed'];

$count_students_approved_activities_completed = count($students_approved_activities_completed);

$students_approved_activities_not_completed = $return_data['students_approved_activities_not_completed'];

$student_id = Auth::guard('ela_user')->user()->id;

$profile_pic_path = app()->call([$cc, 'get_student_profile_pic_by_id'], [$student_id]);
$student_grade = app()->call([$cc, 'get_student_grade_by_id'], [$student_id]);

$students_total_scores = app()->call([$sc, 'get_students_total_scores'], [$student_id]);

$aggr_sum_marks = (count($students_total_scores )!=0)? $students_total_scores[0]->aggr_sum_marks: '-';
$aggr_sum_base_mark = (count($students_total_scores )!=0)? $students_total_scores[0]->aggr_sum_base_mark: '-';
$ev_criterias = array();

?>

<script>
$(document).ready(function() {
	
	activity_id =0;
	room_id = 0;
	publish_id = 0;
	

	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		student_id = '{{ $student_id }}'; /* GET FIRST STUDENT ID  */
		
		user_id_receiver = 7;
				
		get_student_detail(student_id); /* GET FIRST STUDENT DETAIL  */
		
	
});


	$(document).on('click', '#a-notifications', function()
	{
		$('#span-notifications-count').hide(500);
		
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/update_reminder_readed';
				
		var data = {};
		data['_token'] = CSRF_TOKEN;
		
		var reminder_id = {};
		
		$('.room-reminder').each(function(index, elem) 
		{
			reminder_id[index] = $(this).data("reminder_id");
			
		});		
		
		
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: {data, reminder_id},
		   async:false,
		   success:function(result_data)
			   {
					//alert('Updated.');
				   
				}
			});
			
		
		

		  
		
	});

	
	$(document).on('click', '#btn-modal-view-activity-close', function()
	{
	
		  $('audio').each(function(){
			this.pause(); // Stop playing
			this.currentTime = 0; // Reset time
		  }); 
		  
		 $('video').each(function(){
			this.pause(); // Stop playing
			this.currentTime = 0; // Reset time
		  }); 

		  
		
	});
		
		
	$(document).on('click', '.btn-view-activity', function()
	{
		activity_id = $(this).attr('value');
		room_id = $(this).data('room_id');
		return_activity_detail_by_id();
		
	});
	
	
	$(document).on('click', '#a-update-edit-student', function()
	{
		
		if(!$('#edit_first_name').val())
		{
			alert('Please enter First Name.');
		}
		else
		{
			
			if(confirm("Are you sure to Update ?"))
			{
				update_edit_student();
			}
			
			
		}
		
		
	});
	
	
	function return_activity_detail_by_id()
	{

		var	url_var = APP_URL + '/return_activity_detail_by_id';
		
		var data = {};
		data['id'] = activity_id;
		data['room_id'] = room_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				    activity_master = result_data['activity_master'];
				    act_acs_videos = result_data['act_acs_videos'];
				    act_acs_audios = result_data['act_acs_audios'];
				    act_acs_docs = result_data['act_acs_docs'];
				    act_pbsh_grades = result_data['act_pbsh_grades'];
				    act_pbsh_subjects = result_data['act_pbsh_subjects'];
					
					
					
					
				   					
					$('#videoActivity').empty();
					if(act_acs_videos.length > 0 )
					{
						video_path = "{{url('/public')}}" + act_acs_videos[0].acs_file_path + act_acs_videos[0].acs_file_name ;
					
					}
					else
					{
						video_path = "" ;
					
					}
					
						video_source = '<source src="' + video_path + '" type="video/mp4">' + 
										'<source src="' +   video_path + '" type="video/ogg">';
										
						$('#videoActivity').html(video_source);


					$('#audioActivity').empty();
					if(act_acs_audios.length > 0 )
					{
						audio_path = "{{url('/public')}}" + act_acs_audios[0].acs_file_path + act_acs_audios[0].acs_file_name ;
					}
					else
					{
						audio_path = "" ;
					}
					
						audio_source = '<source src="' + audio_path + '" type="audio/ogg">' + 
										'<source src="' +   audio_path + '" type="audio/mpeg">';
										
						$('#audioActivity').html(audio_source);
					
					
					
					$('#docsActivity').attr('src', '')
					if(act_acs_docs.length > 0)
					{
						docs_source = "{{url('/public')}}" + act_acs_docs[0].acs_file_path + act_acs_docs[0].acs_file_name ;
					}
					else
					{
						docs_source = "" ;
					}
						$('#docsActivity').attr('src', docs_source)
					
					
					
					
					
					
				   
					$('#view_activity_title').html(activity_master[0].activity_title + '<span>For Grades ' + act_pbsh_grades.join(", ") + '</span>');
					
					$('#view_activity_subjects').html('Subjects <span>' + act_pbsh_subjects.join(", ") + '</span>');
					
				}
			});

	}	
	
	
	
	function get_student_detail(student_id)
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_student_detail';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['student_id'] = student_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					grades = result_data['grades'];
					selected_student = result_data['selected_student'];
					students_own_groups = result_data['students_own_groups'];
				  
				  	var last_name = selected_student[0].last_name ? selected_student[0].last_name : '';
				  	var stud_standard = selected_student[0].standard ? selected_student[0].standard : '';
				   
				    $('#h-sel-stud-name').html(selected_student[0].first_name + ' ' + last_name + '<span  > Class: ' + stud_standard + '</span>');
				   
				    var f_letter_1 = (selected_student[0].first_name).substring(0, 1);
				    var f_letter_2 = last_name.substring(0, 1);
				   
				    $('#span-sel-stud-name-abbr').html(f_letter_1  + f_letter_2 );
				   
				    $('#bio_reg_number').empty();
				    $('#bio_school_name').empty();
				    $('#bio_school_district').empty();
				    $('#bio_parent_name').empty();
				    $('#bio_syllabus').empty(); 
					
				    $('#stud_grade_id').val(selected_student[0].stud_grade_id);
				    $('#reg_number').val(selected_student[0].stud_reg_number);
				    $('#bio_reg_number').append(selected_student[0].stud_reg_number);
				    $('#bio_school_name').append(selected_student[0].school_name);
				    $('#bio_school_district').append(selected_student[0].school_district);
				    $('#bio_parent_name').append(selected_student[0].parent_name);
				    $('#bio_syllabus').append(selected_student[0].syllabus);
					
					profile_pic_path = "{{url('/public')}}" + '/' + selected_student[0].prof_pic_path + selected_student[0].prof_pic_file ;
					 
					
					$.ajax({ url: profile_pic_path, type:'HEAD',
								error: function()
								{
									$("#imagePreview").hide();
									//$("#span-sel-stud-name-abbr").show();
								},
								success: function()
								{
									$("#imagePreview").show();
									//$("#span-sel-stud-name-abbr").hide();
									$('#imagePreview').css('background-image','url("' + profile_pic_path +'")');
								}
							}); 								  
									
				   
					fill_student_edit_detail(selected_student);
				   
					cnt = students_own_groups.length;
					
					$('#div-groups').empty();
					$('.grp_row').css('display', 'block');
					
					for( i = 0; i< cnt; i++ ) 
					{
						
						grp_string = '<div class="btn-gray mb-15">' + students_own_groups[i].stud_group + 
											'<span class="span-remove-group" value="' + students_own_groups[i].stud_group_id + '" style="cursor:pointer; color:red!important;">' + 
												'<a ><i class="fa fa-times" aria-hidden="true"></i></a>' + 
											'</span>' +
										'</div>';
										
						$('#div-groups').append(grp_string);
						
						$('#grp_row_'+ students_own_groups[i].stud_group_id ).css('display', 'none');
						
					  
				   }
				    
				}
			});
			
	}
	
	
	function fill_student_edit_detail(selected_student)
	{	
	
		 $('#edit_gender_id').val(selected_student[0].gender_id);
		 $('#edit_first_name').val(selected_student[0].first_name);
		 $('#edit_last_name').val(selected_student[0].last_name);
		 $('#edit_stud_dob').val((selected_student[0].stud_dob).substring(0, 10));
		 
		 $('#edit_standard_id').val(selected_student[0].standard_id);
		 $('#edit_medium_id').val(selected_student[0].medium_id);
		 $('#edit_syllabus_id').val(selected_student[0].syllabus_id);
		 $('#edit_school_name').val(selected_student[0].school_name);
		 $('#edit_school_address').val(selected_student[0].school_address);
		 $('#edit_school_manage_category_id').val(selected_student[0].school_manage_category_id);
		 $('#edit_school_sub_district').val(selected_student[0].school_sub_district);
		 $('#edit_school_edu_district').val(selected_student[0].school_edu_district);
		 $('#edit_school_district_id').val(selected_student[0].school_district_id);
		
		 $('#edit_father_name').val(selected_student[0].father_name);
		 $('#edit_father_phone').val(selected_student[0].father_phone);
		 $('#edit_father_job').val(selected_student[0].father_job);
		 $('#edit_father_emp_ctg_id').val(selected_student[0].father_emp_ctg_id);
		 $('#edit_mother_name').val(selected_student[0].mother_name);
		 $('#edit_mother_phone').val(selected_student[0].mother_phone);
		 $('#edit_mother_job').val(selected_student[0].mother_job);
		 $('#edit_mother_emp_ctg_id').val(selected_student[0].mother_emp_ctg_id);
		 $('#edit_guardian_name').val(selected_student[0].guardian_name);
		 $('#edit_guardian_phone').val(selected_student[0].guardian_phone);
		 $('#edit_guardian_job').val(selected_student[0].guardian_job);
		 $('#edit_guardian_emp_ctg_id').val(selected_student[0].guardian_emp_ctg_id);
		 
		 $('#edit_house_address').val(selected_student[0].house_address);
		 $('#edit_house_panchayath').val(selected_student[0].house_panchayath);
		 $('#edit_house_block').val(selected_student[0].house_block);
		 $('#edit_house_district_id').val(selected_student[0].house_district_id);
		 $('#edit_house_pin').val(selected_student[0].house_pin);
		 
		 $('#edit_stud_blood_group_id').val(selected_student[0].stud_blood_group_id);
		 $('#edit_stud_height').val(selected_student[0].stud_height);
		 $('#edit_stud_weight').val(selected_student[0].stud_weight);
		 $('#edit_stud_physical_status_id').val(selected_student[0].stud_physical_status_id);
		 $('#edit_stud_disease').val(selected_student[0].stud_disease);
		 $('#edit_stud_disease_details').val(selected_student[0].stud_disease_details);
		 $('#edit_whatsapp_1').val(selected_student[0].whatsapp_1);
		 $('#edit_whatsapp_2').val(selected_student[0].whatsapp_2);
		 $('#edit_other_member_name').val(selected_student[0].other_member_name);
		 $('#edit_other_member_std').val(selected_student[0].other_member_std);
		 $('#edit_other_member_rel').val(selected_student[0].other_member_rel);
		 $('#edit_email_id').val(selected_student[0].email_id);
		 
	}
	
	
	function update_edit_student()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/update_edit_student';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['id'] = student_id;
		
		data['first_name'] = $('#edit_first_name').val();
		data['last_name'] = $('#edit_last_name').val();
		data['gender_id'] = $('#edit_gender_id').val();
		data['stud_dob'] = $('#edit_stud_dob').val();
		
		data['standard_id'] = $('#edit_standard_id').val();
		data['medium_id'] = $('#edit_medium_id').val();
		data['syllabus_id'] = $('#edit_syllabus_id').val();
		data['school_name'] = $('#edit_school_name').val();
		data['school_edu_district'] = $('#edit_school_edu_district').val();
		data['school_address'] = $('#edit_school_address').val();
		data['school_manage_category_id'] = $('#edit_school_manage_category_id').val();
		data['school_sub_district'] = $('#edit_school_sub_district').val();
		data['school_district_id'] = $('#edit_school_district_id').val();
		
		
		data['father_name'] = $('#edit_father_name').val();
		data['father_phone'] = $('#edit_father_phone').val();
		data['father_job'] = $('#edit_father_job').val();
		data['father_emp_ctg_id'] = $('#edit_father_emp_ctg_id').val();
		data['mother_name'] = $('#edit_mother_name').val();
		data['mother_phone'] = $('#edit_mother_phone').val();
		data['mother_job'] = $('#edit_mother_job').val();
		data['mother_emp_ctg_id'] = $('#edit_mother_emp_ctg_id').val();
		data['guardian_name'] = $('#edit_guardian_name').val();
		data['guardian_phone'] = $('#edit_guardian_phone').val();
		data['guardian_job'] = $('#edit_guardian_job').val();
		data['guardian_emp_ctg_id'] = $('#edit_guardian_emp_ctg_id').val();
		
		data['house_address'] = $('#edit_house_address').val();
		data['house_panchayath'] = $('#edit_house_panchayath').val();
		data['house_block'] = $('#edit_house_block').val();
		data['house_district_id'] = $('#edit_house_district_id').val();
		data['house_pin'] = $('#edit_house_pin').val();
		
		data['stud_blood_group_id'] = $('#edit_stud_blood_group_id').val();
		data['stud_height'] = $('#edit_stud_height').val();
		data['stud_weight'] = $('#edit_stud_weight').val();
		data['stud_physical_status_id'] = $('#edit_stud_physical_status_id').val();
		data['stud_disease'] = $('#edit_stud_disease').val();
		data['stud_disease_details'] = $('#edit_stud_disease_details').val();
		
		data['whatsapp_1'] = $('#edit_whatsapp_1').val();
		data['whatsapp_2'] = $('#edit_whatsapp_2').val();
		data['other_member_name'] = $('#edit_other_member_name').val();
		data['other_member_std'] = $('#edit_other_member_std').val();
		data['other_member_rel'] = $('#edit_other_member_rel').val();
		data['email_id'] = $('#edit_email_id').val();
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==1)
				   {
						alert('Updated.');
						location.reload();

				   }
				}
			});
			
	}
	
	
	$(document).on('click', '.a-criteria-marks', function()
	{
		room_id = $(this).data('room_id');
		activity_title = $(this).data('activity_title');
		$('#h-eval-marks').text('Your Score for Activity ' + activity_title);
		get_mentor_room_evaluations_by_room_by_student(room_id);
		
	});

	
	
	function get_mentor_room_evaluations_by_room_by_student(room_id)
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_mentor_room_evaluations_by_room_by_student';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['student_id'] = student_id;
		data['room_id'] = room_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
								
					mentor_room_evaluations = result_data['mentor_room_evaluations'];
					
					var mark = {};
					var criteria = {};
					
					for (var i = 0; i < mentor_room_evaluations.length; ++i) 
					{
						mark[mentor_room_evaluations[i].criteria_id] = mentor_room_evaluations[i].marks;
					}	
					
					$('.inp-mark').each(function(index, elem) 
					{
						criteria[index] = $(this).data("criteria_id");
						$('#mark-' + criteria[index]).val(mark[criteria[index]]);
					});		

					mentor_room_evaluation_statuses = result_data['mentor_room_evaluation_statuses'];					
					$('#ev_comment').val(mentor_room_evaluation_statuses[0].ev_comment);
					
					mentor_room_evaluation_statuses[0].evaluation_completed == 1 ? $("#evaluation_completed").prop("checked", true): $("#evaluation_completed").prop("checked", false);

					
				}
			});
			
	}
	

</script>


<body>
@include('student.layouts.ela-student-topbar')
<!--
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="images/elaschool.png" width="120"></a>
            <!-- Navbar
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="images/2.jpg" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="images/1.jpg" width="24" /></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/avatar.jpg" width="30"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
	-->
	<?php
		$first_name = strval(Auth::guard('ela_user')->user()->first_name);
		$last_name = Auth::guard('ela_user')->user()->last_name;
		$str = $first_name . ' ' . $last_name;
		$user_name = "";

		
			$array = array();
				$pattern = '/([;:,-.\/ X])/';
				$array = preg_split($pattern, $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

				foreach($array as $k => $v)
					$user_name .= ucwords(strtolower($v));



	?>
	<style>
	.glow {
  font-size: 18px;
  color: #fff;
  text-align: center;
  -webkit-animation: glow 1s ease-in-out infinite alternate;
  -moz-animation: glow 1s ease-in-out infinite alternate;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073, 0 0 70px #e60073;
  }
  
  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6, 0 0 80px #ff4da6;
  }
}
	</style>
    <main class="main students-login" style="background:#f0f0ff;">
        <div class="jumbotron">
            <div class="container" style="position:relative;">
                
                <div class="row pb-5">
                    <div class="col-9 d-flex">
                        <div class="profile mr-3">
                            <!--<img src="{{asset('public/ela-assets/images/avatar.jpg')}}" class="img-fluid">-->
                            <img src="{{asset(Session::get('profile_pic_path'))}}" class="img-fluid">
                        </div>
                        <div>
                            <h3 class="font-weight-bold main-fo">Hello {{$user_name  }}</h3>
                            <p class="sub-text">Grade: {{$student_grade}} </p>
                        </div>
						<h2  style="color: #fe6711;font-size:15px;white-space: nowrap;max-width: 540px;overflow: hidden;text-overflow: clip;" class="ml-auto mentor-quote">
						    <span style="display:block;font-weight:400;font-size:14px;padding-bottom:5px;color: #616161cc;">Mentor Quotes</span>
						    <marquee><span id="span-mot_text" class="">{{$motivation_text->mot_text}}</span></marquee></h2>
							 
                    </div>
                    <div class="col-3 text-right">
                        <button type="button" class="btn btn-outline-lighter text-dark" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-editstudent">Edit User
                            <img src="{{asset('public/ela-assets/images/filter.svg')}}" />
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 d-flex p-0">
                        <div class="col-4">
                            <img src="{{asset('public/ela-assets/images/follow.svg')}}" width="20">
                            <p class="sub-text m-0 pt-2">Mentors Following</p>
                            <p class="pt-1">03</p>
                        </div>
                        <div class="col-4">
                            <img src="{{asset('public/ela-assets/images/checkbox.svg')}}" width="20">
                            <p class="sub-text m-0 pt-2">Activities Done</p>
                            <p class="pt-1">{{$count_students_approved_activities_completed}} / {{$count_students_approved_activities}}</p>
                        </div>
                        <div class="col-4">
                            <img src="{{asset('public/ela-assets/images/time-line.svg')}}" width="20">
                            <p class="sub-text m-0 pt-2">Activities Under Review</p>
                            <p class="pt-1">10</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row d-flex ml-auto">
                            <div class="col-6">
                                <p class="sub-text mb-10">This Week</p>
                                <div class="card ml-auto green-bg">
                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-sm-8  pt-2  p-0">
                                                <p class="card-title im-oppa  text-light m-0" style="font-size:14px">
                                                    Time Spent</p>
                                                <p class="card-text m-0 text-dark font-weight-bold" style="font-size:14px">1h 23m</p>
                                            </div>
                                            <div class="col-sm-4 p-0  text-right">
                                                <img class="thisweek" src="{{asset('public/ela-assets/images/timer-line1.svg')}}" alt="sans" width="60px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="sub-text mb-10">Score</p>
                                <div class="card ml-auto vilot-bg">
                                    <div class="card-body py-0">
                                        <div class="row d-flex">
                                            <div class="col-8 pt-2 p-0">
                                                <p class="card-title text-light im-oppa m-0" style="font-size:14px">
                                                    Total</p>
		
													
                                                <p class="card-text text-light font-weight-bold m-0" style="font-size:14px;">{{$aggr_sum_marks}} / {{$aggr_sum_base_mark}}</p>
                                            </div>
                                            <div class="col-4 p-0 text-right">
                                                <img class="score" src="{{asset('public/ela-assets/images/medal-line1.svg')}}" alt="sans" width="60px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="cloud-wrap">
                <div class="cloud"></div>
                <div class="cloud"></div>
                <div class="cloud"></div>
                <div class="cloud"></div>
                <div class="cloud"></div>
            </div>
            <div class="row three-boxes">
                <div class="col-3">
                    <div class="card bg-white text-center p-4 min-hei">
                        <a class="ml-auto" href="#"><img src="{{asset('public/ela-assets/images/8.jpg')}}" width="20" /></a>
                        <div class="text-center centered pt-1">
                            <img class="" src="{{asset('public/ela-assets/images/9.jpg')}}" width="60" />
                            <h5 class="pt-2 font-weight-bold">05</h5>
                            <p>
                                Activities pending<br />this week
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-white text-center p-4 min-hei">
                        <a class="ml-auto" href="#"><img src="{{asset('public/ela-assets/images/8.jpg')}}" width="20" /></a>
                        <div class="text-center centered">
                            <img class="" src="{{asset('public/ela-assets/images/graph.png')}}" width="100%" />
                            <div style="margin-top:-60px">
                                <img class="" src="{{asset('public/ela-assets/images/10.jpg')}}" width="30" />
                                <h5 class="pt-2 font-weight-bold">450 / 500</h5>
                                <p>
                                    Your aggregate score<br />this week
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card course-prgrs bg-white p-4 min-hei">
                        <a class="ml-auto" href="#"><img src="{{asset('public/ela-assets/images/8.jpg')}}" width="20" /></a>
                        <div class="row">
                            <div class="col-4">
                                <img src="{{asset('public/ela-assets/images/graph2.png')}}" width="100%" />
                                <h5 class="position-absolute font-weight-bold" style="left:50%;top:50%;width: 60px; height: 20px; margin-left: -30px; margin-top: -10px; text-align: center;">
                                    432
                                </h5>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <h4>Course Progress</h4>
                                    <ul class="pl-0 col-12">
                                        <li class="d-flex">
                                            <p>IT</p>
                                            <p class="sub-text2 pl-2">IT Basics, OOPS</p>
                                            <p class=" text-right ml-auto">74%</p>
                                        </li>
                                        <li class="d-flex">
                                            <p>Science</p>
                                            <p class="sub-text2 pl-2">Physics, Chemistry, Biology</p>
                                            <p class=" text-right ml-auto">7%</p>
                                        </li>
                                        <li class="d-flex">
                                            <p>Art</p>
                                            <p class="sub-text2">Music, Reading, Craft</p>
                                            <p class=" text-right ml-auto">24%</p>
                                        </li>
                                        <li class="d-flex">
                                            <p>Language</p>
                                            <p class="sub-text2">English, Malayalam</p>
                                            <p class=" text-right ml-auto">100%</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row pt-30 pb-40">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Completed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Pending</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:20rem">Activity</th>
                                            <th class="head-font" style="width:15rem">Due Date</th>
                                            <th class="head-font" style="width:8rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($students_approved_activities as $key=>$students_approved_activity) 
                                        <tr>
                                            <td>{{$key+1 }}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$students_approved_activity->activity_title }}</p>
                                                <p class="sub-text2">By {{$students_approved_activity->first_name . ' ' . $students_approved_activity->last_name}}</p>
                                            </td>
                                            <td class="orage">{{date('d-m-Y', strtotime( $students_approved_activity->room_expiry_date))}}</td>
                                            <td class="text-success">
												<!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td>
                                            <td></td>
											
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$students_approved_activity->activity_id}}" data-room_id="{{$students_approved_activity->room_id}}" data-activity_title="{{$students_approved_activity->activity_title}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>

											
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							    <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:20rem">Activity</th>
                                            <th class="head-font" style="width:15rem">Due Date</th>
                                            <th class="head-font" style="width:8rem"></th>
                                            <th class="head-font" style="width:8rem">Score</th>
                                            <th class="head-font">Mentor's Comment</th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($students_approved_activities_completed as $key=>$students_approved_activity_completed) 
										<?php
										
												$cc = app()->make('App\Http\Controllers\CommonController');
												$evaluation_marks_sum = app()->call([$cc, 'get_mentor_room_evaluation_marks_sum'], [$students_approved_activity_completed->room_id, $student_id]);
												
												$sum_marks = (count($evaluation_marks_sum )!=0)? $evaluation_marks_sum[0]->sum_marks: '-';
												$sum_base_mark = (count($evaluation_marks_sum )!=0)? $evaluation_marks_sum[0]->sum_base_mark: '-';
												
												$mentor_room_evaluation_status = app()->call([$cc, 'get_mentor_room_evaluation_status'], [$students_approved_activity_completed->room_id, $student_id]);
												if($key == 0)
												{
													$room_id = $students_approved_activity_completed->room_id;
													
													$ev_criterias =  app()->call([$cc, 'get_ev_criterias_by_room_id'], [$room_id]);
												}
										?>
                                        <tr>
                                            <td>{{$key+1 }}</td> 
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$students_approved_activity_completed->activity_title }}</p>
                                                <p class="sub-text2">By {{$students_approved_activity_completed->first_name . ' ' . $students_approved_activity_completed->last_name}}</p>
                                            </td>
                                            <td class="orage">{{date('d-m-Y', strtotime($students_approved_activity_completed->room_expiry_date))}}</td>
                                            <td class="text-success">
												<!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td> 
												
                                            <td style="font-weight:bold; color: blue!important;">
												<a class="a-criteria-marks" href="#" data-room_id ="{{$students_approved_activity_completed->room_id }}" data-activity_title="{{$students_approved_activity->activity_title}}"  data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#evaluation"><u>{{$sum_marks . '/' . $sum_base_mark}}
												</u></a>
											</td>
                                            <td>{{$mentor_room_evaluation_status[0]->ev_comment or ''}}</td>
											
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$students_approved_activity_completed->activity_id}}" data-room_id="{{$students_approved_activity_completed->room_id}}"  type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>

											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
							    </div>
							
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							    <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:20rem">Activity</th>
                                            <th class="head-font" style="width:15rem">Due Date</th>
                                            <th class="head-font" style="width:8rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($students_approved_activities_not_completed as $key=>$students_approved_activity_not_completed) 
                                        <tr>
                                            <td>{{$key+1 }}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$students_approved_activity_not_completed->activity_title }}</p>
                                                <p class="sub-text2">By {{$students_approved_activity_not_completed->act_created_by_first_name . ' ' . $students_approved_activity_not_completed->act_created_by_last_name}}</p>
                                            </td>
                                            <td class="orage">{{date('d-m-Y', strtotime( $students_approved_activity_not_completed->room_expiry_date)) }}</td>
                                            <td class="text-success">
												<!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
											</td>
                                            <td></td>
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$students_approved_activity_not_completed->activity_id}}" data-room_id="{{$students_approved_activity_not_completed->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>

                                            <td>
												<a href="{{url('student/activity/students-activity', ['room_id' => $students_approved_activity_not_completed->room_id])}}">
												<button value="{{$students_approved_activity_not_completed->room_id}}" data-room_id="{{$students_approved_activity_not_completed->room_id}}" type="button" class="btn btn-warning btn-view-activity">Learn >></button>
												</a>
											</td>
											
											
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
							    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!----------body content place end here----------->
        <img src="{{asset('public/ela-assets/images/students-bg.png')}}" class="img-fluid" />
    </main>
	
	@include('student.layouts.student-edit-modal')
<!--------------VIEW ACTIVITY MODAL BEGINS-------------------------------------------------------------------------------->	
	@include('layouts.activity-modal')

<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	
	@include('layouts.messenger-modal')
	
                    <!-- Evaluation Modal -->
                    <div class="modal fade" id="evaluation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: darkturquoise;">
                                    <h5 class="modal-title" id="h-eval-marks" >Evaluation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="background: #fff;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" style="color: #3574b3; font-weight: 700;">
                                            <tbody>
												@foreach($ev_criterias as $key=>$ev_criteria) 
                                                <tr>
                                                    <td width="250px" id="criteria-{{$ev_criteria->id}}">{{$ev_criteria->criteria}} </td>
                                                    <td><input readonly id="mark-{{$ev_criteria->id}}" data-criteria_id ="{{$ev_criteria->id}}"  data-base_mark ="{{$ev_criteria->base_mark}}" min="0" max="{{$ev_criteria->base_mark}}" type="number"  class="form-control inp-mark req_fields" aria-describedby="mark" placeholder="- -" style="color: #d839a0; font-weight: 700;"></td>
                                                    <td width="100px">on {{round($ev_criteria->base_mark)}}</td>
                                                </tr>
												@endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-header" style="background-color: darkturquoise;">
									<div class="row">
										<div class="col-md-12" >
												<h6 class="mb-1">Mentor's Comment</h6>
                                                <textarea class="form-control" id="ev_comment" rows="6" placeholder="Add Comment" readonly></textarea>
                                                <small id="headline" class="form-text text-muted"></small>
										</div>
										<!--
										<div class="col-md-12" style="text-align:right;">
											<input type="checkbox" class="form-check-input" id="evaluation_completed" style="float:left">Completed</label>
											<button id="btn-save-evaluation" type="button" class="btn btn-primary m-auto">Save</button>
										</div>
										-->
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
	
    <footer class="container-fluid bg-dard-blue">
        <div class="container pt-5 pb-5 text-light">
            <div class="row">
                <div class="col-md-12">
                    <p>© Effective Teachers 2020. All rights reserved.</p>
                    <img class="ml-auto logo" src="{{asset('public/ela-assets/images/logo-light.png')}}" width="40" height="25">
                </div>

            </div>
        </div>
    </footer>

	@include('layouts.ela-footer')

</body>

</html>