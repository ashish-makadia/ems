
'use strict';

(function (window, Calendar) {
  // variables
  var cal, resizeThrottled;
  var useCreationPopup = true;
  var useDetailPopup = true;

  // default keys and styles of calendar
  var themeConfig = {
    'common.border': '1px solid #DFE3E7',
    'common.backgroundColor': 'white',
    'common.holiday.color': '#FF5B5C',
    'common.saturday.color': '#304156',
    'common.dayname.color': '#304156',
    'month.dayname.borderLeft': '1px solid transparent',
    'month.dayname.fontSize': '1rem',
    'week.dayGridSchedule.borderRadius': '4px',
    'week.timegridSchedule.borderRadius': '4px',
  }

  // calendar initialize here'
//   schedule = [
//     {id: 489273, title: 'Workout for 2020-04-05', isAllDay: false, start: '2020-02-01T11:30:00+09:00', end: '2020-02-01T12:00:00+09:00', goingDuration: 30, comingDuration: 30, color: '#ffffff', isVisible: true, bgColor: '#69BB2D', dragBgColor: '#69BB2D', borderColor: '#69BB2D', calendarId: 'Post', category: 'time', dueDateClass: '', customStyle: 'cursor: default;', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
//     {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-02-17T09:00:00+09:00', end: '2020-02-17T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: 'Event', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''}
// ];
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
    useCreationPopup: useCreationPopup,
    useDetailPopup: useDetailPopup,
    calendars: CalendarList,
    theme: themeConfig,
    template: {
      milestone: function (model) {
        return '<span class="bx bx-flag align-middle"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
      },
      allday: function (schedule) {
        return getTimeTemplate(schedule, true);
      },
      time: function (schedule) {
        return getTimeTemplate(schedule, false);
      },
      monthGridHeader: function(data) {
        var date = parseInt(data.date.split('-')[2], 10);
        if (data.day === 6 || data.day === 0) {
            return (
                '<span class="calendar-month-header" style="margin-left: 4px;">' +
                date + '  Weekoff</span>'
            );

        } else {
            return (
                '<span class="calendar-month-header" style="margin-left: 4px;">' +
                date + '</span>'
            );
        }
        // common.saturday.color = "#88C0D0",

    },
    }
  });
  function convert(str) {
    var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
}

  // calendar default on click event
  cal.on({
    'clickSchedule': function (e) {
      $(".tui-full-calendar-popup-top-line").css("background-color", e.calendar.color);
      $(".tui-full-calendar-calendar-dot").css("background-color", e.calendar.borderColor);
    },
    'beforeCreateSchedule': function (e) {
      // new schedule create and save
      saveNewSchedule(e);
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
    'beforeUpdateSchedule': function (e) {
      // schedule update
      e.schedule.start = e.start;
      e.schedule.end = e.end;
      cal.updateSchedule(e.schedule.id, e.schedule.calendarId, e.schedule);
    },
    'beforeDeleteSchedule': function (e) {
      // schedule delete
      console.log('beforeDeleteSchedule', e);
      cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
    },
    'clickTimezonesCollapseBtn': function (timezonesCollapsed) {
      if (timezonesCollapsed) {
        cal.setTheme({
          'week.daygridLeft.width': '77px',
          'week.timegridLeft.width': '77px'
        });
      } else {
        cal.setTheme({
          'week.daygridLeft.width': '60px',
          'week.timegridLeft.width': '60px'
        });
      }
      return true;
    }
  });

  // Create Event according to their Template
  function getTimeTemplate(schedule, isAllDay) {
    var html = [];
    var start = moment(schedule.start.toUTCString());
    if (!isAllDay) {
      html.push('<span>' + start.format('HH:mm') + '</span> ');
    }
    if (schedule.isPrivate) {
      html.push('<span class="bx bxs-lock-alt font-size-small align-middle"></span>');
      html.push(' Private');
    } else {
      if (schedule.isReadOnly) {
        html.push('<span class="bx bx-block font-size-small align-middle"></span>');
      } else if (schedule.recurrenceRule) {
        html.push('<span class="bx bx-repeat font-size-small align-middle"></span>');
      } else if (schedule.attendees.length) {
        html.push('<span class="bx bxs-user font-size-small align-middle"></span>');
      } else if (schedule.location) {
        html.push('<span class="bx bxs-map font-size-small align-middle"></span>');
      }
      html.push(' ' + schedule.title);
    }
    return html.join('');
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

  // on click of next and previous button view change
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

  // Click of new schedule button's open schedule create popup
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
  // new schedule create
  function saveNewSchedule(scheduleData) {
    var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
    var schedule = {
      id: String(chance.guid()),
      title: scheduleData.title,
      isAllDay: scheduleData.isAllDay,
      start: scheduleData.start,
      end: scheduleData.end,
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

  // view all checkbox initialize
  function onChangeCalendars(e) {
    var calendarId = e.target.value;
    var checked = e.target.checked;
    var viewAll = document.querySelector('.sidebar-calendars-item input');
    var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
    var allCheckedCalendars = true;

    if (calendarId === 'all') {
      allCheckedCalendars = checked;

      calendarElements.forEach(function (input) {
        var span = input.parentNode;
        input.checked = checked;
        span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
      });

      CalendarList.forEach(function (calendar) {
        calendar.checked = checked;
      });
    } else {
      findCalendar(calendarId).checked = checked;

      allCheckedCalendars = calendarElements.every(function (input) {
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

    CalendarList.forEach(function (calendar) {
      cal.toggleSchedules(calendar.id, !calendar.checked, false);
    });

    cal.render(true);

    calendarElements.forEach(function (input) {
      var span = input.nextElementSibling;
      span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
    });
  }
  // calendar type set on dropdown button
  function setDropdownCalendarType() {
    var calendarTypeName = document.getElementById('calendarTypeName');
    var calendarTypeIcon = document.getElementById('calendarTypeIcon');
    var options = cal.getOptions();
    var type = cal.getViewName();
    var iconClassName;

    if (type === 'day') {
      type = 'Daily';
      iconClassName = 'bx bx-calendar-alt mr-25';
    } else if (type === 'week') {
      type = 'Weekly';
      iconClassName = 'bx bx-calendar-event mr-25';
    } else if (options.month.visibleWeeksCount === 2) {
      type = '2 weeks';
      iconClassName = 'bx bx-calendar-check mr-25';
    } else if (options.month.visibleWeeksCount === 3) {
      type = '3 weeks';
      iconClassName = 'bx bx-calendar-check mr-25';
    } else {
      type = 'Monthly';
      iconClassName = 'bx bx-calendar mr-25';
    }
    calendarTypeName.innerHTML = type;
    calendarTypeIcon.className = iconClassName;
  }

  function setRenderRangeText() {
    var renderRange = document.getElementById('renderRange');
    var options = cal.getOptions();
    var viewName = cal.getViewName();
    var html = [];
    if (viewName === 'day') {
      html.push(moment(cal.getDate().getTime()).format('YYYY-MM-DD'));
    } else if (viewName === 'month' &&
      (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
      html.push(moment(cal.getDate().getTime()).format('YYYY-MM'));
    } else {
      html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY-MM-DD'));
      html.push('-');
      html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
    }
    renderRange.innerHTML = html.join('');
  }
  // Randome Generated schedule
  function setSchedules() {
    cal.clear();
    console.log("ScheduleList", ScheduleList);
    generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd());
    cal.createSchedules(ScheduleList);
    refreshScheduleVisibility();
  }
  // Events initialize
  function setEventListener() {
    $('.menu-navigation').on('click', onClickNavi);
    $('.dropdown-menu [role="menuitem"]').on('click', onClickMenu);
    $('.sidebar-calendars').on('change', onChangeCalendars);
    $('.sidebar-new-schedule-btn').on('click', createNewSchedule);
    window.addEventListener('resize', resizeThrottled);
  }
  // get data-action atrribute's value
  function getDataAction(target) {
    return target.dataset ? target.dataset.action : target.getAttribute('data-action');
  }
  resizeThrottled = tui.util.throttle(function () {
    cal.render();
  }, 50);
  window.cal = cal;
  setDropdownCalendarType();
  setRenderRangeText();
  setSchedules();
  setEventListener();
})(window, tui.Calendar);


// set sidebar calendar list
(function () {
  var calendarList = document.getElementById('calendarList');

  var html = [];
  CalendarList.forEach(function (calendar) {
    console.log("calendar" , calendar);
    html.push('<div class="col-md-2"><div class="sidebar-calendars-item"><label>' +
      '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
      '<span style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';"></span>' +
      '<span>' + calendar.name + '</span>' +
      '</label></div></div>'
    );
  });
  calendarList.innerHTML = html.join('\n');
})();

(function() {
    var calendar;
    var id = 8;

    calendar = new CalendarInfo();
    id += 1;
    console.log("id:",id);
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


$(document).ready(function () {

  // calendar sidebar scrollbar
  if ($('.sidebar').length > 0) {
    var sidebar = new PerfectScrollbar(".sidebar", {
      wheelPropagation: false
    });
  }
  // sidebar menu toggle
  $(".sidebar-toggle-btn").on("click", function () {
    $(".sidebar").toggleClass("show");
    $(".app-content-overlay").toggleClass("show");
  })
  // on click Overlay hide sidebar and overlay
  $(".app-content-overlay, .sidebar-new-schedule-btn").on("click", function () {
    $(".sidebar").removeClass("show");
    $(".app-content-overlay").removeClass("show");
  });
})

$(window).on("resize", function () {
  // sidebar and overlay hide if screen resize
  if ($(window).width() < 991) {
    $(".sidebar").removeClass("show");
    $(".app-content-overlay").removeClass("show");
  }
})
