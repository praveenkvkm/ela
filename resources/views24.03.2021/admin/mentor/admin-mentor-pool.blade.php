@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$mentors =  app()->call([$cc, 'get_non_approved_mentors']);
$mentor_types =  app()->call([$cc, 'get_mentor_types']);
$mentor_categories =  app()->call([$cc, 'get_mentor_categories']);

?>
<body>
@include('admin.layouts.ela-admin-topbar')

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
	<script>
$(document).ready(function(){
	
	$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		selected_groups = [];
	
		
		mentor_id = '{{ $mentors[0]->ela_user_id }}'; /* GET FIRST MENTOR ID  */
		
				
		get_mentor_full_detail_by_id(mentor_id); /* GET FIRST MENTOR DETAIL  */
		
		
		$(document).on('click', '#a-add-new-mentor', function()
		{
			set_session_add_new_mentor_from_page();
			
		});
	
	
		$(document).on('click', '.tr-mentor', function(event)
		{
			event.preventDefault;
			
			mentor_id = $(this).attr('value');
			get_mentor_full_detail_by_id(mentor_id);
			
			
		});
		
		
		$(document).on('click', '#a-update-edit-mentor', function()
		{
			
			if(!$('#first_name').val())
			{
				alert('Please enter First Name.');
			}
			else
			{
				
				if(confirm("Are you sure to Update ?"))
				{
					update_non_approved_mentor();
				}
				
				
			}
			
			
		});
		
		

		
		


});



	function update_non_approved_mentor()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/update_non_approved_mentor';
		approved = $('#approved').is(':checked') ? 1 : 0;
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['id'] = mentor_id;
				
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['res_address'] = $('#res_address').val();
		data['off_address'] = $('#off_address').val();
		data['designation'] = $('#designation').val();
		data['mentor_type_id'] = $('#mentor_type_id').val();
		data['mentor_category_id'] = $('#mentor_category_id').val();
		data['approved'] = approved;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   
				   if(result_data =='dup')
				   {
						alert('Email id or Mobile number Already Exists.');
				   }
				   else
				   {
						alert('Updated.');
					   if(result_data ==0)
					   {
							document.location.href = APP_URL + '/admin/dashboard';
					   }
					   else
					   {
							location.reload();
					   }
				   }
				   
				   
				}
			});
			
	}
	
	
	function set_session_add_new_mentor_from_page()
	{

		var	url_var = APP_URL + '/set_session_add_new_mentor_from_page';
		
		var data = {};
		data['add_new_mentor_from_page'] = '/admin/mentor/admin-mentors';
		
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
	
	

	function get_mentor_full_detail_by_id(mentor_id)
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_mentor_full_detail_by_id';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['mentor_id'] = mentor_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   
					selected_mentor = result_data['selected_mentor'];
				  	var last_name = selected_mentor[0].last_name ? selected_mentor[0].last_name : '';
					
					
				    $('#h-sel-mentor-name').html('<span class="text-left" >' + selected_mentor[0].first_name + ' ' + last_name + '</span>');
				   
				   var f_letter_1 = (selected_mentor[0].first_name).substring(0, 1);
				   var f_letter_2 = last_name.substring(0, 1);
				   
				    $('#span-sel-mentor-name-abbr').html(f_letter_1  + f_letter_2 );
				   
				   
					fill_mentor_edit_detail(selected_mentor);
				   
				}
			});
			
	}

	
	function fill_mentor_edit_detail(selected_mentor)
	{		
		 $('#first_name').val(selected_mentor[0].first_name);
		 $('#last_name').val(selected_mentor[0].last_name);
		 $('#mobile').val(selected_mentor[0].mobile);
		 $('#email').val(selected_mentor[0].email);
		 $('#res_address').val(selected_mentor[0].res_address);
		 $('#off_address').val(selected_mentor[0].off_address);
		 $('#designation').val(selected_mentor[0].designation);
		 $('#mentor_type_id').val(selected_mentor[0].mentor_type_id);
		 $('#mentor_category_id').val(selected_mentor[0].mentor_category_id);
		 
		 $('#active').val(selected_mentor[0].active);
		 
	}
	
