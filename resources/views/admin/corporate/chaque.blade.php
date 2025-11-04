<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />


<section id="create_corporate">
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-3 mb-3">Cheque Print</h5>
                    {{-- <small>Cheque Form</small> --}}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Cheque Print Form</div>
            <div class="card-body p-2">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    {{-- form start --}}

                        <div class="form-row">

                                <div class="col-md-3 col-sm-12">
                                    <form action="{{ route('store-accounts-cheque') }}" method="post" id="chequeBill">
                                        @csrf
                                    <div class="card mt-0">
                                        <div class="card-body p-2">
                                            <div class="form-group">
                                                <label for="cheque_dt" class="col-form-label s-12">Cheque Date</label>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker2"
                                                    id="cheque_dt" name="cheque_dt" value=""
                                                    placeholder="dd-mm-yyyy" autocomplete="off">
                                            </div>

                                            <div class="form-group">
                                                <label for="patientID" class="col-form-label s-12">Pay To <span
                                                        class="text-danger">*</span></label>
                                                <input type="hidden" class="" id="hdn_patient_id"
                                                    name="hdn_cheque_id" value="" />
                                                {{-- <input type="text" class="form-control form-control-sm m-0 mb-0 "
                                                    id="cheque_no" name="cheque_no" value="" placeholder="Pay To" maxlength="80"
                                                    required  autocomplete="off"/> --}}
                                                    <input list="cheque_no" name="cheque_no" type="text" class="form-control m-0 mb-0 " placeholder="Enter Pay To" required/>
                                                    <datalist id="cheque_no">
                                                        @if (isset($PayToNames))
                                                            @foreach ($PayToNames as $data)
                                                                <option value="{{ $data->chq_pay_to }}">
                                                            @endforeach
                                                        @endif
                                                    </datalist>
                                            </div>
                                            <div class="form-group">
                                                <label for="cheque_amount" class="col-form-label s-12">Cheque Amount <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control number_only" id="cheque_amount"
                                                    onkeyup="setAmount(this)" name="cheque_amount" value=""
                                                    placeholder="Enter Cheque Amount" required autocomplete="off"/>
                                            </div>

                                            {{-- <span class="text-danger" id="dt_show"></span> --}}

                                            {{-- <div class="form-group"> --}}
                                                {{-- <label for="sum_of_tk" class="col-form-label s-12">The Sum Of TK</label> --}}
                                            <input type="hidden" class="form-control" id="sum_of_tk" name="sum_of_tk"
                                                value="" placeholder="The Sum. of TK" />
                                            {{-- </div> --}}

                                            <div class="form-group">
                                                <label for="Bank name" class="col-form-label s-12">Bank name <span
                                                    class="text-danger">*</span></label>
                                                {{-- <input type="text" class="form-control" id="bank_name" name="bank_name" value="" placeholder="Enter Bank Name" /> --}}
                                                    <select class="form-control font_size_12 m-auto select2" id="bank_name" name="bank_name" required>
                                                        <option value="">Select Bank</option>
                                                        @if (isset($BankInfo))
                                                            @foreach ($BankInfo as $value)
                                                                <option value="{{ $value->lookupdata_name }}">{{ $value->lookupdata_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="acc_id" class="col-form-label s-12">Cheque Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="acc_id" name="acc_id"
                                                    value="" placeholder="Enter Cheque Number" required autocomplete="off"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="acc_pay" class="col-form-label s-12">Account Status <span
                                                    class="text-danger">*</span></label>
                                                <select class="form-control" id="acc_pay" name="acc_pay" required>
                                                    <option value="1">Account Pay Cheque</option>
                                                    <option value="2">Cash Cheque</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="remarks" class="col-form-label s-12">Remarks/Purpose<span
                                                    class="text-danger">*</span></label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3" maxlength="58" required></textarea>
                                              </div>
                                            @php
                                                $response_action = route('accounts-cheque');
                                            @endphp

                                            <button type="button" class="btn btn-info btn-md btn-block btnSave"
                                                title=""
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                                        </div>
                                    </div>
                                </form>
                                </div>

                            <div class="col-md-9 col-sm-12">
                                <div class="card mb-2" style="width: 100%; margin: auto">
                                    <div class="card-header ">
                                        <h5> Search</h5>
                                    </div>
                                    <div class="card-body ">
                                        <div class="form-row mt-2">
                                            <div class="col-md-12 ">
                                                <form method="post"  data-response-action="" action=""  target="_blank" id="frmSearchChq">
                                                    @csrf
                                                    <div class=" justify-content-start  form-row">
                                                        <input type="hidden" name="id" value="">
                                                        <div class=" col-md-2">
                                                            <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                                                Date</label>
                                                            <input type="text" class="form-control form-control-sm date_picker" id="from_date"
                                                                name="from_date" value="{{date('d-m-Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                                            <span class="focus_input"></span>
                                                        </div>

                                                        <div class=" col-md-2">
                                                            <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To
                                                                Date</label>
                                                            <input type="text" class="form-control form-control-sm date_picker" id="to_date"
                                                                name="to_date" value="{{date('d-m-Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                                            <span class="focus_input"></span>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="bank_name"
                                                                class=" col-form-label col-form-label-sm ">Bank Name</label>
                                                            <select class="form-control select2" id="bank_name" name="bank_name"
                                                                style="margin:0px!important;">
                                                                <option value="">Select Bank</option>
                                                                @if (isset($BankInfo))
                                                                    @foreach ($BankInfo as $value)
                                                                        <option value="{{ $value->lookupdata_name }}">{{ $value->lookupdata_name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        {{-- <div class="col-md-2">
                                                            <label for="pay_to"
                                                                class=" col-form-label col-form-label-sm ">Pay To</label>
                                                            <select class="form-control select2" id="pay_to" name="pay_to"
                                                                style="margin:0px!important;">
                                                                <option value="">Select Pay To</option>
                                                                @if (isset($PayToNames))
                                                                    @foreach ($PayToNames as $value)
                                                                        <option value="{{ $value->chq_pay_to }}">
                                                                            {{ $value->chq_pay_to }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-md-2 mt-3">
                                                        <div class="form-check ml-4">
                                                            <input class="form-check-input" type="checkbox"  name="be_printed">
                                                            <label class="form-check-label" for="">
                                                                Be Printed
                                                            </label>
                                                            </div>
                                                            <div class="form-check ml-4">
                                                            <input class="form-check-input" type="checkbox" name="printed">
                                                            <label class="form-check-label" for="">
                                                                Printed
                                                            </label>
                                                        </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 text-left mt-4">
                                                            <div class="btn-group btn-block" role="group" >
                                                                <button type="button" class="btn btn-sm btn-success btn-md-global btn-block mt-0"
                                                                    id="accountsChequeSearchReport" onclick=""> <i class="fas fa-search"></i>
                                                                    Search</button>
                                                                <button type='submit' class="btn btn-info btn-block btn-sm btn-md-global mt-0 print" value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                                                <button type='submit' class="btn btn-primary btn-block btn-sm btn-md-global mt-0 print" value="2"><i class="fa fa-file-excel"></i> Exp Excel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-0">
                                    <div class="card-header">
                                        <h5>Cheque Print List</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive mt-2 border-right" id="accounts_cheque_print_list_container">

                                            @include('admin.corporate.accounts_cheque_list')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            'format': 'dd-mm-yyyy'
        });
    });

    $(function() {
        $('.date_picker2').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    });

    // cheque info searching
    $(document).on("click", "#accountsChequeSearchReport", function(e) {
        var formID = $("#frmSearchChq").attr("id");

        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearchChq").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('accounts_cheque_report_search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#accounts_cheque_print_list_container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('accounts_cheque_report_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('accounts_cheque_report_print_excel') }}");
        }
        if (print == 3) {

            var itemArray = $(".cheque_item")
                .map(function() {
                    if ($(this).is(":checked")) {
                        return this.value;
                    }
                }).get();
            if (itemArray == "") {
                alert("Please Select Item");
                return false;
            }
            $('form').attr('action', "{{ route('cheque-print-all') }}");
        }
    });

    $("#cheque_dt").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#cheque_no').focus()
        }
    });

    $("#cheque_no").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#cheque_amount').focus()
        }
    });

    $("#cheque_amount").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#bank_name').focus()
        }
    });
    $("#bank_name").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#acc_id').focus()
        }
    });

    $("#acc_id").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#acc_pay').focus()
        }
    });
    $("#acc_pay").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('.btnSave').focus()
        }
    });


    // setAmount
    function setAmount(element) {

        let numberInput = $(element).val()
        let myDiv = document.querySelector('#dt_show');

        let oneToTwenty = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ',
            'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ',
            'nineteen '
        ];
        let tenth = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        if (numberInput.toString().length > 7) return myDiv.innerHTML = 'overlimit';
        console.log(numberInput);
        //let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        let num = ('0000000' + numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
        console.log(num);
        if (!num) return;

        let outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] ||
            `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}`) + ' million ' : '';

        outputText += num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}`) +
            'hundred ' : '';
        outputText += num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`) +
            ' thousand ' : '';
        outputText += num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) +
            'hundred ' : '';
        outputText += num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) :
            '';
        console.log(outputText)
        myDiv.innerHTML = outputText;
        $("#sum_of_tk").val(outputText)
    }

    // function salesAmount(element) {
    //     var percent = $(element).val() != "" ? $(element).val() : 0;
    //     var amount = $(element).parents('td').parents('tr').find('#amount').val();
    //     var discount_amt = $(element).parents('td').parents('tr').find('#discount').val();
    //     var net_comission = percent > 0 ? (amount * percent) / 100 : 0;
    //     console.log(discount_amt, amount, net_comission)
    //     $(element).parents('td').parents('tr').find('#payable_amt').val(net_comission);
    // }

    // openChequeAutocomplete('#cheque_no', 'Cheque Name');
</script>
