@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$students =  app()->call([$cc, 'get_students']);
$stud_groups =  app()->call([$cc, 'get_stud_groups']);
$subjects =  app()->call([$cc, 'get_subjects']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);

?>

<script>
$(document).ready(function() {
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
	APP_URL = "{{ url('/') }}";		

		
	activity_id = 0; 
	room_id = 0;
	count_video_files = 0;
	count_audio_files = 0;
	count_docs_files = 0;
	
	
	
	$('#description').val('');
    //$('#goats-table').DataTable();
	
	//$('#div-parent').load("add-media");
	
		
	
	
} );
					

	$(document).on('click', '#btn-continue-to-send, #btn-skip-to-send', function(event)
	{	
		event.preventDefault();
		
		$(".tab-pane-media").removeClass("show");
		$(".tab-pane-media").removeClass("active");
		$("#send").addClass("show");
		$("#send").addClass("active");
		$(".nav-link-media").removeClass("active");
		$("#send-tab").addClass("active");
		
		
	});



	$(document).on('click', '#btn-send-for-approval', function(event)
	{
					 
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/insert_send_for_approval';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['subject_id'] = $('#subject_id').val();
		//data['stud_grade_id'] = $('#stud_grade_id').val();
		data['tentated_publish_date'] = $('#tentated_publish_date').val();
		data['room_id'] = room_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data, 
		   async:false,
		   success:function(result_data)
			   {
						alert('Sent Successfully.');
						window.location.href =  APP_URL + '/mentor/dashboard';
				}
			});
			
			
		
	});


	$(document).on('change', '.check-stud', function(event)
	{
		
		stud_checked = $(this).is(':checked') ? 1 : 0;
		stud_id = $(this).attr('id');
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/allocate_student_in_activity';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['stud_checked'] = stud_checked;
		data['activity_id'] = activity_id;
		data['student_id'] = stud_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
						//alert(result_data);
						room_id = result_data;
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
	
	
	$(document).on('change', '.check-group', function(event)
	{
		
		group_checked = $(this).is(':checked') ? 1 : 0;
		stud_group_id = $(this).attr('id');
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/allocate_group_in_activity';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['group_checked'] = group_checked;
		data['activity_id'] = activity_id;
		data['stud_group_id'] = stud_group_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
						room_id = result_data;
				   
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


	$(document).on('change', '.inp-files', function()
	{
		var inp_file_type = $(this).attr('id');
		/*
			if(this.files[0].size > 4250000)
			{
				alert("File is too big!. Allowed size 4MB");
				this.value = "";
			};
 		*/
			var names = [];
			for (var i = 0; i < $(this).get(0).files.length; ++i) 
			{
				names.push($(this).get(0).files[i].name );
			}
			
			if(inp_file_type == 'inputfiles_video')
			{
				$("#label_video").text(names.join(', '));
				count_video_files = names.length;
				
			}
			else if(inp_file_type == 'inputfiles_audio')
			{
				$("#label_audio").text(names.join(', '));
				count_audio_files = names.length;
			}
			else if(inp_file_type == 'inputfiles_docs')
			{
				$("#label_docs").text(names.join(', '));
				count_docs_files = names.length;
			}
	
	});	



	$(document).on('click', '#btn-continue-to-invite-students', function(event)
	{	
		event.preventDefault();
		
			
		if(count_video_files > 0 || count_audio_files > 0 || count_docs_files > 0)	
		{
			upload_act_acs_video();
		}
		else
		{
			alert('Select at least one file.');
		}
			
		
	});

	
	$(document).on('click', '#btn-continue-to-media', function(event)
	{
		event.preventDefault();

		if(!$('#activity_title').val())
		{
			alert('Please enter Activity Title.');
		}
		else if(!$('#description').val())
		{
			alert('Please enter Description.');
		}
		else
		{
			if(confirm("Are you sure to Update ?"))
			{
				insert_activity_content();
				
				$(".tab-pane-media").removeClass("show");
				$(".tab-pane-media").removeClass("active");
				$("#add-media").addClass("show");
				$("#add-media").addClass("active");
				$(".nav-link-media").removeClass("active");
				$("#add-media-tab").addClass("active");
			}
		}
		
		
	});
	
	
	function insert_activity_content()
	{

		var	url_var = APP_URL + '/insert_activity_content';
		
		var data = {};
		data['activity_title'] = $('#activity_title').val();
		data['description'] = $('#description').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   activity_id = result_data;
				   
				   	dirtarget = '/pk-uploads/act-acs/' + activity_id + '/';
					$('.dirtarget').val(dirtarget);	
					$('.act_id').val(activity_id);	

				}
			});
			
	}
	
	/*
	function upload_act_acs(act_acs_type)
		{
			APP_URL = "{{ url('/') }}";		
			
			
			
			$('#loaderModal').modal({
					backdrop: 'static',
					keyboard: false
				})
			
			
			if(act_acs_type=='video')
			{
				
				//url_now = APP_URL + '/upload_act_acs_videos';
				var myform = document.getElementById("form-video");
			}
			else if(act_acs_type=='audio')
			{
				//url_now = APP_URL + '/upload_act_acs_audios';
				var myform = document.getElementById("form-audio");
			}
			else if(act_acs_type=='docs')
			{
				//url_now = APP_URL + '/upload_act_acs_docs';
				var myform = document.getElementById("form-docs");
			}
							

			url_now = APP_URL + '/upload_act_acs';

			var fd = new FormData(myform );
			//console.log(fd);
			$.ajax({
				url: url_now,
				data: fd,
				cache: false,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function (dataofconfirm) 
				{
					// do something with the result
					//alert("Files uploaded successfully.");
					//hideLoader();
				},
				complete: function()
				{
					$('#loaderModal').modal('hide');	
				}
	  
			});

		}
	*/	 
		
	function upload_act_acs_video()
		{
			APP_URL = "{{ url('/') }}";		
			
			
			url_now = APP_URL + '/upload_act_acs';
							
			var myform = document.getElementById("form-video");
			var fd = new FormData(myform );
			
			//console.log(fd);
			$.ajax({
				url: url_now,
				data: fd,
				cache: false,
				processData: false,
				contentType: false,
				type: 'POST',
				beforeSend: function()
				{
					$('#loaderModal').modal({ backdrop: 'static', keyboard: false });
				},
				success: function (dataofconfirm) 
				{
					upload_act_acs_audio();
				},
				error: function()
				{
					
					upload_act_acs_audio();
					
				}
	  
			});

		}
		
		
	function upload_act_acs_audio()
		{
			APP_URL = "{{ url('/') }}";		
			url_now = APP_URL + '/upload_act_acs';
			
			var myform = document.getElementById("form-audio");
			var fd = new FormData(myform );
			
				$.ajax({
					url: url_now,
					data: fd,
					cache: false,
					processData: false,
					contentType: false,
					type: 'POST',
					beforeSend: function()
					{
						//$('#loaderModal').modal({ backdrop: 'static', keyboard: false });
					},
					success: function (dataofconfirm) 
					{
						upload_act_acs_docs();
					},
					error: function()
					{
						upload_act_acs_docs();
					}
		  
				});
					
					
					
		}
		
		
	function upload_act_acs_docs()
		{
			APP_URL = "{{ url('/') }}";		
			
			
			url_now = APP_URL + '/upload_act_acs';
							
			
					var myform = document.getElementById("form-docs");
					var fd = new FormData(myform );
					$.ajax({
						url: url_now,
						data: fd,
						cache: false,
						processData: false,
						contentType: false,
						type: 'POST',
						beforeSend: function()
						{
							//$('#loaderModal').modal({ backdrop: 'static', keyboard: false });
						},
						success: function (dataofconfirm) 
						{
							$('#loaderModal').modal('hide');	
							$('#loadedAlertModal').modal({ backdrop: 'static', keyboard: false });
							window.location.reload;
						},
						error: function()
						{
							$('#loaderModal').modal('hide');	
							$('#loadedAlertModal').modal({ backdrop: 'static', keyboard: false });
							window.location.reload;
						}
			  
					});
		}
		
		
		
</script>
<body>
@include('mentor.layouts.ela-mentor-topbar')
<!--
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
            <!-- Navbar
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/tutor.png')}}" width="30"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
-->

    <main class="main students-login">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
				
                    <div class="col-9 d-flex">
                        <div class="profile mr-3">
                            <img src="{{asset('public/ela-assets/images/avatar.jpg')}}" class="img-fluid">
                        </div>
                        <div>
						<?php
							$first_name = strval(Auth::guard('ela_user')->user()->first_name);
							$last_name = Auth::guard('ela_user')->user()->last_name;
							$str = $first_name . ' ' . $last_name;
							$user_name = "";

							
								$array = array();
									$pattern = '/([;:,-.\/ X])/';
									$array = preg_split($pattern, $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

									foreach($array as $k => $v)
										$user_name .= ucwords(strtolower($v));



						?>
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Create New Activity</h3>
                            <p class="sub-text">Admin for ELA School</p>
                        </div>
                    </div>
					
                    <div class="col-3 text-right">
                        <button type="button" class="btn btn-outline-lighter text-dark">Edit User
                            <img src="{{asset('public/ela-assets/images/filter.svg')}}" />
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="row pt-30 pb-90">
                <div class="col-md-12">
                    <div class="card sidebar-tab">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="left-ul-wrap">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" >
                                            <a class="nav-link nav-link-media active" id="home-tab"><span>1.</span> Content</a>
                                        </li>
                                        <li class="nav-item" >
                                            <a class="nav-link  nav-link-media" id="add-media-tab" ><span>2.</span> Add Media</a>
                                        </li>
										<!--
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><span>3.</span> Invite Students</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#publish" role="tab" aria-controls="contact" aria-selected="false"><span>4.</span> Publish</a>
                                        </li>
										-->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-5">
							

                                <div class="tab-content" id="myTabContent"> 
								
									
									
                                    <div class="tab-pane tab-pane-media fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <form>
                                            <div class="form-group">
                                                <input type="headline" class="form-control" aria-describedby="Add a headline" placeholder="Enter Activity Title"  id="activity_title">
                                                <small id="headline" class="form-text text-muted">Eg: Newton’s first law of motion explained.</small>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="description" rows="6" placeholder="Add description"></textarea>
                                                <small id="headline" class="form-text text-muted">500 Characters minimum</small>
                                            </div>
  
											<button id="btn-continue-to-media" class="btn btn-primary">Continue</button>

                                        </form>
                                    </div>
                                    <div class="tab-pane tab-pane-media fade" id="add-media" role="tabpanel" aria-labelledby="add-media-tab">
                                        <div class="col-sm-12 p-4">
										
											
                                            <form enctype="multipart/form-data" id="form-video" >
                                                <div class="form-group">
                                                    <label><strong>Video Content</strong></label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image[]" multiple class="custom-file-input form-control inp-files" id="inputfiles_video"  accept="video/*">
                                                        <label class="custom-file-label" for="customFile"  id="label_video">Upload from your computer</label>
														<input type="hidden" name="dirtarget" id="dirtarget_video" class="form-control dirtarget" placeholder="Add Title">
														<input type="hidden" name="acs_type" id="" class="form-control acs-type" value="video">
														<input type="hidden" name="act_id" id="" class="form-control act_id" >
                                                    </div>
													
													
                                                </div>
											</form>	
											
                                            <form  enctype="multipart/form-data" id="form-audio" >
                                                <div class="form-group">
                                                    <label><strong>Audio Content</strong></label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image[]" multiple class="custom-file-input form-control inp-files" id="inputfiles_audio" accept="audio/*">
                                                        <label class="custom-file-label" for="customFile" id="label_audio">Upload from your computer</label>
														<input type="hidden" name="dirtarget" id="dirtarget_audio" class="form-control dirtarget" placeholder="Add Title">
														<input type="hidden" name="acs_type" id="" class="form-control acs-type" value="audio">
														<input type="hidden" name="act_id" id="" class="form-control act_id" >
                                                    </div>
													
													
                                                </div>
											</form>
                                            <form  enctype="multipart/form-data" id="form-docs" >
                                                <div class="form-group">
                                                    <label><strong>Document Content</strong></label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image[]" multiple class="custom-file-input form-control inp-files" id="inputfiles_docs" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*">
                                                        <label class="custom-file-label" for="customFile" id="label_docs">Upload from your computer</label>
														<input type="hidden" name="dirtarget" id="dirtarget_docs" class="form-control dirtarget" placeholder="Add Title">
														<input type="hidden" name="acs_type" id="" class="form-control acs-type" value="docs">
														<input type="hidden" name="act_id" id="" class="form-control act_id" >
                                                    </div>
													
													  
                                                </div>
											</form>	
                                                <button class="btn btn-primary" id="btn-continue-to-invite-students">Continue</button>
                                                <button  class="btn btn-secondary" id="btn-skip">Skip</button>
												
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane tab-pane-media fade" id="invite-stud" role="tabpanel" aria-labelledby="contact-tab">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Individuals</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Group</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content pl-0 pr-0 pt-0 pb-0" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                <div class="row mt-30 mb-30">
                                                    <div class="input-group col-md-8 search">
                                                        <input class="form-control py-2" type="search" value="search" id="example-search-input">
                                                        <span class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-control" id="exampleFormControlSelect1">
                                                            <option>Grade VIII</option>
                                                            <option>Grade VIII</option>
                                                            <option>Grade VIII</option>
                                                        </select>
                                                    </div>
                                                </div>
												
                                                <div class="row students-lists">
												
													@foreach($students as $key=>$student) 
                                                    <div class="col-md-12 single-student">
                                                        <div class="student-pic" style="background: url({{asset('public/ela-assets/images/s1.png')}});"></div>
                                                        <div class="name">
                                                            {{$student->first_name .' '. $student->last_name }}
                                                            <span>Grade VIII</span>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input check-stud" value="" id="{{$student->id}}">
                                                            </label>
                                                        </div>
                                                    </div>
													@endforeach
													
                                                    
                                                </div>
                                             
												
												
												
                                            </div>
                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
											
                                                <div class="row mt-30 mb-30">
                                                    <div class="input-group col-md-8 search">
                                                        <input class="form-control py-2" type="search" value="search" id="example-search-input">
                                                        <span class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-control" id="exampleFormControlSelect1">
                                                            <option>Grade VIII</option>
                                                            <option>Grade VIII</option>
                                                            <option>Grade VIII</option>
                                                        </select>
                                                    </div>
                                                </div>
												
                                                <div class="row students-lists">
												
													@foreach($stud_groups as $key=>$stud_group) 
                                                    <div class="col-md-12 single-student">
                                                        <div class="student-pic" style="background: url({{asset('public/ela-assets/images/s1.png')}});"></div>
                                                        <div class="name">
                                                            {{$stud_group->stud_group  }}
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input check-group " value="" id="{{$stud_group->id}}">
                                                            </label>
                                                        </div>
                                                    </div>
													@endforeach
													
                                                    
                                                </div>
											    
											
											
											
											</div>
											<div class="row mt-20">
										        <div class="col-md-12">
                                                    <button class="btn btn-primary" id="btn-continue-to-send">Continue</button>
                                                    <button class="btn btn-secondary" id="btn-skip-to-send">Skip</button>
                                                </div>
										    </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane tab-pane-media fade" id="send" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <form>
                                            <div class="form-group">
                                                <label><strong>Activity for</strong></label>
                                                <select class="form-control" id="subject_id" multiple>
                                                    <!--<option>Choose Subject</option>-->
													@foreach($subjects as $key=>$subject) 
														<option value="{{$subject->id}}">{{$subject->subject}}</option>
													@endforeach
                                                </select>
                                            </div>
											<!--
                                            <div class="form-group">
                                                <label><strong>Grades</strong></label>
                                                <select class="form-control" id="stud_grade_id" multiple>
                                                    <option>Choose Grades</option>
													@foreach($stud_grades as $key=>$stud_grade) 
														<option value="{{$stud_grade->id}}">{{$stud_grade->stud_grade}}</option>
													@endforeach
                                                </select>
                                                <small id="headline" class="form-text text-muted">Multiple grades can be seperated by Comma.</small>
                                            </div>
											-->
											<div class="form-group mt-1">
												<div class="input-group-append">
													<div class="">
														<label class="form-check-label " for="tentated_publish_date" id="lbl-mated" >Tentative Publish Date</label>
													</div>
												</div>
												<input  type="date" class="form-control mt-1"  id="tentated_publish_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
																								
											</div>
											
                                            <hr>
                                            <a class="btn btn-primary" id="btn-send-for-approval">Continue</a>
                                            <a href="#" class="btn btn-secondary" data-toggle="modal" data-target=".bd-example-modal-lg">Preview</a>

                                            <p style="font-size: 12px;" class="mt-20">Your request to publish will be moderated by admin.<br> You’ll be notified once it’s done.</p>
                                        </form>
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg  modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Displacement, velocity, and time
                                                                    <span>For Grade VIII</span>
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h5 class="modal-second-title" id="myLargeModalLabel">Subject
                                                                    <span>Physics</span>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-tabs">
                                                            <li><a data-toggle="tab" href="#menu1" class="active show">Video</a></li>
                                                            <li><a data-toggle="tab" href="#menu2">Audio</a></li>
                                                            <li><a data-toggle="tab" href="#menu3">PDF</a></li>
                                                        </ul>

                                                        <div class="tab-content">
                                                            <div id="menu1" class="tab-pane fade  active show">
                                                                <div class="video-wrap">
                                                                    <video width="100%" controls poster="images/vid.jpg">
                                                                        <source src="{{asset('public/ela-assets/images/mov_bbb.mp4')}}" type="video/mp4">
                                                                        <source src="mov_bbb.ogg" type="video/ogg">
                                                                    </video>
                                                                </div>
                                                                <h3 class="pt-30">
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                </h3>
                                                                <p>
                                                                    Nam consectetur quam id erat pretium, ut tincidunt diam imperdiet. In ac tincidunt turpis.
                                                                    Nulla consequat tortor a porta viverra.
                                                                </p>
                                                                <p>
                                                                    Sed ut purus euismod, auctor neque ac, vestibulum libero. Vivamus sagittis lectus nec ultricies ultrices. Etiam rutrum porttitor vulputate. In nulla urna, molestie id sapien sit amet, porta sollicitudin purus. Donec laoreet magna ut tellus maximus suscipit. Aenean nec tincidunt dui, vel euismod magna.
                                                                </p>
                                                            </div>
                                                            <div id="menu2" class="tab-pane fade">
                                                                <h3>Menu 2</h3>
                                                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                                            </div>
                                                            <div id="menu3" class="tab-pane fade">
                                                                <h3>Menu 3</h3>
                                                                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="right-list-wrap">
                                    <div class="form-group">
                                        <label for="choose1">Or, select from Activity Library</label>
                                        <select class="form-control" id="choose1">
                                            <option>Choose Subject</option>
                                            <option>Choose Subject</option>
                                            <option>Choose Subject</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="input-group search">
                                            <input class="form-control py-2" type="search" value="search" id="example-search-input">
                                            <span class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <ul class="subject-grade">
                                        <li>
                                            <a href="#">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                <strong> Ipsum Dolor Sit Amet
                                                    <span>Grade IX Chemistry</span>
                                                </strong>
                                                <span class="date-area">
                                                    12 Aug
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                <strong> Ipsum Dolor Sit Amet
                                                    <span>Grade IX Chemistry</span>
                                                </strong>
                                                <span class="date-area">
                                                    12 Aug
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                                                <strong> Ipsum Dolor Sit Amet
                                                    <span>Grade IX Chemistry</span>
                                                </strong>
                                                <span class="date-area">
                                                    12 Aug
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                                                <strong> Ipsum Dolor Sit Amet
                                                    <span>Grade IX Chemistry</span>
                                                </strong>
                                                <span class="date-area">
                                                    12 Aug
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5" value="option5">
                                                <strong> Ipsum Dolor Sit Amet
                                                    <span>Grade IX Chemistry</span>
                                                </strong>
                                                <span class="date-area">
                                                    12 Aug
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <a href="#" class="btn btn-secondary">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
	 <!-- The Modal -->
	 
	@include('layouts.loader-modal')
	@include('layouts.loaded-alert-modal')

<!--
	  <div class="modal fade" id="loaderModal">
		<div class="modal-dialog">
		  <div class="modal-content">
			
			<!-- Modal body 
			<div class="modal-body text-center back-trans">
			  <h5 class="" style="color:#3230c3" id="loader-title">Please Wait...Uploading Media...</h5>
				<div  class="d-flex justify-content-center back-trans" >
					<div id="div-loader" class="spinner-grow text-warning" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
				</div>
			  
			  
			</div>
			
			
		  </div>
		</div>
	  </div>
 --> 
    <footer class="container-fluid bg-dard-blue">
        <div class="container pt-5 pb-5 text-light">
            <div class="row">
                <div class="col-md-12">
                    <p>© Effective Teachers 2020. All rights reserved.</p>
                    <img class="ml-auto logo" src="{{asset('public/ela-assets/images/logo-light.png')}}" width="40" height="25">
                </div>

            </div>
        </div>
    </footer>

	@include('layouts.ela-footer')

</body>

</html>