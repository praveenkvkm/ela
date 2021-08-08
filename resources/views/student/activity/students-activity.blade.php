<!DOCTYPE html>
<html lang="en">
<style>
.complete
{
    background: #fff;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #dfe4e9;
    min-height: 217px; 
}
</style>
@include('layouts.ela-header')
<?php
	$activity_master = $return_data['activity_master'];
	$act_acs_videos = $return_data['act_acs_videos'];
	$act_acs_audios = $return_data['act_acs_audios'];
	$act_acs_docs = $return_data['act_acs_docs'];
	$act_publish_details = $return_data['act_publishs'];
	
	$room_id = $return_data['room_id'];
	$student_id = Auth::guard('ela_user')->user()->id;
	
	$cc = app()->make('App\Http\Controllers\CommonController');
	$return_data =  app()->call([$cc, 'get_students_approved_activities']);
	$students_approved_activities_not_completed = $return_data['students_approved_activities_not_completed'];
	
	$count_student_media_uploads =  app()->call([$cc, 'get_count_student_media_uploads'], [$room_id, $student_id]);
	$student_media_uploads =  app()->call([$cc, 'get_student_media_uploads'], [$room_id, $student_id]);
	
	
	$video_acs_file_path = (count($act_acs_videos)>0) ? $act_acs_videos[0]->acs_file_path : ' ';
	$audio_acs_file_path = (count($act_acs_audios)>0) ? $act_acs_audios[0]->acs_file_path : ' ';
	$docs_acs_file_path = (count($act_acs_docs)>0) ? $act_acs_docs[0]->acs_file_path : ' ';
	
	$video_acs_file_name = (count($act_acs_videos)>0) ? $act_acs_videos[0]->acs_file_name : ' ';
	$audio_acs_file_name = (count($act_acs_audios)>0) ? $act_acs_audios[0]->acs_file_name : ' ';
	$docs_acs_file_name = (count($act_acs_docs)>0) ? $act_acs_docs[0]->acs_file_name : ' ';
	
	$video_path = url('/public') .$video_acs_file_path . $video_acs_file_name; 
	$audio_path = url('/public') . $audio_acs_file_path . $audio_acs_file_name ;
	/*$docs_path = url('/public') . $docs_acs_file_path . $docs_acs_file_name ;*/
	
	($docs_acs_file_name != ' ')? 	$docs_path = url('/public') . $docs_acs_file_path . $docs_acs_file_name : $docs_path ='';
	
?>
<script>
$(document).ready(function() {
	
	activity_id =0;
	room_id = '{{$room_id}}';
	student_id = '{{$student_id}}';
	publish_id = 0; 
	
	count_video_files = 0;
	count_audio_files = 0;
	count_docs_files = 0;
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		dirtarget = '/pk-uploads/stud_act_acs/' + 'rm-' + room_id + '/stud-' + student_id + '/';
		$('.dirtarget').val(dirtarget);	
		$('.room_id').val(room_id);	
	
		
	
	
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


	$(document).on('click', '.btn-upload', function(event)
	{
		event.preventDefault();
		act_acs_type = $(this).val();
		
			if(act_acs_type=='video')
			{
				(count_video_files > 0) ? upload_stud_act_acs(act_acs_type): alert('Select at least one file.');
			}
			else if(act_acs_type=='audio')
			{
				(count_audio_files > 0) ? upload_stud_act_acs(act_acs_type): alert('Select at least one file.');
			}
			else if(act_acs_type=='docs')
			{
				(count_docs_files > 0) ? upload_stud_act_acs(act_acs_type): alert('Select at least one file.');
			}
		
		
		/*
		if(count_video_files > 0)
		{
			upload_stud_act_acs(act_acs_type);
		}
		else
		{
			alert('Select at least one file.');
		}
		*/
		
		
	});



	function upload_stud_act_acs(act_acs_type)
		{
			APP_URL = "{{ url('/') }}";		
			
			if(act_acs_type=='video')
			{
				var myform = document.getElementById("form-video");
			}
			else if(act_acs_type=='audio')
			{
				var myform = document.getElementById("form-audio");
			}
			else if(act_acs_type=='docs')
			{
				var myform = document.getElementById("form-docs");
			}
							

			url_now = APP_URL + '/upload_stud_act_acs';

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
					$('#loaderModal').modal({ backdrop: 'static', keyboard: false });
				},
				success: function (dataofconfirm) 
				{
					//alert("Files uploaded successfully.");
					//location.reload();
				},
				complete: function()
				{
					$('#loaderModal').modal('hide');	
					$('#loadedAlertModal').modal({ backdrop: 'static', keyboard: false });
					location.reload();
				},
				error: function()
				{
					$('#loaderModal').modal('hide');	
					alert("File Upload failed.");
					location.reload();
				}
				
	  
			});

		}
		
	
	$(document).on('click', '.td-delete-stud-media', function()
	{
		if(confirm('Are you sure to remove this file ?'))
		{
			student_media_id = $(this).data('student_media_id');
			
			var	url_var = APP_URL + '/delete_student_act_upload';
			
			var data = {};
			data['id'] = student_media_id;
			
			$.ajax({
			   type:'post',  
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
						location.reload();
								
					}
				});
		}
		
	});



