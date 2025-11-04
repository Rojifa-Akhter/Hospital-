<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use \PDF;
use Session;
use PDO;
use PhpParser\Node\Stmt\Else_;

trait UtilitiesTrait
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImages($files, $image_name, $path, $thumb_path = "")
    {
        // for save original image
        $ImageUpload = Image::make($files);
        $ImageUpload->orientate();
        $originalPath = public_path($path);
        $ImageUpload->save($originalPath . $image_name . "." . $files->getClientOriginalExtension());

        // for save thumnail image
        $thumbnailPath = public_path($thumb_path);
        $ImageUpload->resize(100, 100);
        $ImageUpload = $ImageUpload->save($thumbnailPath . $image_name . "." . $files->getClientOriginalExtension());
    }

    public function generatePdf(
        string $dataFile,
        string $fileToExport,
        array $data,
        bool $download = false,
        array $options = []
    ) {
        try {
            $pdf = PDF::loadView($dataFile, $data);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - (!empty($options['x']) ?: 20);
            $x = $canvas->get_width() - (!empty($options['y']) ?: 65);
            $text = !empty($options['text']) ?: "Page No: {PAGE_NUM} of {PAGE_COUNT}";
            $font = !empty($options['font']) ?: 'serif';;
            $size = !empty($options['size']) ?: 8;
            $color = !empty($options['color']) ?: array(255, 0, 0);
            $wordSpace = !empty($options['word_space']) ?: 0.0;  //  default
            $charSpace = !empty($options['color_space']) ?: 0.0;  //  default
            $angle = !empty($options['angle']) ?: 0.0;   //  default
            $canvas->page_text($x, $y, $text, $font, $size, $color, $wordSpace, $charSpace, $angle);
            //            $canvas->page_script($pdf->set_opacity(.5), $pdf->image("/path/to/image.png", 'x', 'y', 'w', 'h'));

            if (!empty($fileToExport)) {
                if ($download) {
                    return $pdf->download("{$fileToExport}.pdf");
                }
                return $pdf->stream("{$fileToExport}.pdf");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function generateExcel(string $dataFile, string $fileToExport, array $data)
    {
        $html = View($dataFile)->with($data);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }
    public function getServiceUnitByInd($column_name)
    {
        $su_data = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->where($column_name, 1)
            ->orderBy('serviceunit_name', 'asc')
            ->get();

        $su_arr = [];
        if (!empty($su_data)) {
            foreach ($su_data as $row) {
                $su_arr[$row->serviceunit_no_pk] = $row->serviceunit_name;
            }
        }

        return $su_arr;
    }
    public function getPathologyResultEntryByUser($indicator, $labresult_list1_ind = "", $service_unit_pk = "")
    {
        $user_arr = [];
        $hospital_id = Session::get('user.ses_hospital_no_pk');
       
        if (Session::get('user.ses_hospital_code') =="AMCSH") {
            if ($service_unit_pk != "") {

                $entry_by_user_info = DB::table("sysc_grant_su")
                    ->select("sysc_grant_su.*","hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
                    ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
                    ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
                    ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
                    ->where('sysc_serviceunit.pathology_ind', 1)
                    ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
                    ->where('sysc_grant_su.su_no_fk', $service_unit_pk)
                    ->where("$indicator", 1)
                    // ->where("$labresult_list1_ind", 1)
                    ->orderBy("hrms_personnel.full_name", "asc");
             
              
            } else {
                $entry_by_user_info = DB::table("sysc_grant_su")
                    ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
                    ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
                    ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
                    ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
                    ->where('sysc_serviceunit.pathology_ind', 1)
                    ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
                    ->where("$indicator", 1)
                    // ->where("$labresult_list1_ind", 1)
                    ->orderBy("hrms_personnel.full_name", "asc");
                  
            }
        }elseif (in_array(Session::get('user.ses_hospital_code'),["EWMCH","IMPERIAL"])){
           
            if ($service_unit_pk != "") {

                $entry_by_user_info = DB::table("sysc_grant_su")
                    ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
                    ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
                    ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
                    ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
                    ->where('sysc_serviceunit.pathology_ind', 1)
                    ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
                    ->where('sysc_grant_su.su_no_fk', $service_unit_pk)
                    // ->where("$indicator", 1)
                    ->where("$labresult_list1_ind", 1)
                    ->orderBy("hrms_personnel.full_name", "asc");
                    // dd( $service_unit_pk,$indicator,$labresult_list1_ind , $entry_by_user_info->get());
            } else {
                $entry_by_user_info = DB::table("sysc_grant_su")
                    ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
                    ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
                    ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
                    ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
                    ->where('sysc_serviceunit.pathology_ind', 1)
                    ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
                    ->where("$indicator", 1)
                    ->orderBy("hrms_personnel.full_name", "asc");
            }
        }else{
            if ($service_unit_pk != "") {

                $entry_by_user_info = DB::table("sysc_grant_su")
                    ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
                    ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
                    ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
                    ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
                    ->where('sysc_serviceunit.pathology_ind', 1)
                    ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
                    ->where('sysc_grant_su.su_no_fk', $service_unit_pk)
                    ->where("$indicator", 1)
                    ->orderBy("hrms_personnel.full_name", "asc");
                    // dd($indicator,$entry_by_user_info->get());
                    
            } else {
                $entry_by_user_info = DB::table("sysc_grant_su")
                    ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
                    ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
                    ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
                    ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
                    ->where('sysc_serviceunit.pathology_ind', 1)
                    ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
                    ->where("$indicator", 1)
                    ->orderBy("hrms_personnel.full_name", "asc");
                  
            }
        }
        // dd($entry_by_user_info->get() );
        //dd( $service_unit_pk ,$entry_by_user_info->get());

        // if ($labresult_list1_ind !="") {
        //     $entry_by_user_info->where("$labresult_list1_ind", 1)->get();
        //     dd($entry_by_user_info);
        // }


        // if ($labresult_list1_ind != "") {
        //     $entry_by_user_info->when($labresult_list1_ind, function ($query, $labresult_list1_ind) {
        //         return $query->where($labresult_list1_ind, 1);
        //     });
        // }
        // if (Session::get('user.ses_hospital_code')=="UNICO") {
        //     $entry_by_user_info->where('sysc_grant_su.user_no_fk',Auth::id());
        // }
        $entry_by_user_infos = $entry_by_user_info->get();
        // dd( $entry_by_user_infos);
        //    dd($entry_by_user_infos);
        if (!empty($entry_by_user_infos)) {
            foreach ($entry_by_user_infos as $row) {
                $user_arr[$row->person_no_pk] = $row->full_name . "_" . $row->serviceunit_name;
            }
        }

        return $user_arr;
    }
    public function getPathologyResultEntryByUserMic($indicator, $labresult_list1_ind = "")
    {
        $user_arr = [];
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $service_unit_no = Session::get('user.su_pk_no');
        $entry_by_user_info = DB::table("sysc_grant_su")
            ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name", "sysc_grant_su.user_no_fk")
            ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
            ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
            ->leftjoin("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
            ->where('sysc_serviceunit.pathology_ind', 1)
            ->where('hrms_personnel.serviceunit_no_fk', $service_unit_no)
            ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
            ->where("$indicator", 1)
            ->orderBy("hrms_personnel.full_name", "asc");

        // if ($labresult_list1_ind !="") {
        //     $entry_by_user_info->where("$labresult_list1_ind", 1)->get();
        //     dd($entry_by_user_info);
        // }


        if ($labresult_list1_ind != "") {
            $entry_by_user_info->when($labresult_list1_ind, function ($query, $labresult_list1_ind) {
                return $query->where($labresult_list1_ind, 1);
            });
        }

        $entry_by_user_infos = $entry_by_user_info->get();
        //    dd($entry_by_user_infos);
        if (!empty($entry_by_user_infos)) {
            foreach ($entry_by_user_infos as $row) {
                $user_arr[$row->person_no_pk] = $row->full_name . "_" . $row->serviceunit_name;
            }
        }

        return $user_arr;
    }
    public function getRadiologyResultEntryByUser($indicator)
    {
        // dd($indicator);
        $user_arr = [];
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_code= Session::get('user.ses_hospital_code');
        if ($hospital_code != 'UNICO') {
            $entry_by_user_info = DB::table("sysc_grant_su")
            ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name")
            ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
            ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
            ->join("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
            ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
            ->whereRaw("sysc_serviceunit.radiology_ind = 1")



            // ->whereRaw("sysc_serviceunit.serviceunit_no_pk='1100' or sysc_serviceunit.radiology_ind = 1")
            ->whereRaw($indicator . " =1")
            ->get();
        } else {
           $entry_by_user_info = DB::table("sysc_grant_su")
            ->select("hrms_personnel.person_no_pk", "hrms_personnel.full_name", "sysc_serviceunit.serviceunit_code", "sysc_serviceunit.serviceunit_name")
            ->join("wsec_user", "sysc_grant_su.user_no_fk", "=", "wsec_user.user_no_pk")
            ->join("hrms_personnel", "wsec_user.person_no_fk", "=", "hrms_personnel.person_no_pk")
            ->join("sysc_serviceunit", "hrms_personnel.serviceunit_no_fk", "=", "sysc_serviceunit.serviceunit_no_pk")
            ->where('sysc_grant_su.au_entry_hospital_no_fk', $hospital_id)
           ->where('user_no_fk', Auth::user()->user_no_pk)
            ->whereRaw("sysc_serviceunit.radiology_ind = 1")



            // ->whereRaw("sysc_serviceunit.serviceunit_no_pk='1100' or sysc_serviceunit.radiology_ind = 1")
            ->whereRaw($indicator . " =1")
            ->get();
        }

        
        // dd($entry_by_user_info);



        if (!empty($entry_by_user_info)) {
            foreach ($entry_by_user_info as $row) {
                $user_arr[$row->person_no_pk] = $row->full_name . "_" . $row->serviceunit_name;
            }
        }

        return $user_arr;
    }

    /*------------------------------------------------------------------------------------------
    / This FUnction is created for generate AutoUID for all table in H360. Developed By MAI.
    /------------------------------------------------------------------------------------------*/

    public function getAutoGenerateUID($in_table_name_txt, $in_column_name_txt, $in_hos_yyyymmdd_ind = '', $in_special_code = "")
    {
        try {
            $out_uid = '';
            $pdo                        = DB::getPdo();
            $in_au_entry_by             = auth()->user()->user_no_pk;
            $in_au_entry_session        = "Auto Generate";
            $in_au_entry_hospital_pk_no = session('user.ses_hospital_no_pk');
            $stmt = $pdo->prepare("begin pkg_tools.prc_getuid(
                :in_table_name_txt,
                :in_column_name_txt ,
                :in_hos_yyyymmdd_ind,
                :in_special_code,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :out_uid
            );
                end;"); //,:in_is_manual_sl

            $stmt->bindParam(':in_table_name_txt', $in_table_name_txt);
            $stmt->bindParam(':in_column_name_txt', $in_column_name_txt);
            $stmt->bindParam(':in_hos_yyyymmdd_ind', $in_hos_yyyymmdd_ind);
            $stmt->bindParam(':in_special_code', $in_special_code);
            $stmt->bindParam(':in_au_entry_by', $in_au_entry_by);
            $stmt->bindParam(':in_au_entry_session', $in_au_entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
            $stmt->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);

            $stmt->execute();
            return $out_uid;
        } catch (Exception $e) {
            return '';
        }
    }
}
