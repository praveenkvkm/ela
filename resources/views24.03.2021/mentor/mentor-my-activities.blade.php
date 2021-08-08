@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$mentors_own_groups =  app()->call([$cc, 'get_mentors_own_groups']);
$count_mentors_own_groups = count($mentors_own_groups);
$mentors_own_students =  app()->call([$cc, 'get_mentors_own_students']);
$count_mentors_own_students = count($mentors_own_students);
$sent_for_approval_activities =  app()->call([$cc, 'get_sent_for_approval_activities_by_mentor_id']);
$pending_approval_activities =  app()->call([$cc, 'get_pending_approval_activities_of_mentor']);
$approved_activities =  app()->call([$cc, 'get_approved_activities_of_mentor']);

//$mentors_own_groups = app()->call([$cc, 'get_mentors_own_groups'], [Auth::guard('ela_user')->user()->id]);
?>
<script>
$(document).ready(function() {
	
	activity_id =0;
	room_id = 0;
	publish_id = 0;
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
	
}); 

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


	$(document).on('click', '#a-add-new-student', function()
	{
		set_session_add_new_student_from_page();
		
	});
	
	
	function set_session_add_new_student_from_page()
	{

		var	url_var = APP_URL + '/set_session_add_new_student_from_page';
		
		var data = {};
		data['add_new_student_from_page'] = '/admin/dashboard';
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					//alert(result_data);
							
				}
			});

	}	
	


	$(document).on('click', '.td-approve-options', function()
	{
		publish_id = $(this).attr('value');
		
	});
	
	
	$(document).on('click', '#btn-update-rejection', function()
	{
		if($('#reason_for_rejection').val())
		{
			if(confirm('Confirm Approval ?'))
			{
				approve_activity_rejection();
			}
		}
		else
		{
			alert('Please Enter Reason.');
		}
	});
	
	
	function approve_activity_rejection()
	{

		var	url_var = APP_URL + '/approve_activity_rejection';
		
		var data = {};
		data['publish_id'] = publish_id;
		data['reason_for_rejection'] = $('#reason_for_rejection').val();
		
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
	

	$(document).on('click', '#btn-update-approval', function()
	{
		publish_date = $('#inp-publish-date').val();
		if(confirm('Confirm Approval ?'))
		{
			approve_activity_publish();
		}
		
	});
	
	
	function approve_activity_publish()
	{

		var	url_var = APP_URL + '/approve_activity_publish';
		
		var data = {};
		data['publish_id'] = publish_id;
		data['publish_date'] = publish_date;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert('Approved.');
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
				   					
					video_path = "{{url('/public')}}" + act_acs_videos[0].acs_file_path + act_acs_videos[0].acs_file_name ;
					
						video_source = '<source src="' + video_path + '" type="video/mp4">' + 
										'<source src="' +   video_path + '" type="video/ogg">';
										
										
						audio_path = "{{url('/public')}}" + act_acs_audios[0].acs_file_path + act_acs_audios[0].acs_file_name ;
						
						audio_source = '<source src="' + audio_path + '" type="audio/ogg">' + 
										'<source src="' +   audio_path + '" type="audio/mpeg">';
																
						docs_source = "{{url('/public')}}" + act_acs_docs[0].acs_file_path + act_acs_docs[0].acs_file_name ;
			  
										
					$('#videoActivity').empty();
					$('#videoActivity').html(video_source);
					
					$('#audioActivity').empty();
					$('#audioActivity').html(audio_source);
					
					$('#docsActivity').attr('src', docs_source)
				   
					$('#view_activity_title').html(activity_master[0].activity_title + '<span>For Grades ' + act_pbsh_grades.join(", ") + '</span>');
					
					$('#view_activity_subjects').html('Subjects <span>' + act_pbsh_subjects.join(", ") + '</span>');
					
				}
			});

	}	
	

