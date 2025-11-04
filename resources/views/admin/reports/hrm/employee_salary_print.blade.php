
<style >
    .board_member_img{
        border: 1px solid black;
        width: 50px;
    }
</style>
@include('admin.components.pdf_header')
<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td>
        </tr>
    </table>
</div>

<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                            date_default_timezone_set('Asia/Dhaka');
                            $date = date("d/m/Y H:m:s");
                            @endphp
                            {{$date}}
                        </strong> Printed By: <strong>{{Session::get('user.ses_user_name')}}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
<main>
	<div>
		<div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
			<span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Salary Stucture</span>
		</div>
	</div>

	<table   style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
		<thead class="bg-primary" >
			<tr>
				<th style="width: 5px">Sl#</th>
				<th >Employee</th>
				<th >Section</th>
				<th >Salary</th>
			</tr>
		</thead>

		<tbody>
			@php 
			$listSl = 0; @endphp
			@if(!empty($salary_data))
			@foreach($salary_data as $dept => $dept_data)
			@php $dep = 0 @endphp
			@foreach($dept_data as $desig => $emp_data)
			
			@php 
			$des = 0; 
			$listSl++;
			$dep++; 
			@endphp
			
			@if($dep == 1)
			<tr class="">
				<td  class="border-0" colspan="4"> 
					<strong> Department = </strong>{{$dept}} <strong>Total Employee = </strong> 
					{{ isset($count_depart_emp[$dept])? $count_depart_emp[$dept] : "0" }} 
					<strong> Total Gross Salary = </strong>
					{{ isset($sum_salary[$dept])? $sum_salary[$dept] : "0" }} 
				</td>
			</tr>
			@endif
			
			<tr>
				<td style="text-align: center;">{{$listSl}}</td>

				<td class="">
					<div>
						<div class=" board_member_img "  style="display: inline-block; margin-left: 5px ">
							@if(!empty($emp_data->photo_name))
							<img class="w-100 " src="{{ asset('images/uploads/doctor_images/thumb/')}}/{{$emp_data->photo_name}}" alt="">
							@else
							<img class="w-100" src="{{ asset('images/no-photo.png')}}" alt="" style="width: 50px;">
							@endif
						</div>
						<div style="display: inline-block; margin-left: 5px" >
							{{$emp_data->card_no }} <br>
							{{$emp_data->full_name }}<br>
							JD : {{date('d/m/Y',strtotime($emp_data->join_date)) }}<br>
							BG : {{$emp_data->blood_group }}
						</div>
					</div>

				</td>
				<td  scope="col" style="vertical-align: top">
					<table>
						<tr>
							<td style="vertical-align: top">Bank Name</td>
							<td style="vertical-align: top"> : {{$emp_data->bank_name}}</td>
						</tr>
						<tr>
							<td style="vertical-align: top">Acc. Name</td>
							<td style="vertical-align: top"> : {{$emp_data->bank_acc_name}}</td>
						</tr>
						<tr>
							<td style="vertical-align: top">Acc. No</td>
							<td style="vertical-align: top"> : {{$emp_data->bank_acc_no}}</td>
						</tr>


					</table>
				</td>
				<td class="" style="vertical-align: top">
					<table>
						<tr>
							<td style="vertical-align: top">Basic</td>
							<td style="vertical-align: top"> : {{$emp_data->basic_salary}}</td>
						</tr>
						<tr>
							<td style="vertical-align: top">House</td>
							<td style="vertical-align: top"> : {{$emp_data->house_rent}}</td>
						</tr>
						<tr>
							<td style="vertical-align: top">Medical</td>
							<td style="vertical-align: top"> : {{$emp_data->medical_allow}}</td>
						</tr>
						<tr>
							<td style="vertical-align: top">Gross</td>
							<td style="vertical-align: top"> : {{$emp_data->gross_salary}}</td>
						</tr>
						<tr>
							<td style="vertical-align: top">Savings Amount</td>
							<td style="vertical-align: top"> : {{$emp_data->personal_savings_amount}}</td>
						</tr>
					</table>

				</td>
			</tr>

			@endforeach
			@endforeach
			@endif
		</tbody>

	</table>
</main>


</body>

</html>