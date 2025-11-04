<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
<style type="text/css">
    .table td,
    .table th {
        vertical-align: top;
    }
</style>
<div class="container-fluid">
    @php
        //dd($indents);
    @endphp
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Indent Worklist</h5>
            <small>Inventory / Indent Worklist</small>
        </div>
        {{-- <div class="col-md-3">
            <div id="top-action">
                <a rel="tab" href="{{ route('new_indent') }}" class="btn btn-outline-primary btn-md float-right"><i
                        class="fa fa-plus"></i>&nbsp;New Indent</a>

            </div>
        </div> --}}
    </div>
    {{-- <input type="hidden" id="tab_name" value="7"> --}}
    <div class="row">
        <div class="col-12">
            @if(isset($msg))
                <strong style="text-align: center; font-size: 20px;margin:0 auto; display:block; color: red;">{{$msg}}, Need HOD || Director || MD/Chairman Privilege. </strong>
                @php
                    exit;
                @endphp
            @endif
            {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab" id="indent-work-list-tab" data-toggle="tab"
                        href="#indent-work-list" role="tab" aria-controls="indent-work-list"
                        aria-selected="false">Indent Work List</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab" id="item-wise-indent-tab" data-toggle="tab" href="#item-wise-indent"
                        role="tab" aria-controls="item-wise-indent" aria-selected="false">Received by Item</a>
                </li>

            </ul> --}}

            {{-- <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="indent-work-list" role="tabpanel"
                    aria-labelledby="indent-work-list-tab"> --}}

            <div class="row">
                <div class="col-12 px-0">
                    {{-- <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form method="POST" action="{{ route('pharmacy_search_indent') }}"
                                        id="indent-search">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm" for="indent_no">Indent
                                                    No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="indent_no" name="indent_no" value="" placeholder="Indent No">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="indent_date_from">Indent Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_from" name="indent_date_from" value=""
                                                        placeholder="yyyy-mm-dd">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_to" name="indent_date_to" value=""
                                                        placeholder="yyyy-mm-dd">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-success btn-block btn-md mt-4"
                                                        onclick="generateSearch( this, 'indent-search', '{{ route('pharmacy_search_indent') }}', 'indent-list' )">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <a rel="tab" href="{{ route('pharmacy_indent_worklist') }}"
                                                        class="btn btn-info btn-block btn-md mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> --}}
                    <form action="{{ route('indent_verify') }}" method="post" id="indent_verify_item">
                        @csrf
                        <div class="card" id="indent-list">
                            <div class="card-body mt-3">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table data-table  table-striped table-bordered table-hover">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center">
                                                        SL
                                                    </th>
                                                    <th class="text-center">Item Code</th>
                                                    <th class="text-center">Item Name</th>
                                                    <th class="text-center">Item UoM</th>
                                                    <th class="text-center">Item Quantity</th>
                                                    <th class="text-center">Reject</th>


                                                    {{-- <th class="text-center">Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @php
                                                    $item_quantity = [];
                                                    $indent_no = [];
                                                @endphp --}}
                                          @if(isset($indent_items))


                                                @foreach ($indent_items as $indent)

                                             <input type ="hidden" name="indent_no[]" value="{{ $indent->inv_requisitiondtl_no_pk }}">
                                             <input type ="hidden" name="item_quantity[]" value="{{ $indent->req_quantity }}">

                                                <input type="hidden" name="hod_ind" value="{{ $users_ind->inv_hod_ind }}">
                                               <input type="hidden" name="admin_ind" value="{{ $users_ind->inv_auth_admin_ind }}">

                                               <input type="hidden" name="director_ind" value="{{ $users_ind->inv_auth_director_ind }}">

                                               <input type="hidden" name="md_ind" value="{{ $users_ind->inv_auth_chairman_ind }}">
                                                    {{-- @php
                                                        $item_quantity[] = $indent->req_quantity;
                                                        $indent_no[] = $indent->inv_requisitiondtl_no_pk;
                                                    @endphp --}}

                                                    <tr>
                                                        <td class="text-center" width="8%">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td class="text-center" width="8%">
                                                            {{ $indent->pvmsno }}</td>
                                                        <td class="text-left" width="11%">
                                                            {{ $indent->item_name }}
                                                            {{-- {{ isset($indent->inv_requisition_date) ? date('d-m-Y', strtotime($indent->inv_requisition_date)) : '' }} --}}
                                                        </td>
                                                        <td class="text-center" width="13%">
                                                            {{ $indent->uom_long }}

                                                        </td>
                                                        <td class="text-center" width="13%">
                                                            {{ $indent->req_quantity }}

                                                        </td>
                                                        <td class="text-center" width="13%">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="rejected_items_pk[]" value="{{ $indent->inv_requisitiondtl_no_pk }}" {{ isset($users_ind->inv_auth_admin_ind) ? ($indent->aproval_diradm_ind == 2 ? 'checked':''):''}} {{ isset($users_ind->inv_hod_ind) ? ($indent->aproval_hod_ind == 2 ? 'checked':''):''}} {{ isset($users_ind->inv_auth_director_ind) ? ($indent->aproval_dirhospital_ind == 2 ? 'checked':''):''}} {{ isset($users_ind->inv_auth_chairman_ind) ? ($indent->aproval_md_chairman_ind== 2 ? 'checked':''):''}} {{ isset($users_ind->inv_auth_chairman_ind) ? '':($check_md_ind==1 ? 'disabled':'') }}>
                                                            {{-- {{ $users_ind->inv_auth_chairman_ind == 1 ? '' : 'disabled' }} {{ $indent_items[0]->aproval_md_chairman_ind  ? 'checked':'' }}> --}}

                                                        </td>

                                                        {{-- <td class="text-center" width="11%">
                                                                <span Class="btn btn-sm btn-success open-modal"
                                                                data-action="{{ route('indent_item_details', $indent->inv_requisition_uid) }}" data-modal="common-modal-md" data-title="Indent Item Details" title="view"><i class="fa fa-eye"></i></span>

                                                            </td> --}}
                                                    </tr>
                                                @endforeach
                                            @endif


                                            </tbody>
                                        </table>
                                        <div class="modal-footer mt-1">
                                            {{-- <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Cancel</button> --}}

                                            @php
                                                $response_action = route('pharmacy_indent_worklist');
                                            @endphp
                                            <button class="btn btn-success btn-md"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            {{-- </div>

            </div> --}}
        </div>
    </div>
</div>
<div class="col-sm-12 col-lg-5 col-xl-12">



    {{-- <input type="hidden" name="hod_ind" value="{{ $users_ind->inv_hod_ind }}"> --}}

    <div class="row mt-3">
        <div class="col-md-6">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Created by </label>
                {{-- <input class="form-check-input" type="checkbox" name="hod_verify_ind" value="1"
                        {{ $users_ind->inv_hod_ind == 1 ? '' : 'disabled' }}> --}}
                {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}
                {{ isset($indent_items[0]) ?($indent_items[0]->req_by_name ):''}}


            </div>


        </div>
        {{-- <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <label class="form-check-label mr-3" for="verified_by">Name :</label>
                    {{ $users_ind->inv_hod_ind == 1 ? $user_name : '' }}

                </div>

                 $duty_area_ind == '1' ? 'checked' : '' >



            </div> --}}
        <div class="col-md-6">


            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Date and Time </label>
                {{ isset($indent_items[0]) ?(date('d/m/Y h:i A', strtotime($indent_items[0]->req_at))):'' }}

            </div>
            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}

        </div>

    </div>
    <div class="row mt-3">
        <div class="col-md-2">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Verified by(HOD)</label>
                {{-- <input class="form-check-input mb-4" type="checkbox" name="hod_verify_ind" value="1"
                    {{ $users_ind->inv_hod_ind == 1 ? '' : 'disabled' }}
                    {{ $indent_items[0]->aproval_hod_ind ? 'checked' : '' }}> --}}
                {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}
            </div>


        </div>
        <div class="col-md-4">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Name </label>
                {{ isset($indent_items[0]) ?($indent_items[0]->aproval_hod_ind ? $indent_items[0]->aproval_hod_name : ''):'' }}
            </div>

            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}



        </div>
        <div class="col-md-6">


            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Date and Time </label>
                {{ isset($indent_items[0]) ?($indent_items[0]->aproval_hod_ind ? date('d/m/Y h:i A', strtotime($indent_items[0]->aproval_hod_at)) : ''):'' }}
            </div>
            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}

        </div>

    </div>
    {{-- <div class="row mt-3">
        <div class="col-md-2">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Verified by(Admin)</label>
              
            </div>


        </div>
        <div class="col-md-4">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Name </label>
                {{isset($indent_items[0]) ?( $indent_items[0]->aproval_diradm_ind ? $indent_items[0]->aproval_diradm_name : ''):'' }}

            </div>

          



        </div>
        <div class="col-md-6">


            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Date and Time </label>
                {{ isset($indent_items[0]) ?($indent_items[0]->aproval_diradm_ind ? date('d/m/Y h:i A', strtotime($indent_items[0]->aproval_diradm_at)) : '' ):''}}

            </div>
            

        </div>

    </div> --}}
    <div class="row mt-3">
        <div class="col-md-2">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Verified by(Director)</label>
                {{-- <input class="form-check-input mb-4" type="checkbox" name="director_verify_ind" value="1"
                    {{ $users_ind->inv_auth_director_ind == 1 ? '' : 'disabled' }}
                    {{ $indent_items[0]->aproval_dirhospital_ind ? 'checked' : '' }}> --}}
                {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}
            </div>


        </div>
        <div class="col-md-4">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Name </label>
                {{ isset($indent_items[0]) ?($indent_items[0]->aproval_dirhospital_ind ? $indent_items[0]->aproval_dirhospital_name : ''):'' }}
            </div>

            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}



        </div>
        <div class="col-md-6">


            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Date and Time </label>
                {{ isset($indent_items[0]) ?($indent_items[0]->aproval_dirhospital_ind ? date('d/m/Y h:i A', strtotime($indent_items[0]->aproval_dirhospital_at)) : '' ):''}}

            </div>
            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}

        </div>

    </div>
    <div class="row mt-3">
        <div class="col-md-2">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Verified by(MD)</label>
                {{-- <input class="form-check-input mb-4" type="checkbox" name="md_verify_ind" value="1"
                    {{ $users_ind->inv_auth_chairman_ind == 1 ? '' : 'disabled' }}
                    {{ $indent_items[0]->aproval_md_chairman_ind ? 'checked' : '' }}> --}}
                {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}
            </div>


        </div>
        <div class="col-md-4">

            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Name </label>
                {{isset($indent_items[0]) ?( $indent_items[0]->aproval_md_chairman_ind ? $indent_items[0]->aproval_md_chairman_name : ''):'' }}

            </div>

            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}



        </div>
        <div class="col-md-6">


            <div class="form-check form-check-inline">
                <label class="form-check-label mr-3" for="verified_by">Date and Time </label>
                {{ isset($indent_items[0]) ?($indent_items[0]->aproval_md_chairman_ind ? date('d/m/Y h:i A', strtotime($indent_items[0]->aproval_md_chairman_at)) : ''):'' }}

            </div>
            {{-- {{ $duty_area_ind == '1' ? 'checked' : '' }}> --}}

        </div>

    </div>



