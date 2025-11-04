<?php

use Carbon\Carbon;

function number_to_words($number, $full_unit = '', $half_unit = "")
{
    // This function returns amount in word
    // uses :: echo number_to_words("55555555250", "USD", "CENTS");

    //$number = str_replace(",", "", $number);
    if (($number < 0) || ($number > 99999999999)) {
        throw new Exception("Number is out of range");
    }
    //echo $number .",". $full_unit .",". $half_unit;
    $number = explode('.', $number);

    if ($number[1] == "" || $number == 0) {
        $result1 = " " . $full_unit;
        $number = $number[0];
    } else {
        //print_r($number);die;
        $number[1] = str_pad($number[1], 2, "0", STR_PAD_RIGHT);
        $result1 = " " . $full_unit . " and " . number_to_words($number[1]) . " " . $half_unit;
        $number = $number[0];
    }

    die;
    $Cn = floor($number / 10000000); /* Crore (giga) */
    $number -= $Cn * 10000000;

    // $Gn = floor($number / 1000000);  /* Millions (giga) */
    //$number -= $Gn * 1000000;

    $Ln = floor($number / 100000); /* Lacs (giga) */
    $number -= $Ln * 100000;

    $kn = floor($number / 1000); /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100); /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10); /* Tens (deca) */
    $n = $number % 10; /* Ones */

    $result = "";
    if ($Cn) {
        $result .= number_to_words($Cn) . " Crore ";
    }

    /* if ($Gn)
            {  $result .= number_to_words($Gn) . " Million ";  }
    */
    if ($Ln) {
        $result .= number_to_words($Ln) . " Lac ";
    }

    if ($kn) {
        $result .= (empty($result) ? "" : " ") . number_to_words($kn) . " Thousand ";
    }

    if ($Hn) {
        $result .= (empty($result) ? "" : " ") . number_to_words($Hn) . " Hundred ";
    }

    $ones = array(
        "", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen"
    );
    $tens = array(
        "", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety"
    );

    if ($Dn || $n) {
        if (!empty($result)) {
            $result .= " and ";
        }

        if ($Dn < 2) {
            $result .= $ones[$Dn * 10 + $n];
        } else {
            $result .= $tens[$Dn];
            if ($n) {
                $result .= "-" . $ones[$n];
            }
        }
    }

    if (empty($result)) {
        $result = "Zero";
    }

    return "$result " . " $result1";
}

function bangladeshiFormat($number, $decimals = 0)
{

    // $number = 555;
    // $decimals=0;
    // $number = 555.000;
    // $number = 555.123456;

    if (strpos($number, '.') != null) {
        $decimalNumbers = substr($number, strpos($number, '.'));
        $decimalNumbers = substr($decimalNumbers, 1, $decimals);
    } else {
        $decimalNumbers = 0;
        for ($i = 2; $i <= $decimals; $i++) {
            $decimalNumbers = $decimalNumbers . '0';
        }
    }
    // return $decimalNumbers;



    $number = (int) $number;
    // reverse
    $number = strrev($number);

    $n = '';
    $stringlength = strlen($number);

    for ($i = 0; $i < $stringlength; $i++) {
        if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
            $n = $n . $number[$i] . ',';
        } else {
            $n = $n . $number[$i];
        }
    }

    $number = $n;
    // reverse
    $number = strrev($number);

    ($decimals != 0) ? $number = $number . '.' . $decimalNumbers : $number;

    return $number;
}

function getBangladeshCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? null : null;
            $hundred = ($counter == 1 && $str[0]) ? ' And ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else $str[] = null;
    }
    $Taka = implode('', array_reverse($str));
    $poysa = ($decimal) ? " And " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paisa' : '';
    return ($Taka ? $Taka . 'Taka ' : '') . $poysa . " Only";
}

function countFridaysInMonth($year, $month)
{

    $startDate = Carbon::create($year, $month, 1);
    $endDate = $startDate->copy()->endOfMonth();

    $fridayCount = 0;

    while ($startDate <= $endDate) {
        if ($startDate->isFriday()) {
            $fridayCount++;
        }

        $startDate->addDay();
    }

    return $fridayCount;
}

// count fridays between two date range
function countFridays($startDate, $endDate) {
    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);
    $count = 0;
    while ($startDate->lte($endDate)) {
        // Check if the current day is Friday (dayOfWeek returns 5 for Friday)
        if ($startDate->dayOfWeek == Carbon::FRIDAY) {
            $count++;
        }

        // Move to the next day
        $startDate->addDay();
    }

    return $count;
}
// count no of days between two date range
function countDays($startDate, $endDate) {
    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);
    $daysDifference = $startDate->diffInDays($endDate);
    return $daysDifference;
}
//get previous month specific date from current month year
function getPreviousMonthSpecificDate($currentMonthYear, $specificDay) {
    $currentDate = Carbon::createFromFormat('Ym', $currentMonthYear)->startOfMonth();
    $previousMonthDate = $currentDate->subMonth()->setDay($specificDay);
    return $previousMonthDate;
}
//get current month specific date from current month year
function getCurrentMonthSpecificDate($currentMonthYear, $specificDay) {
    $currentDate = Carbon::createFromFormat('Ym', $currentMonthYear)->startOfMonth();
    $currentMonthDate = $currentDate->setDay($specificDay);

    return $currentMonthDate;
}

/**
 * Get all dates between 2 date ranges
 * @param $date_time_from
 * @param $date_time_to
 * @param $format <optional>
 *
 * @return array
 */
function getDatesFromRange($date_time_from, $date_time_to, $format = 'Y-m-d')
{
    $start  = Carbon::createFromFormat($format, substr($date_time_from, 0, 10));
    $end    = Carbon::createFromFormat($format, substr($date_time_to, 0, 10));

    $dates = [];
    while ($start->lte($end)) {
        $dates[] = $start->copy()->format($format);
        $start->addDay();
    }

    return $dates;
}

function calculatedLeaves($late, $sl=0, $cl=0, $el=0) {
    $prevSl = $sl;
    $prevCl = $cl;
    $prevEl = $el;
    $absent = 0;

    if ($late <= $cl) {
        $cl -= $late;
    } else {
        $late -= $cl;
        $cl = 0;

        if ($late <= $el) {
            $el -= $late;
        } else {
            $late -= $el;
            $el = 0;

            if ($late <= $sl) {
                $sl -= $late;
            } else {
                $absent = $late - $sl;  // Calculate absent days
                $sl = 0;
            }
        }
    }

    return [
        'SL' => $prevSl - $sl,
        'CL' => $prevCl - $cl,
        'EL' => $prevEl - $el,
        'ABSENT' => $absent,
    ];
}

function calculateAgeInDays($dob, $admission_date) {
    $dob = Carbon::createFromFormat('Y-m-d H:i:s', $dob);
    $admission_date = Carbon::createFromFormat('Y-m-d H:i:s', $admission_date);
    // $today = Carbon::today();
    $ageInDays = $dob->diffInDays($admission_date);
    return $ageInDays;
}

function getFridaysOfMonthOfYear($year, $month)
{
    $fridays = [];
    // Start from the first day of the month
    $date = Carbon::create($year, $month, 1);
    // Loop through the month
    while ($date->month == $month) {
        if ($date->isFriday()) {
            $fridays[] = $date->format('Y-m-d H:i:s');
        }
        $date->addDay();
    }

    return $fridays;
}
