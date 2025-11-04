 <link href="{{ asset('fullcalendar/core/main.css') }}" rel='stylesheet' />
 <link href="{{ asset('fullcalendar/daygrid/main.css') }}" rel='stylesheet' />
 <link href="{{ asset('fullcalendar/timegrid/main.css') }}" rel='stylesheet' />

 <section id="full_appointment">
     <div class="container-fluid">
         <div class="row">
             <div class="col-sm-12 col-lg-5 col-xl-4">
                 <div class="card">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12 ">
                                 <div id='day_calendar'></div>

                                 <form action="">
                                     <div class="form-group">
                                         <label for="appointment_date">Appontment Date</label>
                                         <input type="text" class="form-control" id="appointment_date" name="appointment_date" value="" readonly placeholder="Pick a date for appointment">
                                     </div>

                                     <div class="form-group">
                                         <label for="select_speciality">Speciality</label>
                                         <select class="form-control" id="select_speciality" name="select_speciality">
                                             <option>Select speciality</option>
                                             <option>speciality-1</option>
                                             <option>speciality-2</option>
                                             <option>speciality-3</option>
                                         </select>
                                     </div>

                                     <div class="form-group">
                                         <label for="select_doctor">Doctor</label>
                                         <select class="form-control" id="select_doctor" name="select_doctor">
                                             <option>Select Doctor</option>
                                             <option>Doctor-1</option>
                                             <option>Doctor-2</option>
                                             <option>Doctor-3</option>
                                         </select>
                                     </div>

                                     <button type="button" class="btn btn-sm btn-success btn-block mt-3 open-modal" data-action="{{ route('appointments.index') }}" data-title="Create New Appointment"> Appointment </button>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-sm-12 col-lg-7 col-xl-8">
                 <div class="card">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12">
                                 <div id='calendar'></div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </div>

     </div>
 </section>

 <script type="application/javascript" src="{{ asset('fullcalendar/core/main.js') }}"></script>
 <script type="application/javascript" src="{{ asset('fullcalendar/daygrid/main.js') }}"></script>
 <script type="application/javascript" src="{{ asset('fullcalendar/interaction/main.js') }}"></script>
 <script type="application/javascript" src="{{ asset('fullcalendar/timegrid/main.js') }}"></script>

 <script>
     $(function() {
         var calendarEl = document.getElementById('calendar');

         var calendar = new FullCalendar.Calendar(calendarEl, {
             plugins: ['timeGrid'],
             timeZone: 'UTC',
             defaultView: 'timeGridDay',
             header: {
                 left: 'prev,next today',
                 center: 'title',
                 right: 'timeGridWeek,timeGridDay'
             },
             events: 'https://fullcalendar.io/demo-events.json'
         });

         calendar.render();
     });

     $(function() {
         var calendarE2 = document.getElementById('day_calendar');

         var calendar2 = new FullCalendar.Calendar(calendarE2, {
             plugins: ['dayGrid'],
             defaultView: 'dayGridMonth',
             selectable: true,
             aspectRatio: 1.8,
             height: 250,
             contentHeight: 250,
         });

         calendar2.render();
     });
 </script>