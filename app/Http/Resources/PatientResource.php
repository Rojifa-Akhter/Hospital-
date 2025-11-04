<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'admission_date' => date('d/m/Y', strtotime($this->admission_date)),
            'patient_name' => $this->patient_name,
            'ward_name' => $this->ward_name,
            'bed_name' => $this->bed_name,
            'gender_txt' => $this->gender_txt,
            'admitted_department' => $this->admitted_department,
            'age' => $this->age,
            'diagnosis' => $this->diagnosis,
            'purpose_off_reff' => $this->purpose_off_reff,
            'estimated_duration_surge' => $this->estimated_duration_surge,
            'specific_req_n_remarks' => $this->specefic_req_n_remarks,
            'reff_date' => date('d/m/Y', strtotime($this->reff_date)),
            'req_dept_name' => $this->req_dept_name,
            'urgency_details' => $this->urgency_details,
            'surgen_name' => $this->surgen_name,
            'surgen_no_fk' => $this->surgen_no_fk,
            'nurse_name' => $this->nurse_name,
            'user_no_pk' => $this->user_no_pk,
            'prescription_no_fk' => $this->prescription_no_fk,
            'user_name' => $this->user_name,
            'req_given_date' => date('d/m/Y', strtotime($this->req_given_date)),
            'reff_anes_dept_no_pk' => $this->reff_anes_dept_no_pk,
            'photo_url' => asset('images/uploads/patient_images/thumb/' . $this->patient_photo),
            'requisition_date' => date('d/m/y', strtotime($this->reff_date)),
        ];

    }
}