</script>

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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Mentor Pool</h3>
                            <p class="sub-text">Admin for ELA School</p>
                        </div>
                    </div>
                    <div class="col-3 text-right">
						<a id="a-add-new-mentor" href="{{url('admin/mentor/add-mentor')}}"> 
                        <button type="button" class="btn btn-third" >
                            <img src="{{asset('public/ela-assets/images/pls.png')}}" class="img-fluid">
                            New Mentor
                        </button>
						</a>
                    </div>
                </div>
            </div>
			
			
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="row admin-lists">
                <div class="col-md-12">
                    <div class="row">
					
					<!--
                        <div class="col-3">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Assigned</option>
                                    <option>Assigned</option>
                                    <option>Assigned</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Sort</option>
                                    <option>Sort</option>
                                    <option>Sort</option>
                                </select>
                            </div>
                        </div>
					-->	
						
                    </div>
                </div>
            </div>
            <div class="row pb-90">
                <div class="col-md-12">
                    <div class="card p-30">
                        <div class="row">
                            <div class="col-md-4 lists-search">
                                <input class="form-control" id="myInput" type="text" placeholder="Search Mentors">
                                <div class="list-height-fix mt-30">
                                    <table class="table">
                                        <tbody id="myTable">
											@foreach($mentors as $key=>$mentor) 
                                            <tr class="tr-mentor" value="{{$mentor->ela_user_id}}" style="cursor:pointer">
											<!--
                                                <td>
                                                    <a href="#">
                                                        <div class="submitted-by">
                                                            <span style="background: url({{asset('public/ela-assets/images/s1.png)no-repeat;')}}"></span>
                                                            Jakob Vaccaro
                                                        </div>
                                                    </a>
                                                </td>
											-->	
                                                <td>
                                                    <a >
                                                        <div class="submitted-by">
                                                            <span class="grade">{{strtoupper(substr($mentor->first_name, 0, 1)) . strtoupper(substr($mentor->last_name, 0, 1)) }}</span>
                                                           {{$mentor->first_name . ' ' . $mentor->last_name }}
                                                        </div>
                                                    </a>
                                                </td>
												 
                                            </tr>
											@endforeach
											
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-8 profile-wrap">
							<!--
                                <div class="profile">
                                    <span style="background: url({{asset('public/ela-assets/images/jordyn.png)no-repeat;')}}"></span>
                                    <h3>Jordyn Dias</h3>
                                </div>
							-->	
								<div class="profile submitted-by ">
									<span id="span-sel-mentor-name-abbr" class="grade ">{{strtoupper(substr($mentors[0]->first_name, 0, 1)) . strtoupper(substr($mentors[0]->last_name, 0, 1)) }}</span>
									<h3 id="h-sel-mentor-name"><span class="text-left" >{{$mentors[0]->first_name . ' ' . $mentors[0]->last_name }}</span></h3>
								</div>
								
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="firstname">First Name</label>
													<input type="text" class="form-control" id="first_name" value="{{$mentors[0]->first_name }}">
												</div>
												<div class="form-group col-md-6">
													<label for="lastname">Last Name</label>
													<input type="text" class="form-control" id="last_name" value="{{$mentors[0]->last_name }}">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="mobile">Mobile</label>
													<input type="text" class="form-control" id="mobile" value="{{$mentors[0]->last_name }}">
												</div>
												<div class="form-group col-md-6"> 
													<label for="email">Email</label> 
													<input type="text" class="form-control" id="email" value="{{$mentors[0]->last_name }}">
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
														<option {{ $mentor_type->id == $mentors[0]->mentor_type_id ? "selected":""}} value="{{$mentor_type->id}}">
															{{$mentor_type->mentor_type}}
														</option>
														@endforeach
													</select>
												</div>
												<div class="form-group col-md-6">
													<label for="gender">Mentor Category</label>
													<select id="mentor_category_id" class="form-control">
														@foreach($mentor_categories as $key=>$mentor_category)  
														<option value="{{$mentor_category->id}}" {{ $mentor_category->id == $mentors[0]->mentor_category_id ? "selected":""}}  >
															{{$mentor_category->mentor_category}}
														</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="approved">
														<label class="form-check-label" for="active">Approve</label>
													</div>
												</div>
											</div>
											
                                            <a style="color:white;" id="a-update-edit-mentor" class="btn btn-primary float-right">Submit</a>
											
                                        </form>
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