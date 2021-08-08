<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$genders =  app()->call([$cc, 'get_genders']);

?>
            <div class="row pb-90">
                <div class="col-md-8 m-auto">
                    <div class="card p-60">
                        <div class="row">
                            <div class="col-md-8 text-center m-auto mb-20">
                                <h1 style="font-size: 24px;">Personal Information</h1>
                                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.</p>-->
                            </div>
                            <div class="col-md-12">
								<form>
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
											<label for="gender">Gender</label>
											<select id="gender_id" class="form-control">
												@foreach($genders as $key=>$gender) 
													<option value="{{$gender->id}}">{{$gender->gender}}</option>
												@endforeach
											</select>
										</div>
										
										<div class="form-group col-md-6 mt-1">
											<div class="input-group-append">
												<div class="">
													<label class="form-check-label " for="stud_dob" id="lbl-mated" >Date of Birth</label>
												</div>
											</div>
											<input  type="date" class="form-control mt-1"  id="stud_dob" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
										</div>
										
									</div>

									<a href="#" class="btn btn-primary" id="a-continue-1">Next</a>
								</form>
							
                           </div>
                        </div>
                    </div>
                </div>
            </div>

