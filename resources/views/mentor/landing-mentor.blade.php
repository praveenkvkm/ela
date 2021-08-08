@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$ac = app()->make('App\Http\Controllers\AdminController');

$mentor_types =  app()->call([$cc, 'get_mentor_types']);
$mentor_categories =  app()->call([$cc, 'get_mentor_categories']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);
$motivation_text =  app()->call([$ac, 'get_motivation_text']);


$mentors_own_groups =  app()->call([$cc, 'get_mentors_own_groups']);
$count_mentors_own_groups = count($mentors_own_groups);
$mentors_own_students =  app()->call([$cc, 'get_mentors_own_students']);
$count_mentors_own_students = count($mentors_own_students);
$sent_for_approval_activities =  app()->call([$cc, 'get_sent_for_approval_activities_by_mentor_id']);
$pending_approval_activities =  app()->call([$cc, 'get_pending_approval_activities_of_mentor']);
$approved_activities =  app()->call([$cc, 'get_approved_activities_of_mentor']);
$count_sent_for_approval_activities = count($sent_for_approval_activities);

$mentors_entire_students =  app()->call([$cc, 'get_mentors_entire_students']);
$count_mentors_entire_students = count($mentors_entire_students);
//$mentors_own_groups = app()->call([$cc, 'get_mentors_own_groups'], [Auth::guard('ela_user')->user()->id]);
$profile_pic_path = url('/public') . '/' . Auth::guard('ela_user')->user()->prof_pic_path . Auth::guard('ela_user')->user()->prof_pic_file ;
?>
<script>
$(document).ready(function() { 
	
	activity_id =0;
	room_id = 0;
	publish_id = 0;
	active =0;
	 
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		mentor_id = '{{ Auth::guard('ela_user')->user()->id }}'; /* GET FIRST MENTOR ID  */
		
				
		get_mentor_full_detail_by_id(mentor_id); /* GET FIRST MENTOR DETAIL  */
		
	
});

		$(document).on('click', '#a-update-edit-mentor', function()
		{
			
			
			if(!$('#first_name').val())
			{
				alert('Please enter First Name.');
			}
			else if(!$('#mobile').val())
			{
				alert('Please enter Mobile Number.');
			}
			else
			{
				
				if(confirm("Are you sure to Update ?"))
				{
					update_approved_mentor();
				}
				
				
			}
			
			
			
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


	$(document).on('click', '#a-add-new-student', function()
	{
		set_session_add_new_student_from_page();
		
	});
	
	
	function set_session_add_new_student_from_page()
	{

		var	url_var = APP_URL + '/set_session_add_new_student_from_page';
		
		var data = {};
		data['add_new_student_from_page'] = '/admin/dashboard';
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					//alert(result_data);
							
				}
			});

	}	
	


	$(document).on('click', '.td-approve-options', function()
	{
		publish_id = $(this).attr('value');
		
	});
	
	
	$(document).on('click', '#btn-update-rejection', function()
	{
		if($('#reason_for_rejection').val())
		{
			if(confirm('Confirm Approval ?'))
			{
				approve_activity_rejection();
			}
		}
		else
		{
			alert('Please Enter Reason.');
		}
	});
	
	
	function approve_activity_rejection()
	{

		var	url_var = APP_URL + '/approve_activity_rejection';
		
		var data = {};
		data['publish_id'] = publish_id;
		data['reason_for_rejection'] = $('#reason_for_rejection').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert(result_data);
							
				}
			});

	}	
	

	$(document).on('click', '#btn-update-approval', function()
	{
		publish_date = $('#inp-publish-date').val();
		if(confirm('Confirm Approval ?'))
		{
			approve_activity_publish();
		}
		
	});
	
	
	function approve_activity_publish()
	{

		var	url_var = APP_URL + '/approve_activity_publish';
		
		var data = {};
		data['publish_id'] = publish_id;
		data['publish_date'] = publish_date;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert('Approved.');
					location.reload();
							
				}
			});

	}	
	


	
	$(document).on('click', '.btn-view-activity', function()
	{
		activity_id = $(this).attr('value');
		room_id = $(this).data('room_id');
		return_activity_detail_by_id();
		
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
	
	function get_mentor_full_detail_by_id(mentor_id)
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_mentor_full_detail_by_id';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['mentor_id'] = mentor_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   
					selected_mentor = result_data['selected_mentor'];
				  	var last_name = selected_mentor[0].last_name ? selected_mentor[0].last_name : '';
					
					
				    $('#h-sel-mentor-name').html(selected_mentor[0].first_name + ' ' + last_name +'<span></span>');
				   
				   var f_letter_1 = (selected_mentor[0].first_name).substring(0, 1);
				   var f_letter_2 = last_name.substring(0, 1);
				   
				    $('#span-sel-mentor-name-abbr').html(f_letter_1  + f_letter_2 );
					
					
					profile_pic_path = "{{url('/public')}}" + '/' + selected_mentor[0].prof_pic_path + selected_mentor[0].prof_pic_file ;
					 
					
					$.ajax({ url: profile_pic_path, type:'HEAD',
								error: function()
								{
									$("#imagePreview").hide();
									$("#span-sel-mentor-name-abbr").show();
								},
								success: function()
								{
									$("#imagePreview").show();
									$("#span-sel-mentor-name-abbr").hide();
									$('#imagePreview').css('background-image','url("' + profile_pic_path +'")');
								}
							}); 								  
					
				   
					fill_mentor_edit_detail(selected_mentor);
					
					
					mentors_own_grades = result_data['mentors_own_grades'];
					
					cnt = mentors_own_grades.length;
					
					$('#div-grades').empty();
					$('.grd_row').css('display', 'block');
					
					//alert(cnt);
					for( i = 0; i< cnt; i++ ) 
					{
						
						grd_string = '<div class="btn-gray mb-15">' + mentors_own_grades[i].stud_grade + 
											'<span class="span-remove-grade" value="' + mentors_own_grades[i].stud_grade_id + '" style="cursor:pointer; color:red!important;">' + 
												'<a ><i class="fa fa-times" aria-hidden="true"></i></a>' + 
											'</span>' +
										'</div>';
										
										
						$('#div-grades').append(grd_string);
						
						$('#grd_row_'+ mentors_own_grades[i].stud_grade_id ).css('display', 'none');
					  
				    }
				   
				   
				   
				}
			});
			
	}
	
	
	function fill_mentor_edit_detail(selected_mentor)
	{			
	
		 $('#first_name').val(selected_mentor[0].first_name);
		 $('#last_name').val(selected_mentor[0].last_name);
		 $('#mobile').val(selected_mentor[0].mobile);
		 $('#email').val(selected_mentor[0].email);
		 $('#res_address').val(selected_mentor[0].res_address);
		 $('#off_address').val(selected_mentor[0].off_address);
		 $('#designation').val(selected_mentor[0].designation);
		 $('#mentor_type_id').val(selected_mentor[0].mentor_type_id);
		 $('#mentor_category_id').val(selected_mentor[0].mentor_category_id);
		 $('#designation').val(selected_mentor[0].designation);
		 
		 $('#reset_user_name').val(selected_mentor[0].mobile);
		 
		 var last_name = selected_mentor[0].last_name ? selected_mentor[0].last_name : '';
		 $('#reset_mentor_name').val(selected_mentor[0].first_name + ' ' + last_name);
		 
		active = selected_mentor[0].active;
		
		 
		

	}
	
	function update_approved_mentor()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/update_approved_mentor';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['id'] = mentor_id;
				
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['res_address'] = $('#res_address').val();
		data['off_address'] = $('#off_address').val();
		data['designation'] = $('#designation').val();
		data['mentor_type_id'] = $('#mentor_type_id').val();
		data['mentor_category_id'] = $('#mentor_category_id').val();
		data['approved'] = 1;
		data['active'] = active;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data =='dup')
				   {
						alert('Email id or Mobile number Already Exists.');
				   }
				   else
				   {
						alert('Updated.');
					   if(result_data ==0)
					   {
							document.location.href = APP_URL + '/mentor/dashboard';
					   }
					   else
					   {
							location.reload();
					   }
				   }
				   
				   
				}
			});
			
	}

