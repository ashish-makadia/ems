@extends('layouts.app')
@section('subheader',"Attendance Listing")
@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/tui-time-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/tui-date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/tui-calendar.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/calendars/app-calendar.css')}}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

  @media screen and (max-height: 450px) {
    .sidenav {
      padding-top: 15px;
    }

    .sidenav a {
      font-size: 18px;
    }
  }
</style>
<div class="m-portlet m-portlet--mobile">
  <div class="m-portlet__head">
    <div class="m-portlet__head-caption">
      <div class="m-portlet__head-title">
        <h3 class="m-portlet__head-text">
          Attendance
        </h3>
      </div>
    </div>

  </div>
  <div class="m-portlet__body">

    <!--begin: Datatable -->
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
            <button id="dropdownMenu-calendarType" class="btn btn-action dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i id="calendarTypeIcon" class="bx bx-calendar-alt"></i>
              <span id="calendarTypeName">Dropdown</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu-calendarType">
              <li role="presentation">
                <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-daily">
                  <i class="bx bx-calendar-alt mr-50"></i>
                  <span>Daily</span>
                </a>
              </li>
              <li role="presentation">
                <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-weekly">
                  <i class='bx bx-calendar-event mr-50'></i>
                  <span>Weekly</span>
                </a>
              </li>
              <li role="presentation">
                <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-monthly">
                  <i class="bx bx-calendar mr-50"></i>
                  <span>Month</span>
                </a>
              </li>
              <li role="presentation">
                <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-weeks2">
                  <i class='bx bx-calendar-check mr-50'></i>
                  <span>2 weeks</span>
                </a>
              </li>
              <li role="presentation">
                <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-weeks3">
                  <i class='bx bx-calendar-check mr-50'></i>
                  <span>3 weeks</span>
                </a>
              </li>
              <li role="presentation" class="dropdown-divider"></li>
              <li role="presentation">
                <div role="menuitem" data-action="toggle-workweek" class="dropdown-item">
                  <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
                  <span class="checkbox-title bg-primary"></span>
                  <span>Show weekends</span>
                </div>
              </li>
              <li role="presentation">
                <div role="menuitem" data-action="toggle-start-day-1" class="dropdown-item">
                  <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                  <span class="checkbox-title"></span>
                  <span>Start Week on Monday</span>
                </div>
              </li>
              <li role="presentation">
                <div role="menuitem" data-action="toggle-narrow-weekend" class="dropdown-item">
                  <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
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
            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name"><b>Start Date</b></label>
                    <input type="date" class="form-control" value="" name="start_date" id="from_date">
                    <input type="hidden" class="form-control" value="" id="type">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name"><b>End Date</b></label>
                    <input type="date" class="form-control" value="" name="end_date" id="to_date">
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
                        <button type="button" id="butsave" class="btn btn-primary btn-block" style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i> Save</button>
                    </div>
                </div>
            </div>
            </form>
          </div>
          <!-- calenadar next and previous navigate button -->
          <span id="menu-navi" class="menu-navigation">
            <button type="button" class="btn btn-action move-today mr-50 px-75" data-action="move-today">Today</button>
            <button type="button" class="btn btn-icon btn-action  move-day mr-50 px-50" data-action="move-prev">
              <i class="far fa-arrow-alt-circle-left" data-action="move-prev"></i>
            </button>
            <button type="button" class="btn btn-icon btn-action move-day mr-50 px-50" data-action="move-next">
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
                    <input type="checkbox" class="checkbox-input tui-full-calendar-checkbox-square" id="checkbox1" value="all" checked>
                    <label for="checkbox1">View all</label>
                  </div>
                </div>
              </div>
              <div id="calendarList" style="display: flex;" class="sidebar-calendars-d1"></div>
              <div id="buttonDiv" style="display: none;" class="sidebar-calendars-d1">
                <a href="#" onclick="openNav(1)" style="background-color: #f91818;border-color: #dc0000;box-shadow: 0px 5px 10px 2px rgb(255 9 9 / 19%) !important;" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"><b>Apply Opt Holiday</b></a>
                <a href="#" onclick="openNav(2)" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"><b>Apply Present</b></a>
                <a href="#" onclick="openNav(3)" style="background-color: #a13aff;border-color: #a13aff;box-shadow: 0px 5px 10px 2px rgb(161 58 255 / 19%) !important" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"> <b>Apply Leave</b></a>
                <a href="#" onclick="openNav(4)" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"><b>Apply Comp Off</b></a>
              </div>
            </div>
            <!-- / sidebar calendar labels -->
          </div>

        </div>
        <!-- calendar view  -->
        <div id="calendar" style="width: 100%!important;" class="calendar-content"></div>
      </div>
      <!-- calendar view end  -->
    </div>
  </div>
