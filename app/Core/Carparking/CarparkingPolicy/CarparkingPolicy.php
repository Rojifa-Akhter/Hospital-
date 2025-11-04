<?php

namespace App\Core\Carparking\CarparkingPolicy;

use Illuminate\Http\Request;

interface CarparkingPolicy
{
    public function carparking();
    public function carparkingData(Request $request);
}
