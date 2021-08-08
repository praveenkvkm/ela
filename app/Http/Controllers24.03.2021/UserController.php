<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;
use Carbon\Carbon;
use Session;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //protected $guard = 'admin';

    //protected $redirectTo = '/';
	
//============================USER TABLE INSERT=======================================//	


	public function upload_profile_pic(Request $request)    
	{		
		$root = public_path();
		$cnt = count($request->image);
		$profile_user_id = $request->profile_user_id;
		
			for( $i = 0; $i<($cnt); $i++ ) 
					{
						$input = $request->all();
						$input['image'] = $request->image[$i]->getClientOriginalName();
						$file_name = str_replace(' ', '', $input['image']);  //<-- removes spaces from file name
						$dirtarget = $request->dirtarget . '/';
						$request->image[$i]->move(public_path($dirtarget), $file_name);
						
						DB::table('ela_users')
								->where([['id', '=', $profile_user_id] ])
								->update
								(
									[
										'prof_pic_path' => $dirtarget,
										'prof_pic_file' => $file_name
										
									]
								);
						
					}
					
			return 1;
		
	}




	public function update_activate_student(Request $req)
    {
				
		$resp_count = DB::table('ela_users')
				->where([['stud_reg_number', '=', $req->reg_number], ['id', '!=', $req->id]])
				->count();
				
		if(!$resp_count)
		{
			DB::table('students')
					->where([['user_id', '=', $req->id] ])
					->update
					(
						[
							'active' => $req->active,
							'stud_grade_id' => $req->stud_grade_id,
							'updated_at' => Carbon::now()->toDateTimeString()
							
						]
					);
					
			DB::table('ela_users')
					->where([['id', '=', $req->id] ])
					->update
					(
						[
							'stud_reg_number' => $req->reg_number,
							'updated_at' => Carbon::now()->toDateTimeString()
							
						]
					);
					
				$this->allocate_grade_to_student($req);		
					
			
			return 1;
		}
		else
		{
			
			return 0;
		}

	}

	


	public function update_approve_student(Request $req)
    {
		$resp_count = DB::table('ela_users')
				->where([['stud_reg_number', '=', $req->reg_number], ['id', '!=', $req->id]])
				->count();
				
		if(!$resp_count)
		{
			DB::table('students')
					->where([['user_id', '=', $req->id] ])
					->update
					(
						[
							'approved' => $req->approved,
							'active' => $req->approved,
							'stud_grade_id' => $req->stud_grade_id,
							'updated_at' => Carbon::now()->toDateTimeString()
							
						]
					);
					
			DB::table('ela_users')
					->where([['id', '=', $req->id] ])
					->update
					(
						[
							'approved' => $req->approved,
							'active' => $req->approved,
							'stud_reg_number' => $req->reg_number,
							'updated_at' => Carbon::now()->toDateTimeString()
							
						]
					);
					
					
				$this->allocate_grade_to_student($req);		
					
				$count_non_approved_students = DB::table('ela_users')
					->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
					->where([['ela_users.user_type_id', '=', 3]])
					->where([['students.approved', '=', 0]])
					->whereNull('ela_users.deleted_at')
					->count();

				return $count_non_approved_students;
					
			
		}
		else
		{
			
			return 'dup';
		}

	}
	
	
	public function allocate_grade_to_student(Request $req)    
	{	
				
		$rec_count = DB::table('studs_in_grades')
				->where([['student_id', '=', $req->id]  ])
				->whereNull('deleted_at')
				->count();
				
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
						
				DB::table('studs_in_grades')
						->insert
						(
							[
								'stud_grade_id' => $req->stud_grade_id,
								'student_id' => $req->id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
				return 1;
		}
		else	// IF THIS STUDENT IS ALREADY ALLOCATED.
		{
				DB::table('studs_in_grades')
						->where([['student_id', '=', $req->id]  ])
						->whereNull('deleted_at')
						->update
						(
							[
								'stud_grade_id' => $req->stud_grade_id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
						

			return 1;
				
			
			
		}	
		
	}
	
	
	public function reset_password(Request $req)
    {
		$user =	DB::table('ela_users')
					->where([['id', '=', $req->id] ])
					->get();
					
					
		if (Hash::check($req->old_password, $user[0]->password)) 
		{ 
			DB::table('ela_users')
					->where([['id', '=', $req->id] ])
					->update
					(
						[
							'password' => bcrypt($req->new_password)
						]
					);
					
					return 1;
		}
		else
		{
					return 0;
		}
		
	}	
	
	public function set_password(Request $req)
    {
			DB::table('ela_users')
					->where([['id', '=', $req->id] ])
					->update
					(
						[
							'password' => bcrypt($req->new_password)
						]
					);
					
					return 1;
		
	}	
	
	
	public function update_approved_mentor(Request $req)
    { 
		
		$resp_count = DB::table('ela_users')
				->where([['mobile', '=', $req->mobile], ['id', '!=', $req->id]])
				->orWhere([['email', '=', $req->email], ['id', '!=', $req->id]])
				->whereNotNull('mobile')
				->whereNotNull('email')
				->count();
		
		if(!$resp_count)
		{
	
				DB::table('ela_users')
						->where([['id', '=', $req->id] ])
						->update
						(
							[
								'first_name' => $req->first_name,
								'last_name' => $req->last_name,
								'mobile' => $req->mobile,
								'email' => $req->email,
								'approved' => $req->approved,
								'active' => $req->approved,
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'updated_at' => Carbon::now()->toDateTimeString()

							]
						);
						

						
				DB::table('mentors')
						->where([['user_id', '=', $req->id] ])
						->update
						(
							[
								'res_address' => $req->res_address,
								'off_address' => $req->off_address,
								'designation' => $req->designation,
								'mentor_type_id' => $req->mentor_type_id,
								'mentor_category_id' => $req->mentor_category_id,
								'active' => $req->active,
								'approved' => $req->approved,
								'active' => $req->approved,
								'updated_at' => Carbon::now()->toDateTimeString()
								
							]
						);
						
				
				
				$count_approved_mentors = DB::table('ela_users')
					->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
					->where([['ela_users.user_type_id', '=', 2]])
					->where([['mentors.approved', '=', 1]])
					->whereNull('ela_users.deleted_at')
					->count();

				return $count_approved_mentors;
		}
		else
		{
			
			return 'dup';
		}
		


	}
	
	
	public function update_non_approved_mentor(Request $req)
    { 
		
		$resp_count = DB::table('ela_users')
				->where([['mobile', '=', $req->mobile], ['id', '!=', $req->id]])
				->orWhere([['email', '=', $req->email], ['id', '!=', $req->id]])
				->whereNotNull('mobile')
				->whereNotNull('email')
				->count();
		
		if(!$resp_count)
		{
	
				DB::table('ela_users')
						->where([['id', '=', $req->id] ])
						->update
						(
							[
								'first_name' => $req->first_name,
								'last_name' => $req->last_name,
								'mobile' => $req->mobile,
								'email' => $req->email,
								'approved' => $req->approved,
								'active' => $req->approved,
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'updated_at' => Carbon::now()->toDateTimeString()

							]
						);
						

						
				DB::table('mentors')
						->where([['user_id', '=', $req->id] ])
						->update
						(
							[
								'mentor_type_id' => $req->mentor_type_id,
								'mentor_category_id' => $req->mentor_category_id,
								'approved' => $req->approved,
								'active' => $req->approved,
								'updated_at' => Carbon::now()->toDateTimeString()
								
							]
						);
						
				
				
				$count_non_approved_mentors = DB::table('ela_users')
					->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
					->where([['ela_users.user_type_id', '=', 2]])
					->where([['mentors.approved', '=', 0]])
					->whereNull('ela_users.deleted_at')
					->count();

				return $count_non_approved_mentors;
		}
		else
		{
			
			return 'dup';
		}
		


	}


	public function update_edit_student(Request $req)
    {
				
		DB::table('ela_users')
				->where([['id', '=', $req->id] ])
				->update
				(
					[
						'first_name' => $req->first_name,
						'last_name' => $req->last_name,
						'updated_at' => Carbon::now()->toDateTimeString()
					]
				);
				
		$stud_disease_details = ($req->stud_disease == 1) ? $req->stud_disease_details : '';
				
		DB::table('students')
				->where([['user_id', '=', $req->id] ])
				->update
				(
					[
		
						'gender_id' => $req->gender_id,
						'stud_dob' => $req->stud_dob,
						'standard_id' => $req->standard_id,
						'medium_id' => $req->medium_id,
						'syllabus_id' => $req->syllabus_id,
						'school_name' => $req->school_name,
						'school_edu_district' => $req->school_edu_district,
						'school_address' => $req->school_address,
						'school_manage_category_id' => $req->school_manage_category_id,
						'school_sub_district' => $req->school_sub_district,
						'school_district_id' => $req->school_district_id,				
						'father_name' => $req->father_name,
						'father_phone' => $req->father_phone,
						'father_job' => $req->father_job,
						'father_emp_ctg_id' => $req->father_emp_ctg_id,
						'mother_name' => $req->mother_name,
						'mother_phone' => $req->mother_phone,
						'mother_job' => $req->mother_job,
						'mother_emp_ctg_id' => $req->mother_emp_ctg_id,
						'guardian_name' => $req->guardian_name,
						'guardian_phone' => $req->guardian_phone,
						'guardian_job' => $req->guardian_job,
						'guardian_emp_ctg_id' => $req->guardian_emp_ctg_id,
						'house_address' => $req->house_address,
						'house_panchayath' => $req->house_panchayath,
						'house_block' => $req->house_block,
						'house_district_id' => $req->house_district_id,
						'house_pin' => $req->house_pin,
						'stud_blood_group_id' => $req->stud_blood_group_id,
						'stud_height' => $req->stud_height,
						'stud_weight' => $req->stud_weight,
						'stud_physical_status_id' => $req->stud_physical_status_id,
						'stud_disease' => $req->stud_disease,
						'stud_disease_details' => $stud_disease_details,
						'whatsapp_1' => $req->whatsapp_1,
						'whatsapp_2' => $req->whatsapp_2,
						'other_member_name' => $req->other_member_name,
						'other_member_std' => $req->other_member_std,
						'other_member_rel' => $req->other_member_rel,
						'email_id' => $req->email_id,
						'updated_at' => Carbon::now()->toDateTimeString()
						
					]
				);

		return 1;

	}
	
	
	public function insert_mentor(Request $req)
    {
		
		$resp_count = DB::table('ela_users')
				->where([['mobile', '=', $req->mobile]])
				->orWhere([['email', '=', $req->email]])
				->whereNotNull('mobile')
				->whereNotNull('email')
				->count();
		
		if(!$resp_count)
		{
		
			DB::table('ela_users')
					->insert
					(
						[
							'user_type_id' => 2,
							'first_name' => $req->first_name,
							'last_name' => $req->last_name,
							'mobile' => $req->mobile,
							'email' => $req->email,
							'user_id_recorded_by' => Auth::guard('ela_user')->user()->id
							
						]
					);
					
			$user_id = DB::getPdo()->lastInsertId();
			

			DB::table('mentors')
					->insert
					(
						[ 
							'user_id' => $user_id,
							'res_address' => $req->res_address,
							'off_address' => $req->off_address,
							'designation' => $req->designation,
							'mentor_type_id' => $req->mentor_type_id,
							'mentor_category_id' => $req->mentor_category_id,
							'active' => $req->active
						]
					);
					
			
			return 1;
			
		}
		else
		{
			return 0;
		}
		
		
    }




	public function insert_stud_reg_bio(Request $req)
    {

		$student_id_being_updated = Session::get('student_id_being_updated');
		
		$stud_disease_details = ($req->stud_disease == 1) ? $req->stud_disease_details : '';
		
		DB::table('students')
				->where([['user_id', '=', $student_id_being_updated] ])
				->update
				(
					[
						'father_name' => $req->father_name,
						'father_phone' => $req->father_phone,
						'father_job' => $req->father_job,
						'father_emp_ctg_id' => $req->father_emp_ctg_id,
						'mother_name' => $req->mother_name,
						'mother_phone' => $req->mother_phone,
						'mother_job' => $req->mother_job,
						'mother_emp_ctg_id' => $req->mother_emp_ctg_id,
						'guardian_name' => $req->guardian_name,
						'guardian_phone' => $req->guardian_phone,
						'guardian_job' => $req->guardian_job,
						'guardian_emp_ctg_id' => $req->guardian_emp_ctg_id,
						'house_address' => $req->house_address,
						'house_panchayath' => $req->house_panchayath,
						'house_block' => $req->house_block,
						'house_district_id' => $req->house_district_id,
						'house_pin' => $req->house_pin,
						'stud_blood_group_id' => $req->stud_blood_group_id,
						'stud_height' => $req->stud_height,
						'stud_weight' => $req->stud_weight,
						'stud_physical_status_id' => $req->stud_physical_status_id,
						'stud_disease' => $req->stud_disease,
						'stud_disease_details' => $stud_disease_details,
						'whatsapp_1' => $req->whatsapp_1,
						'whatsapp_2' => $req->whatsapp_2,
						'other_member_name' => $req->other_member_name,
						'other_member_std' => $req->other_member_std,
						'other_member_rel' => $req->other_member_rel,
						'email_id' => $req->email_id,
						'updated_at' => Carbon::now()->toDateTimeString()
						
						
					]
				);
				
				
				
				
				
		
		return 1;
			

    }
	

	public function insert_stud_reg_academic(Request $req)
    {


		$student_id_being_updated = Session::get('student_id_being_updated');
		
				
		DB::table('students')
				->where([['user_id', '=', $student_id_being_updated] ])
				->update
				(
					[
						'standard_id' => $req->standard_id,
						'medium_id' => $req->medium_id,
						'syllabus_id' => $req->syllabus_id,
						'school_name' => $req->school_name,
						'school_edu_district' => $req->school_edu_district,
						'school_address' => $req->school_address,
						'school_manage_category_id' => $req->school_manage_category_id,
						'school_sub_district' => $req->school_sub_district,
						'school_district_id' => $req->school_district_id,
						'updated_at' => Carbon::now()->toDateTimeString()
					]
				);
				
				
		
		return 1;
			

    }


	public function insert_stud_reg_basic(Request $req)
    {

		$user_id_recorded_by = (Auth::guard('ela_user')->check()) ? Auth::guard('ela_user')->user()->id : null;
		
		DB::table('ela_users')
				->insert
				(
					[
						'user_type_id' => 3,
						'first_name' => $req->first_name,
						'last_name' => $req->last_name,
						'user_id_recorded_by' => $user_id_recorded_by
						
					]
				);
				
		$user_id = DB::getPdo()->lastInsertId();
				
		$stud_dob = Carbon::parse($req->stud_dob);
		$stud_dob= ($stud_dob)->toDateTimeString();

		DB::table('students')
				->insert
				(
					[ 
						'user_id' => $user_id,
						'gender_id' => $req->gender_id,
						'stud_dob' => $stud_dob,
						'active' => 1
					]
				);
				
		
		Session::put('student_id_being_updated', $user_id);
		return 1;
			

    }
	
	public function insert_user(Request $req)
    {

		$rec_count = DB::table('ela_users')
				->where([['mobile', '=', $req->mobile]])
				->count();
				
		if(!$rec_count)
		{
			
			$user_id_recorded_by = (Auth::guard('ela_user')->check()) ? Auth::guard('ela_user')->user()->id : null;
			
			DB::table('ela_users')
					->insert
					(
						[
							'user_type_id' => $req->user_type_id,
							'first_name' => $req->first_name,
							'last_name' => $req->last_name,
							'mobile' => $req->mobile,
							'email' => $req->email,
							'password' => bcrypt($req->password),
							'user_id_recorded_by' => $user_id_recorded_by
							
						]
					);
					
					
					
			$user_id = DB::getPdo()->lastInsertId();
			
			
			if($req->user_type_id == 1)
			{	
				$updated = $this->insert_admins_details($req, $user_id );		
			}
			if($req->user_type_id == 2)
			{	
				$updated = $this->insert_mentor_details($req, $user_id );		
			}
			elseif($req->user_type_id == 3)
			{	
				$updated = $this->insert_student_details($req, $user_id );		
			}
			return 1;
			
		}
		else
		{
			return 0;
		}	
		
    }
	
//============================USER SUB-TABLES INSERT BEGINS=======================================//	


	public function insert_admins_details(Request $req, $user_id)
    {

			DB::table('admins')
					->insert
					(
						[
							'user_id' => $user_id
						]
					);
					
			return 1;
		
    }
	
	
	public function insert_mentor_details(Request $req, $user_id)
    {

			DB::table('mentors')
					->insert
					(
						[
							'user_id' => $user_id,
							'mentor_type_id' => $req->mentor_type_id,
							'mentor_category_id' => $req->mentor_category_id,
							'active' => $req->active,
							
						]
					);
					
			return 1;
		
    }


	public function insert_student_details(Request $req, $user_id)
    {

			DB::table('students')
					->insert
					(
						[
							'user_id' => $user_id
						]
					);
					
			return 1;
		
    }
	
//============================USER SUB-TABLES INSERT ENDS=======================================//	
	
	
//============================USER LOGIN=======================================//	

	public function attempt_user_login(Request $request)
    {						

			
		if(Auth::guard('ela_user')->attempt(['mobile' => $request->username, 'password' => $request->password, 'active' => 1, 'approved' => 1]))
		{
			//Authentication passed...
			return Auth::guard('ela_user')->user()->user_type_id;
				
		}			
		else
		{
			if(Auth::guard('ela_user')->attempt(['stud_reg_number' => $request->username, 'password' => $request->password, 'active' => 1, 'approved' => 1]))
			{
				//Authentication passed...
				return Auth::guard('ela_user')->user()->user_type_id;
					
			}			
			else
			{
				return 0;          
			}
			
		}
			
    }

/*
	public function attempt_user_login(Request $request)
    {
		
		if(Auth::attempt(['mobile' => $request->username, 'password' => $request->password]))
		{
			return Auth::user()->user_type_id;
		}			
		else		
		{
			return 0;          
		}
		
	}	
*/	
	
	public function userlogout(Request $request)
    {
			Auth::logout();
			
			return redirect('/login');			
    }
	
	public function elauserlogout(Request $request)
    {
			Auth::guard('ela_user')->logout();
			
			return redirect('/');			
    }
	
		
	public function adminlogout(Request $request)
    {
			Auth::guard('admin')->logout();
			
			return redirect('/login');			
    }
	
	
	public function mentorlogout(Request $request)
    {
			Auth::guard('mentor')->logout();
			
			return redirect('/login');			
    }


	public function studentlogout(Request $request)
    {
			Auth::guard('mentor')->logout();
			
			return redirect('/login');			
    }
	
	
	public function copy_reg_number_to_ela_user(Request $request)
    {
		
		$students = DB::table('students')->get();
		
		$cnt = count($students);
			
		for( $i = 0; $i<($cnt); $i++ ) 
			{
					
				DB::table('ela_users')
						->where([['id', '=', $students[$i]->user_id] ])
						->update
						(
							[
								'stud_reg_number' =>  $students[$i]->reg_number
								
							]
						);
			
			}
			
			return $cnt;
			
    }
	
	
	public function set_session_profile_pic_path(Request $req, $profile_pic_path)    
	{		
				
		Session::put('profile_pic_path', $profile_pic_path);
				
		
	}
	
	
	public function copy_stud_grades_to_stud_in_grades()
    {
		
		$students = DB::table('students')->get();
		
		$cnt = count($students);
			
		for( $i = 0; $i<($cnt); $i++ ) 
			{
						
				DB::table('studs_in_grades')
						->insert
						(
							[
								'stud_grade_id' =>$students[$i]->stud_grade_id,
								'student_id' => $students[$i]->user_id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
						
			
			}
			
			return $cnt;
			
    }
	
	
	
	
	
	
}
