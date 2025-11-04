@include('admin.components.pdf_header')
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Daily Machine Attendance Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong> Date: </strong> {{$date }}
            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td" style="text-align: center;" scope="col" >
                            <strong>SL</strong>
                        </td>
                        <td class="table-td" style="text-align: center;" scope="col" >
                            <strong>Attendance Date</strong></td>
                            <td class="table-td" style="text-align: center;" scope="col" >
                                <strong>Department</strong></td>
                                
                                <td class="table-td" style="text-align: center;" scope="col" ><strong>
                                Employee All Info</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>In time Photo</strong></td>
                                    <td class="table-td" style="text-align: center;" scope="col" >
                                        <strong>In Time</strong></td> 
                                        <td class="table-td" style="text-align: center;" scope="col" >
                                            <strong>Out Time Photo</strong></td> 
                                            <td class="table-td" style="text-align: center;" scope="col" >
                                                <strong>Out Time</strong></td>
                                                

                                            </tr>
                                        {{--                        </thead>--}}
                                        {{--                        <tbody>--}}

                                            @if(isset($machine_data))
                                            @foreach($machine_data as $date => $employee_data )
                                            <?php $date1 = 0 ?>
                                            @foreach($employee_data as $emp_code => $data )
                                            <?php $date1 ++ ?>

                                            <tr>
                                                <td class="text-center" scope="col">{{$loop->iteration}}</td>
                                                
                                                <td class="text-left" scope="col">{{date('d/m/Y', strtotime($date))}}</td>
                                                
                                                <td class="text-left" scope="col">{{($data->serviceunit_name != '') ? $data->serviceunit_name : ''}}</td>

                                                <td class="text-left" scope="col">
                                                    <div class="board_member_info d-flex align-items-center">
                                                        <div class="board_member_img">
                                                            <img class="w-100" src="{{ asset('images/uploads/doctor_images/thumb/')}}/{{$data->photo_name}}" alt="">
                                                        </div>

                                                        <div class="board_member_details text-left">
                                                           
                                                            <span class="d-block"><strong>Service Id</strong> :&nbsp;{{ $emp_code}}</span>
                                                            
                                                            <span class="d-block"><strong>Name</strong> :&nbsp;{{$data->full_name}}</span>

                                                            <span class="d-block"><strong>Speciality</strong> :&nbsp; {{$data->designation_name}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="text-left" scope="col"><img width="120" class="" src="{{ asset('images/uploads/attendance_images/')}}/{{$data->punch_time_photo}}" alt=""> </td>
                                            <td class="text-left" scope="col">{{date('H:i a',strtotime($data->attandance_data))}}</td>
                                            <td class="text-left" scope="col"><img width="120" class="" src="{{ asset('images/uploads/attendance_images/')}}/{{$data->punch_time_photo}}" alt=""></td>
                                            <td class="text-left" scope="col">{{date('H:i a',strtotime($data->attandance_data))}}</td>

                                        </tr>


                                        @endforeach
                                        @endforeach
                                        @endif

                                        
                          <!--   @if(isset($value))
                        @foreach($value as $data)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>{{$loop->iteration}}</strong>
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{date('d/m/Y', strtotime($data->attendance_date))}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{$data->person_card_no}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" ><strong>
                                {{$data->full_name}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{$data->designation_name}}</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>{{$data->in_time}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{$data->conflict_comments}}</strong></td>

                            </tr>
                            @endforeach
                            @endif -->
                        {{--                        </tbody>--}}


                    </table>
                </div>
            </section>
        </div>
    </main>


    @include('admin.components.pdf_footer')