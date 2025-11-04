<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-left">Date of Bill</th>
            <th class="text-center">Card No.</th>
            <th class="text-left">Employee Name</th>
            <th class="text-center">UHID</th>
            <th class="text-left">PACKAGE NAME</th>
            <th class="text-left">Fitness Status</th>
            <th class="text-left">Remarks</th>
            <th class="text-center" style="width:5%">Action</th>
        </tr>
    </thead>
    <tbody id="cvListTable">
        @if (!empty($preEmployeeData)) 
            @foreach ($preEmployeeData as $data)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-left">{{date('d/m/Y', strtotime($data->invoice_date))}}</td>
                    <td class="text-center">{{$data->person_code}}</td>
                    <td class="text-left">{{$data->full_name}}</td>
                    <td class="text-center">{{$data->patient_code}}</td>
                    <td class="text-left">{{$data->item_name}}</td>
                    <td class="text-left">{{$data->emp_status}}</td>
                    <td class="text-left">{{$data->remarks}}</td>
                    <td class="text-left">
                        @if(isset($doc_info) && $doc_info->doctor_ind == 1)
                            <button  type="button" class="btn btn-sm btn-primary mb-1 mt-1 open-modal" data-action="{{ route('v1.hrm.pre-employee-certificate-form', [$data->invoice_no_pk ?? 0, $data->person_no_pk ?? 0, $data->patient_no_fk ?? 0 ]) }}" data-modal="common-modal-md" data-title="Pre Employment Health Checkup Certificate Form" title="Edit"><i class="fa fa-edit"></i></button>
                        @endif
                        @if(isset($data->preempcertificate_no_pk))
                            <a class="btn btn-sm btn-success" href="{{ route('v1.hrm.pre-employee-certificate', ['id' => $data->invoice_no_pk]) }}"  target="_blank" title="Print Certificate" ><i class="fa fa-print"></i></a>
                        @endif
                    </td>
                    
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('.data-table')) {
            $('.data-table').DataTable().destroy(); // Destroy existing instance
        }
        // Reinitialize DataTable
        $('.data-table').DataTable({
            "ordering": true,
            "searching": true,
            "lengthMenu": [10, 20, 50, 75, 100],
            "pageLength": 10, // Number of entries per page
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>

