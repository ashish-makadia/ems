
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
    <link href="{{ asset('admin-files') }}/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('admin-files') }}/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Global Theme Styles -->
      <link rel="shortcut icon" href="{{ asset('admin-files') }}/assets/demo/default/media/img/logo/flogo.png" />
      <style type="text/css">
      img {
        width: 50% !important;
      }
      .m-login__form-action button {
      	background: #41AFAA;
      	background-color: #41AFAA;
      	border-color: #41AFAA;
      	color: #fff !important;
      	font-size: 16px;
      }
      .m-login__form-action button:hover {
      	background-color: #40c4ff;
      	background: #40c4ff;
      	border-color: #40c4ff;
      }
    </style>
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-login m-login--signin  m-login--5" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
				<div class="m-login__wrapper-1 m-portlet-full-height" style="background-image: url(../../../minicruise/public/app/media/img/logos/cover-image.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;">
					<div class="m-login__wrapper-1-1">
						<div class="m-login__contanier">
							<div class="m-login__content">
								<div class="m-login__logo">
									<a href="#">
										<img src="{{asset('/app/media/img/logos/Laravel-Logo.png')}}">
									</a>
								</div>
							</div>
						</div>
						<div class="m-login__border">
							<div></div>
						</div>
					</div>
				</div>
				@yield('content')
			</div>
		</div>
		<script src="{{ asset('admin-files') }}/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
   		<script src="{{ asset('admin-files') }}/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>

    	<!--end::Global Theme Bundle -->

    	<!--begin::Page Scripts -->
    	<script src="{{ asset('admin-files') }}/assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>
    </body>

  <!-- end::Body -->
</html>