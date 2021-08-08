<!DOCTYPE html>
<html lang="en">

@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$rooms_own_students =  app()->call([$cc, 'get_rooms_own_students'], [$room_id]);

$count_rooms_own_students = count($rooms_own_students);

$rooms_own_groups =  app()->call([$cc, 'get_rooms_own_groups'], [$room_id]);

$activity_by_room_id =  app()->call([$cc, 'get_activity_by_room_id'], [$room_id]);

$rooms_entire_students =  app()->call([$cc, 'get_rooms_entire_students'], [$room_id]);

$ev_criterias =  app()->call([$cc, 'get_ev_criterias'], [$room_id]);

?>
<script>
$(document).ready(function() {
	
	video_path = "" ;
	audio_path = "" ;
	docs_source = "" ;

	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
	APP_URL = "{{ url('/') }}";		

	student_id = '{{ $rooms_entire_students[0]->student_id }}';
	room_id = '{{ $room_id }}'; /*   */
	
	get_students_responses_to_activity();
		
	$(".nav-tabs-media").hide();
	//$(".tab-pane-media").removeClass("show");

		
	
	
});


	$(document).on('click', '#tr-student', function(event)
	{	
		student_status = $(this).data('student_status');
		student_id = $(this).data('student_id');
		/*
		if(student_status=='completed')
		{
			$("#div-completed").show();
			$("#div-pending").hide();
			
		}
		else if(student_status=='pending')
		{
			$("#div-completed").hide();
			$("#div-pending").show();
			
		}
		*/
		get_students_responses_to_activity();

	});
					

	$(document).on('click', '#a-pane-groups', function(event)
	{	
		event.preventDefault();
		
		$("#pane-individuals").removeClass("show");
		$("#pane-individuals").removeClass("active");
		$("#pane-groups").addClass("show");
		$("#pane-groups").addClass("active");
		
	});


	$(document).on('click', '#a-pane-individuals', function(event)
	{	
		event.preventDefault();
		
		$("#pane-groups").removeClass("show");
		$("#pane-groups").removeClass("active");
		$("#pane-individuals").addClass("show");
		$("#pane-individuals").addClass("active");
		
	});
	
	
	$(document).on('keyup', '.inp-mark', function(event)
	{	
			var max = parseInt($(this).attr('max'));
			var min = parseInt($(this).attr('min'));
			
          if ($(this).val() > max)
          {
              $(this).val(max);
          }
          else if ($(this).val() < min)
          {
              $(this).val(min);
          } 
		  
	});
	
	
	$(document).on('change', '#sel-group', function(event)
	{
		
		group_id = $(this).val();
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/get_groups_own_students';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['group_id'] = group_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   
				    $("#table-individuals tbody").empty();
				   
					for (var i = 0; i < result_data.length; ++i) 
					{
						
						row_string = '<tr>'+
										'<td>'+
											'<a href="#">'+
												'<div class="submitted-by">'+
													'<span ></span>'+
													'<div>' + result_data[i].first_name + '<p>Task completed 40 Min ago</p>'+
													'</div>'+
													'<div class="evaluated">Evaluated</div>'+
												'</div>'+
											'</a>'+
										'</td>'+
									'</tr>';
									
					   $("#table-individuals tbody").append(row_string);
						
					}

				   
				   
				   
				}
			});
			
			
		
	});
	
	
	function get_students_responses_to_activity()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_students_responses_to_activity';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['student_id'] = student_id;
		data['room_id'] = room_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					
					
					student_details = result_data['student_details'];					
					profile_pic_path = "{{url('/public')}}" + '/' + student_details[0].prof_pic_path + student_details[0].prof_pic_file ;
					
				  	var last_name = student_details[0].last_name ? student_details[0].last_name : '';
				    var f_letter_1 = (student_details[0].first_name).substring(0, 1);
				    var f_letter_2 = last_name.substring(0, 1);
				    $('.span-sel-stud-name-abbr').html(f_letter_1  + f_letter_2 );
					
					student_room_statuses = result_data['student_room_statuses'];
					
					if(student_room_statuses.length)
					{
						$("#div-completed").show();
						$("#div-pending").hide();
			
						completed_date = PKDateDdMmYyyy(student_room_statuses[0].completed_date);
						$('.h-sel-stud-name').html(student_details[0].first_name + ' ' + last_name + '<span  > Task completed on ' + completed_date + '</span>');
					}
					else
					{
						$("#div-completed").hide();
						$("#div-pending").show();
						
						$('.h-sel-stud-name').html(student_details[0].first_name + ' ' + last_name + '<span  > Task pending ' + '</span>');
						$('#h-sel-stud-name-reminder').html('Send Reminder to ' + student_details[0].first_name + ' ' + last_name );
					}

					
					$.ajax({ url: profile_pic_path, type:'HEAD',
								error: function()
								{
									$(".imagePreview").hide();
									$(".span-sel-stud-name-abbr").show();
									
								},
								success: function()
								{
									$(".imagePreview").show();
									$(".span-sel-stud-name-abbr").hide();
									$('.imagePreview').css('background-image','url("' + profile_pic_path +'")');
								}
							}); 								  
				   
					student_video_uploads = result_data['student_video_uploads'];
					student_audio_uploads = result_data['student_audio_uploads'];
					student_docs_uploads = result_data['student_docs_uploads'];
						
					if (student_video_uploads.length)
					{
						video_path = "{{url('/public')}}" + '/' + student_video_uploads[0].acs_file_path + student_video_uploads[0].acs_file_name ;
						
						$('#a-download-video').attr("href", video_path )
						$('#a-download-video').attr("download", video_path)
						$('#a-download-video').removeClass('disabled' )
						$('#col-video').addClass('col-have-media' )
						student_notes_video = student_video_uploads[0].notes;
						
					}
					else
					{
						$('#a-download-video').addClass('disabled' );
						$('#col-video').removeClass('col-have-media' )
						video_path ='';
						student_notes_video ='';
					}
					
						video_source = '<source src="' + video_path + '" type="video/mp4">' + 
										'<source src="' +   video_path + '" type="video/ogg">';
										
						$('#videoActivity').html(video_source);
						$("#modal_activity_description_video").append(student_notes_video);
					
					if (student_audio_uploads.length)
					{
						audio_path = "{{url('/public')}}" + '/' + student_audio_uploads[0].acs_file_path + student_audio_uploads[0].acs_file_name ;
						
						$('#a-download-audio').attr("href", audio_path )
						$('#a-download-audio').attr("download", audio_path)
						$('#a-download-audio').removeClass('disabled' )
						$('#col-audio').addClass('col-have-media' );
						student_notes_audio = student_audio_uploads[0].notes;
					}
					else
					{
						$('#a-download-audio').addClass('disabled' );
						$('#col-audio').removeClass('col-have-media' );
						audio_path = '';
						student_notes_audio = '';
					}
					
						audio_source = '<source src="' + audio_path + '" type="audio/ogg">' + 
										'<source src="' +   audio_path + '" type="audio/mpeg">';
										
						$('#audioActivity').html(audio_source);
						$("#modal_activity_description_audio").append(student_notes_audio);
					
					if (student_docs_uploads.length)
					{
						docs_path = "{{url('/public')}}" + '/' + student_docs_uploads[0].acs_file_path + student_docs_uploads[0].acs_file_name ;
						
						$('#a-download-docs').attr("href", docs_path )
						$('#a-download-docs').attr("download", docs_path)
						$('#a-download-docs').removeClass('disabled' );
						$('#col-docs').addClass('col-have-media' );
						student_notes_docs = student_docs_uploads[0].notes;
					}
					else
					{
						$('#a-download-docs').addClass('disabled' );
						$('#col-docs').removeClass('col-have-media' );
						docs_path = "";
						student_notes_docs = '';
					}
					
						$('#docsActivity').attr('src', docs_path);
						$("#modal_activity_description_docs").append(student_notes_docs);
					
					mentor_room_evaluations = result_data['mentor_room_evaluations'];
					
					var mark = {};
					var criteria = {};
					
					for (var i = 0; i < mentor_room_evaluations.length; ++i) 
					{
						mark[mentor_room_evaluations[i].criteria_id] = mentor_room_evaluations[i].marks;
					}	
					
					$('.inp-mark').each(function(index, elem) 
					{
						criteria[index] = $(this).data("criteria_id");
						$('#mark-' + criteria[index]).val(mark[criteria[index]]);
					});		

					mentor_room_evaluation_statuses = result_data['mentor_room_evaluation_statuses'];					
					$('#ev_comment').val(mentor_room_evaluation_statuses[0].ev_comment);
					
			mentor_room_evaluation_statuses[0].evaluation_completed == 1 ? $("#evaluation_completed").prop("checked", true): $("#evaluation_completed").prop("checked", false);

				    
				}
			});
			
	}
	
	
	
	$(document).on('click', '#btn-save-evaluation', function(event)
	{
		valid = 1;
		$('.req_fields').filter(function () 
		{
			if (this.value.trim() == '')
				valid = 0;
				return false;
		});		
				
		if(valid == 1)
		{
		
			
				var CSRF_TOKEN = '{{csrf_token()}}';
		 
				var url_var =  APP_URL + '/insert_mentor_room_evaluations';
						
				var data = {};
				data['_token'] = CSRF_TOKEN;
				data['room_id'] = room_id;
				data['student_id'] = student_id;
				
				var mark = {};
				var criteria = {};
				var base_mark = {};
				
				$('.inp-mark').each(function(index, elem) 
				{
					
					criteria[index] = $(this).data("criteria_id");
					mark[$(this).data("criteria_id")] = $(this).val();
					base_mark[$(this).data("criteria_id")] = $(this).data("base_mark");
				});		
				
				
				$.ajax({
				   type:'post',
				   url: url_var,  
				   data: {data, criteria, mark, base_mark},
				   async:false,
				   success:function(result_data)
					   {
							 update_mentor_room_evaluation_statuses();
						   
						}
					});
		}
		else
		{

			alert('Empty Fields Not Allowed.');
		}			
		
	});
	
	
	$(document).on('click', '#btn-send-reminder', function(event)
	{
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/insert_mentor_room_reminders';
				
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['room_id'] = room_id;
		data['student_id'] = student_id;
		data['reminder_text'] = $('#reminder_text').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					if(data['reminder_text'] != '')
					{
						insert_notifications(3, student_id, $('#reminder_text').val() );
					}
						
					alert('Sent Reminder Successfully.');
				   
				}
			});
			
			  
		
	});
	

	$(document).on('click', '.view-activity', function()
	{
		var media = $(this).data('media');
		$(".tab-pane-media").removeClass("show");
		$(".tab-pane-media").removeClass("active");
	
		$('#tab-' + media ).addClass("show");
		$('#tab-' + media).addClass("active");
				 
		
		
	});
	
		
	function update_mentor_room_evaluation_statuses()
		{
		
			evaluation_completed = $('#evaluation_completed').is(':checked') ? 1 : 0;
			
			var	url_var = APP_URL + '/update_mentor_room_evaluation_statuses';
			
			var data = {};
			data['room_id'] = room_id;
			data['student_id'] = student_id;
			data['evaluation_completed'] = evaluation_completed ;
			data['ev_comment'] = $('#ev_comment').val();
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
						//alert('Updated.');
						document.location.href = APP_URL + '/mentor/dashboard';
					}
				});
		}	
		
		
	$(document).on('click', '#btn-update-finish-activity', function()
	{
		if(confirm('Are you sure to Finish this Activity ?'))
		{
			update_finish_activity();
		}
		
	});
	
	
	function update_finish_activity()
		{
		
			activity_finished = $('#activity_finished').is(':checked') ? 1 : 0;
			
			var	url_var = APP_URL + '/update_finish_activity';
			
			var data = {};
			data['room_id'] = room_id;
			data['activity_finished'] = activity_finished ;
			data['mentors_finish_note'] = $('#mentors_finish_note').val();
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
					   
						if(activity_finished == 1)
						{
							insert_notifications(8, 7, $('#mentors_finish_note').val() );
						}
						document.location.href = APP_URL + '/mentor/dashboard';

					}
				});
				
		}	

		
	function insert_notifications(notif_category_id, user_id_receiver, message)
		{
			
			var	url_var = APP_URL + '/insert_notifications';
			
			var data = {};
			data['notif_category_id'] = notif_category_id;  //Finished activity
			data['user_id_receiver'] = user_id_receiver ; //super admin id
			data['message'] = message;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
					   
					}
				});
				
		}	
		

