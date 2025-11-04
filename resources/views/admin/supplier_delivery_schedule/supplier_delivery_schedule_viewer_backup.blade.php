<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/@fullcalendar/core/main.css') }}">
<style type="text/css">
    .table-condensed,
    .datepicker-inline {
        width: 100%;
    }

    #calendar td h4 {
        font-size: .9rem;
        margin-bottom: 0
    }

    #calendar th {
        font-weight: normal;
    }

    .list-group-item {
        padding: .2rem
    }

    #calendar .card-header {
        padding: 0 .5rem !important;
        color: #0077c1 !important
    }

    #calendar .card-body {
        padding-top: 2px;
    }

    #calendar .card-body h5 {
        font-size: .75rem;
        margin-bottom: 0;
        font-weight: bold;
    }

    .border-bottom-blue {
        border-bottom: 1px solid #6CB2EB !important;
    }

    .border-bottom-danger {
        border-bottom: 2px solid #6CB2EB !important;
    }

    .border-top-danger {
        border-top: 2px solid #6CB2EB !important;
    }

    .datepicker td,
    .datepicker th {
        border: 1px solid #E3F3FD;
    }

    .datepicker-days .table-condensed thead tr:nth-child(2) {
        background-image: linear-gradient(#d3edfb, rgba(255, 255, 255, .5));
    }

    .block-day {
        background: #6CB2EB;
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
                <div class="col-sm-12 col-lg-5 col-xl-3">
                    <div class="card">
                        <div class="card-body p-1">
                            <div class="form-group">
                                <div class="datepicker datepicker-inline col-md-12"></div>
                                <input type="hidden" id="hdn_appointment_date" name="hdn_appointment_date">
                            </div>
                        </div>
                        <div class="card-header">Resources</div>
                        <div class="card-body p-1" style="max-height: 380px; overflow-y: auto;">
                            <ul class="list-group list-group-flush">
                                @if (!empty($doctor_list))
                                    @foreach ($doctor_list as $doctor)
                                        <li class="list-group-item">
                                            <i class="fa fa-user-tie"></i>
                                            {{ $doctor->full_name }}
                                            @php
                                                if (isset($appointment_arr[$doctor->person_no_pk]) && $appointment_arr[$doctor->person_no_pk] == 0) {
                                                    $badge_class = 'badge-secondary';
                                                } else {
                                                    $badge_class = 'badge-primary';
                                                }

                                            @endphp
                                            <span
                                                class="badge {{ $badge_class }} badge-pill float-right">{{ isset($appointment_arr[$doctor->person_no_pk]) ? $appointment_arr[$doctor->person_no_pk] : '' }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-7 col-xl-9" id="schedule-calendar">
                    @include('admin.supplier_delivery_schedule.supplier_delivery_schedule_calender')
                </div>
            </div>
        </div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/bootstrap/js/dist/util.js') }}"></script>
<script src="{{ asset('node_modules/bootstrap/js/dist/tooltip.js') }}"></script>
<script src="{{ asset('node_modules/bootstrap/js/dist/popover.js') }}"></script>

<script>
    function formatDate(d) {
        var day = String(d.getDate())
        if (day.length == 1)
            day = '0' + day
        var month = String((d.getMonth() + 1))
        if (month.length == 1)
            month = '0' + month
        return day + "-" + month + "-" + d.getFullYear()
    }

    function scheduleCalendar(schedule_date) {
        var action = '{{ route('get-service-schedule-calendar', ':id') }}';
        action = action.replace(':id', schedule_date);

        $.ajax({
            url: action,
            type: "get",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#schedule-calendar').html(data);
            },
            complete: function(data) {
                $.unblockUI();
            }

        });
    }

    var schedulerEngine = {
        createConsultation: function(thisElement) {
            if ($("#billing_table-body tr").length == 0) {
                alert("No Service Item Found");
                return;
            }

            var response_action = $(thisElement).attr("data-response-action");
            var schedule_date = $("#hdn_schedule_date").val();

            btnSaveUpdate($(thisElement), 'afterSaveModal', response_action, 'common-modal',
                'Service Consultation Invoice', scheduleCalendar, schedule_date);
        },
        calculatePayment: function(thisElement) {
            var hdn_item_total = $("#hdn_item_total").val() * 1;
            var total_payment = $(thisElement).val() * 1;
            if (total_payment > 0) {
                $("#total_due").val((hdn_item_total - total_payment).toFixed(2));
            }
        }
    };

    $(function() {
        $(".datepicker").datepicker({
            weekStart: 6,
            daysOfWeekDisabled: [5],
            startDate: "1d",
            todayHighlight: true
        }).on('changeDate', function(ev) {
            scheduleCalendar(formatDate(ev.date));
        });

        $('.pat-sc-details').popover({
            "html": true,
            trigger: 'focus',
            "content": function() {
                var div_id = "pat-sc-id-" + $.now();
                return details_in_popup($(this).attr('href'), div_id);
            }
        });

        function details_in_popup(link, div_id) {
            $.ajax({
                url: link,
                success: function(response) {
                    $('#' + div_id).html(response);
                }
            });
            return '<div id="' + div_id + '"><i class="fas fa-stroopwafel fa-spin text-primary"></i></div>';
        }


    });
</script>
