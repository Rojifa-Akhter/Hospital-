<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">

    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Loan Installment Payment & Closing</h5>
                            <small>HRM / Loan Installment Payment & Closing</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" id="formLoadSettlement" method="post">
                @csrf
                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name_" class="col-form-label">Loan ID</label>
                                            <input type="text" class="form-control form-control-sm" id="name_"
                                                name="loan_id" placeholder="" value="">

                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <button type="button"
                                            class="btn btn-block btn-success btn-md mt-4 btn-md-global"
                                            id="searchLoadRequest">Search</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('v1.hrm.update-loan-installment-payment-and-closing') }}"
                id="formLoadSettlementPayment" method="post">
                @csrf
                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive" id="loan-payment-table">
                                {{-- @include('admin.v1.hrm.loan-installment-payment-and-closing-table') --}}
                                <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center">Serial</th>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">Payment Amount</th>
                                        <th class="text-center">Paid Date</th>
                                        <th class="text-center">Paid Amount</th>
                                        <th class="text-center">Status</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($Details))
                                        @foreach ($Details as $loanDetails)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('F', strtotime($loanDetails->installment_date)) }}'
                                                    {{ date('Y', strtotime($loanDetails->installment_date)) }}</td>
                                                <td class="text-right">{{ $loanDetails->installment_amt }}</td>
                                                <td class="text-center">
                                                    {{ isset($loanDetails->paid_date) ? date('d-m-Y', strtotime($loanDetails->paid_date)) : '' }}
                                                </td>
                                                <td class="text-right">
                                                    {{ $loanDetails->pay_status == 1 ? $loanDetails->installment_amt : '' }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="loansettlementdtl_no_pk[]"
                                                        {{ $loanDetails->pay_status == 1 ? 'checked disabled' : '' }}
                                                        value="{{ $loanDetails->loansettlementdtl_no_pk }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    @php
                                        $response_action = route('v1.hrm.loan-installment-payment-and-closing');
                                        // '{{ $response_action }}'
                                    @endphp
                                    <tr>
                                        <td colspan="5"></td>
                                        <td> <button
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"class="btn btn-sm btn-success">Paid</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                           

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>

</main>

<script>
    $(document).on("click", "#searchLoadRequest", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#formLoadSettlement").attr("id");
        var formMethod = $("#formLoadSettlement").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-loan-installment-payment-and-closing') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#loan-payment-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
