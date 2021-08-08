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

body {
  background: #368dda;
}

.bubble {
  position: relative;
  font-family: sans-serif;
  font-size: 18px;
  line-height: 24px;
  width: 300px;
  background: #fff;
  border-radius: 40px;
  padding: 24px;
  text-align: center;
  color: #000;
}

.bubble-bottom-left:before {
  content: "";
  width: 0px;
  height: 0px;
  position: absolute;
  border-left: 24px solid #fff;
  border-right: 12px solid transparent;
  border-top: 12px solid #fff;
  border-bottom: 20px solid transparent;
  left: 32px;
  bottom: -24px;
}

.bubble-bottom-right:before {
  content: "";
  width: 0px;
  height: 0px;
  position: absolute;
  border-left: 24px solid #fff;
  border-right: 12px solid transparent;
  border-top: 12px solid #fff;
  border-bottom: 20px solid transparent;
  left: 232px;
  bottom: -24px;
}


</style>



	<div class="wrapper">
		@include('admin.layouts.topbar')

		
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">MESSENGER  <span style="color: blue; font-size:18px; margin-top: 0px; display:none;"  class="card-category text-right " id="p-edit-mode"> - EDIT MODE</span>									
								</div>
										

								</div>
								<div class="card-body" style="background-color: antiquewhite;">
									<div class="row">
										<div class="col-md-6">
											<div class="container ">
												
													<div class="row">
														<div class="col-md-6">
															<div class="bubble bubble-bottom-left" contenteditable>
															Type any text here and the bubble will grow to fit the text no matter how many lines.  Isn't that nifty?
															</div>
														</div>
														<div class="col-md-6" style="margin-left:700px;">
															<div class="bubble " contenteditable>
															Type any text here and the bubble will grow to fit the text no matter how many lines.  Isn't that nifty?
															</div>
														</div>

													</div>
													
												
												
												
											</div>
											
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