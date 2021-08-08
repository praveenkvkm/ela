@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$act_publishs=  app()->call([$cc, 'get_on_publish_activities']);

$count_pending_approval = count($act_publishs);

$approved_activities =  app()->call([$cc, 'get_approved_activities_of_mentor']);
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
					alert('Updated Rejection.');
					location.reload();
							
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
		data['room_expiry_date'] = $('#inp-expiry-date').val();
		
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Activity Pool</h3>
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
                    <div class="card cards-list-wrap">
                        <div class="card-header bg-white">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                        aria-controls="home" aria-selected="true">All Activities</a>
                                </li>
								<!--
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false">Pending</a>
                                </li>
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
                                            <th class="head-font" style="width:9rem">Created Date</th>
                                            <th class="head-font" style="width:10rem">Submitted By</th>
                                            <th class="head-font">Suggested Grades</th>
                                            <th class="head-font"></th>
                                            <th class="head-font"></th>
                                        </tr>
                                    </thead>
									<?php
									
									
										
									?>
                                    <tbody>
									
										@foreach($act_publishs as $key=>$act_publish) 
											<?php
											
												$act_pbsh_grades = array();
												$grades =  array();
												
												$act_pbsh_grades = DB::table('act_pbsh_grades')
												->leftJoin('stud_grades', 'act_pbsh_grades.stud_grade_id', '=', 'stud_grades.id')
												->select('act_pbsh_grades.*', 'stud_grades.stud_grade AS stud_grade')
												->where([['act_pbsh_grades.room_id', '=', $act_publish->room_id] ])
												->whereNull('act_pbsh_grades.deleted_at')
												->get();
											?>
												@foreach($act_pbsh_grades as $key2=>$act_pbsh_grade) 
													@php array_push($grades, $act_pbsh_grade->stud_grade ); @endphp
												@endforeach
                                        <tr>
                                            <td>{{$key+1 }}</td>
                                            <td colspan="2">
                                                <p class="dark-blue font-weight-bold">{{$act_publish->activity_title }}</p>
                                            </td>
											@php 
											
												$sent_for_approval_date = Carbon\Carbon::parse($act_publish->sent_for_approval_date) ;  
												$sent_for_approval_date =($sent_for_approval_date)->format('d-m-Y'); 
											@endphp
											
                                            <td class="orage">{{$sent_for_approval_date }}</td> 
                                            <td>
                                                <div class="submitted-by">
                                                    <span style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
														{{$act_publish->ela_user_sent_by_first_name}}
                                                </div>
                                            </td>
                                            <td>{{implode(', ', $grades) }}</td>
                                           <!-- <td><a href="{{url('admin/view-activity/'. $act_publish->activity_id)}}"><button type="button" class="btn btn-primary">View</button></a></td>-->
                                            <td>
												<a href="#" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target=".bd-example-modal-lg">
												<button value="{{$act_publish->activity_id}}" data-room_id="{{$act_publish->room_id}}" type="button" class="btn btn-primary btn-view-activity">View</button>
												</a>
											</td>
                                            <td class="dropdown dropdots td-approve-options dropleft" value="{{$act_publish->id }}">
                                                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" data-toggle="modal" data-target="#approve">Approve</a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#reject">Reject</a></li>
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
										
										<div class="form-group col-md-6 mt-1">
											<div class="input-group-append">
												<div class="">
													<label class="form-check-label " for="inp-publish-date" id="lbl-mated" >Publish date</label>
												</div>
											</div>
											<input  type="date" class="form-control mt-1"  id="inp-publish-date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
										</div>
										
										<div class="form-group col-md-6 mt-1">
											<div class="input-group-append">
												<div class="">
													<label class="form-check-label " for="inp-expiry-date" id="lbl-mated" >Expiry date</label>
												</div>
											</div>
											<input  type="date" class="form-control mt-1"  id="inp-expiry-date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
										</div>
										
										
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button id="btn-update-approval" type="button" class="btn btn-primary">Update</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                 <!--Reject Modal -->
                                <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Reject</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="form-group">
                                            <label for="reason_for_rejection">Reason for rejection</label>
                                            <textarea maxlength="500" class="form-control" id="reason_for_rejection" rows="4">
											
											</textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button id="btn-update-rejection" type="button" class="btn btn-primary">Save</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>								
                            </div>

                        </div>
						
						
						
						
						
                    </div>
                </div>
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
<!--------------VIEW ACTIVITY MODAL ENDS-------------------------------------------------------------------------------->	
	@include('layouts.activity-modal')
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