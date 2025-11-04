@php
$approval_ind = isset($approval_ind) ? $approval_ind : 0;

@endphp
<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive">
            <form action="{{ route('comparative-statement-approval.store') }}" method="post"
                id="comparative-statement-approval">
                @csrf
                @php
                    $response_url = route('comparative-statement-approval.index');
                @endphp
                <table class="table datatable table-striped table-bordered table-hover">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center">
                                SL
                            </th>
                            <th class="text-center">Requistion No</th>
                            <th class="text-center">Prepared Date</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Specification</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Estimated Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"> <button class="btn btn-success btn-sm"
                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')"
                                    type="button">Approval</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($comparative_statement_list))
                            @foreach ($comparative_statement_list as $indent)
                                @php
                                    $item_info = DB::table("sysc_serviceitem")->where('item_no_pk', $indent->item_no_fk)->first();
                                @endphp
                                <tr>

                                    <input type="hidden" name='requisition_id_{{ $indent->comparative_no_pk }}'
                                        value="{{ $indent->requisition_code }}">
                                    <input type="hidden" name='supplier_id_{{ $indent->comparative_no_pk }}'
                                        value="{{ $indent->supplier_no_fk }}">
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-center">
                                        {{ $indent->requisition_code }}</td>
                                    <td class="text-left">
                                        {{ isset($indent->au_entry_at) ? date('d/m/Y', strtotime($indent->au_entry_at)) : '' }}
                                    </td>
                                    <td class="text-left">
                                        {{ $indent->supplier_name }}
                                    </td>
                                    <td class="text-left">
                                        {{ $indent->item_name }}
                                    </td>
                                    <td class="text-left">
                                        {{ $item_info->item_code }}
                                    </td>
                                    <td class="text-left">
                                        {{ $indent->approval_qty_amt }}
                                    </td>
                                    <td class="text-left">
                                        {{ $indent->supplier_amt }}
                                    </td>
                                    <td class="text-center">
                                        @if ($indent->approved_ind == 1)
                                            Approved
                                        @elseif ($indent->passed_ind == 1)
                                            Passed
                                        @elseif ($indent->prepared_ind == 1)
                                            Prepared
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if (Session::get('user.inv_auth_director_ind') == 1)
                                            @if ($indent->approved_ind == 1)
                                                <input type="checkbox" name="requisition_id[]"
                                                    value="{{ $indent->comparative_no_pk }}" checked disabled>
                                            @elseif ($indent->passed_ind == 1)
                                                <input type="checkbox" name="requisition_id[]"
                                                    value="{{ $indent->comparative_no_pk }}"
                                                    {{ !empty(@$approve_ind->approved_ind == 1) ? ' disabled' : '' }}>
                                            @elseif ($indent->prepared_ind == 1)
                                                <input type="checkbox" name="requisition_id[]"
                                                    value="{{ $indent->comparative_no_pk }}"
                                                    {{ !empty(@$approve_ind->approved_ind == 1) ? ' disabled' : '' }}>
                                            @endif
                                        @else
                                            @if ($indent->approved_ind == 1)
                                                <input type="checkbox" name="requisition_id[]"
                                                    value="{{ $indent->comparative_no_pk }}" checked disabled>
                                            @elseif ($indent->passed_ind == 1)
                                                <input type="checkbox" name="requisition_id[]"
                                                    value="{{ $indent->comparative_no_pk }}" {{ !empty(@$approve_ind->approved_ind == 1) ? ' disabled' : 'checked' }}>
                                            @elseif ($indent->prepared_ind == 1)
                                                <input type="checkbox" name="requisition_id[]"
                                                    value="{{ $indent->comparative_no_pk }}"  {{ !empty(@$approve_ind->approved_ind == 1) ? ' disabled' : '' }}>
                                            @endif
                                        @endif

                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </form>

        </div>
    </div>
</div>
