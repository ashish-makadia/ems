<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="{{ url('dashboard')}}" class="m-brand__logo-wrapper">
										<img src="{{ @$logo }}" width="150%">
									</a>
									
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">

									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
										<span></span>
									</a>
									<!-- END -->

									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>
									<!-- END -->

									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

							<!-- BEGIN: Horizontal Menu -->
							<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
								<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"></a>
										<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
											
										</div>
									</li>
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"></a>
										<div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:1000px"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
											<div class="m-menu__subnav">
												<ul class="m-menu__content"></ul>
											</div>
										</div>
									</li>
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__ver-arrow la la-angle-right"></i></a>
										<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
										</div>
									</li>
								</ul>
							</div>

							<!-- END: Horizontal Menu -->

							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<style type="text/css">
										label.col-lg-2.col-form {
										    vertical-align: middle;
										    line-height: 38px;
										}
										#m_header_topbar div > ul.translate_class {
										    margin: 0;
										}
										.translate_class label.col-lg-2.col-form {
										    float: left;
										    width: auto;
										    max-width: none !important;
										    padding-right: 0 !important;
										}
									</style>
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li>
											<a href="https://nimb.ws/omwQc3" target="_blank">
												<i class="far fa-question-circle"></i>
											</a>
										</li>
									</ul>
									<ul class="m-topbar__nav m-nav m-nav--inline translate_class">
										<li>
											
											    <div class="form-group m-form__group row">
											      	<label class="col-lg-2 col-form">{{ __('messages.translate')}}</label>
											      	<div class="col-lg-8">
												        <select class="form-control m-input m-input--air" name="locale" id="langauge_locale" >
												          <option value="en" selected>{{ __('messages.selectlanguage')}}</option>
												          <option value="en" <?php if(config('app.locale') == "en") echo "selected";  ?>>English</option>
												          <option value="it" <?php if(config('app.locale') == "it") echo "selected";  ?>>Italian</option>
												        </select>
											      	</div>
											    </div>
								 	 		
										</li>
									</ul>
									
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li>
											<span class="m-menu__arrow m-menu__arrow--adjust"></span>
										</li>
										<li>
										</li>
										<span class="m-menu__arrow m-menu__arrow--adjust">{{ __('messages.welcome')}} {{Auth::user()->name}}<a href="{{ route('logout') }}"  class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a><form id="logout-form" method="POST" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf </form></span>
										<li id="m_quick_sidebar_toggle" class="m-nav__item">
										</li>
									</ul>
									
								</div>
							</div>

							<!-- END: Topbar -->
						</div>
					</div>
				</div>
			</header>
			<style type="text/css">
				.m-brand.m-brand--skin-dark {
				    background: none;
				}
			</style>

			<!-- END: Header -->