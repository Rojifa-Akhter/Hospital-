<div class="card">
    <div class="card-header"><h5>Daily Patient List</h5></div>
    <div class="card-body">
        <div class="mt-2" id="financial-list">
            <div class="col-md-12 table-responsive">
                <table class="table data-table table-striped table-bordered table-hover" id="data-table">
                    <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center w-10" scope="col" >SL</th>
                        <th class="text-left w-20" scope="col" >Patient Name</th>
                        <th class="text-center" scope="col" >Age</th>
                        <th class="text-center" scope="col" >Gender</th>
                        <th class="text-center" scope="col" >CC</th>

                    </tr>

                    </thead>
                    <tbody>
                    @if(!empty($value))
                        @foreach($value as $row)

                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-left">{{ $row->patient_name}}</td>
                                <td class="text-center"> {{ $row->age}}
                                </td>
                                <td class="text-center"> {{ $row->gender_txt}}
                                </td>
                                <td class="text-center"> {{ $row->chif_complain}}
                                </td>
                            </tr>
                        @endforeach @endif
                    </tbody>
                </table>
                <form method="post" action="{{ route("reports.doctor-wise-daily-Appointment-print") }}" target="_blank">
                    @csrf
                    <input type="hidden" name="type" value="{{$type}}">
                    <input type="hidden" name="appointment_data" value="{{$appointment_data}}">
                    <button class="btn btn-primary" type="submit"> Export Pdf </button>
                </form>
            </div>
        </div>
    </div>
</div>