</script>
<body>
@include('mentor.layouts.ela-mentor-topbar')
<style>

.col-have-media
{
	cursor:pointer;
	background-color: lightcyan;
}
</style>
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
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/avatar.jpg')}}" width="30"></a>
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
                <div class="row pb-0">
                    <div class="col-12 d-flex">
                        <div class="col-md-4">
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
								<h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/mentor/dashboard')}}"> {{ $user_name }}</a> / {{$activity_by_room_id[0]->activity_title}}</h3>
								<p class="sub-text"></p>
							</div>
							
							
							
							
							
                        </div>
                        <div class="col-md-8 d-flex p-0">
                            <div class="col-2">
                                <p class="sub-text m-0">Published Date </p>
                                <p class="pt-1">{{ date('d-m-Y', strtotime($activity_by_room_id[0]->publish_date))    }}</p>
                            </div>
                            <div class="col-2">
                                <p class="sub-text m-0">Due Date</p>
                                <p class="pt-1">{{ date('d-m-Y', strtotime($activity_by_room_id[0]->room_expiry_date))    }}  </p>
                            </div>
                            <div class="col-2">
                                <p class="sub-text m-0">Completed</p>
                                <p class="pt-1" id="p-completed"></p>
                            </div>
                            <div class="col-2">
                                <p class="sub-text m-0">Evaluated</p>
                                <p class="pt-1" id="p-evaluated"></p>
                            </div>
                            <div class="col-2">
                                <p class="sub-text m-0">Pending</p>
                                <p class="pt-1" id="p-pending"></p>
                            </div>
                            <div class="col-2 text-right">
                                <button type="button" class="btn btn-outline-lighter text-dark">Edit User
                                    <img src="{{asset('public/ela-assets/images/filter.svg')}}">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="row three-boxes">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" style="display:none;">
                        <li><a id="a-pane-individuals" href="#" class="active show">Individuals ( {{$count_rooms_own_students}} )</a></li>
                        <li><a id="a-pane-groups" href="#">Group ( 2 )</a></li>
                    </ul>

                    <div class="tab-content pl-0 pr-0 mt-60">
                        <div id="pane-individuals" class="tab-pane fade  active show">
                            <div class="row pb-40">
                                <div class="col-md-12">
                                    <div class="card p-30">
                                        <div class="row">
                                            <div class="col-md-4 lists-search">
                                                <h6 class="mb-4">Task Overview</h6>
                                                <form style="display:none;">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" placeholder="Search..">
                                                        </div>
                                                        <div class="col-4">
                                                            <select class="form-control" id="sel-group">
															@foreach($rooms_own_groups as $key=>$rooms_own_group) 
                                                                <option value="{{$rooms_own_group->id  }}">{{$rooms_own_group->stud_group  }}</option>
															@endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>Evaluated</option>
                                                                <option>Completed</option>
                                                                <option>Pending</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </form>
                                                <div class="list-height-fix task-overview mt-30">
                                                    <div class="table-responsive">
                                                        <table class="table" id="table-individuals">
                                                            <tbody id="myTable">
																@php $count_completed= 0; $count_evaluated= 0; $count_pending= 0; @endphp
																@foreach($rooms_entire_students as $key=>$student) 
																<?php
																	$profile_pic_path = url('/public') . '/' . $student->prof_pic_path . $student->prof_pic_file ;
																	
																	$student_status =  app()->call([$cc, 'get_student_room_status'], [$room_id, $student->student_id]);
																	
																	$student_status =='completed' && $count_completed++;
																	$student_status =='evaluated' && $count_evaluated++;
																	$student_status =='pending' && $count_pending++;
																	
																	$cc = app()->make('App\Http\Controllers\CommonController');
																	$evaluation_marks_sum = app()->call([$cc, 'get_mentor_room_evaluation_marks_sum'], [$room_id, $student->student_id]);
																	
																	$sum_marks = (count($evaluation_marks_sum )!=0)? $evaluation_marks_sum[0]->sum_marks: '-';
																	$sum_base_mark = (count($evaluation_marks_sum )!=0)? $evaluation_marks_sum[0]->sum_base_mark: '-';
																	
																?>
                                                                <tr id="tr-student" data-student_status="{{$student_status}}" data-student_id="{{$student->student_id}}" data-room_id="{{$student->room_id}}" style="cursor:pointer;">
																	@if( @GetImageSize($profile_pic_path))
                                                                    <td>
                                                                        <a >
                                                                            <div class="submitted-by">
                                                                                <span  style="background: url({{$profile_pic_path}}" ></span>
                                                                                <div>{{$student->first_name}} <!--<p>Task completed 40 Min ago</p>-->
                                                                                </div>
                                                                                <div class="{{$student_status}}">{{ucwords($student_status)}}</div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
																	@else
																	<td>
																		<a >
																			<div class="submitted-by">
																				<span class="grade">{{strtoupper(substr($student->first_name, 0, 1)) . strtoupper(substr($student->last_name, 0, 1)) }}</span>
																			   {{$student->first_name . ' ' . $student->last_name }}
                                                                                <div class="{{$student_status}}">{{ucwords($student_status)}}</div>
																			</div>
																		</a>
																	</td>
																	@endif
																	<td style="font-weight:bold; color: blue!important;">{{$sum_marks . '/' . $sum_base_mark}}</td>
                                                                </tr>
																@endforeach
																
																

                                                            </tbody>
                                                        </table>
														<script>
															$("#p-completed").text('{{ $count_completed }}');
															$("#p-evaluated").text('{{ $count_evaluated }}');
															$("#p-pending").text('{{ $count_pending }}');

														</script>
                                                    </div>
                                                </div>
												
                                            </div>
											
                                            <div id="div-completed" class="col-md-8 profile-wrap" ><!-- EVALUATION DIV BEGINS------------------------------------------------>
												
												
												<div class="profile submitted-by ">
													<form class="profile-pic-form" id="profile-pic-form" enctype="multipart/form-data">
														<div class="avatar-upload profile-photo-editor">
															<div class="avatar-preview">
																<div class="imagePreview" style=" display:none;">
																
																</div>
																
																<div class="without-image span-sel-stud-name-abbr" id="span-sel-stud-name-abbr">
																	
																</div>
															</div>
														</div>
													</form>
													
													
													
													<h3 class="h-sel-stud-name"><span class="text-left" ></span></h3>
                                                    <div class="edit-btn btn-group dropleft" data-toggle="tooltip" title="Edit Student">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid"></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#finish-modal">Finish Activity</a>
                                                        </div>
                                                    </div>
												</div>
												
												
												
												
												
												
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12 pl-60 pr-60 pt-30 pb-30" id="student_notes">
													
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="file-wrap" id="col-video">
                                                            <span class="circle view-activity" data-media="video" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target=".bd-example-modal-lg">
                                                                <img src="{{asset('public/ela-assets/images/live.png')}}" class="img-fluid" />
                                                            </span>
                                                            <span>videofile.mp4</span>
                                                            <p class="mb-0">28 mb</p>
                                                            <!--<a href="#"><img src="{{asset('public/ela-assets/images/dwnld.png')}}" /></a>-->
															<a id="a-download-video" href="" download="" >
																<img src="{{asset('public/ela-assets/images/dwnld.png')}}" />
															</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="file-wrap" id="col-audio">
                                                            <span class="circle view-activity" data-media="audio" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target=".bd-example-modal-lg">
                                                                <img src="{{asset('public/ela-assets/images/play.png')}}" class="img-fluid" />
                                                            </span>
                                                            <span>audio.wav</span>
                                                            <p class="mb-0">6 mb</p>
															<a id="a-download-audio" href="" download="" >
																<img src="{{asset('public/ela-assets/images/dwnld.png')}}" />
															</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="file-wrap" id="col-docs">
                                                            <span class="circle view-activity" data-media="docs" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target=".bd-example-modal-lg">
                                                                <img src="{{asset('public/ela-assets/images/pdf.png')}}" class="img-fluid" />
                                                            </span>
                                                            <span>doc.pdf</span>
                                                            <p class="mb-0">12 mb</p>
															<a id="a-download-docs" href="" download="" >
																<img src="{{asset('public/ela-assets/images/dwnld.png')}}" />
															</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 course-evaluation mt-30">
                                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#evaluation"> Evaluate</a>
                                                        <a href="#" class="gray-btn mt-20">Mark as incomplete</a>
                                                    </div>
                                                </div>
                                            </div><!-- EVALUATION DIV ENDS------------------------------------------------>
                                            <div id="div-pending" class="col-md-8 profile-wrap" style="display:none;"><!-- PENDING DIV BEGINS--------------------------->
											<!--
                                                <div class="profile">
                                                    <span style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                    <h3>Sreelekshmi R<span>Task Pending</span></h3>
                                                    <div class="edit-btn btn-group dropleft" data-toggle="tooltip" title="Edit Student">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid"></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editstudent">View Profile</a>
                                                            <a class="dropdown-item" href="#">Add to Group</a>
                                                            <a class="dropdown-item" href="#">Report/Flag</a>
                                                        </div>
                                                    </div>
                                                </div>
											-->	
												
												
												<div class="profile submitted-by ">
													<form class="profile-pic-form" id="profile-pic-form" enctype="multipart/form-data">
														<div class="avatar-upload profile-photo-editor">
															<div class="avatar-preview">
																<div class="imagePreview" style=" display:none;">
																
																</div>
																
																<div class="without-image span-sel-stud-name-abbr" id="">
																	
																</div>
															</div>
														</div>
													</form>
													
													
													
													<h3 class="h-sel-stud-name"><span class="text-left" ></span></h3>
                                                    <div class="edit-btn btn-group dropleft" data-toggle="tooltip" title="Edit Student">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/dots.svg')}}" class="img-fluid"></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editstudent">View Profile</a>
                                                            <a class="dropdown-item" href="#">Add to Group</a>
                                                            <a class="dropdown-item" href="#">Report/Flag</a>
                                                        </div>
                                                    </div>
												</div>
												
												
												
												
												
												
												
												
												
												
												
												
												
												
                                                <hr>
                                                <div class="row remind">
                                                    <div class="col-md-12">
                                                        <img src="{{asset('public/ela-assets/images/pending.jpg')}}" class="img-fluid m-auto" />
                                                        <a type="button" class="btn btn-third mt-60" data-toggle="modal" data-target="#remind" style="margin: auto;display: block;max-width: 100px;">
                                                            Remind
                                                        </a>
                                                    </div>
                                                </div>
                                            </div><!-- PENDING DIV ENDS------------------------------------------------>
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pane-groups" class="tab-pane fade">
						
							<div class="row students-lists">
							
								@foreach($rooms_own_groups as $key=>$rooms_own_group) 
								<div class="col-md-12 single-student">
									<div class="student-pic" style="background: url({{asset('public/ela-assets/images/s1.png')}});"></div>
									<div class="name">
										{{$rooms_own_group->stud_group  }}
									</div>
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input check-group " value="" id="{{$rooms_own_group->id}}">
										</label>
									</div>
								</div>
								@endforeach
								
								
							</div>
							
							
                        </div>
                        <div id="" class="tab-pane fade">
                            <h3>Menu 3</h3>
                            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="evaluation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Evaluation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="background: #fff;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
												@foreach($ev_criterias as $key=>$ev_criteria) 
                                                <tr>
                                                    <td width="250px" id="criteria-{{$ev_criteria->id}}">{{$ev_criteria->criteria}} </td>
                                                    <td><input id="mark-{{$ev_criteria->id}}" data-criteria_id ="{{$ev_criteria->id}}"  data-base_mark ="{{$ev_criteria->base_mark}}" min="0" max="{{$ev_criteria->base_mark}}" type="number"  class="form-control inp-mark req_fields" aria-describedby="mark" placeholder="- -"></td>
                                                    <td width="100px">on {{round($ev_criteria->base_mark)}}</td>
                                                </tr>
												@endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-header">
									<div class="row">
										<div class="col-md-12" >
                                                <textarea class="form-control" id="ev_comment" rows="6" placeholder="Add Comment"></textarea>
                                                <small id="headline" class="form-text text-muted">500 Characters minimum</small>
										</div>
										<div class="col-md-12" style="text-align:right;">
											<input type="checkbox" class="form-check-input" id="evaluation_completed" style="float:left">Completed</label>
											<button id="btn-save-evaluation" type="button" class="btn btn-primary m-auto">Save</button>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <!-- REMINDER Modal -->
                    <div class="modal fade" id="remind" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="h-sel-stud-name-reminder"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="background: #fff;">
                                    <textarea class="form-control" id="reminder_text" rows="5" placeholder="Type here ..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-send-reminder" type="button" class="btn btn-primary m-auto">Remind</button>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
<!--------------VIEW ACTIVITY MODAL BEGINS-------------------------------------------------------------------------------->	
	@include('layouts.activity-modal')
<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	
                                <!--Approve Modal -->
                                <div class="modal fade" id="finish-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Finish Activity</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
									  <!--
                                        <p>Publish date</p>
                                        <div class="form-group">
                                            <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                                                <input id="inp-publish-date" class="form-control" type="text" readonly />
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                        </div>
										-->
										
										
										<div class="row">
											<div class="col-md-12" >
													<textarea class="form-control" id="mentors_finish_note" rows="6" placeholder="Add mentors comment on activity"></textarea>
													<small id="headline" class="form-text text-muted">1000 Characters minimum</small>
											</div>
											<div class="col-md-12 ml-4 mt-2" style="text-align:left;">
												<input type="checkbox" class="form-check-input" id="activity_finished" style="float:left">Finished</label>
											</div>
										</div>
										
										
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button id="btn-update-finish-activity" type="button" class="btn btn-primary">Update</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
					
                </div>
            </div>
        </div>
        <!----------body content place end here----------->
    </main>
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