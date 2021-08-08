@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$students =  app()->call([$cc, 'get_non_approved_students']);

$stud_groups =  app()->call([$cc, 'get_stud_groups']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);
$genders =  app()->call([$cc, 'get_genders']);
$school_manage_categories =  app()->call([$cc, 'get_school_manage_categories']);
$parent_relationships =  app()->call([$cc, 'get_parent_relationships']);
$guardian_employers =  app()->call([$cc, 'get_guardian_employers']);
$districts =  app()->call([$cc, 'get_districts']);
$blood_groups =  app()->call([$cc, 'get_blood_groups']);
$physical_statuses =  app()->call([$cc, 'get_physical_statuses']);
?>
<body>
<script>
		
$(document).ready(function(){
	
	$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		selected_groups = [];
	
	
		
		student_id = '{{ $students[0]->ela_user_id }}'; /* GET FIRST STUDENT ID  */
				
		get_student_detail(student_id); /* GET FIRST STUDENT DETAIL  */
		
		
		$(document).on('click', '#a-allocate-group-to-student', function()
		{
			 
				$(".check-group:checked").each(function () 
				{
					group_id = $(this).attr("value");
					var	url_var = APP_URL + '/allocate_group_to_student';
					
					var data = {};
					data['group_checked'] = 1;
					data['group_id'] = group_id;
					data['student_id'] = student_id;
							
					$.ajax({
					   type:'post',
					   url: url_var,  
					   data: data,
					   async:false,
					   success:function(result_data)
						   {
							  
							}
						});
							
					
				}); 
				
			get_student_detail(student_id);	
				
		});	
		
		
		$(document).on('click', '.span-remove-group', function()
		{
			group_id = $(this).attr("value");

			var	url_var = APP_URL + '/allocate_group_to_student';
			
			var data = {};
			data['group_checked'] = 0;
			data['group_id'] = group_id;
			data['student_id'] = student_id;
					
			$.ajax({
			   type:'post',
			   url: url_var,  
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
					  
					}
				});
						
			get_student_detail(student_id);				
			
		});
		
		
		$(document).on('click', '#a-add-new-student', function()
		{
			set_session_add_new_student_from_page();
			
		});
	
	
		$(document).on('click', '.tr-student', function(event)
		{
			event.preventDefault;
			
			student_id = $(this).attr('value');
			get_student_detail(student_id);
			
			
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
		
		

		$(document).on('click', '#btn-approve', function()
		{
			//event.preventDefault;
			
			if(!$('#reg_number').val())
			{
				alert('Please enter Register Number.');
			}
			else
			{
				
				if(confirm("Are you sure to Update ?"))
				{
					update_approve_student();
				}
				
				
			}
			
			
		});
		
		


});


	function update_approve_student()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/update_approve_student';
		
		approved = $('#approved').is(':checked') ? 1 : 0;
			
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['id'] = student_id;
		
		data['reg_number'] = $('#reg_number').val();
		data['stud_grade_id'] = $('#stud_grade_id').val();
		data['approved'] = approved;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
						
				   if(result_data =='dup')
				   {
						alert('Register Number Already Exists.');
				   }
				   else
				   {
						alert('Updated.');
					   if(result_data ==0)
					   {
							document.location.href = APP_URL + '/admin/dashboard';
					   }
					   else
					   {
							location.reload();
					   }
				   }
				   
				}
			});
			
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
	
	
	function set_session_add_new_student_from_page()
	{

		var	url_var = APP_URL + '/set_session_add_new_student_from_page';
		var data = {};
		data['add_new_student_from_page'] = '/admin/student/admin-students-pool';
		
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
	
	
	function update_approved_mentor()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/update_approved_mentor';
		active = $('#active').is(':checked') ? 1 : 0;
		
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
@include('admin.layouts.ela-admin-topbar')
<!--
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="{{url('/admin/dashboard')}}"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
            <!-- Navbar
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/avatar.jpg')}}" width="30"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('/elauserlogout')}}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
-->	
    <main class="main students-login">
        <div class="jumbotron">
            <div class="container">
                <div class="row pb-0">
                    <div class="col-9 d-flex">
                        <div class="profile mr-3">
                            <img src="{{asset('public/ela-assets/images/avatar.jpg')}}" class="img-fluid">
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Students Pool</h3>
                            <p class="sub-text">Admin for ELA School</p>
                        </div>
                    </div>
                    <div class="col-3 text-right">
						<a id="a-add-new-student" href="{{url('admin/student/stud-registration')}}"> 
                        <button type="button" class="btn btn-third" >
                            <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                            New Student
                        </button>
						</a>
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="row admin-lists">
                <div class="col-md-12">
                    <div class="row">
					<!--
                        <div class="col-3">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Grade VIII</option>
                                    <option>Grade VIII</option>
                                    <option>Grade VIII</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Sort</option>
                                    <option>Sort</option>
                                    <option>Sort</option>
                                </select>
                            </div>
                        </div>
						-->
                    </div>
                </div>
            </div>
            <div class="row pb-90">
                <div class="col-md-12">
                    <div class="card p-30">
                        <div class="row">
                            <div class="col-md-4 lists-search">
                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                <div class="list-height-fix mt-30">
                                    <table class="table">
                                        <tbody id="myTable">
											@foreach($students as $key=>$student) 
                                            <tr class="tr-student" value="{{$student->ela_user_id}}" style="cursor:pointer">
											<!--
                                                <td>
													<div class="submitted-by" >
														<span  style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}} " ></span>
														{{$student->first_name . ' ' . $student->last_name }}
													</div>
                                                </td>
											-->	
                                                <td>
                                                    <a >
                                                        <div class="submitted-by">
                                                            <span class="grade">{{strtoupper(substr($student->first_name, 0, 1)) . strtoupper(substr($student->last_name, 0, 1)) }}</span>
                                                           {{$student->first_name . ' ' . $student->last_name }}
                                                        </div>
                                                    </a>
                                                </td>
												
                                            </tr>
											@endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                            <div class="col-md-8 profile-wrap"> 
								<!--
                                <div class="profile">
                                    <span style="background: url({{asset('public/ela-assets/images/s4.png)no-repeat;')}}"></span>
                                    <h3 id="h-sel-stud-name"><span  ></span></h3>
                                </div>
								-->
								<div class="profile submitted-by ">
									<span id="span-sel-stud-name-abbr" class="grade ">{{strtoupper(substr($student->first_name, 0, 1)) . strtoupper(substr($student->last_name, 0, 1)) }}</span>
									<h3 id="h-sel-stud-name" ><span style="text-align:left;!important" ></span></h3>
                                    <div class="edit-btn btn-group dropleft" data-toggle="tooltip" title="Edit Student">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid"/></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editstudent">Edit & Approve</a>
                                            <!--<a class="dropdown-item" href="#" data-toggle="modal" data-target="#resetpassword">Password Reset</a>-->
                                        </div>
                                    </div>
								</div>

                                <div class="row">
                                    <!--<div class="col-md-6">-->
                                    <!--    <h6>Academic Report</h6>-->
                                    <!--    <ul class="reports">-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="violet"></span>IT <span class="gray"> Basics, OOPS</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="blue"></span>Science <span class="gray"> Physics, Chemistry, Biology</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="green"></span>Art <span class="gray"> Music, Reading, Craft</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="dark-green"></span>Language <span class="gray"> English, Malayalam</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--    </ul>-->
                                    <!--    <hr>-->
                                    <!--    <h6>Attendance</h6>-->
                                    <!--    <ul class="reports">-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="violet"></span>IT <span class="gray"> Basics, OOPS</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="blue"></span>Science <span class="gray"> Physics, Chemistry, Biology</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="green"></span>Art <span class="gray"> Music, Reading, Craft</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--        <li class="d-flex">-->
                                    <!--            <span class="dark-green"></span>Language <span class="gray"> English, Malayalam</span>-->
                                    <!--            <p class=" text-right ml-auto">74%</p>-->
                                    <!--        </li>-->
                                    <!--    </ul>-->
                                    <!--</div>-->
									<!-- 
                                    <div class="col-md-6">
                                        <h6 style="position:relative;">Mentors
                                            <div class="edit-btn" data-toggle="tooltip" title="Add Mentor" >
                                                <a href="#" data-toggle="modal" data-target="#addmentor"><img src="" class="img-fluid"/></a>
                                            </div>
                                        </h6>
                                        <span class="avatar mr-2" style="background: url({{asset('public/ela-assets/images/s2.png) no-repeat;')}}">
                                            <a href=""  data-toggle="tooltip" title="Delete Mentor" class="close-s"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="avatar mr-2" style="background: url({{asset('public/ela-assets/images/s3.png) no-repeat;')}}">
                                            <a href=""  data-toggle="tooltip" title="Delete Mentor" class="close-s"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="avatar mr-2" style="background: url({{asset('public/ela-assets/images/s4.png) no-repeat;')}}">
                                            <a href=""  data-toggle="tooltip" title="Delete Mentor" class="close-s"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        <hr>
                                        <h6 style="position:relative;">Groups
                                            <div class="edit-btn" data-toggle="tooltip" title="Add Group" >
                                                <a href="#" data-toggle="modal" data-target="#addgroup"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid"/></a>
                                            </div>
                                        </h6>
										
										<div id="div-groups">
											<!--
											<div class="btn-gray mb-15">Group ABC
												<span>
													<a href="#"><i class="fa fa-times" aria-hidden="true"></i></a>
												</span>
											</div>
											
										</div>
                                    </div>
									-->
                                    <div class="col-md-12 student-bio">
                                        <hr>
                                        <h6>Biodata</h6>
                                        <table class="table table-borderless">
                                            <tbody>
                                              <tr>
                                                <td style="width: 20rem;color:#212529!important;">Registration No</td>
                                                <td id="bio_reg_number"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Name of the school</td>
                                                <td id="bio_school_name"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">District</td>
                                                <td id="bio_school_district"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Guardian Name</td>
                                                <td id="bio_parent_name"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Home Location</td>
                                                <td id="bio_house_location"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Syllabus</td>
                                                <td id="bio_syllabus"></td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal fade" id="resetpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Reset Password </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <form>
                                              <div class="form-group row mb-0">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Registration No.</label>
                                                <div class="col-sm-8">
                                                  <input type="text" readonly class="form-control-plaintext" id="staticno" value="62788569" style="font-size:14px;">
                                                </div>
                                              </div>
                                              <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                  <input type="text" readonly class="form-control-plaintext" id="staticno" value="Sanju" style="font-size:14px;">
                                                </div>
                                              </div>
                                              <div class="row">
                                                  <div class="form-group col-md-6">
                                                    <label for="exampleInputPassword1">Old Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1">
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                    <label for="exampleInputPassword1">New Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                                                  </div>
                                                  <div class="form-group col-md-12">
                                                    <label for="exampleFormControlInput1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                                  </div>
                                              </div>
                                              <button type="submit" class="btn btn-primary float-right">Reset</button>
                                            </form>
                                          </div>
                                          
                                        </div>
                                      </div>
                                    </div>
									
									@include('admin.student.student-edit-modal-pool')

                                <div class="modal fade bd-example-modal-md" id="addmentor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md  modal-dialog-centered">
                                      <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h4 class="modal-title" id="myLargeModalLabel">Allocate Mentor to Student
                                                        </h4>
                                                    </div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <form class="students-form" style="max-width: 100%;">
                                                        
                                                        <div class="row students-lists">
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s1.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s2.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s3.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s4.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s1.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s2.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s3.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s1.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s2.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s3.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s1.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s2.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 single-student">
                                                                <div class="student-pic" style="background: url(images/s3.png);"></div>
                                                                <div class="name">
                                                                    Sreelakshmi R
                                                                    <span>Grade VIII</span>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input type="checkbox" class="form-check-input" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                        <a href="#" class="btn btn-primary mt-30 float-right">Allocate</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade bd-example-modal-md" id="addgroup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md  modal-dialog-centered">
                                      <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h4 class="modal-title" id="myLargeModalLabel">Allocate Group to Student
                                                        </h4>
                                                    </div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <form class="students-form" style="max-width: 100%;">
                                                        
                                                        <div class="row students-lists allocate-group">
															@foreach($stud_groups as $key=>$stud_group) 
                                                            <div class="col-md-12 single-student grp_row" id="grp_row_{{$stud_group->id  }}">
                                                                <div class="name">
																{{$stud_group->stud_group}}
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
																		<input  id="grp_row_check_{{$stud_group->id  }}" type="checkbox" value="{{$stud_group->id  }}" class="form-check-input check-group" >
                                                                    </label>
                                                                </div>
                                                            </div>
															@endforeach
                                                        </div>   
                                                        <a style="" data-dismiss="modal" class="btn btn-primary mt-30 float-right" id="a-allocate-group-to-student">Allocate</a>
                                                    </form>
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
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
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