<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$parent_relationships =  app()->call([$cc, 'get_parent_relationships']);
$guardian_employers =  app()->call([$cc, 'get_guardian_employers']);
$districts =  app()->call([$cc, 'get_districts']);
$blood_groups =  app()->call([$cc, 'get_blood_groups']);
$physical_statuses =  app()->call([$cc, 'get_physical_statuses']);

?>
<script>
$(document).ready(function() 
{
	
	APP_URL = "{{ url('/') }}";		
	
	profile_user_id = "{{ Session::get('student_id_being_updated') }}";
	
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
	dirtarget = 'pk-uploads/profile-pic/' + profile_user_id ;
	$('.dirtarget').val(dirtarget);	
	$('.profile_user_id').val(profile_user_id);	
	
	
	$(document).on('change', '#inputfiles', function() 
	{
		
		if(confirm('Are you sure to Update this Image ?'))
		{
			showimages(this);
			upload_profile_pic();
		}
			
	});	
	
	
	$(document).on('change', '#stud_disease', function() 
	{
		if($(this).val() == 1)
		{
			$('#div-disease_details').show(500);
		}
		else
		{
			$('#div-disease_details').hide(500);
		}
	});	
	
	
	
});




 function showimages(input) 
	{
		if (input.files && input.files[0]) 
		{
			var i=0;
			var src='';
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
		
			var myform = document.getElementById("students-form");
			
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


</script>


			<div class="row pb-90">
                <div class="col-md-8 m-auto">
                    <div class="card p-60">
                        <div class="row">
                            <div class="col-md-8 text-center m-auto mb-20">
                                <h1 style="font-size: 24px;">Bio</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.</p>
                            </div>
                            <div class="col-md-12">
							
                                <form class="students-form" id="students-form" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="image[]" id="inputfiles" accept=".png, .jpg, .jpeg" />
                                                    <label for="inputfiles"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);">
													
                                                    </div>
                                                </div>
                                            </div>
											<input type="hidden" name="dirtarget" id="dirtarget_docs" class="form-control dirtarget" placeholder="Add Title">
											<input type="hidden" name="profile_user_id" id="" class="form-control profile_user_id" >
                                        </div>
                                    </div>
									
									
									
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="father_name">Name of Father</label>
                                            <input type="text" class="form-control" id="father_name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="father_phone">Phone No.</label>
                                            <input type="text" class="form-control" id="father_phone" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="father_job">Job</label>
                                            <input type="text" class="form-control" id="father_job">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="mother_name">Name of Mother</label>
                                            <input type="text" class="form-control" id="mother_name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mother_phone">Phone No.</label>
                                            <input type="text" class="form-control" id="mother_phone" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mother_job">Job</label>
                                            <input type="text" class="form-control" id="mother_job">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="guardian_name">Name of Guardian</label>
                                            <input type="text" class="form-control" id="guardian_name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="guardian_phone">Phone No.</label>
                                            <input type="text" class="form-control" id="guardian_phone" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="guardian_job">Job</label>
                                            <input type="text" class="form-control" id="guardian_job">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="father_emp_ctg_id">Employer (Father)</label>
                                            <select id="father_emp_ctg_id" class="form-control">
												@foreach($guardian_employers as $key=>$guardian_employer) 
													<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
												@endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mother_emp_ctg_id">Employer (Mother)</label>
                                            <select id="mother_emp_ctg_id" class="form-control">
												@foreach($guardian_employers as $key=>$guardian_employer) 
													<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
												@endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="guardian_emp_ctg_id">Employer (Guardian)</label>
                                            <select id="guardian_emp_ctg_id" class="form-control">
												@foreach($guardian_employers as $key=>$guardian_employer) 
													<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
												@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
										<div class="form-group col-md-6">
											<label for="house_address">Home Address</label>
											<textarea class="form-control" id="house_address" style="height:40px;" rows="2"></textarea>

										</div>
                                        <div class="form-group col-md-6">
                                            <label for="location">Panchayath</label>
											<input type="text" class="form-control" id="house_panchayath">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="housename">Block</label>
											<input type="text" class="form-control" id="house_block">
                                        </div>
																				
										<div class="form-group col-md-4">
											<label for="parent_email">District</label>
											<select id="house_district_id" class="form-control">
												@foreach($districts as $key=>$district) 
													<option value="{{$district->id}}">{{$district->district}}</option>
												@endforeach
											</select>
										</div>
										
                                        <div class="form-group col-md-4">
                                            <label for="pin">PIN Code</label>
											<input type="text" class="form-control" id="house_pin" maxlength="6">
                                        </div>
										
                                    </div>
                                    <div class="form-row">
										
                                        <div class="form-group col-md-4">
                                            <label for="stud_blood_group_id">Blood Group</label>
                                            <select id="stud_blood_group_id" class="form-control">
        										@foreach($blood_groups as $key=>$blood_group) 
        											<option value="{{$blood_group->id}}">{{$blood_group->blood_group}}</option>
        										@endforeach
                                            </select>
                                        </div>
										
                                        <div class="form-group col-md-4">
                                            <label for="stud_height">Height ( CMs )</label>
                                            <input type="number" class="form-control" id="stud_height">
                                        </div>
										
                                        <div class="form-group col-md-4">
                                            <label for="stud_weight">Weight ( Kg )</label>
                                            <input type="number" class="form-control" id="stud_weight">
                                        </div>
                                    </div>
                                    <div class="form-row">
										
                                        <div class="form-group col-md-6">
                                            <label for="stud_physical_status_id">Physical Status</label>
                                            <select id="stud_physical_status_id" class="form-control">
        										@foreach($physical_statuses as $key=>$physical_status) 
        											<option value="{{$physical_status->id}}">{{$physical_status->physical_status}}</option>
        										@endforeach
                                            </select>
                                        </div>
										
										
                                        <div class="form-group col-md-6">
                                            <label for="stud_disease">Have any Chronic Diseases</label>
                                            <select id="stud_disease" class="form-control">
                                                <option value="0" selected>No</option>
                                                <option  value="1" >Yes</option>
                                            </select>
                                        </div>
										
        								<div class="form-group col-md-12" style="display:none;" id="div-disease_details">
                                            <label for="city">Disease Details</label>
                                            <textarea class="form-control" id="stud_disease_details" rows="3"></textarea>
                                            
        
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="whatsapp_1" class="required" >WhatsApp Number 1</label>
                                            <input type="text" class="form-control" id="whatsapp_1" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="whatsapp_2" >WhatsApp Number 2</label>
                                            <input type="text" class="form-control" id="whatsapp_2" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email_id" class="required">Email ID</label>
                                            <input type="text" class="form-control" id="email_id" >
                                        </div>
                                    </div>
									
                                    <p style="color: blue;font-weight: bold;">If any others from your family in ela school</p>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="other_member_name">Name</label>
                                            <input type="text" class="form-control" id="other_member_name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="other_member_std">Class</label>
                                            <input type="text" class="form-control" id="other_member_std">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="other_member_rel">Relation Ship</label>
                                            <input type="text" class="form-control" id="other_member_rel">
                                        </div>
                                    </div>
									
									<!--
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="guardian" class="required">Comments if any</label>
                                            <input type="text" class="form-control" id="guardian">
                                        </div>
                                    </div>
									-->
									
									<a href="#" type="" class="btn btn-primary" id="a-continue-3">Complete</a>
                                </form>
							
							
                            </div>
                        </div>
                    </div>
                </div>
            </div>
