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

#item-goat-entry i, #item-goat-entry p
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
<?php
	$students = array();
	
	$students = DB::table('ela_users')
	->where('ela_users.user_type_id',  '=', 3)
	->whereNull('ela_users.deleted_at')
	->orderBy('ela_users.first_name')
	->get();
	
	$stud_groups = array();
	
	$stud_groups = DB::table('stud_groups')
	->whereNull('deleted_at')
	->orderBy('stud_group')
	->get();

?>		


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
									<div class="card-title">ADD STUDENTS TO GROUP  <span style="color: blue; font-size:18px; margin-top: 0px; display:none;"  class="card-category text-right " id="p-edit-mode"> - EDIT MODE</span>									
								</div>
										

								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="category_id">GROUPS</label>
													<select class="form-control"  id="stud_group_id">
														@foreach($stud_groups as $key=>$stud_group) 
															<option value="{{$stud_group->id  }}">{{$stud_group->stud_group  }}</option>
														@endforeach
													</select>
													
													
											</div>
										</div>
							
										<div class="col-md-4">
										<h4 class="card-title">STUDENTS IN GROUP</h4>
											<div class="table-responsive table-hover table-sales">
												<table id="stud-in-group-table" class="table table-striped table-bordered" style="width:100%">
													<thead>
														<tr>
															<th>SRL</th>
															<th>NAME</th>
														</tr>
													</thead>
													<tbody>
													
													</tbody>
													<tfoot>
														<tr>
															<th>NAME</th>
															<th>SELECT</th>
														</tr>
													</tfoot>
												</table>												
												
											</div>
										
											
										</div>
										
										<div class="col-md-4">
											<h4 class="card-title">STUDENTS LIST</h4>
											<div class="table-responsive table-hover table-sales">
												<table id="goats-table" class="table table-striped table-bordered" style="width:100%">
													<thead>
														<tr>
															<th>NAME</th>
															<th>SELECT</th>
														</tr>
													</thead>
													<tbody>
														@foreach($students as $key=>$student) 
															<tr style="cursor:pointer" value="">
																<td>{{$student->first_name .' '. $student->last_name }}</td>
																<td><input type="checkbox" class="form-check-input ml-0 check-stud" id="{{$student->id}}" ></td>
															</tr>
														@endforeach
													</tbody>
													<tfoot>
														<tr>
															<th>NAME</th>
															<th>SELECT</th>
														</tr>
													</tfoot>
												</table>												
												
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
	stud_group_id =0;
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});

	
	
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
		
		
		
	$(document).on('change', '.check-stud', function(event)
	{
		
		stud_checked = $(this).is(':checked') ? 1 : 0;
		stud_id = $(this).attr('id');
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 

		var url_var =  APP_URL + '/allocate_stud_in_group';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['stud_checked'] = stud_checked;
		data['stud_group_id'] = $('#stud_group_id').val();
		
		data['student_id'] = stud_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
						//alert(result_data);
				   refill_studs_in_group();
				   /*
				   if(result_data ==0)
				   {
						alert('User Already Exists.');
				   }
				   else
				   {
						alert('Successfully registered.');
				   }
				   */
				}
			});
			
			
		
	});
		
		
		
		
	$(document).on('change', '#stud_group_id', function()
	{
		stud_group_id = $(this).val();
		refill_studs_in_group();			
				
	});
		
		
		
		
		

	});
	
	
	function refill_studs_in_group()
	{

		var	url_var = APP_URL + '/get_studs_by_group_id';
		
		var data = {};
		data['stud_group_id'] = stud_group_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   
				    $("#stud-in-group-table tbody").empty();
					
				   for (i = 0; i < result_data.length; i++) 
				   {
						
						 var tr_ledger = '<tr style="cursor:pointer" value="">'+
												'<td>' + ( i+1) + '</td>'+
												'<td>'+ result_data[i].first_name +'</td>'+
											'</tr>';

					   
					   $("#stud-in-group-table tbody").append(tr_ledger);
					   
				   }
				   
				   
							
				}
			});

	}	

	
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