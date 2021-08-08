@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$mentors_own_groups =  app()->call([$cc, 'get_mentors_own_groups']);
$count_mentors_own_groups = count($mentors_own_groups);
$mentors_own_students =  app()->call([$cc, 'get_mentors_own_students']);

$mentors_grade_students =  app()->call([$cc, 'get_mentors_grade_students']);
$count_mentors_grade_students = count($mentors_grade_students);

$mentors_entire_students =  app()->call([$cc, 'get_mentors_entire_students']);

$count_mentors_own_students = count($mentors_own_students);

$count_mentors_entire_students = count($mentors_entire_students);

$student_id = ($count_mentors_entire_students>0) ? $mentors_entire_students[0]->student_id : ' ';

/*
$student_id = ($count_mentors_grade_students>0) ? $mentors_grade_students[0]->student_id : ' ';
$student_id = ($count_mentors_own_students>0) ? $mentors_own_students[0]->student_id : $student_id;
*/	
//$mentors_own_groups = app()->call([$cc, 'get_mentors_own_groups'], [Auth::guard('ela_user')->user()->id]);

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
	
	
		
		student_id = '{{ $student_id }}'; /* GET FIRST STUDENT ID  */
				
		get_student_detail(student_id); /* GET FIRST STUDENT DETAIL  */
		
		
		
	
		$(document).on('click', '.tr-student', function(event)
		{
			event.preventDefault;
			
			student_id = $(this).attr('value');
			get_student_detail(student_id);
			
			
		});
		
		
		
		

		
		


});
	
	

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
				  	var stud_grade = selected_student[0].stud_grade ? selected_student[0].stud_grade : '';
				   
				    $('#h-sel-stud-name').html(selected_student[0].first_name + ' ' + last_name + '<span  >Class: ' + stud_grade + '</span>');
				   
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
				    $('#bio_reg_number').html(selected_student[0].stud_reg_number);
				    $('#bio_school_name').html(selected_student[0].school_name);
				    $('#bio_school_district').html(selected_student[0].school_district);
				    $('#bio_father_name').html(selected_student[0].father_name);
				    $('#bio_mother_name').html(selected_student[0].mother_name);
				    $('#bio_father_phone').html(selected_student[0].father_phone);
				    $('#bio_mother_phone').html(selected_student[0].mother_phone);
				    $('#bio_medium').html(selected_student[0].medium);
				    $('#bio_stud_dob').html((selected_student[0].stud_dob).substring(0, 10));
				    $('#bio_blood_group').html(selected_student[0].blood_group);
				    $('#bio_syllabus').html(selected_student[0].syllabus);
				    $('#bio_gender').html(selected_student[0].gender);
				    $('#bio_house_panchayath').html(selected_student[0].house_panchayath);
				    $('#bio_whatsapp_1').html(selected_student[0].whatsapp_1);
					
					profile_pic_path = "{{url('/public')}}" + '/' + selected_student[0].prof_pic_path + selected_student[0].prof_pic_file ;
					 
					
					$.ajax({ url: profile_pic_path, type:'HEAD',
								error: function()
								{
									$("#imagePreview").hide();
									$("#span-sel-stud-name-abbr").show();
								},
								success: function()
								{
									$("#imagePreview").show();
									$("#span-sel-stud-name-abbr").hide();
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
	
</script>
@include('mentor.layouts.ela-mentor-topbar')
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
							
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/mentor/dashboard')}}"> {{ $user_name }}</a> / My Students</h3>
                            <p class="sub-text">Expert in Science Subjects</p>
							
                        </div>
                    </div>
                    <div class="col-3 text-right">
					<!--
						<a id="a-add-new-student" href="{{url('admin/student/stud-registration')}}"> 
                        <button type="button" class="btn btn-third" >
                            <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                            New Student
                        </button>
						</a>
						-->
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="row admin-lists">
                <div class="col-md-12">
                    <div class="row">
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
											@foreach($mentors_entire_students as $key=>$student) 
												<?php
													$profile_pic_path = url('/public') . '/' . $student->prof_pic_path . $student->prof_pic_file ;
												?>		
                                            <tr class="tr-student" value="{{$student->student_id}}" style="cursor:pointer">
											@if( @GetImageSize($profile_pic_path))
                                                <td>
													<div class="submitted-by" >
														<span  style="background: url({{$profile_pic_path}}" ></span>
														{{$student->student_first_name . ' ' . $student->student_last_name }}
													</div>
                                                </td>
											@else
                                                <td>
                                                    <a >
                                                        <div class="submitted-by">
                                                            <span class="grade">{{strtoupper(substr($student->student_first_name, 0, 1)) . strtoupper(substr($student->student_last_name, 0, 1)) }}</span>
                                                           {{$student->student_first_name . ' ' . $student->student_last_name }}
                                                        </div>
                                                    </a>
                                                </td>
											@endif	
                                            </tr>
											@endforeach
											
											
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                            <div class="col-md-8 profile-wrap"> 
								
								<div class="profile submitted-by ">
									<form class="profile-pic-form" id="profile-pic-form" enctype="multipart/form-data">
										<div class="avatar-upload profile-photo-editor">
										<!--
											<div class="avatar-edit">
												<input type='file' name="image[]" id="inputfiles" accept=".png, .jpg, .jpeg" />
												<label for="inputfiles"></label>
											</div>
											-->
											<div class="avatar-preview">
												<div id="imagePreview" style=" display:none;">
												
												</div>
												
												<div class="without-image" id="span-sel-stud-name-abbr">
													{{strtoupper(substr($student->first_name, 0, 1)) . strtoupper(substr($student->last_name, 0, 1)) }}
												</div>
											</div>
										</div>
										<input type="hidden" name="dirtarget" id="dirtarget_docs" class="form-control dirtarget" placeholder="Add Title">
										<input type="hidden" name="profile_user_id" id="" class="form-control profile_user_id" >
									</form>
									
									
									
									<h3 id="h-sel-stud-name"><span class="text-left" ></span></h3>
								</div>

                                <div class="row mt-30">
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
									<div class="col-md-6">
                                        <h6>Academic Report</h6>
                                        <ul class="reports">
                                            <li class="d-flex">
                                                <span class="violet"></span>IT  <span class="gray"> Basics, OOPS</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                            <li class="d-flex">
                                                <span class="blue"></span>Science <span class="gray"> Physics, Chemistry, Biology</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                            <li class="d-flex">
                                                <span class="green"></span>Art <span class="gray"> Music, Reading, Craft</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                            <li class="d-flex">
                                                <span class="dark-green"></span>Language <span class="gray"> English, Malayalam</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Attendance</h6>
                                        <ul class="reports">
                                            <li class="d-flex">
                                                <span class="violet"></span>IT  <span class="gray"> Basics, OOPS</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                            <li class="d-flex">
                                                <span class="blue"></span>Science <span class="gray"> Physics, Chemistry, Biology</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                            <li class="d-flex">
                                                <span class="green"></span>Art <span class="gray"> Music, Reading, Craft</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                            <li class="d-flex">
                                                <span class="dark-green"></span>Language <span class="gray"> English, Malayalam</span>
                                                <p class=" text-right ml-auto">74%</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 student-bio">
                                        <hr>
                                        <h6>Biodata</h6>
                                        <table class="table table-borderless">
                                            <tbody>
                                              <tr>
                                                <td style="width: 20rem;color:#212529!important;">Registration No</td>
                                                <td class="text-right pr-20" id="bio_reg_number"></td>
                                                <td style="width: 20rem;color:#212529!important;">Medium of Instruction</td>
                                                <td class="text-right" id="bio_medium"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Name of the school</td>
                                                <td class="text-right pr-20" id="bio_school_name"></td>
                                                <td style="width: 20rem;color:#212529!important;">D.O.B.</td>
                                                <td class="text-right"  id="bio_stud_dob"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Home District</td>
                                                <td class="text-right pr-20" id="bio_school_district"></td>
                                                <td style="width: 20rem;color:#212529!important;">Blood Group</td>
                                                <td class="text-right" id="bio_blood_group"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Panchayath</td>
                                                <td class="text-right pr-20" id="bio_house_panchayath"></td>
                                                <td style="width: 20rem;color:#212529!important;">Whatsapp Number</td>
                                                <td class="text-right" id="bio_whatsapp_1"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Father Name</td>
                                                <td class="text-right pr-20" id="bio_father_name"></td>
                                                <td style="width: 20rem;color:#212529!important;">Father's Phone</td>
                                                <td class="text-right" id="bio_father_phone"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Mother Name</td>
                                                <td class="text-right pr-20" id="bio_mother_name"></td>
                                                <td style="width: 20rem;color:#212529!important;">Mother's Phone</td>
                                                <td class="text-right" id="bio_mother_phone"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Gender</td>
                                                <td class="text-right pr-20" id="bio_gender"></td>
                                                <td style="width: 20rem;color:#212529!important;"></td>
                                                <td class="text-right"></td>
                                              </tr>
                                              <tr>
                                                <td style="color: #212529!important;">Syllabus</td>
                                                <td class="text-right pr-20" id="bio_syllabus"></td>
                                                <td style="width: 20rem;color:#212529!important;"></td>
                                                <td class="text-right"></td>
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