</div>
<!-- Sliding div starts here -->

@endsection
@section('footer_scripts')
@push('scripts')

<script src="{{asset('vendors/js/calendar/tui-code-snippet.min.js')}}"></script>
<!-- <script src="{{asset('vendors/js/calendar/tui-dom.js')}}"></script>
<script src="{{asset('vendors/js/calendar/tui-time-picker.min.js')}}"></script>
<script src="{{asset('vendors/js/calendar/tui-date-picker.min.js')}}"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script> -->
<!-- <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script> -->
<!-- <script src="{{asset('vendors/js/calendar/chance.min.js')}}"></script> -->
<script src="{{asset('vendors/js/calendar/tui-calendar.min.js')}}"></script>
<!-- <script src="{{asset('js/scripts/extensions/calendar/calendars-data.js')}}"></script> -->

<script type="text/javascript">

'use strict';

  var CalendarList = [];
  var primaryColor = "#5A8DEE";
  var primaryLight = "#E2ECFF";
  var secondaryColor = "#475F7B";
  var secondaryLight = "#E6EAEE";
  var successColor = "#39DA8A";
  var successLight = "#D2FFE8";
  var dangercolor = "#FF5B5C";
  var dangerLight = "#FFDEDE";
  var warningColor = "#FDAC41";
  var warningLight = "#FFEED9";
  var infoColor = "#00CFDD";
  var infoLight = "#CCF5F8 ";
  var lightColor = "#b3c0ce";
  var veryLightBlue = "#e7edf3";
  var cloudyBlue = "#b3c0ce";

  function CalendarInfo() {
    this.id = null;
    this.name = null;
    this.checked = true;
    this.color = null;
    this.bgColor = null;
    this.borderColor = null;
    this.dragBgColor = null;
  }

  function addCalendar(calendar) {
    CalendarList.push(calendar);
  }

  function findCalendar(id) {
    var found;

    CalendarList.forEach(function(calendar) {
      if (calendar.id === id) {
        found = calendar;
      }
    });

    return found || CalendarList[0];
  }

  function hexToRGBA(hex) {
    var radix = 16;
    var r = parseInt(hex.slice(1, 3), radix),
      g = parseInt(hex.slice(3, 5), radix),
      b = parseInt(hex.slice(5, 7), radix),
      a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
    var rgba = 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';

    return rgba;
  }

  (function() {
    var calendar;
    var id = 0;

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = 'Applied Leave';
    calendar.color = "#798283";
    calendar.bgColor = primaryLight;
    calendar.dragBgColor = "#798283";
    calendar.borderColor = "#798283";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = 'Opt Holiday';
    calendar.color = "#ff54b3";
    calendar.bgColor = primaryLight;
    calendar.dragBgColor = "#ff54b3";
    calendar.borderColor = "#ff54b3";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = 'Present';
    calendar.color = "#00C878";
    calendar.bgColor = secondaryLight;
    calendar.dragBgColor = "#00C878";
    calendar.borderColor = "#00C878";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = 'Leave';
    calendar.color = "#a13aff";
    calendar.bgColor = successLight;
    calendar.dragBgColor = "#a13aff";
    calendar.borderColor = "#a13aff";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = 'Absent';
    calendar.color = dangercolor;
    calendar.bgColor = dangerLight;
    calendar.dragBgColor = dangerLight;
    calendar.borderColor = dangercolor;
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = 'Holidays';
    calendar.color = warningColor;
    calendar.bgColor = warningLight;
    calendar.dragBgColor = warningColor;
    calendar.borderColor = warningColor;
    addCalendar(calendar);



  })();

