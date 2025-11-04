<style>
table {
  table-layout: fixed;
  width: 100%; 
}
thead {
  position: sticky;
  top: 0px;
  left:0px;
  right:0px;
}
.selected{
    background-color: #258df5 !important;
    color:white !important;
}
.no-wrap{
    white-space: nowrap;
}
.table-list td{
    font-size: 13px !important
}
</style>
@php
      $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
@endphp
<div style="max-height:400px;overflow-y: scroll">
<table class="table mb-0 table-list">
    <thead>
        <tr class="bg-primary">
            <th class="text-center w-5">SL</th>
            <th class="text-center w-10">Date</th>
            <th class="text-left" style="width: auto; white-space: nowrap;">Voucher No</th>
            <th class="text-left">Voucher Type</th>
            <th class="text-left">Amount</th>
            <th class="text-left">Prepare By</th>
            <th class="text-left w-10">Created At</th>
            <th class="text-left w-10">Updated By</th>
            <th class="text-center w-10">Status</th>
            <th class="text-center w-10">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @forelse($voucher_info->getData()->data as $key => $voucher)
            @if($i < 10)
                @php 
                    $i = "0".$i
                @endphp
            @endif
            <tr>
                <td class="text-center">{{$i}}</td>
                <td class="text-center">{{date("d/m/Y",strtotime($voucher->journal_date))}}</td>
                <td class="text-left text-primary selectedCell{{$key}}" style="cursor: pointer" onclick="fetchJournal('{{$voucher->journal_code}}','{{$key}}')">{{$voucher->journal_code}}</td>
                <td class="text-left no-wrap">{{$voucher->voucher_type_name}}</td>
                <td class="text-right">{{number_format($voucher->dr,2)}}</td>
                <td class="text-left">{{$voucher->prepare_by}}</td>
                <td class="text-left">{{date("d/m/Y",strtotime($voucher->au_entry_at))}}</td>
                <td class="text-left">{{$voucher->journal_update_by}}</td>
                <td class="text-center" width="20%">
                   
                        <span style="cursor: pointer;" class="badge @if($voucher->verified_ind ==1) badge-success @else badge-danger @endif voucher_active_inactive" data-voucher_type="{{$voucher->voucher_type_no_fk}}" data-voucher_date="{{$voucher->journal_date}}" data-voucher_no="{{$voucher->journal_code}}" action-link="{{route('v2.set-active-inactive-journal')}}" @if($voucher->verified_ind ==1) data-active="1" @else data-active="0" @endif>{{$voucher->verified_ind ==1 ? "VERIFIED" : "NOT VERIFIED"}}</span>
                    
                   
                    <div class="voucher_loader_1 pl-3 text-success" style="float:left; display:none; text-align:center; margin-bottom: 13px; font-weight:900;position:relative;z-index:999;"><i class="fas fa-stroopwafel fa-spin"></i></div>
                </td>
                <td class="text-center">
                    @if($hospital_code == 'EWMCH')
                        <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $voucher->journal_code]) }}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>
                    @else
                        <a href="{{route('journal_show')}}?journal_id={{$voucher->journal_code}}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>
                    @endif
                    <a href="{{route('view_journal')}}?journal_id={{$voucher->journal_code}}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                    {{-- @if($voucher->verified_ind != 1) <a href="{{route('edit_journal')}}?journal_id={{$voucher->journal_code}}" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> @endif --}}
                </td>
            </tr>
        @php
            $i++;
        @endphp
        @empty
        <tr>
            <td colspan="10" style="text-align: center"> No Data Found</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
