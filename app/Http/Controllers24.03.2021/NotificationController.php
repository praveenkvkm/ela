<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;
use Carbon\Carbon;
use Session;


class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //protected $guard = 'admin';

    //protected $redirectTo = '/';
	
//============================USER TABLE INSERT=======================================//	


	public function get_non_viewed_notifications(Request $req)
    {
		
		$user_id_receiver = $req->user_id_receiver;
		
		$non_viewed_notifications = DB::table('notifications')
		->leftJoin('ela_users as sender', 'notifications.user_id_sender', '=', 'sender.id')
		->leftJoin('user_types', 'sender.user_type_id', '=', 'user_types.id')
		->select('notifications.*','user_types.*','sender.first_name as sender_first_name','sender.last_name as sender_last_name')
		->where([['notifications.user_id_receiver', '=', Auth::guard('ela_user')->user()->id], ['notifications.viewed', '=', 0] ]) 
		->get();
		
		
		DB::table('notifications')
		->where([['notifications.user_id_receiver', '=', Auth::guard('ela_user')->user()->id], ['notifications.viewed', '=', 0] ]) 
		->update
		(
			[
				'viewed' => 1
				
			]
		);
		
		
		return $non_viewed_notifications;
		
    }


	public function insert_notifications(Request $req)
    {
		
		
			DB::table('notifications')
					->insert
					(
						[
							'notif_category_id' => $req->notif_category_id,
							'user_id_sender' => Auth::guard('ela_user')->user()->id,
							'user_id_receiver' => $req->user_id_receiver,
							'message' => $req->message
						]
					);
					
		
		
    }



	
	
}
