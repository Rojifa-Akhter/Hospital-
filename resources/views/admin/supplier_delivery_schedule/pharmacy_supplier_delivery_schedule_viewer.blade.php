<link rel="stylesheet" href="{{ asset('fullcalendar/fullcalendar.min.css')}}" />

<script src="{{asset('fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('fullcalendar/fullcalendar.min.js')}}"></script>
{{-- src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}" --}}
<style>
    #calendar {
        width: 1050px;
        margin-left: 5px;
        background: white;
        /* #cdf3cd */
        text-align: center;
    }

    .response {
        height: 30px;
    }

    .success {
        background: #cdf3cd;
        padding: 10px 60px;
        border: #c3e6c3 1px solid;
        display: inline-block;
    }

    .fc-unthemed td.fc-today {
        background: #d6d5d2;
    }

    .fc-title {
        color: white
    }

    .fc-day-grid-event>.fc-content {
        white-space: normal;
    }

    .fc-event {
        /* force events to be one-line tall */
        white-space: nowrap !important;
        overflow: hidden;
    }

</style>


<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Supplier Schedule Viewer</h5>
                <small>Pharmacy / Supplier Delivery Schedule Calendar</small>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-sm-12 col-lg-7 col-xl-9" id="schedule-calendar">
                    <div class="response"></div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: "{{ route('pharmacy.show_supplier_schedule_viewer') }}",
            displayEventTime: false,
            eventRender: function(event, element, view) {
                //console.log("evemt date ",event.start);
                if (event.allDay === 'true') {
                    event.start = $.fullCalendar.formatDate(evemt.start, "Y-MM-DD HH:mm:ss");

                } else {
                    event.allDay = false;
                }

                calendar.fullCalendar('renderEvent', {
                        title: event.start,
                        allDay: event.allDay
                    },
                    true
                );
            },
            selectable: false,
            selectHelper: true,
            select: function(start, end, allDay) {
                var title = prompt('Event Title:');

                //if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: 'add-event.php',
                    data: 'title=' + title + '&start=' + start + '&end=' + end,
                    type: "POST",
                    success: function(data) {
                        displayMessage("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent', {
                        title: title,
                        start: start,
                        end: end,
                        allDay: allDay
                    },
                    true
                );
                //}
                calendar.fullCalendar('unselect');
            },

            editable: false,
            eventDrop: function(event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                $.ajax({
                    url: 'edit-event.php',
                    data: 'title=' + event.title + '&start=' + start + '&end=' + end +
                        '&id=' + event.id,
                    type: "POST",
                    success: function(response) {
                        displayMessage("Updated Successfully");
                    }
                });
            },
            eventClick: function(event) {
                //var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: "delete-event.php",
                        data: "&id=" + event.id,
                        success: function(response) {
                            if (parseInt(response) > 0) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                displayMessage("Deleted Successfully");
                            }
                        }
                    });
                }
            }

        });
    });

    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>