/*
		
	$(document).on('click', '#btn-modal-view-activity-close', function()
	{
	
		  $('audio').each(function(){
			this.pause(); // Stop playing
			this.currentTime = 0; // Reset time
		  }); 
		  
		 $('video').each(function(){
			this.pause(); // Stop playing
			this.currentTime = 0; // Reset time
		  }); 

		  
		
	});
	
*/	


	
	$(document).on('click', '.nav-tab', function(e)
	{
		e.preventDefault();  //stop the browser from following
		acs_file_path = $(this).data('acs_file_path');
		acs_file_name = $(this).data('acs_file_name');
		
		$('#a-download').attr('href', acs_file_path);
		$('#a-download').attr('download', acs_file_name);
		
		tab_key = $(this).data('tab_key');
		
		$('.form-upload').hide();
		$('#form-' + tab_key).show();
		
		$('.a-stud-media').removeClass('active');
		$('#a-stud-' + tab_key).addClass('active');
		
		
	});	
	
	$(document).on('click', '.a-stud-media', function(e)
	{
		e.preventDefault();  //stop the browser from following
		
		tab_key = $(this).data('tab_key');
				
		$('#nav-tab-' + tab_key).tab('show');
		
		$('.a-stud-media').removeClass('active');
		$('#a-stud-' + tab_key).addClass('active');
		
		$('.form-upload').hide();
		$('#form-' + tab_key).show();
		
		
	});	
	
	
	
	function download_activity_for_student(acs_file_path, acs_file_name)
	{

		var	url_var = APP_URL + '/download_activity_for_student';
		
		var data = {};
		data['acs_file_path'] = acs_file_path;
		data['acs_file_name'] = acs_file_name;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert(result_data);
							
				}
			});

	}	
	
	
	$(document).on('click', '#btn-completed', function(e)
	{
		e.preventDefault();  //stop the browser from following
		
		if(confirm('Do you really confirm that you have Completed learning this Activity ? \n This action lets your mentor to evaluate your Learning Status '))
		{
		
			completed = $('#completed').is(':checked') ? 1 : 0;
			
			var	url_var = APP_URL + '/update_student_room_statuses';
			
			var data = {};
			data['room_id'] = room_id;
			data['completed'] = completed ;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
						alert('Updated.');
						document.location.href = APP_URL + '/student/dashboard';
					}
				});
		}	
			
			
	});	
	
	
	function check_if_student_had_any_media()
	{

		var	url_var = APP_URL + '/check_if_student_had_any_media';
		
		var data = {};
		data['room_id'] = room_id;
		data['student_id'] = student_id ;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert(result_data);
							
				}
			});

	}	
	
	
	
