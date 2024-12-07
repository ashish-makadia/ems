<!DOCTYPE html>

<html lang="en">
@php
$company_name = "Start & Grow";
$logo = asset('/assets/app/media/img/logos/logo_.png');
@endphp
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>{{ @$company_name }}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<style>
		.gallery_main_img{
			width: 100px;
			height: 100px;
		}
		#loader_img {
            display:none;
			height: 100%;
			width: 100%;
			z-index: 1000;
			background: #fcfcfc url("http://www.mvgen.com/loader.gif") no-repeat scroll center center / 40px 40px;
			top: 0;
			left: 0;
			opacity: 0.5;
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
	    <link rel="shortcut icon" href="{{ asset('/assets/app/media/img/logos/favicon.png')}}" />
	    <link rel="stylesheet" type="text/css" href="{{ asset('admin-files') }}/assets/lightbox/jquery.fancybox.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
	</head>


	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default" >

 		<div  class="m-grid m-grid--hor m-grid--root m-page" id="wrapper">
	 		@include('layouts.header')
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
		        <!-- <div class="sidebar-collapse" style="float:left;height: 1000px;"> -->
		            @include('layouts.left_sidebar')
		        <!-- </div> -->

				<!-- <div id="page-wrapper" class="gray-bg dashbard-1" style="float:left;width: auto;padding: 10px;"> -->
					<div class="m-grid__item m-grid__item--fluid m-wrapper">
                <!-- BEGIN: Subheader -->
		                <div class="m-subheader">
		                    <div class="d-flex align-items-center">
		                        <div class="mr-auto">
								<?php $segment1 =  Request::segment(1);  ?>
									@if($segment1 != "dashboard")
		                            <h3 class="m-subheader__title @if(isset($breadcrumb) and count($breadcrumb)>1) m-subheader__title--separator @endif">@yield('subheader')</h3>

									@if(isset($breadcrumb) and count($breadcrumb)>1)
		                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">

		                                @for($i=0; $i < count($breadcrumb); $i++)
		                                <li class="m-nav__item m-nav__item--home @if($i==0) active @endif">
		                                    <a class="m-nav__link m-nav__link--icon" href="{{ (($i!=count($breadcrumb) - 1) ? $breadcrumb[$i]['url'] : 'javascript:;') }}">
		                                        @if($i==0) <i class="m-nav__link-icon la la-home"></i>@else{!! '<span class="m-nav__link-text">'.$breadcrumb[$i]['name'].'</span>' !!}@endif
		                                    </a>
		                                </li>
		                                @if($i<count($breadcrumb)-1) <li class="m-nav__separator">-</li> @endif
		                                @endfor
		                            </ul>
		                            @endif
		                            @endif
		                        </div>
		                      	<?php
	                        		$url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	                        		$url_local = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	                        		$booking_url = url('/').'/agents';
									$orderbooking = url('/').'/orderbooking';

		                        ?>
			                    @if($url ==  $booking_url || $url_local == $booking_url)
									<div class="manage_divs">
										<a  href="{{route('agents.create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
											<span>
												<i class="la la-plus"></i>
												<span>{{ __('messages.addrecord')}}</span>
											</span>
										</a>
										<a  href="javascript:void(0);" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air edit_template">
											<span>
											<i class="la la-plus"></i>
												<span>{{__('messages.options')}}</span>
											</span>
										</a>
										<a  href="javascript:void(0);"  class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air export_excel_agent">
											<span>
												<span>{{__('messages.export')}}</span>
											</span>
										</a>
										<!-- <a  href="{{ route('agents_import.create') }}"  class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
											<span>
												<span>{{__('messages.importagents')}}</span>
											</span>
										</a> -->
									</div>
								@endif

								@if($url ==  $orderbooking || $url_local == $orderbooking)
								@if(auth()->user()->role == "Super Admin")
								<div class="manage_divs">
									<a  href="javascript:void(0);" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air edit_template_booking">
										<span>
										<i class="la la-plus"></i>
											<span>{{__('messages.options')}}</span>
										</span>
									</a>
									<a  href="javascript:void(0);"  class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air export_order_booking">
										<span>
											<span>{{__('messages.export')}}</span>
										</span>
									</a>
									<a  href="{{ route('importview') }}"  class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
										<span>
										<i class="la la-plus"></i>
											<span>{{__('messages.importorders')}}</span>
										</span>
									</a>
								</div>
								@endif
								@endif

		                    </div>
		                </div>
                        <div id="loader_img"></div>
		                <!-- END: Subheader -->
		                <div class="m-content">
		                    @yield('content')
		                </div>
		            </div>

				<!-- </div> -->
	        </div>
	        @include('layouts.footer')
	    </div>
	    @yield('footer_scripts')
	     <script type="text/javascript">var site_url = "{{ url('/') }}/";@if($message = Session::get('success_message')) var success_message = "{!! $message !!}"; @endif @if($message = Session::get('error_message')) var error_message = "{!! $message !!}"; @endif @if($message = Session::get('info_message')) var info_message = "{!! $message !!}"; @endif
    	</script>

	    <script type="text/javascript" src="{{ asset('admin-files') }}/assets/lightbox/jquery.fancybox.min.js"></script>
	    <script src="{{ asset(autoVersion('js/custom.js')) }}" type="text/javascript"></script>
		<script src="{{ asset('js/jquery.smartWizard.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendors\custom\ckeditor4\ckeditor.js') }}" type="text/javascript"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" ></script>
        @stack('scripts')
		<script type="text/javascript">
		 <?php
		    $seach_date = DB::table('save_search')->orderBy('id','desc')->first();
		    if(isset($seach_date) && $seach_date->agents_status == "0" || empty($seach_date)){ ?>
				$("*").dblclick(function(e){
				  e.preventDefault();
				  e.stopPropagation();
				});
		   <?php } ?>
		</script>
        <script>
            $(window).on("load",function(){
                // PAGE IS FULLY LOADED
                // FADE OUT YOUR OVERLAYING DIV
                console.log("Hello");
                $('#loader_img').fadeOut();
            });
        </script>

	</body>

</html>
