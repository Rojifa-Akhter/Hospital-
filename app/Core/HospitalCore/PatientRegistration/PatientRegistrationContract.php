<?php

namespace App\Core\HospitalCore\PatientRegistration;

interface PatientRegistrationContract {
    public function create_patient();
    public function save_patient(array $data);
    public function update_patient(array $data);
}