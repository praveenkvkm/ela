<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$stud_grades =  app()->call([$cc, 'get_stud_grades']);
$students =  app()->call([$cc, 'get_students']);
$stud_groups =  app()->call([$cc, 'get_stud_groups']);
?>
<script>
$(document).ready(function() {
	room_id = 0;
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
	
});


	$(document).on('click', '.a-stud-allocation', function()
	{
		room_id = $(this).data('room_id');
		activity_title = $(this).data('activity_title');
		
		$('.check-stud').prop('checked', false);
		$('.check-grade').prop('checked', false);
		$('.check-group').prop('checked', false);
		
		$('#activity_title_edit_allocation').html('<span>Activity: ' + activity_title + '</span>');
		get_allocations_by_room_id();
	});
	
	
	function get_allocations_by_room_id()
	{

		var	url_var = APP_URL + '/get_allocations_by_room_id';
		
		var data = {};
		data['room_id'] = room_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   rooms_own_students = result_data['rooms_own_students'];
				   rooms_own_groups = result_data['rooms_own_groups'];
				   rooms_own_grades = result_data['rooms_own_grades'];
				   					
					for (var i = 0; i < rooms_own_students.length; ++i) 
					{
						$('#check-stud-' + rooms_own_students[i].student_id).prop('checked', true);
					}
					
					for (var i = 0; i < rooms_own_groups.length; ++i) 
					{
						$('#check-group-' + rooms_own_groups[i].stud_group_id).prop('checked', true);
					}
					
					for (var i = 0; i < rooms_own_grades.length; ++i) 
					{
						$('#check-grade-' + rooms_own_grades[i].stud_grade_id).prop('checked', true);
					}
					
					
				}
				
			});

	}	


	$(document).on('change', '.check-stud', function(event)
	{
		stud_checked = $(this).is(':checked') ? 1 : 0;
		student_id = $(this).data('student_id');
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/edit_allocate_student_in_activity';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['stud_checked'] = stud_checked;
		data['room_id'] = room_id;
		data['student_id'] = student_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					room_id = result_data;
				}
			});
			
			
		
	});
	
	
	$(document).on('change', '.check-group', function(event)
	{
		
		group_checked = $(this).is(':checked') ? 1 : 0;
		stud_group_id = $(this).data('stud_group_id');
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/edit_allocate_group_in_activity';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['group_checked'] = group_checked;
		data['room_id'] = room_id;
		data['stud_group_id'] = stud_group_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					room_id = result_data;
				}
			});
		
	});
	
	
	$(document).on('change', '.check-grade', function(event)
	{
		
		grade_checked = $(this).is(':checked') ? 1 : 0;
		stud_grade_id = $(this).data('stud_grade_id');
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		var url_var =  APP_URL + '/edit_allocate_grade_in_activity';
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['grade_checked'] = grade_checked;
		data['room_id'] = room_id;
		data['stud_grade_id'] = stud_grade_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,  
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					room_id = result_data;
				}
			});
			
		
	});


	
	
	
</script>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-stud-allocation">
		<div class="modal-dialog modal-lg  modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-7">
							<h3 class="modal-title" id="">
								<span>Edit Allocations</span>
							</h3>
							
							<h4 class="modal-title" id="activity_title_edit_allocation">
								<span>Edit Allocations</span>
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="view_activity_subjects">
							</h5>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-modal-view-activity-close" onclick="location.reload()">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs nav-tabs-media">
						<li id="li-stud"><a data-toggle="tab" href="#tab-stud" class="active show">Students</a></li>
						<li id="li-group"><a data-toggle="tab" href="#tab-group">Groups</a></li>
						<li id="li-grade"><a data-toggle="tab" href="#tab-grade">Grades</a></li>
					</ul>

					<div class="tab-content mt-10">
						<!--STUDENT ALLOCATION------------------>
						<div id="tab-stud" class="tab-pane tab-pane-media fade active show ">
							<h3 class="modal_activity_title" id="modal_activity_title_docs"></h3>
							<p class="modal_activity_description" id="modal_activity_description_docs">
							
							</p>
							
							<div class="row students-lists">
							
								@foreach($students as $key=>$student) 
									<?php
										$profile_pic_path = url('/public') . '/' . $student->prof_pic_path . $student->prof_pic_file ;
									?>		
									
								<div class="col-md-12 single-student">
									@if( @GetImageSize($profile_pic_path))
									<div class="student-pic" style="background: url({{$profile_pic_path}}">
									
									
									</div>
									<div class="name">
										{{$student->first_name .' '. $student->last_name }}
										<span></span>
									</div>
									@else
									<div class="student-pic" style="background: #25d7fb;display: flex;justify-content: center;align-items: center;font-size: 15px;font-weight: 700;color: #fff;">
										<a >
											<div class="submitted-by">
												<span class="grade" style="height:auto;">{{strtoupper(substr($student->first_name, 0, 1)) . strtoupper(substr($student->last_name, 0, 1)) }}</span>
											</div>
										</a>
									</div>
									<div class="name">
										{{$student->first_name .' '. $student->last_name }}
										<span></span>
									</div>
									
									@endif
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input check-stud" value="" data-student_id="{{$student->id}}" id="check-stud-{{$student->id}}">
										</label>
									</div>
								</div>
								@endforeach
								
								
							</div>

							
						</div>
						<!--GROUP ALLOCATION------------------>
						<div id="tab-group" class="tab-pane tab-pane-media fade">
							<h3 class="modal_activity_title" id="modal_activity_title_audio"></h3>
							<p class="modal_activity_description" id="modal_activity_description_audio">
							</p>
                            
							<div class="row students-lists">
							@foreach($stud_groups as $key=>$stud_group) 
							<div class="col-md-12 single-student">
								<div class="name">
									{{$stud_group->stud_group  }}
								</div>
								<div class="form-check">
									<label class="form-check-label">
										<input type="checkbox" class="form-check-input check-group "  data-stud_group_id="{{$stud_group->id}}" value="" id="check-group-{{$stud_group->id}}">
									</label>
								</div>
							</div>
							@endforeach
							</div>
							
						</div>
						<!--GRADE ALLOCATION------------------>
						<div id="tab-grade" class="tab-pane tab-pane-media fade">
							<h3 class="modal_activity_title" id="modal_activity_title_docs"></h3>
							<p class="modal_activity_description" id="modal_activity_description_docs">
							
							</p>
							
							<div class="row students-lists">
							
								@foreach($stud_grades as $key=>$stud_grade) 
								<div class="col-md-12 single-student">
									<div class="name">
										{{$stud_grade->stud_grade  }}
									</div>
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input check-grade" value="" data-stud_grade_id="{{$stud_grade->id}}" id="check-grade-{{$stud_grade->id}}">
										</label>
									</div>
								</div>
								@endforeach
								
							</div>
							
							
						</div>
						
					</div>

				</div>
				
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="">
								<span></span>
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="">
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
