<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<!--<link rel="icon" href="{{asset('azzara/img/icon.ico" type="image/x-icon')}}"/> -->
 <link rel="icon" href="{{asset('public/ela-assets/images/logo.png')}}" type="image/gif" sizes="16x16">
	<!-- Fonts and icons -->
	<script src="{{asset('public/azzara/js/plugin/webfont/webfont.min.js')}}"></script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{asset('public/azzara/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/azzara/css/azzara.min.css')}}">
	

	<script src="{{asset('public/azzara/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/core/popper.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/core/bootstrap.min.js')}}"></script>
<style>
#a-signin
{
    background: #28a745!important;
    border-color: #28a745!important;
}
</style>
	
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn ">
			<a class="navbar-brand text-center mb-8" href="#" style="margin-left: 28%">
				<img width="70%" class="responsive-image" src="{{asset('public/ela-assets/images/logo.png')}}" alt="logo" />
				<h3 class="text-center">Sign up for ELA</h3>
				<!--
				<select class="form-control"  id="user_type_id">
					<option value="1">Admin</option>
					<option value="2">Mentor</option>
					<option value="3">Student</option>
				</select>
				-->
			</a>
			
			<div class="login-form mt-5">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group form-floating-label">
							<input  id="first_name" name="name-signup" type="text" class="form-control input-border-bottom" required>
							<label for="first_name" class="placeholder">First Name</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-floating-label">
							<input  id="last_name" name="username-signup" type="text" class="form-control input-border-bottom" required>
							<label for="last_name" class="placeholder">Last Name</label>
						</div>
					</div>
				</div>
			
				<div class="form-group form-floating-label">
					<input  id="mobile" name="username-signup" type="text" class="form-control input-border-bottom" maxlength="10" required>
					<label for="mobile" class="placeholder">Mobile Number</label>
				</div>
				<div class="form-group form-floating-label">
					<input  id="email" name="username-signup" type="text" class="form-control input-border-bottom" required>
					<label for="email" class="placeholder">Email</label>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group form-floating-label">
							<input  id="password" name="password-signup" type="password" class="form-control input-border-bottom" required>
							<label for="password" class="placeholder">Password</label>
							<div class="show-password">
								<i class="flaticon-interface"></i>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-floating-label">
							<input  id="confirmpassword" name="confirmpassword" type="password" class="form-control input-border-bottom" required>
							<label for="confirmpassword" class="placeholder">Confirm Password</label>
							<div class="show-password">
								<i class="flaticon-interface"></i>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-action mb-3">
					<a href="#" id="a-signup" class="btn btn-primary btn-rounded btn-login"><b>Sign Up</b></a>
				</div>
				
				<!--
				<div class="login-account">
					<span class="msg">Don't have an account yet ?</span>
					<a href="#" id="show-signup" class="link">Sign Up</a>
				</div>
				-->
				
			</div>
		</div>

		
		
		
		
	</div>
	
<script>
$(document).ready(function(){
	
	
		$(document).on('click', '#a-signup', function(event)
		{
			
			user_type_id = 1; //registration is allowed only for students in this page
			//user_type_id = $('#user_type_id').val();
			
			
			if(!$('#first_name').val())
			{
				alert('Please enter FirstName');
			}
			else if(!$('#mobile').val())
			{
				alert('Please enter Mobile');
			}
			else if(!$('#password').val())
			{
				alert('Please enter Password');
			}
			else
			{
				
				if(user_type_id == 1)
				{
					insert_user();
				}
				else if(user_type_id == 2)
				{
					insert_user();
				}
				else if(user_type_id == 3)
				{
					insert_user();
				}
				
				
				
			}
			
			

			
		});
		
		
		

	});
	
	
	function insert_admin()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_admin';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['password'] = $('#password').val();
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==0)
				   {
						alert('User Already Exists.');
				   }
				   else
				   {
						alert('Successfully registered.');
				   }
				   
				}
			});
			
	}
	
	function insert_mentor()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_mentor';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['password'] = $('#password').val();
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==0)
				   {
						alert('User Already Exists.');
				   }
				   else
				   {
						alert('Successfully registered.');
				   }
				}
			});
			
	}
	
	
	function insert_student()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_student';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['password'] = $('#password').val();
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==0)
				   {
						alert('User Already Exists.');
				   }
				   else
				   {
						alert('Successfully registered.');
				   }
				}
			});
			
	}
	

	function insert_user()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_user';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['user_type_id'] = user_type_id;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['password'] = $('#password').val();
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==0)
				   {
						alert('User Already Exists.');
				   }
				   else
				   {
						alert('Successfully registered.');
				   }
				}
			});
			
	}
	
	
</script>
	<script src="{{asset('public/azzara/js/ready.js')}}"></script>
	
	
</body>
</html>