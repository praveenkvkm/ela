<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')
<script>
$(document).ready(function() {
	
		publish_id = 0;
		publish_date = '';

    $('#goats-table').DataTable();
	
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
	
});


	
	$(document).on('click', '.check-approve', function()
	{
		publish_id = $(this).attr('value');
		publish_date = $('#inp-publish-date-' + publish_id ).val();
		
		
		approve_activity_publish();
		
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
					alert('Updated.');
							
				}
			});

	}	
	

</script>
<style>

#item-dashboard i, #item-dashboard p
{
    color: #28a745!important;
}

.col-total
{
	font-weight:bold;
	font-size:14px!important;
	
}
</style>
<body>
	<div class="wrapper">
		@include('admin.layouts.topbar')

		@include('admin.layouts.sidebar-admin')
		
		<?php
		
			$act_publishs = array();
			
			$act_publishs = DB::table('act_publishs')
			->leftJoin('mentor_on_activity_rooms', 'act_publishs.room_id', '=', 'mentor_on_activity_rooms.id')
			->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
			->leftJoin('ela_users', 'act_publishs.user_id_sent_by', '=', 'ela_users.id')
			->select('act_publishs.*', 'activities.id AS activity_id', 'activities.activity_title AS activity_title', 'ela_users.first_name AS mentor_first_name')
			->whereNull('act_publishs.deleted_at')
			->orderBy('act_publishs.sent_for_approval_date')
			->get();
		
			
		?>
		
		<div class="main-panel">
		
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">ADMIN DASHBOARD</h4>
						<!--
						<div class="btn-group btn-group-page-header ml-auto">
							<button type="button" class="btn btn-light btn-round btn-page-header-dropdown dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-ellipsis-h"></i>
							</button>
							<div class="dropdown-menu">
								<div class="arrow"></div>
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Separated link</a>
							</div>
						</div>
						-->
					</div>
					<div class="row">
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-primary bubble-shadow-small">
												<i class="fas fa-users"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Mentors</p>
												<h4 class="card-title">112</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-info bubble-shadow-small">
												<i class="fas fa-users"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Students</p>
												<h4 class="card-title">1303</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-success bubble-shadow-small">
												<i class="far fa-chart-bar"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Activites</p>
												<h4 class="card-title"> 1,345</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-secondary bubble-shadow-small">
												<i class="far fa-check-circle"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">New Orders</p>
												<h4 class="card-title">576</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row row-card-no-pd">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<h4 class="card-title">ACTIVITIES SUBMITTED FOR APPROVAL</h4>
										<!--
										<div class="card-tools">
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"><span class="fa fa-sync-alt"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-times"></span></button>
										</div>
										-->
									</div>
									<!--<p class="card-category">
									Map of the distribution of users around the world</p>-->
								</div>
								<div class="card-body text-center">
								
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive table-hover table-sales">
												<table id="goats-table" class="table table-striped table-bordered" style="width:100%">
													<thead>
														<tr>
															<th>SRL.NO.</th>
															<th>TITLE.</th>
															<th>ACTIVITY</th>
															<th>MENTOR NAME</th>
															<th>SENT DATE</th>
															<th>TENTATED DATE</th>
															<th>PUBLISH DATE</th>
															<th>APPROVE</th>
														</tr>
													</thead>
													<tbody>
														@foreach($act_publishs as $key=>$act_publish) 
														<?php
														
															$act_accessories = array();
															
															$act_accessories = DB::table('act_accessories')
															->where([['activity_id', '=', $act_publish->activity_id], ['act_acs_type_id', '=', 1] ])
															->whereNull('act_accessories.deleted_at')
															->get();
															
														?>
															<tr style="cursor:pointer" value="">
																<td>{{$key+1 }}</td>
																<td>{{$act_publish->activity_title }}</td>
																@if(count($act_accessories) > 0)
																{
																	<td>
																	
																	<video width="150" height="120" controls>
																		<source src="{{url('/public').($act_accessories[0]->acs_file_path ) .  $act_accessories[0]->acs_file_name }}" type="video/mp4">
																	</video>
																	</td>
																}
																@else
																{
																	<td>''</td>
																}
																@endif
																<td>{{$act_publish->mentor_first_name }}</td>
																<td>{{$act_publish->sent_for_approval_date }}</td>
																<td>{{$act_publish->tentated_publish_date }}</td>
																<td>
																	<input id="inp-publish-date-{{$act_publish->id}}" value="{{ Carbon\Carbon::now()->format('Y-m-d')}}" type="date" class="form-control " placeholder="Name">
																</td>
																<td>
																	<input id="" value="{{$act_publish->id }}" type="checkbox" class="form-control check-approve" placeholder="Name">
																</td>
															</tr>
														@endforeach
													</tbody>
													<tfoot>
														<tr>
															<th>SRL.NO.</th>
															<th>TITLE.</th>
															<th>ACTIVITY</th>
															<th>MENTOR NAME</th>
															<th>SENT DATE</th>
															<th>TENTATED DATE</th>
															<th>PUBLISH DATE</th>
															<th>APPROVE</th>
														</tr>
													</tfoot>
												</table>												
												
											</div>
										</div>
										
									</div><!--row ends-->
									
									
								</div>
							</div>
						</div>
					</div>
					
					
					
					
				</div>
			</div>
			
		</div>
		
	</div>
</div>

@include('layouts.footer')

</body>
</html>