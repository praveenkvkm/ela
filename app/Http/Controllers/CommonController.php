<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Auth;

//use Illuminate\Support\Collection;

class CommonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
//===========================================COUNT FUNCTIONS BEGIN===============================================================	

	public function get_count_stud_groups(Request $req)
    {
		$count_stud_groups = DB::table('stud_groups')
			->whereNull('deleted_at')
			->count();
			
		return $count_stud_groups;
		
    }
	
	public function get_count_students(Request $req)
    {						

		$count_students = DB::table('ela_users')
			->where([['user_type_id', '=', 3]])
			->whereNull('deleted_at')
			->count();
			
		return $count_students;
		
    }

	public function get_count_mentors(Request $req)
    {
		$count_mentors = DB::table('ela_users')
			->where([['user_type_id', '=', 2]])
			->whereNull('deleted_at')
			->count();
			
		return $count_mentors;
		
    }
	
	public function get_count_activities(Request $req)
    {
		$count_activities = DB::table('activities')
			->whereNull('deleted_at')
			->count();
			
		return $count_activities;
		
    }
	
	public function get_count_stud_grades(Request $req)
    {
		$count_stud_grades = DB::table('stud_grades')
			->whereNull('deleted_at')
			->count();
			
		return $count_stud_grades;
		
    }
	
	public function get_count_approved_students(Request $req)
    {
		
		$count_approved_students = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->where([['ela_users.user_type_id', '=', 3]])
			->where([['students.approved', '=', 1]])
			->whereNull('ela_users.deleted_at')
			->count();

		return $count_approved_students;

	}	
	
	public function get_count_non_approved_students(Request $req)
    {
		
		$count_non_approved_students = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->where([['ela_users.user_type_id', '=', 3]])
			->where([['students.approved', '=', 0]])
			->whereNull('ela_users.deleted_at')
			->count();

		return $count_non_approved_students;

	}	
	
	
	public function get_count_approved_mentors(Request $req)
    {
		
		$count_approved_mentors = DB::table('ela_users')
			->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
			->where([['ela_users.user_type_id', '=', 2]])
			->where([['mentors.approved', '=', 1]])
			->whereNull('ela_users.deleted_at')
			->count();

		return $count_approved_mentors;

	}	
	
	public function get_count_non_approved_mentors(Request $req)
    {
		
		$count_non_approved_mentors = DB::table('ela_users')
			->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
			->where([['ela_users.user_type_id', '=', 2]])
			->where([['mentors.approved', '=', 0]])
			->whereNull('ela_users.deleted_at')
			->count();

		return $count_non_approved_mentors;

	}	
	
	
	public function get_count_on_publish_activities(Request $req)
    {
			

	$count_on_publish_activities = DB::table('act_publishs')
	->leftJoin('mentor_on_activity_rooms', 'act_publishs.room_id', '=', 'mentor_on_activity_rooms.id')
	->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
	->leftJoin('ela_users as ela_user_sent_by', 'act_publishs.user_id_sent_by', '=', 'ela_user_sent_by.id')
	->select('act_publishs.*', 'activities.id AS activity_id', 'activities.activity_title AS activity_title', 'ela_user_sent_by.first_name AS ela_user_sent_by_first_name')
	->whereNull('act_publishs.approval_date')
	->whereNull('act_publishs.deleted_at')
	->orderBy('act_publishs.sent_for_approval_date')
	->count();
			
		return $count_on_publish_activities;
		
    }
	
	
	public function get_count_published_activities(Request $req)
    {
			

	$count_published_activities = DB::table('act_publishs')
	->leftJoin('mentor_on_activity_rooms', 'act_publishs.room_id', '=', 'mentor_on_activity_rooms.id')
	->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
	->leftJoin('ela_users as ela_user_sent_by', 'act_publishs.user_id_sent_by', '=', 'ela_user_sent_by.id')
	->select('act_publishs.*', 'activities.id AS activity_id', 'activities.activity_title AS activity_title', 'ela_user_sent_by.first_name AS ela_user_sent_by_first_name')
	->whereNotNull('act_publishs.approval_date')
	->whereNull('act_publishs.deleted_at')
	->orderBy('act_publishs.sent_for_approval_date')
	->count();
			
		return $count_published_activities;
		
    }
	
	
	
