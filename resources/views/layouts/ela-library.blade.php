	
    <link rel="stylesheet" href="{{asset('public/ela-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/ela-assets/css/style.css')}}">
	
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
	
	<script src="{{asset('public/azzara/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{asset('public/azzara/js/core/popper.min.js')}}"></script>
	
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
    <link rel="stylesheet" href="{{asset('public/ela-assets/css/font-awesome.min.css')}}">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>

<style> 
	/* Following style is the code to remove arrows/spinners from input type -> TO REMOVE ARROWS FROM NUMBER INPUT */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button 
		{
		   -webkit-appearance: none;
		   margin: 0;
		}
		input[type="number"] 
		{
		   -moz-appearance: textfield;
		}
	/* TO REMOVE ARROWS FROM NUMBER INPUT ENDS*/
</style>
	<script>
$(document).ready(function(){
	/*
		url = "{{asset('public/azzara/css/fonts.css')}}";
		
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: [url]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	*/	
	


	
	
});

	APP_URL ='';
	APP_URL = "{{ url('/') }}";		
	
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	pk_today = now.getFullYear()+"-"+(month)+"-"+(day) ;	
	

	function PKDateDiff(start, end)
	{ 
		var diff = Date.parse(end) - Date.parse(start);
		
		days = (Date.parse(end)- Date.parse(start)) / (1000 * 60 * 60 * 24);
				
		diff_days = Math.round(days);
		
		return diff_days;
	}
	
	
	function PKDateDdMmYyyy(dte)
		{		
			
			var now = new Date(dte);
		 
			var day = ("0" + now.getDate()).slice(-2);
			
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = (day)+"-"+(month)+"-"+ now.getFullYear();

			return today;
		  
		}		
		
		
	function PKDateDdMmYyyyHHMn(dte)
		{		
			
			var now = new Date(dte);
		 
			var day = ("0" + now.getDate()).slice(-2);
			
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = (day)+"-"+(month)+"-"+ now.getFullYear();
			
			var hoursIST = now.getHours()
			var minutesIST = now.getMinutes()
			
			var hoursIST = ('0' + hoursIST).slice(-2)
			var minutesIST = ('0' + minutesIST).slice(-2)
			
			datetime = today + ': ' + hoursIST + ":" + minutesIST;
			return datetime;
		  
		}	

	function PKDateHHMn(dte)
		{		
			
			var now = new Date(dte);
		 
			var day = ("0" + now.getDate()).slice(-2);
			
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = (day)+"-"+(month)+"-"+ now.getFullYear();
			
			var hoursIST = now.getHours()
			var minutesIST = now.getMinutes()
			
			var hoursIST = ('0' + hoursIST).slice(-2)
			var minutesIST = ('0' + minutesIST).slice(-2)
			
			datetime = hoursIST + ":" + minutesIST;
			return datetime;
		  
		}	


	function PKDateHHMnAmPm(dte)
		{		
			
			var now = new Date(dte);
		 
			var day = ("0" + now.getDate()).slice(-2);
			
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = (day)+"-"+(month)+"-"+ now.getFullYear();
			
			var hoursIST = now.getHours()
			var minutesIST = now.getMinutes()
			var secondsIST = now.getSeconds()
			
			var hoursIST = ('0' + hoursIST).slice(-2)
			var minutesIST = ('0' + minutesIST).slice(-2)
			var secondsIST = ('0' + secondsIST).slice(-2)
			
			datetime = hoursIST + ":" + minutesIST + ":" + secondsIST;
			
			const timeString = datetime;
			// Append any date. Use your birthday.
			const timeString12hr = new Date('1970-01-01T' + timeString + 'Z')
			  .toLocaleTimeString({},
				{timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
			  );
			  
			return timeString12hr;			
			
		  
		}		
		
	</script>
	
<?php
$uc = app()->make('App\Http\Controllers\UserController');

$profile_pic_path ='';

$profile_pic_path = url('/public') . '/' . Auth::guard('ela_user')->user()->prof_pic_path . Auth::guard('ela_user')->user()->prof_pic_file ;

app()->call([$uc, 'set_session_profile_pic_path'], [$profile_pic_path]);

?>


