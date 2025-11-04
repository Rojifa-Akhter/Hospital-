<?php
/**
 * Created by PhpStorm.
 * User: jahid
 * Date: 19/02/2020
 * Time: 4:58 PM
 */
namespace App\Library;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class BarcodeGen
{
    /**
     * @author Jahid Hasan <jahid0209@gmail.com>
     * @param string $pageName defining page name
     * @param array $data defining dynamic values passed to view
     * @return custom view
     */
    public static function generateBarcode($barcode_text, $barcode_type="Code128", $scale=1, $thickness=25, $font_size=10)
    {
        $barcode = new BarcodeGenerator();
        $barcode->setText($barcode_text);
        $barcode->setType(BarcodeGenerator::$barcode_type);
        $barcode->setScale($scale);
        $barcode->setThickness($thickness);
        $barcode->setFontSize($font_size);
        return $barcode->generate();
    }
}