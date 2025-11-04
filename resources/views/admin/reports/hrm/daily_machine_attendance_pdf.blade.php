

@include('admin.components.pdf_header')
<main>
   <div class="wrapper">
      <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
         <span class="report-name" style="width:70%; border:solid black 1px; padding:20px;  "> Daily Machine Attendance Report</span>
      </div>
      <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
         <span class="report-date"><strong> From Date: </strong> {{$from_date }}
         </span>
         <span class="report-date"><strong> To Date: </strong> {{($to_date ==  '01-01-1970') ? '' : $to_date }}
         </span>
      </div>
      <section id="lp-items">
         <div class="container">
            <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
               <tr class="table-tr" style="background-color: #E3E3E3;">
                  <td class="table-td" style="text-align: center;" scope="col" >
                     <strong>SL</strong>
                  </td>
                  <td class="table-td" style="text-align: center; width: 150px" scope="col" ><strong>
                  Employee </strong>
               </td>
                  
                  <td class="table-td" style="text-align: center;" scope="col" >
                     <strong>Attendance Date</strong>
                  </td>
                  <td class="table-td" style="text-align: center;" scope="col" >
                     <strong>Department</strong>
                  </td>
                  
               <td class="table-td" style="text-align: center;" scope="col" >
                  <strong>In time Photo</strong>
               </td>
               <td class="table-td" style="text-align: center; width: 50px" scope="col" >
                  <strong>In Time hh:24</strong>
               </td>
               <td class="table-td" style="text-align: center;" scope="col" >
                  <strong>Out Time Photo</strong>
               </td>
               <td class="table-td" style="text-align: center; width: 50px" scope="col" >
                  <strong>Out Time hh:24</strong>
               </td>
               <td class="table-td" style="text-align: center; width: 50px" scope="col" >
                  <strong>OT</strong>
               </td>
               <td class="table-td" style="text-align: center; width: 50px" scope="col" >
                  <strong>Late</strong>
               </td>
               <td class="table-td" style="text-align: center; width: 50px" scope="col" >
                  <strong>Remarks</strong>
               </td>
            </tr>
         {{--                        </thead>--}}
         {{--                        
            <tbody>
               --}}
               @if(isset($machine_data))
               @foreach($machine_data as $value)
               <tr class="table-tr">
                   <td class="table-td" style="text-align: center;" scope="col">{{$loop->iteration}}</td>
                   <td class="table-td"  scope="col">
                     <div class="board_member_info d-flex align-items-center" style="padding-top: 10px;" >
                        <div class="board_member_img" style="display: inline-block; ">
                        @if($value->photo_name !="")
                           <img class="w-100" width="50px" src="{{ asset('images/uploads/doctor_images/thumb/')}}/{{$value->photo_name}}" alt="">
                        @endif   
                        </div>
                        <div class="board_member_details text-left" style="display: inline-block;">
                           <table>
                              <tr>
                                 <td>  {{ $value->person_card_no}}</td>
                               
                              </tr>
                              <tr>
                                 <td>  {{$value->full_name}}</td>
                                
                              </tr>
                              <tr>
                                 <td>  {{$value->designation_name}}</td>
                               
                              </tr>
                           </table>
                          
                        </div>
                     </div>
                     
                  </td>
                 
                  <td class="table-td" style="text-align: left;" scope="col">{{date('d/m/Y', strtotime($value->attendance_date))}}</td>
                  <td class="table-td" style="text-align: left;" scope="col">{{($value->serviceunit_name != '') ? $value->serviceunit_name : ''}}</td>

                  <td class="table-td" style="text-align: center;" scope="col">
                  @if($value->in_time_photo !="")
                  <img width="70" class="" src="{{ asset('images/uploads/attendance_images/')}}/{{$value->in_time_photo}}" alt=""> 
                  @endif
               </td>
                  <td class="table-td" style="text-align: left;" scope="col">{{date('H:i ',strtotime($value->duty_in_time))}} <br> {{date('H:i ',strtotime($value->in_time))}}</td>
                  <td class="table-td" style="text-align: center;" scope="col">
                  @if($value->in_time_photo !="")
                  <img width="70" class="" src="{{ asset('images/uploads/attendance_images/')}}/{{$value->out_time_photo}}" alt="">
                  @endif
               </td>
                  <td class="table-td" style="text-align: left;" scope="col">{{date('H:i ',strtotime($value->duty_out_time))}} <br> {{date('H:i ',strtotime($value->out_time))}}</td>
                  <td class="table-td" style="text-align: left;" scope="col">{{$value->over_time_min}}</td>
                  <td class="table-td" style="text-align: left;" scope="col">{{$value->late_time_min}}</td>
                  <td class="table-td" style="text-align: left;" scope="col">{{$value->attendance_status_text}}</td>
               </tr>
               @endforeach
               @endif
            {{--                        </tbody>--}}
         </table>
      </div>
   </section>
</div>
</main>
@include('admin.components.pdf_footer')

