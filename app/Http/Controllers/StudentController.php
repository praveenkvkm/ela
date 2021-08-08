<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Auth;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
//===========================================COUNT FUNCTIONS BEGIN===============================================================	

	public function get_mentor_room_reminders_to_students(Request $req)
    {
		$mentor_room_reminders = DB::table('mentor_room_reminders')
			->leftJoin('ela_users as ela_user_mentors', 'mentor_room_reminders.mentor_id', '=', 'ela_user_mentors.id')
			->leftJoin('mentors', 'ela_user_mentors.id', '=', 'mentors.user_id')
			->select('mentor_room_reminders.*', 'mentor_room_reminders.id as reminder_id', 'ela_user_mentors.first_name as mentor_first_name','ela_user_mentors.last_name as mentor_last_name', 'mentors.*' )
			->where([['mentor_room_reminders.student_id', '=', Auth::guard('ela_user')->user()->id], ['mentor_room_reminders.student_id', '=', Auth::guard('ela_user')->user()->id] ]) 
			->whereNull('mentor_room_reminders.deleted_at')
			->whereNull('mentor_room_reminders.reminder_readed_date')
			->get();
		
		return $mentor_room_reminders;
		
    }
	
	
	
	public function get_students_total_scores(Request $req, $student_id)
    {
						
		$students_total_score = DB::table('mentor_room_evaluations')
          ->select([
                'id',
                DB::raw("SUM(marks) as aggr_sum_marks"),
                DB::raw("SUM(base_mark) as aggr_sum_base_mark"),
            ])
			->groupBy(['room_id', 'student_id'])
			->where([['student_id', '=', $student_id] ])
			->whereNull('deleted_at')
			->get();				
		
				
		return $students_total_score;
		
    }
	
	
	public function get_students_by_stud_grade_id(Request $req)
    {
		if($req->stud_grade_id !=0)	
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
				->select('ela_users.*','ela_users.id as ela_user_id','students.*','genders.*','standards.*','mediums.*','syllabuses.*','stud_grades.*','blood_groups.*','school_district.district as school_district','parent_relationships.*','guardian_employers.*', 'house_district.district as house_district')
				->where([['stud_grades.id', '=', $req->stud_grade_id]])
				->whereNull('ela_users.deleted_at')
				->orderBy('ela_users.first_name', 'asc')
				->orderBy('ela_users.last_name', 'asc')
				->get();
		}
		else
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
				->select('ela_users.*','ela_users.id as ela_user_id','students.*','genders.*','standards.*','mediums.*','syllabuses.*','stud_grades.*','blood_groups.*','school_district.district as school_district','parent_relationships.*','guardian_employers.*', 'house_district.district as house_district')
				->whereNull('ela_users.deleted_at')
				->orderBy('ela_users.first_name', 'asc')
				->orderBy('ela_users.last_name', 'asc')
				->get();
			
			
		}
		return $selected_student;

	}	
	
	
	public function open_print_single_student(Request $req)    
	{	
		$id =  $req->id;
		
		return view('/admin/student/single-student-print', compact('id'));
	}
	

	
}
