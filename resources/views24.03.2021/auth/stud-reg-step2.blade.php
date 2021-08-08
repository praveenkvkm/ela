@include('layouts.ela-header')

<body>
<script>
$(document).ready(function(){
	
	
		$(document).on('click', '#a-continue', function(event)
		{
			
			
			
			if(!$('#school_name').val())
			{
				alert('Please enter School Name.');
			}
			else
			{
				/*
				if(confirm("Are you sure to Update and Continue ?"))
				{
					insert_stud_reg_academic();
				}
				*/
				
				insert_stud_reg_academic();
			}
			
			
		});
		
		
		

	});
	

	function insert_stud_reg_academic()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';

		var url_var ='insert_stud_reg_academic';
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['standard_id'] = $('#standard_id').val();
		data['medium_id'] = $('#medium_id').val();
		data['syllabus_id'] = $('#syllabus_id').val();
		data['school_name'] = $('#school_name').val();
		data['school_district_id'] = $('#school_district_id').val();
		data['school_address'] = $('#school_address').val();
		data['school_manage_category_id'] = $('#school_manage_category_id').val();
		data['school_sub_district'] = $('#school_sub_district').val();
		data['school_revenue_district'] = $('#school_revenue_district').val();
		
						
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if(result_data ==1)
				   {
						document.location.href = 'stud-reg-bio';
				   }
				}
			});
			
	}
	
	
</script>
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$school_manage_categories =  app()->call([$cc, 'get_school_manage_categories']);

?>
    <section class="main-login register">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-5" style="background: url({{asset('public/ela-assets/images/login-bg.jpg) no-repeat;')}}">
                    <h1>
                        Sign in to<br> Dedication, Innovation<br> and Entertainment.
                    </h1>
                </div>
                <div class="col-md-7">
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
                                <div class="initial">
                                    <div class="dot"></div>
                                    <span>Bio</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mb-40">
                                <h2>Tell us about your academics.</h2>
                                <p>{{Session::get('student_id_being_updated')}}Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.</p>
                            </div>
                        </div>
								<form>
                                    <div class="form-row">
        							<!--
                                        <div class="form-group col-md-6">
                                            <label for="class">Class</label>
                                            <input type="text" class="form-control" id="class">
                                        </div>
        							-->
        								<?php
        									$standards = DB::table('standards')
        										->whereNull('deleted_at')
        										->get();
        								?>							
                                        <div class="form-group col-md-6">
                                            <label for="instruction">Standard in School</label>
                                            <select id="standard_id" class="form-control">
        										@foreach($standards as $key=>$standard) 
        											<option value="{{$standard->id}}">{{$standard->standard}}</option>
        										@endforeach
                                            </select>
                                        </div>
        								<?php
        									$mediums = DB::table('mediums')
        										->whereNull('deleted_at')
        										->get();
        								?>							
                                        <div class="form-group col-md-6">
                                            <label for="instruction">Medium of Instruction</label>
                                            <select id="medium_id" class="form-control">
        										@foreach($mediums as $key=>$medium) 
        											<option value="{{$medium->id}}">{{$medium->medium}}</option>
        										@endforeach
                                            </select>
                                        </div>
                                    </div>
        							
                                    <div class="form-row">
        								<?php
        									$syllabuses = DB::table('syllabuses')
        										->whereNull('deleted_at')
        										->get();
        								?>							
                                        <div class="form-group col-md-6">
                                            <label for="syllabus">Syllabus</label>
                                            <select id="syllabus_id" class="form-control">
        										@foreach($syllabuses as $key=>$syllabus) 
        											<option value="{{$syllabus->id}}">{{$syllabus->syllabus}}</option>
        										@endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="school">Name of the School</label>
                                            <input type="text" class="form-control" id="school_name">
                                        </div>
                                    </div>
                                    <div class="form-row">
        								<?php
        									$districts = DB::table('districts')
        										->whereNull('deleted_at')
        										->get();
        								?>		
        								<div class="form-group col-md-12">
                                            <label for="city">School - Address</label>
                                            <textarea class="form-control" id="school_address" rows="2"></textarea>
                                            
        
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="city">School - Management</label>
                                            <select id="school_manage_category_id" class="form-control">
        										@foreach($school_manage_categories as $key=>$school_manage_category) 
        											<option value="{{$school_manage_category->id}}">{{$school_manage_category->school_manage_category}}</option>
        										@endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="district">School - District</label>
                                            <select id="school_district_id" class="form-control">
        										@foreach($districts as $key=>$district) 
        											<option value="{{$district->id}}">{{$district->district}}</option>
        										@endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="city">Sub District</label>
                                            <input type="text" class="form-control" id="school_sub_district">
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="city">Revenue District</label>
                                            <input type="text" class="form-control" id="school_revenue_district">
                                        </div>
                                        
                                        
                                    </div>
        
                                    <a href="#" class="btn btn-primary" id="a-continue">Next</a>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

	@include('layouts.ela-footer')

</body>

</html>