<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<table width="100%">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-left">Full Name</th>
            <th class="text-left">Department</th>
            <th class="text-center">CCU</th>
            <th class="text-center">Echo</th>
            <th class="text-center">Dialysis</th>
            <th class="text-center">Endoscopy Colonoscopy</th>
            <th class="text-center">ENT</th>
            <th class="text-center">EYE</th>
            <th class="text-center">Gynaeobs</th>
            <th class="text-center">ICU</th>
            <th class="text-center">MED</th>
            <th class="text-center">NEO</th>
            <th class="text-center">Neorusurgery</th>
            <th class="text-center">NICU</th>
            <th class="text-center">ORTHO</th>
            <th class="text-center">PEDI</th>
            <th class="text-center">PHYSIO</th>
            <th class="text-center">SUR</th>
        </tr>
    </thead>
    <tbody>
        @php 
        
         $ref_ccu_sum= 0;
         $ref_dialysis_sum= 0;
         $ref_echo_sum= 0;
         $ref_endoscopy_colonoscopy_sum= 0;
         $ref_ent_sum= 0;
         $ref_ett_sum= 0;
         $ref_eye_sum= 0;
         $ref_gynaeobs_sum= 0;
         $ref_icu_sum= 0;
         $ref_med_sum= 0;
         $ref_neo_sum= 0;
         $ref_neurosurgery_sum= 0;
         $ref_nicu_sum= 0;
         $ref_ortho_sum= 0;
         $ref_pedi_sum= 0;
         $ref_physio_sum= 0;
         $ref_sur_sum= 0;
         
        @endphp
    @if (isset($report_data))
            @foreach ($report_data as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td style="text-align: left;">{{ $data->full_name }}</td>
                    <td style="text-align: left;">{{ $data->su_name }}</td>
                    <td style="text-align: center;">{{ $data->ref_ccu }}</td>
                    
                    <td style="text-align: center;">{{ $data->ref_echo }}</td>
                    <td style="text-align: center;">{{ $data->ref_dialysis }}</td>
                    <td style="text-align: center;">{{ $data->ref_endoscopy_colonoscopy }}</td>

                    <td style="text-align: center;">{{ $data->ref_ent }}</td>
                    <td style="text-align: center;">{{ $data->ref_eye }}</td>

                    <td style="text-align: center;">{{ $data->ref_gynaeobs }}</td>
                    <td style="text-align: center;">{{ $data->ref_icu }}</td>
                    <td style="text-align: center;">{{ $data->ref_med }}</td>
                    <td style="text-align: center;">{{ $data->ref_neo }}</td>
                    <td style="text-align: center;">{{ $data->ref_neurosurgery }}</td>

                    <td style="text-align: center;">{{ $data->ref_nicu }}</td>
                    <td style="text-align: center;">{{ $data->ref_ortho }}</td>
                    <td style="text-align: center;">{{ $data->ref_pedi }}</td>
                    <td style="text-align: center;">{{ $data->ref_physio }}</td>
                    <td style="text-align: center;">{{ $data->ref_sur }}</td>
                </tr>
                @php 
                $ref_ccu_sum +=$data->ref_ccu;
                $ref_dialysis_sum +=$data->ref_dialysis;
                $ref_echo_sum +=$data->ref_echo;
                $ref_endoscopy_colonoscopy_sum +=$data->ref_endoscopy_colonoscopy;
                $ref_ent_sum +=$data->ref_ent;
                $ref_ett_sum +=$data->ref_ett;
                $ref_eye_sum +=$data->ref_eye;
                $ref_gynaeobs_sum +=$data->ref_gynaeobs;
                $ref_icu_sum +=$data->ref_icu;
                $ref_med_sum +=$data->ref_med;
                $ref_neo_sum +=$data->ref_neo;
                $ref_neurosurgery_sum +=$data->ref_neurosurgery;
                $ref_nicu_sum +=$data->ref_nicu;
                $ref_ortho_sum +=$data->ref_ortho;
                $ref_pedi_sum +=$data->ref_pedi;
                $ref_physio_sum +=$data->ref_physio;
                $ref_sur_sum +=$data->ref_sur;           
                 @endphp
                @endforeach


             
                @endif
    </tbody>
    <tfoot>
    <tr>
                <th style="text-align: right" colspan="3">Grand Total: </th>
                <th style="text-align: center;">{{ $ref_ccu_sum}}</th>
                <th style="text-align: center;">{{ $ref_dialysis_sum}}</th>
                <th style="text-align: center;">{{ $ref_echo_sum}}</th>
                <th style="text-align: center;">{{ $ref_endoscopy_colonoscopy_sum}}</th>
                <th style="text-align: center;">{{ $ref_ent_sum}}</th>
                <th style="text-align: center;">{{ $ref_ett_sum}}</th>
                <th style="text-align: center;">{{ $ref_eye_sum}}</th>
                <th style="text-align: center;">{{ $ref_gynaeobs_sum}}</th>
                <th style="text-align: center;">{{ $ref_icu_sum}}</th>
                <th style="text-align: center;">{{ $ref_med_sum}}</th>
                <!-- <th style="text-align: center;">{{ $ref_neo_sum}}</th> -->
                <th style="text-align: center;">{{ $ref_neurosurgery_sum}}</th>

                <th style="text-align: center;">{{ $ref_nicu_sum}}</th>
                <th style="text-align: center;">{{ $ref_ortho_sum}}</th>

                <th style="text-align: center;">{{ $ref_pedi_sum}}</th>
                <th style="text-align: center;">{{ $ref_physio_sum}}</th>
                <th style="text-align: center;">{{ $ref_sur_sum}}</th>

            </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
