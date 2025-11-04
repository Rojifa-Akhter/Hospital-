<?php
    namespace App\Core\Depreciation;
    interface Depreciation
    {
        public function get_fixed_asset_depreciation_details();
        public function datewise_balance_sheet($to_date,$account_no_pk);
        public function datewise_balance_sheet_without_depreciation($from_date,$to_date,$account_no_pk = null);
        public function fixedAssetDepreciationDaily($to_date,$account_no_pk = null);
        public function lastMonthDepreciation($account_no_pk);
    }
?>