<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>ELA</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta name="_token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{asset('public/ela-assets/images/logo.png')}}" type="image/gif" sizes="16x16">
	<style> /* Following style is the code to remove arrows/spinners from input type */
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
		
		
	</style>
	@include('layouts.library')
</head>
