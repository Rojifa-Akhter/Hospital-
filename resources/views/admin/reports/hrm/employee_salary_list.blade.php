
<style >
    .board_member_img{
        border: 1px solid black;
        width: 50px;
    }
</style>

<div class="row mt-2">
    <div class="col-md-12 table-responsive">
        <table id="data-table" class="table table-bordered  " width="100%" border="1">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center" scope="col">Sl#</th>
                    <th class="text-left" scope="col">Employee</th>
                    <th class="text-center" scope="col">Section</th>

                    <th class="text-center" scope="col">Salary</th>

                </tr>
            </thead>
            <tbody>



                @php $listSl = 0; @endphp

                @foreach($salary_data as $dept => $dept_data)

                @php $dep = 0 @endphp


                @foreach($dept_data as $desig => $emp_data)

                @php $des = 0    @endphp

                @php $listSl++; @endphp
                @php $dep++; @endphp


                @if($dep == 1)
                <tr>
                    <div class="text-center" style="text-align: center;">

                        <td class="" colspan="4"  scope="col">

                           <table>
                            <tr class="">
                                <td  class="border-0"> <strong> Department = </strong>  {{$dept}} </td>
                                <td class="border-0">  <strong>Total Employee = </strong> {{ isset($count_depart_emp[$dept])? $count_depart_emp[$dept] : "0" }} </td>
                                <td class="border-0">  <strong> Total Gross Salary = </strong> {{ isset($sum_salary[$dept])? $sum_salary[$dept] : "0" }} </td>
                            </tr>

                        </table>


                    </td>

                </div>
            </tr>
            <tr>
               @endif
               <td class="text-center" scope="col">{{$listSl}}</td>


               <td class="align-text-top" scope="col">
                <div class="board_member_info d-flex align-items-center">
                    <div class="d-inline-block board_member_img ml-2">
                        @if(!empty($emp_data->photo_name))
                        <img class="w-100" src="{{ asset('images/uploads/doctor_images/thumb/')}}/{{$emp_data->photo_name}}" alt="">
                        @else
                        <img class="w-100" src="{{ asset('images/no-photo.png')}}" alt="">
                        @endif
                    </div>
                    <div class="d-inline-block ml-2">
                     {{$emp_data->card_no }} <br>
                     {{$emp_data->full_name }}<br>
                     JD : {{date('d/m/Y',strtotime($emp_data->join_date)) }}<br>
                     BG : {{$emp_data->blood_group }}
                 </div>
             </div>

         </td>
         <td class="align-text-top" scope="col">
           <table>
            <tr>
                <td class="border-0 text-left  align-text-top">Bank Name</td>
                <td class="border-0 text-left align-text-top"> : {{$emp_data->bank_name}}</td>
            </tr>
            <tr>
                <td class="border-0 text-left align-text-top">Acc. Name</td>
                <td class="border-0 text-left align-text-top"> : {{$emp_data->bank_acc_name}}</td>
            </tr>
            <tr>
                <td class="border-0 text-left align-text-top">Acc. No</td>
                <td class="border-0 text-left align-text-top"> : {{$emp_data->bank_acc_no}}</td>
            </tr>


        </table>
    </td>
    <td class="" scope="col">
        <table>
            <tr>
                <td class="border-0 text-left">Basic</td>
                <td class="border-0 text-left"> : {{$emp_data->basic_salary}}</td>
            </tr>
            <tr>
                <td class="border-0 text-left">House</td>
                <td class="border-0 text-left"> : {{$emp_data->house_rent}}</td>
            </tr>
            <tr>
                <td class="border-0 text-left">Medical</td>
                <td class="border-0 text-left"> : {{$emp_data->medical_allow}}</td>
            </tr>
            <tr>
                <td class="border-0 text-left">Gross</td>
                <td class="border-0 text-left"> : {{$emp_data->gross_salary}}</td>
            </tr>
            <tr>
                <td class="border-0 text-left">Savings Amount</td>
                <td class="border-0 text-left"> : {{$emp_data->personal_savings_amount}}</td>
            </tr>
        </table>

    </td>




</tr>



@endforeach

@endforeach



</tbody>
</table>
</div>
</div>

