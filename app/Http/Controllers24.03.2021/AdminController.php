<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;
use File;

use Carbon\Carbon;
use Session;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	 
	public function get_motivation_text(Request $req)
    {
			
		$motivations = DB::table('motivations')->first();
			
		return $motivations;
		
    }

	 
	public function update_motivation_text(Request $req)
    {
		
		$id = Auth::guard('ela_user')->user()->id;
		
		DB::table('motivations')
				->where([['id', '=', 1] ])
				->update
				(
					[
						'mot_text' =>  $req->mot_text,
						'user_id_created_by' => $id,
						'updated_at' => Carbon::now()->toDateTimeString()
					]
				);
		
		
		return 1;
    }


	
	public function insert_stud_group(Request $req)    
	{		
	
		$rec_count = DB::table('stud_groups')
				->where([['stud_group', '=', $req->stud_group] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
				DB::table('stud_groups')
						->insert
						(
							[
								'user_id' => Auth::guard('ela_user')->user()->id,
								'stud_group' => $req->stud_group
							]
						);
						
				return 1;
		}
		else	
		{
			return 0;
		}	
		
	}
	
	
	public function insert_stud_grade(Request $req)    
	{		
	
		$rec_count = DB::table('stud_grades')
				->where([['stud_grade', '=', $req->stud_grade] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
				DB::table('stud_grades')
						->insert
						(
							[
								'user_id' => Auth::guard('ela_user')->user()->id,
								'stud_grade' => $req->stud_grade
							]
						);
						
				return 1;
		}
		else	
		{
			return 0;
		}	
		
	}
	
	/*
	public function insert_stud_in_group(Request $req)    
	{		
	
		$rec_count = DB::table('studs_in_groups')
				->where([['stud_group_id', '=', $req->stud_group_id], ['student_id', '=', $req->student_id]  ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) 
		{
				DB::table('studs_in_groups')
						->insert
						(
							[
								'stud_group_id' => $req->stud_group_id,
								'student_id' => $req->student_id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
				return 1;
		}
		else	
		{
			return 0;
		}	
		
	}
	*/
	
	public function allocate_stud_in_group(Request $req)    
	{		
	
				
		$rec_count = DB::table('studs_in_groups')
				->where([['stud_group_id', '=', $req->stud_group_id], ['student_id', '=', $req->student_id]  ])
				->whereNull('deleted_at')
				->count();
				
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->stud_checked == 1)
			{
						
				DB::table('studs_in_groups')
						->insert
						(
							[
								'stud_group_id' => $req->stud_group_id,
								'student_id' => $req->student_id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
				return 1;
			}
		}
		else	// IF THIS STUDENT IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->stud_checked == 0)
			{
				DB::table('studs_in_groups')
						->where([['stud_group_id', '=', $req->stud_group_id], ['student_id', '=', $req->student_id]  ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);
						
						
						

			return 1;
				
			}
			
			
			
		}	
		
	}
	
	
	public function allocate_grade_to_mentor(Request $req)    
	{		
				
		$rec_count = DB::table('mentors_in_grades')
				->where([['stud_grade_id', '=', $req->grade_id], ['mentor_id', '=', $req->mentor_id]  ])
				->whereNull('deleted_at')
				->count();
				
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->grade_checked == 1)
			{
						
				DB::table('mentors_in_grades')
						->insert
						(
							[
								'stud_grade_id' => $req->grade_id,
								'mentor_id' => $req->mentor_id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
				return 1;
			}
		}
		else	// IF THIS STUDENT IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->grade_checked == 0)
			{
				DB::table('mentors_in_grades')
						->where([['stud_grade_id', '=', $req->grade_id], ['mentor_id', '=', $req->mentor_id]  ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);
						
						
						

			return 2;
				
			}
			
			
			
		}	
		
	}
	
	
	public function allocate_mentor_to_student(Request $req)    
	{	
				
		$rec_count = DB::table('studs_in_mentors')
				->where([['mentor_id', '=', $req->mentor_id], ['student_id', '=', $req->student_id]  ])
				->whereNull('deleted_at')
				->count();
				
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->mentor_checked == 1)
			{
						
				DB::table('studs_in_mentors')
						->insert
						(
							[
								'mentor_id' => $req->mentor_id,
								'student_id' => $req->student_id,
								'user_id_created_by' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
				return 1;
			}
		}
		else	// IF THIS STUDENT IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->mentor_checked == 0)
			{
				DB::table('studs_in_mentors')
						->where([['mentor_id', '=', $req->mentor_id], ['student_id', '=', $req->student_id]  ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id_created_by' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);
						
						
						

			return 2;
				
			}
			
			
			
		}	
		
	}
	
	
	
	public function allocate_group_to_student(Request $req)    
	{		
				
		$rec_count = DB::table('studs_in_groups')
				->where([['stud_group_id', '=', $req->group_id], ['student_id', '=', $req->student_id]  ])
				->whereNull('deleted_at')
				->count();
				
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->group_checked == 1)
			{
						
				DB::table('studs_in_groups')
						->insert
						(
							[
								'stud_group_id' => $req->group_id,
								'student_id' => $req->student_id,
								'user_id' => Auth::guard('ela_user')->user()->id
							]
						);
						
						
				return 1;
			}
		}
		else	// IF THIS STUDENT IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->stud_checked == 0)
			{
				DB::table('studs_in_groups')
						->where([['stud_group_id', '=', $req->group_id], ['student_id', '=', $req->student_id]  ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);
						
						
						

			return 2;
				
			}
			
			
			
		}	
		
	}
	
	public function get_studs_by_group_id(Request $req)    
	{		
				
		$rec_count = DB::table('studs_in_groups')
				->leftJoin('ela_users', 'studs_in_groups.student_id', '=', 'ela_users.id')
				->select('studs_in_groups.*', 'ela_users.first_name AS first_name', 'ela_users.last_name AS last_name')
				->where([['studs_in_groups.stud_group_id', '=', $req->stud_group_id]  ])
				->whereNull('studs_in_groups.deleted_at')
				->get();
				
				
		return $rec_count;		
					
		
	}
	
	
	public function set_session_add_new_student_from_page(Request $req)    
	{		
				
		Session::put('add_new_student_from_page', $req->add_new_student_from_page);
				
		
	}
	
	
	
}
