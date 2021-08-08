<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')
<script>
$(document).ready(function() {
    $('#goats-table').DataTable();
	
} );

</script>
<style>
.card-title 
{
    color: #28a745;
    font-weight: 700;
}

label 
{
    color: #28a745!important;
    font-size: 14px!important;
    font-weight: 600!important;
}

.card .card-header 
{
    background-color: transparent;
    border-bottom: 2px solid #35cd3a!important;
}

.card .card-action 
{
    border-top: 1px solid #35cd3a!important;
}

#item-add-student i, #item-add-student p
{
    color: #28a745!important;
}

.blink_me 
{
  animation: blinker 2s linear infinite;
}

@keyframes blinker 
{
  50% {
    opacity: 0;
  }
}
</style>



	<div class="wrapper">
		@include('admin.layouts.topbar')

		@include('admin.layouts.sidebar-admin')
		
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">ADD STUDENT  <span style="color: blue; font-size:18px; margin-top: 0px; display:none;"  class="card-category text-right " id="p-edit-mode"> - EDIT MODE</span>									
								</div>
										

								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="container container-login animated fadeIn ">
												
												<div class="login-form">
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
														<input  id="user_email" name="username-signup" type="text" class="form-control input-border-bottom" required>
														<label for="user_email" class="placeholder">Email</label>
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
														<a href="#" id="a-signup" class="btn btn-primary btn-rounded btn-login"><b>Update</b></a>
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
							
										<div class="col-md-3">
										<!--
											<div class="form-group">
												<label for="category_id">CATEGORY</label>
													<select class="form-control"  id="mentor_category_id">
														<option value="1">Mentor</option>
														<option value="2">Supervisor</option>
													</select>
											</div>
											
											<div class="form-group">
												<label for="category_id">TYPE</label>
													<select class="form-control"  id="mentor_type_id">
														<option value="1">Temporary</option>
														<option value="2">Permanent</option>
													</select>
											</div>
											
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" type="checkbox" value="">
													<span class="form-check-sign">Active</span>
												</label>
											</div>
										-->
											
										</div>
										
										<div class="col-md-3">
											
										</div>
										
									</div>
								</div>
								<div class="card-action">
								<!--
									<button id="btn-save" class="btn btn-success">Save</button>
									<button  id="btn-edit" type="button" class="btn btn-warning" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#myModal">
									  Edit
									</button>	
									<button style="display:none"  class="btn btn-info " id="btn-switch-to-addition">Switch to Addition Mode</button>
									-->
								</div>
							</div>
							
							
						</div>
					</div>
					
					
					
					
					
					
				</div>
			</div>
		</div>	<!--Main-Panel ends -->
		
		
	</div>
</div>


<!--======================================================================================================-->
@include('layouts.footer')

<script>
$(document).ready(function(){
	
	
		$(document).on('click', '#a-signup', function(event)
		{
			
			
			if(!$('#mobile').val())
			{
				alert('Please enter Mobile');
			}
			else if(!$('#password').val())
			{
				alert('Please enter Password');
			}
			else
			{
				
					insert_studentr_by_admin();
				
				
			}
			
			

			
		});
		
		
		

	});

	
	function insert_studentr_by_admin()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_user';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['user_type_id'] = 3;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['password'] = $('#password').val();
		data['mentor_type_id'] = $('#mentor_type_id option:selected').val();
		data['mentor_category_id'] = $('#mentor_category_id option:selected').val();
		data['active'] = $('#active').is(':checked') ? 1 : 0;
						
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   //alert(result_data);
					if(result_data == 0)
					{
						alert('UserName already Exists.');
					}
					else
					{
						alert('Succesfully Registered.');
					}
				}
			});
			
	}
	
	
	
	
</script>

</body>
</html>