</div>

{{-- <di class="form-row mb-2">
    <div class="col-md-4">

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="duty_area" id="duty_area" value="1"
                {{ $duty_area_ind == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="duty_area">Duty Area</label>
        </div>
    </div>
    <div class="col-md-4">

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="external_hospital" id="external_hospital"
                value="1" {{ $external_hosp_su_ind == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="external_hospital">External Hospital</label>
        </div>
    </div> --}}



{{-- <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
{{-- <script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script> --}}
<script>
    // $(document).ready(function() {
    // function checkedValue(this) {
    //     alert(this.value);
    // }
    // var table = $('.indent-item-details').DataTable({
    //         "ordering": false,
    //         "bPaginate": false,
    //         "bLengthChange": false,
    //         "bAutoWidth": false
    //     });

    // $.fn.dataTable.ext.search.push(
    //     function(settings, searchData, index, rowData, counter) {

    //         var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
    //             return this.value;
    //         }).get();


    //         if (offices.length === 0) {
    //             return true;
    //         }
    //         var tblindex = $('#tab_name').val()

    //         if (offices.indexOf(searchData[tblindex]) !== -1) {
    //             return true;
    //         }

    //         return false;
    //     }
    // );

    // var table = $('.datatable').DataTable({
    //     "ordering": false,
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bAutoWidth": false
    // });


    // $('input:checkbox').on('change', function() {
    //     table.draw();

    // });
    // $(document).on('click', '.page-tab', function(e) {
    //     e.preventDefault()

    //     if ($(this).attr('id') == 'indent-work-list-tab') {
    //         $('#tab_name').val(7)
    //     }
    //     if ($(this).attr('id') == 'item-wise-indent-tab') {
    //         $('#tab_name').val(12)
    //     }
    //     table.draw();
    // })

    // $('.date_picker').datepicker({
    //     format: 'yyyy-mm-dd',
    //     autoclose: true,
    //     todayHighlight: true,
    //     clearBtn: true,
    // });
    // $(document).on('click', '.receive-btn', function(e) {
    //     e.preventDefault()
    //     // alert(1);
    //     var response_action = "{{ route('pharmacy_indent_worklist') }}"
    //     var elem = $(this).closest('tr').find('input.number_only')[0]
    //     var receive_qty = parseInt($(elem).val())
    //     var max_limit = parseInt($(this).attr('data-indentqty'))
    //     var pk = $(this).attr('data-pk')
    //     var rcv_qty = $(this).attr('data-rcv')
    //     var issued_qty = $(this).attr('data-issued')

    //     var transfer_no = $(this).attr('data-in_transref_no');
    //     var transfer_date = $(this).attr('data-in_transref_date');
    //     var stock_store_to = $(this).attr('data-in_stock_su_no_fk');
    //     var stock_store_from = $(this).attr('data-in_stock_su_no_fk_from');
    //     var item_no_fk = $(this).attr('data-in_item_no_fk');

    //     if (isNaN(receive_qty)) {
    //         alert('Receive quantity is required.');
    //         e.stopImmediatePropagation()
    //         return false;
    //     }
    //     if (rcv_qty == issued_qty) {
    //         alert('Issue quantity is not available.');
    //         e.stopImmediatePropagation()
    //         return false;
    //     }
    //     if (receive_qty > max_limit) {
    //         alert('Receive quantity cannot be greater than Issue Quantity. \n Receive Balance is ' +
    //             max_limit);
    //         e.stopImmediatePropagation()
    //         return false;
    //     }
    //     if (receive_qty <= 0) {
    //         alert('Receive quantity cannot be or zero or negative');
    //         e.stopImmediatePropagation()
    //         return false;
    //     }
    //     if (!confirm("Are you sure?")) {
    //         return false
    //     }
    //     var data = {
    //         received_quantity: $(elem).val(),
    //         pk: pk,
    //         in_transref_no: transfer_no,
    //         in_transref_date: transfer_date,
    //         in_stock_su_no_fk_to: stock_store_to,
    //         in_stock_su_no_fk_from: stock_store_from,
    //         in_item_no_fk: item_no_fk
    //     }

    //     $.ajax({
    //         async: true,
    //         data: data,
    //         url: "{{ route('update_indent') }}",
    //         type: 'post',
    //         beforeSend: function() {
    //             if (isAModalOpen)
    //                 $('.modal').modal('hide');
    //             blockUI();
    //         },
    //         success: function(data) {
    //             if (data.title == 'Success') {
    //                 $('.common-modal-notify').modal('show');
    //                 $('.common-modal-notify .modal-body').html(
    //                     "<i class='fas fa-stroopwafel fa-spin'></i>");
    //                 $('.common-modal-notify .modal-title').html(data.title);
    //                 $('.common-modal-notify .modal-body').html(data.msg);
    //             }
    //         },
    //         error: function(data) {
    //             var errors = jQuery.parseJSON(data.responseText).errors;
    //             error_messages = "";
    //             for (messages in errors) {
    //                 var field_name = $("#" + messages).siblings("label").html();
    //                 error_messages += "<div class='alert alert-danger' role='alert'>" +
    //                     errors[messages] + "</div>";
    //             }

    //             $('.common-modal-notify-error').modal('show');
    //             $('.common-modal-notify-error .modal-title').html("Validation Error");
    //             $('.common-modal-notify-error .modal-body').html(error_messages);

    //             $.unblockUI();
    //         }
    //     }).done(function() {
    //         $.unblockUI();
    //         dynamicFunc.afterSaveLoadPage(response_action);
    //     });
    //     e.stopImmediatePropagation();
    // })
    // })
</script>
