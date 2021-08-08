@include('layouts.ela-header')

<body>
<script>

$(document).ready(function(){
	
	
		$(document).on('click', '#a-continue', function(event)
		{
			
			
			
			if(!$('#parent_name').val())
			{
				alert('Please enter Parent Name.');
			}
			else
			{
				/*
				if(confirm("Are you sure to Update and Continue ?"))
				{
					insert_stud_reg_bio();
				}
				*/
					insert_stud_reg_bio();
				
			}
			
			
		});
		
		
		

	});
	
	

	function insert_stud_reg_bio()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_stud_reg_bio';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['parent_name'] = $('#parent_name').val();
		data['parent_relation_id'] = $('#parent_relation_id').val();
		data['house_address'] = $('#house_address').val();
		data['house_pin'] = $('#house_pin').val();
		data['parent_job'] = $('#parent_job').val();
		data['guardian_employer_id'] = $('#guardian_employer_id').val();
		data['house_block'] = $('#house_block').val();
		data['house_district_id'] = $('#house_district_id').val();
		data['house_panchayath'] = $('#house_panchayath').val();
		data['parent_email'] = $('#parent_email').val();
		data['parent_phone'] = $('#parent_phone').val();
		data['parent_whatsapp'] = $('#parent_whatsapp').val();
				
						
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==1)
				   {
					   alert('Registration Completed Successfully. Phone alert will be received when you are approved. Thank you.');
						document.location.href = "{{ url('/') }}";
				   }
				}
			});
			
	}
	
	
</script>
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$parent_relationships =  app()->call([$cc, 'get_parent_relationships']);
$guardian_employers =  app()->call([$cc, 'get_guardian_employers']);
$districts =  app()->call([$cc, 'get_districts']);

?>
    <section class="main-login register">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-5" style="background: url({{asset('public/ela-assets/images/login-bg.jpg) no-repeat;')}}">
                    <h1>
                        Sign in to<br> Dedication, Innovation<br> and Entertainment.
                    </h1>
                </div>
                <div class="col-md-7 pt-60 pb-60">
                    <div class="register-steps">
                        <div class="row timeline mb-60">
                            <div class="col-4">
                                <div class="initial active">
                                    <div class="dot"></div>
                                    <span>Basic</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="initial active line">
                                    <div class="dot"></div>
                                    <span>Academic</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="initial active line">
                                    <div class="dot"></div>
                                    <span>Bio</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mb-40">
                                <h2>And a few personal details.</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.</p>
                            </div>
                        </div>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="parent_name">Name of Father/ Mother/ Guardian</label>
                                    <input type="text" class="form-control" id="parent_name">
                                </div>
								
								<div class="form-group col-md-6">
									<label for="instruction">Relationship</label>
									<select id="parent_relation_id" class="form-control">
										@foreach($parent_relationships as $key=>$parent_relationship) 
											<option value="{{$parent_relationship->id}}">{{$parent_relationship->parent_relationship}}</option>
										@endforeach
									</select>
								</div>
								
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="house_address">Home Address</label>
                                    <textarea class="form-control" id="house_address" rows="2"></textarea>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="house_pin">PIN Code</label>
                                    <input type="text" class="form-control" id="house_pin" maxlength="10">
                                </div>
                            </div>
                            <div class="form-row">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="parent_job">Job of Guardian</label>
                                    <input type="text" class="form-control" id="parent_job">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="guardian_employer_id">Employer</label>
									<select id="guardian_employer_id" class="form-control">
										@foreach($guardian_employers as $key=>$guardian_employer) 
											<option value="{{$guardian_employer->id}}">{{$guardian_employer->guardian_employer}}</option>
										@endforeach
									</select>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="house_block">Block</label>
                                    <input type="text" class="form-control" id="house_block">
                                </div>
								
                                <div class="form-group col-md-6">
                                    <label for="parent_email">District</label>
									<select id="house_district_id" class="form-control">
										@foreach($districts as $key=>$district) 
											<option value="{{$district->id}}">{{$district->district}}</option>
										@endforeach
									</select>
                                </div>
								
                                <div class="form-group col-md-6">
                                    <label for="parent_phone">Panchayath</label>
                                    <input type="text" class="form-control" id="house_panchayath">
                                </div>
								
                                <div class="form-group col-md-6">
                                    <label for="parent_email">Email ID</label>
                                    <input type="text" class="form-control" id="parent_email">
                                </div>
                              
                                 <div class="form-group col-md-6">
                                    <label for="parent_phone">Phone Number</label>
                                    <input type="text" class="form-control" id="parent_phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="parent_whatsapp">WhatsApp Number</label>
                                    <input type="text" class="form-control" id="parent_whatsapp">
                                </div>
                                
                            </div>
                            
                            <a href="#" type="" class="btn btn-primary" id="a-continue">Next</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

	@include('layouts.ela-footer')

</body>

</html>