<?php

namespace App\Core\Accounts\CashFlowCategory;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\CashFlowCategory\CashFlowCategory;
class CashFlowCategoryDetails implements CashFlowCategory
{
    public function addCashFlowCategory(array $data)
    {

    }

    public function updateCashFlowCategory(array $data)
    {

    }

    public function deleteCashFlowCategoryById($id)
    {

    }

    public function getCashFlowCategories()
    {
        $acct_cashflow = DB::table('acct_cashflow_category')->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->orderBy('cashflow_category_no_pk','asc')->get();

        if ($acct_cashflow->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acct_cashflow], 200);
    }

    public function getCashFlowCategoryById()
    {

    }
}