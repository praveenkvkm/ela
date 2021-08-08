@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$mentors =  app()->call([$cc, 'get_approved_mentors']);
$mentor_types =  app()->call([$cc, 'get_mentor_types']);
$mentor_categories =  app()->call([$cc, 'get_mentor_categories']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);

?>

<body>
@include('admin.layouts.ela-admin-topbar')
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
		
		profile_pic_path ='';
		
		selected_grades = [];
	
		
		mentor_id = '{{ $mentors[0]->ela_user_id }}'; /* GET FIRST MENTOR ID  */
		
				
		get_mentor_full_detail_by_id(mentor_id); /* GET FIRST MENTOR DETAIL  */
		
		
		dirtarget = 'pk-uploads/profile-pic/' + mentor_id ;
		$('.dirtarget').val(dirtarget);	
		$('.profile_user_id').val(mentor_id);	
		
		
		$(document).on('change', '#inputfiles', function() 
		{
			
			if(confirm('Are you sure to Update this Image ?'))
			{
				showimages(this);
				upload_profile_pic();
			}
				
		});	
		
		
	 function showimages(input) 
		{
			if (input.files && input.files[0]) 
			{
				var i=0;
				var src='';
				$("#span-sel-mentor-name-abbr").hide();
				$("#imagePreview").show();
				$("#imagePreview").empty();
				$(input.files).each(function () 
				{
					var reader = new FileReader();
					reader.readAsDataURL(this);
					reader.onload = function (e) 
					{					
									
						$('#imagePreview').css('background-image', 'url(' +  e.target.result + ')');			
										
					}
					if (i ==3) 
					{
						return false;      
					}				
					
					i++;
				});
			}
		}
		
		
		
		function upload_profile_pic()
		{
			APP_URL = "{{ url('/') }}";		
			
				var myform = document.getElementById("profile-pic-form");
				
			url_now = APP_URL + '/upload_profile_pic';

			var fd = new FormData(myform );
			//console.log(fd);
			$.ajax({
				url: url_now,
				data: fd,
				async:false,
				cache: false,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function (dataofconfirm) 
				{
					// do something with the result
					alert("Files uploaded successfully.");
					//hideLoader();
									//location.reload();

				}
			});

		}
		
		
		
		
		
		$(document).on('click', '#a-add-new-mentor', function()
		{
			set_session_add_new_mentor_from_page();
			
		});
	
	
		$(document).on('click', '.tr-mentor', function(event)
		{
			event.preventDefault;
			
			mentor_id = $(this).attr('value');
			dirtarget = 'pk-uploads/profile-pic/' + mentor_id ;
			$('.dirtarget').val(dirtarget);	
			$('.profile_user_id').val(mentor_id);	
			
			get_mentor_full_detail_by_id(mentor_id);
			
			
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
		
		
		$(document).on('click', '#btn-reset-password', function()
		{
			
			if(!$('#old_password').val())
			{
				alert('Please enter Old Password.');
			}
			else if(!$('#new_password').val())
			{
				alert('Please enter New Password.');
			}
			else
			{
				
				if(confirm("Are you sure to Reset Password ?"))
				{
					var	url_var = APP_URL + '/reset_password';
					
					var data = {};
					data['id'] = mentor_id;
					data['old_password'] = $('#old_password').val();
					data['new_password'] =$('#new_password').val();
							
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
							   }
							   else if(result_data ==0)
							   {
									alert('Old Password Mismatch');
							   }
							  
							}
						});
				}
				
			}

				
		});	
		
		
		$(document).on('click', '#btn-set-password', function()
		{
			
			if(!$('#new_password').val())
			{
				alert('Please enter New Password.');
			}
			else
			{
				
				if(confirm("Are you sure to Set Password ?"))
				{
					var	url_var = APP_URL + '/set_password';
					var data = {};
					data['id'] = mentor_id;
					data['new_password'] =$('#new_password').val();
							
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
				
			}

				
		});	
		
		
		
		$(document).on('click', '#a-allocate-grade-to-mentor', function()
		{
			 
				$(".check-grade:checked").each(function () 
				{
					grade_id = $(this).attr("value");
					var	url_var = APP_URL + '/allocate_grade_to_mentor';
					
					var data = {};
					data['grade_checked'] = 1;
					data['grade_id'] = grade_id;
					data['mentor_id'] = mentor_id;
							
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
				
			get_mentor_full_detail_by_id(mentor_id);	
				
		});	
		
		
		$(document).on('click', '.span-remove-grade', function()
		{
			grade_id = $(this).attr("value");

			var	url_var = APP_URL + '/allocate_grade_to_mentor';
			
			var data = {};
			data['grade_checked'] = 0;
			data['grade_id'] = grade_id;
			data['mentor_id'] = mentor_id;
					
			$.ajax({
			   type:'post',
			   url: url_var,  
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
					  
					}
				});
						
			get_mentor_full_detail_by_id(mentor_id);				
			
		});
		
		

		
		


});



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
		data['approved'] = active;	//if inactivated, its approval also should be cancelled.
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
	
	
	function set_session_add_new_mentor_from_page()
	{

		var	url_var = APP_URL + '/set_session_add_new_mentor_from_page';
		
		var data = {};
		data['add_new_mentor_from_page'] = '/admin/mentor/admin-mentors';
		
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
		 
		 $('#div-active').empty();
		 if (selected_mentor[0].active ==1)
		 {
			 $('#div-active').html('<input type="checkbox" class="form-check-input" id="active" checked="checked"><label class="form-check-label" for="active">Active</label>');
		 }
		 else
		 {
			 $('#div-active').html('<input type="checkbox" class="form-check-input" id="active"><label class="form-check-label" for="active">Active</label>');
		 
		 }
		

	}
	
