@include('layouts.ela-header')
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$mentor_types =  app()->call([$cc, 'get_mentor_types']);
$mentor_categories =  app()->call([$cc, 'get_mentor_categories']);


?>
<script>
$(document).ready(function(){
	
	
		$(document).on('click', '#a-continue', function(event)
		{
			
			if(!$('#first_name').val())
			{
				alert('Please enter FirstName');
			}
			else if(!$('#last_name').val())
			{
				alert('Please enter Last Name');
			}
			else if(!$('#mobile').val())
			{
				alert('Please enter Mobile number');
			}
			else if(!$('#email').val())
			{
				alert('Please enter Email');
			}
			else
			{
				if(confirm("Are you sure to Update ?"))
				{
					insert_mentor();
				}
				
			}
			
		});
		
		

	});
	

	function insert_mentor()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var	url_var = APP_URL + '/insert_mentor';
		
		active = $('#active').is(':checked') ? 1 : 0;
		approved = $('#approved').is(':checked') ? 1 : 0;
		
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['first_name'] = $('#first_name').val();
		data['last_name'] = $('#last_name').val();
		data['mobile'] = $('#mobile').val();
		data['email'] = $('#email').val();
		data['res_address'] = $('#res_address').val();
		data['off_address'] = $('#off_address').val();
		data['designation'] = $('#designation').val();
		data['mentor_type_id'] = $('#mentor_type_id').val();
		data['mentor_category_id'] = $('#mentor_category_id').val();
		data['approved'] = 0;
		data['active'] = 1;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data == 1)
				   {
					   alert('Updated.');
					   clear_elements();
					   $('#first_name').focus();
				   }
				   else
				   {
					   alert('Emailid or Mobile Number Already Existing.');
					   
				   }
				   
				}
			});
			
	}
	
	
	function clear_elements()
	{
		
		$('#first_name').val('');
		$('#last_name').val('');
		$('#mobile').val('');
		$('#email').val('');
		$('#res_address').val('');
		$('#off_address').val('');
		$('#designation').val('');
		$('#mentor_type_id').val('');
		$('#mentor_category_id').val('');
			
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
                            <h3 class="font-weight-bold main-fo"><a style="color:black" href="{{url('/admin/dashboard')}}"> {{ $user_name }}</a> / Add Mentor</h3>
                            <p class="sub-text">Admin for ELA School</p>
                        </div>
                    </div>
                    <div class="col-3 text-right">
					<!--
                        <button type="button" class="btn btn-third">
                            <img src="images/pls.png" class="img-fluid">
                            New Student
                        </button>
						-->
                    </div>
                </div>
            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            
            <div class="row pb-90">
                <div class="col-md-8 m-auto">
                    <div class="card p-60">
                        <div class="row">
                            <div class="col-md-8 text-center m-auto mb-20">
                                <h1 style="font-size: 24px;">Hi, let us know about you.</h1>
                                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.</p>-->
                            </div>
                            <div class="col-md-12">
                                <form class="students-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">First Name</label>
                                            <input type="text" class="form-control" id="first_name"  oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" class="form-control" id="last_name"  oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" id="mobile" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-6"> 
                                            <label for="email">Email</label> 
                                            <input type="text" class="form-control" id="email">
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
                                                <option value="{{$mentor_type->id}}" >{{$mentor_type->mentor_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="gender">Mentor Category</label>
                                            <select id="mentor_category_id" class="form-control">
												@foreach($mentor_categories as $key=>$mentor_category)  
                                                <option value="{{$mentor_category->id}}" >{{$mentor_category->mentor_category}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									
									
                                    <div class="form-row" style="display:none;">
                                        <div class="form-group col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="active">
                                                <label class="form-check-label" for="active">Active</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="approved">
                                                <label class="form-check-label" for="approved">Approved</label>
                                            </div>    
                                        </div>
                                    </div>
                                    
                                    <a id="a-continue" class="btn btn-primary" style="cursor:pointer">Save</a>
                                </form>
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