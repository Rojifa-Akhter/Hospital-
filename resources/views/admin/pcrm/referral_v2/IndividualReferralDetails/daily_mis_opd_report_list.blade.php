<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='7' class='text-center'> <strong> OPD</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">SHIFT</th>
            <th class="text-center">TIME</th> --}}
            <th class="text-center">New Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Follow Up/Old Patients</th>
            <th class="text-center">Total Patients</th>
        </tr>
    </thead>
    @if (!empty($doctorPerformanceSummary))
    <tbody>
        @php
        $total_new_patient = 0;
        $total_free_patient = 0;
        $total_followup_patient = 0;
        $total_number_of_patient = 0;
        $total_new_patient2 = 0;
        $total_free_patient2 = 0;
        $total_followup_patient2 = 0;
        $total_number_of_patient2 = 0;

        @endphp
        @foreach ($doctorPerformanceSummary as $data)
        @php

        // if( $data->patient_new_paid >= 0 && $data->patient_new_paid < 2){
            $total_new_patient += $data->patient_new_paid;
        // }else{
        //     $total_new_patient2 += $data->patient_new_paid;
        // }

        // if(  $data->patient_free >= 0 &&  $data->patient_free < 2){
            $total_free_patient += $data->patient_free;
        // }else{
        //     $total_free_patient2 += $data->patient_free;
        // }

        // if( $data->patient_followup_free >= 0 && $data->patient_followup_free < 2){
            $total_followup_patient += $data->patient_followup_free;
        // }else{
        //     $total_followup_patient2 += $data->patient_followup_free;
        // }
        // if( $data->total_appointment >= 0 && $data->total_appointment < 2){
            $total_number_of_patient += $data->total_appointment;
        // }else{
        //     $total_number_of_patient2 += $data->total_appointment;
        // }
        @endphp
        @endforeach
        <tr>
            <td class="text-center">1</td>
            {{-- <td class="text-center">Morning</td>
            <td class="text-center">7:30 AM - 2:30 PM</td> --}}
            <td class="text-center">{{ $total_new_patient}}</td>
            <td class="text-center">{{ $total_free_patient}}</td>
            <td class="text-center">{{ $total_followup_patient}}</td>
            <td class="text-center">{{ $total_number_of_patient}}</td>

        </tr>
        {{--<tr>
            <td class="text-center">2</td>
             <td class="text-center">Evening</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_new_patient2}}</td>
            <td class="text-center">{{ $total_free_patient2}}</td>
            <td class="text-center">{{ $total_followup_patient2}}</td>
            <td class="text-center">{{ $total_number_of_patient2}}</td>

        </tr>--}}

    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" > <strong> Total = </strong> </td>
            {{-- <td class="text-right" colspan="3"> <strong> Total = </strong> </td> --}}
            <td class="text-center"> <strong> {{ $total_new_patient +  $total_new_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient +  $total_free_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient +  $total_followup_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient +  $total_number_of_patient2}} </strong></td>
        </tr>
    </tfoot>
    @endif

