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
use App\modelContact;



class MailController extends Controller {

		public function template_email_saq_submit(Request $sp) 
		{
			$user = Auth::user();
			$userdata = DB::table('pci_company')->select('saq_submit_date')->where('companyid',$user->companyid)->first();
			if($userdata->saq_submit_date == '') {
				$saq_submit_date = date("Y-m-d");
				$t = strtotime($saq_submit_date); 
				$t_valid_saq = strtotime('+1 year', $t);
				$renew_till_saq = date('Y-m-d',$t_valid_saq);
				DB::table('pci_company')->where('companyid', $user->companyid)->update(['saq_submit_date' => $saq_submit_date ,'renewal_date' => $renew_till_saq]);
			}

			$mailto = $user->cmp_email;
			$ccp_email = $sp->provider_email;
			$tokens = array();
			$token_values = array();
			$subject = 'SAQ SUBMITTED';
			
			$template_path = public_path('template_email_saq_submit.php');
			$message = file_get_contents($template_path);
			
			$tokens[0]	=	'{USERNAME}';
			$tokens[1]	=	'{IMAGE_URL}';
			$tokens[2]	=	'{SITE_URL}';
			$tokens[3]	= '{EMAILID}';
			
			$basename = basename(getcwd());

			$token_values[0]	=	$user->cnt_name;
			$token_values[1]	=	asset('/images');
			$token_values[2]	=	url('/');
			$token_values[3]	= $ccp_email;
			$html	=	str_replace($tokens, $token_values, $message);
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			$headers .="From: ACCELPCI \r\nReply-To: support@accel-pci.com";


			mail($mailto,$subject,$html,$headers);			
			$this->template_email_ccp($ccp_email);
		}
		
		
		public function template_mailto_merchant() {
			
			return view('template_mailto_merchant');
		}
		
		public function template_email_ccp($ccp_email) 
		{
			$user = Auth::user();	
			$mailto = $ccp_email;
			$subject = 'SAQ SUBMITTED';
			$template_path = public_path('template_email_ccp.php');
			$message = file_get_contents($template_path);
			$tokens = array();
			$token_values = array();
			$tokens[0]	=	'{MERCHANTNAME}';
			$tokens[1]	=	'{COMPANYNAME}';
			$tokens[2]	=	'{IMAGE_URL}';
			$tokens[3]	=	'{SITE_URL}';

			$token_values[0]	=	$user->cnt_name;			
			$token_values[1]	=	$user->cmp_name;
			$token_values[2]	=	asset('/images');
			$token_values[3]	=	url('/');

			$year =date("Y");
			//$path = public_path('/apcidocs/'.$user->companyid.'/documentation/procedures/'.$year.'/'.$user->saq_document);		
			$path = public_path('/apcidocs/'.$user->companyid.'/SAQ/'.date('Y').'/SAQDocs/ByMerchant/'.$user->saq_document);	
			
			$html	=	str_replace($tokens, $token_values, $message);
			$content = file_get_contents($path);
			$content = chunk_split(base64_encode($content));

			// a random hash will be necessary to send mixed content
			$separator = md5(time());

			// carriage return type (RFC)
			$eol = "\r\n";
			// main header (multipart mandatory)
			$headers = "From: ACCELPCI \r\nReply-To: support@accel-pci.com";
			$headers .= "MIME-Version: 1.0" . $eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
			$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
			$headers .= "This is a MIME encoded message." . $eol;

			// message
			$body = "--" . $separator . $eol;
			$body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
			$body .= "Content-Transfer-Encoding: 8bit" . $eol;
			$body .= $html . $eol;

			// attachment
			$body .= "--" . $separator . $eol;
			$body .= "Content-Type: application/octet-stream; name=\"" .$user->saq_document. "\"" . $eol;
			$body .= "Content-Transfer-Encoding: base64" . $eol;
			$body .= "Content-Disposition: attachment" . $eol;
			$body .= $content . $eol;
			$body .= "--" . $separator . "--";

			//SEND Mail
			if (mail($mailto, $subject, $body, $headers)) {
				echo "true"; // or use booleans here
			} 
			else {
				echo "false";
				/* print_r( error_get_last() ); */
			}
			 //return view('backend/tempale_email_ccp');
		}
		
		public function getSaqDate($id) {
				$userdata = DB::table('pci_company')->select('saq_submit_date','doc_veri_date')->where('companyid',$id)->get();
				return $userdata;
				
		}
		
