<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionFreeTextController extends Controller
{
    //
    public function prescriptionFreeText(Request $request){
        dd($request->all());
    }
}
