@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$act_publishs=  app()->call([$cc, 'get_on_publish_activities']);

$count_pending_approval = count($act_publishs);

$approved_activities =  app()->call([$cc, 'get_approved_activities']);
$mentor_room_evaluation_statuses =  app()->call([$cc, 'get_mentor_room_evaluation_statuses']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);
?>
<script>
$(document).ready(function() {
	
	activity_id =0;
	room_id = 0;
	publish_id = 0;
	student_id = 0;
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
	
});



	$(document).on('click', '.li-change-expiry-date', function()
	{
		room_id = $(this).data('room_id');
		
		expiry_date = $(this).data('expiry_date');
		
		$('#inp-expiry-date').val(expiry_date);
		
		//alert(expiry_date);
	});

	$(document).on('click', '#btn-update-expiry_date', function()
	{
		//expiry_date = $('#inp-expiry-date').val();
		if(confirm('Confirm Change Due Date ?'))
		{
			change_activity_expiry_date();
		}
		
	});
	
	
	function change_activity_expiry_date()
	{

		var	url_var = APP_URL + '/change_activity_expiry_date';
		
		var data = {};
		data['room_id'] = room_id;
		data['room_expiry_date'] = $('#inp-expiry-date').val();
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert('Updated.');
					location.reload();
							
				}
			});

	}	

	
	$(document).on('click', '.btn-view-activity', function()
	{
		activity_id = $(this).attr('value');
		room_id = $(this).data('room_id');
		return_activity_detail_by_id();
		
	});

	
	function return_activity_detail_by_id()
	{

		var	url_var = APP_URL + '/return_activity_detail_by_id';
		
		var data = {};
		data['id'] = activity_id;
		data['room_id'] = room_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   activity_master = result_data['activity_master'];
				   act_acs_videos = result_data['act_acs_videos'];
				   act_acs_audios = result_data['act_acs_audios'];
				   act_acs_docs = result_data['act_acs_docs'];
				   act_pbsh_grades = result_data['act_pbsh_grades'];
				   act_pbsh_subjects = result_data['act_pbsh_subjects'];
				   					
					$('#videoActivity').empty();
					if(act_acs_videos.length > 0 )
					{
						video_path = "{{url('/public')}}" + act_acs_videos[0].acs_file_path + act_acs_videos[0].acs_file_name ;
					
					}
					else
					{
						video_path = "" ;
					
					}
					
						video_source = '<source src="' + video_path + '" type="video/mp4">' + 
										'<source src="' +   video_path + '" type="video/ogg">';
										
						$('#videoActivity').html(video_source);


					$('#audioActivity').empty();
					if(act_acs_audios.length > 0 )
					{
						audio_path = "{{url('/public')}}" + act_acs_audios[0].acs_file_path + act_acs_audios[0].acs_file_name ;
					}
					else
					{
						audio_path = "" ;
					}
					
						audio_source = '<source src="' + audio_path + '" type="audio/ogg">' + 
										'<source src="' +   audio_path + '" type="audio/mpeg">';
										
						$('#audioActivity').html(audio_source);
					
					
					
					$('#docsActivity').attr('src', '')
					if(act_acs_docs.length > 0)
					{
						docs_source = "{{url('/public')}}" + act_acs_docs[0].acs_file_path + act_acs_docs[0].acs_file_name ;
					}
					else
					{
						docs_source = "" ;
					}
						$('#docsActivity').attr('src', docs_source)
					
					
				   
					$('#view_activity_title').html(activity_master[0].activity_title + '<span>For Grades ' + act_pbsh_grades.join(", ") + '</span>');
					
					$('#view_activity_subjects').html('Subjects <span>' + act_pbsh_subjects.join(", ") + '</span>');
					
				}
			});

	}	
	
	
	$(document).on('click', '#a-stud-activity-view', function()
	{
		$('#li-eval').show();
		$('#tab-eval').show();

		room_id = $(this).data('room_id');
		student_id = $(this).data('student_id');
		var activity_title = $(this).data('activity_title');
		$('#view_eval_activity_title').html('<span style="color: #f14ab6;"> ACTIVITY : ' +  activity_title + '</span>');
		
		get_students_responses_to_activity();
		
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
					$('#view_eval_student_name').html('<span style="color: #f14ab6;"> STUDENT: ' +  student_details[0].first_name + ' ' + last_name + '</span>');
					
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
						$("#modal_activity_description_video").append(student_notes_audio);
					
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
					
					$('#table-marks tbody').empty();
					
					sum_marks = 0;
					sum_base_marks = 0;
					
					for (var i = 0; i < mentor_room_evaluations.length; ++i) 
					{
						sum_marks += +mentor_room_evaluations[i].marks;
						sum_base_marks += +mentor_room_evaluations[i].base_mark;
						
						marks_row =	'<tr>'+
									'<td width="200px" id="criteria-">'+ (i+1)+'</td>'+
									'<td width="200px" id="criteria-">'+ mentor_room_evaluations[i].criteria+'</td>'+
									'<td width="100px">'+ mentor_room_evaluations[i].marks +' </td>'+
									'<td width="100px">on '+ mentor_room_evaluations[i].base_mark +' </td>'+
								'</tr>';
					
						$('#table-marks tbody').append(marks_row);

					}	
					
						sum_row = '<tr>'+
								'<th class="head-font" style="width:10rem"></th>'+
								'<th class="head-font"  style="width:20rem">SUM:</th>'+
								'<th class="head-font" style="width:20rem">'+ sum_marks +'</th>'+
								'<th class="head-font" style="width:20rem">on '+ sum_base_marks +'</th>'+
							'</tr>';
							
						$('#table-marks tfoot').empty();
						$('#table-marks tfoot').append(sum_row);
						
						mentor_room_evaluation_statuses = result_data['mentor_room_evaluation_statuses'];
						
						comment_row = '<tr>'+
								'<th class="" style="width:20rem">'+ mentor_room_evaluation_statuses[0].ev_comment +'</th>'+
							'</tr>';
							
						$('#table-comment tbody').empty();
						$('#table-comment tbody').append(comment_row);
						
						
						
						
				    
				}
			});
			
	}
	
	
	
	$(document).on('click', '#btn-save-eval-approval', function(event)
	{
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/update_approve_evaluation';
		
		eval_approved = $('#chk-eval-approved').is(':checked') ? 1 : 0;
		eval_rejected = $('#chk-eval-rejected').is(':checked') ? 1 : 0;

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['room_id'] = room_id;
		data['student_id'] = student_id;
		data['eval_approved'] = eval_approved;
		data['eval_rejected'] = eval_rejected;
		data['admin_comment'] = $('#admin_comment').val();
				
		
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
			
			
		
	});
	

