<?php

namespace App\Core\Ambulance;

use Illuminate\Http\Request;

interface Ambulance
{
    public function ambulanceList();
    public function tripList($id);
    public function ambulanceTripSave($request);
    public function bockedTripList();
    public function CompletedTripList();
    public function fineAmbulanceInfo($id);
    public function allAmbulanceInfo();
    public function ambulanceSetupSave($request);
}
