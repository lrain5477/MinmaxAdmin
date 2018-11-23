$(document).ready(function() {
  //fullcaleder
    $('#calendar').fullCalendar({
      themeSystem: 'bootstrap4',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      locale:'zh-tw',
      defaultDate: '2018-03-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      themeButtonIcons:{
        prev: 'btn btn-main',
        next: 'btn btn-main',
        prevYear: 'btn btn-main',
        nextYear: 'btn btn-main'
      },
      
      buttonText:{
        today:    '今日',
        month:    '月',
        week:     '週',
        day:      '天',
        list:     '清單'
      },
      buttonIcons:{
        prev: 'icon-chevron-small-left',
        next: 'icon-chevron-small-right',
      },
      events: [
        {
          id: 999,
          title: 'xx影片:5，xx影片:5(滿)',
          start: '2018-03-09T16:00:00',
          className:'border-danger bg-danger',
          url: '#',        
        },
        {
          id: 999,
          title: 'xx影片:5，xx影片:5',
          start: '2018-03-09T16:00:00',
          className:'border-info bg-info',
          url: '#',  
        },
        {
          id: 999,
          title: 'xx影片:5，xx影片:5',
          start: '2018-03-19T09:00:00',
          className:'border-info bg-info',
          url: '#',  
        }
      ],
    });

  });
