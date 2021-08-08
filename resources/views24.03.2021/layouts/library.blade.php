
	<!-- Fonts and icons -->
	<script src="{{asset('public/azzara/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		 
		url = "{{asset('public/azzara/css/fonts.css')}}";
		
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: [url]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
		
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	pk_today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	
	APP_URL = "{{ url('/') }}";		

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
	
		
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{asset('public/azzara/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/azzara/css/azzara.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{asset('public/assets/css/demo.css')}}">
<script src="{{asset('public/azzara//js/core/jquery.3.2.1.min.js')}}"></script>

<style><!--STYLE FOR LOADER BEGINS-->
.loader 
{
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin 
{
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin 
{
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style><!--STYLE FOR LOADER ENDS-->