<table class="table table-striped table-bordered table-hover mb-0 border-top border-right data-table data_search doc_schedule">
    <thead>
        <th>SL</th>
        <th>Photo</th>
        <th>Doctor</th>
        <th>Contact</th>
        <th>Specialization</th>
        <th>Date</th>
        <th>Time</th>
        {{-- <th>AQ</th>
        <th>Action</th> --}}
    </thead>
    <tbody>
        @if(isset($schedules_doctors))
        @foreach($schedules_doctors as $schedule_doctor)
        <tr class="text-center">
            <td class="border-0">{{ $loop->iteration }}</td>
            <td class="border-0">
                @if ($schedule_doctor->photo_name)
                    <img alt="No Image" src="{{ asset('images/uploads/doctor_images/thumb/'. $schedule_doctor->photo_name) }}" class="rounded float-center" width="35">
                @elseif (!isset($schedule_doctor->photo_name) AND $schedule_doctor->gender_txt == 'Male')
                    <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded float-center" width="35">
                @elseif (!isset($schedule_doctor->photo_name) AND $schedule_doctor->gender_txt == 'Female')
                    <img src="{{asset ('images/female-doc.jpg')}}" alt="doctor image" class="rounded float-center" width="35">
                @else
                    <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded float-center" width="35">
                @endif
            </td>
            <td class="border-0">
                <div class="text-left">
                    <div class="font-medium">{{ $schedule_doctor->full_name ?? "N/A" }}</div>
                    <div class="text-gray-600 text-xs"><span>{{ $schedule_doctor->age }}years</span>, <span>{{ $schedule_doctor->gender_txt }}</span></div>
                </div>
            </td>
            <td class="border-0">
                <div class="">
                    <div class="font-medium"> {{ $schedule_doctor->phone_mobile ? $schedule_doctor->phone_mobile : 'N/A' }} </div>
                </div>
            </td>
            <td class="border-0">
                <div>
                    <div class="font-medium">{{ $schedule_doctor->specialization }}</div>
                </div>
            </td>
            <td class="border-0">
                <div>
                    <div class="font-medium">{{ date("d-M-Y",strtotime($schedule_doctor->schedule_dt)) }}</div>
                </div>
            </td>
            <td class="border-0">
                <div>
                    <div class="font-medium">
                        {{ date("h:i A",strtotime($schedule_doctor->start_time)) }} - {{ date("h:i A",strtotime($schedule_doctor->end_time)) }}
                    </div>
                </div>
            </td>
            {{-- <td class="border-0">
                <div>
                    <div class="font-medium">{{ $schedule_doctor->total_patient }}</div>
                </div>
            </td>
            <td class="border-0">
                <div class="text-theme-6">
                    <button type="button" class="btn btn-sm bg-navy">Call</button>
                    <button type="button" class="btn btn-sm bg-blue">SMS</button>
                    <button type="button" class="btn btn-sm bg-brown">Email</button>
                </div>
            </td> --}}
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