		public function contact_us_mail(Request $request) {
		
			  $surname = $request->input('surname');

			  $name = $request->input('name');

			  $entreprise = $request->input('entreprise');
			  
			  $tele = $request->input('tele');

			  $email = $request->input('email');

			  $subject = $request->input('subject');
			  
			  $msg = $request->input('msg');
			  
			  $mailto = 'support@accel-pci.com';
			  
			
				$tokens = array();
				$token_values = array();
				$subject = $subject;
				
				$template_path = public_path('template_contactus.php');
				$message = file_get_contents($template_path);
				
				
				$tokens[0]	=	'{IMAGE_URL}';
				$tokens[1]	=	'{SITE_URL}';
				$tokens[2]	=	'{SURNAME}';
				$tokens[3]	=   '{NAME}';
				$tokens[4]	=	'{ENTREPRISE}';
				$tokens[5]	=	'{TELE}';			
				$tokens[6]	=	'{MSG}';			
	
				$token_values[0]	=	asset('/images');
				$token_values[1]	=	url('/');
				$token_values[2]	=	$surname;
				$token_values[3]	=   $name;
				$token_values[4]	=	$entreprise;
				$token_values[5]	=   $tele;
				$token_values[6]	=   $msg;
				
				$html	=	str_replace($tokens, $token_values, $message);
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
	
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
				$headers .="From: ACCELPCI \r\nReply-To:".$email;
	
	
				mail($mailto,$subject,$html,$headers);	
				
				$contact = new modelContact;	
				
				$contact->name = $request->input('name');

				$contact->surname = $request->input('surname');
	
				$contact->entreprise = $request->input('entreprise');
				  
				$contact->phone = $request->input('tele');
	
				$contact->email = $request->input('email');
	
				$contact->subject = $request->input('subject');
				  
				$contact->message = $request->input('msg');
				
				$contact->created_at = date('Y-m-d H:i:s');
				  
				$contact->save();
				
				return \Redirect::route('contactus')
      					->with('message', 'Thanks for contacting us!');
			  
			 
		}
		
		
		public function sendmail_merchant(Request $request) {
		
			 
			 

			  $email = $request->input('email');

			  $subject = $request->input('subject');
			  
			  $msg = $request->input('msg');
			  
			  $mailto = $email;
			  
			
				$tokens = array();
				$token_values = array();
				$subject = $subject;
				
				$template_path = public_path('template_mailto_mer.php');
				$message = file_get_contents($template_path);
				
				
				$tokens[0]	=	'{IMAGE_URL}';
				$tokens[1]	=	'{SITE_URL}';
				$tokens[2]	=	'{MSG}';			
	
				$token_values[0]	=	asset('/images');
				$token_values[1]	=	url('/');
				$token_values[2]	=   $msg;
				
				$html	=	str_replace($tokens, $token_values, $message);
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
	
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
				$headers .="From: ACCELPCI \r\nReply-To:".$email;
	
	
				mail($mailto, $subject, $html, $headers);
							
				
				
			$green_count = DB::table('pci_company')

            ->where('status','=','A')

            ->where('is_read','=','0')

						->count();



			$orange_count = DB::table('pci_company')

           		           ->where('is_read','=','0')

						   ->count();

						

						

						/*$orange_count = DB::table('pci_company')

            ->where('status','!=','A')

            ->where('is_read','=','0')

						->count();*/

			

			$merchantList = DB::table('pci_company')

            ->join('states', 'pci_company.cmp_state', '=', 'states.code')

            //->join('cities', 'pci_company.cmp_city', '=', 'cities.id')

            ->select('pci_company.*', 'states.name AS state_name', 'pci_company.cmp_city AS city_name')

			->orderBy('pci_company.companyid', 'desc')

			->orderBy('pci_company.status', 'asc')			

            ->get();



			return view('backend/dashboard',['users' => $merchantList , 'green_count' => $green_count, 'orange_count' => $orange_count]);
			  
			 
		}
		
		
		
		public function sendotherlogin(Request $request) {
		
			  $company = $request->input('company');

			  $name = $request->input('name');

			  $tele = $request->input('tele');

			  $email = $request->input('email');
			 			  
			  $msg = $request->input('msg');
			  
			  $mailto = 'support@accel-pci.com';
			  
			
				$tokens = array();
				$token_values = array();
				$subject = 'OTHER LOGIN QUESTIONS';
				
				$template_path = public_path('template_getLogin.php');
				$message = file_get_contents($template_path);
				
				
				$tokens[0]	=	'{IMAGE_URL}';
				$tokens[1]	=	'{SITE_URL}';
				$tokens[2]	=	'{EMAIL}';
				$tokens[3]	=   '{NAME}';
				$tokens[4]	=	'{COMPANY}';
				$tokens[5]	=	'{TELE}';			
				$tokens[6]	=	'{MSG}';			
	
				$token_values[0]	=	asset('/images');
				$token_values[1]	=	url('/');
				$token_values[2]	=	$email;
				$token_values[3]	=   $name;
				$token_values[4]	=	$company;
				$token_values[5]	=   $tele;
				$token_values[6]	=   $msg;
				
				$html	=	str_replace($tokens, $token_values, $message);
				$template_path1 = public_path('template_test.php');
                file_put_contents($template_path1,$html,FILE_APPEND);
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
	
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
				$headers .="From: ACCELPCI \r\nReply-To:".$email;
	
	
				mail($mailto,$subject,$html,$headers);			
				
				
				return \Redirect::route('forgotpwd')
      					->with('message', 'Thanks for contacting us!');
			  
			 
		}
		
		public function notification_mailQSTN(Request $request) {
		
				$user = Auth::user();						
				$mailto = $user->cmp_email;
				 $name = $user->cnt_name;
				 $email = "support@accel-pci.com";
				$tokens = array();
				$token_values = array();
				$subject = 'THANK YOU FOR SUBMITTING QUESTIONNAIRE';
				
				$template_path = public_path('template_qstn_submit.php');
				$message = file_get_contents($template_path);
				
				
				$tokens[0]	=	'{IMAGE_URL}';
				$tokens[1]	=	'{SITE_URL}';
				$tokens[2]	=   '{NAME}';
					
	
				$token_values[0]	=	asset('/images');
				$token_values[1]	=	url('/');
				$token_values[2]	=   $name;
				
				
				$html	=	str_replace($tokens, $token_values, $message);
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
	
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
				$headers .="From: ACCELPCI \r\nReply-To:".$email;
	
	
				if (mail($mailto, $subject, $html, $headers)) {
				echo "true"; // or use booleans here
			} 
			else {
				echo "false";
				/* print_r( error_get_last() ); */
			}		
				
				
		}
		
}