//===========================================COUNT FUNCTIONS END===============================================================	

	public function get_ev_criterias(Request $req, $room_id)
    {
			
		$ev_criterias = DB::table('ev_criterias')
		->where([['room_id', '=', $req->room_id] ]) 
		->get();
			
		return $ev_criterias;
		
    }
	
	public function get_ev_criterias_by_room_id(Request $req, $room_id)
    {
			
		$ev_criterias = DB::table('ev_criterias')
		->where([['room_id', '=', $room_id] ]) 
		->get();
			
		return $ev_criterias;
		
    }

	public function get_physical_statuses(Request $req)
    {
			
		$physical_statuses = DB::table('physical_statuses')
		->get();
			
		return $physical_statuses;
		
    }

	public function get_blood_groups(Request $req)
    {
			
		$blood_groups = DB::table('blood_groups')
		->get();
			
		return $blood_groups;
		
    }
	
	
	public function get_activity_by_room_id(Request $req, $room_id)
    {
	
		$rooms_own_activity = DB::table('mentor_on_activity_rooms')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->select('mentor_on_activity_rooms.*','activities.*','act_publishs.*')
		->where([['mentor_on_activity_rooms.id', '=', $room_id] ]) 
		->get();
				
		return $rooms_own_activity;
		
    }
	
	
	public function get_rooms_own_students(Request $req, $room_id)
    {
		
	
		$rooms_own_students = DB::table('act_allocations')
		->leftJoin('ela_users', 'act_allocations.student_id', '=', 'ela_users.id')
		->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
		->select('act_allocations.*','ela_users.*','students.*')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.student_id')
		->whereNull('act_allocations.deleted_at')
		->get();
		
				
		return $rooms_own_students;
			
		
    }


	public function get_rooms_own_groups(Request $req, $room_id)
    {
		
	
		$rooms_own_groups = DB::table('act_allocations')
		->leftJoin('stud_groups', 'act_allocations.stud_group_id', '=', 'stud_groups.id')
		->select('act_allocations.*','stud_groups.*')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.stud_group_id')
		->whereNull('act_allocations.deleted_at')
		->get();
		
				
		return $rooms_own_groups;
			
		
    }
	
	
	public function get_grades_by_room_id(Request $req, $room_id)
    {
	
		$rooms_own_grades = DB::table('act_allocations')
		->leftJoin('stud_grades', 'act_allocations.stud_grade_id', '=', 'stud_grades.id')
		->select('act_allocations.*','stud_grades.stud_grade')
		->where([['act_allocations.room_id', '=', $room_id] ]) 
		->whereNotNull('act_allocations.stud_grade_id')
		->whereNull('act_allocations.deleted_at')
		->pluck('stud_grade')->toArray();
		
		return $rooms_own_grades;
		
    }
	
	
	public function get_groups_by_room_id(Request $req, $room_id)
    {
		$rooms_own_groups = DB::table('act_allocations')
		->leftJoin('stud_groups', 'act_allocations.stud_group_id', '=', 'stud_groups.id')
		->select('act_allocations.*','stud_groups.*')
		->where([['act_allocations.room_id', '=', $room_id] ]) 
		->whereNotNull('act_allocations.stud_group_id')
		->whereNull('act_allocations.deleted_at')
		->pluck('stud_group')->toArray();
				
		return $rooms_own_groups;
    }
	
	
	public function get_students_by_room_id(Request $req, $room_id)
    {
		
		$act_room_students = DB::table('act_allocations')
		->leftJoin('ela_users as ela_user_student', 'act_allocations.student_id', '=', 'ela_user_student.id')
		->select('act_allocations.*', 'ela_user_student.first_name')
		->where([['act_allocations.room_id', '=', $room_id] ])
		->whereNull('act_allocations.deleted_at')
		->pluck('first_name')->toArray();
				
		return $act_room_students;
    }
	
	
	public function get_rooms_entire_students(Request $req, $room_id)
    {
	
		$rooms_own_students = DB::table('act_allocations')
		->leftJoin('ela_users', 'act_allocations.student_id', '=', 'ela_users.id')
		->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
		->select('act_allocations.*','ela_users.*','students.*','students.user_id as un_student_id')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.student_id')
		->whereNull('act_allocations.deleted_at')
		->get();
		
		$rooms_own_groups = DB::table('act_allocations')
		->leftJoin('stud_groups', 'act_allocations.stud_group_id', '=', 'stud_groups.id')
		->leftJoin('studs_in_groups', 'stud_groups.id', '=', 'studs_in_groups.stud_group_id')
		->leftJoin('ela_users', 'studs_in_groups.student_id', '=', 'ela_users.id')
		->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
		->select('act_allocations.*','studs_in_groups.*','ela_users.*','students.*','students.user_id as un_student_id')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.stud_group_id')
		->whereNull('act_allocations.deleted_at')
		->get();
		
		
		$rooms_own_grades = DB::table('act_allocations')
		->leftJoin('stud_grades', 'act_allocations.stud_grade_id', '=', 'stud_grades.id')
		->leftJoin('studs_in_grades', 'stud_grades.id', '=', 'studs_in_grades.stud_grade_id')
		->leftJoin('ela_users', 'studs_in_grades.student_id', '=', 'ela_users.id')
		->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
		->select('act_allocations.*','studs_in_grades.*','ela_users.*','students.*','students.user_id as un_student_id')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.stud_grade_id')
		->whereNull('act_allocations.deleted_at')
		->get();
				
		
		$rooms_group_grade_students = $rooms_own_groups->merge($rooms_own_grades);	
		$rooms_group_grade_indv_students = $rooms_group_grade_students->merge($rooms_own_students);	
		
		$rooms_entire_students = $rooms_group_grade_indv_students->unique('un_student_id');
		
		
		//$collection = collect($rooms_entire_students);
		
		//$rooms_entire_students = $collection->sort();
		
		$rooms_entire_students = $rooms_entire_students->sortBy('first_name');
						
		return $rooms_entire_students;
		
    }
	
	
	public function get_allocations_by_room_id(Request $req)
    {
		
		$return_data['rooms_own_students'] =  DB::table('act_allocations')
		->leftJoin('ela_users as ela_user_student', 'act_allocations.student_id', '=', 'ela_user_student.id')
		->select('act_allocations.*', 'ela_user_student.first_name')
		->where([['act_allocations.room_id', '=', $req->room_id] ])
		->whereNull('act_allocations.deleted_at')
		->get();
		
		$return_data['rooms_own_groups'] = DB::table('act_allocations')
		->leftJoin('stud_groups', 'act_allocations.stud_group_id', '=', 'stud_groups.id')
		->select('act_allocations.*','stud_groups.*')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.stud_group_id')
		->whereNull('act_allocations.deleted_at')
		->get();
		
		
		$return_data['rooms_own_grades'] = DB::table('act_allocations')
		->leftJoin('stud_grades', 'act_allocations.stud_grade_id', '=', 'stud_grades.id')
		->select('act_allocations.*','stud_grades.stud_grade')
		->where([['act_allocations.room_id', '=', $req->room_id] ]) 
		->whereNotNull('act_allocations.stud_grade_id')
		->whereNull('act_allocations.deleted_at')
		->get();
				
								
		return $return_data;
		
    }
	

	
	public function get_pending_approval_activities_of_mentor(Request $req)
    {
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$pending_approval_activities = DB::table('mentor_on_activity_rooms')
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->select('mentor_on_activity_rooms.*','mentor_on_activity_rooms.id as room_id','activities.*')
		->where([['mentor_on_activity_rooms.mentor_id', '=', $mentor_id] ]) 
		->whereNull('act_publishs.approval_date')
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
		
				
		return $pending_approval_activities;
			
		
    }
	
	
	public function get_approved_activities_of_mentor(Request $req)
    {
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$pending_approval_activities = DB::table('mentor_on_activity_rooms')
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->select('mentor_on_activity_rooms.*','mentor_on_activity_rooms.id as room_id','activities.*','act_publishs.*')
		->where([['mentor_on_activity_rooms.mentor_id', '=', $mentor_id] ]) 
		->whereNotNull('act_publishs.approval_date')
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
		
				
		return $pending_approval_activities;
		
		
			
		
    }


	public function get_sent_for_approval_activities_by_mentor_id(Request $req)
    {
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$sent_for_approval_activities = DB::table('mentor_on_activity_rooms')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->select('mentor_on_activity_rooms.*','mentor_on_activity_rooms.id as room_id','activities.*')
		->where([['mentor_on_activity_rooms.mentor_id', '=', $mentor_id] ]) 
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
		
				
		return $sent_for_approval_activities;
			
		
    }


	public function get_mentors_own_groups(Request $req)
    {
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$mentors_own_room_ids = DB::table('mentor_on_activity_rooms')
		->where([['mentor_id', '=', $mentor_id] ]) 
		->whereNull('deleted_at')
		->pluck('id')->toArray();
		
		
		$mentors_own_groups = DB::table('act_allocations')
		->leftJoin('stud_groups', 'act_allocations.stud_group_id', '=', 'stud_groups.id')
		->whereIn('act_allocations.room_id', $mentors_own_room_ids)
		->whereNotNull('act_allocations.stud_group_id')
		->whereNull('act_allocations.deleted_at')
		->groupBy('act_allocations.stud_group_id')
		->get();
		
				
		return $mentors_own_groups;
			
		
    }

	
	
	public function get_mentors_own_students(Request $req)
    {
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
				
		$mentors_own_students = DB::table('studs_in_mentors')
		->leftJoin('ela_users as ela_user_students', 'studs_in_mentors.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('studs_in_mentors.*','ela_user_students.id as student_id', 'ela_user_students.first_name as student_first_name','ela_user_students.last_name as student_last_name', 'students.*' )
		->where([['studs_in_mentors.mentor_id', '=', $mentor_id] ]) 
		->whereNull('studs_in_mentors.deleted_at')
		->get();
						
		return $mentors_own_students;
			
		
    }
	
	
	public function get_mentors_grade_students(Request $req)
    {
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$grade_ids = DB::table('mentors_in_grades')
		->where([['mentor_id', '=', $mentor_id] ])
		->pluck('stud_grade_id')->toArray();
				
		$mentors_grade_students = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->select('ela_users.*','ela_users.id as student_id','ela_users.first_name as student_first_name','ela_users.last_name as student_last_name','students.*')
			->where([['ela_users.user_type_id', '=', 3] ]) 
			->whereIn('students.stud_grade_id', $grade_ids)
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name')
			->orderBy('ela_users.last_name')
			->get();
						
		return $mentors_grade_students;
			
		
    }
	
	
	public function get_mentors_entire_students(Request $req)
    {
		
		$mentor_id = Auth::guard('ela_user')->user()->id;
		
		$mentors_own_students = DB::table('studs_in_mentors')
		->leftJoin('ela_users as ela_user_students', 'studs_in_mentors.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('studs_in_mentors.*','ela_user_students.*','ela_user_students.id as student_id', 'ela_user_students.first_name as student_first_name','ela_user_students.last_name as student_last_name', 'students.*' )
		->where([['studs_in_mentors.mentor_id', '=', $mentor_id] ]) 
		->whereNull('studs_in_mentors.deleted_at')
		->get();
		
		$own_stud_ids = ($mentors_own_students )->pluck('student_id')->toArray();
		
		$grade_ids = DB::table('mentors_in_grades')
		->where([['mentor_id', '=', $mentor_id] ])
		->pluck('stud_grade_id')->toArray();
				
		$mentors_grade_students = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->select('ela_users.*','ela_users.id as student_id','ela_users.first_name as student_first_name','ela_users.last_name as student_last_name','students.*')
			->where([['ela_users.user_type_id', '=', 3] ]) 
			->whereIn('students.stud_grade_id', $grade_ids)
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name')
			->orderBy('ela_users.last_name')
			->get();
			
		$mentors_entire_students2 = $mentors_grade_students->merge($mentors_own_students);	
		$mentors_entire_students = $mentors_entire_students2->unique('student_id');
						
		return $mentors_entire_students;
			
		
    }
	
	
	
	
	public function get_all_active_mentors(Request $req)
    {
		
		$active_mentors = DB::table('ela_users')
			->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
			->select('ela_users.*','ela_users.id as mentor_id','mentors.*')
			->where([['ela_users.user_type_id', '=', 2], ['mentors.active', '=', 1],['mentors.approved', '=', 1] ]) 
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name')
			->orderBy('ela_users.last_name')
			->get();
		
						
		return $active_mentors;
			
		
    }


	public function get_districts(Request $req)
    {
			
		$districts = DB::table('districts')
		->orderBy('district')
		->get();
			
		return $districts;
		
    }
	
	public function get_guardian_employers(Request $req)
    {
			
		$guardian_employers = DB::table('guardian_employers')
		->get();
			
		return $guardian_employers;
		
    }

	public function get_parent_relationships(Request $req)
    {
			
		$parent_relationships = DB::table('parent_relationships')
		->orderBy('parent_relationship')
		->get();
			
		return $parent_relationships;
		
    }

	public function get_school_manage_categories(Request $req)
    {
			
		$school_manage_categories = DB::table('school_manage_categories')
		->orderBy('school_manage_category')
		->get();
			
		return $school_manage_categories;
		
    }

	public function get_genders(Request $req)
    {
			
		$genders = DB::table('genders')
		->orderBy('id')
		->get();
			
		return $genders;
		
    }

	public function get_mentor_categories(Request $req)
    {
			
		$mentor_categories = DB::table('mentor_categories')
		->whereNull('deleted_at')
		->orderBy('mentor_category')
		->get();
			
		return $mentor_categories;
		
    }

	public function get_mentor_types(Request $req)
    {
			
		$mentor_types = DB::table('mentor_types')
		->whereNull('deleted_at')
		->orderBy('mentor_type')
		->get();
			
		return $mentor_types;
		
    }

	public function get_stud_groups(Request $req)
    {
			
		$stud_groups = DB::table('stud_groups')
		->whereNull('deleted_at')
		->orderBy('stud_group')
		->get();
			
		return $stud_groups;
		
    }
	
	
	public function get_stud_grades(Request $req)
    {
			
		$stud_grades = DB::table('stud_grades')
		->whereNull('deleted_at')
		->orderBy('id')
		->get();
			
		return $stud_grades;
		
    }
	
	public function get_subjects(Request $req)
    {
			
		$subjects = DB::table('subjects')
		->whereNull('deleted_at')
		->orderBy('subject')
		->get();
			
		return $subjects;
		
    }
	
	
	public function get_student_full_detail_by_id(Request $req)
    {
		
		$selected_student = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->leftJoin('genders', 'students.gender_id', '=', 'genders.id')
			->leftJoin('standards', 'students.standard_id', '=', 'standards.id')
			->leftJoin('mediums', 'students.medium_id', '=', 'mediums.id')
			->leftJoin('syllabuses', 'students.syllabus_id', '=', 'syllabuses.id')
			->leftJoin('districts as school_district', 'students.school_district_id', '=', 'school_district.id')
			->leftJoin('school_manage_categories', 'students.school_manage_category_id', '=', 'school_manage_categories.id')
			->leftJoin('parent_relationships', 'students.parent_relation_id', '=', 'parent_relationships.id')
			->leftJoin('guardian_employers', 'students.father_emp_ctg_id', '=', 'guardian_employers.id')
			->leftJoin('districts as house_district', 'students.house_district_id', '=', 'house_district.id')
			->leftJoin('stud_grades', 'students.stud_grade_id', '=', 'stud_grades.id')
			->leftJoin('blood_groups', 'students.stud_blood_group_id', '=', 'blood_groups.id')
			->select('ela_users.*','students.*','genders.*','standards.*','mediums.*','syllabuses.*','stud_grades.*','blood_groups.*','school_manage_categories.*','school_district.district as school_district','parent_relationships.*','guardian_employers.*', 'house_district.district as house_district')
			->where([['ela_users.id', '=', $req->student_id]])
			->whereNull('ela_users.deleted_at')
			->get();

		return $selected_student;

	}	
	
	
	public function get_student_profile_pic_by_id(Request $req, $student_id)
    {
		
		$selected_student = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->select('ela_users.*','students.*')
			->where([['ela_users.id', '=', $student_id]])
			->whereNull('ela_users.deleted_at')
			->get();
			
		if($selected_student)
		{		
			$profile_pic_path = url('/public') . '/' . $selected_student[0]->stud_pic_path . $selected_student[0]->stud_pic_file ;
		}
		else
		{
			$profile_pic_path = '' ;
		}
		

		return $profile_pic_path;

	}	
	
	
	public function get_student_grade_by_id(Request $req, $student_id)
    {
		
		$stud_grade = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->leftJoin('stud_grades', 'students.stud_grade_id', '=', 'stud_grades.id')
			->where([['ela_users.id', '=', $student_id]])
			->whereNull('ela_users.deleted_at')
			->value('stud_grades.stud_grade');

		return $stud_grade;

	}	
	
	
	
	public function get_students(Request $req)
    {
			
		$students = DB::table('ela_users')
			->where([['user_type_id', '=', 3]])
			->whereNull('deleted_at')
			->orderBy('first_name', 'asc')
			->orderBy('last_name', 'asc')
			->get();
			
		return $students;
		
    }
	
	public function get_all_active_users(Request $req)
    {
			
		$active_users = DB::table('ela_users')
			->leftJoin('user_types', 'ela_users.user_type_id', '=', 'user_types.id')
			->where([['ela_users.active', '=', 1], ['ela_users.approved', '=', 1]])
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name', 'asc')
			->orderBy('ela_users.last_name', 'asc')
			->get();
			
		return $active_users;
		
    }
	
	
	public function get_approved_students(Request $req)
    {
		
		$approved_students = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->leftJoin('genders', 'students.gender_id', '=', 'genders.id')
			->leftJoin('standards', 'students.standard_id', '=', 'standards.id')
			->leftJoin('mediums', 'students.medium_id', '=', 'mediums.id')
			->leftJoin('syllabuses', 'students.syllabus_id', '=', 'syllabuses.id')
			->leftJoin('districts as school_district', 'students.school_district_id', '=', 'school_district.id')
			->leftJoin('school_manage_categories', 'students.school_manage_category_id', '=', 'school_manage_categories.id')
			->leftJoin('parent_relationships', 'students.parent_relation_id', '=', 'parent_relationships.id')
			->leftJoin('guardian_employers', 'students.father_emp_ctg_id', '=', 'guardian_employers.id')
			->leftJoin('districts as house_district', 'students.house_district_id', '=', 'house_district.id')
			->leftJoin('stud_grades', 'students.stud_grade_id', '=', 'stud_grades.id')
			->select('ela_users.*','ela_users.id as ela_user_id','students.*','genders.*','standards.*','mediums.*','syllabuses.*','school_district.district as school_district','parent_relationships.*','guardian_employers.*','stud_grades.*', 'house_district.district as house_district')
			->where([['ela_users.user_type_id', '=', 3]])
			->where([['students.approved', '=', 1]])
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name', 'asc')
			->orderBy('ela_users.last_name', 'asc')
			->get();

		return $approved_students;

	}	
	
	
	public function get_approved_mentors(Request $req)
    {
		
		$approved_mentors = DB::table('ela_users')
			->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
			->leftJoin('mentor_types', 'mentors.mentor_type_id', '=', 'mentor_types.id')
			->leftJoin('mentor_categories', 'mentors.mentor_category_id', '=', 'mentor_categories.id')
			->select('ela_users.*','ela_users.id as ela_user_id','mentors.*','mentor_types.*','mentor_categories.*')
			->where([['ela_users.user_type_id', '=', 2]])
			->where([['mentors.approved', '=', 1]])
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name', 'asc')
			->orderBy('ela_users.last_name', 'asc')
			->get();

		return $approved_mentors;

	}	
	
	
	
	public function get_non_approved_mentors(Request $req)
    {
		
		$non_approved_mentors = DB::table('ela_users')
			->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
			->leftJoin('mentor_types', 'mentors.mentor_type_id', '=', 'mentor_types.id')
			->leftJoin('mentor_categories', 'mentors.mentor_category_id', '=', 'mentor_categories.id')
			->select('ela_users.*','ela_users.id as ela_user_id','mentors.*','mentor_types.*','mentor_categories.*')
			->where([['ela_users.user_type_id', '=', 2]])
			->where([['mentors.approved', '=', 0]])
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name', 'asc')
			->orderBy('ela_users.last_name', 'asc')
			->get();

		return $non_approved_mentors;

	}	
	
	
	public function get_non_approved_students(Request $req)
    {
		
		$non_approved_students = DB::table('ela_users')
			->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
			->leftJoin('genders', 'students.gender_id', '=', 'genders.id')
			->leftJoin('standards', 'students.standard_id', '=', 'standards.id')
			->leftJoin('mediums', 'students.medium_id', '=', 'mediums.id')
			->leftJoin('syllabuses', 'students.syllabus_id', '=', 'syllabuses.id')
			->leftJoin('districts as school_district', 'students.school_district_id', '=', 'school_district.id')
			->leftJoin('school_manage_categories', 'students.school_manage_category_id', '=', 'school_manage_categories.id')
			->leftJoin('parent_relationships', 'students.parent_relation_id', '=', 'parent_relationships.id')
			->leftJoin('guardian_employers', 'students.father_emp_ctg_id', '=', 'guardian_employers.id')
			->leftJoin('districts as house_district', 'students.house_district_id', '=', 'house_district.id')
			->select('ela_users.*','ela_users.id as ela_user_id','students.*','genders.*','standards.*','mediums.*','syllabuses.*','school_district.district as school_district','parent_relationships.*','guardian_employers.*', 'house_district.district as house_district')
			->where([['ela_users.user_type_id', '=', 3]])
			->where([['students.approved', '=', 0]])
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name', 'asc')
			->orderBy('ela_users.last_name', 'asc')
			->get();

		return $non_approved_students;

	}	
	
	
	public function get_mentor_full_detail_by_id(Request $req)
    {
		
		$return_data['selected_mentor'] = DB::table('ela_users')
			->leftJoin('mentors', 'ela_users.id', '=', 'mentors.user_id')
			->leftJoin('mentor_types', 'mentors.mentor_type_id', '=', 'mentor_types.id')
			->leftJoin('mentor_categories', 'mentors.mentor_category_id', '=', 'mentor_categories.id')
			->select('ela_users.*','ela_users.id as ela_user_id','mentors.*','mentor_types.*','mentor_categories.*')
			->where([['ela_users.user_type_id', '=', 2]])
			->where([['ela_users.id', '=', $req->mentor_id]])
			->whereNull('ela_users.deleted_at')
			->orderBy('ela_users.first_name', 'asc')
			->orderBy('ela_users.last_name', 'asc')
			->get();
			
			
		$return_data['mentors_own_grades'] = DB::table('mentors_in_grades')
		->leftJoin('stud_grades', 'mentors_in_grades.stud_grade_id', '=', 'stud_grades.id')
		->select('mentors_in_grades.*', 'stud_grades.stud_grade AS stud_grade')
		->where([['mentors_in_grades.mentor_id', '=', $req->mentor_id] ]) 
		->whereNull('mentors_in_grades.deleted_at')
		->get();
		
		
		return ($return_data);

	}	
	
	
	
	public function get_student_detail(Request $req)
    {
		

		$student_id = $req->student_id;
		
		$return_data['students_own_mentors'] = DB::table('studs_in_mentors')
		->leftJoin('ela_users as ela_user_mentors', 'studs_in_mentors.mentor_id', '=', 'ela_user_mentors.id')
		->leftJoin('mentors', 'ela_user_mentors.id', '=', 'mentors.user_id')
		->select('studs_in_mentors.*', 'ela_user_mentors.first_name as mentor_first_name','ela_user_mentors.last_name as mentor_last_name', 'mentors.*' )
		->where([['studs_in_mentors.student_id', '=', $student_id] ]) 
		->whereNull('studs_in_mentors.deleted_at')
		->get();
				
		
		/*====================================FIND GROUP_IDS OF STUDENT==================================================*/
		
		$students_own_groups = DB::table('studs_in_groups')
		->leftJoin('stud_groups', 'studs_in_groups.stud_group_id', '=', 'stud_groups.id')
		->select('studs_in_groups.*', 'stud_groups.stud_group AS stud_group')
		->where([['studs_in_groups.student_id', '=', $student_id] ]) 
		->whereNull('studs_in_groups.deleted_at')
		->get();
		
		$return_data['students_own_groups'] = $students_own_groups;
		
		$students_own_group_ids = $students_own_groups->pluck('stud_group_id')->toArray();
				
			//$std_ids = $teacher_standards->pluck('teacher_class')->toArray();  //picks STANDARDS of school
			
		/*===================================FIND ROOM_IDS OWNED BY STUDENT===================================================*/
		
		$students_own_room_ids = DB::table('act_allocations')
		->where([['student_id', '=', $student_id] ]) 
		->orWhereIn('stud_group_id', $students_own_group_ids)
		->whereNull('deleted_at')
		->pluck('room_id')->toArray();
				
		$grades = DB::table('act_pbsh_grades')
		->leftJoin('stud_grades', 'act_pbsh_grades.stud_grade_id', '=', 'stud_grades.id')
		->select('act_pbsh_grades.*', 'stud_grades.stud_grade AS stud_grade')
		->whereIn('act_pbsh_grades.room_id', $students_own_room_ids)
		->whereNull('act_pbsh_grades.deleted_at')
		->groupBy('act_pbsh_grades.stud_grade_id')
		->pluck('stud_grade')->toArray();
			
		$return_data['grades'] = $grades;
		
		
		$return_data['selected_student'] = $this->get_student_full_detail_by_id($req );
		
		return ($return_data);
			
		
    }
	
	
	public function get_on_publish_activities(Request $req)
    {
			
	$on_publish_activities = array();

	$on_publish_activities = DB::table('act_publishs')
	->leftJoin('mentor_on_activity_rooms', 'act_publishs.room_id', '=', 'mentor_on_activity_rooms.id')
	->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
	->leftJoin('ela_users as ela_user_sent_by', 'act_publishs.user_id_sent_by', '=', 'ela_user_sent_by.id')
	->select('act_publishs.*', 'activities.id AS activity_id', 'activities.activity_title AS activity_title', 'ela_user_sent_by.first_name AS ela_user_sent_by_first_name')
	->whereNull('act_publishs.approval_date')
	->whereNull('act_publishs.deleted_at')
	->orderBy('act_publishs.sent_for_approval_date')
	->get();
			
		return $on_publish_activities;
		
    }
	
	
	public function get_approved_activities(Request $req)
    {
	
		$approved_activities = DB::table('mentor_on_activity_rooms')
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->select('mentor_on_activity_rooms.*','mentor_on_activity_rooms.id as room_id','activities.*','act_publishs.*')
		->whereNotNull('act_publishs.approval_date')
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
			
		return $approved_activities;
		
    }
	
	
	public function get_title_case(Request $req)
    {
		$str = $req->str;
							$result = "";
		$array = array();
			$pattern = '/([;:,-.\/ X])/';
			$array = preg_split($pattern, $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

			foreach($array as $k => $v)
				$result .= ucwords(strtolower($v));
			
		return $result;
		
    }
	
	
	public function get_students_approved_activities(Request $req)
    {

		$student_id = Auth::guard('ela_user')->user()->id;
		/*====================================FIND GROUP_IDS OF STUDENT==================================================*/
		
		$students_own_group_ids = array();
		
		$students_own_group_ids = DB::table('studs_in_groups')
		->where([['student_id', '=', $student_id] ]) 
		->whereNull('deleted_at')
		->pluck('stud_group_id')->toArray();
		
		/*====================================FIND GRADE_IDS OF STUDENT==================================================*/
		
		$students_own_grade_ids = array();
		
		$students_own_grade_ids = DB::table('studs_in_grades')
		->where([['student_id', '=', $student_id] ]) 
		->whereNull('deleted_at')
		->pluck('stud_grade_id')->toArray();
		
		
		/*===================================FIND ROOM_IDS OWNED BY STUDENT===================================================*/
		
		$students_own_room_ids = DB::table('act_allocations')
		->where([['student_id', '=', $student_id] ]) 
		->orWhereIn('stud_group_id', $students_own_group_ids)
		->orWhereIn('stud_grade_id', $students_own_grade_ids)
		->whereNull('deleted_at')
		->pluck('room_id')->toArray();
		
		
		/*=======================================FIND ACTIVITIES OF STUDENT'S ROOM_IDS===============================================*/
		
		//$students_approved_activities = array();
		
					
		$return_data['students_approved_activities'] = DB::table('mentor_on_activity_rooms')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->leftJoin('ela_users as act_created_by', 'activities.user_id_created_by', '=', 'act_created_by.id') 
		->whereIn('mentor_on_activity_rooms.id', $students_own_room_ids)
		->whereNotNull('act_publishs.approval_date')
		->whereDate('act_publishs.publish_date', '<=', Carbon::now()->toDateTimeString())
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
		
		
		$return_data['students_approved_activities_completed'] = DB::table('mentor_on_activity_rooms')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->leftJoin('student_room_statuses', 'mentor_on_activity_rooms.id', '=', 'student_room_statuses.room_id')
		->leftJoin('ela_users as act_created_by', 'activities.user_id_created_by', '=', 'act_created_by.id') 
		->where([['student_room_statuses.student_id', '=', $student_id], ['student_room_statuses.completed', '=', 1] ]) 
		->whereIn('mentor_on_activity_rooms.id', $students_own_room_ids)
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
		
		$students_approved_activities_completed_ids = array();
		
		$students_approved_activities_completed_ids = ($return_data['students_approved_activities_completed'])->pluck('activity_id')->toArray();
		
		
		$return_data['students_approved_activities_not_completed'] = DB::table('mentor_on_activity_rooms')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->leftJoin('ela_users as act_created_by', 'activities.user_id_created_by', '=', 'act_created_by.id') 
		->leftJoin('act_publishs', 'mentor_on_activity_rooms.id', '=', 'act_publishs.room_id')
		->select('mentor_on_activity_rooms.*', 'activities.*', 'act_created_by.*', 'act_publishs.*', 'act_created_by.first_name AS act_created_by_first_name', 'act_created_by.last_name AS act_created_by_last_name')
		
		->whereNotNull('act_publishs.approval_date')
		->whereDate('act_publishs.publish_date', '<=', Carbon::now()->toDateTimeString())
		->whereDate('act_publishs.room_expiry_date', '>', Carbon::now()->toDateTimeString())
		->whereNull('act_publishs.room_finished_date')
		->whereNull('act_publishs.deleted_at')
		
		->whereIn('mentor_on_activity_rooms.id', $students_own_room_ids)
		->whereNotIn('mentor_on_activity_rooms.activity_id', $students_approved_activities_completed_ids)
		->whereNull('mentor_on_activity_rooms.deleted_at')
		->get();
		
		

		return ($return_data);

	}	
	
	
	
	public function get_groups_own_students(Request $req)
    {
			
		$groups_own_students = array();

		$groups_own_students = DB::table('studs_in_groups')
		->leftJoin('ela_users', 'studs_in_groups.student_id', '=', 'ela_users.id')
		->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
		->select('studs_in_groups.*', 'ela_users.*', 'students.*')
		->where([['studs_in_groups.stud_group_id', '=', $req->group_id] ]) 
		->whereNull('studs_in_groups.deleted_at')
		->whereNull('ela_users.deleted_at')
		->get();
			
		return $groups_own_students;
		
    }
	
	
	public function get_activity_by_id(Request $req, $room_id)
    {
	
		$activity_by_id = DB::table('activities')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->select('activities.*')
		->where([['mentor_on_activity_rooms.id', '=', $room_id] ]) 
		->get();
				
		return $activity_by_id;
		
    }
	
	
	public function get_student_room_status(Request $req, $room_id, $student_id)
    {
		
	
		$mentor_room_evaluation_status = DB::table('mentor_room_evaluation_statuses')
		->where([['mentor_room_evaluation_statuses.room_id', '=', $room_id], ['mentor_room_evaluation_statuses.student_id', '=', $student_id], ['mentor_room_evaluation_statuses.evaluation_completed', '=', 1]]) 
		->whereNotNull('mentor_room_evaluation_statuses.student_id')
		->whereNull('mentor_room_evaluation_statuses.deleted_at')
		->get();
		
		if(count($mentor_room_evaluation_status)>0)
		{
			$student_status = 'evaluated';
			
			return $student_status;
			
		}
		else
		{
			$student_room_status = DB::table('student_room_statuses')
			->where([['student_room_statuses.room_id', '=', $room_id], ['student_room_statuses.student_id', '=', $student_id]]) 
			->whereNotNull('student_room_statuses.student_id')
			->whereNull('student_room_statuses.deleted_at')
			->get();
			
			$student_status = (count($student_room_status)>0) ? $student_room_status[0]->completed : 0;
			$student_status = ($student_status == 1) ? 'completed' : 'pending';
			
			return $student_status;
		}
	
	}
	
	
	public function get_students_responses_to_activity(Request $req)
    {

		$student_id = $req->student_id;
		$room_id = $req->room_id;
		
		$return_data['student_details'] = DB::table('ela_users')
		->leftJoin('students', 'ela_users.id', '=', 'students.user_id')
		->select('ela_users.*', 'students.*' )
		->where([['ela_users.id', '=', $student_id] ]) 
		->get();
		
		$return_data['student_room_statuses'] = DB::table('student_room_statuses')
		->leftJoin('ela_users as ela_user_students', 'student_room_statuses.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('student_room_statuses.*', 'ela_user_students.*', 'students.*' )
		->where([['student_room_statuses.student_id', '=', $student_id] ]) 
		->where([['student_room_statuses.room_id', '=', $room_id] ]) 
		->whereNull('student_room_statuses.deleted_at')
		->get();
		
		
		$return_data['student_video_uploads'] = DB::table('student_act_uploads')
		->leftJoin('ela_users as ela_user_students', 'student_act_uploads.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('student_act_uploads.*', 'ela_user_students.*', 'students.*' )
		->where([['student_act_uploads.student_id', '=', $student_id] ]) 
		->where([['student_act_uploads.room_id', '=', $room_id] ]) 
		->where([['student_act_uploads.act_acs_type_id', '=', 1] ]) 
		->whereNull('student_act_uploads.deleted_at')
		->get();
		
		$return_data['student_audio_uploads'] = DB::table('student_act_uploads')
		->leftJoin('ela_users as ela_user_students', 'student_act_uploads.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('student_act_uploads.*', 'ela_user_students.*', 'students.*' )
		->where([['student_act_uploads.student_id', '=', $student_id] ]) 
		->where([['student_act_uploads.room_id', '=', $room_id] ]) 
		->where([['student_act_uploads.act_acs_type_id', '=', 2] ]) 
		->whereNull('student_act_uploads.deleted_at')
		->get();
		
		$return_data['student_docs_uploads'] = DB::table('student_act_uploads')
		->leftJoin('ela_users as ela_user_students', 'student_act_uploads.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('student_act_uploads.*', 'ela_user_students.*', 'students.*' )
		->where([['student_act_uploads.student_id', '=', $student_id] ]) 
		->where([['student_act_uploads.room_id', '=', $room_id] ]) 
		->where([['student_act_uploads.act_acs_type_id', '=', 3] ]) 
		->whereNull('student_act_uploads.deleted_at')
		->get();
						
		$return_data['mentor_room_evaluations'] = DB::table('mentor_room_evaluations')
						->leftJoin('ev_criterias', 'mentor_room_evaluations.criteria_id', '=', 'ev_criterias.id')
						->select('mentor_room_evaluations.*', 'ev_criterias.*' )
						->where([['mentor_room_evaluations.room_id', '=', $room_id], ['mentor_room_evaluations.student_id', '=', $student_id] ])
						->whereNull('mentor_room_evaluations.deleted_at')
						->get();
						
						
		$return_data['mentor_room_evaluation_statuses'] = DB::table('mentor_room_evaluation_statuses')
						->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
						->whereNull('deleted_at')
						->get();

		
		return $return_data;
		
	}


	public function get_mentor_room_evaluations_by_room_by_student(Request $req)
    {
		$student_id = $req->student_id;
		$room_id = $req->room_id;
		
		$return_data['mentor_room_evaluations'] = DB::table('mentor_room_evaluations')
						->leftJoin('ev_criterias', 'mentor_room_evaluations.criteria_id', '=', 'ev_criterias.id')
						->select('mentor_room_evaluations.*', 'ev_criterias.*' )
						->where([['mentor_room_evaluations.room_id', '=', $room_id], ['mentor_room_evaluations.student_id', '=', $student_id] ])
						->whereNull('mentor_room_evaluations.deleted_at')
						->get();
						
						
		$return_data['mentor_room_evaluation_statuses'] = DB::table('mentor_room_evaluation_statuses')
						->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
						->whereNull('deleted_at')
						->get();

		
		return $return_data;

	}	
	
	
	public function get_mentor_room_evaluation_marks(Request $req, $room_id, $student_id, $criteria_id)
    {
			
		$criteria_marks = DB::table('mentor_room_evaluations')
						->where([['room_id', '=', $room_id], ['student_id', '=', $student_id], ['criteria_id', '=', $criteria_id] ])
						->whereNull('deleted_at')
						->value('marks');
		
				
		return $criteria_marks;
		
    }
	
	
	public function get_count_student_media_uploads(Request $req, $room_id, $student_id )
    {

		//$student_id = $req->student_id;
		//$room_id = $req->room_id;
		
		$count_student_media_uploads = DB::table('student_act_uploads')
		->leftJoin('ela_users as ela_user_students', 'student_act_uploads.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->select('student_act_uploads.*', 'ela_user_students.*', 'students.*' )
		->where([['student_act_uploads.student_id', '=', $student_id] ]) 
		->where([['student_act_uploads.room_id', '=', $room_id] ]) 
		->whereNull('student_act_uploads.deleted_at')
		->count();
		
		
		return $count_student_media_uploads;
		
	}	
	
	public function get_student_media_uploads(Request $req, $room_id, $student_id )
    {

		//$student_id = $req->student_id;
		//$room_id = $req->room_id;
		
		$student_media_uploads = DB::table('student_act_uploads')
		->leftJoin('ela_users as ela_user_students', 'student_act_uploads.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->leftJoin('act_acs_types', 'student_act_uploads.act_acs_type_id', '=', 'act_acs_types.id')
		->select('student_act_uploads.*', 'act_acs_types.act_acs_type' )
		->where([['student_act_uploads.student_id', '=', $student_id] ]) 
		->where([['student_act_uploads.room_id', '=', $room_id] ]) 
		->whereNull('student_act_uploads.deleted_at')
		->get();
		
		
		return $student_media_uploads;
		
	}	
	
	public function get_student_room_completed_status(Request $req, $room_id, $student_id )
    {
		
			$student_room_status = DB::table('student_room_statuses')
			->where([['student_room_statuses.room_id', '=', $room_id], ['student_room_statuses.student_id', '=', $student_id]]) 
			->whereNotNull('student_room_statuses.student_id')
			->whereNull('student_room_statuses.deleted_at')
			->get();
			
			$student_status = (count($student_room_status)>0) ? $student_room_status[0]->completed : 0;
		
		return $student_status;		
		
	}	
	
	public function get_mentor_room_evaluation_statuses(Request $req )
    {
	
		$mentor_room_evaluation_statuses = DB::table('mentor_room_evaluation_statuses')
		->leftJoin('ela_users as ela_user_students', 'mentor_room_evaluation_statuses.student_id', '=', 'ela_user_students.id')
		->leftJoin('students', 'ela_user_students.id', '=', 'students.user_id')
		->leftJoin('ela_users as ela_user_mentors', 'mentor_room_evaluation_statuses.mentor_id', '=', 'ela_user_mentors.id')
		->leftJoin('mentor_on_activity_rooms', 'mentor_room_evaluation_statuses.room_id', '=', 'mentor_on_activity_rooms.id')
		->leftJoin('activities', 'mentor_on_activity_rooms.activity_id', '=', 'activities.id')
		->select('mentor_room_evaluation_statuses.*', 'ela_user_students.first_name as student_first_name', 'ela_user_students.last_name as student_last_name', 'ela_user_mentors.first_name as mentor_first_name', 'ela_user_mentors.last_name as mentor_last_name', 'students.*','ela_user_mentors.*','activities.*' )
		->where([['mentor_room_evaluation_statuses.evaluation_completed', '=', 1] ]) 
		->whereNull('mentor_room_evaluation_statuses.deleted_at')
		->get();
		
		return $mentor_room_evaluation_statuses;
	}
	
	
	public function get_mentor_room_evaluation_marks_sum(Request $req, $room_id, $student_id)
    {
						
		$evaluation_marks_sum = DB::table('mentor_room_evaluations')
          ->select([
                'id',
                DB::raw("SUM(marks) as sum_marks"),
                DB::raw("SUM(base_mark) as sum_base_mark"),
            ])
			->groupBy(['room_id', 'student_id'])
			->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
			->whereNull('deleted_at')
			->get();				
		
				
		return $evaluation_marks_sum;
		
    }
	
	
	public function get_mentor_room_evaluation_status(Request $req, $room_id, $student_id)
    {
						
		$mentor_room_evaluation_statuses = DB::table('mentor_room_evaluation_statuses')
			->where([['room_id', '=', $room_id], ['student_id', '=', $student_id] ])
			->whereNull('deleted_at')
			->get();				
		
				
		return $mentor_room_evaluation_statuses;
		
    }
	
	
}