</table>
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='7' class='text-center'> <strong>EMERGENCY OPD</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">SHIFT</th>
            <th class="text-center">TIME</th> --}}
            <th class="text-center">New Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Follow Up/Old Patients</th>
            <th class="text-center">Total Patients</th>
        </tr>
    </thead>
    @if (!empty($doctorPerformanceSummaryEmr))
    <tbody>
        @php
        $total_new_patient = 0;
        $total_free_patient = 0;
        $total_followup_patient = 0;
        $total_number_of_patient = 0;
        $total_new_patient2 = 0;
        $total_free_patient2 = 0;
        $total_followup_patient2 = 0;
        $total_number_of_patient2 = 0;
        $total_new_patient3 = 0;
        $total_free_patient3 = 0;
        $total_followup_patient3 = 0;
        $total_number_of_patient3 = 0;

        @endphp
        @foreach ($doctorPerformanceSummaryEmr as $data)
        @php

        // if( $data->patient_new_paid >= 0 && $data->patient_new_paid < 2){
            $total_new_patient += $data->patient_new_paid;
        // }elseif($data->patient_new_paid >= 2  && $data->patient_new_paid < 50){
        //     $total_new_patient2 += $data->patient_new_paid;
        // }elseif($data->patient_new_paid >= 50){
        //     $total_new_patient2 += $data->patient_new_paid;
        // }

        // if(  $data->patient_free >= 0 &&  $data->patient_free < 2){
            $total_free_patient += $data->patient_free;
        // }elseif($data->patient_free >= 2  && $data->patient_free < 50){
        //     $total_free_patient2 += $data->patient_free;
        // }elseif($data->patient_free >= 50){
        //     $total_free_patient3 += $data->patient_free;
        // }

        // if( $data->patient_followup_free >= 0 && $data->patient_followup_free < 2){
            $total_followup_patient += $data->patient_followup_free;
        // }elseif($data->patient_followup_free >= 2  && $data->patient_followup_free < 50){
        //     $total_followup_patient2 += $data->patient_followup_free;
        // }elseif($data->patient_followup_free >= 50){
        //     $total_followup_patient3 += $data->patient_followup_free;
        // }
        // if( $data->total_appointment >= 0 && $data->total_appointment < 2){
            $total_number_of_patient += $data->total_appointment;
        // }elseif($data->total_appointment >= 2  && $data->total_appointment < 50){
        //     $total_number_of_patient2 += $data->total_appointment;
        // }elseif($data->total_appointment >= 50){
        //     $total_number_of_patient3 += $data->total_appointment;
        // }
        @endphp
        @endforeach
        <tr>
            <td class="text-center">1</td>
            {{-- <td class="text-center">Morning</td>
            <td class="text-center">7:30 AM - 2:30 PM</td> --}}
            <td class="text-center">{{ $total_new_patient}}</td>
            <td class="text-center">{{ $total_free_patient}}</td>
            <td class="text-center">{{ $total_followup_patient}}</td>
            <td class="text-center">{{ $total_number_of_patient}}</td>

        </tr>
       {{-- <tr>
            <td class="text-center">2</td>
             <td class="text-center">Evening</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_new_patient2}}</td>
            <td class="text-center">{{ $total_free_patient2}}</td>
            <td class="text-center">{{ $total_followup_patient2}}</td>
            <td class="text-center">{{ $total_number_of_patient2}}</td>

        </tr>--}}
       {{--  <tr>
            <td class="text-center">3</td>
            <td class="text-center">Night</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_new_patient3}}</td>
            <td class="text-center">{{ $total_free_patient3}}</td>
            <td class="text-center">{{ $total_followup_patient3}}</td>
            <td class="text-center">{{ $total_number_of_patient3}}</td>

        </tr> --}}

    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" > <strong> Total = </strong> </td>
            {{-- <td class="text-right" colspan="3"> <strong> Total = </strong> </td> --}}
            {{-- <td class="text-center"> <strong> {{ $total_new_patient +  $total_new_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient +  $total_free_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient +  $total_followup_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient +  $total_number_of_patient2}} </strong></td> --}}

            <td class="text-center"> <strong> {{ $total_new_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient}} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient }} </strong></td>
        </tr>
    </tfoot>
    @endif

</table>
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='7' class='text-center'> <strong> EMERGENCY PROCEDURES</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">SHIFT</th>
            <th class="text-center">TIME</th> --}}
            <th class="text-center">New Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Follow Up/Old Patients</th>
            <th class="text-center">Total Patients</th>
        </tr>
    </thead>
    @if (!empty($emergencyProcedure))
    <tbody>
        @php
        $total_new_patient = 0;
        $total_free_patient = 0;
        $total_followup_patient = 0;
        $total_number_of_patient = 0;
        $total_new_patient2 = 0;
        $total_free_patient2 = 0;
        $total_followup_patient2 = 0;
        $total_number_of_patient2 = 0;
        $total_new_patient3 = 0;
        $total_free_patient3 = 0;
        $total_followup_patient3 = 0;
        $total_number_of_patient3 = 0;

        @endphp
        @foreach ($emergencyProcedure as $data)
        @php
            $total_patient = $data->patient_cnt_newcons + $data->free_patient + $data->patient_followup;

        // if( $data->patient_cnt_newcons >= 0 && $data->patient_cnt_newcons < 2){
            $total_new_patient += $data->patient_cnt_newcons;
        // }elseif($data->patient_cnt_newcons >= 2  && $data->patient_cnt_newcons < 50){
        //     $total_new_patient2 += $data->patient_cnt_newcons;
        // }elseif($data->patient_cnt_newcons >= 50){
        //     $total_new_patient2 += $data->patient_cnt_newcons;
        // }

        // if(  $data->free_patient >= 0 &&  $data->free_patient < 2){
            $total_free_patient += $data->free_patient;
        // }elseif($data->free_patient >= 2  && $data->free_patient < 50){
        //     $total_free_patient2 += $data->free_patient;
        // }elseif($data->free_patient >= 50){
        //     $total_free_patient3 += $data->free_patient;
        // }

        // if( $data->patient_followup >= 0 && $data->patient_followup < 2){
            $total_followup_patient += $data->patient_followup;
        // }elseif($data->patient_followup >= 2  && $data->patient_followup < 50){
        //     $total_followup_patient2 += $data->patient_followup;
        // }elseif($data->patient_followup >= 50){
        //     $total_followup_patient3 += $data->patient_followup;
        // }



        // if( $total_patient >= 0 && $total_patient < 2){
            $total_number_of_patient += $total_patient;
        // }elseif($total_patient >= 2  && $total_patient < 50){
        //     $total_number_of_patient2 += $total_patient;
        // }elseif($total_patient >= 50){
        //     $total_number_of_patient3 += $total_patient;
        // }
        @endphp
        @endforeach
        <tr>
            <td class="text-center">1</td>
            {{-- <td class="text-center">Morning</td>
            <td class="text-center">7:30 AM - 2:30 PM</td> --}}
            <td class="text-center">{{ $total_new_patient}}</td>
            <td class="text-center">{{ $total_free_patient}}</td>
            <td class="text-center">{{ $total_followup_patient}}</td>
            <td class="text-center">{{ $total_number_of_patient}}</td>

        </tr>
        {{--
        <tr>
            <td class="text-center">2</td>
             <td class="text-center">Evening</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_new_patient2}}</td>
            <td class="text-center">{{ $total_free_patient2}}</td>
            <td class="text-center">{{ $total_followup_patient2}}</td>
            <td class="text-center">{{ $total_number_of_patient2}}</td>

        </tr>
        <tr>
            <td class="text-center">3</td>
            <td class="text-center">Night</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_new_patient3}}</td>
            <td class="text-center">{{ $total_free_patient3}}</td>
            <td class="text-center">{{ $total_followup_patient3}}</td>
            <td class="text-center">{{ $total_number_of_patient3}}</td>

        </tr>--}}

    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" > <strong> Total = </strong> </td>
            {{-- <td class="text-right" colspan="3"> <strong> Total = </strong> </td> --}}
            {{-- <td class="text-center"> <strong> {{ $total_new_patient +  $total_new_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient +  $total_free_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient +  $total_followup_patient2}} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient +  $total_number_of_patient2}} </strong></td> --}}


            <td class="text-center"> <strong> {{ $total_new_patient}} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient}} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient}} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient}} </strong></td>
        </tr>
    </tfoot>
    @endif

