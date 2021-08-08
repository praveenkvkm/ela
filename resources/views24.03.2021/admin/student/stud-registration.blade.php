@include('layouts.ela-header')
<script>
$(document).ready(function(){
	
		from_page = "{{Session::get('add_new_student_from_page')}}";


		$(document).on('click', '#a-continue-3', function(event)
		{
			
			if(!$('#father_name').val())
			{
				alert('Please enter Father Name.');
			}
			else
			{
				/*
				if(confirm("Are you sure to Update and Continue ?"))
				{
					insert_stud_reg_bio();
				}
				*/
					insert_stud_reg_bio();
				
			}
			
			
		});
	
	
		$(document).on('click', '#a-continue-1', function(event)
		{
			
			user_type_id = 3; //registration is allowed only for students in this page
			//user_type_id = $('#user_type_id').val();
			if(!$('#first_name').val())
			{
				alert('Please enter FirstName');
			}
			else if(!$('#last_name').val())
			{
				alert('Please enter Last Name');
			}
			else
			{
				if(confirm("Are you sure to Update and Continue ?"))
				{
					insert_stud_reg_basic();
				}
				
			}
			
		});
		
		
		$(document).on('click', '#a-continue-2', function(event)
		{
			
			if(!$('#school_name').val())
			{
				alert('Please enter School Name.');
			}
			else
			{
				/*
				if(confirm("Are you sure to Update and Continue ?"))
				{
					insert_stud_reg_academic();
				}
				*/
				
				insert_stud_reg_academic();
			}
			
			
		});
		


		
		
		

	});
	
	

	function insert_stud_reg_basic()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/insert_stud_reg_basic';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['gender_id'] = $('#gender_id').val();
		data['stud_dob'] = $('#stud_dob').val();
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==1)
				   {
						$('#divMain').load("stud-reg-div2");

				   }
				}
			});
			
	}
	
	
	function insert_stud_reg_academic()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/insert_stud_reg_academic';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['standard_id'] = $('#standard_id').val();
		data['medium_id'] = $('#medium_id').val();
		data['syllabus_id'] = $('#syllabus_id').val();
		data['school_name'] = $('#school_name').val();
		data['school_edu_district'] = $('#school_edu_district').val();
		data['school_address'] = $('#school_address').val();
		data['school_manage_category_id'] = $('#school_manage_category_id').val();
		data['school_sub_district'] = $('#school_sub_district').val();
		data['school_district_id'] = $('#school_district_id').val();
						
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==1)
				   {
						$('#divMain').load("stud-reg-div3");
				   }
				}
			});
			
	}
	
	function insert_stud_reg_bio()
	{
		var CSRF_TOKEN = '{{csrf_token()}}'; 

		var	url_var = APP_URL + '/insert_stud_reg_bio';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['father_name'] = $('#father_name').val();
		data['father_phone'] = $('#father_phone').val();
		data['father_job'] = $('#father_job').val();
		data['father_emp_ctg_id'] = $('#father_emp_ctg_id').val();
		data['mother_name'] = $('#mother_name').val();
		data['mother_phone'] = $('#mother_phone').val();
		data['mother_job'] = $('#mother_job').val();
		data['mother_emp_ctg_id'] = $('#mother_emp_ctg_id').val();
		data['guardian_name'] = $('#guardian_name').val();
		data['guardian_phone'] = $('#guardian_phone').val();
		data['guardian_job'] = $('#guardian_job').val();
		data['guardian_emp_ctg_id'] = $('#guardian_emp_ctg_id').val();
		
		data['house_address'] = $('#house_address').val();
		data['house_panchayath'] = $('#house_panchayath').val();
		data['house_block'] = $('#house_block').val();
		data['house_district_id'] = $('#house_district_id').val();
		data['house_pin'] = $('#house_pin').val();
		
		data['stud_blood_group_id'] = $('#stud_blood_group_id').val();
		data['stud_height'] = $('#stud_height').val();
		data['stud_weight'] = $('#stud_weight').val();
		data['stud_physical_status_id'] = $('#stud_physical_status_id').val();
		data['stud_disease'] = $('#stud_disease').val();
		data['stud_disease_details'] = $('#stud_disease_details').val();
		
		data['whatsapp_1'] = $('#whatsapp_1').val();
		data['whatsapp_2'] = $('#whatsapp_2').val();
		data['other_member_name'] = $('#other_member_name').val();
		data['other_member_std'] = $('#other_member_std').val();
		data['other_member_rel'] = $('#other_member_rel').val();
		data['email_id'] = $('#email_id').val();
		
						
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==1)
				   {
					   alert('Student Registration Completed Successfully.');
						//document.location.href =  APP_URL + '/admin/student/admin-students';
						
						document.location.href =  APP_URL + from_page;
						

				   }
				}
			});
			
	}
	
</script>
<body>
@include('admin.layouts.ela-admin-topbar')
<!--
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Add Student</h3>
                            <p class="sub-text">Admin for ELA School</p>
							
                        </div>
                    </div>
                    <div class="col-3 text-right">
					<!--
                        <button type="button" class="btn btn-third">
                            <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                            New Student
                        </button>
						-->
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container" id="divMain">

			@include('admin.student.stud-reg-div1')
			
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