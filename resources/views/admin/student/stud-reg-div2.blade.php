<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$school_manage_categories =  app()->call([$cc, 'get_school_manage_categories']);

?>
            <div class="row pb-90">
                <div class="col-md-8 m-auto">
                    <div class="card p-60">
                        <div class="row">
                            <div class="col-md-8 text-center m-auto mb-20">
                                <h1 style="font-size: 24px;">Academics</h1>
                                <!--
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex elit, suscipit nec
                                    venenatis vitae, convallis id elit.
								</p>
								-->
                            </div>
                            <div class="col-md-12">
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
                                            <label for="instruction">Class</label>
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
                                            <label for="city">School Sub. District</label>
                                            <input type="text" class="form-control" id="school_sub_district">
                                        </div>
										
                                        <div class="form-group col-md-6">
                                            <label for="city">School Edl. District</label>
                                            <input type="text" class="form-control" id="school_edu_district">
                                        </div>
										
                                        <div class="form-group col-md-6">
        								<?php
        									$districts = DB::table('districts')
        										->whereNull('deleted_at')
        										->get();
        								?>		
                                            <label for="district">School Rev. District</label>
                                            <select id="school_district_id" class="form-control">
        										@foreach($districts as $key=>$district) 
        											<option value="{{$district->id}}">{{$district->district}}</option>
        										@endforeach
                                            </select>
                                        </div>
										
										<!--
                                        <div class="form-group col-md-6">
                                            <label for="city">School Rev. District</label>
                                            <input type="text" class="form-control" id="school_revenue_district">
                                        </div>
										-->
                                        
                                    </div>
        
                                    <a href="#" class="btn btn-primary" id="a-continue-2">Next</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