</script>	
<body>
@include('student.layouts.ela-student-topbar')
    <main class="main students-login">
        <div class="jumbotron">
            <div class="container mb-5">
                <div class="row pb-0">
                    <div class="col-12 d-flex">

                        <div class="col-md-5" style="display:flex;align-items:center;">
							<div class="profile mr-3">
								<img src="{{asset(Session::get('profile_pic_path'))}}" class="img-fluid">
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
								<h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/student/dashboard')}}"> {{ $user_name }}</a> / {{$activity_master[0]->activity_title}}</h3>
								<p class="sub-text">By  {{$activity_master[0]->act_created_by_first_name . '  '. $activity_master[0]->act_created_by_last_name}}</p>
							</div>
							
							
							
							
							
                        </div>
						
                        <div class="col-md-7 d-flex p-0">
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2"></p>
                                <p class="pt-1"></p>
                            </div>
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2"></p>
                                <p class="pt-1"></p>
                            </div>
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2">Published Date</p>
                                <p class="pt-1">{{date('d-m-Y', strtotime($act_publish_details[0]->publish_date))}}</p>
                            </div>
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2">Due Date</p>
                                <p class="pt-1 orange">{{date('d-m-Y', strtotime( $act_publish_details[0]->room_expiry_date))}}</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!----------body content place here----------->
        <div class="container ">
            <div class="row three-boxes">
                <div class="col-md-8">
                    <ul class="nav nav-tabs margin-minus">
                        <li><a id="nav-tab-video" data-toggle="tab" href="#menu1"  class="nav-tab active show"  data-tab_key="video" data-acs_file_path="{{$video_path}}" data-acs_file_name="{{$video_acs_file_name}}" >Video</a></li>
                        <li><a id="nav-tab-audio" data-toggle="tab" href="#menu2" class="nav-tab" data-tab_key="audio" data-acs_file_path="{{$audio_path}}" data-acs_file_name="{{$audio_acs_file_name}}">Audio</a></li>
                        <li><a id="nav-tab-docs" data-toggle="tab" href="#menu3" class="nav-tab" data-tab_key="docs" data-acs_file_path="{{$docs_path}}" data-acs_file_name="{{$docs_acs_file_name}}">PDF</a></li>
                    </ul>
					
                    <div class="tab-content pl-0 pr-0 mt-60">
					    <div class="row">
					        <div class="col-md-12" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
					            <span style="font-size: 18px;font-weight: 700;color: #000000;">Activity Name</span>
					            <h3 style="text-align:right;margin-bottom:0px;font-size:15px;">
        							<a id="a-download" href="{{$docs_path}}" download="{{$docs_acs_file_name}}" >
        								<img src="{{asset('public/ela-assets/images/download.png')}}" /> 
        								Download 
        							</a>
        						</h3>
					        </div>
					    </div>					
                        
                        <div id="menu1" class="tab-pane fade  active show">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="video-wrap">
                                        <video width="100%" controls poster="images/vid.jpg" style="border: 1px solid #ccc;">
                                            <source src="{{$video_path}}" type="video/mp4">
                                            <source src="{{$video_path}}" type="video/ogg">
                                        </video>
                                    </div>
                                    <h3 class="pt-30">
                                        {{$activity_master[0]->activity_title}}
                                    </h3>
                                    <p>
                                        {{$activity_master[0]->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <audio autobuffer controls class="mb-15">
                                <source src="{{$audio_path}}" type="audio/mp3">
                                
                            </audio>

                            <h3 class="pt-20">
                               
                            </h3>
                            <p>
                               
                            </p>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <div class="pdf-wrap">
                                <iframe src="{{$docs_path}}" frameborder="0" height="100%" width="100%">
								
                                </iframe>
                            </div>
                            <h3 class="pt-20"></h3>
                            <p></p>
                        </div>
						
						
                    </div>

                </div>								

                <div class="col-md-4">
				
                    <div class="activity p-50">
                        <h3 class="mb-0 pb-0" style="color: #ff900e!important;font-size:20px;text-align:center;">Upload Your Results</h3>
                        <hr>
                        <div class="vid-audio-pdf">
                            <a href="#" id="a-stud-video" class="a-stud-media active" data-tab_key="video"><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a>
                            <a href="#" id="a-stud-audio" class="a-stud-media" data-tab_key="audio"><i class="fa fa-volume-up" aria-hidden="true"></i> Audio</a>
                            <a href="#" id="a-stud-docs" class="a-stud-media" data-tab_key="docs"><i class="fa fa-file" aria-hidden="true"></i> Pdf</a>
                        </div>
                        

						<form class="form-upload" enctype="multipart/form-data" id="form-video" >
                            <div class="form-group mb-30">
                                <div class="custom-file">
									<input type="file" name="image[]" multiple class="custom-file-input form-control inp-files" id="inputfiles_video"  accept="video/*">
                                    <label class="custom-file-label" for="customFile" id="label_video">Upload your Video</label>
									<input type="hidden" name="dirtarget" id="dirtarget_video" class="form-control dirtarget" placeholder="Add Title">
									<input type="hidden" name="acs_type" id="" class="form-control acs-type" value="video">
									<input type="hidden" name="room_id" id="" class="form-control room_id" >
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <textarea class="form-control" name="notes" id="exampleFormControlTextarea1" rows="3" placeholder="Add Notes Here"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-upload" value="video" style="width: 100%;">Submit</button>
                        </form>
						
						<form class="form-upload"  enctype="multipart/form-data" id="form-audio" style="display:none;">
                            <div class="form-group mb-30">
                                <div class="custom-file">
									<input type="file" name="image[]" multiple class="custom-file-input form-control inp-files" id="inputfiles_audio" accept="audio/*">
                                    <label class="custom-file-label" for="customFile" id="label_audio">Upload your Audio</label>
									<input type="hidden" name="dirtarget" id="dirtarget_audio" class="form-control dirtarget" placeholder="Add Title">
									<input type="hidden" name="acs_type" id="" class="form-control acs-type" value="audio">
									<input type="hidden" name="room_id" id="" class="form-control room_id" >
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <textarea class="form-control" name="notes" id="exampleFormControlTextarea1" rows="3" placeholder="Add Notes Here"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-upload" value="audio" style="width: 100%;">Submit</button>
                        </form>

						<form class="form-upload" enctype="multipart/form-data" id="form-docs" style="display:none;">
                            <div class="form-group mb-30">
                                <div class="custom-file">
									<input type="file" name="image[]" multiple class="custom-file-input form-control inp-files" id="inputfiles_docs" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*">
                                    <label class="custom-file-label" for="customFile" id="label_docs">Upload your Documents</label>
									<input type="hidden" name="dirtarget" id="dirtarget_docs" class="form-control dirtarget" placeholder="Add Title">
									<input type="hidden" name="acs_type" id="" class="form-control acs-type" value="docs">
									<input type="hidden" name="room_id" id="" class="form-control room_id" >
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <textarea class="form-control" name="notes" id="exampleFormControlTextarea1" rows="3" placeholder="Add Notes Here"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-upload" value="docs" style="width: 100%;">Submit</button>
                        </form>
							<div class="row">
								<div class="col-md-12">
						
									 <h2 style="margin-top: 15px; color: #ff900e!important;">Files Uploaded</h2>
									
									<table id="example">
										<thead>
											<tr >
												<th width="250">FileName</th>
												<th width="100">Type</th>
												<th width="50" style="text-align:center">Remove</th>
											</tr>
										</thead>
										<tbody> 
											@foreach($student_media_uploads as $key=>$student_media_upload) 
											<tr>
												<td><div style="width:124px;overflow:hidden;text-overflow:ellipsis;">{{$student_media_upload->acs_file_name}}</div></td>
												<td>{{$student_media_upload->act_acs_type}}</td>
												<td style="text-align:center; cursor:pointer" data-student_media_id = "{{$student_media_upload->id}}" class="td-delete-stud-media"><a style="color:red;" ><i class="fa fa-times" aria-hidden="true"></i></a></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								 </div> 
							 </div> 
                    </div> 
                    <div class="complete p-50 text-center">
                        <h3>
							<a style="color: #ff900e!important" >
								Complete this Activity
							</a>
							
						</h3>
                        <hr>
						<p style="color:#66a0d8">
							I agree that, the above activity completely done by me itself, and the report is uploaded to you for evaluation.
                        </p>
						<form class=""  enctype="multipart/form-data" id="form-audio" >
                            <div class="form-group ">
                                <div class="custom-file">
									<input type="checkbox" class="form-check-input" id="completed" >Completed</label>
                                </div>
                            </div>
                            <a type="submit" class="btn btn-primary {{($count_student_media_uploads == 0 ) ? 'disabled':''}} " id="btn-completed"  style="width: 100%;">Save</a>
                        </form>
						
						
					</div>
					
					
					
					
                </div>
            </div>
            <hr>
            <div class="row pt-30 pb-90">
                <div class="col-md-12">
                    <h2 class="pb-15">Upcoming Activities</h2>
                    <div class="card" style="height:auto;">
                        <table class="table">
                            <tbody>
							@foreach($students_approved_activities_not_completed as $key=>$students_approved_activity_not_completed) 
							@if ($students_approved_activity_not_completed->room_id != $room_id )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td colspan="2">
                                        <p class="dark-blue font-weight-bold">{{$students_approved_activity_not_completed->activity_title }}</p>
                                        <p class="sub-text2">By {{$students_approved_activity_not_completed->act_created_by_first_name }}</p>
                                    </td>
                                    <td class="orage">09 September 2020</td>
                                    <td class="text-success"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        Active</td>
                                    <td>VIII</td>
                                    <td>
									
										<a href="{{url('student/activity/students-activity', ['room_id' => $students_approved_activity_not_completed->room_id])}}">
										<button value="{{$students_approved_activity_not_completed->room_id}}" data-room_id="{{$students_approved_activity_not_completed->room_id}}" type="button" class="btn btn-warning btn-view-activity">Learn</button>
										</a>
									
									
                                    <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                </tr>
							@endif
							@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
	@include('layouts.loader-modal')
	@include('layouts.loaded-alert-modal')
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