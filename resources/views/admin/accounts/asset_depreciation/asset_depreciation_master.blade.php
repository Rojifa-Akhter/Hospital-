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
                <h5 class="mt-2 mb-0">Asset Depreciation Master</h5>
                <small>Accounts / Asset Depreciation Master</small>
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
                        {{-- <div class="col-sm-4">
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
                        </div> --}}

                        <div class="col-sm-4">
                            <label for="date_from">From Date</label>
                            <input type="text" class="form-control date_picker" name="date_from" id="date_from"
                                placeholder="From Date" autocomplete="off" />
                        </div>

                        <div class="col-sm-4">
                            <label for="date_to">To Date</label>
                            <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                placeholder="To Date" autocomplete="off" />
                        </div>

                        <div class="col-sm-4 mt-4" style="">
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

                                {{-- <button type="button" class="btn btn-primary btn-md btn-md-global" id="btnPdfReport">
                                    <i class="fa fa-file-pdf"></i>
                                    Export PDF
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mt-2 mb-0">Asset Depreciation Master List</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="assetDepreciationList">
                    <table class="table table-bordered table-hover table-striped w-100" id="dataTable">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>SL</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                                {{-- <th>Location</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($assetDepreciationMasters))
                                @foreach ($assetDepreciationMasters as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-right">{{ number_format($value->dep_amount, 2) }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($value->tran_date)) }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm btn-md-global"
                                                title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                // { targets: [0, 5, 6, 7], className: 'text-center' },
                // { targets: [1, 2, 3, 4], className: 'text-left' }
            ],
            "lengthMenu": [
                [500, 600, 700, 800, 900, 1000, -1],
                [500, 600, 700, 800, 900, 1000, "All"]
            ],
            "pageLength": 500
        });

        $('th').addClass('text-center');

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
    });
</script>
