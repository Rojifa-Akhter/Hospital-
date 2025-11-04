<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Referral Payment Bill
                    Report</h5>
                <small>Report / Referral Payment Bill</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmSearch" action="{{ route('pcrm.referral-payment-bill-pdf') }}"
                              data-response-action="">
                            @csrf
                            <div class="form-group  form-row">
                                <input type="hidden" name="id" value="">

                                <label for="card_no" class=" col-form-label col-form-label-sm ">Referral code </label>
                                <div class=" col-md-2">
                                    <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                           value="" placeholder="Card no">
                                    <input type="hidden" name="card_hidn" id="card_hidn">

                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                    Date</label>
                                <div class=" col-md-1">
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_pic"
                                           name="date_from" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="focus_input"></span>
                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
                                <div class=" col-md-1">

                                    <input type="text" class="form-control form-control-sm date_picker" id="date_pic2"
                                           name="date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="focus_input"></span>
                                </div>
                                <label for="su_name" class=" col-form-label col-form-label-sm ">Department</label>
                                <div class=" col-md-2">
                                    <select class="form-control form-control-sm select2" name="dept_name">
                                        <option value="">Select Department</option>
                                        @if (!empty($requestDepts))
                                            @foreach ($requestDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">
                                                    {{ $rd->serviceunit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                                id="billPaymentSheet" onclick=""><i class="fas fa-search"></i>
                                            Search
                                        </button>

                                        <button type='submit' class="btn btn-info btn-block btn-md mt-0 print"
                                                target="_blank"
                                                value="2"> Export PDF
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-header"> Referral Bill Payment Report</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="bill_payment_list">
                        @include('admin.pcrm.referral_v2.billPayment.referral_bill_payment_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $('.select2').select2();
    openDoctorAutocomplete("#card_no", 'card_hidn');


    $("body").addClass("sidebar-collapse");
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format':'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#billPaymentSheet", function (e) {

        // if ($('#card_hidn').val() != '') {
            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ route('pcrm.referral-payment-bill-search') }}",
                type: formMethod,
                beforeSend: function () {
                    blockUI();

                },
                success: function (data) {

                    $("#bill_payment_list").html(data);

                },
                complete: function () {
                    $.unblockUI();
                }
            });
        // } else {
        //     alert('Please Enter Referral Code')
        //     return
        // }


    });

    $(document).on('keyup','#card_no',function(){
        if($(this).val() ==''){
            $('#card_hidn').val('');
        }
    })

    $(document).on("click", ".print", function (e) {
        // if ($('#card_hidn').val() != '') {
            $('form').attr('action', "{{ route('pcrm.referral-payment-bill-pdf') }}");
        // } else {
        //     alert('Please Enter Referral Code')
        //     return
        // }
    });

    // delete

</script>
