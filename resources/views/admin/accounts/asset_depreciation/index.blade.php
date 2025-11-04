<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    #total_amount:disabled {
        cursor: not-allowed;
        color: #333;
    }

    #btnSave {
        transition: all 0.2s ease-in-out;
    }

    #btnSave:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 128, 0, 0.2);
    }
</style>

<section id="full_appointment">
    <div class="container-fluid pb-4">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Fixed Asset Depreciation</h5>
                <small>Accounts / Asset Depreciation</small>
            </div>
            @php
                $invoice_ref_edit_ind = Session::get('user.ses_invoice_ref_edit_ind');
                $hospital_code = Session::get('user.ses_hospital_code');
            @endphp
        </div>
        <input type="hidden" name="invoice_ref_edit_ind" id="invoice_ref_edit_ind" value="{{ $invoice_ref_edit_ind }}">

        <input type="hidden" name="hospital_code" id="hospital_code"
            value="{{ Session::get('user.ses_hospital_code') }}">

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post" action="#">
                    @csrf

                    <input type="hidden" id="page-view-type" name="page_view_type">

                    <div class="form-group form-row">
                        <div class="col-sm-4">
                            <label for="category">Category</label>
                            <select class="form-control select2" id="category" name="category">
                                <option value="">Select Category</option>
                                @if (isset($categories))
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->catagory_no_fk }}">{{ $value->catagory }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="sub_category">Sub Category</label>
                            <select class="form-control select2" id="sub_category" name="sub_category">
                                <option value="">Select Sub Category</option>
                                @if (isset($sub_categories))
                                    @foreach ($sub_categories as $value)
                                        <option value="{{ $value->itemtype_no_pk }}">{{ $value->sub_catagory }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <div class="d-flex" style="gap: 10px">
                                <button type="button" class="btn btn-success btn-md btn-md-global"
                                    id="btnSearchReport">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>

                                <button type="reset" class="btn btn-info btn-md btn-md-global" id="btnReset"
                                    onclick="window.location.reload();">
                                    <i class="fa fa-redo"></i>
                                    Reset
                                </button>

                                <button type="button" class="btn btn-primary btn-md btn-md-global" id="btnPdfReport">
                                    <i class="fa fa-file-excel"></i>
                                    Export Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-row align-items-end mt-3">
                        <!-- Total Amount -->
                        <div class="col-sm-6 col-md-4">
                            <label for="total_amount" class="font-weight-bold mb-1">Total Amount</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <span class="text-success">৳</span>
                                </span>
                                <input type="text" class="form-control border-start-0" id="total_amount"
                                    name="total_amount" placeholder="Total Amount" title="Total Amount" disabled
                                    style="background-color: #f9f9f9 !important; font-weight: 600;" />
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="col-sm-6 col-md-4 mt-3 mt-sm-0">
                            <button type="button" class="btn btn-success btn-md btn-md-global w-100 shadow-sm"
                                id="btnSave">
                                <i class="fa fa-save me-1"></i> Save Depreciation
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mt-2 mb-0">Asset Depreciation List</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="assetDepreciationList">
                    @include('admin.accounts.asset_depreciation.asset_depreciation_list')
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
@php
    $p_route = isset($row->patient_no_pk) ? route('patient-card', $row->patient_no_pk) : '#';
@endphp

<script>
    openInvoiceAutocomplete("#app_date");

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $('.select2').select2();
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var edit_ind = "";

    $(document).ready(function() {
        $('body').on('click', '#btnSearchReport', function() {
            let category_id = $('#category').val();
            let sub_category_id = $('#sub_category').val();

            if (!sub_category_id && !category_id) {
                alert("Please Select Category or Sub Category !");
                return;
            }

            $.ajax({
                url: "{{ route('asset-depreciations.search') }}",
                type: "POST",
                data: {
                    category_id: category_id,
                    sub_category_id: sub_category_id,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data);
                    $("#assetDepreciationList").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        $('#category').on('change', function() {
            let category_id = $(this).val();

            if (!category_id) {
                $('#sub_category').html('<option value="">Select Sub Category</option>').trigger(
                    'change');
                return;
            }

            $.ajax({
                url: "{{ route('get-sub-category-by-category') }}",
                type: "POST",
                data: {
                    category_id: category_id,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    let options = '<option value="">Select Sub Category</option>';
                    $.each(data.sub_categories, function(index, item) {
                        options +=
                            `<option value="${item.itemtype_no_pk}">${item.sub_catagory}</option>`;
                    });
                    $('#sub_category').html(options).trigger('change');
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        $('#btnPdfReport').on('click', function() {
            window.open("asset-depreciations/excel", "_blank");
        });
    });
</script>
