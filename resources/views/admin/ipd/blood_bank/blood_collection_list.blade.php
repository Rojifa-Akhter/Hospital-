<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr class="global-uhl-table-bg">
            <th>Sl.</th>
            <th class="text-left">Donor Name</th>
            <th class="text-left">Donor No</th>
            <th class="text-left">Mobile No.</th>
            <th class="text-left">Admission No / Date</th>
            <th class="text-left">Bed / Cabin Name</th>
            <th class="text-left">Ward</th>
            <th class="text-left">Department</th>
            <th class="text-left">Admitted Under</th>
            <th class="text-left">Status</th>
            <th class="text-left">Donation</th>
            <th class="text-left">Bag No</th>
            <th class="text-left">BG</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody id="">
        @if(!empty($donor_data))
        @foreach($donor_data as $value)
        <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td>{{$value->donor_name}}</td>
            <td>{{$value->donor_no_pk}}</td>
            <td>{{$value->donor_mobile}}</td>
            <td>{{$value->admission_no_fk}}, {{$value->admission_date !="" ?
                date('d/m/Y',strtotime($value->admission_date)) : ''}}</td>
            <td>{{$value->new_bed_name}}</td>
            <td>{{$value->new_ward_name}}</td>
            <td>{{$value->new_su_name}}</td>
            <td>{{$value->primary_doctor_name}}</td>
            <td>
                @if($value->blood_col_no_pk)
                    <span class="badge badge-success">Collected</span>
                @else
                    <span class="badge badge-danger">Not Collected</span>
                @endif
            </td>
            <td>
                @php

                $blood_collection_no=$value->blood_col_no_pk !="" ? $value->blood_col_no_pk: '';
                @endphp
                <span class="btn btn-sm btn-outline-success open-modal" data-id=""
                    data-action="{{route('ipd.blood-collection-from-donar',[$value->requsition_no_pk, $value->donor_no_pk, $value->admission_no_fk, $value->admission_date, $value->blood_group, $blood_collection_no])}}"
                    data-modal="common-modal-sm" data-title="Blood Donation" >Donate</span>
            </td>
            <td>{{ $value->bag_no }}</td>
            <td>{{ $value->blood_group }}</td>
            {{-- <td style="">
                <!-- <span class="btn btn-sm btn-outline-primary open-modal" data-id="" data-action="" data-modal="common-modal" data-title="Edit Blood Requisition" title="Edit"><i class="fa fa-pencil-alt"></i></span>
    <span class="btn btn-sm btn-outline-success open-modal" data-id="" data-action="" data-modal="common-modal" data-title="Add Donor" title="Add Donor">Add Donor</span>
    <span class="btn btn-sm btn-outline-info open-modal" data-id="" data-action="" data-modal="common-modal" data-title="Donor List" title="Donor list"> Donor List</span>
    <a href="" title="requisition pdf" target="_blank"><i class="fa fa-file-pdf"></i></a> -->
            </td> --}}
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