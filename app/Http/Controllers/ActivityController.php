<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;
use File;

use Carbon\Carbon;


class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	
	public function insert_activity_content(Request $req)
    {
		
		DB::table('activities')
				->insert
				(
					[
						'user_id_created_by' => Auth::guard('ela_user')->user()->id,
						'activity_title' => $req->activity_title,
						'description' => $req->description							
					]
				);
		$id = DB::getPdo()->lastInsertId();
		/*		
		$path = public_path().'/pk-uploads/act-acs/'.$id.'/video';
		File::makeDirectory($path, $mode = 0777, true, false);
		
		$path = public_path().'/pk-uploads/act-acs/'.$id.'/audio';
		File::makeDirectory($path, $mode = 0777, true, false);
		
		$path = public_path().'/pk-uploads/act-acs/'.$id.'/docs';
		File::makeDirectory($path, $mode = 0777, true, false);
				*/	
		return $id;
    }
	
	
	public function upload_act_acs(Request $request)    
	{		
		$root = public_path();
		$cnt = count($request->image);
		$acs_type = $request->acs_type;
		$act_id = $request->act_id;
		
			for( $i = 0; $i<($cnt); $i++ ) 
					{
						$input = $request->all();
						$input['image'] = $request->image[$i]->getClientOriginalName();
						$dirtarget = $request->dirtarget . $acs_type . '/';
						$request->image[$i]->move(public_path($dirtarget), $input['image']);

						if($acs_type == 'video')
						{
							DB::table('act_accessories')
								->insert
								(
									[  
										'activity_id' => $act_id,
										'act_acs_type_id' => 1,
										'acs_file_path' => $dirtarget,
										'acs_file_name' => $input['image']
									]
								);
						}
						else if($acs_type == 'audio')
						{
							DB::table('act_accessories')
								->insert
								(
									[  
										'activity_id' => $act_id,
										'act_acs_type_id' => 2,
										'acs_file_path' => $dirtarget,
										'acs_file_name' => $input['image']
									]
								);
						}
						else if($acs_type == 'docs')
						{
							DB::table('act_accessories')
								->insert
								(
									[  
										'activity_id' => $act_id,
										'act_acs_type_id' => 3,
										'acs_file_path' => $dirtarget,
										'acs_file_name' => $input['image']
									]
								);
						}
						
					}
					
			return 1;
		
	}
	
	
	public function download_activity_for_student(Request $req)
	{
		//$file= public_path(). "/download/info.pdf";
		
		$file= url('/public'). $req->acs_file_path . $req->acs_file_name;
		
		$acs_file_path = $req->acs_file_path;
		$acs_file_name = $req->acs_file_name;

		$headers = [
					  'Content-Type' => 'application/pdf',
				   ];  

		//return response()->download($file);	

		//return response()->download( public_path().$acs_file_path . $acs_file_name);	
		return $file;
	}	
	
	
	
	public function allocate_student_in_activity(Request $req)    
	{		
		$room_id = $this->make_or_select_room($req );
	
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
	
	
	public function allocate_group_in_activity(Request $req)    
	{		
		$room_id = $this->make_or_select_room($req );
		
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
	
	
	public function allocate_grade_in_activity(Request $req)    
	{		
		$room_id = $this->make_or_select_room($req );
		
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
	
	
	public function make_or_select_room(Request $req)    
	{	
	
		$dt = Carbon::now();
		$dt = $dt->format('d-m-Y'); 	
			
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$room_count = DB::table('mentor_on_activity_rooms')
				->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
				->where([['mentor_on_activity_rooms.activity_id', '=', $req->activity_id], ['mentor_on_activity_rooms.mentor_id', '=', $mentor_id] ])
				->whereNull('act_publishs.room_finished_date')
				->whereNull('act_publishs.deleted_at')
				->count();
				
		if(!$room_count) // IF THIS STUDENT IS NOT ALREADY ALLOCATED.
		{
			
			
			$room_name = 'room-'. $mentor_id  . '-' . $req->activity_id . '@'. $dt ;
			
			DB::table('mentor_on_activity_rooms')
					->insert 
					(
						[
							'activity_id' => $req->activity_id,
							'mentor_id' => Auth::guard('ela_user')->user()->id,
							'room_name' => $room_name
						]
					);
					
			$id = DB::getPdo()->lastInsertId();
					
			return $id;

		}
		else
		{
			
			$rooms = DB::table('mentor_on_activity_rooms')
				->where([['activity_id', '=', $req->activity_id], ['mentor_id', '=', $mentor_id] ])
				->whereNull('published_date')
				->whereNull('deleted_at')
				->get();
				
			return $rooms[0]->id;	
			
		}

	}
	
	 
	public function insert_send_for_approval(Request $req)    
	{	
			
			DB::table('act_publishs')
					->insert 
					(
						[
							'room_id' => $req->room_id,
							'sent_for_approval_date' => Carbon::now()->toDateTimeString(),
							'user_id_sent_by' => Auth::guard('ela_user')->user()->id,
							'tentated_publish_date' => $req->tentated_publish_date
						]
					);
					
		if($req->subject_id)	
		{			
			$this->insert_activity_publish_subjects($req );
		}
		
			
		return 1;
	}
	
	
	
	public function insert_activity_publish_subjects(Request $req)    
	{	
		$subjects = array();

		$subjects = $req->subject_id;
		
		$fldnos = count($subjects);		
	
		for( $i = 0; $i<$fldnos; $i++ ) 
		{
			
			DB::table('act_pbsh_subjects')
					->insert 
					(
						[
							'room_id' => $req->room_id,
							'subject_id' => $subjects[$i],
							'user_id_recorded_by' => Auth::guard('ela_user')->user()->id
						]
					);

		}			
	
					
				return 	$fldnos;

	}


	public function insert_activity_publish_grades(Request $req)    
	{	
		$stud_grades = array();

		$stud_grades = $req->stud_grade_id;
		
		$fldnos = count($stud_grades);		
	
		for( $i = 0; $i<$fldnos; $i++ ) 
		{
			
			DB::table('act_pbsh_grades')
					->insert 
					(
						[
							'room_id' => $req->room_id,
							'stud_grade_id' => $stud_grades[$i],
							'user_id_recorded_by' => Auth::guard('ela_user')->user()->id
						]
					);

		}			
	
					
				return 	$fldnos;

	}
	
	public function approve_activity_publish(Request $req)    
	{	
	
		$publish_date = Carbon::parse($req->publish_date)->toDateTimeString();
	
		DB::table('act_publishs')
				->where([['id', '=', $req->publish_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'approval_date' =>Carbon::now()->toDateTimeString(),
						'user_id_approved_by' =>  Auth::guard('ela_user')->user()->id,
						'publish_date' => $publish_date,
						'room_expiry_date' => $req->room_expiry_date,
						'rejection_date' => null
					]
				);
				
				return 	1;
	
	}
	
	
	public function change_activity_expiry_date(Request $req)    
	{	
		DB::table('act_publishs')
				->where([['room_id', '=', $req->room_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'user_id_approved_by' =>  Auth::guard('ela_user')->user()->id,
						'room_expiry_date' => $req->room_expiry_date
					]
				);
				
				return 	1;
	}
	
	
	public function delete_activity_publish(Request $req)    
	{	
		DB::table('act_publishs')
				->where([['id', '=', $req->publish_id] ])
				->update
				(
					[
						'deleted_at' =>Carbon::now()->toDateTimeString(),
						'user_id_rejected_by' =>  Auth::guard('ela_user')->user()->id
					]
				);
				
				return 	1;
	}
	
	
	public function approve_activity_rejection(Request $req)    
	{	
	
	
		DB::table('act_publishs')
				->where([['id', '=', $req->publish_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'rejection_date' =>Carbon::now()->toDateTimeString(),
						'user_id_rejected_by' =>  Auth::guard('ela_user')->user()->id,
						'reason_for_rejection' => $req->reason_for_rejection,
						'approval_date' => null
					]
				);
				
				return 	1;
	
	}
	
	
	public function act_allocations(Request $req)    
	{	
	
			$act_allocations = array();
						
			$act_allocations = DB::table('act_allocations')
			->leftJoin('ela_users', 'act_allocations.student_id', '=', 'ela_users.id')
			->leftJoin('stud_groups', 'act_allocations.stud_group_id', '=', 'stud_groups.id')
			->leftJoin('studs_in_groups', 'stud_groups.id', '=', 'studs_in_groups.stud_group_id')
			->leftJoin('mentor_on_activity_rooms', 'act_allocations.room_id', '=', 'mentor_on_activity_rooms.id')
			->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
			->select('act_allocations.*', 'studs_in_groups.student_id AS grp_student_id')
			->whereNull('act_allocations.deleted_at')
			->get();
			
			
			return $act_allocations;
			
	
	}
	
	
	public function return_activity_detail_by_id(Request $req)    
	{	
	
		$activity_id = DB::table('mentor_on_activity_rooms')
		->where([['id', '=', $req->room_id] ])
		->value('activity_id');
	
		$return_data['activity_master'] = DB::table('activities')
		->where([['id', '=', $activity_id] ])
		->get();
		
		$return_data['act_acs_videos'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 1] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_acs_audios'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 2] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_acs_docs'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 3] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_pbsh_grades'] = DB::table('act_pbsh_grades')
		->leftJoin('stud_grades', 'act_pbsh_grades.stud_grade_id', '=', 'stud_grades.id')
		->select('act_pbsh_grades.*', 'stud_grades.stud_grade AS stud_grade')
		->where([['act_pbsh_grades.room_id', '=', $req->room_id] ])
		->whereNull('act_pbsh_grades.deleted_at')
		->pluck('stud_grade')->toArray();
		
		$return_data['act_pbsh_subjects'] = DB::table('act_pbsh_subjects')
		->leftJoin('subjects', 'act_pbsh_subjects.subject_id', '=', 'subjects.id') 
		->select('act_pbsh_subjects.*', 'subjects.subject AS subject')
		->where([['act_pbsh_subjects.room_id', '=', $req->room_id] ])
		->whereNull('act_pbsh_subjects.deleted_at')
		->pluck('subject')->toArray();
		
		//return [$return_data];
		return ($return_data);
		
	}
	
	
	public function open_activity_evaluation(Request $req)    
	{	
		$room_id =  $req->room_id;
		
		return view('mentor/activity/activity-evaluation', compact('room_id'));
	}
	
	
	
	public function open_student_activity(Request $req)    
	{	
				
		$activity_id = DB::table('mentor_on_activity_rooms')
		->where([['id', '=', $req->room_id] ])
		->value('activity_id');
		
		list($return_data) = [$this->get_activity_accessories_by_id( $req, $activity_id)];	

		$return_data['room_id']	= $req->room_id;

		$return_data['act_pbsh_grades'] = DB::table('act_pbsh_grades')
		->leftJoin('stud_grades', 'act_pbsh_grades.stud_grade_id', '=', 'stud_grades.id')
		->select('act_pbsh_grades.*', 'stud_grades.stud_grade AS stud_grade')
		->where([['act_pbsh_grades.room_id', '=', $req->room_id] ])
		->whereNull('act_pbsh_grades.deleted_at')
		->pluck('stud_grade')->toArray();
		
		$return_data['act_pbsh_subjects'] = DB::table('act_pbsh_subjects')
		->leftJoin('subjects', 'act_pbsh_subjects.subject_id', '=', 'subjects.id') 
		->select('act_pbsh_subjects.*', 'subjects.subject AS subject')
		->where([['act_pbsh_subjects.room_id', '=', $req->room_id] ])
		->whereNull('act_pbsh_subjects.deleted_at')
		->pluck('subject')->toArray();
		
		$return_data['act_publishs'] = DB::table('act_publishs')
		->where([['room_id', '=', $req->room_id] ])
		->whereNull('act_publishs.deleted_at')
		->get();
				
	
		return view('student/activity/students-activity', compact('return_data'));
	}
	
	
	public function get_activity_accessories_by_id(Request $req,  $activity_id)    
	{	
		/*
		$return_data['activity_master'] = DB::table('activities')
		->where([['id', '=', $activity_id] ])
		->get();
		
		*/
		
		$return_data['activity_master'] = DB::table('activities')
			->leftJoin('ela_users as act_created_by', 'activities.user_id_created_by', '=', 'act_created_by.id') 
			->select('activities.*', 'act_created_by.first_name AS act_created_by_first_name', 'act_created_by.last_name AS act_created_by_last_name')
			->where([['activities.id', '=', $activity_id] ])
			->get();
		
		$return_data['act_acs_videos'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 1] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_acs_audios'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 2] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_acs_docs'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 3] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		
		//return [$return_data];
		return($return_data);
	}	
	
	
	public function get_activity_detail_by_room_id(Request $req)    
	{	
		$activity_id = DB::table('mentor_on_activity_rooms')
		->where([['id', '=', $req->room_id] ])
		->value('activity_id');
	
		$return_data['activity_master'] = DB::table('activities')
		->where([['id', '=', $activity_id] ])
		->get();
		
		$return_data['act_acs_videos'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 1] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_acs_audios'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 2] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_acs_docs'] = DB::table('act_accessories')
		->where([['activity_id', '=', $activity_id], ['act_acs_type_id', '=', 3] ])
		->whereNull('act_accessories.deleted_at')
		->get();
		
		$return_data['act_pbsh_grades'] = DB::table('act_pbsh_grades')
		->leftJoin('stud_grades', 'act_pbsh_grades.stud_grade_id', '=', 'stud_grades.id')
		->select('act_pbsh_grades.*', 'stud_grades.stud_grade AS stud_grade')
		->where([['act_pbsh_grades.room_id', '=', $req->room_id] ])
		->whereNull('act_pbsh_grades.deleted_at')
		->pluck('stud_grade')->toArray();
		
		$return_data['act_pbsh_subjects'] = DB::table('act_pbsh_subjects')
		->leftJoin('subjects', 'act_pbsh_subjects.subject_id', '=', 'subjects.id') 
		->select('act_pbsh_subjects.*', 'subjects.subject AS subject')
		->where([['act_pbsh_subjects.room_id', '=', $req->room_id] ])
		->whereNull('act_pbsh_subjects.deleted_at')
		->pluck('subject')->toArray();
		
		
		return ($return_data);
		
	}
	
	
	public function upload_stud_act_acs(Request $request)    
	{		
		$root = public_path();
		$cnt = count($request->image);
		$acs_type = $request->acs_type;
		$room_id = $request->room_id;
		
			for( $i = 0; $i<($cnt); $i++ ) 
					{
						$input = $request->all();
						$input['image'] = $request->image[$i]->getClientOriginalName();
						$dirtarget = $request->dirtarget . $acs_type . '/';
						$request->image[$i]->move(public_path($dirtarget), $input['image']);

						if($acs_type == 'video')
						{
							DB::table('student_act_uploads')
								->insert
								(
									[  
										'room_id' => $room_id,
										'student_id' => Auth::guard('ela_user')->user()->id,
										'act_acs_type_id' => 1,
										'acs_file_path' => $dirtarget,
										'acs_file_name' => $input['image'],
										'notes' => $request->notes
									]
								);
						}
						else if($acs_type == 'audio')
						{
							DB::table('student_act_uploads')
								->insert
								(
									[  
										'room_id' => $room_id,
										'student_id' => Auth::guard('ela_user')->user()->id,
										'act_acs_type_id' => 2,
										'acs_file_path' => $dirtarget,
										'acs_file_name' => $input['image'],
										'notes' => $request->notes
									]
								);
						}
						else if($acs_type == 'docs')
						{
							DB::table('student_act_uploads')
								->insert
								(
									[  
										'room_id' => $room_id,
										'student_id' => Auth::guard('ela_user')->user()->id,
										'act_acs_type_id' => 3,
										'acs_file_path' => $dirtarget,
										'acs_file_name' => $input['image'],
										'notes' => $request->notes
									]
								);
						}
						
					}
					
			return 1;
		
	}
	
	
	
	public function update_student_room_statuses(Request $req)    
	{	
		$student_id = Auth::guard('ela_user')->user()->id;
		$room_id = $req->room_id;
		
		$rec_count = DB::table('student_room_statuses')
				->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS GROUP IS NOT ALREADY ALLOCATED.
		{
	
			
			DB::table('student_room_statuses')
				->insert
				(
					[  
						'room_id' => $room_id,
						'student_id' => Auth::guard('ela_user')->user()->id,
						'completed_date' =>Carbon::now()->toDateTimeString(),
						'completed' => $req->completed
					]
				);
				
				return 1;
				
		}
		else
		{
			
			DB::table('student_room_statuses')
				->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'completed' => $req->completed
					]
				);
			
			
			
		}
		
		
		
		
			
	}	
	
	
	public function insert_mentor_room_evaluations(Request $req)    
	{	

		$criterias = array();
		$marks = array();
		$base_marks = array();

		$criterias = $req->criteria;
		$marks = $req->mark;
		$data = $req->data;
		$base_marks = $req->base_mark;
		
		$rec_count = DB::table('mentor_room_evaluations')
				->where([['room_id', '=', $data['room_id']], ['student_id', '=', $data['student_id']] ])
				->whereNull('deleted_at')
				->count();
				

					
		if(!$rec_count) 
		{
			
			$fldnos = count($criterias);
			for( $i = 0; $i<$fldnos; $i++ ) 
			{
				
				DB::table('mentor_room_evaluations')
						->insert 
						(
							[
								'mentor_id' => Auth::guard('ela_user')->user()->id,
								'room_id' => $data['room_id'],
								'student_id' => $data['student_id'],
								'criteria_id' => $criterias[$i],
								'marks' => $marks[$criterias[$i]],
								'base_mark' => $base_marks[$criterias[$i]]
							]
						);

			}
			
		}
		else
		{
			$fldnos = count($criterias);
			for( $i = 0; $i<$fldnos; $i++ ) 
			{
				DB::table('mentor_room_evaluations')
						->where([['room_id', '=', $data['room_id']], ['student_id', '=', $data['student_id']], ['criteria_id', '=', $criterias[$i]] ])
						->whereNull('deleted_at')
						->update
						(
							[
								'mentor_id' => Auth::guard('ela_user')->user()->id,
								'room_id' => $data['room_id'],
								'student_id' => $data['student_id'],
								'marks' => $marks[$criterias[$i]],
								'base_mark' => $base_marks[$criterias[$i]]
							]
						);
			}
		}
				return 	$fldnos;

	}
	
	
	public function insert_mentor_room_reminders(Request $req)    
	{	
		
		DB::table('mentor_room_reminders')
				->insert 
				(
					[
						'mentor_id' => Auth::guard('ela_user')->user()->id,
						'room_id' => $req->room_id,
						'student_id' => $req->student_id,
						'reminder_date' => Carbon::now()->toDateTimeString(),
						'reminder_text' => $req->reminder_text
					]
				);

		return 	1;

	}
	
	
	public function update_reminder_readed(Request $req)    
	{	
		$reminder_id = array();
		
		$reminder_id = $req->reminder_id;
		$data = $req->data;
			
		$fldnos = count($reminder_id);
		
		for( $i = 0; $i<$fldnos; $i++ ) 
		{
									
			DB::table('mentor_room_reminders')
					->where([['id', '=', $reminder_id[$i]] ])
					->update
					(
						[
							'reminder_readed_date' =>  Carbon::now()->toDateTimeString()
						]
					);
					
					

		}
		
		
		
		
		
			return 	$fldnos;

	}
	
	
	
	public function update_mentor_room_evaluation_statuses(Request $req)    
	{	
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
		$room_id = $req->room_id;
		$student_id = $req->student_id;
		
		$rec_count = DB::table('mentor_room_evaluation_statuses')
				->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) // IF THIS GROUP IS NOT ALREADY ALLOCATED.
		{
	
			
			DB::table('mentor_room_evaluation_statuses')
				->insert
				(
					[  
						'mentor_id' => $mentor_id,
						'room_id' => $room_id,
						'student_id' =>$student_id,
						'evaluation_completed_date' =>Carbon::now()->toDateTimeString(),
						'evaluation_completed' => $req->evaluation_completed,
						'ev_comment' => $req->ev_comment
					]
				);
				
				return 1;
				
		}
		else
		{
			
			DB::table('mentor_room_evaluation_statuses')
				->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'evaluation_completed' => $req->evaluation_completed,
						'ev_comment' => $req->ev_comment
					]
				);
			
				return 1;
			
		}
		
		
		
		
			
	}	
	
	
	public function insert_ev_criterias(Request $req)    
	{	

		$criterias = array();
		$marks = array();

		$criterias = $req->criteria;
		$marks = $req->mark;
		$data = $req->data;
		
		$rec_count = DB::table('ev_criterias')
				->where([['room_id', '=', $data['room_id']] ] )
				->whereNull('deleted_at')
				->count();
					
		if(!$rec_count) 
		{
			
			$fldnos = count($criterias);
			for( $i = 0; $i<$fldnos; $i++ ) 
			{
				
				DB::table('ev_criterias')
						->insert 
						(
							[
								'user_id_recorded_by' => Auth::guard('ela_user')->user()->id,
								'criteria_srl' => ($i + 1),
								'room_id' => $data['room_id'],
								'criteria' => $criterias[$i],
								'base_mark' => $marks[$i]
							]
						);

			}
			
		}
		else
		{
			$fldnos = count($criterias);
			for( $i = 0; $i<$fldnos; $i++ ) 
			{
				DB::table('ev_criterias')
						->where([['room_id', '=', $data['room_id']], ['criteria_srl', '=', ($i + 1)] ])
						->update
						(
							[
								'criteria' => $criterias[$i],
								'base_mark' => $marks[$i]
							]
						);
			}
		}
				return 	$fldnos;

	}
	
	
	
	public function update_approve_evaluation(Request $req)    
	{	
	
		
		$room_id = $req->room_id;
		$student_id = $req->student_id;
		
		$rec_count = DB::table('mentor_room_evaluation_statuses')
				->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
				->whereNull('deleted_at')
				->count();
				
		if($rec_count) 
		{
			$evaluation_approved_date = ($req->eval_approved==0)? null: Carbon::now()->toDateTimeString();
			$evaluation_rejected_date = ($req->eval_rejected==0)? null: Carbon::now()->toDateTimeString();
			
			DB::table('mentor_room_evaluation_statuses')
				->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'evaluation_approved_date' => $evaluation_approved_date,
						'evaluation_rejected_date' => $evaluation_rejected_date,
						'admin_comment' => $req->admin_comment
					]
				);
			
				return 1;
				
				
		}
		
	}	
	
	
	public function update_finish_activity(Request $req)    
	{	
	
		
		$room_id = $req->room_id;
		
		$rec_count = DB::table('act_publishs')
				->where([['room_id', '=', $room_id] ])
				->whereNull('deleted_at')
				->count();
				
		if($rec_count) 
		{
			
			DB::table('act_publishs')
				->where([['room_id', '=', $room_id] ])
				->whereNull('deleted_at')
				->update
				(
					[
						'room_finished_date' =>  ($req->activity_finished==0)? null: Carbon::now()->toDateTimeString(),
						'mentors_finish_note' => ($req->activity_finished==0)? null: $req->mentors_finish_note
					]
				);
			
				return 1;
				
				
		}
		
	}



	public function delete_student_act_upload(Request $req)    
	{		
		DB::table('student_act_uploads')
				->where([['id', '=', $req->id] ])
				->update
				(
					[
						'deleted_at' => Carbon::now()->toDateTimeString()
					]
				);

		return 1;
		
	}

	
	
	
}
