<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use DB;
use Response;
use File;
use Illuminate\Support\Facades\Hash;


class MailController extends Controller 
{
	
		public function check_forgot_pwd(Request $req) 
		{
			
			$ela_users = DB::table('ela_users')
					->where([['mobile', '=', $req->username] ])
					->orWhere([['stud_reg_number', '=', $req->username] ])
					->whereNull('deleted_at')
					->get();
					
			if( $ela_users->count() > 0)
			{
				if($ela_users[0]->user_type_id == 3)
				{
					
					$students = DB::table('students')
							->where([['user_id', '=', $ela_users[0]->id] ])
							->get();
					
					$to_email = $students[0]->email_id;
					
				}
				else
				{
					$to_email = $ela_users[0]->email;
				}
				
				if (!filter_var($to_email, FILTER_VALIDATE_EMAIL)) 
				{
				  //$emailErr = "Invalid email format";
				  return 2;
				}	
				
				$new_password = str_random(8);
				
				DB::table('ela_users')
						->where([['id', '=', $ela_users[0]->id] ])
						->update
						(
							[
								'password' => bcrypt($new_password)
							]
						);
				
				
				$req->merge(["to_email"=> $to_email]);
				$req->merge(["new_password"=> $new_password]);
				$req->merge(["username"=> $username]);
				
				$this->send_mail_forgot_pwd($req );		
				return $to_email;
			}
			else
			{
				return 0;
				
			}
			
			
		}
		
	
		public function send_mail_forgot_pwd(Request $req) 
		{
	
			$subject = 'ELA-NEW PASSWORD';	  			
			$to_email = $req->to_email;
			$pwd = $req->new_password;
			$username =  $req->username;
			
			//$headers = "From: " . "Ela" . "\r\n";
			////$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
			////$headers .= "CC: pbvaikom@gmail.com\r\n";
			//$headers .= "MIME-Version: 1.0\r\n";
			//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$headers = "From: " . "effectiveteacher.in" . "\r\n";
			$headers .= "Reply-To: info@effectiveteacher.in\r\n";
			$headers .= "Return-Path: effectiveteacher.in\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			

			$message = '<html><body>
			
			<div  class="row pkrow-emblem" style="border-style: ridge; width:550px;; margin:0 auto; text-align:center; height:500px;">
				<div  class="row pkrow-emblem" style="padding-top:1px; background-color:orange; width:100%; text-align:center; height:60px;">
					<p id="aTitle" style="font-size:20px; color:white; font-family: Helvetica Neue;" >Welcome to "ELA SHCOOL"</p>
				</div>
				
				<div  class="row pkrow-emblem" style="padding-top:1px; width:100%; text-align:center; height:300px;">
					<div class="col-sm-6" >
						<p id="pWarning" style="color:green; font-size:18px; font-family: Helvetica Neue;" >Please Find Your New Password Here.</p>
					</div>
					
					<div class="col-sm-6" >
						<img id="imgLogo" style="width:200px;" src="http://www.techinsoft.com/ela-dev/public/ela-assets/images/logo.png" alt="" >
					</div>
				</div>
				
				<br>
				<br>
				<div class="row" style="border:1px solid green; margin:0 auto; text-align:center; width:300px; height:70px; padding-top:2px">
					<p id="pUsr" style="font-size: 14px; color: blue;">USER NAME: '.$username.'</p>
					<p id="pPwd" style="font-size: 14px; color: blue;">PASSWORD: '.$pwd.'</p>
				</div>	 
			</div>
			</body></html>';

		
			mail($to_email, $subject, $message, $headers);

		}


		
		
		
}