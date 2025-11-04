<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />


<section id="create_corporate">
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Corporate Form</h5>
                    <small>Corporate / Corporate Form</small>
                </div>
            </div>
        </div>

        {{-- page body start --}}
        <div class="card">
            <div class="card-body p-2">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    {{-- form start --}}
                    <form action="{{ route('store-corporate-bill') }}" method="post" id="corporateBill">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4 col-sm-12">
                                <div class="card mt-0">
                                    <div class="card-body p-2">
                                        <div class="form-group">
                                            <label for="Company Name" class="col-form-label s-12">Company Name</label>
                                            <select class="form-control mr-sm-2 select2" id="cmp_name"
                                                name="Company Name">
                                                <option selected value="">Choose Company</option>
                                                @if (isset($companies))
                                                    @foreach ($companies as $record)
                                                        <option value="{{ $record->ccm_client_no_pk }}">
                                                            {{ Ucfirst($record->ccm_client_name) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="patientID" class="col-form-label s-12">Patient ID</label>
                                            <input type="hidden" class="" id="hdn_patient_id"
                                                name="hdn_patient_id" value="" />
                                            <input type="text" class="form-control form-control-sm m-0 mb-0 "
                                                id="service_number" name="service_number" value=""
                                                placeholder="Patient ID" />
                                        </div>

                                        <div class="form-group">
                                            <label for="treatment_dt" class="col-form-label s-12">Treatment Date</label>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                id="treatment_dt" name="treatment_dt" value="{{ date('d/m/Y') }}"
                                                placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>


                                        <div class="form-group">
                                            <label for="section" class="col-form-label s-12">Section</label>
                                            <input type="text" class="form-control" id="section" name="section"
                                                value="" placeholder="Enter Section" />
                                        </div>

                                        <div class="form-group">
                                            <label for="Designation" class="col-form-label s-12">Designation</label>
                                            <input type="text" class="form-control" id="Designation"
                                                name="Designation" value="" placeholder="Enter Designation" />
                                        </div>

                                        <div class="form-group">
                                            <label for="Insurance ID" class="col-form-label s-12">Insurance ID</label>
                                            <input type="text" class="form-control" id="ins_id" name="ins_id"
                                                value="" placeholder="Enter Ins. ID" />
                                        </div>

                                        <div class="form-group">
                                            <label for="bill_id" class="col-form-label s-12">Bill Number</label>
                                            <input type="text" class="form-control" id="bill_id" name="bill_id"
                                                value="" placeholder="Enter Bill Number" />
                                        </div>

                                        <div class="form-group">
                                            <table class="table table-bordered" id="myTable">
                                                <thead>
                                                    <tr class="bg-light-blue">
                                                        <td><strong> Service Name</td>
                                                        <td><strong> Amount (TK.)</strong></td>
                                                        <td><strong> Discount (%)</strong></td>
                                                        <td><strong> Payable Amount</strong></td>
                                                        <td><strong> Action</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="dinamicApp">
                                                    <tr>
                                                        <td> <input type="text" class="form-control" id="service_id"
                                                                name="service_id[]" value=""
                                                                placeholder="Service Name" /></td>
                                                        <td> <input type="text" class="form-control number_only"
                                                                id="amount" name="amount[]" value=""
                                                                placeholder="Amount (TK.)" /></td>
                                                        <td> <input type="text" class="form-control number_only"
                                                                id="discount" name="discount[]" value=""
                                                                placeholder="Discount" onkeyup="salesAmount(this)"/>
                                                        </td>
                                                        <td> <input type="text" class="form-control number_only"
                                                                id="payable_amt" name="payable_amt[]" value=""
                                                                placeholder="Payable Amt." /></td>
                                                        <td>
                                                            <button class="btn btn-md btn-primary" id="addBtn"
                                                                type="button">
                                                                +
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                            @php
                                                $response_action = route('corporate-bill');
                                            @endphp

                                        <button type="button" class="btn btn-info btn-md btn-block" title=""
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-8 col-sm-12">
                                <div class="card mt-0">
                                    <div class="card-header">
                                        <h5>Corporate Bill List</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive border-top border-right">
                                            <table class="table table-bordered table-hover mb-0 staffList">
                                                <thead class="global-uhl-table-bg">
                                                    <tr class="bg-primary">
                                                        <th class="text-center" rowspan="2">SL#</th>
                                                        <th class="text-left" rowspan="2">Patient</th>
                                                        <th class="text-left" rowspan="2">Treatment Date</th>
                                                        <th class="text-left" rowspan="2">Company Name</th>
                                                        <th class="text-left" rowspan="2">Service Name</th>
                                                        <th class="text-left" rowspan="2">Section</th>
                                                        <th class="text-left" rowspan="2">Designation</th>
                                                        <th class="text-left" rowspan="2">Insurance ID</th>
                                                        <th class="text-left" rowspan="2">Bill No</th>
                                                        <th class="text-center" colspan="3">Amount</th>
                                                        <th class="text-center"  rowspan="2" >Action</th>
                                                    </tr>
                                                    <tr  class="bg-warning" >
                                                        <th class="text-left">Amount (TK.)</th>
                                                        <th class="text-left">Discount</th>
                                                        <th class="text-left">Payable Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    {{-- <tr role="row" class="odd">
															<td class="text-center">PAT01</td>
															<td class="text-left"></td>
															<td class="text-center"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>
															<td class="text-center">
																<span
																	class="badge badge-md badge-success p-1 mb-1 cursor-pointer"><i
																		class="far fa-edit"></i> Edit</span>
															</td>
														</tr> --}}


                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    $('.select2').select2();

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });



    $("#ins_id").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#bill_id').focus()
        }
    });

    $("#section").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#Designation').focus()
        }
    });

    $("#Designation").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#ins_id').focus()
        }
    });

    $("#treatment_dt").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#section').focus()
        }
    });

    $("#service_number").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#treatment_dt').focus()
        }
    });

    $("#cmp_name").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#service_number').focus()
        }
    });

    $("#bill_id").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#service_id').focus()
        }
    });


    $("#addBtn").click(function() {
        console.log('ol')
        const i = 1;
        $('#dinamicApp').append('<tr id="row' + i +
            '"> <td> <input type="text" class="form-control" id="service_id" name="service_id[]" value="" placeholder="Service Name" /></td><td> <input type="text" class="form-control number_only" id="amount" name="amount[]" value="" placeholder="Amount (TK.)" /></td> <td> <input type="text" class="form-control number_only" id="discount" name="discount[]" value="" placeholder="Discount" /></td><td> <input type="text" class="form-control number_only" id="payable_amt" name="payable_amt[]" value="" placeholder="Payable Amt." /></td><td><button class="btn btn-md btn-danger removeBtn" id="' +
            i + '" type="button"> - </button></td> </tr>');
    });
    $(document).on('click', '.removeBtn', function() {

        const row_id = $(this).attr('id');
        console.log(row_id)
        $('#row' + row_id + '').remove();
    })

    //setAmount
    // function setAmount(element){
    //    const amt = $(element).val()

    //    console.log(amt)
    //    $("#payable_amt").val(amt)
    // }

    function salesAmount(element) {
        var percent = $(element).val() != "" ? $(element).val() : 0;
        var amount = $(element).parents('td').parents('tr').find('#amount').val();
        var discount_amt = $(element).parents('td').parents('tr').find('#discount').val();
        var net_comission = percent > 0 ? (amount * percent) / 100 : 0;
        console.log(discount_amt,amount,net_comission)
        $(element).parents('td').parents('tr').find('#payable_amt').val(net_comission);
    }

    openPatientAutocomplete('#service_number', 'patient_name');
</script>
