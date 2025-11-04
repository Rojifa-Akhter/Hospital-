<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">

        <li class="nav-item " role="presentation">
            <a class="nav-link cursor-pointer active" href="#general_ledger" id="general-ledger-tab" data-toggle="tab"
                role="tab" aria-controls="general_ledger" aria-selected="true">General Ledger</a>
        </li>

        {{-- <li class="nav-item" role="presentation">
            <a class="nav-link cursor-pointer" href="#journal_voucher" id="journal-voucher-tab" data-toggle="tab"
                aria-controls="journal_voucher" aria-selected="false">Journal Voucher</a>
        </li> --}}
        <li class="nav-item" role="presentation">
            <a class="nav-link cursor-pointer" href="#profit_loss" id="profit-loss-tab" data-toggle="tab"
                aria-controls="profit_loss" aria-selected="false">Profit Loss</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link cursor-pointer" href="#financial_statement" id="financial-statement-tab" data-toggle="tab"
                aria-controls="financial_statement" aria-selected="false">Financial Statement</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        {{-- general_ledger --}}
        <div class="tab-pane fade show active" id="general_ledger" role="tabpanel" aria-labelledby="general-ledger-tab">
            @include('admin.accounts.reports.payment_voucher.general_ledger_report')
        </div>

        {{-- journal_voucher --}}
        {{-- <div class="tab-pane fade" id="journal_voucher" role="tabpanel" aria-labelledby="journal-voucher-tab">
            @include('admin.accounts.reports.payment_voucher.payment_voucher_report')

        </div> --}}

        <div class="tab-pane fade" id="profit_loss" role="tabpanel" aria-labelledby="profit-loss-tab">
            @include('admin.accounts.reports.payment_voucher.profit_loss_report')
        </div>
         <div class="tab-pane fade" id="financial_statement" role="tabpanel" aria-labelledby="financial-statement-tab">
            @include('admin.accounts.reports.payment_voucher.payment_voucher_report')

        </div>
    </div>
</div>



<script type="text/javascript"></script>
