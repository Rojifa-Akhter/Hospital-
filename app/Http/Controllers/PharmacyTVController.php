<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\TV\PharmacyTVService;

class PharmacyTVController extends Controller
{
    protected $pharmacy_tv_information;

    public function __construct(PharmacyTVService $pharmacy_tv_information)
    {
        $this->pharmacy_tv_information = $pharmacy_tv_information;
    }

    public function index($id = ""){
        return view('admin.tv_screen.pharmacy_tv.pharmacy_tv');
    }

    public function defaultTVShow($id){
        $data = $this->pharmacy_tv_information->get_pharmacy_tv_data($id);
        // dd(  $data);
        return response()->json(['title'=> 'success', 'data' => $data],200);
    }
}
