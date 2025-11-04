<?php

namespace App\Http\Controllers\HRM;

use PDO;
use Exception;
use PDF;
use App\Library\Template;
use App\Models\Designation;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmployeePhoneBookController extends Controller
{
    public function employeePhoneBook()
    {
        $designation  = DB::table('sysc_phonebook')
                                ->select('designation')
                                ->groupBy('designation')
                                ->orderByRaw('lower(designation) asc')->get();

        $department = DB::table('sysc_phonebook')
                                ->select('department')
                                ->groupBy('department')
                                ->orderByRaw('lower(department) asc')->get();

        return Template::loadView("admin.v1.employee.employee-phonebook", [
            'designation' => $designation,
            'department' => $department
        ]);
    }

    public function searchEmployeePhoneBook(Request $request)
    {
        $query = DB::table('sysc_phonebook');
        if (!empty($request->name)) {
            $query->whereRaw("LOWER(full_name) LIKE LOWER(?)", ["%{$request->name}%"]);
        }
        if (!empty($request->department)) {
            $query->where('department', $request->department);
        }
        if (!empty($request->designation)) {
            $query->where('designation', $request->designation);
        }
        $data = $query->get();
        return response()->json(['data'=> $data,'success' => true], 200);
    }
    public function searchEmployeePhoneBookPDF(Request $request)
    {

        ini_set('max_execution_time',0);
        $query = DB::table('sysc_phonebook');
        if (!empty($request->name)) {
            $query->whereRaw("LOWER(full_name) LIKE LOWER(?)", ["%{$request->name}%"]);
        }
        if (!empty($request->department)) {
            $query->where('department', $request->department);
        }
        if (!empty($request->designation)) {
            $query->where('designation', $request->designation);
        }
        $data = $query->get();
    
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.v1.employee.employee-phonebook-pdf", ['employee_list' =>  $data, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');

        return $pdf->stream('employee-phonebook.pdf');


    }

}
