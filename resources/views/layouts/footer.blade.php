<!-- begin::Footer -->
			<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								{{date ('Y')}} &copy; <a href="#" class="m-link">{{ @$company_name }}</a>
							</span>
						</div>
						<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
							<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
								<li class="m-nav__item">
									<a href="#" class="m-nav__link">
										<span class="m-nav__link-text">About</span>
									</a>
								</li>
								<li class="m-nav__item">
									<a href="#" class="m-nav__link">
										<span class="m-nav__link-text">Privacy</span>
									</a>
								</li>
								<li class="m-nav__item m-nav__item">
									<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
										<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>

			<!-- end::Footer -->
		<div id="m_scroll_top" class="m-scroll-top">
	        <i class="la la-arrow-up"></i>
	    </div>
	    <script src="{{ asset('js/vendors.bundle.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('js/scripts.bundle.js') }}" type="text/javascript"></script>

	    <script src="{{ asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('vendors/custom/ckeditor4/ckeditor.js') }}" type="text/javascript"></script>
        <script>
            @if(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif

            @if(Session::has('danger'))
                toastr.error('{{ Session::get('danger') }}');
            @endif

            @if(Session::has('warning'))
                toastr.warning('{{ Session::get('warning') }}');
            @endif
        </script>

		<script>
			window.Userback = window.Userback || {};
			    Userback.access_token = '6983|58743|w7syOODqHJzmArf0Z1XspIsHFsRLptGsSwHW2NSUCC5QIRcpWF';
			    (function(d) {
			        var s = d.createElement('script');s.async = true;
			        s.src = 'https://static.userback.io/widget/v1.js';
			        (d.head || d.body).appendChild(s);
			    })(document);
		</script>


	    <!--begin::Global Theme Bundle -->
