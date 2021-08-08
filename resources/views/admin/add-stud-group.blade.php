<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')
<script>
$(document).ready(function() {
    $('#goats-table').DataTable();
	
	$(function() {
		$.ajaxSetup({
			headers: 
			{
			  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
			}
		});
	});
	
	
	$(document).on('click', '#btn-save', function()
	{
		
			if(!$('#stud_group').val())
			{
				alert('Please enter Group.');
			}
			else
			{
				if(confirm("Are you sure to Update ?"))
				{
					insert_stud_group();
					
				}
			}
		
		
	});
	
	
	
	
} );


	function insert_stud_group()
	{

		var url_var =  APP_URL + '/insert_stud_group';
		
		var data = {};
		data['stud_group'] = $('#stud_group').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if (result_data==1)
				   {
					   alert('Updated');
				   }
				   else
				   {
					   
					   alert('Group Name Already Exists.');
				   }
				}
			});
			
	}


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

#item-stud-group i, #item-stud-group p
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
				
					<div class="row row-card-no-pd">
						<div class="col-md-12">						
							<div class="card">
							
								<div class="card-header">
									<div class="card-head-row">
										<h4 class="card-title"></h4>
										<!--
										<div class="card-tools">
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"><span class="fa fa-sync-alt"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-times"></span></button>
										</div>
										-->
									</div>
									<!--<p class="card-category">
									Map of the distribution of users around the world</p>-->
								</div>
								
								<div class="card-body " id="div-parent"> <!--CONTENT DIV BEGINS------------->
									<div id="div-content">
										<h4 class="card-title">CREATE STUDENT GROUP</h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="email2">Group Name</label>
													<input  type="text" class="form-control" id="stud_group" value="">
												</div>
																								
												
												
											</div>
											<div class="col-md-6">
											</div>
											
											
										</div>
									
									</div>
									
								<div class="card-action">
									<button id="btn-save" class="btn btn-success">Save</button>
								</div>
									
									
								</div> <!--CONTENT DIV ENDS------------->
								
							</div><!--CARD ends-->
							
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
				
					insert_mentor_by_admin();
				
				
			}
			
			

			
		});
		
		
		

	});

	
	function insert_mentor_by_admin()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_user';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['user_type_id'] = 2;
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