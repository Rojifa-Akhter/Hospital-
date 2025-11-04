<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />


<section id="create_corporate">
    <div class="container-fluid">

        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-3 mb-3">Cheque Print</h5>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Cheque Print Form</div>
            <div class="card-body p-2">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="form-row">
                        <div class="col-md-3 col-sm-12">
                            <form action="{{ route('cheque-printing.store') }}" method="post" id="chequeBill">
                                @csrf
                                <div class="card mt-0">
                                    <div class="card-body p-2">
                                        
                                        <div class="form-group">
                                            <label for="cheque_dt" class="col-form-label s-12">Cheque Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker2" id="cheque_dt" name="cheque_dt" value="" placeholder="dd-mm-yyyy" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="cheque_pay_to" class="col-form-label s-12">Pay To <span class="text-danger">*</span></label>
                                            <input type="hidden" id="hdn_cheque_id" name="hdn_cheque_id" value="" />

                                            <input list="cheque_pay_to_options" name="cheque_pay_to" type="text" class="form-control m-0 mb-0" placeholder="Enter Pay To" required/>
                                            <datalist id="cheque_pay_to_options">
                                                @if (isset($PayToNames))
                                                    @foreach ($PayToNames as $data)
                                                        <option value="{{ $data->chq_pay_to }}">
                                                    @endforeach
                                                @endif
                                            </datalist>
                                        </div>

                                        <div class="form-group">
                                            <label for="cheque_amount" class="col-form-label s-12">Cheque Amount <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control number_only" id="cheque_amount" onkeyup="setAmount(this)" name="cheque_amount" value="" placeholder="Enter Cheque Amount" required autocomplete="off"/>
                                        </div>

                                        {{-- <span class="text-danger" id="dt_show"></span> --}}

                                        {{-- <div class="form-group"> 
                                            <label for="sum_of_tk" class="col-form-label s-12">The Sum Of TK</label> --}}
                                            <input type="hidden" class="form-control" id="sum_of_tk" name="sum_of_tk" value="" placeholder="The Sum. of TK" />
                                        {{-- </div> --}}
                                        
                                        <div class="form-group">
                                            <label for="addBankAccountSelect" class="col-form-label s-12">Bank name <span class="text-danger">*</span></label>
                                            <select id="addBankAccountSelect" class="form-control" name="bank_name" required>
                                                <option value="">Select Bank</option>
                                                @if (isset($bankAccounts))
                                                    @foreach ($bankAccounts as $account)
                                                        <option value="{{ $account->account_name }}" data-bank-pk="{{ $account->account_pk }}">
                                                            {{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cheque_number" class="col-form-label s-12">Cheque Number <span class="text-danger">*</span></label>
                                            <select id="cheque_number" name="cheque_number" required>
                                                <option value=""></option> 
                                            </select>
                                            <small class="form-text text-muted">Cheque numbers populate based on selected Bank</small>
                                        </div>

                                        <input type="hidden" id="cheque_detail_pk" name="cheque_detail_pk" value="">

                                        <div class="form-group">
                                            <label for="remarks" class="col-form-label s-12">Remarks/Purpose<span
                                                class="text-danger">*</span></label>
                                            <textarea class="form-control" id="remarks" name="remarks" rows="3" maxlength="58" required></textarea>
                                        </div>

                                        <button 
                                            type="button" class="btn btn-info btn-md btn-block btnSave"
                                            title=""
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ route('cheque-printing.index') }}')"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-9 col-sm-12">
                            <div class="card mb-2" style="width: 100%; margin: auto">
                                <div class="card-header">
                                    <h5> Search</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-row mt-2">
                                        <div class="col-md-12 ">
                                            <form method="post" data-response-action="" action=""  target="_blank" id="frmSearchChq">
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
                                                        <label for="bank_name" class="col-form-label col-form-label-sm">Bank Name</label>
                                                        <select class="form-control select2" id="bank_name" name="bank_name" style="margin:0px">
                                                            <option value="">Select Bank</option>
                                                            @if (isset($bankAccounts))
                                                                @foreach ($bankAccounts as $account)
                                                                    <option value="{{ $account->account_name }}" data-bank-pk="{{ $account->account_pk }}">
                                                                        {{ $account->account_name }}
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
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button" class="btn btn-sm btn-success btn-md-global btn-block mt-0" id="accountsChequeSearchReport" onclick=""> 
                                                                <i class="fas fa-search"></i> Search
                                                            </button>
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
                                        @include('admin.cheque-printing.partials.cheque-list')
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

    $('#cheque_number').select2({
        placeholder: "Select Cheque Number", 
        allowClear: true 
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd-mm-yyyy'
        });
    });
    
    $(function() {
        $('.date_picker2').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            format: 'dd-mm-yyyy'
        });
    });

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

    $(document).on('change', '#addBankAccountSelect', function() {
        const bankPk = $(this).find(':selected').data('bank-pk');
        const chequeDropdown = $('#cheque_number');
        
        chequeDropdown.find('option:not([value=""])').remove();
        // chequeDropdown.trigger('change');
        
        if (bankPk) {
            $.ajax({
                url: '{{ route("cheque-printing.get-cheques") }}',
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                data: {
                    bank_pk: bankPk
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    if (response.data && response.data.cheques.length > 0) {
                        response.data.cheques.forEach(function(cheque) {
                            const option = $('<option>', {
                                value: cheque.cheque_number,
                                text: cheque.cheque_number
                            });
                            option.attr('data-verified-pk', cheque.cheque_verified_pk);
                            option.attr('data-detail-pk', cheque.cheque_detail_pk);
                            chequeDropdown.append(option);
                        });
                    } else {
                        alert('No cheques found for the selected bank');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error fetching cheques. Please try again later.');
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }

    });

    $('#cheque_number').on('change', function(event) {
        const selectedOption = $(this).find('option:selected');
        const detailPk = selectedOption.data('detail-pk') || '';
        
        $('#cheque_detail_pk').val(detailPk);
        
        $(this).valid();
    });

    $("#cheque_dt").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#cheque_pay_to').focus() 
        }
    });

    $("#cheque_pay_to").on('keyup', function(e) { 
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#cheque_amount').focus()
        }
    });

    $("#cheque_amount").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#bank_name').focus()
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

</script>