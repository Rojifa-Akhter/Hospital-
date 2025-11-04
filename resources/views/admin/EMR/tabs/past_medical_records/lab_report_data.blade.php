@if(!empty($lab_data))
<input type="hidden" name="pat_id" id="pat_id" value="{{ $patient_id}}">
@foreach ($lab_data as $value)
@php
    // dd($lab_data)
@endphp
<tr>

	<td class="text-center">{{$loop->iteration}}</td>
	<td class="text-center">{{$value->invoice_code}}</td>
	<td class="text-left">{{$value->item_name}}</td>
	<td class="text-left">{{$value->report_delivery_date !="" ?date("d/m/Y", strtotime($value->report_delivery_date)):""}}</td>
	<td class="text-center">{{$value->lab_code}}</td>
	{{-- <td class="text-left"></td> --}}
	<td class="text-center">
		@if($value->lab_result_verify_key_ind == 1)

        @if($value->lab_result_final_key_ind == 1)
            @if ($value->report_url == 'path.bc-report-pdf')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-column-2')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank"  >Print</a>
        @elseif($value->report_url == 'path.bc-special-pdf-column-2')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-special-pdf-cbc')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-mic')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-cr')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.gram-stain-pdf')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.afb-report')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.csf-report')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-elisa')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-column-2-pbf')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-stool-pdf-column-2')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'histopathology.bc-report-pdf-mic')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-3column')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}"
                class="btn btn-sm btn-warning" target="_blank" >Print</a>
    @elseif($value->report_url == 'path.bc-report-pdf-pcr')
            <a href="{{ route($value->report_url, $value->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-column-4')
        <a href="{{ route($value->report_url, $value->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @elseif($value->report_url == 'path.bc-report-pdf-v1')
        <a href="{{ route($value->report_url, $value->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank" >Print</a>
        @endif








        {{-- <a href="{{ route('path.bc-report-pdf', $value->report_no_fk) }}" class="btn btn-outline-primary btn-sm bg-none cursor-pointer " target="_blank"><i class="fa fa-file-pdf"></i></a> --}}
	@inject('due_status','App\Http\Controllers\EMRController')
	@php
	 $indent_item = $due_status->dueCalculate($value->invoice_no_fk);
	//  dd($indent_item );
	@endphp
		@if (Session::get('user.email_send_ind')==1 && $indent_item <=0 && $value->email !='')
		  @php
		  $send_mail_color=$value->mail_ind ==1 ? 'btn-outline-success' : 'btn-outline-info';
		  $sendUrl=route("send-mail-lab-report");
		//   dd($sendUrl);
	      @endphp
	     <button type="button" class="btn btn-sm <?=  $send_mail_color; ?> bg-none cursor-pointer" data-report_id="{{$value ->report_no_fk}}" onclick="pathologyFunc.sendLabReportMail(this,'{{ $patient_id}}','{{$value ->report_no_fk}}','{{ $sendUrl}}' ,$('.lab_report'))"><i class="fa fa-envelope"></i></button>
		@endif

        @else
        <button type="button" class="btn btn-sm btn-secondary" disabled>Finalize Pending</button>
        @endif

		@else
		 <span class="alert alert-danger">Pending</span>
		@endif
    </td>
</tr>
@endforeach
@else

<tr>
	<td colspan="10" class="text-center">No Data Found</td>
</tr>
@endif
<script>
	// function sendMail(element){
	// 	if (confirm('Are You Sure ?')) {
	// 		$.ajax({
	// 			data:{
	// 					pat_id:$('#pat_id').val(),
	// 					report_id:$(element).data("report_id"),
	// 			},
	// 			url:  "{{route('send-mail-lab-report')}}",
	// 			type: "post",
	// 			beforeSend:function(){
	// 				blockUI();

	// 			},
	// 			success: function (data) {
	// 				// $("#search_data").html(data);
	// 				$('.lab_report').click();
	// 				// EMRFunc.getCurrentMedicalUsages($('#nav-lab-report-tab'));
	// 			},
	// 			complete:function(){
	// 				$.unblockUI();
	// 			}
	// 		});
	// 	}
	// }
</script>
