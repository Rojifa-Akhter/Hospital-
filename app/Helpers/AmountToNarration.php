<?php

namespace App\Helpers;

class AmountToNarration
{
    private static $ones = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
        'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 
        'Seventeen', 'Eighteen', 'Nineteen'
    ];

    private static $tens = [
        '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 
        'Sixty', 'Seventy', 'Eighty', 'Ninety'
    ];

    private static $thousands = ['', 'Thousand', 'Lakh', 'Crore'];

    /**
     * Convert amount to Bangladeshi Taka narration
     *
     * @param float|int|string $amount
     * @return string
     */
    public static function convert($amount): string
    {
        if (!is_numeric($amount)) {
            return 'Invalid amount';
        }

        $amount = (float) $amount;
        
        // Handle zero amount
        if ($amount == 0) {
            return 'Zero Taka Only';
        }

        // Handle negative amounts
        $negative = '';
        if ($amount < 0) {
            $negative = 'Negative ';
            $amount = abs($amount);
        }

        // Split into Taka and Poisha
        $taka = (int) $amount;
        $poisha = round(($amount - $taka) * 100);

        $takaWords = self::convertToWords($taka);
        $poishaWords = self::convertToWords($poisha);

        $result = $negative . $takaWords . ' Taka';

        if ($poisha > 0) {
            $result .= ' and ' . $poishaWords . ' Poisha';
        }

        return $result . ' Only';
    }

    /**
     * Convert number to words
     *
     * @param int $number
     * @return string
     */
    private static function convertToWords(int $number): string
    {
        if ($number == 0) {
            return '';
        }

        $words = '';
        $index = 0;

        while ($number > 0) {
            if ($number % 1000 != 0) {
                $words = self::convertHundreds($number % 1000) . 
                         (self::$thousands[$index] ? ' ' . self::$thousands[$index] . ' ' : '') . 
                         $words;
            }
            $number = (int)($number / 1000);
            $index++;
        }

        return trim($words);
    }

    /**
     * Convert hundreds place to words
     *
     * @param int $number
     * @return string
     */
    private static function convertHundreds(int $number): string
    {
        $words = '';

        // Handle hundreds place
        if ($number >= 100) {
            $words .= self::$ones[(int)($number / 100)] . ' Hundred ';
            $number %= 100;
        }

        // Handle tens and ones place
        if ($number >= 20) {
            $words .= self::$tens[(int)($number / 10)];
            if ($number % 10 > 0) {
                $words .= '-' . self::$ones[$number % 10];
            }
        } else if ($number > 0) {
            $words .= self::$ones[$number];
        }

        return trim($words);
    }

    /**
     * Helper method for quick conversion
     *
     * @param float|int|string $amount
     * @return string
     */
    public static function takaToWords($amount): string
    {
        return self::convert($amount);
    }
}