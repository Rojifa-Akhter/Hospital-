{{-- <link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet"> --}}
<div class="container-fluid">
    <div class="card">
        <div class="card-body table-responsive">
            <table width="100%" class="data-table" border="1">
                <thead>
                    <tr class="global-uhl-table-bg">
                        <th>Sl.</th>
                        <th>Donor Id</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>BG</th>
                        <th>Address</th>
                        <th>Last blood donat date</th>
                        <th>Doner Type</th>
                        <th>Selected Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="donor_list">
                    @if(!empty($blood_requisition_dtl_data))
                    @foreach($blood_requisition_dtl_data as $value)
                    <tr>
                        <td style="text-align: center;">{{$loop->iteration}}</td>                       
                        <td style="text-align: center;">{{$value->donor_no_pk}}</td>
                        <td>{{$value->donor_name}}</td>
                        <td style="text-align: center;">{{ $value->donor_age }}</td>
                        <td style="text-align: center;">{{$value->donor_gender}}</td>
                        <td style="text-align: center;">{{$value->blood_group}}</td>
                        <td style="text-align: left;">{{$value->donor_address}}</td>
                        <td>{{$value->last_blood_donat_date !="" ? date('d/m/Y',strtotime($value->last_blood_donat_date)):''}}</td>  
                        <td style="text-align: left;">{{$value->lookupdata_code}}</td>
                        <td style="text-align: center;"> <strong> {{$value->is_selected_donate}}</strong></td>                     
                        <td  style="text-align: center;">
                            <a href="{{route('ipd.blood-bank-requisition-edit-donor-dmhl',[$value->donordtl_no_pk, '1'])}}" title="Edit Donor Details" target="_blank"><i class="fa fa-pencil-alt"></i></a>                     
                            <a href="{{route('ipd.pdf-blood-bank-donor-details',$value->donordtl_no_pk)}}" title="requisition pdf" target="_blank"><i class="fa fa-file-pdf"></i></a>
                            <a href="{{route('ipd.donor-barcode-print',$value->donor_no_pk)}}" title="Barcode Print" target="_blank" class="text-success">Barcode</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- <script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script> --}}
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