@extends('layouts.app')

@section('css')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="{{ asset('resources/plugin/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plugin/fullcalendar/fullcalendar.print.css') }}" media="print">
    <style>
        :root {
           /* --red: #ef233c;
            --darkred: #c00424;
            --platinum: #e5e5e5;
            --black: #2b2d42;
            --blue: #3379A1;*/
            --green: #59AB91;
            --white: #fff;
            --thumb: #edf2f4;
        }
        .scroll-container {
            display: flex;
            list-style: none;
            overflow-x: scroll;
            scroll-snap-type: x mandatory;
        }
        .scroll-container::-webkit-scrollbar {
            height: 12px;
        }
        .scroll-container::-webkit-scrollbar-thumb,
        .scroll-container::-webkit-scrollbar-track {
            border-radius: 92px;
        }
        .scroll-container::-webkit-scrollbar-thumb {
            background: var(--green);
        }
        .scroll-container::-webkit-scrollbar-track {
            background: var(--thumb);
        }
        .scroll-item {
            display: flex;
            flex-direction: column;
            flex: 0 0 100%;
            background: var(--white);
            border-radius: 4px;
            scroll-snap-align: start;
            transition: all 0.2s;
        }
        .scroll-item .widget-user {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 15%);
        }
        .scroll-item:not(:last-child) {
            margin-right: 10px;
        }
        .scroll-item .widget-user-header {
            background: var(--green);
            color: white;
        }
        .widget-user-header .widget-user-desc {
            max-width: 65%;
            font-size: 14px;
        }
        .widget-user-header .widget-user-username {
            font-size: 21px;
        }
        .widget-user .widget-user-image {
            position: absolute;
            top: 65px;
            left: 75%;
            margin-left: -45px;
        }
        .with-badge {
            position: relative;
            display: inline-block;
        }
        .with-badge::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50px;
            height: 50px;
            background: linear-gradient(to bottom left, transparent 30%, #ef233c 4%, #ef233c 50.5%, transparent 50.5%);
            transform-origin: bottom right;
            z-index: 1;
        }
        .with-badge::after {
            content: 'Government';
            position: absolute;
            top: 9%;
            right: 5%;
            transform: translate(50%, -50%) rotate(45deg);
            color: white;
            font-size: 8px;
            font-weight: bold;
            z-index: 2;
        }

        .widget-user-image {
            overflow: hidden;
        }
        .widget-user-image img {
            transition: transform .3s ease-in-out;
        }
        .scroll-item:hover .widget-user-image img {
            /*transform: scale(.9);*/
            width: 100px;
        }
        .available-slot-event {
            cursor: pointer;
        }
        /*===============================================================*/



        /*===============================================================*/
        @media (min-width: 500px) {
            .scroll-item {
                flex-basis: calc(50% - 10px);
            }

            .scroll-item:not(:last-child) {
                margin-right: 20px;
            }
        }
        @media (min-width: 700px) {
            .scroll-item {
                flex-basis: calc(calc(100% / 3) - 20px);
            }

            .scroll-item:not(:last-child) {
                margin-right: 30px;
            }
        }
        @media (min-width: 1100px) {
            .scroll-item {
                flex-basis: calc(25% - 30px);
            }

            .scroll-item:not(:last-child) {
                margin-right: 1px;
            }
        }
        .selected-date {
            background-color: #ffc73d; /* Change this color to the desired highlight color */
            /*color: #0000CC; !* Adjust text color if necessary *!*/
        }

        /* Define borders for FullCalendar cells */
        .fc-day .fc-day-top {
            border: 1px solid #ddd; !important;/* Add borders around each day */
        }

        .available-slot-event {
            /* Custom styling for events */

        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="jim-content">
                <h3 class="page-header">Select Facility</h3>
                <div class="row">
                    <div class="scroll-container">
                        @if(isset($appointment_sched))
                            @foreach($appointment_sched as $row)
                                <div class="col-md-4 scroll-item">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user with-badge">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header">
                                            <h3 class="widget-user-username">
                                                <?php
                                                $facility_name = \App\Facility::find($row->facility_id)->name;
                                                echo $facility_name;
                                                ?></h3>
                                            <h5 class="widget-user-desc">
                                                <?php
                                                $address = \App\Facility::find($row->facility_id)->address;
                                                echo $address;
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="widget-user-image">
                                            <img src="<?php echo e(asset('resources/img/video/doh-logo.png')); ?>" class="img-circle" alt="User Avatar"/>
                                        </div>
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        {{--<h5 class="description-header">3,200</h5>--}}
                                                        <h5 class="description-header"><?php
                                                            $slot = \App\AppointmentSchedule::where('facility_id', $row->facility_id)->get();
                                                            if($slot){
                                                                $count =0;
                                                                foreach ($slot as $ind){
                                                                    $count = $count + $ind->slot;
                                                                }
                                                            }
                                                            echo $count;?></h5>
                                                        <span class="description-text">Slot</span>
                                                    </div><!-- /.description-block -->
                                                </div><!-- /.col -->
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">13,000</h5>
                                                        <span class="description-text">Available</span>
                                                    </div><!-- /.description-block -->
                                                </div><!-- /.col -->
                                                <div class="col-sm-4">
                                                    <div class="description-block">
                                                    <button class="btn btn-block btn-success btn-select" onclick="calendar_display({{$row->facility_id}})" id="selected_data" name="selected_data"> Select</button>
                                                    </div><!-- /.description-block -->
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </div>
                                    </div><!-- /.widget-user -->
                                </div><!-- /.col -->
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="jim-content">
                        <h3 class="page-header">Appointment Calendar</h3>
                        {{--------------------------------------------------------}}
                        <div class="calendar-container">
                            <section class="content">
                                <div class="row">
                                    <div class="box box-primary">
                                        <div class="box-body no-padding">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div> <!-- calendar container -->
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="jim-content">
                        <h3 class="page-header">Time Slot</h3>
                        {{--------------------------------------------------------}}
                        <div class="calendar-container">
                            <section class="content">
                                <div class="row">
                                    <div class="box box-primary">
                                        <div class="box-body no-padding">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">Legends</h4>
                                            </div>
                                            <div id="external-events">
                                                <div class="external-event bg-green">Available Present & future Date</div>
                                                <div class="external-event" style="background-color: #6C757D; color: #ffff">Disabled Previous Date</div>
                                            </div>
                                            <div class="box box-solid">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Select Time of Appointment</h3>
                                                    <div id="date-selected"></div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="appointment-time-list">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div> <!-- calendar container -->
                    </div>
                </div>

            </div>
        </div> 
    </div>
@endsection

@section('js')
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('resources/plugin/fullcalendar/fullcalendar.min.js') }}"></script>
    <script>
        var appointedDates = [];

        /*-----------------------------------------------------------------*/
        function calendar_display(appointmentId) {
//            refreshCalendar();
            $('#calendar').val(appointmentId);
            console.log('appointedId', appointmentId);

            $('#calendar').fullCalendar({
               dayRender: function (date, cell) {
//
                   var formattedDate = moment(date).format('YYYY-MM-DD');
                   var url = "{{ route('get-Facility-Details', ':id') }}";
                   url = url.replace(':id', appointmentId);

                   var all_dates =[];
                   $.get(url, function (data) {
                       console.log('my data', data);
                       for (var i = 0; i < data.facility_data.length; i++) {
                           var date = data.facility_data[i].appointed_date;

                           all_dates.push(date);
                       }

                       console.log('new ',all_dates);
                       console.log('new_length', all_dates.length);

                       console.log('apilido',formattedDate);

                       var found = all_dates.some(function(dateItem) {
                           return dateItem === formattedDate;
                       });

                       if (found) {
                           cell.css("background-color", "green");
                       } else {
                           cell.css("background-color", ""); // Reset background color to default
                       }

                   }).fail(function (jqXHR, textStatus, errorThrown) {
                       console.log("AJAX Error: " + errorThrown);
                   });
                },
                dayClick: function (date, info, jsEvent, view) {
                    // Handle the click event here
//                        alert('You clicked on ' + calEvent.title);
                    var selectedDate = date.format('YYYY-MM-DD');

                    // Make an AJAX request to fetch available time slots
                    $.ajax({
                        type: 'GET',
                        url: '{{ route("get-available-time-slots") }}',
                        data: {
                            selected_date: selectedDate
//                                facility_id: facility_id
                        },
                        success: function (response) {
                            // Update the radio button list with available time slots
                            if(response.time_slots) {
                                updateAvailableTimeSlots(response.time_slots);
                            }
                        },
                        error: function (error) {
                            console.error('Error fetching available time slots:', error);
                        }
                    });
//                        applyCustomStyleToCell(info.date, info.dayEl, selectedDate);
                }
            });
            refreshCalendar();

            var url = "{{ route('get-Facility-Details', ':id') }}";
            url = url.replace(':id', appointmentId);


            $.get(url, function (data) {
                console.log('my data', data);
                var appointedDates =[];
                /*for (var i = 0; i < data.length; i++) {
                    var date = data[i].appointed_date;
                    if (!appointedDates.includes(date)) {
                        appointedDates.push(date);
                    }
                }*/

                for (var i = 0; i < data.facility_data.length; i++) {
                    var date = data.facility_data[i].appointed_date;
//                    var time = data.facility_data[i].appointed_time;

                        appointedDates.push(date);
                }

                console.log('checking', appointedDates);
                $('#calendar').fullCalendar('render'); // Render the updated data
                doSomethingWithAppointedDates();

            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + errorThrown);
            });

