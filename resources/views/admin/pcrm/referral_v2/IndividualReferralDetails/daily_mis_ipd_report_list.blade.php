<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='8' class='text-center'> <strong> IPD</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Ward</th>
            <th class="text-center">PREVIOUS DAY PATIENT</th>
            <th class="text-center">ADMITTED PATIENT</th>
            <th class="text-center">MOVING-IN PATIENT</th>
            <th class="text-center">DISCHARGE PATIENT</th>
            <th class="text-center">MOVING-OUT PATIENT</th>
            <th class="text-center">CURRENT PATIENT</th>
        </tr>
    </thead>
    @if (!empty($ipd_datas))
    <tbody>
      @php
            $gross_total_previous_day_patient = 0;
            $gross_total_admitted_patient = 0;
            $gross_total_moving_in_patient = 0;
            $gross_total_discharge_patient = 0;
            $gross_total_moving_out_patient = 0;
            $gross_total_current_patient = 0;    
         
        @endphp
        @foreach ($ipd_datas as $ward => $data)   
        @php
        $ward=explode('_',$ward);
        @endphp
   

        @php
            $total_previous_day_patient = 0;
            $total_admitted_patient = 0;
            $total_moving_in_patient = 0;
            $total_discharge_patient = 0;
            $total_moving_out_patient = 0;
            $total_current_patient = 0;    
            $admitted_date='';
        @endphp
        @foreach($data as $value)
            @php
            $admitted_date=date('Y-m-d',strtotime($value->admission_date));
            if($admitted_date < date('Y-m-d') && $value->dis_ind == 0){
                $total_previous_day_patient += 1;
            }
            if($admitted_date == date('Y-m-d')  && $value->dis_ind == 0){
                $total_admitted_patient += 1;
            }
            if($value->dis_ind == 1){
                $total_discharge_patient += 1;
            }
            
            $total_moving_in_patient += 0;
        
            $total_moving_out_patient += 0;
            $total_current_patient =  ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient >= 0 ? ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient : 0;
            @endphp
        @endforeach
      



        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">{{ $ward[1]}}</td>
            <td class="text-center"> {{$total_previous_day_patient}}</td>
            <td class="text-center">{{$total_admitted_patient}}</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_discharge_patient}}</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_current_patient}}</td>

        </tr>
     
        @php
            $gross_total_previous_day_patient +=  $total_previous_day_patient;
            $gross_total_admitted_patient += $total_admitted_patient;
            $gross_total_moving_in_patient = 0;
            $gross_total_discharge_patient += $total_discharge_patient;
            $gross_total_moving_out_patient = 0;
            $gross_total_current_patient +=  $total_current_patient;    
         
        @endphp
        @endforeach 
    </tbody>
  
    <tfoot>
        <tr>
            <td class="text-right" colspan="2"> <strong> Total = </strong> </td>
            <td class="text-center"> <strong> {{ $gross_total_previous_day_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $gross_total_admitted_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $total_moving_in_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $gross_total_discharge_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_moving_out_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $gross_total_current_patient }} </strong></td>
        </tr>
    </tfoot>
    @endif
