<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;
use Hash;
use Carbon\Carbon;
use Session;


class MessengerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //protected $guard = 'admin';

    //protected $redirectTo = '/';
	
//============================USER TABLE INSERT=======================================//	

	public function read_all_messages_with_reply(Request $req)
    {
		$my_user_id = Auth::guard('ela_user')->user()->id;
		//$my_user_id = 142;
				
		$all_messages_with_reply = DB::table('messenger_maps')
		->leftJoin('messages', 'messenger_maps.message_id', '=', 'messages.id')
		->leftJoin('ela_users as sender', 'messages.user_id_sender', '=', 'sender.id')
		->leftJoin('ela_users as receiver', 'messenger_maps.user_id_receiver', '=', 'receiver.id')
		->select('messenger_maps.*','messages.message','sender.first_name as sender_first_name','sender.last_name as sender_last_name','receiver.first_name as receiver_first_name','receiver.last_name as receiver_last_name', 'messages.user_id_sender')
		->where([['messenger_maps.user_id_receiver', '=', $my_user_id] ]) 
		->orWhere([['messages.user_id_sender', '=', $my_user_id] ]) 
		->limit(1000)
		->get();
		
		return $all_messages_with_reply;
	}	


	public function read_non_viewed_messages(Request $req)
    {
		$my_user_id = Auth::guard('ela_user')->user()->id;
		//$my_user_id = 142;
				
		$non_viewed__messages = DB::table('messenger_maps')
		->leftJoin('messages', 'messenger_maps.message_id', '=', 'messages.id')
		->leftJoin('ela_users as sender', 'messages.user_id_sender', '=', 'sender.id')
		->select('messenger_maps.*','messages.message','sender.first_name as sender_first_name','sender.last_name as sender_last_name')
		->where([['messenger_maps.user_id_receiver', '=', $my_user_id], ['messenger_maps.viewed', '=', 0] ]) 
		->get();
		
				
		
		return $non_viewed__messages;
	}	
	
	
	public function read_and_mark_non_viewed_messages(Request $req)
    {
		$my_user_id = Auth::guard('ela_user')->user()->id;
		//$my_user_id = 142;
				
		$non_viewed__messages = DB::table('messenger_maps')
		->leftJoin('messages', 'messenger_maps.message_id', '=', 'messages.id')
		->leftJoin('ela_users as sender', 'messages.user_id_sender', '=', 'sender.id')
		->select('messenger_maps.*','messages.message','sender.first_name as sender_first_name','sender.last_name as sender_last_name')
		->where([['messenger_maps.user_id_receiver', '=', $my_user_id], ['messenger_maps.viewed', '=', 0] ]) 
		->get();
		
				
				DB::table('messenger_maps')
						->where([['messenger_maps.user_id_receiver', '=', $my_user_id], ['messenger_maps.viewed', '=', 0] ]) 
						->update 
						(
							[								
								'viewed' => 1
								
							]
						);

		
		return $non_viewed__messages;
	}	
	

	public function insert_message(Request $req)
    {
		
		$user_id_receiver = array();
		$group_id_receiver = array();
		$grade_id_receiver = array();
		
		$data = $req->data;
		
		DB::table('messages')
				->insert 
				(
					[								
						'user_id_sender' => Auth::guard('ela_user')->user()->id,
						'message' => $data['message']
						
					]
				);
				
		$message_id = DB::getPdo()->lastInsertId();
		
		if(isset($req->user_id_receiver)) 
		{
			$user_id_receiver = $req->user_id_receiver;
					
			$fldnos = count($user_id_receiver);
			for( $i = 0; $i<$fldnos; $i++ ) 
			{
				
				DB::table('messenger')
						->insert 
						(
							[								
								'user_id_receiver' => $user_id_receiver[$i],
								'message_id' => $message_id 
								
							]
						);
						
				DB::table('messenger_maps')
						->insert 
						(
							[								
								'user_id_receiver' => $user_id_receiver[$i],
								'message_id' => $message_id 
								
							]
						);
						

			}
		}
		
			
		if(isset($req->group_id_receiver)) 
		{
					
			$group_id_receiver = $req->group_id_receiver;
					
			$fldnos1 = count($group_id_receiver);
			
			for( $i = 0; $i<$fldnos1; $i++ ) 
			{
				
				DB::table('messenger')
						->insert 
						(
							[								
								'group_id_receiver' => $group_id_receiver[$i],
								'message_id' => $message_id 
								
							]
						);
							
						$individuals = DB::table('studs_in_groups')
							->where([['stud_group_id', '=', $group_id_receiver[$i]] ]) 
							->whereNull('deleted_at')
							->get();
							
						
						$this->insert_messenger_maps($req,$individuals, $message_id);	
						
			}
			
			
		}


		if(isset($req->grade_id_receiver)) 
		{
			
			$grade_id_receiver = $req->grade_id_receiver;
					
			$fldnos2 = count($grade_id_receiver);
			for( $i = 0; $i<$fldnos2; $i++ ) 
			{
				
				DB::table('messenger')
						->insert 
						(
							[								
								'grade_id_receiver' => $grade_id_receiver[$i],
								'message_id' => $message_id 
								
							]
						);
						
						$individuals = DB::table('studs_in_grades')
							->where([['stud_grade_id', '=', $grade_id_receiver[$i]] ]) 
							->whereNull('deleted_at')
							->get();
							
						
						$this->insert_messenger_maps($req,$individuals, $message_id);	

			}
			
		}
		
    }
	
	
	
	public function insert_messenger_maps(Request $req, $individuals, $message_id)
    {
			
			$fldnos_individuals = count($individuals);
			
			for( $j = 0; $j<$fldnos_individuals; $j++ ) 
			{
				
				DB::table('messenger_maps')
						->insert 
						(
							[								
								'user_id_receiver' => $individuals[$j]->student_id,
								'message_id' => $message_id 
								
							]
						);

			}		

	}
	
	
	public function read_received_messages(Request $req)
    {
		
		$my_user_id = Auth::guard('ela_user')->user()->id;
		
		//$my_user_id = 142;
		
		$my_group_ids = DB::table('studs_in_groups')
		->where([['student_id', '=', $my_user_id] ]) 
		->pluck('stud_group_id')->toArray();
		
		
		$my_grade_ids = DB::table('studs_in_grades')
		->where([['student_id', '=', $my_user_id] ]) 
		->pluck('stud_grade_id')->toArray();
		
		/*
		$received_messages = DB::table('messenger')
		->leftJoin('messages', 'messenger.message_id', '=', 'messages.id')
		->leftJoin('message_viewers', 'messenger.message_id', '=', 'message_viewers.message_id')
		->leftJoin('ela_users as sender', 'messages.user_id_sender', '=', 'sender.id')
		->select('messenger.*','messages.message','sender.first_name as sender_first_name','sender.last_name as sender_last_name','message_viewers.user_id_viewed')
		->where(function ($query) use ($my_user_id)
			{
				$query->where('messenger.user_id_receiver', '=', $my_user_id)
				->whereNull('message_viewers.user_id_viewed');
			})
		->orWhere(function ($query) use ($my_group_ids)
			{
				$query->WhereIn('messenger.group_id_receiver', $my_group_ids)
				->whereNull('message_viewers.user_id_viewed');
			})
		->orWhere(function ($query) use ($my_grade_ids)
			{
				$query->WhereIn('messenger.grade_id_receiver', $my_grade_ids)
				->whereNull('message_viewers.user_id_viewed');
			})
		->get();
		*/
		
		$received_messages = DB::table('messenger')
		->leftJoin('messages', 'messenger.message_id', '=', 'messages.id')
		->leftJoin('message_viewers', 'messenger.message_id', '=', 'message_viewers.message_id')
		->leftJoin('ela_users as sender', 'messages.user_id_sender', '=', 'sender.id')
		->select('messenger.*','messages.message','sender.first_name as sender_first_name','sender.last_name as sender_last_name','message_viewers.user_id_viewed')
		->where(function ($query) use ($my_user_id)
			{
				$query->where('messenger.user_id_receiver', '=', $my_user_id);
			})
		->orWhere(function ($query) use ($my_group_ids)
			{
				$query->WhereIn('messenger.group_id_receiver', $my_group_ids);
			})
		->orWhere(function ($query) use ($my_grade_ids)
			{
				$query->WhereIn('messenger.grade_id_receiver', $my_grade_ids);
			})
		->get();

/*
		
			$fldnos = count($received_messages);
			for( $i = 0; $i<$fldnos; $i++ ) 
			{
				
				DB::table('message_viewers')
						->insert 
						(
							[								
								'user_id_viewed' => $my_user_id,
								'message_id' => $received_messages[$i]->message_id 
								
							]
						);

			}
	*/	
	
		return $received_messages;
		
    }

	
	
}
