<script>
$(document).ready(function() 
{
	
	APP_URL = "{{ url('/') }}";		
	
	
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
	dirtarget = 'pk-uploads/profile-pic/' + student_id ;
	$('.dirtarget').val(dirtarget);	
	$('.profile_user_id').val(student_id);	
	
	
	$(document).on('change', '#inputfiles', function() 
	{
		
		if(confirm('Are you sure to Update this Image ?'))
		{
			showimages(this);
			upload_profile_pic();
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
				alert("Profile Image updated successfully.");
				//hideLoader();
								location.reload();

			}
		});

	}


</script>
	
	<div class="modal fade bd-example-modal-lg2" id="modal-editstudent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg  modal-dialog-centered">
	  <div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-7">
						<h4 class="modal-title" id="myLargeModalLabel">Edit User
						</h4>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
                    <form class="students-form" id="students-form" enctype="multipart/form-data"  style="max-width: 100%;">
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
						
						
							<div class="form-group col-md-6">
								<label for="reg_number">Registration No. ( User Name )</label>
								<input type="text" class="form-control" id="reg_number" readonly>
								<span id="alert-reg-number-existing" style="color:#F44336;font-size:12px; display:none;">Registor no is already existing. Please enter a unique reg. no.</span>
							</div>
							<div class="form-group col-md-6">
								<label for="stud_grade_id">ELA School Grade</label>
								<select id="stud_grade_id" class="form-control" disabled>
									@foreach($stud_grades as $key=>$stud_grade) 
										<option value="{{$stud_grade->id}}">{{$stud_grade->stud_grade}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-12 text-right">
								<!--<div class="form-check-inline">-->   
								<!--  <label class="form-check-label" for="check1">-->
								<!--    <input type="checkbox" class="form-check-input" id="check1" name="vehicle1" value="something" checked>Approve-->
								<!--  </label>-->
								<!--</div>
								<div class="form-check-inline">
								  <label class="form-check-label" for="approved">
									<input type="checkbox" class="form-check-input" id="approved" name="vehicle2" value="something">Approve
								  </label>
								</div>
								<a class="btn btn-primary" id="btn-approve">Apply</a>
								-->
							</div>
							
							
						</div>
						<hr>
						<div class="form-row">
						
		<!--======================================================== BASICS ========================================================================================-->					
							<div class="form-group col-md-4">
								<label for="firstname">First Name</label>
								<input type="text" class="form-control" id="edit_first_name">
							</div>
							<div class="form-group col-md-4">
								<label for="lastname">Last Name</label>
								<input type="text" class="form-control" id="edit_last_name">
							</div>
							<div class="form-group col-md-4">
								<label for="gender">Gender</label>
								<select id="edit_gender_id" class="form-control">
									@foreach($genders as $key=>$gender) 
										<option value="{{$gender->id}}">{{$gender->gender}}</option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-4 mt-1">
								<div class="input-group-append">
									<div class="">
										<label class="form-check-label " for="stud_dob" id="lbl-mated" >Date of Birth</label>
									</div>
								</div>
								<input  type="date" class="form-control mt-1"  id="edit_stud_dob" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
							</div>
							
		<!--======================================================== A C A D E M I C S ========================================================================================-->					
							
							<?php
								$standards = DB::table('standards')
									->whereNull('deleted_at')
									->get();
							?>							
							<div class="form-group col-md-4">
								<label for="instruction">Class</label>
								<select id="edit_standard_id" class="form-control">
									@foreach($standards as $key=>$standard) 
										<option value="{{$standard->id}}">{{$standard->standard}}</option>
									@endforeach
								</select>
							</div>
							<?php
								$mediums = DB::table('mediums')
									->whereNull('deleted_at')
									->get();
							?>							
							<div class="form-group col-md-4">
								<label for="instruction">Medium of Instruction</label>
								<select id="edit_medium_id" class="form-control">
									@foreach($mediums as $key=>$medium) 
										<option value="{{$medium->id}}">{{$medium->medium}}</option>
									@endforeach
								</select>
							</div>
							
							<?php
								$syllabuses = DB::table('syllabuses')
									->whereNull('deleted_at')
									->get();
							?>							
							<div class="form-group col-md-4">
								<label for="syllabus">Syllabus</label>
								<select id="edit_syllabus_id" class="form-control">
									@foreach($syllabuses as $key=>$syllabus) 
										<option value="{{$syllabus->id}}">{{$syllabus->syllabus}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-8">
								<label for="school">Name of the School</label>
								<input type="text" class="form-control" id="edit_school_name">
							</div>
							
							<?php
								$districts = DB::table('districts')
									->whereNull('deleted_at')
									->get();
							?>		
							<div class="form-group col-md-8">
								<label for="city">School - Address</label>
								<textarea class="form-control" id="edit_school_address" rows="2" style="height:40px;"></textarea>
								

							</div>
							<div class="form-group col-md-4">
								<label for="city">School - Management</label>
								<select id="edit_school_manage_category_id" class="form-control">
									@foreach($school_manage_categories as $key=>$school_manage_category) 
										<option value="{{$school_manage_category->id}}">{{$school_manage_category->school_manage_category}}</option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-4">
								<label for="city">School Sub. District</label>
								<input type="text" class="form-control" id="edit_school_sub_district">
							</div>
							
							<div class="form-group col-md-4">
								<label for="city">School Edl. District</label>
								<input type="text" class="form-control" id="edit_school_edu_district">
							</div>
							
							<div class="form-group col-md-4">
							<?php
								$districts = DB::table('districts')
									->whereNull('deleted_at')
									->get();
							?>		
								<label for="district">School Rev. District</label>
								<select id="edit_school_district_id" class="form-control">
									@foreach($districts as $key=>$district) 
										<option value="{{$district->id}}">{{$district->district}}</option>
									@endforeach
								</select>
							</div>
							
		<!--======================================================== B I O ========================================================================================-->
							<div class="form-group col-md-4">
								<label for="father_name">Name of Father</label>
								<input type="text" class="form-control" id="edit_father_name">
							</div>
							<div class="form-group col-md-4">
								<label for="father_phone">Phone No.</label>
								<input type="text" class="form-control" id="edit_father_phone" maxlength="10">
							</div>
							<div class="form-group col-md-4">
								<label for="father_job">Job</label>
								<input type="text" class="form-control" id="edit_father_job">
							</div>
		
							<div class="form-group col-md-4">
								<label for="mother_name">Name of Mother</label>
								<input type="text" class="form-control" id="edit_mother_name">
							</div>
							<div class="form-group col-md-4">
								<label for="mother_phone">Phone No.</label>
								<input type="text" class="form-control" id="edit_mother_phone" maxlength="10">
							</div>
							<div class="form-group col-md-4">
								<label for="mother_job">Job</label>
								<input type="text" class="form-control" id="edit_mother_job">
							</div>
							
							<div class="form-group col-md-4">
								<label for="guardian_name">Name of Guardian</label>
								<input type="text" class="form-control" id="edit_guardian_name">
							</div>
							<div class="form-group col-md-4">
								<label for="guardian_phone">Phone No.</label>
								<input type="text" class="form-control" id="edit_guardian_phone" maxlength="10">
							</div>
							<div class="form-group col-md-4">
								<label for="guardian_job">Job</label>
								<input type="text" class="form-control" id="edit_guardian_job">
							</div>
																						
							<div class="form-group col-md-4">
								<label for="father_emp_ctg_id">Employer (Father)</label>
								<select id="edit_father_emp_ctg_id" class="form-control">
									@foreach($guardian_employers as $key=>$guardian_employer) 
										<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-4">
								<label for="mother_emp_ctg_id">Employer (Mother)</label>
								<select id="edit_mother_emp_ctg_id" class="form-control">
									@foreach($guardian_employers as $key=>$guardian_employer) 
										<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-4">
								<label for="guardian_emp_ctg_id">Employer (Guardian)</label>
								<select id="edit_guardian_emp_ctg_id" class="form-control">
									@foreach($guardian_employers as $key=>$guardian_employer) 
										<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-4">
								<label for="house_address">Home Address</label>
								<textarea class="form-control" id="edit_house_address" rows="2" style="height:40px;"></textarea>

							</div>
							
							<div class="form-group col-md-4">
								<label for="location">Panchayath</label>
								<input type="text" class="form-control" id="edit_house_panchayath">
							</div>
							
							<div class="form-group col-md-4">
								<label for="housename">Block</label>
								<input type="text" class="form-control" id="edit_house_block">
							</div>
																	
							<div class="form-group col-md-4">
								<label for="parent_email">District</label>
								<select id="edit_house_district_id" class="form-control">
									@foreach($districts as $key=>$district) 
										<option value="{{$district->id}}">{{$district->district}}</option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-4">
								<label for="pin">PIN Code</label>
								<input type="text" class="form-control" id="edit_house_pin" maxlength="6">
							</div>
							
							<div class="form-group col-md-4">
								<label for="stud_blood_group_id">Blood Group</label>
								<select id="edit_stud_blood_group_id" class="form-control">
									@foreach($blood_groups as $key=>$blood_group) 
										<option value="{{$blood_group->id}}">{{$blood_group->blood_group}}</option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-4">
								<label for="stud_height">Height ( CMs )</label>
								<input type="number" class="form-control" id="edit_stud_height">
							</div>
							
							<div class="form-group col-md-4">
								<label for="stud_weight">Weight ( Kg )</label>
								<input type="number" class="form-control" id="edit_stud_weight">
							</div>
							
							<div class="form-group col-md-4">
								<label for="stud_physical_status_id">Physical Status</label>
								<select id="edit_stud_physical_status_id" class="form-control">
									@foreach($physical_statuses as $key=>$physical_status) 
										<option value="{{$physical_status->id}}">{{$physical_status->physical_status}}</option>
									@endforeach
								</select>
							</div>
							
							
							<div class="form-group col-md-4">
								<label for="stud_disease">Have any Chronic Diseases</label>
								<select id="edit_stud_disease" class="form-control">
									<option value="0" selected>No</option>
									<option  value="1" >Yes</option>
								</select>
							</div>
							
							<div class="form-group col-md-8" style="" id="div-disease_details">
								<label for="city">Disease Details</label>
								<textarea class="form-control" id="edit_stud_disease_details" rows="3" style="height:40px;"></textarea>
								

							</div>
							
							<div class="form-group col-md-4">
								<label for="whatsapp_1" class="required" >WhatsApp Number 1</label>
								<input type="text" class="form-control" id="edit_whatsapp_1" maxlength="10">
							</div>
							<div class="form-group col-md-4">
								<label for="whatsapp_2">WhatsApp Number 2</label>
								<input type="text" class="form-control" id="edit_whatsapp_2" maxlength="10">
							</div>
							<div class="form-group col-md-4">
								<label for="email_id" class="required">Email ID</label>
								<input type="text" class="form-control" id="edit_email_id" >
							</div>
							
							<p style="color: blue;font-weight: bold;">If any others from your family in ela school</p>
							<hr>
							<div class="form-row" style="width:100%;">
								<div class="form-group col-md-4">
									<label for="other_member_name">Name</label>
									<input type="text" class="form-control" id="edit_other_member_name">
								</div>
								<div class="form-group col-md-4">
									<label for="other_member_std">Class</label>
									<input type="text" class="form-control" id="edit_other_member_std">
								</div>
								<div class="form-group col-md-4">
									<label for="other_member_rel">Relation Ship</label>
									<input type="text" class="form-control" id="edit_other_member_rel">
								</div>
							</div>
							
						  
							<div class="form-group col-md-12 text-right mt-10">
							<a id="a-update-edit-student" class="btn btn-primary">Submit</a>
							</div>
						</div>
						
						
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
