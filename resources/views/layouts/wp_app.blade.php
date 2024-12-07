<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>Mini Cruise</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<style>
			.gallery_main_img{
			width: 100px;
			height: 100px;
		}
		</style>
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
		  });
		  
        </script>
       
  


		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="{{ asset('css/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    	<link href="{{ asset('css/datatables.min.css') }}" type="text/javascript">
	    <link href="{{ asset(autoVersion('css/style.bundle.css')) }}" rel="stylesheet" type="text/css" />
	    <link href="{{ asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/smart_wizard_all.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset(autoVersion('css/style.css')) }}" rel="stylesheet" type="text/css" />
	    <link rel="shortcut icon" href="{{ asset('logo/favicon.ico') }}" />
	    <link rel="stylesheet" type="text/css" href="{{ asset('admin-files') }}/assets/lightbox/jquery.fancybox.min.css">

		
	</head>

	
	<body>
		
 		
	 		
			
					
		               
		                    @yield('content')
		               
		            
				
	   
	    @yield('footer_scripts')
	     <script type="text/javascript">var site_url = "{{ url('/') }}/";@if($message = Session::get('success_message')) var success_message = "{!! $message !!}"; @endif @if($message = Session::get('error_message')) var error_message = "{!! $message !!}"; @endif @if($message = Session::get('info_message')) var info_message = "{!! $message !!}"; @endif
    	</script>
    	
	    <script type="text/javascript" src="{{ asset('admin-files') }}/assets/lightbox/jquery.fancybox.min.js"></script>
	    <script src="{{ asset(autoVersion('js/custom.js')) }}" type="text/javascript"></script>
		<script src="{{ asset('js/jquery.smartWizard.min.js') }}" type="text/javascript"></script>
		
		
	</body>

</html>
