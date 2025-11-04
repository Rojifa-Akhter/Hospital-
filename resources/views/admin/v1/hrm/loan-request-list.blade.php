<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    {{-- <form action="#" id="" method="post"> --}}
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Loan Request List</h5>
                            <small>HRM / Loan Request List</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <form action="#" id="requestListSearch" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                {{-- <input type="radio" id="customRadioInline1" name="customRadioInline1"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="customRadioInline1">Application</label> --}}
                                                <input type="checkbox" id="application" name="application"
                                                    value="application">&nbsp;&nbsp;
                                                <label for="application">Application</label><br>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="checkbox" id="approved" name="approved"
                                                    value="approved">&nbsp;&nbsp;
                                                <label for="approved">Approved</label><br>
                                            </div>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="checkbox" id="completed" name="completed"
                                                    value="completed">&nbsp;&nbsp;
                                                <label for="completed">Completed</label><br>
                                            </div>


                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="checkbox" id="rejected" name="rejected"
                                                    value="rejected">&nbsp;&nbsp;
                                                <label for="rejected">Rejected</label><br>
                                            </div>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <button type="button"
                                                    class="btn btn-block btn-success btn-md mt-4 btn-md-global"
                                                    id="searchLoanRequest">Search</button>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


            <div class="card" id="">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center">Loan ID</th>
                                        <th class="text-center">Request Date</th>
                                        <th class="text-center" width="25%">Employee Info</th>
                                        <th class="text-center">Service Length</th>
                                        <th class="text-center">Loan Reason</th>
                                        <th class="text-center">Loan Req. Desc.</th>
                                        <th class="text-center">Req. Amt.</th>
                                        <th class="text-center">Approved Date</th>
                                        <th class="text-center">Approved Amt.</th>
                                        <th class="text-center">No of Installment</th>
                                        <th class="text-center">Installment Amt.</th>
                                        <th class="text-center">Refunded Installment</th>
                                        <th class="text-center">Refunded Amt.</th>

                                        <th class="text-left">Uploaded Document</th>
                                        {{-- <th class="text-center">Status</th> --}}
                                        <th class="text-center" style="width:120px;">Action</th>


                                    </tr>
                                </thead>
                                <tbody id="loanRequestListTable">
                                    @include('admin.v1.hrm.loan-request-list-search-table')
                                    @if (!empty($loanList))
                                        @foreach ($loanList as $loan)
                                            <tr>
                                                <td>{{ $loan->loan_req_no_pk }}</td>
                                                <td class="text-center">
                                                    {{ date('d/m/Y', strtotime($loan->au_entry_at)) }}</td>
                                                <td>
                                                    <div>
                                                        <b> EMP Code:</b> {{ $loan->person_code }}
                                                    </div>
                                                    <div>
                                                        <b> Full Name: </b> {{ $loan->full_name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (isset($loan->join_date))
                                                        @php
                                                            $date1 = date_create(date('Y-m-d', strtotime($loan->join_date)));
                                                            $date2 = date_create(date('Y-m-d'));
                                                            $diff = date_diff($date1, $date2);
                                                        @endphp
                                                        {{ $diff->format('%y') . 'Y ' . $diff->format('%m') . 'M' }}
                                                    @endif
                                                </td>
                                                <td class="text-left">{{ $loan->req_reason }}</td>
                                                <td class="text-left">
                                                    {{ substr($loan->loan_req_desc, 0, 50) }}
                                                    {{ Str::length($loan->loan_req_desc) > 50 ? '...' : '' }}
                                                </td>
                                                <td class="text-right">{{ number_format($loan->loan_amt, 2) }}</td>
                                                <td class="text-center">
                                                    {{ isset($loan->approval_date) ? date('d/m/Y', strtotime($loan->approval_date)) : '' }}
                                                </td>
                                                <td class="text-center">{{ number_format($loan->approval_amt, 2) }}
                                                </td>
                                                <td class="text-right">{{ $loan->no_of_installment }}</td>
                                                <td class="text-right">
                                                    {{ number_format($loan->installment_amt, 2) }}
                                                </td>
                                                <td class="text-center">{{ $loan->refund_installment }}</td>
                                                <td class="text-center">{{ number_format($loan->refund_amt, 2) }}</td>
                                                <td class="text-center">
                                                    @if (isset($loan->upload_application))
                                                        <a href="{{ asset('uploads/hrm/' . $loan->upload_application) }}"
                                                            target="_blank">{{ $loan->upload_application }}</a>
                                                    @endif
                                                </td>
                                                {{-- <td class="text-center">{{ $loan->req_saveoption }}</td> --}}
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-success ">History</a>
                                                    <a rel="tab"
                                                        href="{{ route('v1.hrm.loan-settlement', $loan->loan_req_no_pk) }}"
                                                        class="btn btn-sm btn-success m-1">Set
                                                        Installment</a>
                                                    <a href="{{ route('v1.hrm.loan-installment-payment-and-closing', $loan->loan_req_no_pk) }}"
                                                        class="btn btn-sm btn-success">Payment</a>
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
        </div>
    </section>
    {{-- </form> --}}
</main>

<script>
    $(document).on("click", "#searchLoanRequest", function(e) {

        var formID = $("#requestListSearch").attr("id");
        var formMethod = $("#requestListSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-loan-request-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                // console.log(data);
                $("#loanRequestListTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