</table>
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='7' class='text-center'> <strong> DEPARTMENT WISE OPD PATIENT CLASSIFICATION</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">DEPARTMENT</th>
            <th class="text-center">New Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Follow Up/Old Patients</th>
            <th class="text-center">Total Patients</th>
            <th class="text-center">Remarks</th>
        </tr>
    </thead>
    @if (!empty($doctorPerformanceSummarydept))
    <tbody>
        @php
        $total_new_patient = 0;
        $total_free_patient = 0;
        $total_followup_patient = 0;
        $total_number_of_patient = 0;

        @endphp
        @foreach ($doctorPerformanceSummarydept as $data)
        @php
            $total_new_patient += $data->patient_new_paid;
            $total_free_patient += $data->patient_free;
            $total_followup_patient += $data->patient_followup_free;
            $total_number_of_patient += $data->total_appointment;
        @endphp
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{ ucfirst($data->serviceunit_name) }}</td>
            <td class="text-center">{{ $data->patient_new_paid}}</td>
            <td class="text-center">{{ $data->patient_free}}</td>
            <td class="text-center">{{ $data->patient_followup_free}}</td>
            <td class="text-center">{{ $data->total_appointment}}</td>
            <td class="text-center"></td>

        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" colspan="2"> <strong> Total = </strong> </td>
            <td class="text-center"> <strong> {{ $total_new_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient }} </strong></td>
            <td class="text-center"></td>
        </tr>
    </tfoot>
    @endif

</table>
{{-- <table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='7' class='text-center'> <strong>  OPD  CLASSIFICATION OF EMERGENCY STATUS</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">DEPARTMENT</th>
            <th class="text-center">New Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Follow Up/Old Patients</th>
            <th class="text-center">Total Patients</th>
            <th class="text-center">Remarks</th>
        </tr>
    </thead>
    @if (!empty($doctorPerformanceSummary))
    <tbody>
        @php
        $total_new_patient = 0;
        $total_free_patient = 0;
        $total_followup_patient = 0;
        $total_number_of_patient = 0;

        @endphp
        @foreach ($doctorPerformanceSummary as $data)
        @php
            $total_new_patient += $data->patient_new_paid;
            $total_free_patient += $data->patient_free;
            $total_followup_patient += $data->patient_followup_free;
            $total_number_of_patient += $data->total_appointment;
        @endphp
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">DEPARTMENT</td>
            <td class="text-center">{{ $total_new_patient}}</td>
            <td class="text-center">{{ $total_free_patient}}</td>
            <td class="text-center">{{ $total_followup_patient}}</td>
            <td class="text-center">{{ $total_number_of_patient}}</td>
            <td class="text-center"></td>

        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" colspan="2"> <strong> Total = </strong> </td>
            <td class="text-center"> <strong> {{ $total_new_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_free_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_followup_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_number_of_patient }} </strong></td>
            <td class="text-center"></td>
        </tr>
    </tfoot>
    @endif

</table> --}}


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        // "lengthMenu": [
        //     [50],
        //     [50]
        // ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
