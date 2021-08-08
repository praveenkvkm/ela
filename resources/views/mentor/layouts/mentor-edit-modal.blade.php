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
		
		
	dirtarget = 'pk-uploads/profile-pic/' + mentor_id ;
	$('.dirtarget').val(dirtarget);	
	$('.profile_user_id').val(mentor_id);	
	
	
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
								<label for="firstname">First Name</label>
								<input type="text" class="form-control" id="first_name" value="">
							</div>
							<div class="form-group col-md-6">
								<label for="lastname">Last Name</label>
								<input type="text" class="form-control" id="last_name" value="">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="mobile">Mobile</label>
								<input type="text" class="form-control" id="mobile" value="">
							</div>
							<div class="form-group col-md-6"> 
								<label for="email">Email</label> 
								<input type="text" class="form-control" id="email" value="">
							</div>
						</div>
						
						<div class="form-row">
							
							<div class="form-group col-md-6">
								<label for="city">Residential Address</label>
								<textarea class="form-control" id="res_address" rows="3" style="height:40px;"></textarea>
							</div>
							
							<div class="form-group col-md-6">
								<label for="city">Official Address</label>
								<textarea class="form-control" id="off_address" rows="3" style="height:40px;"></textarea>
							</div>
							
						</div>
						
						<div class="form-row">
							
							<div class="form-group col-md-6"> 
								<label for="designation">Designation</label> 
								<input type="text" class="form-control" id="designation">
							</div>
							
							
						</div>
						
						<div class="form-row" style="display:none;">
							<div class="form-group col-md-6">
								<label for="gender">Mentor Type</label>
								<select id="mentor_type_id" class="form-control">
									@foreach($mentor_types as $key=>$mentor_type)  
									<option  value="{{$mentor_type->id}}">
										{{$mentor_type->mentor_type}}
									</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="gender">Mentor Category</label>
								<select id="mentor_category_id" class="form-control">
									@foreach($mentor_categories as $key=>$mentor_category)  
									<option value="{{$mentor_category->id}}"   >
										{{$mentor_category->mentor_category}}
									</option>
									@endforeach
								</select>
							</div>
						</div>
						<!--
						<div class="form-row" d>
							<div class="form-group col-md-6">
								<div class="form-check" id="div-active">
									<input type="checkbox" class="form-check-input" id="active"  >
									<label class="form-check-label" for="active">Active</label>
								</div>
							</div>
						</div>
						-->
						<a style="color:white;" id="a-update-edit-mentor" class="btn btn-primary float-right">Submit</a>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
