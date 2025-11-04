<?php 

namespace App\Http\Controllers\Admin;

use App\Constants\LookupKeys;
use App\Enums\AccountIndicator;
use App\Library\Template;
use App\Models\AcctChartOfAccount as ChartOfAccount;
use App\Models\LookupItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankCommissionSetupController
{
    public function index(Request $request)
    {   

        $hospitalNoPk = $hospitalNoPk = (int) session('user.ses_hospital_no_pk');

        $chartOfAccounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalNoPk)
            ->where('posting_head_ind', 1)
            ->whereIn('bank_ind', [
                AccountIndicator::BANK,
                AccountIndicator::MOBILE_BANKING,
            ])
            ->where('status', ChartOfAccount::STATUS_ACTIVE)
            ->orderBy('account_name', 'asc')
            ->get();

        $chartOfAccounts = $chartOfAccounts->map(function ($chartOfAccount) {
            return [
                'account_no_pk'    => $chartOfAccount->account_no_pk,
                'account_name'     => $chartOfAccount->account_name,
                'commission_rates' => $chartOfAccount->commission_rates
                    ? json_decode($chartOfAccount->commission_rates, true)
                    : [],
            ];
        });


        return Template::loadView('admin.bank-commission-setup.index', compact('request', 'chartOfAccounts'));
    }

    public function show(Request $request, int $journalKey) 
    {
        $account = ChartOfAccount::findOrFail($journalKey);

        $commissionRates = $account->commission_rates ? json_decode($account->commission_rates, true) : [];

        $paymentMethods = LookupItem::query()
            ->whereIn('lookup_no_fk', [
                LookupKeys::CARD_TYPE,
                LookupKeys::MBANKING,
            ])
            ->where('status', 1)
            ->pluck('lookupdata_name', 'lookupdata_no_pk');


        return Template::loadView('admin.bank-commission-setup.show', compact('request', 'account', 'commissionRates', 'paymentMethods'));
    }

    public function update(Request $request)
    {   
        $data = $request->validate([
            'account_key' => ['required', 'integer', 'exists:acct_chart_of_accounts,account_no_pk'],
            'payment_method_key' => ['required', 'array'],
            'payment_method_key.*' => ['required', 'string', 'max:100'],
            'payment_method_name' => ['required', 'array'],
            'payment_method_name.*' => ['required', 'string', 'max:150'],
            'commission_rate' => ['required', 'array'],
            'commission_rate.*' => ['required', 'numeric', 'min:0'],
        ]);

        $rows = [];
        foreach ($data['payment_method_key'] as $i => $key) {
            $rows[] = [
                'payment_method_key' => $key,
                'payment_method_name' => $data['payment_method_name'][$i],
                'commission_rate' => round((float) $data['commission_rate'][$i], 2),
            ];
        }

        try {
            DB::transaction(function () use ($data, $rows) {
                $account = ChartOfAccount::findOrFail($data['account_key']);
                $account->commission_rates = json_encode($rows);
                $account->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Commission rates saved successfully.',
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}