//   isWeekend: function(day) {
//     return day === 5 || day === 6;
// },

  (function(window, Calendar) {

    var cal, resizeThrottled;
    var useCreationPopup = true;
    var useDetailPopup = true;
    var datePicker, selectedCalendar;

    cal = new Calendar('#calendar', {

      defaultView: 'month',

      month: {
     //   daynames = c("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"),
        startDayOfWeek: 1,
        weekend: {
              backgroundColor: 'rgba(255, 64, 64, 0.4)',
            },
        },
        week: {

          weekend: {
              backgroundColor: 'rgba(255, 64, 64, 0.4)',
            },
        },
      useCreationPopup: false,
      useDetailPopup: true,
      calendars: CalendarList,

      template: {

          monthGridHeader: function (data) {
           var date = parseInt(data.date.split('-')[2], 10);
            if(data.day===6 || data.day===0){
              return (
              '<span class="calendar-month-header" style="margin-left: 4px;">'+ date +'  Weekoff</span>'
            );

            }else{
              return (
              '<span class="calendar-month-header" style="margin-left: 4px;">'+ date +'</span>'
            );
            }
           // common.saturday.color = "#88C0D0",

          },

          milestone: function(model) {
          return '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
        },
        allday: function(schedule) {
          return getTimeTemplate(schedule, true);
        },
        time: function(schedule) {
          return getTimeTemplate(schedule, false);
        }
        },
    });
    function convert(str) {
  var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
  return [date.getFullYear(), mnth, day].join("-");
}
    // event handlers
    cal.on({
      'clickMore': function(e) {

            console.log('clickMore', e);
        },
      'clickSchedule': function(e) {
        console.log('clickSchedule', e);
      },
      'beforeCreateSchedule': function(e) {
        console.log('beforeCreateSchedule', e);
        var startTime = e.start;
       var new_date = (convert(startTime));
       document.getElementById("from_date").value = new_date;
       document.getElementById("to_date").value = new_date;
        document.getElementById("calendarList").style.display = "none";
        document.getElementById("buttonDiv").style.display = "block";
      },
      'beforeUpdateSchedule': function(e) {
        console.log('beforeUpdateSchedule', e);
        e.schedule.start = e.start;
        e.schedule.end = e.end;
        cal.updateSchedule(e.schedule.id, e.schedule.calendarId, e.schedule);
      },
      'beforeDeleteSchedule': function(e) {
        console.log('beforeDeleteSchedule', e);
        cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
      }
    });

    function getTimeTemplate(schedule, isAllDay) {
      var html = [];
      var start = moment(schedule.start.toUTCString());
      if (!isAllDay) {
        html.push('<strong>' + start.format('HH:mm') + '</strong> ');
      }
      if (schedule.isPrivate) {
        html.push('<span class="calendar-font-icon ic-lock-b"></span>');
        html.push(' Private');
      } else {
        if (schedule.isReadOnly) {
          html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
        } else if (schedule.recurrenceRule) {
          html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
        } else if (schedule.attendees.length) {
          html.push('<span class="calendar-font-icon ic-user-b"></span>');
        } else if (schedule.location) {
          html.push('<span class="calendar-font-icon ic-location-b"></span>');
        }
        html.push(' ' + schedule.title);
      }

      return html.join('');
    }

    function onClickNavi(e) {
      var action = getDataAction(e.target);

      switch (action) {
        case 'move-prev':
          cal.prev();
          break;
        case 'move-next':
          cal.next();
          break;
        case 'move-today':
          cal.today();
          break;
        default:
          return;
      }

      setRenderRangeText();
      setSchedules();
    }

    function onNewSchedule() {
      var title = $('#new-schedule-title').val();
      var location = $('#new-schedule-location').val();
      var isAllDay = document.getElementById('new-schedule-allday').checked;
      var start = datePicker.getStartDate();
      var end = datePicker.getEndDate();
      var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

      if (!title) {
        return;
      }

      console.log('calendar.id ', calendar.id)
      cal.createSchedules([{
        id: '1',
        calendarId: calendar.id,
        title: title,
        isAllDay: isAllDay,
        start: start,
        end: end,
        category: isAllDay ? 'allday' : 'time',
        dueDateClass: '',
        color: calendar.color,
        bgColor: calendar.bgColor,
        dragBgColor: calendar.bgColor,
        borderColor: calendar.borderColor,
        raw: {
          location: location
        },
        state: 'Busy'
      }]);

      $('#modal-new-schedule').modal('hide');
    }

    function onChangeNewScheduleCalendar(e) {
      var target = $(e.target).closest('a[role="menuitem"]')[0];
      var calendarId = getDataAction(target);
      changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
      var calendarNameElement = document.getElementById('calendarName');
      var calendar = findCalendar(calendarId);
      var html = [];

      html.push('<span class="calendar-bar" style="background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';"></span>');
      html.push('<span class="calendar-name">' + calendar.name + '</span>');

      calendarNameElement.innerHTML = html.join('');

      selectedCalendar = calendar;
    }

    function createNewSchedule(event) {
      var start = event.start ? new Date(event.start.getTime()) : new Date();
      var end = event.end ? new Date(event.end.getTime()) : moment().add(1, 'hours').toDate();

      if (useCreationPopup) {
        cal.openCreationPopup({
          start: start,
          end: end
        });
      }
    }

    function saveNewSchedule(scheduleData) {
      console.log('scheduleData ', scheduleData)
      var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
      var schedule = {
        id: '1',
        title: scheduleData.title,
        isAllDay: scheduleData.isAllDay,
        start: scheduleData.start,
        end: scheduleData.end,
        category: 'allday',
        category: scheduleData.isAllDay ? 'allday' : 'time',
        dueDateClass: '',
        color: calendar.color,
        bgColor: calendar.bgColor,
        dragBgColor: calendar.bgColor,
        borderColor: calendar.borderColor,
        location: scheduleData.location,
        raw: {
          class: scheduleData.raw['class']
        },
        state: scheduleData.state
      };
      if (calendar) {
        schedule.calendarId = calendar.id;
        schedule.color = calendar.color;
        schedule.bgColor = calendar.bgColor;
        schedule.borderColor = calendar.borderColor;
      }

      cal.createSchedules([schedule]);

      refreshScheduleVisibility();
    }


    function refreshScheduleVisibility() {
      var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

      CalendarList.forEach(function(calendar) {
        alert(calendar);
        cal.toggleSchedules(calendar.id, !calendar.checked, false);
      });

      cal.render(true);

      calendarElements.forEach(function(input) {
        var span = input.nextElementSibling;
        span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
      });
    }


    function setRenderRangeText() {
      var renderRange = document.getElementById('renderRange');
      var options = cal.getOptions();
      var viewName = cal.getViewName();
      var html = [];
      if (viewName === 'day') {
        html.push(moment(cal.getDate().getTime()).format('MMM YYYY DD'));
      } else if (viewName === 'month' &&
        (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
        html.push(moment(cal.getDate().getTime()).format('MMM YYYY'));
      } else {
        html.push(moment(cal.getDateRangeStart().getTime()).format('MMM YYYY DD'));
        html.push(' ~ ');
        html.push(moment(cal.getDateRangeEnd().getTime()).format(' MMM DD'));
      }
      renderRange.innerHTML = html.join('');
    }

    function setSchedules() {
      cal.clear();
      var schedules = [
        <?php foreach($attend as $data){?> {
          id: "{{ $data->id }}",
          title: "<?php echo date('h:i a', strtotime($data->DateTimePunchedIn)); ?> | {{ $data->username }}",
          isAllDay: false,
          start: "{{ $data->DateTimePunchedIn }}",
          end: "{{ $data->DateTimePunchedOut }}",
          color: '#ffffff',
          isVisible: true,
          bgColor: '',
          dragBgColor: '',
          borderColor: '',
          calendarId: '3',
          category: 'allday',
          dueDateClass: '',
          customStyle: 'cursor: default;',
          isPending: false,
          isFocused: false,
          isReadOnly: true,
          isPrivate: false,
          location: '{{ $data->location }}',
          attendees: '',
          recurrenceRule: '',
          state: ''
        },
        <?php } ?>
        <?php foreach($c_holiday as $data) { ?> {
          id: "{{ $data->id }}",
          title: "{{ $data->name }}",
          isAllDay: false,
          start: "{{ $data->from_date }}",
          end: "{{ $data->to_date }}",
          color: '#ffffff',
          isVisible: true,
          bgColor: '',
          dragBgColor: '',
          borderColor: '',
          calendarId: '6',
          category: 'allday',
          dueDateClass: '',
          customStyle: 'cursor: default;',
          isPending: false,
          isFocused: false,
          isReadOnly: true,
          isPrivate: false,
          location: '{{ $data->location }}',
          attendees: '',
          recurrenceRule: '',
          state: ''
        },
        <?php } ?>
        <?php foreach($o_holiday as $data) { ?> {
          id: "{{ $data->id }}",
          title: "{{ $data->name }}",
          isAllDay: false,
          start: "{{ $data->from_date }}",
          end: "{{ $data->to_date }}",
          color: '#ffffff',
          isVisible: true,
          bgColor: '',
          dragBgColor: '',
          borderColor: '',
          calendarId: '2',
          category: 'allday',
          dueDateClass: '',
          customStyle: 'cursor: default;',
          isPending: false,
          isFocused: false,
          isReadOnly: true,
          isPrivate: false,
          location: '{{ $data->location }}',
          attendees: '',
          recurrenceRule: '',
          state: ''
        },
       <?php } ?>
        <?php foreach($applied_leave as $data){ ?> {
          id: "{{ $data->id }}",
          title: "Applied Leave | {{ $data->username }}",
          isAllDay: false,
          start: "{{ $data->from_date }}",
          end: "{{ $data->to_date }}",
          color: '#ffffff',
          isVisible: true,
          bgColor: '',
          dragBgColor: '',
          borderColor: '',
          calendarId: '1',
          category: 'allday',
          dueDateClass: '',
          customStyle: 'cursor: default;',
          isPending: false,
          isFocused: false,
          isReadOnly: true,
          isPrivate: false,
          location: '{{ $data->location }}',
          attendees: '',
          recurrenceRule: '',
          state: ''
        },
        <?php } ?>
        <?php foreach($leave as $data){ ?> {
          id: "{{ $data->id }}",
          title: "{{ $data->username }}",
          isAllDay: false,
          start: "{{ $data->from_date }}",
          end: "{{ $data->to_date }}",
          color: '#ffffff',
          isVisible: true,
          bgColor: '',
          dragBgColor: '',
          borderColor: '',
          calendarId: '4',
          category: 'allday',
          dueDateClass: '',
          customStyle: 'cursor: default;',
          isPending: false,
          isFocused: false,
          isReadOnly: true,
          isPrivate: false,
          location: '{{ $data->location }}',
          attendees: '',
          recurrenceRule: '',
          state: ''
        },
        <?php } ?>
      ];
      // generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd());
      cal.createSchedules(schedules);
      // cal.createSchedules(schedules);
      refreshScheduleVisibility();
    }
    // view all checkbox initialize
    function onChangeCalendars(e) {
      var calendarId = e.target.value;
      var checked = e.target.checked;
      var viewAll = document.querySelector('.sidebar-calendars-item input');
      var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
      var allCheckedCalendars = true;

      if (calendarId === 'all') {
        allCheckedCalendars = checked;

        calendarElements.forEach(function(input) {
          var span = input.parentNode;
          input.checked = checked;
          span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
        });

        CalendarList.forEach(function(calendar) {
          calendar.checked = checked;
        });
      } else {
        findCalendar(calendarId).checked = checked;

        allCheckedCalendars = calendarElements.every(function(input) {
          return input.checked;
        });

        if (allCheckedCalendars) {
          viewAll.checked = true;
        } else {
          viewAll.checked = false;
        }
      }
      refreshScheduleVisibility();
    }
    // schedule refresh according to view
    function refreshScheduleVisibility() {
      var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

      CalendarList.forEach(function(calendar) {
        cal.toggleSchedules(calendar.id, !calendar.checked, false);
      });

      cal.render(true);

      calendarElements.forEach(function(input) {
        var span = input.nextElementSibling;
        span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
      });
    }
    // A listener for click the menu
    function onClickMenu(e) {
      var target = $(e.target).closest('[role="menuitem"]')[0];
      var action = getDataAction(target);
      var options = cal.getOptions();
      var viewName = '';
      // on click of dropdown button change calendar view
      switch (action) {
        case 'toggle-daily':
          viewName = 'day';
          break;
        case 'toggle-weekly':
          viewName = 'week';
          break;
        case 'toggle-monthly':
          options.month.visibleWeeksCount = 0;
          options.month.isAlways6Week = false;
          viewName = 'month';
          break;
        case 'toggle-weeks2':
          options.month.visibleWeeksCount = 2;
          viewName = 'month';
          break;
        case 'toggle-weeks3':
          options.month.visibleWeeksCount = 3;
          viewName = 'month';
          break;
        case 'toggle-narrow-weekend':
          options.month.narrowWeekend = !options.month.narrowWeekend;
          options.week.narrowWeekend = !options.week.narrowWeekend;
          viewName = cal.getViewName();

          target.querySelector('input').checked = options.month.narrowWeekend;
          break;
        case 'toggle-start-day-1':
          options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
          options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
          viewName = cal.getViewName();

          target.querySelector('input').checked = options.month.startDayOfWeek;
          break;
        case 'toggle-workweek':
          options.month.workweek = !options.month.workweek;
          options.week.workweek = !options.week.workweek;
          viewName = cal.getViewName();

          target.querySelector('input').checked = !options.month.workweek;
          break;
        default:
          break;
      }
      cal.setOptions(options, true);
      cal.changeView(viewName, true);

      setDropdownCalendarType();
      setRenderRangeText();
      setSchedules();
    }

    function setEventListener() {
      $('.menu-navigation').on('click', onClickNavi);
      $('.dropdown-menu [role="menuitem"]').on('click', onClickMenu);
      $('.sidebar-calendars').on('change', onChangeCalendars);
      $('.sidebar-new-schedule-btn').on('click', createNewSchedule);
      window.addEventListener('resize', resizeThrottled);
    }

    function getDataAction(target) {
      return target.dataset ? target.dataset.action : target.getAttribute('data-action');
    }

    resizeThrottled = tui.util.throttle(function() {
      cal.render();
    }, 50);

    window.cal = cal;

    // setDropdownCalendarType();
    setRenderRangeText();
    setSchedules();
    setEventListener();
  })(window, tui.Calendar);

  // set calendars
  (function() {
    var calendarList = document.getElementById('calendarList');
    var html = [];
    CalendarList.forEach(function(calendar) {
      html.push('<div class="lnb-calendars-item" style="padding-right: 40px;"><label>' +
        '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
        '<span style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';"></span>' +
        '<span>' + calendar.name + '</span>' +
        '</label></div>'
      );
    });
    calendarList.innerHTML = html.join('\n');
  })();
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
</script>
<script>
  function openNav(value) {
    if (value == 1) {
      document.getElementById("header_sidebar").innerHTML = "Apply Opt Holiday";
      document.getElementById("type").value = value;
    } else if (value == 2) {
      document.getElementById("header_sidebar").innerHTML = "Apply Present";
      document.getElementById("type").value = value;
    } else if (value == 3) {
      document.getElementById("header_sidebar").innerHTML = "Apply Leave";
      document.getElementById("type").value = value;
    } else {
      document.getElementById("header_sidebar").innerHTML = "Apply Comp Off";
      document.getElementById("type").value = value;
    }

    document.getElementById("mySidenav").style.width = "430px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }




  // function submit_leave_form() {
  //   var type = document.getElementById('modal_type');
  //   var from_date = document.getElementById('from_date');
  //   var to_date = document.getElementById('to_date');
  //   var comment = document.getElementById('comment');
  //   alert(type);
  //       $.ajax({
  //           url: "{{ url('leave-management/insert_leave') }}",
  //           type: 'POST',
  //           data: {

  //               "_token": "{{ csrf_token() }}",
  //               "type": type,
  //               "from_date": from_date,
  //               "to_date": to_date,
  //               "comment": comment
  //           },
  //           success: function(response) {
  //             alert("hii");
  //               // if(response.status){
  //               //     window.location.href = '{{ route("project.index") }}';
  //               // } else {
  //               //     toastr.error(response.message);
  //               // }
  //           }
  //       });
  //   };
</script>
<script>
$(document).ready(function() {

    $('#butsave').on('click', function() {
      var type = $('#type').val();
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var comment = $('#comment').val();
      if(type!="" && from_date!="" && to_date!="" && comment!=""){
        /*  $("#butsave").attr("disabled", "disabled"); */
          $.ajax({
              url: "{{ url('leave-management/insert_leave') }}",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                  "type": type,
                "from_date": from_date,
                "to_date": to_date,
                "comment": comment
              },
              cache: false,
              success: function(dataResult){

                  if(dataResult.status){
                    location.reload();
                  }

              }
          });
      }
      else{
          alert('Please fill all the field !');
      }
  });
});
</script>
@endpush
