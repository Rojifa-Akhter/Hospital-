<?php

namespace App\Enums;

class FundTransferType
{
    const DIRECT_PAYMENT = 'DP';
    const RECEIPT = 'RC';
    const REFUND = 'RF';

    public static function getLabel($value)
    {
        $labels = [
            self::DIRECT_PAYMENT => 'Direct Payment',
            self::RECEIPT => 'Receipt',
            self::REFUND => 'Refund',
        ];

        return $labels[$value] ?? null;
    }

    public static function getValues()
    {
        return [
            self::DIRECT_PAYMENT,
            self::RECEIPT,
            self::REFUND,
        ];
    }

    public static function getOptions()
    {
        return [
            self::DIRECT_PAYMENT => 'Direct Payment',
            self::RECEIPT => 'Receipt',
            self::REFUND => 'Refund',
        ];
    }
}