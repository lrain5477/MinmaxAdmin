"use strict";

/*****Ready function start*****/
$(document).ready(function() {


    /*--------------------------------------------
                page [holiday]日曆
      ---------------------------------------------*/
    var $holiday = $("#holiday");
    $holiday.each(function() {
        var currentYear = new Date().getFullYear();
        var currentMonth = new Date().getMonth();
        var currentDate = new Date().getDate();
        
        var today = new Date(currentYear, currentMonth, currentDate).getTime();
        function editEvent(event) {

            $('#event-modal input[name="event-index"]').val(event ? event.id : '');
            $('#event-modal input[name="event-name"]').val(event ? event.name : '');

            $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
            $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');

            $('#event-modal').modal();
        }

        function deleteEvent(event) {
            var event = {
                id: $('#event-modal input[name="event-index"]').val(),
                name: $('#event-modal input[name="event-name"]').val(),
                startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
                endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate')
            }

            var dataSource = $holiday.data('calendar').getDataSource();

            if (event.id) {
                for(var i in dataSource) {
                    if(dataSource[i].id == event.id) {
                        dataSource.splice(i, 1);
                        break;
                    }
                }
            }
            else {

                var startDate = event.startDate;
                var endDate = event.endDate;
                var loop = new Date(startDate);

                while (loop <= endDate) {
                    var currentDate = loop;
                    for (var i in dataSource) {
                        // console.log(dataSource[i].endDate, currentDate)
                        // console.log(dataSource[i].endDate.getTime(),currentDate.getTime())
                        // console.log(dataSource[i].endDate.getTime() <= currentDate.getTime())

                        if(dataSource[i].startDate.getTime() >= currentDate.getTime()
                            && dataSource[i].endDate.getTime() <= currentDate.getTime()) {
                            // console.log(dataSource[i].startDate)
                            dataSource.splice(i, 1);
                        }
                    }

                    var newDate = loop.setDate(loop.getDate() + 1);
                    loop = new Date(newDate);
                }
            }

            $holiday.data('calendar').setDataSource(dataSource);
        }

        function saveEvent() {
            var event = {
                id: $('#event-modal input[name="event-index"]').val(),
                name: $('#event-modal input[name="event-name"]').val(),
                startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
                endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate')
            }

            var dataSource = $holiday.data('calendar').getDataSource();

            if(event.id) {
                for(var i in dataSource) {
                    if(dataSource[i].id == event.id) {
                        dataSource[i].name = event.name;
                        dataSource[i].startDate = event.startDate;
                        dataSource[i].endDate = event.endDate;
                    }
                }
            }
            else
            {
                var newId = 0;
                for(var i in dataSource) {
                    if(dataSource[i].id > newId) {
                        newId = dataSource[i].id;
                    }
                }

                newId++;
                event.id = newId;

                dataSource.push(event);
            }

            $holiday.data('calendar').setDataSource(dataSource);
            $('#event-modal').modal('hide');
        }

        $(function() {
            var currentYear = new Date().getFullYear();

            $holiday.calendar({
                enableContextMenu: true,
                enableRangeSelection: true,
                customDayRenderer: function(element, date) {
                    if(date.getTime() == today) {
                        $(element).css('color', 'white');
                        $(element).css('font-weight', 'bold');
                        $(element).css('background-color', 'red');
                    }
                },
                language: 'tw',
                contextMenuItems:[
                    {
                        text: 'Update',
                        click: editEvent
                    },
                    {
                        text: 'Delete',
                        click: deleteEvent
                    }
                ],
                selectRange: function(e) {

                    editEvent({ startDate: e.startDate, endDate: e.endDate });

                },
                mouseOnDay: function(e) {
                    if(e.events.length > 0) {
                        var content = '';

                        for(var i in e.events) {
                            content += '<div class="event-tooltip-content">'
                                + '<div class="event-name" style="color:red">' + e.events[i].name + '</div>'
                                + '</div>';
                        }

                        $(e.element).popover({
                            trigger: 'manual',
                            container: 'body',
                            html:true,
                            content: content
                        });

                        $(e.element).popover('show');
                    }

                },
                mouseOutDay: function(e) {
                    if(e.events.length > 0) {
                        $(e.element).popover('hide');
                    }
                },
                dayContextMenu: function(e) {
                    $(e.element).popover('hide');
                },
                dataSource: [
                    {
                        id: 0,
                        name: 'Google I/O',
                        startDate: new Date(2018, 4, 28),
                        endDate: new Date(2018, 4, 29)
                    },
                    {
                        id: 1,
                        name: 'Microsoft Convergence',
                        startDate: new Date(currentYear, 2, 16),
                        endDate: new Date(currentYear, 2, 19)
                    },
                    {
                        id: 2,
                        name: 'Microsoft Build Developer Conference',
                        startDate: new Date(currentYear, 3, 29),
                        endDate: new Date(currentYear, 4, 1)
                    },
                    {
                        id: 3,
                        name: 'Apple Special Event',
                        startDate: new Date(currentYear, 8, 1),
                        endDate: new Date(currentYear, 8, 1)
                    },
                    {
                        id: 4,
                        name: 'Apple Keynote',
                        startDate: new Date(currentYear, 8, 9),
                        endDate: new Date(currentYear, 8, 9)
                    },
                    {
                        id: 5,
                        name: 'Chrome Developer Summit',
                        startDate: new Date(currentYear, 10, 17),
                        endDate: new Date(currentYear, 10, 18)
                    },
                    {
                        id: 6,
                        name: 'F8 2015',
                        startDate: new Date(currentYear, 2, 25),
                        endDate: new Date(currentYear, 2, 26)
                    },
                    {
                        id: 7,
                        name: 'Yahoo Mobile Developer Conference',
                        startDate: new Date(currentYear, 7, 25),
                        endDate: new Date(currentYear, 7, 26)
                    },
                    {
                        id: 8,
                        name: 'Android Developer Conference',
                        startDate: new Date(currentYear, 11, 1),
                        endDate: new Date(currentYear, 11, 4)
                    },
                    {
                        id: 9,
                        name: 'LA Tech Summit',
                        startDate: new Date(currentYear, 10, 17),
                        endDate: new Date(currentYear, 10, 17)
                    }
                ]
            });

            $('#save-event').click(function() {

                saveEvent();

            });
            $('#delete-event').click(function() {

                deleteEvent();

            });
        });
    });
});