<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">

		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__item " aria-haspopup="true">
				<a href="{{route('admin.dashboard')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.dashboard')}}</span></span></span></a>
			</li>

			{{-- <li class="m-menu__item {{ Request::segment(1) === 'Project' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
			<a href="{{route('task.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Task</span></span></span></a>
			</li> --}}

			{{-- Master End --}}

			@if(Auth::user()->role == "Super Admin" || Auth::user()->role == "Employee")
			<li class="m-menu__item m-menu__item--submenu {{ Request::segment(1) === 'work_log' ||Request::segment(1) === 'task' || Request::segment(1) === 'project' ? 'm-menu__item--open' : null }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">User Menu</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::segment(1) === 'project' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('project.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Project</span></span></span></a>
                        </li>
						<li class="m-menu__item {{ Request::segment(1) === 'task' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="{{route('task.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Work Task</span></span></span></a>
						</li>
                        <li class="m-menu__item {{ Request::segment(1) === 'work_log' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="{{route('work_log.index')}}" class="m-menu__link"><i class="m-menu__link-icon far fa-id-card"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Work Log</span></span></span></a>
						</li>

					</ul>
				</div>
			</li>
			@endif

			@if(Auth::user()->role == "Supplier")
			<li class="m-menu__item {{ Request::segment(1) === 'Task' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('task.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.orders')}}</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'customers' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="#customers" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Customers</span></span></span></a>
			</li>
			@endif

			{{--@canany(['view country','view region', 'view province'])
			<li class="m-menu__item  m-menu__item--submenu {{ Request::segment(1) === 'menu'  || Request::segment(1) === 'submenu' ? 'm-menu__item--open' : null }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">Main Menu</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						@can('view country')
						<li class="m-menu__item {{ Request::segment(1) === 'submenu' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="#submenu" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Submenu</span></span></span></a>
						</li>
						@endcan
						@can('view region')
						<li class="m-menu__item {{ Request::segment(1) === 'submenu1' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="#submenu1" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Submenu 1</span></span></span></a>
						</li>
						@endcan

					</ul>
				</div>
			</li>
			@endcanany--}}

			<li class="m-menu__item {{ Request::segment(1) === 'attendance' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('attendance.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Attendance</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'attendance_report' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('attendances.get_calender')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-calendar-alt"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Attendance Calender</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'leave-management' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('leave-management.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-hand-holding-heart"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Leave Management</span></span></span></a>
			</li>
			@if(Auth::user()->role == "Super Admin")
			{{-- Setting Start --}}

			<li class="m-menu__item  m-menu__item--submenu {{ Request::segment(1) === 'user' || Request::segment(1) === 'roles' || Request::segment(1) === 'shipcompany' || Request::segment(1) === 'logactivity' || Request::segment(1) === 'accessips' || Request::segment(1) === 'view access ips'  ? 'm-menu__item--open' : null }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">{{ __('messages.settings')}}</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						@can('view user')
						<li class="m-menu__item {{ Request::segment(1) === 'user' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="{{route('user.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.user')}}</span></span></span></a>
						</li>
						@endcan

						@can('view access ips')
						<li class="m-menu__item {{ Request::segment(1) === 'accessips' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="{{route('accessips.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.accessip')}}</span></span></span></a>
						</li>
						@endcan
						@can('view roles')
						@if(Auth::user()->role == "Super Admin")
						<li class="m-menu__item {{ Request::segment(1) === 'roles' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="{{route('roles.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.rolepermission')}}</span></span></span></a>
						</li>
						@endif
						@endcan

						@can('view activity logs')
						<li class="m-menu__item {{ Request::segment(1) === 'logactivity' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
							<a href="{{route('logactivity.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.activitylogs')}}</span></span></span></a>
						</li>
						@endcan
						<li class="m-menu__item {{ Request::segment(1) === 'hour-management' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('hour-management.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-clock"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Hour Management</span></span></span></a>
			</li>
			{{-- <li class="m-menu__item {{ Request::segment(1) === 'leave-management' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('leave-management.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-hand-holding-heart"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Leave Management</span></span></span></a>
			</li> --}}
			<li class="m-menu__item {{ Request::segment(1) === 'holiday' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('holiday.index')}}" class="m-menu__link"><i class="m-menu__link-icon far fa-sun"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Holiday Management</span></span></span></a>
			</li>

					</ul>
				</div>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'employee' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('employee.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.employee')}}</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'department' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('department.index')}}" class="m-menu__link"><i class="m-menu__link-icon far fa-building"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Department</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'designation' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('designation.index')}}" class="m-menu__link"><i class="m-menu__link-icon far fa-id-card"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Designation</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'profile' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('profile.index')}}" class="m-menu__link"><i class="m-menu__link-icon far fa-user"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Profile</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'change_password' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('change_password')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-redo"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Change Password</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'attendance_report' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('attendances.attendance_report')}}" class="m-menu__link"><i class="m-menu__link-icon far fa-chart-bar"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Attendance Report</span></span></span></a>
			</li>

			{{-- <li class="m-menu__item {{ Request::segment(1) === 'team' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('team.index')}}" class="m-menu__link"><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Team</span></span></span></a>
			</li> --}}
            <li class="m-menu__item {{ Request::segment(1) === 'email-template' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('email-template.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Email Template</span></span></span></a>
			</li>
			{{-- Setting End --}}
			@endif
            <li class="m-menu__item {{ Request::segment(1) === 'worklog_report' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('reports.worklog_reports')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">WorkLog Report</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'tree-view' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('tree-view')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Team Tree View</span></span></span></a>
			</li>
            {{-- <li class="m-menu__item {{ Request::segment(1) === 'team-lead' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('team-lead.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Team Lead</span></span></span></a>
			</li> --}}

            {{-- <li class="m-menu__item {{ Request::segment(1) === 'templatetype' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
			<li class="m-menu__item {{ Request::segment(1) === 'categories' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('categories.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Category</span></span></span></a>
			</li>
			<li class="m-menu__item {{ Request::segment(1) === 'sub_categories' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('sub_categories.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Sub Category</span></span></span></a>
            <li class="m-menu__item {{ Request::segment(1) === 'email-template' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('email-template.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Email Template</span></span></span></a>
			</li>
           {{-- <li class="m-menu__item {{ Request::segment(1) === 'templatetype' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('templatetype.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Template Type</span></span></span></a>
			</li> --}}

			<li class="m-menu__item {{ Request::segment(1) === 'customer' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('customer.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Customers</span></span></span></a>

			<li class="m-menu__item {{ Request::segment(1) === 'customer-support' ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
				<a href="{{route('customer-support.index')}}" class="m-menu__link"><i class="m-menu__link-icon fas fa-chart-line"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Customer Support</span></span></span></a>
			</li>
		</ul>

	</div>
	<!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
