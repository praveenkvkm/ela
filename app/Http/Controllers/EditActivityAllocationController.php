<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;
use File;

use Carbon\Carbon;


class EditActivityAllocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
	
	public function edit_allocate_student_in_activity(Request $req)    
	{		
		$room_id = $req->room_id;
	
		$rec_count = DB::table('act_allocations')
				->where([['room_id', '=', $room_id], ['student_id', '=', $req->student_id] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->stud_checked == 1)
			{
				DB::table('act_allocations')
						->insert
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'room_id' => $room_id,
								'student_id' => $req->student_id
							]
						);
						
				return $room_id;
			}
		}
		else	// IF THIS STUDENT IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->stud_checked == 0)
			{
				DB::table('act_allocations')
						->where([['room_id', '=', $room_id], ['student_id', '=', $req->student_id] ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);

			return $room_id;
				
			}
			
			
			
		}	
		
	}
	
	
	public function edit_allocate_group_in_activity(Request $req)    
	{		
		$room_id = $req->room_id;
		
		$rec_count = DB::table('act_allocations')
				->where([['room_id', '=', $room_id], ['stud_group_id', '=', $req->stud_group_id] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS GROUP IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->group_checked == 1)
			{
				DB::table('act_allocations')
						->insert
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'room_id' => $room_id,
								'stud_group_id' => $req->stud_group_id
							]
						);
						
				return $room_id;
			}
		}
		else	// IF THIS GROUP IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->group_checked == 0)
			{
				DB::table('act_allocations')
						->where([['room_id', '=', $room_id], ['stud_group_id', '=', $req->stud_group_id] ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);

			return $room_id;
				
			}
			
			
			
		}	
		
	}
	
	
	public function edit_allocate_grade_in_activity(Request $req)    
	{		
		$room_id = $req->room_id;
		
		$rec_count = DB::table('act_allocations')
				->where([['room_id', '=', $room_id], ['stud_grade_id', '=', $req->stud_grade_id] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS GRADE IS NOT ALREADY ALLOCATED.
		{
			// ONLY IN CASE THE SIGNAL IS 'CHECKED'
			if($req->grade_checked == 1)
			{
				DB::table('act_allocations')
						->insert
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'room_id' => $room_id,
								'stud_grade_id' => $req->stud_grade_id
							]
						);
						
				return $room_id;
			}
		}
		else	// IF THIS grade IS ALREADY ALLOCATED.
		{
			// IF NOW THE SIGNAL IS 'UN-CHECKED', THE NULL STAGE OF 'DELETED_AT' WILL BE FILLED WITH CURRENT TIME. (IN EFFECT THE ALLOCATION WILL BE MUTTED)
			if($req->grade_checked == 0)
			{
				DB::table('act_allocations')
						->where([['room_id', '=', $room_id], ['stud_grade_id', '=', $req->stud_grade_id] ])
						->whereNull('deleted_at')
						->update
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'deleted_at' => Carbon::now()->toDateTimeString()
							]
						);

			return $room_id;
				
			}
			
			
			
		}	
		
	}
	
	
	
	 
	
	
}
