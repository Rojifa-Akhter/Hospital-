<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr class="global-uhl-table-bg">
            <th>Sl.</th>
            <th>Requisition No</th>
            <th>Requisition Date</th>
            <th>Patient Id</th>
            <th>Admission No / Date</th>
            <th>Name</th>
            <th>Age</th>
            <th>Bed / Cabin Name</th>
            <th>BG</th>
            <th>Blood Bag Qty</th>
            <th>Transmission Date</th>
            <th>Donor Type</th>
            <th>Doctor Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($blood_requisition_data))
        @foreach($blood_requisition_data as $value)
        <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td style="text-align: center;">{{$value->requsition_no_pk}}</td>
            <td>{{$value->au_entry_at !="" ? date('d/m/Y',strtotime($value->au_entry_at)) : ''}}</td>
            <td>{{$value->patient_code}}</td>
            <td>{{$value->admission_no_fk}}, {{$value->admission_date !="" ?
                date('d/m/Y',strtotime($value->admission_date))
                : ''}}
            </td>
            <td>{{$value->patient_name}}</td>
            <td style="text-align: center;">{{$value->patient_age}}</td>
            <td>{{$value->bed_cabin_name}}</td>
            <td style="text-align: center;">{{$value->blood_group}}</td>
            <td style="text-align: center;">{{$value->blood_bag_qty}}</td>
            <td>{{$value->trensmission_date !="" ? date('d/m/Y',strtotime($value->trensmission_date)):''}}</td>
            {{-- <td>{{$value->donor_name}}</td> --}}
            <td>{{$value->lookupdata_code }}</td>
            <td>{{$value->doctor_name}}</td>
            <td style="width: 200px;">
                <span class="btn btn-sm btn-outline-primary open-modal" data-id=""
                    data-action="{{route('ipd.edit-blood-bank-requisition',$value->requsition_no_pk)}}"
                    data-modal="common-modal" data-title="Edit Blood Bank Requisition" title="Edit"><i
                        class="fa fa-pencil-alt"></i></span>
                <span class="btn btn-sm btn-outline-success open-modal" data-id=""
                    data-action="{{route('ipd.add-donor-cross-match',$value->requsition_no_pk)}}"
                    data-modal="common-modal" data-title="Add Donor" title="Add Donor">Add Donor</span>

                <span class="btn btn-sm btn-outline-info open-modal" data-id=""
                    data-action="{{route('ipd.blood-bank-requisition-donor-list',$value->requsition_no_pk)}}"
                    data-modal="common-modal" data-title="Donor List" title="Donor list"> Donor List</span>
                <a href="{{route('ipd.pdf-blood-bank-requisition',$value->requsition_no_pk)}}" title="requisition pdf"
                    target="_blank"><i class="fa fa-file-pdf"></i></a>
                <input type="hidden" class="requisition_data" value="{{ $value->requsition_no_pk }}"
                    name="requsition_no_pk" id="requsition_no_pk">
                @if (Session::get('user.ses_hospital_code') == "UNICO")  
                    <input type="text" class="form-control form-control-sm m-0 mt-1" id="donor_id{{$value->requsition_no_pk}}"
                        name="donor_id{{ $value->requsition_no_pk }}" placeholder="Donor ID" autocomplete="off">
                    <input type="hidden" id="hidden_donor_id{{ $value->requsition_no_pk }}"
                        name="hidden_donor_id{{ $value->requsition_no_pk }}" class="donor_data">
                    <button type="button" class="btn btn-success btn-sm btn-md-global save_button mt-1">Save</button>
                  @endif
                </form>
            </td>
        </tr>
    </tbody>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDonorAutocomplete('#donor_id' + <?php echo json_encode($value->requsition_no_pk); ?>, 'hidden_donor_id'+ <?php echo json_encode($value->requsition_no_pk); ?>,'donor_name');
   
    $(document).on("click", ".save_button", function(e) { 
        let $row = $(this).closest('tr'); 
        let donor_id = $row.find('.donor_data').val(); 
        let requisition_id = $row.find('.requisition_data').val(); 
        console.log(donor_id, requisition_id);
        $.ajax({
            url: "{{ route('ipd.save-blood-bank-patient-donor-info') }}",
            type: 'POST',
            data: {
                donor_id: donor_id,
                requisition_id: requisition_id,
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                if (data.title == "Success") {
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-body").html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $(".common-modal-notify .modal-title").html(data.title);
                    $(".common-modal-notify .modal-body").html(data.msg);
                } else {
                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        data.title
                    );
                    $(".common-modal-notify-error .modal-body").html(data.msg);
                }
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
@endforeach
@endif
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