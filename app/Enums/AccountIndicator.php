<?php

namespace App\Enums;

class AccountIndicator
{
    const BANK = 1;
    const CASH = 2;
    const OTHERS = 3;
    const PETTY_CASH = 4;
    const CARD = 5;
    const CHEQUE = 6;
    const MOBILE_BANKING = 7;

    public static function getLabel($value)
    {
        $labels = [
            self::BANK => 'Bank',
            self::CASH => 'Cash',
            self::OTHERS => 'Others',
            self::PETTY_CASH => 'Petty Cash',
            self::CARD => 'Card',
            self::CHEQUE => 'Cheque',
            self::MOBILE_BANKING => 'Mobile Banking',
        ];

        return $labels[$value] ?? null;
    }

    public static function getValues()
    {
        return [
            self::BANK,
            self::CASH,
            self::OTHERS,
            self::PETTY_CASH,
            self::CARD,
            self::CHEQUE,
            self::MOBILE_BANKING,
        ];
    }

    public static function getOptions()
    {
        return [
            self::BANK => 'Bank',
            self::CASH => 'Cash',
            self::OTHERS => 'Others',
            self::PETTY_CASH => 'Petty Cash',
            self::CARD => 'Card',
            self::CHEQUE => 'Cheque',
            self::MOBILE_BANKING => 'Mobile Banking',
        ];
    }
}