</script>

<body>
@include('admin.layouts.ela-admin-topbar')
    <main class="main students-login">
        <div class="jumbotron">
            <div class="container">
                <div class="row pb-0">
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Activity List</h3>
                            <p class="sub-text">Admin for ELA School</p>
                        </div>
                    </div>
                    <div class="col-3 text-right">
						<a href="{{url('admin/activity/create-activity')}}">
							<button type="button" class="btn btn-third" >
								<img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
								New Activity
							</button>
						</a>
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            
            <div class="row pt-30 pb-90">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                        aria-controls="home" aria-selected="true">All Activities</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="evaluation-tab" data-toggle="tab" href="#tab-pane-evaiuation-approval" role="tab" aria-controls="home" aria-selected="true">Evaluation Approval</a></a><!--List of Student wise Activities whose Mentor Evaluation Completed. -->
                                </li>
								
                                <li class="nav-item">
                                    <a class="nav-link " id="finished-tab" data-toggle="tab" href="#tab-pane-evaiuation-approval" role="tab" aria-controls="home" aria-selected="true">Finished Activities</a><!--List of Actvities whose Learning Session and Mentor Evaluation of all allocated students Completed. -->
                                </li>
								<!--
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                        aria-controls="contact" aria-selected="false">Reviewed</a>
                                </li>
								-->
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:20rem">Activity</th>
                                            <th class="head-font" style="width:10rem">Created Date</th>
                                            <th class="head-font" style="width:10rem">Due Date</th>
                                            <th class="head-font" style="width:10rem">Grades</th>
                                            <th class="head-font" style="width:10rem">Groups</th>
                                            <th class="head-font" style="width:12rem">Individuals</th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($approved_activities as $key=>$approved_activity) 
											<?php
											
												$rm_id = $approved_activity->room_id ;
												
												$rooms_own_grades = app()->call([$cc, 'get_grades_by_room_id'], [$rm_id]);
																																			
												$rooms_own_groups = app()->call([$cc, 'get_groups_by_room_id'], [$rm_id]);
																								
												$rooms_own_students = app()->call([$cc, 'get_students_by_room_id'], [$rm_id]);
												
											?>
												
												
                                        <tr>
                                            <td>{{$key+1 }}</td>
                                            <td colspan="2">
                                                <p class="dark-blue font-weight-bold">{{$approved_activity->activity_title }}</p>
                                            </td>
                                            <td class="orage">{{ Carbon\Carbon::parse($approved_activity->sent_for_approval_date)->format('d-m-Y') }} </td> 
                                            <td class="orage">{{ Carbon\Carbon::parse($approved_activity->room_expiry_date)->format('d-m-Y') }}</td> 
                                            <td class="orage">{{implode(', ', $rooms_own_grades) }}</td>
                                            <td class="orage">{{implode(', ', $rooms_own_groups) }}</td> 
                                            <td class="individuals">
												<!--
													<span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
													<span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
													<span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
													+ 7 More
												-->
												{{implode(', ', $rooms_own_students) }}
                                            </td>
											<!--
                                            <td class="text-success"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                                Active
                                            </td>
											-->
                                           <!-- <td><a href="{{url('admin/view-activity/'. $approved_activity->activity_id)}}"><button type="button" class="btn btn-primary">View</button></a></td>-->
                                            <td>
												<a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$approved_activity->activity_id}}" data-room_id="{{$approved_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
                                            <td class="dropdown dropdots td-approve-options dropleft" value="{{$approved_activity->id }}">
                                                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" id="" class="a-stud-allocation" data-backdrop="static" data-keyboard="false" data-activity_title="{{$approved_activity->activity_title}}" data-room_id="{{$approved_activity->room_id}}" data-expiry_date="{{ Carbon\Carbon::parse($approved_activity->room_expiry_date)->format('Y-m-d')}}" data-toggle="modal" data-target="#modal-stud-allocation">Edit Allocations</a></li>
													
                                                    <li><a href="#" class="li-change-expiry-date" data-room_id="{{$approved_activity->room_id}}" data-expiry_date="{{ Carbon\Carbon::parse($approved_activity->room_expiry_date)->format('Y-m-d')}}" data-toggle="modal" data-target="#modalDueDate">Change Due Date</a></li>
													<!--
                                                    <li><a href="#" data-toggle="modal" data-target="#reject">Reject</a></li>
													-->
                                                </ul>
                                            </td>
                                        </tr>
										@endforeach
									
                                    </tbody>
                                </table>
								
								<!--Change Due Date Modal -->
                                <div class="modal fade" id="modalDueDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Change Due Date</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
																				
										<div class="form-group col-md-6 mt-1">
											<div class="input-group-append">
												<div class="">
													<label class="form-check-label " for="inp-expiry-date" id="lbl-mated" >Due date</label>
												</div>
											</div>
											

											<input  type="date" class="form-control mt-1"  id="inp-expiry-date" >
										</div>
										
										
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button id="btn-update-expiry_date" type="button" class="btn btn-primary">Update</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

								
								
                            </div>
                            <div class="tab-pane fade " id="tab-pane-evaiuation-approval" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font" style="width:10rem">Sl. No.</th>
                                            <th class="head-font"  style="width:20rem">MENTOR</th>
                                            <th class="head-font" style="width:20rem">STUDENT</th>
                                            <th class="head-font" style="width:20rem">ACTIVITY</th>
                                            <th class="head-font" style="width:12rem">EVALUATED DATE</th>
                                            <th class="head-font" style="width:10rem">VIEW</th>
                                            <th class="head-font" style="width:10rem"></th>
                                        </tr>
                                    </thead>
									<?php
									
									
										
									?>
                                    <tbody>
									
										@foreach($mentor_room_evaluation_statuses as $key=>$mentor_room_evaluation_status) 
                                        <tr>
                                            <td>{{$key+1 }}</td>
                                            <td >
                                                <p class="dark-blue font-weight-bold">{{$mentor_room_evaluation_status->mentor_first_name . ' '. $mentor_room_evaluation_status->mentor_last_name}}</p>
                                            </td>
                                            <td >
                                                <p class="dark-blue font-weight-bold">{{$mentor_room_evaluation_status->student_first_name . ' '. $mentor_room_evaluation_status->student_last_name}}</p>
                                            </td>
                                            <td class="orage">{{$mentor_room_evaluation_status->activity_title }}</td> 
											@php 
												$evaluation_completed_date = Carbon\Carbon::parse($mentor_room_evaluation_status->evaluation_completed_date) ;  
												$evaluation_completed_date =($evaluation_completed_date)->format('d-m-Y'); 
											@endphp
                                            <td>
											{{$evaluation_completed_date}}
                                            </td>
                                            <td>
												<a id="a-stud-activity-view" href="#" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target=".bd-example-modal-lg" data-room_id="{{$mentor_room_evaluation_status->room_id}}" data-student_id="{{$mentor_room_evaluation_status->student_id}}" data-activity_title="{{$mentor_room_evaluation_status->activity_title }}" >
												<button value=""  type="button" class="btn btn-primary ">View</button>
												</a>
											</td>
                                            <td class="dropdown dropdots td-approve-options dropleft">
                                                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
													<!--
                                                    <li><a href="#" data-toggle="modal" data-target="#approve">Approve</a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#reject">Reject</a></li>
													-->
                                                </ul>
                                            </td>
                                        </tr>
										@endforeach
										
                                    </tbody>
                                </table>
								
                               
                                <!--Approve Modal -->
                                <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Approve</h5>
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
										
										<div class="form-group">
											<div class="input-group-append">
												<div class="">
													<label class="form-check-label " for="inp-publish-date" id="lbl-mated" >Publish date</label>
												</div>
											</div>
											<input  type="date" class="form-control mt-1"  id="inp-publish-date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
										</div>
										
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button id="btn-update-approval" type="button" class="btn btn-primary">Update</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                            </div>
							
							
							
							
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	
	@include('layouts.activity-eval-modal')
<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	

	@include('layouts.stud-allocation-modal')
	
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