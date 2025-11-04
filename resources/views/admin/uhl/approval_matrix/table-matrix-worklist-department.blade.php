<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped data-table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th>SL</th>
            <th>Approval Name</th>
            {{-- <th>No Of Level</th> --}}
            <th>Default Signatory</th>
            <th>All Random</th>
            <th>All Sequential</th>
            <th>Levels</th>
            <th>No Of Level</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
     @if (!empty($allApprovalMatrixData))
     @foreach ($allApprovalMatrixData as $data)

         @php
         $preparedEmp = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $data->default_prepared_by)->first();

         $verifiedEmp = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $data->default_verified_by)->first();
         $finalizedEmp = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $data->default_finalized_by)->first();
         // $ItemLevels = DB::table('sysc_approvalmatrixdtl')->select('employee_info_vw.full_name')->where('person_no_pk', $data->default_finalized_by)->first();
         // dd($data->approvalmatrixmst_no_pk);
         @endphp
     <tr>
         <td>{{ $loop->iteration }}</td>
         <td class="text-left">
             {{ $data->approval_for_code ? $data->approval_for_code : '' }}
         </td>
         {{-- <td class="text-center">
             {{ $data->no_of_level ?: '0' }}
         </td> --}}
         <td>
            <table class="table table-borderless">
                <tr>
                    <td class="border-0 text-left">
                      <strong>Prepared By :</strong>
                    </td>
                    <td class="border-0 text-left">
                     {{ isset($preparedEmp) ? $preparedEmp->full_name : "" }}
                    </td>

                </tr>
                <tr>
                    <td class="border-0 text-left">
                      <strong>Verified By :</strong>
                    </td>
                    <td class="border-0 text-left">
                     {{ isset($verifiedEmp) ? $verifiedEmp->full_name : "" }}
                    </td>

                </tr>
                <tr>
                    <td class="border-0 text-left">
                      <strong>Finalized By :</strong>
                    </td>
                    <td class="border-0 text-left">
                     {{ isset($finalizedEmp) ? $finalizedEmp->full_name : "" }}
                    </td>

                </tr>
            </table>
         </td>
         <td class="text-center">{{ $data->all_random_ind ? 'Yes': 'No' }}</td>
         <td class="text-center">{{ $data->all_sequential_ind ? 'Yes': 'No' }}</td>
         <td>
            <table class="table table-borderless">
                @php
                    $strArray = explode('|', $data->emp_name);
                @endphp
                @foreach ( $strArray as $key => $value)
                <tr>
                    <td class="border-0 text-left">
                      {{$key+1}}
                    </td>
                    <td>|</td>
                    <td class="border-0 text-left">
                     {{$value == " , " ? "HOD" : $value }}
                    </td>
                </tr>

                @endforeach
            </table>
         </td>
         <td class="text-center">{{$data->total_item ?: 0}}</td>
         <td>
             {{-- <a href="" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                 <i class="fas fa-eye"></i>
             </a> --}}
             <a href="{{ route('v1.edit-approval-matrix-department', $data->approvalmatrixmst_no_pk) }}"
                 class="btn btn-sm btn-success" title="Edit"
                 target="_blank"><i
                     class="fas fa-edit"></i></a>
         </td>

     </tr>
     @endforeach
     @endif

    </tbody>
</table>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript">
        $('.data-table').DataTable({
    "ordering": false,
    "bPaginate": false,
    "bLengthChange": false,
    "bAutoWidth": false
});

</script>
