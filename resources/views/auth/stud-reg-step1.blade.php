@include('layouts.ela-header')

<body>
<script>
$(document).ready(function(){
	
	
		$(document).on('click', '#a-continue', function(event)
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
				/*
				if(confirm("Are you sure to Update and Continue ?"))
				{
					insert_stud_reg_basic();
				}
				*/
					insert_stud_reg_basic();
				
			}
			
			
		});
		
		
		

	});
	
	

	function insert_stud_reg_basic()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_stud_reg_basic';
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
						document.location.href = 'stud-reg-academic';
				   }
				}
			});
			
	}
	
	
</script>
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$genders =  app()->call([$cc, 'get_genders']);

?>

    <section class="main-login register">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-5" style="background: url({{asset('public/ela-assets/images/login-bg.jpg) no-repeat;')}}">
                    <h1>
                        Sign in to<br> Dedication, Innovation<br> and Entertainment.
                    </h1>
                </div>
                <div class="col-md-7">
                    <div class="register-steps">
                        <div class="row timeline mb-60">
                            <div class="col-4">
                                <div class="initial active">
                                    <div class="dot"></div>
                                    <span>Basic</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="initial">
                                    <div class="dot"></div>
                                    <span>Academic</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="initial">
                                    <div class="dot"></div>
                                    <span>Bio</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mb-40">
                                <h2>Hi Kid, let us know about you.</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.</p>
                            </div>
                        </div>
						
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="first_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="last_name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="gender">Gender</label>
                                    <select id="gender_id" class="form-control">
        								@foreach($genders as $key=>$gender) 
        									<option value="{{$gender->id}}">{{$gender->gender}}</option>
        								@endforeach
                                    </select>
                                </div>
								
								<div class="form-group col-md-6 mt-1">
									<div class="input-group-append">
										<div class="">
											<label class="form-check-label " for="stud_dob" id="lbl-mated" >Date of Birth</label>
										</div>
									</div>
									<input  type="date" class="form-control mt-1"  id="stud_dob" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
								</div>
								
                            </div>

                            <a href="#" class="btn btn-primary" id="a-continue">Next</a>
                        </form>
						
                    </div>
                </div>
            </div>
        </div>
    </section>

	@include('layouts.ela-footer')

</body>

</html>