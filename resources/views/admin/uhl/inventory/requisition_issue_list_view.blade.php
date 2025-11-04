<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
{{-- <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
{{-- <div class="modal-dialog modal-lg" role="document"> --}}
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Indent</h5>
        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> --}}
    </div>
    <div class="modal-body p-0">
        <div class="row">

            <div class="col-md-12">
                <div class="card mt-0">
                    <div class="card-body p-2">
                        {{-- <div class=""
                            style="border: 1px solid #dee2e6; height: 80px; padding: 10px; margin-top: 10px;">
                            <div class="patient-information d-flex align-items-center"> --}}
                        {{-- <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Name
                                                :</b>&nbsp;<span>
                                            </span>
                                        </li>

                                        <li><b>Department
                                                :</b>&nbsp;<span>
                                            </span>
                                        </li>
                                        <li><b>Delivery Location
                                                :</b>&nbsp;<span>
                                            </span>
                                        </li>
                                    </ul>
                                </div> --}}
                        {{-- <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">

                                        <li>

                                        </li>
                                        <li><b>Indent ID
                                                :</b>&nbsp;<span>

                                            </span>
                                        </li>

                                        <li><b>Date of Indent:</b>&nbsp;<span>

                                            </span>
                                        </li>
                                    </ul>
                                </div> --}}
                        {{-- </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center">SL#</th>
                <th class="text-center">Item Name</th>
                <th class="text-center">Item UoM</th>
                <th class="text-center">Req. Qty.</th>
                <th class="text-center">Issue. Qty.</th>
                <th class="text-center">Received Qty.</th>
                <th class="text-center">Product Spec.</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($my_requsition_items))
                @foreach ($my_requsition_items as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->item_name }}</td>
                        <td class="text-center">{{ $data->uom_code }}</td>

                        @if ($data->req_quantity == 0)
                            <td class="text-center">{{ '' }}</td>
                        @else
                            <td class="text-center">{{ $data->req_quantity }}</td>
                        @endif

                        @if ($data->issue_quantity == 0)
                            <td class="text-center">{{ '' }}</td>
                        @else
                            <td class="text-center">{{ $data->issue_quantity }}</td>
                        @endif

                        @if ($data->recv_quantity == 0)
                            <td class="text-center">{{ '' }} </td>
                        @else
                            <td class="text-center">{{ $data->recv_quantity }} </td>
                        @endif

                        @if ($data->item_remarks == 0)
                            <td class="text-center">{{ '' }}</td>
                        @else
                            <td class="text-center">{{ $data->item_remarks }}</td>
                        @endif

                        @if ($data->issue_ind == 1 && $data->recv_ind == 1)
                            <td class="text-center"><strong> All Process Completed </strong> </td>
                        @elseif ($data->issue_ind == 1 && $data->recv_ind == 0)
                            <td class="text-center"> <strong> Receive Pending </strong> </td>
                        @elseif ($data->issue_ind == 0 && $data->recv_ind == 1)
                            <td class="text-center"> <strong>Issue Pending</strong></td>
                        @else
                            <td class="text-center"> <strong>Issue Pending</strong></td>
                        @endif
                    </tr>
                @endforeach
            @endif

        </tbody>
        {{-- <tfoot>
            <tr>
                <td colspan="5" class="text-left">
                    <b> Special Instructions</b>: <br> --}}
        {{-- {{ @$my_requsition_items->indent_remarks }} --}}

        {{-- </td>
            </tr>

        </tfoot> --}}
    </table>


</div>
{{-- </div>
</div> --}}
{{-- <div class="modal-footer"> --}}
{{-- <button type="button" class="btn btn-primary uhl_save_btn">Save</button> --}}
<button type="button" class="btn btn-danger mt-2" data-dismiss="modal">Close</button>
{{-- </div> --}}

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
