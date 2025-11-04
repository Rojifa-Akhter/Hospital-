<?php

namespace App\Core\Accounts\CashFlowCategory;


interface CashFlowCategory
{
    public function addCashFlowCategory(array $data);
    public function updateCashFlowCategory(array $data);
    public function deleteCashFlowCategoryById($id);
    public function getCashFlowCategories();
    public function getCashFlowCategoryById();
}