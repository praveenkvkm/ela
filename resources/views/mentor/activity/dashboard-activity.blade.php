<!DOCTYPE html>
<html lang="en">
@include('mentor.activity.layouts.header')
<style>
.browse-file
{
	cursor:pointer;
}

#item-content i, #item-content p
{
    color: #28a745!important;
}

</style>
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
		
	activity_id = 0;
	count_video_files = 0;
	count_audio_files = 0;
	count_docs_files = 0;
	
	
	$('#description').val('');
    $('#goats-table').DataTable();
	
	//$('#div-parent').load("add-media");
	
	
} );


	
	$(document).on('click', '#btn-continue-to-media', function()
	{
		
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
					$('#div-parent').load("add-media");
				}
			}
		
		
	});
	
	
	$(document).on('click', '#browse-video', function()
	{
		$("#inputfiles_video").trigger("click");
		
	});
	
	$(document).on('click', '#browse-audio', function()
	{
		$("#inputfiles_audio").trigger("click");
		
	});

	$(document).on('click', '#browse-docs', function()
	{
		$("#inputfiles_docs").trigger("click");
		
	});
	 
	
	$(document).on('click', '#btn-continue-to-invite-students', function()
	{	
		
		if(count_video_files > 0)
		{
			upload_act_acs('video');
		}
		
		if(count_audio_files > 0)
		{
			upload_act_acs('audio');
		}
		
		if(count_docs_files > 0)
		{
			upload_act_acs('docs');
		}
		
		$('#div-parent').load("add-invite-students");

		
	});
	
	
	$(document).on('click', '#btn-continue-to-publish', function()
	{	
		
		
		$('#div-parent').load("send-for-approval");

		
	});
	
	$(document).on('change', '.inp-files', function()
	{
		var inp_file_type = $(this).attr('id');
		
			var names = [];
			for (var i = 0; i < $(this).get(0).files.length; ++i) 
			{
				names.push($(this).get(0).files[i].name );
			}
			
			if(inp_file_type == 'inputfiles_video')
			{
				$("#inp-video").val(names.join(', '));
				count_video_files = names.length;
			}
			else if(inp_file_type == 'inputfiles_audio')
			{
				$("#inp-audio").val(names.join(', '));
				count_audio_files = names.length;
			}
			else if(inp_file_type == 'inputfiles_docs')
			{
				$("#inp-docs").val(names.join(', '));
				count_docs_files = names.length;
			}
	
	});	
	
	
	
	
	function insert_activity_content()
	{
		APP_URL = "{{ url('/') }}";		
		
		var url_var = APP_URL + '/insert_activity_content';
					
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
				}
			});
			
	}
	
	
	function upload_act_acs(act_acs_type)
		{
			APP_URL = "{{ url('/') }}";		
			
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
				async:false,
				cache: false,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function (dataofconfirm) 
				{
					// do something with the result
					alert("Files uploaded successfully.");
					//hideLoader();
				}
			});

		}
		
		
function showLoader() 
{
    $(".loader").css("display", "");
}

function hideLoader() 
{
    setTimeout(function () {
        $(".loader").css("display", "none");
    }, 1000);
}

</script>
<style>
/*
#item-dashboard i, #item-dashboard p
{
    color: #28a745!important;
}
*/
.col-total
{
	font-weight:bold;
	font-size:14px!important;
	
}
</style>
<body>
	<div class="wrapper">
		@include('mentor.activity.layouts.topbar')

		@include('mentor.activity.layouts.sidebar-activity')
		
		<?php
			
		?>
		
		<div class="main-panel">
		
			<div class="content">
				<div class="page-inner">
				<!--
					<div class="page-header">
						<h4 class="page-title">Dashboard</h4>
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
					</div>
					-->
					
					
					<div class="row row-card-no-pd">
						<div class="col-md-12">						
							<div class="card">
							
								<div class="card-header">
									<div class="card-head-row">
										<h4 class="card-title">ACTIVITY DASHBOARD</h4>
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
								
								<div class="card-body " id="div-parent"> <!--CONTENT DIV BEGINS------------->
									<div id="div-content">
										<h4 class="card-title">CONTENT</h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="email2">Add Headline</label>
													<input  type="text" class="form-control" id="activity_title" value="">
												</div>
																								
												<div class="form-group">
													<label for="comment">Add Description</label>
													<textarea class="form-control" id="description" rows="5">

													</textarea>
												</div>
												
												
											</div>
											<div class="col-md-6">
											</div>
											
											
										</div>
									
									</div>
									
								<div class="card-action">
									<button id="btn-continue-to-media" class="btn btn-success">Continue</button>
								</div>
									
									
								</div> <!--CONTENT DIV ENDS------------->
								
							</div><!--CARD ends-->
							
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