</script>

<body>
@include('mentor.layouts.ela-mentor-topbar')
<!--
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
             Navbar
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/tutor.png')}}"
                            width="30"></a>
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
    <main class="main students-login">
        <div class="jumbotron">
            <div class="container">
                <div class="row pb-3">
                    <div class="col-9 d-flex">
                        <div class="profile mr-3">
                            <img src="{{asset(Session::get('profile_pic_path'))}}" class="img-fluid">
                        </div>
                        <div>
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
                            <h3 class="font-weight-bold main-fo">Hello {{$user_name  }}</h3>
                            <!--<p class="sub-text">Expert in Science Subjects</p>-->
                        </div>
						
						<h2  style="color: #fe6711;font-size:15px;white-space: nowrap;max-width: 540px;overflow: hidden;text-overflow: clip;" class="ml-auto mentor-quote">
						    <span style="display:block;font-weight:400;font-size:14px;padding-bottom:5px;color: #616161cc;">Motivation Text</span>
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
                            <p class="sub-text m-0 pt-2">Groups</p>
                            <p class="pt-1">{{$count_mentors_own_groups}}</p>
                        </div>
                        <div class="col-4">
                            <img src="{{asset('public/ela-assets/images/checkbox.svg')}}" width="20">
                            <p class="sub-text m-0 pt-2">Individuals</p>
                            <p class="pt-1">{{$count_mentors_own_students}}</p>
                        </div>
                        <div class="col-4">
                            <img src="{{asset('public/ela-assets/images/time-line.svg')}}" width="20">
                            <p class="sub-text m-0 pt-2">Pending to Review</p>
                            <p class="pt-1">10</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row d-flex ml-auto">
                            <div class="col-6">
                               <!-- <p class="sub-text mb-10">This Week</p>-->
                                <div class="card ml-auto green-bg">
                                    <div class="card-body py-0">
										<a href="{{url('mentor/mentor-my-students')}}" class="primary-link text-right {{ $count_mentors_entire_students == 0 ? 'disabled' : ''}}">
                                        <div class="row">
                                            <div class="col-sm-8  pt-2  p-0">
                                                <p class="card-title im-oppa  text-light m-0" style="font-size:14px">
                                                    Total Students</p>
                                                <p class="card-text m-0 text-dark font-weight-bold"
                                                    style="font-size:14px">{{$count_mentors_entire_students}}</p>
                                            </div>
                                            <div class="col-sm-4 p-0  text-right">
                                                <img class="thisweek" src="{{asset('public/ela-assets/images/timer-line1.svg')}}" alt="sans"
                                                    width="60px">
                                            </div>
                                        </div>
										</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                 <!-- <p class="sub-text mb-10">Score</p>-->
                                <div class="card ml-auto vilot-bg">
                                    <div class="card-body py-0">
										<a href="{{url('mentor/mentor-my-activities')}}">
                                        <div class="row d-flex">
                                            <div class="col-8 pt-2 p-0">
                                                <p class="card-title text-light im-oppa m-0" style="font-size:14px">
                                                    Total Activities</p>
                                                <p class="card-text text-light font-weight-bold m-0"
                                                    style="font-size:14px;">{{$count_sent_for_approval_activities}}</p>
                                            </div>
                                            <div class="col-4 p-0 text-right">
                                                <img class="score" src="{{asset('public/ela-assets/images/medal-line1.svg')}}" alt="sans" width="60px">
                                            </div>
                                        </div>
										</a>
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
            <div class="row three-boxes">
                <div class="col-3">
                    <div class="card bg-white text-center p-4 min-hei">
                        <a class="ml-auto" href="#"><img src="{{asset('public/ela-assets/images/8.jpg')}}" width="20" /></a>
                        <div class="text-center centered pt-1">
                            <img class="" src="{{asset('public/ela-assets/images/9.jpg')}}" width="60" />
                            <h5 class="pt-2 font-weight-bold">05</h5>
                            <p>
                                Activity Statistics<br />
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
                                    My Students' <br />Performances
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
                                <h5 class="position-absolute font-weight-bold"
                                    style="left:50%;top:50%;width: 60px; height: 20px; margin-left: -30px; margin-top: -10px; text-align: center;">
                                    432
                                </h5>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <h4>Subject wise Performances</h4>
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
            <div class="row pt-30 pb-90">
			
			
			
                <div class="col-md-12">
                    <div class="card cards-list-wrap">
                        <div class="card-header bg-white">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="all-activities-tab" data-toggle="tab" href="#all-activities" role="tab"
                                        aria-controls="all-activities" aria-selected="true">All Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sent-for-approval-tab" data-toggle="tab" href="#sent-for-approval" role="tab"
                                        aria-controls="sent-for-approval" aria-selected="false">On Admin Approval</a> <!-- SENT FOR APPROVAL TO ADMIN -->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab"
                                        aria-controls="approved" aria-selected="false">Published</a> <!-- APPROVED BY ADMIN-->
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all-activities" role="tabpanel" aria-labelledby="all-activities-tab">
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:16rem">Activity</th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($sent_for_approval_activities as $key=>$sent_for_approval_activity) 
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$sent_for_approval_activity->activity_title }}</p>
                                            </td>
											<?php
												$rm_id = $sent_for_approval_activity->room_id ;
												$rooms_own_groups = app()->call([$cc, 'get_rooms_own_groups'], [$rm_id]);
												$grps = $rooms_own_groups->pluck('stud_group')->toArray();

											?>
                                            <!--<td class="orage">{{implode(', ', $grps) }}</td>-->
											<td class="orage"></td>
                                            <td class="individuals">
												<!--
                                                <span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
                                                + 7 More
												-->
                                            </td>
                                            <td class="text-success">
                                                <!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td> 
                                            <td></td>
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$sent_for_approval_activity->activity_id}}" data-room_id="{{$sent_for_approval_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
											
										<!--	
                                            <td class="dropdown dropdots td-approve-options" value="{{$sent_for_approval_activity->room_id }}" >
                                                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{url('mentor/activity/activity-evaluation', ['room_id' => $sent_for_approval_activity->room_id])}}">Evaluate</a></li>
                                                </ul>
                                            </td>
										-->	
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
								<!--
								<a href="{{url('mentor/activity/create-activity')}}">
                                <button type="button" class="btn btn-third float-right mt-30">
                                    <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                                    New Activity
                                </button>
								</a>
								-->
								</div>
                            </div>
                            <div class="tab-pane fade" id="sent-for-approval" role="tabpanel" aria-labelledby="sent-for-approval-tab">
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:16rem">Activity</th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($pending_approval_activities as $key=>$pending_approval_activity) 
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$pending_approval_activity->activity_title }}</p>
                                            </td>
											<?php
												$rm_id = $pending_approval_activity->room_id ;
												$rooms_own_groups = app()->call([$cc, 'get_rooms_own_groups'], [$rm_id]);
												$grps = $rooms_own_groups->pluck('stud_group')->toArray();

											?>
                                            <!--<td class="orage">{{implode(', ', $grps) }}</td>-->
                                            <td class="orage"></td>
                                            <td class="individuals">
											<!--
                                                <span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
                                                + 7 More
												-->
                                            </td>
                                            <td class="text-success">
                                                <!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td>
                                            <td></td>
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$pending_approval_activity->activity_id}}" data-room_id="{{$pending_approval_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:16rem">Activity</th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($approved_activities as $key=>$approved_activity) 
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$approved_activity->activity_title }}</p>
                                            </td>
											<?php
												$rm_id = $approved_activity->room_id ;
												$rooms_own_groups = app()->call([$cc, 'get_rooms_own_groups'], [$rm_id]);
												$grps = $rooms_own_groups->pluck('stud_group')->toArray();

											?>
                                            <!--<td class="orage">{{implode(', ', $grps) }}</td>-->
                                            <td class="orage"></td>
                                            <td class="individuals">
											<!--
                                                <span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
                                                + 7 More
												-->
                                            </td>
                                            <td class="text-success">
                                                <!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td>
                                            <td></td> 
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$approved_activity->activity_id}}" data-room_id="{{$approved_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
											
                                            <td>
												<a href="{{url('mentor/activity/activity-evaluation', ['room_id' => $approved_activity->room_id])}}">
												<button value="{{$approved_activity->activity_id}}" data-room_id="{{$approved_activity->room_id}}" type="button" class="btn btn-secondary btn-view-activity">Evaluate</button>
												</a>
											</td>
											
										<!--	
                                            <td class="dropdown dropdots td-approve-options" value="{{$approved_activity->room_id }}" >
                                                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{url('mentor/activity/activity-evaluation', ['room_id' => $approved_activity->room_id])}}">Evaluate</a></li>
                                                </ul>
                                            </td>
										-->	
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <a href="{{url('mentor/activity/create-activity')}}" class="float-right" style="display:inline-block;">
                                 <button type="button" class="btn btn-third float-right mt-30">
    							<img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
    							New Activity
    							</button>
    						</a>
                        </div>
						

                    </div>
                </div>
				
				
				
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
	
	@include('mentor.layouts.mentor-edit-modal')
<!--------------VIEW ACTIVITY MODAL BEGINS-------------------------------------------------------------------------------->	
	@include('layouts.activity-modal')
<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	
	
	@include('layouts.messenger-modal')
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