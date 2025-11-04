<table class="table table-bordered table-hover table-striped" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th>SL#</th>
            <th>Asset Tag</th>
            <th>Tag date</th>
            <th>Asset Age</th>
            <th>Asset ID</th>
            <th>Asset Name</th>
            <th>Supplier Name</th>
            <th>Sl No.</th>
            <th>Description</th>
            <th>PO No.& GRN No.</th>
            <th>Main Store</th>
            {{-- <th>Asset Type</th> --}}
            <th>Major Group</th>
            <!-- <th>Tax Code</th> -->
            <th>Minor Group</th>
            {{-- <th>Depreciation Years</th> --}}

            <th>GRN Date</th>
            <th>Installation Date</th>
            <th>Quantity</th>
            <th>Current Location </th>
            <th>Last Location</th>
            <th>Under Department</th>
            <th>Person Incharge</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ dd($asset_register_data_arr) }} --}}
        @if (!empty($asset_register_data_arr))
            @foreach ($asset_register_data_arr as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @php
                            $head = $value->item_type_name != '' ? '/' . $value->item_type_name : '';
                            $department = $value->serviceunit_code != '' ? '/' . $value->serviceunit_code : '';
                        @endphp
                        {{-- {{ $value->asset_tag_uid }} --}}
                        {{ Session::get('user.ses_hospital_code') . $head . $department . '/' . $value->asset_tag_uid }}
                    </td>
                    <td>{{ $value->asset_tag_at != '' ? date('d/m/Y', strtotime($value->asset_tag_at)) : '' }}</td>
                    <td style="width:100px">
                        <?php
                        $currentDateTime = date('Y-m-d H:i:s');
                        $currentDateTime = new DateTime($currentDateTime);
                        $grndatetime = new DateTime($value->receive_date);
                        $interval = $currentDateTime->diff($grndatetime);
                        $years = $interval->y;
                        $months = $interval->m;
                        $days = $interval->d;
                        ?>
                        {{ $days . 'D ' . $months . 'M ' . $years . 'Y' }}
                    </td>
                    <td>{{ $value->item_code }}</td>
                    <td>{{ $value->item_name }}</td>
                    <td>{{ $value->supplier_name }}</td>
                    <td>{{ $value->item_serial_number }}</td>
                    <td>{{-- {{ $value->refer_item_specification ? $value->refer_item_specification : 'N/A'}} --}}
                        @if (isset($value->refer_item_specification))
                            <a data-toggle="modal" data-target="#descriptionModal{{ $loop->iteration }}" style="color: #3490dc;"
                                class="description_val" title="Show Detail">
                                {{ strlen($value->refer_item_specification) > 20 ? substr($value->refer_item_specification, 0, 20) . '...' : $value->refer_item_specification }}
                            </a>
                            {{-- Description detail modal --}}
                            <div class="modal fade" id="descriptionModal{{ $loop->iteration }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="descriptionModal{{ $loop->iteration }}">Description
                                                Detail
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="white-space: pre-line; padding: 0px 20px !important; ">
                                            <p style="margin-bottom: 0px !important">
                                                {{ isset($value->refer_item_specification) ? $value->refer_item_specification : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td style="">
                        @if ($value->po_no)
                            PO: <a href="{{ route('v1.purchase-order-print', $value->po_no) }}" target="_blank"
                                title="Show PO Report">{{ $value->po_no }}</a>
                            @if (isset($value->po_doc_attachment_path) || isset($value->pr_doc_attachment_path))
                                @if (isset($value->pr_doc_attachment_path))
                                    <a href="{{ asset('/images/uploads/attachment/' . $value->pr_doc_attachment_path) }}"
                                        target="_blank" class="btn btn-sm btn-success" title="Show PR File"><i
                                            class="fas fa-file"></i></a>
                                @endif
                                @if (isset($value->po_doc_attachment_path))
                                    <a href="{{ asset('/images/uploads/attachment/' . $value->po_doc_attachment_path) }}"
                                        target="_blank" class="btn btn-sm btn-success" title="Show PO File"><i
                                            class="fas fa-file"></i></a>
                                @endif
                            @endif
                            <br>
                        @else
                            PO: N/A<br>
                        @endif
                        @if ($value->itemreceive_no_pk)
                            GRN: <a href="{{ route('v1.grn-report-print', $value->itemreceive_no_pk) }}" target="_blank"
                                title="Show GRN Report">{{ $value->itemreceive_no_pk }}</a><br>
                        @else
                            GRN: N/A<br>
                        @endif
                    </td>
                    {{-- <td>{{ $value->current_store }}</td> --}}
                    <td>{{ 'Asset Store' }}</td>
                    {{-- <td>N/A</td> --}}
                    <td>{{ $value->par_item_type_name }}</td>
                    <td>{{ $value->ity_group_header_name }}</td>
                    <!-- <td>{{ $value->taxcode_name }}</td> -->
                    {{-- <td> N/A</td> --}}
                    <td style=""> {{ $value->receive_date != '' ? date('d/m/Y', strtotime($value->receive_date)) : '' }}
                    </td>
                    <td style="">

                        {{ $value->capital_in_progress_ind == 1 ? ($value->install_date ? date('d/m/Y', strtotime($value->install_date)) : 'Capital in progress') : '' }}
                    </td>
                    <td class="text-center">1</td>
                    <td>{{ !empty($value->current_room) ? $value->current_room : 'Asset Store' }}
                        @if (!empty($value->current_room))
                            <strong>{{ !empty($value->currentphysicalstruct_name_fl_bld) ? $value->currentphysicalstruct_name_fl_bld : '' }}</strong>
                        @endif
                    </td>
                    <td>
                        {{ !empty($value->last_location) && !empty($value->current_room) ? $value->last_location : (empty($value->last_location) && empty($value->current_room) ? ' ' : 'Asset Store') }}
                        @if (!empty($value->last_location))
                            <strong>{{ !empty($value->physicalstruct_name_fl_bld) ? '[' . $value->physicalstruct_name_fl_bld . ']' : '' }}</strong>
                        @endif
                    </td>
                    <td>{{ $value->person_department }}</td>
                    <td>{{ $value->full_name }}</td>
                    <td style="">
                        <!-- <button type="button" class="btn btn-success btn-md-global" data-toggle="modal" data-target="#exampleModal" style="font-size: 12px; border:0;">Detail</button> -->

                        <a href="{{ route('v1.print-generate-tag', $value->ast_register_no_pk) }}" class="mb-1"
                            target="_blank" title="Print Tag"><i class="fas fa-print"></i></a>

                        <span class="btn btn-success btn-sm btn-md-global open-modal btnView mb-1"
                            data-action="{{ route('v1.create_asset_details_popup', $value->ast_register_no_pk) }}"
                            data-modal="common-modal-md" data-title="Asset Details" title="Asset Details"
                            data-id="{{ $value->ast_register_no_pk }}">Details</span>

                        <span class="btn btn-md btn-success btn-md-global open-modal btnView"
                            data-action="{{ route('v1.asset_register_update_popup', $value->ast_register_no_pk) }}"
                            data-modal="common-modal-xl" data-title="Update" title="Update"
                            data-id="{{ $value->ast_register_no_pk }}"><i class="fas fa-pen"></i></span>

                        <!-- <button type="button" class="btn btn-primary btn-md-global" data-toggle="modal" data-target="#exampleModal2" style="font-size: 12px; border:0;">Transfer</button> -->

                        <span class="btn btn-primary btn-sm btn-md-global open-modal btnView"
                            data-action="{{ route('v1.create_transfer_popup', [$value->ast_register_no_pk, $value->itemreceivedtl_no_pk]) }}"
                            data-modal="common-modal-sm" data-title="Set Location" title="Set Location"
                            data-id="{{ $value->ast_register_no_pk }}">Set Location</span>

                        <a href="{{ route('v1.print-equipment-detail', $value->ast_register_no_pk) }}" class="mb-1 text-info"
                            target="_blank" title="Print Detail Info"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            @endforeach

        @endif
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                // { targets: [0, 5, 6, 7], className: 'text-center' },
                // { targets: [1, 2, 3, 4], className: 'text-left' }
            ],
            "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            "pageLength": 10
        });
        $('th').addClass('text-center');
    });
</script>
