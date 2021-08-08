<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;

class MentorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


	


	public function insert_user(Request $req)
    {

		$rec_count = DB::table('users')
				->where([['mobile', '=', $req->mobile]])
				->count();
		
					
		if(!$rec_count)
		{
			DB::table('users')
					->insert
					(
						[
							'user_type_id' => $req->user_type_id,
							'first_name' => $req->first_name,
							'last_name' => $req->last_name,
							'mobile' => $req->mobile,
							'email' => $req->email,
							'password' => bcrypt($req->password)
							
						]
					);
					
			$user_id = DB::getPdo()->lastInsertId();	
			
			$updated = $this->insert_mentor_details($req );		
					
			return 1;
		}
		else
		{
			return 0;
		}	
		
    }
	
	
	public function insert_mentor_details(Request $req)
    {

			DB::table('mentors')
					->insert
					(
						[
							'mentor_type_id' => $req->mentor_type_id,
							'mentor_category_id' => $req->mentor_category_id,
							'active' => $req->active,
							
						]
					);
					
			return 1;
		
    }
	
	
	
	
}
