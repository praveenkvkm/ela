<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ela</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ela">
	<link rel="icon" href="{{asset('public/ela-assets/images/logo.png')}}" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="{{asset('public/ela-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/ela-assets/css/style.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')}}">
	
	<script src="{{asset('public/azzara/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/core/popper.min.js')}}"></script>
	
	
</head>

<body >

    <section class="main-login">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="left-login">
                        <!--<a href="/ela2/ela-admin"><img src="{{asset('public/ela-assets/images/logo.png')}}" class="img-fluid logo mb-40" /></a>-->
						<a href="#"><img src="{{asset('public/ela-assets/images/logo.png')}}" class="img-fluid logo mb-40" /></a>
                        <form>
						<!--
							<div class="form-check" style="height: 50px" >
								<label>Login Type</label><br/>
								<label class="form-radio-label">
									<input  class="form-radio-input" type="radio" name="optionsRadios" value=""  checked id="inward_type_mentor">
									<span class="form-radio-sign">Mentor</span>
								</label>
								<label class="form-radio-label ml-150">
									<input class="form-radio-input" type="radio" name="optionsRadios" value="" id="inward_type_student">
									<span class="form-radio-sign">Student</span>
								</label>
							</div>
						-->	
						
							<div class="form-group mb-30" id="capslockdiv" style="display: none; color:red">
								CAPS lock is ON
							</div>
							
                            <div class="form-group mb-30">
                                <label for="Username">Username</label>
                                <input type="text" class="form-control" id="username" maxlength="10">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control"  id="password">
                            </div>
                            <button type="button" class="btn btn-primary mt-15" id="btn-submit">Submit</button>
                            <div class="form-check mt-20">
                                <!--<input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Remember Me</label>-->
                                <a href="#" id="a-forgot-pwd" class="primarylink text-right">Forgot Password ?</a>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-md-8 pr-0 pl-0">
                    <div class="right-bg" style="background: url({{asset('public/ela-assets/images/login-bg.jpg) no-repeat;')}}">
                        <div class="content-btn">
                            <h1>Sign in to<br> Dedication, Innovation<br> and Entertainment.</h1>
                            <!--<a href="{{url('/stud-reg-basic')}}" class="secondary-btn mt-30">Register Now</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{asset('public/ela-assets/js/main.js')}}"></script>
    <script src="{{asset('public/ela-assets/js/scripts.js')}}"></script>

</body>

<script>
$(document).ready(function(){
	
	
	
	/*==============================CAPS LOCK DECTECTOR BEGINS====================*/
	jQuery('#username').keypress(function(e) 
	{
	  var s = String.fromCharCode( e.which );
	  if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) 
	  {
		jQuery('#capslockdiv').show(500);
	  }
	  else 
	  {
		jQuery('#capslockdiv').hide(500);
	  }
	  
	});

	jQuery('#password').keypress(function(e) 
	{
	  var s = String.fromCharCode( e.which );
	  if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) 
	  {
		jQuery('#capslockdiv').show(500);
	  }
	  else 
	  { 
		jQuery('#capslockdiv').hide(500);
	  }
	}); 
	
	/*==============================CAPS LOCK DECTECTOR ENDS====================*/
	
	
	login_url ='';
						
		$(document).on('keyup', '#password', function(event)
		{
			
			if (event.keyCode === 13) 
			{
				// Cancel the default action, if needed
				event.preventDefault();
				// Trigger the button element with a click
				document.getElementById("btn-submit").click();
			}			
			
			
		});
		
		
		$(document).on('click', '#btn-submit', function(event)
		{
			
			if(!$('#username').val())
			{
				alert('Please enter Username');
			}
			else if(!$('#password').val())
			{
				alert('Please enter password');
			}
			else
			{
				login_url ='attempt_user_login';
				login();
			}
			
			
			
		});
		
		
		$(document).on('click', '#a-forgot-pwd', function(event)
		{
			if(!$('#username').val())
			{
				alert('Please enter Your Username');
			}
			else
			{
				if(confirm('This will set a new password and will send to your email id. Are you sure to continue ?'))
				{
						send_mail_forgot_pwd();
				}
			}
		});
		
		

	});
	
	
	
	function login()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var = login_url;
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['username'] = $('#username').val();
		data['password'] = $('#password').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					var user_exist = result_data.trim();
					//alert(user_exist);
					
					if(user_exist == 1)
					{
						document.location.href = 'admin/dashboard';
					}
					else if(user_exist == 2)
					{
						document.location.href = 'mentor/dashboard';
					}
					else if(user_exist == 3)
					{
						document.location.href = 'student/dashboard';
					}
					else
					{
						alert('Username or Password mismatch');
					}
							  
				}
			});
			
	}
	
	
	function send_mail_forgot_pwd()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var = 'check_forgot_pwd';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['username'] = $('#username').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					var user_exist = result_data.trim();
					
					if(user_exist == 0)
					{
						alert('Unknown Username..!!');
					}
					else if(user_exist == '')
					{
						alert('Your email id is not updated yet. Please contact Admin.' );
					}
					else if(user_exist == 2)
					{
						alert('Your email id is Invalid. Please contact Admin.' );
					}
					else
					{
						alert('Your new password is sent to ' + user_exist );
					}
							
				}
			});
			
	}
	
	
</script>

</html>