</script>
<body>
@include('mentor.layouts.ela-mentor-topbar')
<!--
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="images/elaschool.png" width="120"></a>
            <!-- Navbar
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="images/2.jpg" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="images/1.jpg" width="24" /></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/avatar.jpg" width="30"></a>
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
					
                    <div class="col-9 d-flex">
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/mentor/dashboard')}}"> {{ $user_name }}</a> / My Activities</h3>
                            <!--<p class="sub-text">Expert in Science Subjects</p>-->
                        </div>
                    </div>
					
					
                    <div class="col-3 text-right">
						
						<a href="{{url('mentor/activity/create-activity')}}" class="float-right" style="display:inline-block;">
							<button type="button" class="btn btn-third">
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
                                    <a class="nav-link active" id="all-activities-tab" data-toggle="tab" href="#all-activities" role="tab"
                                        aria-controls="all-activities" aria-selected="true">All Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sent-for-approval-tab" data-toggle="tab" href="#sent-for-approval" role="tab"
                                        aria-controls="sent-for-approval" aria-selected="false">Sent for Approval</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab"
                                        aria-controls="approved" aria-selected="false">Approved</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all-activities" role="tabpanel" aria-labelledby="all-activities-tab">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:16rem">Activity</th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($sent_for_approval_activities as $key=>$sent_for_approval_activity) 
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$sent_for_approval_activity->activity_title }}</p>
                                            </td>
											<?php
												$rm_id = $sent_for_approval_activity->room_id ;
												$rooms_own_groups = app()->call([$cc, 'get_rooms_own_groups'], [$rm_id]);
												$grps = $rooms_own_groups->pluck('stud_group')->toArray();

											?>
                                            <!--<td class="orage">{{implode(', ', $grps) }}</td>-->
                                            <td class="orage"></td>
                                            <td class="individuals">
											<!--
                                                <span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
                                                + 7 More
												-->
                                            </td>
                                            <td class="text-success">
                                                <!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td>
                                            <td></td> 
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$sent_for_approval_activity->activity_id}}" data-room_id="{{$sent_for_approval_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
								<!--
								<a href="{{url('mentor/activity/create-activity')}}">
                                <button type="button" class="btn btn-third float-right mt-30">
                                    <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                                    New Activity
                                </button>
								</a>
								-->
                            </div>
                            <div class="tab-pane fade" id="sent-for-approval" role="tabpanel" aria-labelledby="sent-for-approval-tab">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:16rem">Activity</th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($pending_approval_activities as $key=>$pending_approval_activity) 
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$pending_approval_activity->activity_title }}</p>
                                            </td>
											<?php
												$rm_id = $pending_approval_activity->room_id ;
												$rooms_own_groups = app()->call([$cc, 'get_rooms_own_groups'], [$rm_id]);
												$grps = $rooms_own_groups->pluck('stud_group')->toArray();

											?>
                                            <!--<td class="orage">{{implode(', ', $grps) }}</td>-->
                                            <td class="orage"></td>
                                            <td class="individuals">
											<!--
                                                <span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
                                                + 7 More
												-->
                                            </td>
                                            <td class="text-success">
                                                <!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td>
                                            <td></td> 
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$pending_approval_activity->activity_id}}" data-room_id="{{$pending_approval_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="head-font">Sl. No.</th>
                                            <th class="head-font" colspan="2" style="width:16rem">Activity</th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font" style="width:12rem"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($approved_activities as $key=>$approved_activity) 
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td colspan="2">
                                                <p class="orange font-weight-bold">{{$approved_activity->activity_title }}</p>
                                            </td>
											<?php
												$rm_id = $approved_activity->room_id ;
												$rooms_own_groups = app()->call([$cc, 'get_rooms_own_groups'], [$rm_id]);
												$grps = $rooms_own_groups->pluck('stud_group')->toArray();

											?>
                                            <!--<td class="orage">{{implode(', ', $grps) }}</td>-->
                                            <td class="orage"></td>
                                            <td class="individuals">
											<!--
                                                <span class="individual-students" style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s2.png)no-repeat;')}}"></span>
                                                <span class="individual-students ml-21" style="background: url({{asset('public/ela-assets/images/s3.png)no-repeat;')}}"></span>
                                                + 7 More
												-->
                                            </td>
                                            <td class="text-success">
                                                <!--<i class="fa fa-clock-o" aria-hidden="true"></i>Active-->
                                            </td>
                                            <td></td> 
											
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$approved_activity->activity_id}}" data-room_id="{{$approved_activity->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
											
                                            <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
                            </div>
							<!--
                            <a href="{{url('mentor/activity/create-activity')}}" class="float-right" style="display:inline-block;">
                                 <button type="button" class="btn btn-third float-right mt-30">
    							<img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
    							New Activity
    							</button>
    						</a>
							-->
                        </div>
						

                    </div>
                </div>
				
				
				
				
				
				
				
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
	
<!--------------VIEW ACTIVITY MODAL BEGINS-------------------------------------------------------------------------------->	
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-view-activity">
		<div class="modal-dialog modal-lg  modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="view_activity_title">Displacement, velocity, and time
								<span></span>
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="view_activity_subjects">
							</h5>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-modal-view-activity-close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
						<li><a data-toggle="tab" href="#menu1" class="active show">Video</a></li>
						<li><a data-toggle="tab" href="#menu2">Audio</a></li>
						<li><a data-toggle="tab" href="#menu3">PDF</a></li>
					</ul>

					<div class="tab-content mt-40">
						<div id="menu1" class="tab-pane fade  active show">
							<div class="video-wrap" >
								<video width="100%" controls id="videoActivity">
								</video>
								
								
							</div>
							<h3 class="pt-30">
							</h3>
							<p>
							</p>
							<p>
							</p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h3>Menu 2</h3>
							<p></p>
							
							<audio controls id="audioActivity">
							</audio>
							
							
						</div>
						<div id="menu3" class="tab-pane fade">
							<h3>Menu 3</h3>
							<p></p>
							<iframe id="docsActivity" width="99%" height="300px" class="doc">

							</iframe>
						</div>
					</div>

				</div>
				
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="view_activity_title">Displacement, velocity, and time
								<span></span>
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="view_activity_subjects">
							</h5>
						</div>
					</div>
					<button type="button">
						<span></span>
					</button>
				</div>
				
			</div>
		</div>
	</div>
<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	
	
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