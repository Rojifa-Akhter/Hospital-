<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .fw-bold {
        font-weight: 600;
    }

    .fw-semibold {
        font-weight: 500;
    }

    .fs-14 { 
        font-size: 14px; 
    }

    .fs-16 { 
        font-size: 16px; 
    }

    .form-label {
        font-weight: 600;
        font-size: 0.75rem;
        color: #000;
    }

    input[type="checkbox"]:disabled {
        cursor: not-allowed;
    }

</style>

<div class="bg-white border-bottom shadow-sm px-3 py-2">
    <h5 class="mb-0 fw-bold">Bank Reconciliation</h5>
    <small class="text-muted">Accounts / Bank Reconciliation</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="card">
        <div class="card-body border-bottom pt-2">

            <div class="card-title">
                <h6 class="mb-0 fw-bold">Filter Options</h6>
            </div>           

            <form method="post">
                @csrf
                <div class="form-row">
                    
                    <div class="form-group col-md-4">
                        <label for="account" class="form-label">
                            Reconciled Account: <span class="text-danger">*</span>
                        </label>
                        <select 
                            class="form-control" 
                            id="account" 
                            name="account"
                            required
                        >
                            <option value=""></option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->account_no_pk }}">
                                    {{ $account->account_code }} - {{ $account->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="from_date" class="form-label">
                            From Date <span class="text-danger">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="from_date"
                            name="from_date"
                            value="{{ date('Y-m-01') }}" 
                            required
                        >
                    </div>

                    <div class="form-group col-md-4">
                        <label for="to_date" class="form-label">
                            To Date <span class="text-danger">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="to_date"
                            name="to_date"
                            value="{{ date('Y-m-d') }}" 
                            required
                        >
                    </div>

                </div>

                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-md btn-success" id="apply-button">
                        Apply
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body pt-2 d-none" id="summary-section">
            <div class="card-title mb-3">
                <h6 class="mb-0 fw-bold">Summary</h6>
            </div>
            <div id="summary-content" class="fs-14"></div>
            <div class="mt-3">
                <a 
                    href="" 
                    id="view-summary" 
                    data-base-href="{{ route('bank-reconciliation.create') }}"
                    class="btn btn-primary btn-md"
                >
                    View Summary
                </a>
            </div>
        </div>
    </div>
                     
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>


    (function() {

        const vueInstance = document.getElementById('app').__vue__;

        if (vueInstance && vueInstance.$destroy) {
            vueInstance.$destroy();
            console.log('Vue instance destroyed successfully');
        }

        $("#account").select2({
            placeholder: "Select Bank Account",
            allowClear: true
        });

        const applyButton = $('#apply-button');
        const form = $('form');
        
        form.on("submit", function (e) {
            e.preventDefault();

            const account  = $("#account").val();
            const fromDate = $("#from_date").val();
            const toDate   = $("#to_date").val();

            $("#summary-section").addClass("d-none");
            $("#summary-content").empty();

            applyButton.prop("disabled", true).html("Loading...");

            $.ajax({
                url: "{{ route('bank-reconciliation.filter') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", 
                    account_no: account,
                    from_date: fromDate,
                    to_date: toDate,
                },
                success: function (response, textStatus, jqXHR) {

                    $("#summary-section").removeClass("d-none");

                    $("#summary-content").html(`
                        <dl class="row mb-0">
                            <dt class="col-sm-4 fw-bold">Account:</dt>
                            <dd class="col-sm-8">${response.data.account_display}</dd>

                            <dt class="col-sm-4 fw-bold">Period:</dt>
                            <dd class="col-sm-8">${response.data.from_date} to ${response.data.to_date}</dd>

                            <dt class="col-sm-4 fw-bold">Book Balance (GL):</dt>
                            <dd class="col-sm-8">৳${response.data.book_balance}</dd>

                            <dt class="col-sm-4 fw-bold">Bank Statement Balance:</dt>
                            <dd class="col-sm-8">৳${response.data.bank_statement_balance}</dd>

                            <dt class="col-sm-4 fw-bold">Reconciling Difference:</dt>
                            <dd class="col-sm-8 ${response.data.reconciling_difference !== '0.00' ? 'text-danger' : 'text-success'}">
                                ৳${response.data.reconciling_difference}
                            </dd>
                        </dl>
                    `);

                    setViewSummaryHref(
                        account,
                        fromDate,
                        toDate
                    );

                },
                error: function(xhr, status, error) {
                    
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        
                        console.error('Server Error:\n', xhr.responseJSON);
                        
                        const messages = Object.values(xhr.responseJSON.errors)
                            .flat()
                            .join('\n');
                        
                        alert('Please check your input:\n\n' + messages);
                        
                    } else {
                        
                        console.error('Server Error:\n', xhr.responseJSON?.message || 'Unexpected error occurred');
                        
                        alert('Something went wrong. Please try again.');
                        
                    }
                    
                },
                complete: function () {
                    applyButton.prop("disabled", false).html("Apply");
                },
            });
        });

        function setViewSummaryHref(accountNo, fromDate, toDate) {
            const viewSummary = $('#view-summary');

            let newHref = viewSummary.data('base-href') || viewSummary.attr('href');
            newHref = newHref.split('?')[0]; 

            const params = [];
            if (accountNo) params.push('account_no=' + encodeURIComponent(accountNo));
            if (fromDate)  params.push('from_date=' + encodeURIComponent(fromDate));
            if (toDate)    params.push('to_date=' + encodeURIComponent(toDate));

            if (params.length) {
                newHref += '?' + params.join('&');
            }

            viewSummary.attr('href', newHref);
        }


    })();

</script>