</script>
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Mentor List</h3>
                            <p class="sub-text">Admin for ELA School</p>
                        </div>
                    </div>
                    <div class="col-3 text-right">
						<a id="a-add-new-mentor" href="{{url('admin/mentor/add-mentor')}}"> 
                        <button type="button" class="btn btn-third" >
                            <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                            New Mentor
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
                        <div class="col-3">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Assigned</option>
                                    <option>Assigned</option>
                                    <option>Assigned</option>
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
                                <input class="form-control" id="myInput" type="text" placeholder="Search Students">
                                <div class="list-height-fix mt-30">
                                    <table class="table">
                                        <tbody id="myTable">
											@foreach($mentors as $key=>$mentor) 
                                            <tr class="tr-mentor" value="{{$mentor->ela_user_id}}" style="cursor:pointer">
												<?php
													$profile_pic_path = url('/public') . '/' . $mentor->prof_pic_path . $mentor->prof_pic_file ;
												?>		
												@if( @GetImageSize($profile_pic_path))
                                                <td>
                                                    <a >
                                                        <div class="submitted-by">
                                                            <span style="background: url({{$profile_pic_path}}"></span>
                                                           {{ $mentor->first_name . ' ' . $mentor->last_name }}
                                                        </div>
                                                    </a>
                                                </td>
												@else
                                                <td>
                                                    <a >
                                                        <div class="submitted-by">
                                                            <span class="grade">{{strtoupper(substr($mentor->first_name, 0, 1)) . strtoupper(substr($mentor->last_name, 0, 1)) }}</span>
                                                           {{ $mentor->first_name . ' ' . $mentor->last_name }}
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
											<div class="avatar-edit">
												<input type='file' name="image[]" id="inputfiles" accept=".png, .jpg, .jpeg" />
												<label for="inputfiles"></label>
											</div>
											<div class="avatar-preview">
												<div id="imagePreview" style=" display:none;">
												
												</div>
												
												<div class="without-image" id="span-sel-mentor-name-abbr">
													{{strtoupper(substr($mentor->first_name, 0, 1)) . strtoupper(substr($mentor->last_name, 0, 1)) }}
												</div>
											</div>
										</div>
										<input type="hidden" name="dirtarget" id="dirtarget_docs" class="form-control dirtarget" placeholder="Add Title">
										<input type="hidden" name="profile_user_id" id="" class="form-control profile_user_id" >
									</form>
									
									
									
									<h3 id="h-sel-mentor-name"><span></span></h3>
									
                                    <div class="edit-btn btn-group dropleft" data-toggle="tooltip" title="Edit Student">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid" /></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editstudent">Edit</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#resetpassword">Set Password</a>
                                        </div>
                                    </div>
                                </div>
								
								
								
								
								
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Subjects</h6>
                                        <ul class="reports">
                                            <li class="d-flex">
                                                <span class="violet"></span>IT <span class="gray"> Basics, OOPS</span>
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
                                        <hr>
                                        <div class="student-bio">
                                            <h6>Grades</h6>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 15rem;color:#212529!important;">Grade VIII</td>
                                                        <td>24 Students</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: #212529!important;">Grade IX</td>
                                                        <td>36 Students</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <!-- <a href="#" style="color: #FF900E;">Assign New Grade</a> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <h6 style="position: relative;">Grades
                                            <div class="edit-btn" data-toggle="tooltip" title="Add Group">
                                                <a href="#" data-toggle="modal" data-target="#addgrade"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid" /></a>
                                            </div>
                                        </h6>
										<div id="div-grades" >
											<!--
												<div class="btn-gray mb-15">Grade VI
													<span>
														<a href="#"><i class="fa fa-times" aria-hidden="true"></i></a>
													</span>
												</div>
											-->
										</div>
                                        <hr>
                                    </div>
                                </div>
								<!--
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
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">User Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext" id="reset_user_name" value="sanju@gmail.com" style="font-size:14px;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext" id="reset_mentor_name" value="Sanju" style="font-size:14px;">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="exampleInputPassword1">Old Password</label>
                                                            <input type="password" class="form-control" id="old_password">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="exampleInputPassword1">New Password</label>
                                                            <input type="password" class="form-control" id="new_password" placeholder="New Password">
                                                        </div>

                                                    </div>
                                                    <a id="btn-reset-password" class="btn btn-primary float-right">Reset</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								-->
                                <div class="modal fade" id="resetpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Set Password </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group row mb-0">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">User Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext" id="reset_user_name" value="sanju@gmail.com" style="font-size:14px;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext" id="reset_mentor_name" value="Sanju" style="font-size:14px;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleInputPassword1" class="col-sm-4 col-form-label">New Password</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="new_password" placeholder="New Password">
                                                        </div>

                                                    </div>
                                                    <!--<div class="row">-->
                                                    <!--    <div class="form-group col-md-6">-->
                                                    <!--        <label for="exampleInputPassword1">Password</label>-->
                                                    <!--        <input type="password" class="form-control" id="new_password" placeholder="New Password">-->
                                                    <!--    </div>-->

                                                    <!--</div>-->
                                                    <a id="btn-set-password" class="btn btn-primary float-right">Set</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade bd-example-modal-lg" id="editstudent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <h4 class="modal-title" id="myLargeModalLabel">Edit Mentor Details
                                                        </h4>
                                                    </div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12">
													<form>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label for="firstname">First Name</label>
																<input type="text" class="form-control" id="first_name" value="{{$mentors[0]->first_name }}">
															</div>
															<div class="form-group col-md-6">
																<label for="lastname">Last Name</label>
																<input type="text" class="form-control" id="last_name" value="{{$mentors[0]->last_name }}">
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label for="mobile">Mobile</label>
																<input type="text" class="form-control" id="mobile" value="{{$mentors[0]->last_name }}">
															</div>
															<div class="form-group col-md-6"> 
																<label for="email">Email</label> 
																<input type="text" class="form-control" id="email" value="{{$mentors[0]->last_name }}">
															</div>
														</div>
														
														<div class="form-row">
															
															<div class="form-group col-md-6">
																<label for="city">Residential Address</label>
																<textarea class="form-control" id="res_address" rows="3" style="height:40px;"></textarea>
															</div>
															
															<div class="form-group col-md-6">
																<label for="city">Official Address</label>
																<textarea class="form-control" id="off_address" rows="3" style="height:40px;"></textarea>
															</div>
															
														</div>
														
														<div class="form-row">
															
															<div class="form-group col-md-6"> 
																<label for="designation">Designation</label> 
																<input type="text" class="form-control" id="designation">
															</div>
															
															
														</div>
														
														<div class="form-row" style="display:none;">
															<div class="form-group col-md-6">
																<label for="gender">Mentor Type</label>
																<select id="mentor_type_id" class="form-control">
																	@foreach($mentor_types as $key=>$mentor_type)  
																	<option {{ $mentor_type->id == $mentors[0]->mentor_type_id ? "selected":""}} value="{{$mentor_type->id}}">
																		{{$mentor_type->mentor_type}}
																	</option>
																	@endforeach
																</select>
															</div>
															<div class="form-group col-md-6">
																<label for="gender">Mentor Category</label>
																<select id="mentor_category_id" class="form-control">
																	@foreach($mentor_categories as $key=>$mentor_category)  
																	<option value="{{$mentor_category->id}}" {{ $mentor_category->id == $mentors[0]->mentor_category_id ? "selected":""}}  >
																		{{$mentor_category->mentor_category}}
																	</option>
																	@endforeach
																</select>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<div class="form-check" id="div-active">
																	<input type="checkbox" class="form-check-input" id="active"  >
																	<label class="form-check-label" for="active">Active</label>
																</div>
															</div>
														</div>
														
														<a style="color:white;" id="a-update-edit-mentor" class="btn btn-primary float-right">Submit</a>
														
													</form>
                                                </div>
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
                                <div class="modal fade bd-example-modal-md" id="addgrade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h4 class="modal-title" id="myLargeModalLabel">Allocate Grade to Mentor
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
															@foreach($stud_grades as $key=>$stud_grade) 
                                                            <div class="col-md-12 single-student grd_row" id="grd_row_{{$stud_grade->id  }}">
                                                                <div class="name">
																{{$stud_grade->stud_grade}}
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
																		<input  id="grd_row_check_{{$stud_grade->id  }}" type="checkbox" value="{{$stud_grade->id  }}" class="form-check-input check-grade" >
                                                                    </label>
                                                                </div>
                                                            </div>
															@endforeach
                                                        </div>   
                                                        <a style="" data-dismiss="modal" class="btn btn-primary mt-30 float-right" id="a-allocate-grade-to-mentor">Allocate</a>
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