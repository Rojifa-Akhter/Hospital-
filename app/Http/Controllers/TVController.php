<?php

namespace App\Http\Controllers;

use App\Events\TVUpdate;
use App\Library\Template;
use App\Core\TV\TVService;
use Illuminate\Http\Request;

class TVController extends Controller
{

    protected $tv_information;

    public function __construct(TVService $tv_information)
    {
        $this->tv_information = $tv_information;
    }

    public function index($id = ""){
        return view('admin.tv_screen.tv');
    }


    public function defaultTVShow($id){
        $data = $this->tv_information->get_tv_data($id);
        return response()->json(['title'=> 'success', 'data' => $data],200);
    }
}