</table>
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='8' class='text-center'> <strong> DEPARTMENT WISE IPD PATIENT CLASSIFICATION</strong></td>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">DEPARTMENTS</th>           
            <th class="text-center">PREVIOUS DAY PATIENT</th>
            <th class="text-center">ADMITTED PATIENT</th>
            <th class="text-center">MOVING-IN PATIENT</th>
            <th class="text-center">DISCHARGE PATIENT</th>
            <th class="text-center">MOVING-OUT PATIENT</th>
            <th class="text-center">CURRENT PATIENT</th>
        </tr>
    </thead>
    @if (!empty($ipd_department_datas))
    <tbody>
      @php
            $gross_total_previous_day_patient = 0;
            $gross_total_admitted_patient = 0;
            $gross_total_moving_in_patient = 0;
            $gross_total_discharge_patient = 0;
            $gross_total_moving_out_patient = 0;
            $gross_total_current_patient = 0;    
         
        @endphp
        @foreach ($ipd_department_datas as $su => $data)   
        @php
        $su=explode('_',$su);
        @endphp
   

        @php
            $total_previous_day_patient = 0;
            $total_admitted_patient = 0;
            $total_moving_in_patient = 0;
            $total_discharge_patient = 0;
            $total_moving_out_patient = 0;
            $total_current_patient = 0;    
            $admitted_date='';
        @endphp
        @foreach($data as $value)
            @php
            $admitted_date=date('Y-m-d',strtotime($value->admission_date));
            if($admitted_date < date('Y-m-d') && $value->dis_ind == 0){
                $total_previous_day_patient += 1;
            }
            if($admitted_date == date('Y-m-d')  && $value->dis_ind == 0){
                $total_admitted_patient += 1;
            }
            if($value->dis_ind == 1){
                $total_discharge_patient += 1;
            }
            
            $total_moving_in_patient += 0;
        
            $total_moving_out_patient += 0;
            $total_current_patient =  ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient >=0 ?  ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient : 0;
            @endphp
        @endforeach
      



        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">{{ $su[1]}}</td>
            <td class="text-center"> {{$total_previous_day_patient}}</td>
            <td class="text-center">{{$total_admitted_patient}}</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_discharge_patient}}</td>
            <td class="text-center"></td>
            <td class="text-center">{{ $total_current_patient}}</td>

        </tr>
     
        @php
            $gross_total_previous_day_patient +=  $total_previous_day_patient;
            $gross_total_admitted_patient += $total_admitted_patient;
            $gross_total_moving_in_patient = 0;
            $gross_total_discharge_patient += $total_discharge_patient;
            $gross_total_moving_out_patient = 0;
            $gross_total_current_patient +=  $total_current_patient;    
         
        @endphp
        @endforeach 
    </tbody>
  
    <tfoot>
        <tr>
            <td class="text-right" colspan="2"> <strong> Total = </strong> </td>
            <td class="text-center"> <strong> {{ $gross_total_previous_day_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $gross_total_admitted_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $total_moving_in_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $gross_total_discharge_patient }} </strong></td>
            <td class="text-center"> <strong> {{ $total_moving_out_patient  }} </strong></td>
            <td class="text-center"> <strong> {{ $gross_total_current_patient }} </strong></td>
        </tr>
    </tfoot>
    @endif

</table>
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='3' class='text-center'> <strong> SURGICAL STATUS</strong></td>
        </tr>
        <tr>
            <th class="text-center w-5">SL#</th>
            <th class="text-left">DEPARTMENTS</th>           
            <th class="text-center">ACHIEVEMENTS</th>
          
        </tr>
    </thead>
    @if (!empty($surgical_data))
    <tbody>
     @php
        $total_achievements = 0;
        
    @endphp
        @foreach ($surgical_data as $data)
        @php
        $total_achievements += $data->current_item_qty;
      
        @endphp
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{$data->serviceunit_name}}</td>
            <td class="text-center">{{$data->current_item_qty}}</td>          

        </tr>
        @endforeach    
    </tbody>
    <tfoot>
         <tr>
            <td class="text-right" colspan="2"> <strong> Total = </strong> </td>
            <td class="text-center"> <strong> {{ $total_achievements  }} </strong></td>          
        </tr>
    </tfoot>
    @endif
</table>
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td colspan='3' class='text-center'> <strong> Radiology & Imaging</strong></td>
        </tr>
        <tr>
            <th class="text-center w-5">SL#</th>
            <th class="text-left">NAME OF EQUIPMENTS</th>           
            <th class="text-center">ACHIEVEMENTS</th>
          
        </tr>
    </thead>
    @if (!empty($radiology_data))
    <tbody>
     @php
        $total_achievements = 0;
        
    @endphp
        @foreach ($radiology_data as $data)
        @php
        $total_achievements +=$data->current_item_qty;
      
        @endphp
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{$data->serviceunit_name}}</td>
            <td class="text-center">{{$data->current_item_qty}}</td>          

        </tr>
        @endforeach    
    </tbody>
    <tfoot>
         <tr>
            <td class="text-right" colspan="2"> <strong>Sub Total Income = </strong> </td>
            <td class="text-center"> <strong> {{ $total_achievements  }} </strong></td>          
        </tr>
    </tfoot>
    @endif
</table>




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