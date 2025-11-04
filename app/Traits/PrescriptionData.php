<?php

namespace App\Traits;

use App\Models\Policy;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

trait PrescriptionData
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPrescAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $presc_info = db::table("prest_prescriptionmst_physio_vw pres")
            ->select('pres.prescription_no_pk', 'pres.prescription_code','pt.patient_type_code','ptv.maximum_percent','ptv.patient_type_no_pk','pres.admission_no_fk')
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'pres.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'pres.patient_type')
            ->whereRaw(DB::raw("(upper(pres.prescription_code) like '%$keyword%')"))->get();

        $presc_data = [];
        if (!empty($presc_info)) {
            foreach ($presc_info as $presc) {
                $presc_data[] =  array(
                    'prescription_id'       => $presc->prescription_no_pk,
                    'prescription_code'     => $presc->prescription_code,
                    'patient_type_code'   => $presc->patient_type_code,
                    'maximum_percent'   => $presc->maximum_percent,
                    'patient_type_no_pk'   => $presc->patient_type_no_pk,
                    'admission_no_fk'   => $presc->admission_no_fk,
                );
            }
            return $presc_data;
        }
    }
}
