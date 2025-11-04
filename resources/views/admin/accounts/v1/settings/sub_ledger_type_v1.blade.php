<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Sub Ledger Type</h5>
                            <small>Accounts / Sub Ledger Type</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="subLedgerTypeSave" class="subLedgerTypeSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label for="sub_ledger_type_name" class="col-sm-4 col-form-label">
                                                Sub Ledger Type Name <span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="sub_ledger_type_name" 
                                                    name="sub_ledger_type_name" placeholder="Sub Ledger Type Name" value="" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label for="sub_ledger_type_code" class="col-sm-4 col-form-label">
                                                Sub Ledger Code <span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="sub_ledger_type_code" 
                                                    name="sub_ledger_type_code" placeholder="Sub Ledger Code" value="" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label for="debit_account" class="col-sm-4 col-form-label">
                                                Debit Account <span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="select2" id="debit_account" name="debit_account" required>
                                                    <option value="">Select Debit Account</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->account_no_pk }}">
                                                            {{ $account->account_code }} - {{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label for="credit_account" class="col-sm-4 col-form-label">
                                                Credit Account <span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="select2" id="credit_account" name="credit_account" required>
                                                    <option value="">Select Credit Account</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->account_no_pk }}">
                                                            {{ $account->account_code }} - {{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control custom_area" id="notes" rows="3" name="notes" placeholder="Notes"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group row mt-3">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" value="1" id="status" name="status"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="subLedgerTypeSaveForm()">Save</button>
                                        </li>

                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover subledger_type_v1">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Sub Ledger Type Name</th>
                                            <th class="text-center">Sub Ledger Code</th>
                                            <th class="text-center">Dr Account</th>
                                            <th class="text-center">Cr Account</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>

    $("#credit_account").select2({
        placeholder: "Select Credit Account",
        allowClear: true
    });

    $("#debit_account").select2({
        placeholder: "Select Debit Account",
        allowClear: true
    });
    
    $(document).on('change', '.select2', function(e) {
        $(this).valid(); 
    });

    $("#subLedgerTypeSave").validate({
        errorElement: "em",
        errorPlacement: function (error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                element.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                error.insertAfter(element.next('.select2-container'));
            } else {
                element.addClass("is-invalid");
                error.insertAfter(element);
            }
        },
        success: function (label, element) {
            const $element = $(element);

            if ($element.hasClass('select2-hidden-accessible')) {
                $element.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            } else {
                $element.removeClass("is-invalid");
            }

            label.remove();
        },
        rules: {
            sub_ledger_type_name: {
                required: true,
                minlength: 5,
                maxlength: 50,
                notOnlySpaces: true
            },
            sub_ledger_type_code: {
                required: true,
                minlength: 1,
                maxlength: 50,
                notOnlySpaces: true
            },
            notes: {
                maxlength: 500,
            }
        },
        messages: {
            sub_ledger_type_name: {
                required: "Sub Ledger Type Name Required",
            },
            sub_ledger_type_code: {
                required: "Sub Ledger Type Code Required",
            }
        }
    });

</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $(document).ready(function(){
            getSubLedgerType();
            function getSubLedgerType(){
                    $.ajax({
                    url: "{{route('v1.accounts.get-sub-ledger-type')}}",
                    method: "get",
                    success: function(response){
                        if(response.data.length != 0)
                        setTableData(response.data);
                        else
                        emptyTable();
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
            }

            $('.subledger_type_v1').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 5, 6], className: 'text-center' },
                        { targets: [1, 2, 3, 4,], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center')

        })

       function subLedgerTypeSaveForm(){
            if($('#subLedgerTypeSave').valid()){ 
                let formElement = document.querySelector('#subLedgerTypeSave');
                let formData = new FormData(formElement);
                // console.log('form data',formData);
                $.ajax({
                    url:"{{route('v1.accounts.save-sub-ledger-type')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){

                        if(data.data.length != 0)
                        setTableData(data.data);   

                        $('#subLedgerTypeSave').trigger('reset');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        // console.log('error',err.message);
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                    $.unblockUI();
                }
                });
            }
        }
        // Update Sub Ledger Type
        function subLedgerTypeNameFunc(){           
            $.ajax({
                    url: "{{route('v1.accounts.get-sub-ledger-type')}}",
                    method: "get",
                    success: function(response){
                        if(response.data.length != 0)
                        setTableData(response.data);
                        else
                        emptyTable();
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
        }

        function setTableData(data){
            $('.subledger_type_v1 tbody').empty();
            var rows = [];
            var table = $('.subledger_type_v1').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    item.subledgertype_name,
                    item.subledgertype_code,
                    item.dr_account_name,
                    item.cr_account_name,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-sub-ledger-type-name','')}}/'+item.acct_subledger_typeno_pk+'" data-modal="common-modal-sm" data-title="Edit Sub Ledger Type Name" title="Edit Sub Ledger Type Name" data-id="'+item.acct_subledger_typeno_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }

        function emptyTable(){
            $('.subledger_type_v1 tbody').empty();
            $('.subledger_type_v1 tbody').append(`
                <tr>
                    <td colspan="5" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>