//            function getAllDatesForCurrentMonth() {
//                const today = new Date();
//                const year = today.getFullYear();
//                const month = today.getMonth();
//
//                const allDates = [];
//                const startDate = new Date(year, month, 1);
//                const endDate = new Date(year, month + 1, 0); // Get the last day of the month
//
//                for (let date = startDate; date <= endDate; date.setDate(date.getDate() + 1)) {
//                     const formattedDate = formatDate(date);
//                     allDates.push(formattedDate);
////                    allDates.push(new Date(date)); // Store a copy of the date object
//                }
//                return allDates;
//            }
//
//            function formatDate(date) {
//                const year = date.getFullYear();
//                const month = String(date.getMonth() + 1).padStart(2, '0'); // Add leading zero if needed
//                const day = String(date.getDate()).padStart(2, '0'); // Add leading zero if needed
//
//                return `${year}-${month}-${day}`;
//            }

            var calendarEvents = [];

            function doSomethingWithAppointedDates() {
                console.log("Value of the first appointment globally:", appointedDates[0]);

                calendarEvents = [];

//                appointedDates.forEach(function (date) {
//                    calendarEvents.push({
////                        title: 'Available Slot', // You can customize the title if needed
//                        start: date,
//                        allDay: true, //
//                        backgroundColor: "green", // Success (green)
////                        rendering: 'background',
////                        border: '#000000',
////                        className: 'available-slot-event' // Add the class here
//                    });
//
////                    calendarEvents.push(event);
//                });
                refreshCalendar();
            }

            function refreshCalendar() {
                $('#calendar').fullCalendar('removeEvents'); // Clear previous events
                $('#calendar').fullCalendar('addEventSource', calendarEvents); // Add updated events
                $('#calendar').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    buttonText: {
                        today: 'today',
                        month: 'month',
                        week: 'week',
                        day: 'day'
                    },
                    events: calendarEvents,
//                    rendering: 'background',
                    eventDisplay: 'block',
                    editable: false,
                    droppable: false,
                    selectable: false
                })
            }
            refreshCalendar();

            function updateAvailableTimeSlots(timeSlots) {
                var timeListDiv = $('#appointment-time-list');

                // Clear existing content
                timeListDiv.empty();

                // Add radio buttons for each available time slot
                for (var i = 0; i < timeSlots.length; i++) {
                    var timeSlot = timeSlots[i];
                    var radioButton = $('<div class="form-check">' +
                        '<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault' + (i + 1) + '" value="' + timeSlot.appointed_time + '">' +
                        '<label class="form-check-label" for="flexRadioDefault' + (i + 1) + '">' + timeSlot.appointedTime_to + '</label>' +
                        '</div>');

                    timeListDiv.append(radioButton);
                }

                // Call the function to update the appointment time list
                updateAppointmentTimeList(timeSlots);
            }

        }

        function updateAppointmentTimeList(timeSlots) {
            // Assuming you have an element with id 'appointment-time-list'
            var appointmentTimeList = $('#appointment-time-list');

            // Clear existing content
            appointmentTimeList.empty();

            // Add radio buttons for each available time slot
            for (var i = 0; i < timeSlots.length; i++) {
                var timeSlot = timeSlots[i];
                var radioButton =  $('<div class="time-slot">' +
                    '<span class="time-label" type="radio">' + timeSlot.appointed_time + '</span>' +
                    '<span class="time-label" type="radio">' + timeSlot.appointedTime_to + '</span>' +
                    '</div>');

                radioButton.css({
//                   'border': '2px solid #000', // Set border properties as needed
                    'padding': '15px', // Optional: Add padding around the content
                    'margin-bottom': '15px', // Optional: Add margin between slots
                    'width': '200px', // Set the width of each time slot
                    'height': '25px', // Set the height of each time slot
                    'display': 'flex', // Use flexbox to align content
                    'justify-content': 'center', // Center the content horizontally
                    'align-items': 'center' // Center the content vertically
                });

                radioButton.find('.form-check-input').css({
                    'margin-right': '10px' // Adjust the spacing between the radio button and text
                });

                radioButton.find('.time-label').css({
                    'font-size': '18px', // Set the font size for the time labels
                    'padding': '15px', // Optional: Add padding around the content
                    'border': '1px #000'
                });

                appointmentTimeList.append(radioButton);
            }
        }

        /*----------------------------------------------------------------*/
        $(document).ready(function() {
            // Apply default background when the page loads
            $(".scroll-item .widget-user-header").css({
                "background-color": "#59AB91",
                "color": "white"
            });

            $(".btn-select").on("click", function() {
                console.log("Button is clicked!..")
                // Remove the "selected" class from all buttons
                $(".scroll-item").removeClass("selected");
                $(".btn-select").text("Select");
                $(".scroll-item .widget-user-header").css({
                    "background-color": "#59AB91",
                    "color": "white"
                });

                // Add the "selected" class to the clicked button
                var $parentItem = $(this).closest(".scroll-item");
                $parentItem.addClass("selected");

                // Change the text of the button based on its current state
                var buttonText = $parentItem.hasClass("selected") ? "Selected" : "Select";
                $(this).text(buttonText);

                // Apply the background color to .widget-user-header if selected
                if ($parentItem.hasClass("selected")) {
                    $parentItem.find(".widget-user-header").css({
                        "background-color": "#008E4D",
                        "color": "white"
                    });
                }
            });
        });
        /*-----------------------------------------------------------------*/
    </script>
@endsection

