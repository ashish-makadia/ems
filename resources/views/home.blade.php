@extends('layouts.app')
@section('content')
    <?php
    $ip = \Request::ip();
    $currentUserInfo = Location::get($ip);
    if ($currentUserInfo) {
        date_default_timezone_set($currentUserInfo->timezone);
        $date = date('Y-m-d H:i:s');
    } else {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s');
    }
    @$emp_hours = date('Y-m-d H:i:s', strtotime('+' . $working_hour . 'hours', strtotime($attendance->DateTimePunchedIn)));
    ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/calendars/tui-time-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/calendars/tui-date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/calendars/tui-calendar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/calendars/app-calendar.css') }}">
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}
    <style>
        .cal-side .main-cal-side {
            background-color: #00C878;
            width: 19%;
            /* padding: 10px; */
        }

        .cal-side .main-cal-side h2 {
            font-size: 16px;
            text-align: center;
            padding: 15px;
            color: #fff;
            margin-bottom: 0px;
        }

        div#mySidenav {
            background-color: #f0f0f0;
            /* padding: 10px; */
            /* margin: 10px; */
        }

        .sidenav .closebtn {
            color: #fff;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            /* left: 0; */
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            right: 0;
            z-index: 111111;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        ul.main-drop {
            margin: 0 auto;
            padding-left: 0px;
            list-style: none;
            float: left;
            width: 16%;
            text-align: center;
            padding-top: 15px;
        }
/*
        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        } */
    </style>
    <div class="m-content">

        <div class="row">
            <div class="col-sm-4">
                @if (auth()->user()->role == 'Super Admin')
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">My
                                        Attendances</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-sm-6">
                                        <h3 class="card-text">{{ $presentCount }}</h3>
                                        <hr class="rounded">
                                        <h4>Present</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">Pending
                                        Tickets</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon far fa-clipboard"></i>
                                    </div>
                                    <div class="col-sm-6">

                                        <h3 class="card-text">10</h3>
                                        <hr class="rounded">
                                        <h4>Pending</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">My Leaves
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon fas fa-user-clock"></i>
                                    </div>
                                    <div class="col-sm-6">

                                        <h3 class="card-text">{{ $leaveCount }}</h3>
                                        <hr class="rounded">
                                        <h4>Taken</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">Team
                                        Directory</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon fas fa-users"></i>
                                    </div>
                                    <div class="col-sm-6">

                                        <h3 class="card-text">10</h3>
                                        <hr class="rounded">
                                        <h4>Members</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">My
                                        Attendances</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-sm-6">
                                        <h3 class="card-text">{{ $presentCount }}</h3>
                                        <hr class="rounded">
                                        <h4>Present</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">Pending
                                        Tickets</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon far fa-clipboard"></i>
                                    </div>
                                    <div class="col-sm-6">

                                        <h3 class="card-text">10</h3>
                                        <hr class="rounded">
                                        <h4>Pending</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">My Leaves
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon fas fa-user-clock"></i>
                                    </div>
                                    <div class="col-sm-6">

                                        <h3 class="card-text">{{ $leaveCount }}</h3>
                                        <hr class="rounded">
                                        <h4>Taken</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 padding">
                        <div class="card">
                            {{-- <img src="{{ asset('images/restaurant.jpg') }}" class="card-img-top" alt="..."> --}}
                            <div class="card-body text-center">
                                <div class="row">
                                    <h5 class="card-title float-left" style="font-size: 20px; margin-left: 10px;">Team
                                        Directory</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 icondiv">
                                        <i class="tabicon fas fa-users"></i>
                                    </div>
                                    <div class="col-sm-6">

                                        <h3 class="card-text">10</h3>
                                        <hr class="rounded">
                                        <h4>Members</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-sm-8 padding">
                <?php
			$time = date("H");
			$timezone = date("e");
			if ($time < "12") { ?>
                <div class="card-body text-center">
                    <img src="{{ asset('images/morning.png') }}" class="card-img-top time-img" alt="...">
                    <h5 class="card-title" style="font-size: 26px;">Good Morning {{ Auth::user()->name }}</h5>
                    @if ($attendance == '')
                        <p class="card-text"><b>Please Punch In : {{ now()->format('D/d M/y') }}&emsp;<sapn
                                    id="currentTime"></span></b></p>
                        <a href="#" onclick="toggle()" class="btn btn-success"><img class="punch"
                                src="{{ asset('images/touch.jpg') }}" /> <b>Punch In</b></a>
                    @else
                        <p class="card-text"><b>Last Punch In :
                                {{ date('D/d M/y h:i a', strtotime($attendance->DateTimePunchedIn)) }}</b></p>
                        <h1 id="stopWatch"><time></time></h1>
                    @endif
                </div>
                <?php } else
                if ($time >= "12" && $time < "17") { ?>
                <div class="card-body text-center">
                    <img src="{{ asset('images/morning.png') }}" class="card-img-top time-img" alt="...">
                    <h5 class="card-title" style="font-size: 26px;">Good Afternoon {{ Auth::user()->name }}</h5>

                    @if ($attendance == '')
                        <p class="card-text"><b>Please Punch In : {{ now()->format('D/d M/y') }}&emsp;<sapn
                                    id="currentTime"></span></b></p>
                        <a href="#" onclick="toggle()" class="btn btn-success"><img class="punch"
                                src="{{ asset('images/touch.jpg') }}" /> <b>Punch In</b></a>
                    @else
                        <p class="card-text"><b>Last Punch In :
                                {{ date('D/d M/y h:i a', strtotime($attendance->DateTimePunchedIn)) }}</b></p>
                        <a class="btn btn-danger" href="{{ route('attendance.attendance_out_insert', $attendance->id) }}"
                            id="punchout">Punch Out</a>
                        @if ($date >= $emp_hours)
                            <a class="btn btn-danger"
                                href="{{ route('attendance.attendance_out_insert', $attendance->id) }}"
                                id="punchout">Punch Out</a>
                        @endif
                        <h1 id="stopWatch"><time></time></h1>
                    @endif

                </div>
                <?php  } else
                if ($time >= "17" && $time < "19") { ?>
                <div class="card-body text-center">
                    <img src="{{ asset('images/evening.png') }}" class="card-img-top time-img" alt="...">
                    <h5 class="card-title" style="font-size: 26px;">Good Evening {{ Auth::user()->name }}</h5>
                    @if ($attendance == '')
                        <p class="card-text"><b>Please Punch In : {{ now()->format('D/d M/y') }}&emsp;<sapn
                                    id="currentTime"></span></b></p>
                        <a href="#" onclick="toggle()" class="btn btn-success"><img class="punch"
                                src="{{ asset('images/touch.jpg') }}" /> <b>Punch In</b></a>
                    @else
                        <a class="btn btn-danger" href="{{ route('attendance.attendance_out_insert', $attendance->id) }}"
                            id="punchout">Punch Out</a>
                        <p class="card-text"><b>Last Punch In :
                                {{ date('D/d M/y h:i a', strtotime($attendance->DateTimePunchedIn)) }}</b></p>
                        <h1 id="stopWatch"><time></time></h1>
                    @endif
                </div>
                <?php } else
                if ($time >= "19") { ?>
                <div class="card-body text-center">
                    <img src="{{ asset('images/night.png') }}" class="card-img-top time-img" alt="...">
                    <h5 class="card-title" style="font-size: 26px;">Good Night {{ Auth::user()->name }}</h5>
                    @if ($attendance == '')

                        <p class="card-text"><b>Please Punch In : {{ now()->format('D/d M/y') }}&emsp;<sapn
                                    id="currentTime"></span></b></p>
                        <a href="#" onclick="toggle()" class="btn btn-success"><img class="punch"
                                src="{{ asset('images/touch.jpg') }}" /> <b>Punch In</b></a>
                    @else
                        <p class="card-text"><b>Last Punch In :
                                {{ date('D/d M/y h:i a', strtotime($attendance->DateTimePunchedIn)) }}</b></p>
                        <h1 id="stopWatch"><time></time></h1>
                        <a class="btn btn-warning" id="stop">Stop</a>
                        <a class="btn btn-success" id="start">Start</a>
                        @if ($attendance->DateTimePunchedOut == '')
                            <a class="btn btn-danger"
                                href="{{ route('attendance.attendance_out_insert', $attendance->id) }}"
                                id="punchout">Punch Out</a>
                        @endif
                        @if ($date >= $emp_hours)
                            <a class="btn btn-danger"
                                href="{{ route('attendance.attendance_out_insert', $attendance->id) }}"
                                id="punchout">Punch Out</a>
                        @endif
                    @endif
                </div>
                <?php }
			?>
            </div>
        </div>
    {{-- </div>
    <div class="m-portlet m-portlet--mobile"> --}}
        <div class="m-portlet__body">
            <!-- calendar Wrapper  -->
            <div class="calendar-wrapper position-relative">
                <!-- calendar sidebar start -->
                <div class="cal-side">
                    <div class="main-cal-side">
                        <h2>My Attendance</h2>
                    </div>
                </div>
                <!-- calendar sidebar end -->
                <!-- calendar view start  -->
                <div class="calendar-view">
                    <div class="calendar-action d-flex align-items-center flex-wrap">
                        <!-- sidebar toggle button for small sceen -->
                        <button class="btn btn-icon sidebar-toggle-btn">
                            <i class="bx bx-menu font-large-1"></i>
                        </button>
                        <!-- dropdown button to change calendar-view -->
                        <div class="dropdown d-inline mr-75">
                            <button id="dropdownMenu-calendarType" class="btn btn-action dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i id="calendarTypeIcon" class="bx bx-calendar-alt"></i>
                                <span id="calendarTypeName">Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu"
                                aria-labelledby="dropdownMenu-calendarType">
                                <li role="presentation">
                                    <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-daily">
                                        <i class="bx bx-calendar-alt mr-50"></i>
                                        <span>Daily</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a class="dropdown-menu-title dropdown-item" role="menuitem"
                                        data-action="toggle-weekly">
                                        <i class='bx bx-calendar-event mr-50'></i>
                                        <span>Weekly</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a class="dropdown-menu-title dropdown-item" role="menuitem"
                                        data-action="toggle-monthly">
                                        <i class="bx bx-calendar mr-50"></i>
                                        <span>Month</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a class="dropdown-menu-title dropdown-item" role="menuitem"
                                        data-action="toggle-weeks2">
                                        <i class='bx bx-calendar-check mr-50'></i>
                                        <span>2 weeks</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a class="dropdown-menu-title dropdown-item" role="menuitem"
                                        data-action="toggle-weeks3">
                                        <i class='bx bx-calendar-check mr-50'></i>
                                        <span>3 weeks</span>
                                    </a>
                                </li>
                                <li role="presentation" class="dropdown-divider"></li>
                                <li role="presentation">
                                    <div role="menuitem" data-action="toggle-workweek" class="dropdown-item">
                                        <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                            value="toggle-workweek" checked>
                                        <span class="checkbox-title bg-primary"></span>
                                        <span>Show weekends</span>
                                    </div>
                                </li>
                                <li role="presentation">
                                    <div role="menuitem" data-action="toggle-start-day-1" class="dropdown-item">
                                        <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                            value="toggle-start-day-1">
                                        <span class="checkbox-title"></span>
                                        <span>Start Week on Monday</span>
                                    </div>
                                </li>
                                <li role="presentation">
                                    <div role="menuitem" data-action="toggle-narrow-weekend" class="dropdown-item">
                                        <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                            value="toggle-narrow-weekend">
                                        <span class="checkbox-title"></span>
                                        <span>Narrower than weekdays</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="mySidenav" class="sidenav">
                            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                            <h3 id="header_sidebar"></h3>
                            <form id="leaveForm" class="form-side" style="padding:10px;">
                                <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name"><b>Start Date</b></label>
                                            <input type="date" class="form-control" value="" name="start_date"
                                                id="from_date">
                                            <input type="hidden" class="form-control" value="" id="type">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name"><b>End Date</b></label>
                                            <input type="date" class="form-control" value="" name="end_date"
                                                id="to_date">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Comment</label>
                                    <textarea class="form-control" id="comment" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 m-1">
                                        <div class="text-center" style="margin-top:30px;margin-bottom:10px">
                                            <button type="button" id="butsave" class="btn btn-primary btn-block"
                                                style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i>
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- calenadar next and previous navigate button -->
                        <span id="menu-navi" class="menu-navigation">
                            <button type="button" class="btn btn-action move-today mr-50 px-75"
                                data-action="move-today">Today</button>
                            <button type="button" class="btn btn-icon btn-action  move-day mr-50 px-50"
                                data-action="move-prev">
                                <i class="far fa-arrow-alt-circle-left" data-action="move-prev"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-action move-day mr-50 px-50"
                                data-action="move-next">
                                <i class="far fa-arrow-alt-circle-right" data-action="move-next"></i>
                            </button>
                        </span>
                        <span id="renderRange" class="render-range"></span>
                    </div>

                    <div class="calendar-action d-flex align-items-center flex-wrap">
                        <div id="sidebar" style="width: 100%;" class="sidebar">

                            <!-- sidebar calendar labels -->
                            <div id="sidebar-calendars" class="sidebar-calendars">
                                <div>
                                    <div class="sidebar-calendars-item">
                                        <!-- view All checkbox -->
                                        <div class="checkbox">
                                            <input type="checkbox"
                                                class="checkbox-input tui-full-calendar-checkbox-square" id="checkbox1"
                                                value="all" checked>
                                            <label for="checkbox1">View all</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="calendarList" style="display: flex;" class="sidebar-calendars-d1"></div>
                                <div id="buttonDiv" style="display: none;" class="sidebar-calendars-d1">
                                    <a href="#" onclick="openNav(1)"
                                        style="background-color: #f91818;border-color: #dc0000;box-shadow: 0px 5px 10px 2px rgb(255 9 9 / 19%) !important;"
                                        class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"><b>Apply
                                            Opt Holiday</b></a>
                                    <a href="#" onclick="openNav(2)"
                                        class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"><b>Apply
                                            Present</b></a>
                                    <a href="#" onclick="openNav(3)"
                                        style="background-color: #a13aff;border-color: #a13aff;box-shadow: 0px 5px 10px 2px rgb(161 58 255 / 19%) !important"
                                        class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                        <b>Apply Leave</b></a>
                                    <a href="#" onclick="openNav(4)"
                                        class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"><b>Apply
                                            Comp Off</b></a>
                                </div>
                            </div>
                            <!-- / sidebar calendar labels -->
                        </div>
                    </div>
                    <!-- calendar view  -->
                    <div id="calendar" style="width: 95%!important;" class="calendar-content"></div>
                </div>
                <!-- calendar view end  -->
            </div>
        </div>
    </div>
    @if(!empty($expiryProject) && count($expiryProject) > 0)
    <div class="col-md-12">
        <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height mt-4">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h1 class="m-portlet__head-text">
                            Near Expiry Project
                        </h1>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="expiryProject">
                    <thead>
                        <tr class="heading">
                            <th>{{ __('messages.id')}}</th>
                            <th>{{ __('messages.name')}}</th>
                            <th>{{ __('messages.team_member')}}</th>
                            <th>{{ __('messages.start_date')}}</th>
                            <th>{{ __('messages.end_date')}}</th>
                            <th>{{ __('messages.status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expiryProject as $key => $project)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $project->project_name}}</td>
                                <td>{{ $project->team_members_name}}</td>
                                @php
                                $diff = strtotime(date('d-m-Y'))-strtotime($project->end_date);
													$due_day = abs(round($diff / 86400));

                                @endphp

                                <td>{{ date('d M, Y',strtotime($project->start_date))}}</td>
                                @if($due_day == 0)
                                    <td style="color:#FF0000;">{{ " Today" }}</td>
                                @else
                                    <td style="color:#FF0000;">{{ $due_day." days to go" }}</td>
                                @endif
                                <td>{{ $project->status }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    @if(!empty($expiryTask) && count($expiryTask) > 0)
    <div class="col-md-12">
        <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height mt-4">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h1 class="m-portlet__head-text">
                            Near Expiry Task
                        </h1>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="expiryTask">
                    <thead>
                        <tr class="heading">
                            <th>{{ __('messages.id')}}</th>
                            <th>{{ __('messages.task_title')}}</th>
                            <th>{{ __('messages.team_member')}}</th>
                            <th>{{ __('messages.project')}}</th>
                            <th>{{ __('messages.startdate')}}</th>
                            <th>{{ __('messages.enddate')}}</th>
                            <th>{{ __('messages.status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expiryTask as $key => $task)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $task->task_title}}</td>
                                <td>{{ $task->team_members_name}}</td>
                                <td>{{ $task->project->project_name}}</td>
                                @php
                                $diff = strtotime(date('d-m-Y'))-strtotime($task->end_date);
													$due_day = abs(round($diff / 86400));

                                @endphp

                                <td>{{ date('d M, Y',strtotime($task->start_date))}}</td>
                                @if($due_day == 0)
                                    <td style="color:#FF0000;">{{ " Today" }}</td>
                                @else
                                    <td style="color:#FF0000;">{{ $due_day." days to go" }}</td>
                                @endif
                                <td>{{ $task->status }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    {{-- <div id="chartContainer" style="height: 300px; width: 100%;"></div>
    <canvas id="myChart"></canvas> --}}
    <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <form name="save-event" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Event start</label>
                            <input type="text" name="evtStart" class="form-control col-xs-3" />
                        </div>
                        <div class="form-group">
                            <label>Event end</label>
                            <input type="text" name="evtEnd" class="form-control col-xs-3" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="popup-container">

        <div class="popup">

            <h3>How Your Mood Today?</h3>
            <form method="get" enctype="multipart/form-data" action="{{ route('attendance.insert_new') }}"
                method="POST">
                @csrf
                <input type="radio" name="emoji_id" value="1" id="btn1">
                <input type="radio" name="emoji_id" value="2" id="btn2">
                <input type="radio" name="emoji_id" value="3" id="btn3">
                <input type="radio" name="emoji_id" value="4" id="btn4">
                <input type="radio" name="emoji_id" value="5" id="btn5">

                <div class="icons">
                    <label for="btn1">🙁</label>
                    <label for="btn2">😐</label>
                    <label for="btn3">😊</label>
                    <label for="btn4">🤯</label>
                    <label for="btn5">😡</label>
                </div>

                <input type="submit" value="submit" class="btn">

                <div onclick="toggle()" id="close">✖</div>
            </form>
        </div>

    </div>

    <div class="modal1 fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4><input class="modal-title" type="text" name="title" id="title"
                            placeholder="Event Title/Description" /></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="starts-at">Starts at</label>
                            <input type="text" name="starts_at" id="starts-at" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="ends-at">Ends at</label>
                            <input type="text" name="ends_at" id="ends-at" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-event">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @php @$msg = Session::get('msg'); @endphp

    <button id="clear">clear</button>
@endsection
@section('footer_scripts')


    @push('scripts')

        <script src="{{ asset('vendors/js/calendar/tui-code-snippet.min.js') }}"></script>
        <script src="{{ asset('vendors/js/calendar/tui-dom.js') }}"></script>
        <script src="{{ asset('vendors/js/calendar/tui-time-picker.min.js') }}"></script>
        <script src="{{ asset('vendors/js/calendar/tui-date-picker.min.js') }}"></script>
        <script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
        <script src="{{ asset('vendors/js/calendar/chance.min.js') }}"></script>
        <script src="{{ asset('vendors/js/calendar/tui-calendar.min.js') }}"></script>

        <script src="{{ asset('js/scripts/extensions/calendar/calendars-data.js') }}"></script>
        <script src="{{ asset('js/scripts/extensions/calendar/schedules.js') }}"></script>
        {{-- <script src="{{ asset('js/scripts/extensions/calendar/app-calendar.js') }}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        @include('script');
        <script>
            $("#expiryProject").dataTable();
            $("#expiryTask").dataTable();

        </script>
        <?php if ($msg) { ?>
        <script>
            $(document).ready(function() {
                timer.start();
            });
        </script>
        <?php } ?>

        <script>
            const stopWatch = document.getElementById('stopWatch')
            const startBtn = document.getElementById('start')
            const stopBtn = document.getElementById('stop')
            const clearBtn = document.getElementById('clear')
            const speedBtn = document.getElementById('speed')

            class Timer {
                constructor(speed = 1) {
                    this.speed = speed
                    this.passed = localStorage.getItem("stopWatch") || 0
                    this.running = localStorage.getItem("running") === 'true' || false
                    this.interval = null
                    this.time = this.calculate()
                    this.init()
                }

                init = () => {
                    if (this.running) {
                        this.start()
                    }
                    this.show()
                }

                show = () => {
                    var H = this.format(this.time.h)
                    var M = this.format(this.time.m)
                    var S = this.format(this.time.s)
                    stopWatch?(stopWatch.textContent = H + ':' + M + ':' + S):'';

                }

                calculate = () => {
                    let delta = this.passed || 0
                    let h = Math.floor(delta / 3600)
                    delta -= h * 3600
                    let m = Math.floor(delta / 60) % 60;
                    delta -= m * 60
                    let s = parseInt(delta % 60);
                    if (s == 10) {
                        document.getElementById("punchout").style.display = 'block';
                    }
                    return {
                        h: h,
                        m: m,
                        s: s
                    }
                }

                update = () => {
                    this.passed++
                    this.time = this.calculate()
                    localStorage.setItem("stopWatch", this.passed);
                    this.show()
                }

                start = () => {
                    this.running = true
                    const startBtn = document.getElementById('start')
                    startBtn.disabled = true
                    stopBtn.disabled = false
                    localStorage.setItem("running", true);
                    this.interval = setInterval(() => this.update(), 1000 / this.speed)
                }

                stop = () => {
                    clearInterval(this.interval)
                    localStorage.setItem("running", false);
                    startBtn.disabled = false
                    document.getElementById("stop").disabled = true;
                    //stopBtn.disabled = true
                }

                clear = () => {
                    this.time = {
                        h: 0,
                        m: 0,
                        s: 0
                    }
                    this.passed = 0
                    this.stop()
                    this.show()
                    localStorage.removeItem("stopWatch")
                }

                setSpeed = () => {
                    this.speed = speedBtn.value
                }

                format = (n) => {
                    return n.toLocaleString('en-US', {
                        minimumIntegerDigits: 2,
                        useGrouping: false
                    })
                }

            }

            const timer = new Timer()
            startBtn.onclick = () => timer.start() // This arrow notation is a must here, or else timer starts immediately
            clearBtn.onclick = () => timer.clear()
            stopBtn.onclick = () => timer.stop()
            speedBtn.onchange = () => timer.setSpeed()
        </script>
        <script>
            function toggle() {

                // let toggle = document.querySelector('.popup-container')

                // toggle.classList.toggle('toggle');

            }
        </script>

        <script>
            window.onload = function() {
                clock();

                function clock() {
                    var now = new Date();
                    var TwentyFourHour = now.getHours();
                    var hour = now.getHours();
                    var min = now.getMinutes();
                    var sec = now.getSeconds();
                    var mid = 'pm';
                    if (min < 10) {
                        min = "0" + min;
                    }
                    if (hour > 12) {
                        hour = hour - 12;
                    }
                    if (hour == 0) {
                        hour = 12;
                    }
                    if (TwentyFourHour < 12) {
                        mid = 'am';
                    }
                    document.getElementById('currentTime').innerHTML = hour + ':' + min + ':' + sec + ' ' + mid;
                    setTimeout(clock, 1000);
                }
            }
        </script>

        <style type="text/css">
            @media (min-width: 768px) {
                .col-md-6 {
                    max-width: 45% !important;
                }
            }

            #calendar {
                width: 80%;
                margin: 5% auto;
                border: 1px solid #e5e5e5;
                overflow: hidden;
            }

            mark {
                font-size: 20px;
                font-weight: bold;
                background-color: #D3D3D3;
                padding: 0 10px;
            }

            .time-img {
                height: 200px;
                width: 200px;
            }

            .padding {
                padding: 5px;
            }

            .punch {
                height: 30px;
                border-radius: 30px;
            }

            #currentTime {
                font-family: 'Oswald';
                font-weight: 700;
                font-size: 1.5em;
                color: #34bfa3;
            }

            .tabicon {
                font-size: 2rem;
            }

            hr.rounded {
                border-top: 4px solid;
                color: #34bfa3;
                margin-top: 0rem;
                margin-bottom: 0.5rem;
            }

            .icondiv {
                margin: auto;
                opacity: 50%;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                outline: none;
                border: none;
                transition: all .2s linear;
                text-transform: capitalize;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            .container {
                min-height: 100vh;
                background: #eee;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .btn {
                /*color: #fff;
                  background: #ff6933; */
                box-shadow: 0 5px 10px rgba(0, 0, 0, .3);
                border-radius: 5px;
                cursor: pointer;
            }

            .btn:hover {
                background: #ff4400;
            }

            .btn:active {
                transform: scale(.90);
            }

            #button {
                font-size: 25px;
                height: 60px;
                width: 250px;
            }

            .popup-container {
                position: fixed;
                top: -120%;
                left: 0;
                z-index: 1000;
                background: rgba(0, 0, 0, .3);
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                width: 100%;
            }

            .popup-container.toggle {
                top: 0%;
            }

            .popup-container .popup {
                background: #fff;
                text-align: center;
                margin: 10px;
                padding: 10px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, .5);
                border-radius: 5px;
                position: relative;
            }

            .popup-container .popup h3 {
                color: #444;
                padding: 20px 40px;
                font-size: 25px;
            }

            .popup-container .popup .btn {
                margin: 30px;
                font-size: 20px;
                height: 40px;
                width: 150px;
            }

            .popup-container .popup input[type="radio"] {
                display: none;
            }

            .popup-container .popup .icons {
                padding: 10px;
            }

            .popup-container .popup .icons label {
                font-size: 50px;
                cursor: pointer;
                opacity: .4;
            }

            .popup-container .popup .icons:hover label {
                opacity: .2;
            }


            .popup-container .popup #btn1:checked~.icons label:nth-child(1),
            .popup-container .popup #btn2:checked~.icons label:nth-child(2),
            .popup-container .popup #btn3:checked~.icons label:nth-child(3),
            .popup-container .popup #btn4:checked~.icons label:nth-child(4),
            .popup-container .popup #btn5:checked~.icons label:nth-child(5),
            .popup-container .popup .icons label:hover {
                opacity: 1;
                font-size: 60px;
            }

            .popup-container .popup #close {
                position: absolute;
                top: -15px;
                right: -15px;
                border-radius: 50%;
                border: 4px solid #ff6933;
                height: 40px;
                width: 40px;
                line-height: 35px;
                cursor: pointer;
                background: #333;
                color: #fff;
                font-size: 20px;
            }

            .popup-container .popup #close:hover {
                transform: rotate(90deg);
            }
        </style>
    @endpush
