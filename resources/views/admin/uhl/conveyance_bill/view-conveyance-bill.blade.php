<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="" method="post" id="">
    @csrf
    {{-- <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
    {{-- <div class="modal-dialog modal-lg" role="document"> --}}
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Conveyance Request</h5>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
        </div>
        <div class="modal-body p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-0">
                        <div class="card-body p-2">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</form>

<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-left">SL</th>
            {{-- <th class="text-left">UID</th> --}}
            <th class="text-left">Trip Date</th>
            <th class="text-left">Transport Name</th>
            <th class="text-left">From</th>
            <th class="text-left">To</th>
            <th class="text-left">Purpose</th>
            <th class="text-left">Address</th>
            <th class="text-left">Remarks</th>
            <th class="text-left">Amount</th>
            <th class="text-center">Attachment 1</th>
            <th class="text-center">Attachment 2</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($view_data))
            @foreach ($view_data as $key => $value)
                <tr>
                    <td class="text-left">{{ $value->trip_sl }}</td>
                    {{-- <td class="text-left">{{ $value->conveyancebillmst_uid }}</td> --}}
                    <td class="text-left">
                        @if (!empty($value->conveyance_date))
                        {{ date('d-m-Y', strtotime($value->conveyance_date)) }}
                        @endif       
                    </td>
                    <td class="text-left">{{ $value->transport_name }}</td>
                    <td class="text-left">{{ $value->from_location }}</td>
                    <td class="text-left">{{ $value->to_location }}</td>
                    <td class="text-left">{{ isset($value->purpose_name) ? $value->purpose_name : '' }}</td>
                    <td class="text-left">{{ $value->description }}</td>
                    <td class="text-left">{{ $value->remarks }}</td>
                    <td class="text-left">{{ $value->amount }}</td>
                    <td class="text-center">
                        @if (isset($value->attachment_name_01))
                            <a href="{{ asset('uploads/conveyance_bill/' . $value->attachment_name_01) }}"
                                target="_blank"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                        @endif
                    </td>
                    <td class="text-center">
                        @if (isset($value->attachment_name_02))
                            <a href="{{ asset('uploads/conveyance_bill/' . $value->attachment_name_02) }}"
                                target="_blank"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach

        @endif

    </tbody>

</table>


</div>
{{-- </div> --}}
{{-- </div> --}}

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    });
</script>
