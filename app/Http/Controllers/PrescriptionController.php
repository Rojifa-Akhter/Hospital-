<?php

namespace App\Http\Controllers;

use \PDF;
use stdClass;
use Exception;
use Carbon\Carbon;
use Dompdf\Options;
use App\Models\Doctor;
use App\Models\Allergy;
use App\Events\TVUpdate;
use App\Library\Template;
use App\Models\IIEFModel;
use App\Models\IPSSModel;
use App\Core\TV\TVService;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use App\Traits\PatientData;
use App\Models\Prescription;
use App\Models\PresFavourit;
use Illuminate\Http\Request;
use App\DoctorScheduleDayOff;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\ChronicDisease;
use App\Models\Therapy_Details;
use App\Traits\PrescriptionData;
use App\Datatables\DataTableClass;
use App\Models\PrescriptionLookup;
use Illuminate\Support\Facades\DB;
use App\Models\PhysioAssementModel;
use App\Http\Controllers\Controller;
use App\Models\PrescriptionTemplate;
use Illuminate\Support\Facades\Auth;
use App\Models\PrescriptionTemplateDtl;
use Illuminate\Support\Facades\Session;
use App\Models\ErectileDysFunctionModel;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\PrescriptionRepository;
use App\Http\Requests\PrescriptionBlockSlotRequest;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Http\Requests\PrescriptionUnblockSlotRequest;


//use DateTime;

class PrescriptionController extends Controller
{
    use LookupData, PrescriptionData, PatientData;
    protected $prescriptionRepository, $ServiceUnit, $ipssmodel, $iiefmodel, $therapy_details;
    protected $tv_information;
    public function __construct(Prescription $prescription, PhysioAssementModel $physioassementmodel, PresFavourit $presfavourit, ServiceUnit $serviceunit, IPSSModel $IPSSModel, IIEFModel $IIEFModel, ErectileDysFunctionModel $erectileModel, Therapy_Details $therapy_details, DoctorScheduleDayOff $doctorScheduleDayOff, TVService $tv_information)
    {
        $this->middleware('auth');
        $this->model = new Repo($prescription);
        $this->favouritmodel = new Repo($presfavourit);
        $this->prescriptionRepository = new PrescriptionRepository($prescription, $physioassementmodel, $IPSSModel, $IIEFModel, $erectileModel, $therapy_details, $tv_information);
        $this->ServiceUnit = new Repo($serviceunit);
        // $this->ipssmodel = new Repo($IPSSModel);
        // $this->iiefmodel = new Repo($IIEFModel);
        $this->doctorScheduleDayOff = new Repo($doctorScheduleDayOff);
        $this->tv_information = $tv_information;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $physicians = $this->getLookupListByCode("PHYSICIAN");
        $opticians = $this->getLookupListByCode("OPTICIAN");
        $lens_types = $this->getLookupListByCode("LENSTYPE");
        $lens_materials = $this->getLookupListByCode("LENSEMAT");
        $best_brands = $this->getLookupListByCode("BRAND");
        $spheres = $this->getLookupListByCode("SPHERE");
        $cylinders = $this->getLookupListByCode("CYLINDER");
        $axis = $this->getLookupListByCode("AXIS");
        $adds = $this->getLookupListByCode("ADD");
        $prism1 = $this->getLookupListByCode("PRISM1");
        $base1 = $this->getLookupListByCode("BASE1");
        $prism2 = $this->getLookupListByCode("PRISM2");
        $base2 = $this->getLookupListByCode("BASE2");
        $tinks = $this->getLookupListByCode("TINTCOLOR");
        $status = $this->getLookupListByCode("STATUS");
        $clsol = $this->getLookupListByCode("CLSOL");
        $colors = $this->getLookupListByCode("COLOR");
        $width = $this->getLookupListByCode("WIDTH");

        return Template::loadview("admin.prescription.eye_section.prescription", [
            'gender' => $gender,
            'marsts' => $marsts,
            'bloodg' => $bloodg,
            'physicians' => $physicians,
            'opticians' => $opticians,
            'lens_types' => $lens_types,
            'lens_materials' => $lens_materials,
            'best_brands' => $best_brands,
            'spheres' => $spheres,
            'cylinders' => $cylinders,
            'axis' => $axis,
            'adds' => $adds,
            'prism1' => $prism1,
            'base1' => $base1,
            'prism2' => $prism2,
            'base2' => $base2,
            'tinks' => $tinks,
            'status' => $status,
            'clsol' => $clsol,
            'colors' => $colors,
            'width' => $width,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'doctor_person_no_fk' => $request->physician,
                'optician_person_no_fk' => $request->optician,
                'rx_note_print' => $request->rx_note_priented,
                'rx_type' => $request->rx_type,
                'prescription_date' => date('Y-m-d', strtotime($request->rx_date)),
                'expiry_date' => date('Y-m-d', strtotime($request->rx_expiry_date)),
                'gls_lens_type_lookup_fk_no' => $request->lens_type,
                'lens_supplier_lookup_fk_no' => $request->lens_supplier,
                'lens_brand_lookup_fk_no' => $request->lens_brand,
                'gls_lens_material_lookup_fk_no' => $request->lens_material,
                'gls_dpd_od' => $request->gls_dpd_od,
                'gls_dpd_os' => $request->gls_dpd_os,
                'gls_dpd_ou' => $request->gls_dpd_ou,
                'gls_npd_od' => $request->gls_npd_od,
                'gls_npd_os' => $request->gls_npd_os,
                'gls_npd_ou' => $request->gls_npd_ou,
                'gls_sphere_od' => $request->gls_sphere_od,
                'gls_sphere_os' => $request->gls_sphere_os,
                'gls_cylinder_od' => $request->gls_cylinder_od,
                'gls_cylinder_os' => $request->gls_cylinder_os,
                'gls_axis_od' => $request->gls_axis_od,
                'gls_axis_os' => $request->gls_axis_os,
                'gls_add_od' => $request->gls_add_od,
                'gls_add_os' => $request->gls_add_os,
                'gls_prism1_od' => $request->gls_prism1_od,
                'gls_prism1_os' => $request->gls_prism1_os,
                'gls_base1_od' => $request->gls_base1_od,
                'gls_base1_os' => $request->gls_base1_os,
                'gls_prism2_od' => $request->gls_prism2_od,
                'gls_prism2_os' => $request->gls_prism2_os,
                'gls_base2_od' => $request->gls_base2_od,
                'gls_base2_os' => $request->gls_base2_os,
                'gls_rx_note_internal' => $request->rx_note_internal,
                'hcl_tint_color_lookup_fk_no' => $request->hard_tint_lens_color,
                'hcl_status_lookup_fk_no' => $request->hard_lens_status,
                'hcl_cl_solution_lookup_fk_no' => $request->hard_lens_cl_solution,
                'hcl_sphere_od' => $request->hard_sphere_od,
                'hcl_cylinder_od' => $request->hard_cylinder_od,
                'hcl_axis_od' => $request->hard_axis_od,
                'hcl_add_od' => $request->hard_lens_add_od,
                'hcl_prism_od' => $request->hard_prism_od,
                'hcl_bc_od' => $request->hard_bc_od,
                'hcl_bc2_od' => $request->hard_bc2_od,
                'hcl_dot_od' => $request->hard_lens_cl_solution,
                'hcl_dot_od' => isset($request->hard_dot_od) ? 1 : null,
                'hcl_sphere_os' => $request->hard_sphere_os,
                'hcl_cylinder_os' => $request->hard_cylinder_os,
                'hcl_axis_os' => $request->hard_axis_os,
                'hcl_add_os' => $request->hard_lens_add_os,
                'hcl_prism_os' => $request->hard_prism_os,
                'hcl_bc_os' => $request->hard_bc_os,
                'hcl_bc2_os' => $request->hard_bc2_os,
                'hcl_dot_os' => $request->hard_lens_cl_solution,
                'hcl_dot_os' => isset($request->hard_dot_os) ? 1 : null,
                'hcl_k1_od' => $request->hard_k1_od,
                'hcl_k1_os' => $request->hard_k1_os,
                'hcl_k2_od' => $request->hard_k2_od,
                'hcl_k2_os' => $request->hard_k2_os,
                'hcl_kaxis_od' => $request->hard_kaxis_od,
                'hcl_kaxis_os' => $request->hard_kaxis_os,
                'hcl_pupdia_od' => $request->hard_pupdia_od,
                'hcl_pupdia_os' => $request->hard_pupdia_os,
                'hcl_aperture_od' => $request->hard_aperture_od,
                'hcl_aperture_os' => $request->hard_aperture_os,
                'hcl_thickness_od' => $request->hard_thickness_od,
                'hcl_thickness_os' => $request->hard_thickness_os,
                'hcl_dispensing_notes' => $request->hard_dispensing_notes,
                'hcl_fitting_notes' => $request->hard_fitting_notes,
                'hcl_od_lense_notes' => $request->hard_od_lense_notes,
                'hcl_os_lense_notes' => $request->hard_os_lens_notes,
                'hcl_cl_rx_notes' => $request->hard_cl_rx_notes,
                'hcl_biomacroscopy' => $request->hard_biomicroscopy_notes,
                'hcl_lid' => $request->hard_lid_notes,
                'hcl_cornea' => $request->hard_cornea,
                'hcl_tears' => $request->hard_tears,
                'status' => isset($request->hard_notes_print) ? 1 : null,
                'scl_tint_color_lookup_fk_no' => $request->soft_tint_lens_color,
                'scl_status_lookup_fk_no' => $request->soft_lens_status,
                'scl_cl_solution_lookup_fk_no' => $request->soft_lens_cl_solution,
                'scl_sphere_od' => $request->soft_sphere_od,
                'scl_sphere_os' => $request->soft_sphere_os,
                'scl_cylinder_od' => $request->soft_cylinder_od,
                'scl_cylinder_os' => $request->soft_cylinder_os,
                'scl_axis_od' => $request->soft_axis_od,
                'scl_axis_os' => $request->soft_axis_os,
                'scl_add_od' => $request->soft_add_od,
                'scl_add_os' => $request->soft_add_os,
                'scl_bc_od' => $request->soft_bc_od,
                'scl_bc_os' => $request->soft_bc_os,
                'scl_diameter_od' => $request->soft_diameter_od,
                'scl_diameter_os' => $request->soft_diameter_os,
                'scl_k1_od' => $request->soft_k1_od,
                'scl_k1_os' => $request->soft_k1_os,
                'scl_k2_od' => $request->soft_k2_od,
                'scl_k2_os' => $request->soft_k2_os,
                'scl_kaxis_od' => $request->soft_kaxis_od,
                'scl_kaxis_os' => $request->soft_kaxis_os,
                'scl_dispensing_notes' => $request->dispensing_notes,
                'scl_fitting_notes' => $request->fitting_notes,
                'scl_od_lense_notes' => $request->od_lens_notes,
                'scl_os_lense_notes' => $request->os_lens_notes,
                'scl_cl_rx_notes' => $request->cl_rx_notes,
                'scl_biomacroscopy' => $request->biomicroscopy_notes,
                'scl_lid' => $request->lid_notes,
                'scl_cornea' => $request->cornea,
                'scl_tears' => $request->tears,
            ];
            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $response = $this->model->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
                // $last_id = $id;
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function prescriptionEntry($appointment_id = "", $patient_id = "")
    {
        $patient_info = DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk', '=', $appointment_id)->first();
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $duration_mu = $this->getPresLookupListByCode("DURMU");
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        // $meddurmu   = $this->getPresLookupListByCode("MEDDURMU", "pres_lookupdata_code");
        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["THRPEX", "ETHER"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }
        return Template::loadview("admin.prescription.prescription_entry", [
            'patient_info' => $patient_info,
            'chiefcom' => $chiefcom,
            'appointment_id' => $appointment_id,
            'patient_id' => $patient_id,
            'duration_mu' => $duration_mu,
            'tr_lk_id_arr' => $tr_lk_id_arr,
            'instructions' => $instructions,
            'dose' => $dose,
            'meddurmu' => $meddurmu
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function prescriptionView()
    {
        return Template::loadview("admin.prescription.prescription_view");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function presFavouritListSaveUpdate(Request $request)
    {
        $doctor_id = Auth::id();
        $id = null;
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        DB::beginTransaction();

        $pres_fav_seq_count = PresFavourit::latest('pres_fav_no_pk')->first();
        $favourit_code = isset($pres_fav_seq_count) ? "FAV-" . ($pres_fav_seq_count->pres_fav_no_pk + 1) : "FAV-" . 1;
        $item_type_arr = ["SERVICE", "SUR", "RAD", "LAB", "MED", "INVFIND", "FINDINGS", "PTTE", "PTET"];

        try {
            $favourit_data = [
                'pres_fav_uid' => $favourit_code,
                'favourite_name' => $request->item_name,
                'su_no_fk' => $request->hdn_su_no ? $request->hdn_su_no : 0,
                'doctor_person_no_fk' => ($request->doctor_id != '') ? $request->doctor_id : $doctor_id,
                'user_no_fk' => $doctor_id,
                'item_type_lookup_code' => $request->item_type,
                'pres_lookup_no_fk' => $request->lookup_id ? $request->lookup_id : 0,
                'duration' => $request->data_duration ? $request->data_duration : 0,
                'route' => $request->data_route ? $request->data_route : 0,
                'dosage' => $request->data_dose ? $request->data_dose : 0,
                'item_qty' => ($request->data_quantity == 'Continue') ? 0 : 0, //$request->data_quantity
                'continue_ind' => ($request->data_quantity == 'Continue') ? 1 : 0,
                'med_instruction' => $request->data_instruction ? $request->data_instruction : 0,
                'duration_mu' => $request->data_duration_type ? $request->data_duration_type : 0
            ];

            if (in_array($request->item_type, $item_type_arr)) {
                 
               if ($request->item_id != $request->item_name && $request->item_id != '[object Object]') {
    //  dd('ok',$request->item_id);
                    $favourit_data['favourite_item_no_fk'] = $request->item_id;
                } else {
                    $favourit_data['favourite_item_no_fk'] = 0;                   
                }
            } else {
                $favourit_data['psn_lookupdata_no_fk'] = $request->item_id;
            }

            if ($id == null) {

                $favourit_data['au_entry_by'] = $doctor_id;
                $favourit_data['au_entry_session'] = 'Session';
                $favourit_data['au_entry_hospital_no_fk'] = $ses_hospital_id;
                $this->favouritmodel->create($favourit_data);
            } else {

                $favourit_data['au_update_by'] = $doctor_id;
                $favourit_data['au_update_hospital_no_fk'] = $ses_hospital_id;
                $this->favouritmodel->update($favourit_data, $id);
            }

            DB::commit();

            //$su_info = $this->ServiceUnit->findByColumn("su_no_pk", $request->hdn_su_no);
            $favourit_data = $this->preFavouritList($request->item_type);
            if (Session::get('user.ses_hospital_code') != 'UNICO') {
                return Template::loadview("admin.components.pres_favourit_list", ['favourit_data' => $favourit_data]);
            } else {
                return Template::loadview("admin.prescription.uhl.pres_favourit_list", ['favourit_data' => $favourit_data]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loadPresFavouritList(Request $request)
    {
        $favourit_data = $this->preFavouritList($request->item_type);

        return Template::loadview("admin.components.pres_favourit_list", ['favourit_data' => $favourit_data]);
    }

    public function loadPresFavouritListUHL(Request $request)
    {
        $favourit_data = $this->preFavouritList($request->item_type);
        return Template::loadview("admin.prescription.uhl.pres_favourit_list", ['favourit_data' => $favourit_data]);
    }

    public function prePysioFavouritList($item_type)
    {
        return DB::table('pres_favorite_pysio_vw')->where('item_type_lookup_code', $item_type)->get();
    }
    public function preFavouritList($item_type)
    {
        //return DB::table('pres_favorite_pysio_vw')->where('item_type_lookup_code', $item_type)->get();
        $type_arr = [];
        $item_type = explode(",", $item_type);
        foreach ($item_type as $type) {
            $type_arr[] = "'" . $type . "'";
        }

        return DB::table('psn_s_favorite_vw')
            ->whereRaw("item_type_lookup_code in(" . implode(",", $type_arr) . ") ")
            ->where('doctor_person_no_fk', Session::get('user.ses_user_pk_no'))
            ->orderBy('favourite_name', 'asc')
            ->get();
    }

    public function presPhysiotherapySaveUpdate(Request $request)
    {
        return $this->prescriptionRepository->physioPresCreateOrUpdate($request);
    }

    public function presOpdSaveUpdate(Request $request)
    {
        if (Session::get('user.ses_hospital_code') == 'IMPALA') {
            return $this->prescriptionRepository->opdPresCreateOrUpdateImpala($request);
        } else {
            return $this->prescriptionRepository->opdPresCreateOrUpdate($request);
        }
    }
    public function presOpdSaveUpdateUHL(Request $request)
    {
        return $this->prescriptionRepository->opdPresCreateOrUpdateUHL($request);
    }
    public function presOpdSaveUpdate2(Request $request)
    {
        return $this->prescriptionRepository->opdPresCreateOrUpdate2($request);
    }
    public function OpdNurseStationVitalsSaveUpdate(Request $request)
    {
        return $this->prescriptionRepository->opdNurseStationVitalsCreateOrUpdate($request);
    }

    public function printPrescription($prescription_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $prescription_mst = DB::table('prest_prescriptionmst_physio_vw')->where('prescription_no_pk', '=', $prescription_id)->first();
        $prescription_dtl = DB::table('prest_prescriptiondtl_physio_vw')->where('prescription_no_pk', '=', $prescription_id)->get();
        $prescription_med = DB::table('prest_prescriptionmed_physio_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_code);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        //$patient_barcode = BarcodeGen::generateBarcode($prescription_mst->patient_code);

        $cc_inv_adv_arr = $cc_inv_adv_item_arr = $cc_electro_arr = $cc_electro_item_arr = $cc_therapeutic_arr = $cc_therapeutic_item_arr = [];
        if (!empty($prescription_dtl)) {
            foreach ($prescription_dtl as $dtl_row) {
                if ($dtl_row->itemtype_lookup_code == "ETHER") {
                    $cc_electro_arr[$dtl_row->itemtype_lookup_code] = $dtl_row->pres_lookup_name;
                    $cc_electro_item_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->presdtl_data . "_" . $dtl_row->session_duration . "_" . $dtl_row->unit_intensity_mu_name . "_" . $dtl_row->unit_intensity;
                } else if ($dtl_row->itemtype_lookup_code == "THRPEX") {
                    $cc_therapeutic_arr[$dtl_row->itemtype_lookup_code] = $dtl_row->pres_lookup_name;
                    $cc_therapeutic_item_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->presdtl_data . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu_name . "_" . $dtl_row->no_of_session;
                } else {
                    $cc_inv_adv_arr[$dtl_row->itemtype_lookup_code] = $dtl_row->pres_lookup_name;
                    $cc_inv_adv_item_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->presdtl_data;
                }
            }
        }

        return Template::loadview(
            "admin.prescription.prescription_print",
            [
                'prescription_mst' => $prescription_mst,
                'cc_inv_adv_arr' => $cc_inv_adv_arr,
                'cc_inv_adv_item_arr' => $cc_inv_adv_item_arr,
                'cc_electro_arr' => $cc_electro_arr,
                'cc_electro_item_arr' => $cc_electro_item_arr,
                'cc_therapeutic_arr' => $cc_therapeutic_arr,
                'cc_therapeutic_item_arr' => $cc_therapeutic_item_arr,
                'patient_barcode' => $patient_barcode,
                'prescription_barcode' => $prescription_barcode,
                'prescription_med' => $prescription_med,
                'po_hospital_details' => $po_hospital_details
            ]
        );
    }

    public function printPrescriptionPdf($prescription_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $prescription_mst = DB::table('prest_prescriptionmst_physio_vw')->where('prescription_no_pk', '=', $prescription_id)->first();
        $prescription_dtl = DB::table('prest_prescriptiondtl_physio_vw')->where('prescription_no_pk', '=', $prescription_id)->get();
        $prescription_med = DB::table('prest_prescriptionmed_physio_vw')->where('prescription_no_fk', '=', $prescription_id)->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_code);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $cc_inv_adv_arr = $cc_inv_adv_item_arr = $cc_electro_arr = $cc_electro_item_arr = $cc_therapeutic_arr = $cc_therapeutic_item_arr = [];
        if (!empty($prescription_dtl)) {
            foreach ($prescription_dtl as $dtl_row) {

                if ($dtl_row->itemtype_lookup_code == "ETHER") {
                    $cc_electro_arr[$dtl_row->itemtype_lookup_code] = $dtl_row->pres_lookup_name;
                    $cc_electro_item_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->presdtl_data . "_" . $dtl_row->session_duration . "_" . $dtl_row->unit_intensity_mu_name . "_" . $dtl_row->unit_intensity;
                } else if ($dtl_row->itemtype_lookup_code == "THRPEX") {
                    $cc_therapeutic_arr[$dtl_row->itemtype_lookup_code] = $dtl_row->pres_lookup_name;
                    $cc_therapeutic_item_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->presdtl_data . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu_name . "_" . $dtl_row->no_of_session;
                } else {
                    $cc_inv_adv_arr[$dtl_row->itemtype_lookup_code] = $dtl_row->pres_lookup_name;
                    $cc_inv_adv_item_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->presdtl_data;
                }
            }
        }

        $pdf = PDF::loadView(
            "admin.prescription.prescription_print_pdf",
            [
                'prescription_mst' => $prescription_mst,
                'cc_inv_adv_arr' => $cc_inv_adv_arr,
                'cc_inv_adv_item_arr' => $cc_inv_adv_item_arr,
                'cc_electro_arr' => $cc_electro_arr,
                'cc_electro_item_arr' => $cc_electro_item_arr,
                'cc_therapeutic_arr' => $cc_therapeutic_arr,
                'cc_therapeutic_item_arr' => $cc_therapeutic_item_arr,
                'patient_barcode' => $patient_barcode,
                'prescription_barcode' => $prescription_barcode,
                'prescription_med' => $prescription_med,
                'po_hospital_details' => $po_hospital_details
            ]
        );
        return $pdf->download("Prescription-$prescription_id.pdf");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function prescAutocomplete(Request $request)
    {
        return $this->getPrescAutocompleteList($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $appointment_id
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionMst($appointment_id, $patient_id = "", $prescription_id = "")
    {
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select('patn_appointment_vw.*', DB::raw('pat_age(PAT_REGISTRATION_WL_VW.dob,nvl(PAT_REGISTRATION_WL_VW.dod,sysdate))pat_age'))
            ->join('PAT_REGISTRATION_WL_VW', 'patn_appointment_vw.PATIENT_NO_PK', 'PAT_REGISTRATION_WL_VW.PATIENT_NO_PK')
            ->where("appoint_no_pk", $appointment_id)->first();
        // dd($appointment_rs);
        $chief_com = DB::table("patn_appointment_vw")
            ->select('chif_complain')
            ->where("appoint_no_pk", $appointment_id)
            ->first();
        $pat_vitals_rs = $pat_dtls_rs = $pat_med_rs = [];
        $chronic_disease = DB::table('emr_chronic_disease')->where("appoint_no_fk", $appointment_id)->get()->toArray();
        $allergie_table = new Allergy();
        $allergie_data = $allergie_table->where("appoint_no_fk", $appointment_id)->get()->toArray();
        if ($appointment_id != "") {
            $pat_vitals_rs = DB::table("patn_appointment_vw a")
                ->select(
                    'b.prescription_no_fk',
                    'b.pulse_val',
                    'b.bp_val_sys',
                    'b.bp_val_dia',
                    'b.temp_val',
                    'b.height_val',
                    'b.weight_val',
                    'b.ofc',
                    'b.bmi',
                    'b.bladder_condition',
                    'b.bowel_condition',
                    'b.lung_condition',
                    'b.heart_rate',
                    'b.heart_condition',
                    'b.lmp',
                    'b.lmp_remarks',
                    'b.obs',
                    'b.married_for',
                    'b.para',
                    'b.edd',
                    'b.edd_remarks',
                    'b.gravida',
                    'b.age_of_lastchild',
                    'b.sfh',
                    'b.fm',
                    'b.fhs',
                    'b.pr',
                    'b.hq',
                    'b.swelling',
                    'b.scar_work',
                    'b.tenderness',
                    'b.pae_note',
                    'b.au_entry_at',
                    'b.spo2_value',
                    'b.oxygen',
                    'b.respiration',
                    'b.patapp_no_fk',
                    'b.patient_no_fk'
                )
                ->leftJoin("psn_t_patvitals b", "a.appoint_no_pk", "=", "b.patapp_no_fk")
                ->where("a.appoint_no_pk", $appointment_id)
                ->orderBy('b.vital_no_pk', 'desc')
                // ->orderBy('b.prescription_no_fk', 'desc')
                ->first();
        }
        $investigation_data = DB::table("psn_t_prescription_dtl_vw")
            ->where("appointment_pk_no", $appointment_id)
            ->whereIn("lookupdata_uid", ['RAD', 'LAB', 'SERVICE'])
            ->get();
        return response()->json([
            'appointments' => $appointment_rs,
            'vitals' => $pat_vitals_rs,
            'chief_com' => $chief_com,
            'chronic_disease' => $chronic_disease,
            'allergie_data' => $allergie_data,
            'investigation_data' => $investigation_data,
            'patient_id' => $patient_id

        ]);
    }



    public function getEmergencyPrescriptionMst($patient_id = "", $prescription_id = "")
    {
        $prescription_dtl = DB::table("patient_info_vw")->where('patient_no_pk', '=', $patient_id)->first();

        $pat_vitals_rs = $pat_dtls_rs = $pat_med_rs = [];

        $pat_vitals_rs = DB::table("psn_t_patvitals b")
            ->select('b.prescription_no_fk', 'b.pulse_val', 'b.bp_val_sys', 'b.bp_val_dia', 'b.temp_val', 'b.height_val', 'b.weight_val', 'b.ofc', 'b.bmi', 'b.bladder_condition', 'b.bowel_condition', 'b.lung_condition', 'b.heart_rate', 'b.heart_condition', 'b.lmp', 'b.obs', 'b.rr', 'b.spo2')
            ->where("b.prescription_no_fk", $prescription_id)
            ->first();

        return response()->json([
            'prescription_dtl' => $prescription_dtl,
            'vitals' => $pat_vitals_rs,
            // 'chief_com'          => $chief_com,
            // 'chronic_disease'    => $chronic_disease,
            // 'allergie_data'      => $allergie_data,
            // 'investigation_data' => $investigation_data,

        ]);
    }
    public function getPrescriptionMst2($appointment_id, $patient_id = "", $prescription_id = "")
    {
        $appointment_rs = DB::table("patn_appointment_vw")->where("appoint_no_pk", $appointment_id)->first();
        $chief_com = DB::table("patn_appointment_vw")->select('chif_complain')
            ->where("appoint_no_pk", $appointment_id)
            ->first();
        $pat_vitals_rs = $pat_dtls_rs = $pat_med_rs = [];
        $chronic_disease = DB::table('emr_chronic_disease')->where("appoint_no_fk", $appointment_id)->get()->toArray();
        $allergie_table = new Allergy();
        $allergie_data = $allergie_table->where("appoint_no_fk", $appointment_id)->get()->toArray();
        if ($appointment_id != "") {
            $pat_vitals_rs = DB::table("patn_appointment_vw a")
                ->select('b.prescription_no_fk', 'b.pulse_val', 'b.bp_val_sys', 'b.bp_val_dia', 'b.temp_val', 'b.height_val', 'b.weight_val', 'b.ofc', 'b.bmi')
                ->leftJoin("psn_t_patvitals b", "a.appoint_no_pk", "=", "b.patapp_no_fk")
                ->where("a.appoint_no_pk", $appointment_id)
                ->first();
        }


        return response()->json([
            'appointments' => $appointment_rs,
            'vitals' => $pat_vitals_rs,
            'chief_com' => $chief_com,
            'chronic_disease' => $chronic_disease,
            'allergie_data' => $allergie_data,

        ]);
    }

    public function addChronicDisease(Request $request)
    {
        $prev_selected_item_arr = explode("*", $request->chrn_item_hdn_str);
        $item_arr = [];
        if (!empty($prev_selected_item_arr)) {
            foreach ($prev_selected_item_arr as $prev_selected_item) {
                $itemarr = explode("_", $prev_selected_item);
                //$item_arr[$itemarr[0]] = $itemarr[1];
                array_push($item_arr, $itemarr[0]);
            }
        }

        $chronic_text = explode("*", $request->chronic_text);
        $chronicarr = [];
        $data = [];
        if (!empty($chronic_text)) {
            foreach ($chronic_text as $chronic_text_item) {
                $chroniExp = explode("_", $chronic_text_item);
                //$item_arr[$itemarr[0]] = $itemarr[1];
                $chroniExpData = array_reverse($chroniExp);

                array_push($chronicarr, $chroniExpData[0]);
            }
        }

        $chronic_diseases = DB::table("psn_s_lookup_vw")
            ->select("pres_lookupdata_no_pk", "pres_lookupdata_code", "pres_lookupdata_name", "pres_lookup_no_pk", "pres_lookup_code", "pres_lookup_name")
            ->where("pres_lookup_code", "CHRONDIS")
            ->get();

        return Template::loadview("admin.prescription.add_chronic_disease", ['chronic_diseases' => $chronic_diseases, 'item_arr' => $item_arr, 'chronicarr' => $chronicarr]);
    }

    public function addAllergy()
    {
        $data = $this->getPresLookupListByMultipleCode(["ALLERGY", "ALLERGYCAT", "ALLGSEVERITY"]);

        return Template::loadview("admin.prescription.add_allergy", [
            'lookup_data' => $this->getPresLookupListByMultipleCode(["ALLERGY", "ALLERGYCAT", "ALLGSEVERITY", "OTHERS"]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $appointment_id
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionDtls_physio($prescription_id)
    {
        $pat_dtls_rs = DB::table("prest_prescriptionmst_physio_vw a")
            ->leftJoin("prest_prescriptiondtl_physio_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_id)
            ->get();

        $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $ad_arr = $in_arr = $pr_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = "";
        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                $next_followup_dt = $dtl_row->next_followup_dt;
                $refered_doc = $dtl_row->refered_doc;
                $presc_note = $dtl_row->presc_note;

                if ($dtl_row->itemtype_lookup_code == "CHIEFCOM") {
                    $cc_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "CLINICHIST") {
                    $ch_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "CHRDISEASE") {
                    $cd_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "PROVDIAG") {
                    $pd_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "DISEASE") {
                    $ds_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "ADVICE") {
                    $ad_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "INVFIND") {
                    $in_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "FINDINGS") {
                    $in_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
                if ($dtl_row->itemtype_lookup_code == "PROCEDURE") {
                    $pr_arr[$dtl_row->itemtype_lookup_code][] = $dtl_row->item_lookupdata_no_fk . "_" . $dtl_row->presdtl_data . "_" . $dtl_row->itemtype_lookup_no_fk . "_" . $dtl_row->itemtype_lookupdata_code;
                }
            }
        }

        $pat_med_rs = DB::table("prest_prescriptionmst_physio_vw a")
            ->leftJoin("prest_prescriptionmed_physio_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_id)
            ->get();
        if (!empty($pat_med_rs)) {
            foreach ($pat_med_rs as $med_row) {
                $continue_med_arr[$med_row->item_no_fk] = $med_row->brand_name;
            }
        }

        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("MEDDURMU", "pres_lookupdata_code");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD"]);

        return Template::loadview(
            "admin.prescription.prescription_details_doctor_wise",
            [
                'pat_dtls_rs' => $pat_dtls_rs,
                'pat_med_rs' => $pat_med_rs,
                "cc_arr" => $cc_arr,
                'ch_arr' => $ch_arr,
                'cd_arr' => $cd_arr,
                'pd_arr' => $pd_arr,
                'ds_arr' => $ds_arr,
                'ad_arr' => $ad_arr,
                'in_arr' => $in_arr,
                'pr_arr' => $pr_arr,
                'instructions' => $instructions,
                'dose' => $dose,
                'meddurmu' => $meddurmu,
                'next_followup_dt' => $next_followup_dt,
                'refered_doc' => $refered_doc,
                'presc_note' => $presc_note,
                'continue_med_arr' => $continue_med_arr
            ]
        );
    }

    public function blankPrescriptionForm($id)
    {
        $po_session_hospital = Session::get('user.ses_hospital_no_pk');

        $po_hospital_details = DB::table("WSEC_HOSPITAL")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $blankPrescriptionPrint = DB::table('patn_appointment_vw a')->where('a.appoint_no_pk', $id)->first();
        $vitals = DB::table('psn_t_patvitals')->where('patapp_no_fk', $id)->first();
        $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $id)->get();
        $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $id)->get();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('appointment_pk_no', '=', $id)->get();
        $left_side_arr = [];
        foreach ($prescription_dtl as $dtl_row) {
            $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        }

        $title = $blankPrescriptionPrint->patient_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(100);
        $barcode_no = $barcode->generate();

        $title_app = $blankPrescriptionPrint->appoint_no_pk;
        $barcode_app = new BarcodeGenerator();
        $barcode_app->setText($title_app);
        $barcode_app->setType(BarcodeGenerator::Code128);
        $barcode_app->setLabel('');
        $barcode_app->setScale(1);
        $barcode_app->setThickness(25);
        $barcode_app->setFontSize(100);
        $barcode_app_no = $barcode_app->generate();

        if (Session::get('user.ses_hospital_code') == "GMC") {
            return view(
                "admin.appointment.blank_prescription_gmc_print",
                [
                    'value' => $blankPrescriptionPrint,
                    'po_hospital_details' => $po_hospital_details,
                    'barcode_no' => $barcode_no,
                    'barcode_app_no' => $barcode_app_no,
                    'vitals' => $vitals,
                    'left_side_arr' => $left_side_arr,
                    'allergy' => $allergy,
                    'chronic_item' => $chronic_item
                ]
            );
        } else {
            return view(
                "admin.appointment.blank_prescription_print",
                [
                    'value' => $blankPrescriptionPrint,
                    'po_hospital_details' => $po_hospital_details,
                    'barcode_no' => $barcode_no,
                    'barcode_app_no' => $barcode_app_no,
                    'vitals' => $vitals,
                    'left_side_arr' => $left_side_arr,
                    'allergy' => $allergy,
                    'chronic_item' => $chronic_item
                ]
            );
        }

        // return $pdf->stream("blank_prescription_print.pdf");

        // return $pdf->download('blank_prescription_print.pdf');

    }

    //    Added By Nazmul 26 may 2021

    public function prescreate()
    {
        //        $ses_hospital_id = Session::get('user.ses_hospital_id');
        //        $appointment_date       = date("Y-m-d");
        //
        //        $followup_num = $followup_mu_name = $template_name = "";
        //        $absent_ind = 0;
        //        if($department_id != "")
        //        {
        //            $appointment_rs = DB::table("pat_appoint_wl_vw a")
        //                ->select("a.*","b.prescription_no_pk")
        //                ->leftJoin('psn_t_prescription_vw b', function($join)
        //                {
        //                    $appointment_date = date("Y-m-d");
        //                    $join->on('a.patapp_no_pk', '=', 'b.appoint_no_fk')
        //                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
        //                })
        //                ->leftJoin("sys_lookuplist c", "a.priority_lup_no_fk", "=", "c.lookuplist_no_pk")
        //                ->orderBy("c.serial_no", "asc")
        //                ->orderBy("a.app_sl", "asc")
        //                ->where("a.su_no_fk", $department_id)
        //                ->where("a.room_no_fk", $room_id)
        //                ->where("a.au_entry_hospital_no_fk", $ses_hospital_id)
        //                ->where("a.patapp_date", $appointment_date)->get();
        //
        //            $app_arr = [];
        //            $pending_ind = $prescription_ind =  0;
        //            if(!empty($appointment_rs))
        //            {
        //                foreach ($appointment_rs as $app_data) {
        //                    if($app_data->appoint_status == 1)
        //                    {
        //                        $pending_ind++;
        //                    }
        //                    elseif ($app_data->appoint_status == 3) {
        //                        $absent_ind++;
        //                    }
        //                    else
        //                    {
        //                        $prescription_ind++;
        //                    }
        //                }
        //            }
        //
        //            $su_info = $this->ServiceUnit->findByColumn("su_no_pk", $department_id);
        //            $su_arr = [];
        //        }
        //        else
        //        {
        //            $room_info = Room::select("room_no_pk", "room_name", "room_uid")->where("room_uid", "EXTERNALROOM")->first();
        //            if(!empty($room_info))
        //            {
        //                $room_id = $room_info->room_no_pk;
        //            }
        //            else
        //            {
        //                $room_id = 0;
        //            }
        //            $pending_ind = $prescription_ind = 0;
        //            $appointment_rs = $su_info = [];
        //            $su_arr = ServiceUnit::select("su_no_pk", "su_name", "eye_ind", "dental_ind")->where("external_hosp_su_ind", 1)->get();
        //        }
        //
        //
        //        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        //        $lookup_id_arr = $this->getPresLookupIDByCode(["CHIEFCOM","CLINICHIST","PROVDIAG","DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD"]);
        //
        //        $priority = $this->getLookupListByCode("PRIORITY");
        //        $duration_mu = $this->getPresLookupListByCode("DURMU", "lookup_data");
        //
        //        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "lookup_data");
        //        $route = $this->getPresLookupListByCode("ROUTE", "lookup_data");
        //        $dose = $this->getPresLookupListByCode("DOSE", "lookup_data");
        //        $meddurmu = $this->getPresLookupListByCode("DURMU", "psn_lookupdata_uid");
        //        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "psn_lookupdata_uid");
        //        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        //        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        //        $dental_arr=$selected_dental_arr=[];

        return Template::loadview(
            "admin.prescription.prescription_engine"

        );
    }



    public function prescreateDoctorWiseAppointmentList($appoint_id = "")
    {
        Session::put('expire_after', now()->addMinutes(30));
        $doctor_id = Auth::id();
        $appointment_date = date("Y-m-d");
        $absent_ind = 0;

        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->where("a.appoint_no_pk", $appoint_id)
                ->where("a.consult_ind", 1)
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }
        } else {
            $appointment_date = date("Y-m-d");

            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin(DB::raw("(SELECT appoint_no_fk, MAX(prescription_no_pk) as prescription_no_pk, MAX(au_entry_at) as au_entry_at FROM psn_t_prescription_vw GROUP BY appoint_no_fk) b"), function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->where("a.consult_ind", 1)
                ->get();

            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }

            if (!$appointment_rs->isEmpty()) {
                $department_id = $appointment_rs[0]->su_no_fk;
            } else {
                $department_id = Session::get('user.su_pk_no'); //user.su_pk_no
            }
        }
        return Template::loadview(
            "admin.prescription.uhl.prescription_engine_appointment_list",
            [
                'appointment_date' => $appointment_date,
                'appointment_rs' => $appointment_rs,
                'department_id' => $department_id,
                'prescription_ind' => $prescription_ind,
                'pending_ind' => $pending_ind,
                'absent_ind' => $absent_ind
            ]
        );
    }
    public function searchAppList(Request $request)
    {
        Session::put('expire_after', now()->addMinutes(30));
        $doctor_id = Auth::id();
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date)) : '';
        $patient_id = $request->patient_id;
        $absent_ind = 0;

        $appointment_rss = DB::table('patn_appointment_vw as a')
            ->select('a.*', 'b.prescription_no_pk')
            ->leftJoin(DB::raw('
                        (SELECT appoint_no_fk, MAX(prescription_no_pk) AS prescription_no_pk, MAX(au_entry_at) AS au_entry_at
                        FROM psn_t_prescription_vw
                        GROUP BY appoint_no_fk
                        ) b
                    '), function ($join) {
                $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk');
            })
            ->leftJoin('sysc_lookupdata as c', 'a.priority_no_fk', '=', 'c.lookupdata_no_pk')
            ->where('a.doctor_no_fk', Session::get('user.ses_person_no_fk'))
            ->whereNull('b.prescription_no_pk')
            ->where('a.cancel_ind', 1)
            ->orderBy('c.serial_no', 'asc')
            ->orderBy('a.slot_sl', 'asc');

        // Apply date filters
        if ($from_date && $to_date) {
            $appointment_rss->whereRaw(
                "TRUNC(a.appoint_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                [$from_date, $to_date]
            );
        } elseif ($from_date) {
            $appointment_rss->whereRaw(
                "TRUNC(a.appoint_date) = TO_DATE(?, 'YYYY-MM-DD')",
                [$from_date]
            );
        } elseif ($to_date) {
            $appointment_rss->whereRaw(
                "TRUNC(a.appoint_date) <= TO_DATE(?, 'YYYY-MM-DD')",
                [$to_date]
            );
        }


        if ($patient_id != "") {
            $appointment_rss->where('patient_no_pk', $patient_id);
        }
        if ($request->type == 'COMPLETED') {
            $appointment_rs = $appointment_rss->where("a.consult_ind", 1)->get();
        } else {
            $appointment_rs = $appointment_rss->where("a.consult_ind", 0)->get();
        }


        $pending_ind = $prescription_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {
                if ($app_data->appoint_status == 1) {
                    $pending_ind++;
                }
                if ($app_data->appoint_status == 3) {
                    $absent_ind++;
                }
                if ($app_data->prescription_no_pk != '') {
                    $prescription_ind++;
                }
            }
        }

        if (!$appointment_rs->isEmpty()) {
            $department_id = $appointment_rs[0]->su_no_fk;
        } else {
            $department_id = Session::get('user.su_pk_no'); //user.su_pk_no
        }

        if ($request->type == 'COMPLETED') {
            return Template::loadview(
                "admin.prescription.uhl.completed_prescription",
                [
                    // 'appointment_date' => $appointment_date,
                    'appointment_rs' => $appointment_rs,
                    'department_id' => $department_id,
                    'prescription_ind' => $prescription_ind,
                    'pending_ind' => $pending_ind,
                    'absent_ind' => $absent_ind
                ]
            );
        } else {
            return Template::loadview(
                "admin.prescription.uhl.doctor_appoinment_search_list",
                [
                    // 'appointment_date' => $appointment_date,
                    'appointment_rs' => $appointment_rs,
                    'department_id' => $department_id,
                    'prescription_ind' => $prescription_ind,
                    'pending_ind' => $pending_ind,
                    'absent_ind' => $absent_ind
                ]
            );
        }
    }


    public function prescreateDoctorWise($appoint_id = "")
    {
        Session::put('expire_after', now()->addMinutes(30));
        $doctor_id = Auth::id();
        $appointment_date = date("Y-m-d");

        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;

        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->where("a.appoint_no_pk", $appoint_id)
                ->where("a.consult_ind", 1)
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = [];
        } else {
            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                // ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->where("a.consult_ind", 1)
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }

            if (!$appointment_rs->isEmpty()) {
                $department_id = $appointment_rs[0]->su_no_fk;  //for remove external doctor 08.06.2023

            } else {
                $department_id = Session::get('user.su_pk_no'); //user.su_pk_no
            }
            //$pending_ind = $prescription_ind = 0;
            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->get();
        }

        $room_id = 0;
        $bloodg = $this->getLookupListByCode("BLOODG");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "INSTRUCTION", "PASTHI", "TREATMENTHISTORY"]);
        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                                 FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
                                 WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                                 AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $chief_com = [];
        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["THRPEX", "ETHER", "ACUP"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }

        return Template::loadview(
            "admin.prescription.prescription_engine_doctor_wise",
            [
                'clinical_arr' => $clinical_arr,
                'history_arr' => $history_arr,
                'chiefcom' => $chiefcom,
                'lookup_id_arr' => $lookup_id_arr,
                'duration_mu' => $duration_mu,
                'instructions' => $instructions,
                'dose' => $dose,
                'meddurmu' => $meddurmu,
                'appointment_date' => $appointment_date,
                'appointment_rs' => $appointment_rs,
                'priority' => $priority,
                'department_id' => $department_id,
                'room_id' => $room_id,
                'followup_mu' => $followup_mu,
                'prescription_ind' => $prescription_ind,
                'pending_ind' => $pending_ind,
                'followup_num' => $followup_num,
                'followup_mu_name' => $followup_mu_name,
                'template_name' => $template_name,
                'su_info' => $su_info,
                'dental_arr' => $dental_arr,
                'selected_dental_arr' => $selected_dental_arr,
                'eye_ocular_arr' => $eye_ocular_arr,
                'su_arr' => $su_arr,
                'absent_ind' => $absent_ind,
                'route' => $route,
                'chief_com' => $chief_com,
                'tr_lk_id_arr' => $tr_lk_id_arr,
                'duration_mu_phy' => $duration_mu_phy,
                'intervention' => $intervention,
                'bloodg' => $bloodg
            ]
        );
    }

    public function prescreateDoctorWiseUHL($appoint_id = "", $patient_code = "", $patient_no_pk = "", $prescription_no_pk = "")
    {
        Session::put('expire_after', now()->addMinutes(30));
        $doctor_id = Auth::id();
        $appointment_date = date("Y-m-d");

        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;

        $patient_information = DB::table("patn_appointment_vw as a")
            ->select("a.*")
            ->where("a.patient_no_pk", $patient_no_pk)
            ->first();

        $appointment_history = DB::table("patn_appointment_vw as a")
            // ->leftJoin("psn_t_prescription_dtl as b", "a.patient_no_pk", "=", "b.appointment_pk_no")
            ->select("a.full_name", "a.appoint_date", "a.appoint_code", "a.specialization")
            ->where("a.patient_no_pk", $patient_no_pk)
            ->get();

        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->where("a.appoint_no_pk", $appoint_id)
                ->where("a.consult_ind", 1)
                ->get();
            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            $department_id = null;

            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = [];
        } else {
            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->where("a.consult_ind", 1)
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }

            if (!$appointment_rs->isEmpty()) {
                $department_id = $appointment_rs[0]->su_no_fk;  //for remove external doctor 08.06.2023

            } else {
                $department_id = Session::get('user.su_pk_no'); //user.su_pk_no
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->get();
        }

        $room_id = 0;
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "INSTRUCTION"]);
        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
                                WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                                AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];

        $chief_com = [];

        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["THRPEX", "ETHER", "ACUP"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }
        $doctor_id = Auth::id();
        // $hdn_su_no = $request->hdn_su_no;
        // $su_info =  $this->ServiceUnit->findByColumn("serviceunit_no_pk", $hdn_su_no); // [];

        // $bg = DB::table('pat_registration_wl_vw')
        //         ->select('blood_group', 'blood_group_txt')
        //         ->where('patient_code', $patient_code)
        //         ->first();

        // $bloodg = $this->getLookupListByCode("BLOODG");

        $pat_dtls_rs = DB::table("psn_t_prescription_vw a")
            ->leftJoin("psn_t_prescription_dtl_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_no_pk)
            ->get();
        $pat_ot = DB::table("psn_t_prescription_vw a")
            ->select('ref_reason', 'ref_clinic_no_fk', 'management_plan_note', 'ot_date_time', 'ot_advice', 'ipd_referred_advice', 'ipd_referred_date', 'global_hidden_note', 'investigation_findings_note', 'diabetes_mel_typ1', 'diabetes_mel_typ2', 'hypertension', 'dyslipdemia', 'obesity', 'sedentary_lifestyle', 'smoking', 'dietary_factors', 'stress', 'anemia', 'inflammation', 'genetic_factors', 'heredity', 'disposal')
            ->where("a.prescription_no_pk", $prescription_no_pk)
            ->first();
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                        FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
                        WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                        AND PRES_LOOKUP_CODE = 'DISPOSAL'");

        // সর্বশেষ অ্যাপয়েন্টমেন্ট নাম্বার বের করা
        $lastAppointNo = DB::table('emr_chronic_disease')
            ->where('PATIENT_NO_FK', $patient_no_pk)
            ->orderByDesc('APPOINT_NO_FK')
            ->value('APPOINT_NO_FK');

        // ডিফল্ট ভ্যালু
        $chronicItems = collect();
        $allergies = collect();

        // যদি অ্যাপয়েন্টমেন্ট নাম্বার থাকে
        if ($lastAppointNo) {
            // ঐ অ্যাপয়েন্টমেন্ট অনুযায়ী সব chronic disease
            $chronicItems = DB::table('emr_chronic_disease')
                ->select('CHRONIC_DIS_NAME')
                ->where('PATIENT_NO_FK', $patient_no_pk)
                ->where('APPOINT_NO_FK', $lastAppointNo)
                ->get();

            // ঐ অ্যাপয়েন্টমেন্ট অনুযায়ী সব allergy
            $allergies = DB::table('emr_allergies')
                ->where('PATIENT_NO_FK', $patient_no_pk)
                ->where('APPOINT_NO_FK', $lastAppointNo)
                ->get();
        }
        // dd($chronicItems);
        $treatment_his_arr = $phi_arr = $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $ptet_arr = $ptte_arr = $acup_arr = $find_arr = $ref_reason = $ref_clinic_no_fk = $management_plan_note = $ot_date_time = $ot_advice = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];
        // $dental_arr1 = DB::table("psn_t_prescription")->select("dental_treatement")->where("prescription_no_pk", "=", $prescription_no_pk)->first();

        $ref_reason = $pat_ot->ref_reason ?? '';
        $ref_clinic_no_fk = $pat_ot->ref_clinic_no_fk ?? '';
        $management_plan_note = $pat_ot->management_plan_note ?? '';
        $ot_date_time = $pat_ot->ot_date_time ?? '';
        $ot_advice = $pat_ot->ot_advice ?? '';
        $ipd_referred_advice = $pat_ot->ipd_referred_advice ?? '';
        $ipd_referred_date = $pat_ot->ipd_referred_date ?? '';
        $global_hidden_note = $pat_ot->global_hidden_note ?? '';
        $investigation_findings_note = $pat_ot->investigation_findings_note ?? '';

        $diabetes_mel_typ1 = $pat_ot->diabetes_mel_typ1 ?? '';
        $diabetes_mel_typ2 = $pat_ot->diabetes_mel_typ2 ?? '';
        $hypertension = $pat_ot->hypertension ?? '';
        $dyslipdemia = $pat_ot->dyslipdemia ?? '';
        $obesity = $pat_ot->obesity ?? '';
        $sedentary_lifestyle = $pat_ot->sedentary_lifestyle ?? '';
        $smoking = $pat_ot->smoking ?? '';
        $dietary_factors = $pat_ot->dietary_factors ?? '';
        $stress = $pat_ot->stress ?? '';
        $anemia = $pat_ot->anemia ?? '';
        $inflammation = $pat_ot->inflammation ?? '';
        $genetic_factors = $pat_ot->genetic_factors ?? '';
        $heredity = $pat_ot->heredity ?? '';
        $disposal = $pat_ot->disposal ?? '';

        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                $patient_id = $dtl_row->patient_no_fk;
                $next_followup_dt = $dtl_row->next_followup_dt;
                $followup_num = $dtl_row->followup_num;
                $followup_mu_name = $dtl_row->followup_mu;
                $template_name = $dtl_row->template_name;
                $refered_doc = $dtl_row->ref_doctor;
                $refered_doc_name = $dtl_row->ref_doc_name;
                $presc_note = $dtl_row->note;

                if ($dtl_row->lookup_uid == "HISTORY") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                // if ($dtl_row->lookup_uid == "CHIEFCOM") {
                //     $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                // }
                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $entry = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    if (!isset($cc_arr[$dtl_row->lookup_uid])) {
                        $cc_arr[$dtl_row->lookup_uid] = [];
                    }
                    if (!in_array($entry, $cc_arr[$dtl_row->lookup_uid])) {
                        $cc_arr[$dtl_row->lookup_uid][] = $entry;
                    }
                }
                if ($dtl_row->lookup_uid == "PASTHI") {
                    $phi_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "TREATMENTHISTORY") {
                    $treatment_his_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                // if ($dtl_row->lookup_uid == "CLINICHIST") {
                //     $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                // }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $entry = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    if (!isset($ch_arr[$dtl_row->lookup_uid])) {
                        $ch_arr[$dtl_row->lookup_uid] = [];
                    }
                    if (!in_array($entry, $ch_arr[$dtl_row->lookup_uid])) {
                        $ch_arr[$dtl_row->lookup_uid][] = $entry;
                    }
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                // if ($dtl_row->lookup_uid == "FINDINGS") {
                //     $find_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                // }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $entry = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    if (!isset($find_arr[$dtl_row->lookup_uid])) {
                        $find_arr[$dtl_row->lookup_uid] = [];
                    }
                    if (!in_array($entry, $find_arr[$dtl_row->lookup_uid])) {
                        $find_arr[$dtl_row->lookup_uid][] = $entry;
                    }
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB" || $dtl_row->lookup_uid == "SERVICE") {
                }
                // if ($dtl_row->lookup_uid == "INVFIND") {
                //     if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                //         $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                //     } else {
                //         $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                //     }
                // }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    $entry = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;

                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB" || $dtl_row->lookupdata_uid == "PKG" || $dtl_row->lookupdata_uid == "SERVICE" || $dtl_row->lookupdata_uid == "PROC") {
                        if (!isset($in_arr[$dtl_row->lookup_uid])) {
                            $in_arr[$dtl_row->lookup_uid] = [];
                        }
                        if (!in_array($entry, $in_arr[$dtl_row->lookup_uid])) {
                            $in_arr[$dtl_row->lookup_uid][] = $entry;
                        }
                    } else {
                        if (!isset($inf_arr[$dtl_row->lookup_uid])) {
                            $inf_arr[$dtl_row->lookup_uid] = [];
                        }
                        if (!in_array($entry, $inf_arr[$dtl_row->lookup_uid])) {
                            $inf_arr[$dtl_row->lookup_uid][] = $entry;
                        }
                    }
                }

                if ($dtl_row->lookupdata_uid == "ACUP") {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : '';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : '';
                    $acup_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $e_location . '_' . $m_duration;
                }
                if ($dtl_row->lookupdata_uid == "PTET") {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : '';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : '';
                    $ptet_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $e_location . '_' . $m_duration;
                }
                if ($dtl_row->lookupdata_uid == "PTTE") {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : '';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : '';
                    $ptte_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $e_location . '_' . $m_duration;
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }

                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeDoses("DOSE", "pres_lookupdata_name");
        $referred_clinic_list = $this->getPresLookupListByCode("REFERRED_CLINIC", "pres_lookupdata_name");

        // $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        // dd($route);
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "DISPOSAL", "REFDOC", "PROCEDURE", "PASTHI", "TREATMENTHISTORY"]);
        // $continue_med_arr = DB::table("psn_t_prescription_med_vw")
        //                     ->where("patient_no_fk", $patient_id)
        //                     ->whereRaw('(continue_ind=1 or chronic_ind=1)')
        //                     ->get();

        $pat_med_rs = DB::table("psn_t_prescription_vw as a")
            ->leftJoin("psn_t_prescription_med_vw as b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_no_pk)
            ->distinct()
            ->orderBy('b.prescription_med_no_pk', 'asc')
            ->get();
        // $pat_eye_rs = [];
        // $pat_eye_rs   = DB::table("psn_t_prescription_eye")
        //                     ->leftJoin("psn_t_prescription_dtl_vw b", "psn_t_prescription_eye.prescription_no_fk", "=", "b.prescription_no_fk")
        //                     ->where("psn_t_prescription_eye.prescription_no_fk", $prescription_no_pk)
        //                     ->first();


        $pat_pres_list_dtl = DB::table("psn_t_prescription_vw")
            ->select('psn_t_prescription_vw.*', 'OPD_REFF_ANESTHESIA_DEPT.REFF_ANES_DEPT_NO_PK')
            ->leftJoin('OPD_REFF_ANESTHESIA_DEPT', 'OPD_REFF_ANESTHESIA_DEPT.PRESCRIPTION_NO_FK', 'psn_t_prescription_vw.PRESCRIPTION_NO_pK')
            ->where("psn_t_prescription_vw.patient_no_fk", $patient_no_pk)
            ->where("psn_t_prescription_vw.admission_no_fk", 0)
            ->orderBy("psn_t_prescription_vw.au_entry_at", "desc")
            ->get();
        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {

                $pat_pres_list[$pat_pres->prescription_no_pk] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind . "_" . $pat_pres->patient_code . "_" . $pat_pres->doctor_name . "_" . $pat_pres->su_name . "_" . $pat_pres->prescription_date . "_" . $pat_pres->doctor_person_no_fk  . "_" . $pat_pres->reff_anes_dept_no_pk  . "_" . $pat_pres->appoint_typename;
            }
        }

        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)
            ->whereIn("lookupdata_uid", ['RAD', 'LAB', 'SERVICE'])->orderBy("lookupdata_uid", "asc")
            ->get();
        $ptet_ptte_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)
            ->whereIn("lookupdata_uid", ['PTET', 'PTTE', 'ACUP'])->orderBy("lookupdata_uid", "asc")
            ->get();

        $path_rad_invest = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {

                $path_rad_invest[$path_rad->lookupdata_uid][] = $path_rad->prescrition_data . "_" . $path_rad->report_no_fk;
            }
        }
        $ptet_ptte_item = [];
        if (!empty($ptet_ptte_arr)) {
            foreach ($ptet_ptte_arr as $ptet_ptte) {

                $ptet_ptte_item[$ptet_ptte->lookupdata_uid][] = $ptet_ptte->prescrition_data . "_" . $ptet_ptte->report_no_fk;
            }
        }
        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)->whereIn("lookupdata_uid", ['RAD', 'LAB', 'SERVICE', 'PROC'])->get();

        $path_arr = $rad_arr = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {
                if ($path_rad->lookupdata_uid == "RAD") {
                    $rad_arr[] = $path_rad->prescrition_data;
                } else {
                    $path_arr[] = $path_rad->prescrition_data;
                }
            }
        }

        //     $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
        //     s.SERVICEUNIT_NO_PK
        // FROM sysc_serviceunit s
        //     JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
        // WHERE p.doctor_ind = 1 AND p.employee_ind = 1
        //     group by s.SERVICEUNIT_NAME,
        //     s.SERVICEUNIT_NO_PK
        //     order by 1 asc");

        //          $doctor_departments = DB::select("SELECT SERVICEUNIT_NAME, SERVICEUNIT_NO_PK
        // FROM sysc_serviceunit WHERE serviceunit_name IN ('PAEDIATRICS',
        //          'CARDIOLOGY',
        //          'GESTOLOGY',
        //          'MEDICINE',
        //          'NEUROLOGY',
        //          'NEPHROLOGY',
        //          'OPTHALMOLOGY',
        //          'SURGERY',
        //          'UROFLOWMETRY',
        //          'UROLOGY')");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        // $dental_arr = $selected_dental_arr = [];
        $department_id = $su_info;
        $lmp = DB::table('PSN_T_PATVITALS')
            ->select(
                'lmp',
                'obs',
                'married_for',
                'para',
                'edd',
                'gravida',
                'age_of_lastchild',
                'sfh',
                'fm',
                'fhs',
                'pr',
                'hq',
                'hypothyroidism',
                'brochial_asthma',
                'swelling',
                'scar_work',
                'tenderness',
                'pae_note',
                'alc',
                'menstrual_cycle',
                'mp',
                'mf',
                'dysmenorrhoea',
                'contraceptive_history',
                'drug_history',
                'surgical_history',
                'medical_history',
                'perineum_and_vulva',
                'cx',
                'vaginal_wall',
                'discharge',
                'uterus',
                'adnexa',
                'bme_note',
                'd_r_e',
                'breast_examination',
                'family_history',
                'complaints_history',
                'past_history',
                'outcome_measurement'
            )
            ->where("prescription_no_fk", $prescription_no_pk)->first();

        // $chronic_disease = DB::table('emr_chronic_disease')->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $allergie_table = new Allergy();
        $allergie_data = $allergie_table->where("appoint_no_fk", $appoint_id)->get()->toArray();

        // TV Update


        if (DB::table("PSN_T_PRESCRIPTION")->where('APPOINT_NO_FK', $appoint_id)->count() == 0) {
            if (DB::table('SYSC_TVSCREENSETUP')->where('TVTAG', 'APPOINTMENTTV')->value('status') == 1) {
                DB::table('opd_patdisplay')->where('APPOINT_NO_FK', $appoint_id)->update(['MOVEMENT_TYPE_NO' => 2]);
                DB::commit();
                $data = $this->tv_information->get_tv_data(null);
                event(new TVUpdate($data));
            }
        } else {
            DB::commit();
        }

        $room_data = DB::table('sysc_room')->select('room_no_pk', 'room_name', 'room_code')->where('ot_ind', 1)->get();

        $pac_list_data = DB::table('OT_REQUISITION_VW')
            ->select([
                'reff_anes_dept_no_pk',
                'admission_no_fk',
                'patient_no_fk',
                'full_name',
                'reply_type'
            ])
            ->where('patient_no_fk', $patient_no_pk)
            ->orderByDesc('reff_date')
            ->first();

        if (!$pac_list_data) {
            $pac_list_data = null;
        }

        // TV Update
        return Template::loadview(
            "admin.prescription.uhl.prescription_engine_doctor_wise",
            [
                'appointment_history' => $appointment_history,
                'appoint_id' => $appoint_id,
                'patient_code' => $patient_code,
                'patient_no_pk' => $patient_no_pk,
                'prescription_no_pk' => $prescription_no_pk,
                'patient_information' => $patient_information,
                'clinical_arr' => $clinical_arr,
                'history_arr' => $history_arr,
                'chiefcom' => $chiefcom,
                'lookup_id_arr' => $lookup_id_arr,
                'duration_mu' => $duration_mu,
                'instructions' => $instructions,
                'dose' => $dose,
                'meddurmu' => $meddurmu,
                'appointment_date' => $appointment_date,
                'appointment_rs' => $appointment_rs,
                "priority" => $priority,
                'department_id' => $department_id,
                'room_id' => $room_id,
                'followup_mu' => $followup_mu,
                'prescription_ind' => $prescription_ind,
                'pending_ind' => $pending_ind,
                'followup_num' => $followup_num,
                'followup_mu_name' => $followup_mu_name,
                'next_followup_dt' => $next_followup_dt,
                'template_name' => $template_name,
                'su_info' => $su_info,
                'dental_arr' => $dental_arr,
                'selected_dental_arr' => $selected_dental_arr,
                'eye_ocular_arr' => $eye_ocular_arr,
                'su_arr' => $su_arr,
                'absent_ind' => $absent_ind,
                'route' => $route,
                'chief_com' => $chief_com,
                'tr_lk_id_arr' => $tr_lk_id_arr,
                'duration_mu_phy' => $duration_mu_phy,
                'intervention' => $intervention,
                'cc_arr' => $cc_arr,
                'ch_arr' => $ch_arr,
                'icd_arr' => $icd_arr,
                'find_arr' => $find_arr,
                'in_arr' => $in_arr,
                'pat_med_rs' => $pat_med_rs,
                'presc_note' => $presc_note,
                'pat_pres_list' => $pat_pres_list,
                'lmp' => $lmp,
                'allergie_data' => $allergie_data,
                'chronicItems' => $chronicItems,
                'allergies' => $allergies,
                'acup_arr' => $acup_arr,
                'ptte_arr' => $ptte_arr,
                'ptet_arr' => $ptet_arr,
                'ad_arr' => $ad_arr,
                'pr_arr' => $pr_arr,
                'ref_reason' => $ref_reason,
                'ref_clinic_no_fk' => $ref_clinic_no_fk,
                'management_plan_note' => $management_plan_note,
                'ot_date_time' => $ot_date_time,
                'ot_advice' => $ot_advice,
                'ipd_referred_advice' => $ipd_referred_advice,
                'ipd_referred_date' => $ipd_referred_date,
                'global_hidden_note' => $global_hidden_note,
                'investigation_findings_note' => $investigation_findings_note,
                'diabetes_mel_typ1' => $diabetes_mel_typ1,
                'diabetes_mel_typ2' => $diabetes_mel_typ2,
                'hypertension' => $hypertension,
                'dyslipdemia' => $dyslipdemia,
                'obesity' => $obesity,
                'sedentary_lifestyle' => $sedentary_lifestyle,
                'smoking' => $smoking,
                'dietary_factors' => $dietary_factors,
                'stress' => $stress,
                'anemia' => $anemia,
                'inflammation' => $inflammation,
                'genetic_factors' => $genetic_factors,
                'heredity' => $heredity,
                'disposal' => $disposal,
                'room_data' => $room_data,
                'pac_list_data' => $pac_list_data,
                'referred_clinic_list' => $referred_clinic_list
            ]
        );
    }

    public function getDoctorWisePrescribedPatientList(Request $request)
    {

        $doctor_id = Session::get("user.ses_person_no_fk");
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        // $sql_cond .= ($patient_id != "") ? " $clause  pat.patient_no_pk = $patient_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " $clause pat.appoint_date between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')" : "";
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $appointment_rs = DB::select(DB::raw("select psn.*,pat.* from psn_t_prescription_vw psn
            left join patn_appointment_vw pat on psn.appoint_no_fk = pat.appoint_no_pk where pat.appoint_status = 2 $sql_cond and psn.au_entry_hospital_no_fk = $hospital_id and pat.doctor_no_fk = $doctor_id order by pat.appoint_no_pk DESC"));
        return Template::loadView("admin.prescription.completed_prescription", ['appointment_rs' => $appointment_rs]);
    }

    public function prescreateDoctorWise2($appoint_id = "")
    {
        // $ses_hospital_id = Session::get('user.ses_hospital_id');
        $appointment_date = date("Y-m-d");

        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;
        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->where("a.appoint_no_pk", $appoint_id)->get();


            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = [];
        } else {
            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }
            if (!$appointment_rs->isEmpty()) {
                foreach ($appointment_rs as $value) {
                    $department_id = $value->su_no_fk;
                }
            } else {
                $department_id = Session::get('user.su_pk_no'); //user.su_pk_no
            }

            //$department_id = 12;
            //$pending_ind = $prescription_ind = 0;
            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->get();
        }

        $room_id = 0;

        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");


        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");

        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $physio_others = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSOTH")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val')->get();
        $physio_lifestyles = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSLIFESTYLE")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val', 'pres_lookupdata_no_pk as id')->get();
        $physio_symptoms = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSSYMPT")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val', 'pres_lookupdata_no_pk as id')->orderBy('serial', "asc")->get();
        $physio_present_sexual_function = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PRNTSEXFUN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_previous_evaluation = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PREVEVAL')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_previous_treatment = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PREVTREAT')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_risk_factors = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'RISKFACTERECTILEDYSFUN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $past_medical_history = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PASTMEDHIS')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $family_history = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'FAMILYHISTORY')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physical_examination = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PHYSICALEXAM')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_blood = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONBLOODTEST')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_urine = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONURINETEST')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_usg = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONUSG')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_xray_mri = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONX-RAY/MRI')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $management_plan = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'MANAGEMENTPLAN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $ipss = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYIPSS")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();
        $iief = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYSHIM")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();

        $dental_arr = $selected_dental_arr = [];

        $chief_com = [];

        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["THRPEX", "ETHER", "ACUP"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }

        return Template::loadview("admin.prescription.prescription_engine_doctor_wise2", ['clinical_arr' => $clinical_arr, 'history_arr' => $history_arr, 'chiefcom' => $chiefcom, 'iief' => $iief, 'edit_therapy_details' => '', 'ipss' => $ipss, 'physio_present_sexual_function' => $physio_present_sexual_function, 'physio_previous_evaluation' => $physio_previous_evaluation, 'physio_previous_treatment' => $physio_previous_treatment, 'past_medical_history' => $past_medical_history, 'physio_risk_factors' => $physio_risk_factors, 'family_history' => $family_history, 'physical_examination' => $physical_examination, 'investigation_blood' => $investigation_blood, 'investigation_urine' => $investigation_urine, 'investigation_usg' => $investigation_usg, 'investigation_xray_mri' => $investigation_xray_mri, 'management_plan' => $management_plan, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'appointment_date' => $appointment_date, 'appointment_rs' => $appointment_rs, "priority" => $priority, 'department_id' => $department_id, 'room_id' => $room_id, 'followup_mu' => $followup_mu, 'prescription_ind' => $prescription_ind, 'pending_ind' => $pending_ind, 'followup_num' => $followup_num, 'followup_mu_name' => $followup_mu_name, 'template_name' => $template_name, "su_info" => $su_info, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, "su_arr" => $su_arr, "absent_ind" => $absent_ind, 'route' => $route, 'chief_com' => $chief_com, 'tr_lk_id_arr' => $tr_lk_id_arr, 'duration_mu_phy' => $duration_mu_phy]);
    }

    public function opd_nurse_station_vitals($appoint_id = "")
    {
        $allergie_table = new Allergy();
        $vitals_data = DB::table('psn_t_patvitals')->where("patapp_no_fk", $appoint_id)->first();
        $chronic_disease = DB::table('emr_chronic_disease')->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $allergie_data = $allergie_table->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $appointment_date = date("Y-m-d");

        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;
        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                //    ->where("a.su_no_fk", $department_id)
                //    ->where("a.room_no_fk", $room_id)
                //    ->where("a.au_entry_hospital_no_fk", $ses_hospital_id)
                ->where("a.appoint_no_pk", $appoint_id)->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }

            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = [];
        } else {
            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->get();


            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }
            //$department_id = 12;
            //$pending_ind = $prescription_ind = 0;
            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);
            $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->get();
        }
        $room_id = 0;

        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "HISTORY"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $history_arr = $this->getPresLookupHistoryDTLListByCode("HISTORY", "", $department_id);
        $clinical_arr = $this->getPresLookupHistoryDTLListByCode("EXAMINATION", "", $department_id); //EXAMINATION


        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);

        $pat_dtls_rs = DB::table("psn_t_prescription_dtl_vw a")
            // ->leftJoin("psn_t_prescription_dtl_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.appointment_pk_no", $appoint_id)->get();
        $dental_arr = $selected_dental_arr = [];
        $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $his_arr = $exam_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];


        if (!empty($pat_dtls_rs)) {

            foreach ($pat_dtls_rs as $dtl_row) {
                $patient_id = $dtl_row->patient_no_fk;
                //    $next_followup_dt = $dtl_row->next_followup_dt;
                //    $followup_num = $dtl_row->followup_num;
                //    $followup_mu_name = $dtl_row->followup_mu;
                //    $template_name = $dtl_row->template_name;
                //    $refered_doc = $dtl_row->ref_doctor;
                //    $presc_note = $dtl_row->note;

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                }
                if ($dtl_row->lookup_uid == "HISTORY") {
                    $his_arr[$dtl_row->lookupdata_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                }
                if ($dtl_row->lookup_uid == "EXAMINATION") {

                    // $exam_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;

                    $exam_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk] = $dtl_row->prescrition_data_dtl . '_' . $dtl_row->psn_lookup_no_pk . '_' . $dtl_row->prescrition_data . '_' . $dtl_row->lookupdata_uid;
                }

                // if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid=="EXAMINATION") {
                //     // $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                //     $left_side_arr[$dtl_row->lookupdata_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                // } else {
                //     $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                // }
                // dd($left_side_arr);


                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $chief_com = DB::table("patn_appointment_vw")->select('chif_complain')->where("appoint_no_pk", $appoint_id)->first();

        return Template::loadview("admin.prescription.opd_nurse_station_vitals", ['left_side_arr' => $left_side_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'appointment_date' => $appointment_date, 'appointment_rs' => $appointment_rs, "priority" => $priority, 'department_id' => $department_id, 'room_id' => $room_id, 'followup_mu' => $followup_mu, 'prescription_ind' => $prescription_ind, 'pending_ind' => $pending_ind, "su_info" => $su_info, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, "su_arr" => $su_arr, "absent_ind" => $absent_ind, 'route' => $route, 'history_arr' => $history_arr, 'extarnal_hospitals' => $extarnal_hospitals, 'clinical_arr' => $clinical_arr, 'vitals_data' => $vitals_data, "cc_arr" => $cc_arr, "ch_arr" => $ch_arr, "cd_arr" => $cd_arr, "pd_arr" => $pd_arr, "ds_arr" => $ds_arr, "icd_arr" => $icd_arr, "ad_arr" => $ad_arr, "refdoc_arr" => $refdoc_arr, "in_arr" => $in_arr, "pr_arr" => $pr_arr, 'chronic_disease' => $chronic_disease, 'allergie_data' => $allergie_data, 'exam_arr' => $exam_arr, 'his_arr' => $his_arr, 'chief_com' => $chief_com]);
    }

    /**
     * V2:: For Hospital Code (UNICO)
     */
    public function opd_nurse_station_vitals_v2($appoint_id = "")
    {
        $allergie_table = new Allergy();
        $vitals_data = DB::table('psn_t_patvitals')->where("patapp_no_fk", $appoint_id)->first();
        $chronic_disease = DB::table('emr_chronic_disease')->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $allergie_data = $allergie_table->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $appointment_date = date("Y-m-d");
        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;
        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->where("a.appoint_no_pk", $appoint_id)->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = [];
        } else {
            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }
            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);
            $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->get();
        }
        $room_id = 0;
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD", "HISTORY"]);
        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $history_arr = $this->getPresLookupHistoryDTLListByCode("HISTORY", "", $department_id);
        $clinical_arr = $this->getPresLookupHistoryDTLListByCode("EXAMINATION", "", $department_id); //EXAMINATION
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);

        $pat_dtls_rs = DB::table("psn_t_prescription_dtl_vw a")
            ->where("a.appointment_pk_no", $appoint_id)->get();
        $dental_arr = $selected_dental_arr = [];
        $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $his_arr = $exam_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];


        if (!empty($pat_dtls_rs)) {

            foreach ($pat_dtls_rs as $dtl_row) {
                $patient_id = $dtl_row->patient_no_fk;
                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                }
                if ($dtl_row->lookup_uid == "HISTORY") {
                    $his_arr[$dtl_row->lookupdata_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                }
                if ($dtl_row->lookup_uid == "EXAMINATION") {
                    $exam_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk] = $dtl_row->prescrition_data_dtl . '_' . $dtl_row->psn_lookup_no_pk . '_' . $dtl_row->prescrition_data . '_' . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $chief_com = DB::table("patn_appointment_vw")->select('chif_complain')->where("appoint_no_pk", $appoint_id)->first();

        return Template::loadview("admin.prescription.v2.v2_opd_nurse_station_vitals", ['left_side_arr' => $left_side_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'appointment_date' => $appointment_date, 'appointment_rs' => $appointment_rs, "priority" => $priority, 'department_id' => $department_id, 'room_id' => $room_id, 'followup_mu' => $followup_mu, 'prescription_ind' => $prescription_ind, 'pending_ind' => $pending_ind, "su_info" => $su_info, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, "su_arr" => $su_arr, "absent_ind" => $absent_ind, 'route' => $route, 'history_arr' => $history_arr, 'extarnal_hospitals' => $extarnal_hospitals, 'clinical_arr' => $clinical_arr, 'vitals_data' => $vitals_data, "cc_arr" => $cc_arr, "ch_arr" => $ch_arr, "cd_arr" => $cd_arr, "pd_arr" => $pd_arr, "ds_arr" => $ds_arr, "icd_arr" => $icd_arr, "ad_arr" => $ad_arr, "refdoc_arr" => $refdoc_arr, "in_arr" => $in_arr, "pr_arr" => $pr_arr, 'chronic_disease' => $chronic_disease, 'allergie_data' => $allergie_data, 'exam_arr' => $exam_arr, 'his_arr' => $his_arr, 'chief_com' => $chief_com]);
    }
    public function opd_nurse_station_vitals_v2_er($appoint_id = "")
    {
        $allergie_table = new Allergy();
        $vitals_data = DB::table('psn_t_patvitals')->where("patapp_no_fk", $appoint_id)->first();
        $chronic_disease = DB::table('emr_chronic_disease')->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $allergie_data = $allergie_table->where("appoint_no_fk", $appoint_id)->get()->toArray();
        $appointment_date = date("Y-m-d");
        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;
        $department_id = 0;
        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->where("a.appoint_no_pk", $appoint_id)->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk != "" ? $value->su_no_fk : 0;
            }

            $su_info = !empty($department_id) ? $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id) : [];

            $su_arr = [];
        } else {

            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk != "" ? $value->su_no_fk : 0;
            }
            $su_info = !empty($department_id) ? $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id) : [];
            $su_arr = DB::table('sysc_serviceunit')->select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->where('ipd_ind', 1)->where('emergency_ind', 1)->where('status', '=', 1)->get();
        }
        $room_id = 0;
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD", "HISTORY"]);
        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $history_arr = isset($department_id) && $department_id != "" ?  $this->getPresLookupHistoryDTLListByCode("HISTORY", "", $department_id) : [];
        $clinical_arr = isset($department_id) && $department_id != "" ?  $this->getPresLookupHistoryDTLListByCode("EXAMINATION", "", $department_id) : []; //EXAMINATION
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);

        $pat_dtls_rs = DB::table("psn_t_prescription_dtl_vw a")
            ->where("a.appointment_pk_no", $appoint_id)->get();
        $dental_arr = $selected_dental_arr = [];
        $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $his_arr = $exam_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];


        if (!empty($pat_dtls_rs)) {

            foreach ($pat_dtls_rs as $dtl_row) {
                $patient_id = $dtl_row->patient_no_fk;
                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                }
                if ($dtl_row->lookup_uid == "HISTORY") {
                    $his_arr[$dtl_row->lookupdata_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data_dtl;
                }
                if ($dtl_row->lookup_uid == "EXAMINATION") {
                    $exam_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk] = $dtl_row->prescrition_data_dtl . '_' . $dtl_row->psn_lookup_no_pk . '_' . $dtl_row->prescrition_data . '_' . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $chief_com = DB::table("patn_appointment_vw")->select('chif_complain')->where("appoint_no_pk", $appoint_id)->first();

        return Template::loadview("admin.prescription.v2.v2_opd_nurse_station_vitals_er", ['left_side_arr' => $left_side_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'appointment_date' => $appointment_date, 'appointment_rs' => $appointment_rs, "priority" => $priority, 'department_id' => $department_id, 'room_id' => $room_id, 'followup_mu' => $followup_mu, 'prescription_ind' => $prescription_ind, 'pending_ind' => $pending_ind, "su_info" => $su_info, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, "su_arr" => $su_arr, "absent_ind" => $absent_ind, 'route' => $route, 'history_arr' => $history_arr, 'extarnal_hospitals' => $extarnal_hospitals, 'clinical_arr' => $clinical_arr, 'vitals_data' => $vitals_data, "cc_arr" => $cc_arr, "ch_arr" => $ch_arr, "cd_arr" => $cd_arr, "pd_arr" => $pd_arr, "ds_arr" => $ds_arr, "icd_arr" => $icd_arr, "ad_arr" => $ad_arr, "refdoc_arr" => $refdoc_arr, "in_arr" => $in_arr, "pr_arr" => $pr_arr, 'chronic_disease' => $chronic_disease, 'allergie_data' => $allergie_data, 'exam_arr' => $exam_arr, 'his_arr' => $his_arr, 'chief_com' => $chief_com]);
    }

    /**
     * Block Slot Modal
     */
    public function blockSlotShow($id = null, $doctor_id = null, $date = null)
    {
        $schedules = DB::table('hrms_schedule_slot s')
            ->rightJoin('patn_v1_appointment_vw app', 's.slot_no_pk', 'app.slot_no_fk')
            ->select('s.*', "app.patient_no_pk", "app.patient_name", "app.patient_code", "app.gender_txt", "app.patient_dob", "app.blood_group", "app.age", "app.mobile1", "app.appoint_type_code", "app.ccm_client_name", "app.case_type_name", "app.appoint_no_pk", "wsec_user.user_fullname", "app.calling_note")
            ->whereIn('s.schedule_no_fk', json_decode(($id)))
            ->orderBy('s.slot_no_pk', 'ASC')
            ->count();

        if ($schedules > 0) {
            return "Patient appointment exists in this date. Please cancel appointment first.";
        } else {
            return Template::loadview("admin.prescription.modal.block_slot_modal", compact('id', 'doctor_id', 'date'));
        }
    }

    /**
     * Block Doctor Schedule Slot by Dates
     */
    public function blockSlot(PrescriptionBlockSlotRequest $request)
    {
        DB::beginTransaction();

        try {
            $schedule_id = json_decode($request->input('schedule_id'));
            // $doctor_id = $request->input('doctor_id');
            $reason = $request->input('reason');
            // $date = json_decode($request->input('date'));

            $schedules = DB::table('hrms_schedule_slot s')
                ->leftJoin('patn_v1_appointment_vw app', 's.slot_no_pk', 'app.slot_no_fk')
                ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 's.block_by')
                ->select('s.*', "app.patient_no_pk", "app.patient_name", "app.patient_code", "app.gender_txt", "app.patient_dob", "app.blood_group", "app.age", "app.mobile1", "app.appoint_type_code", "app.ccm_client_name", "app.case_type_name", "app.appoint_no_pk", "wsec_user.user_fullname", "app.calling_note")
                ->whereIn('s.schedule_no_fk', $schedule_id)
                ->orderBy('s.slot_no_pk', 'ASC')
                ->get();

            foreach ($schedules as $item) {
                $this->doctorScheduleDayOff->create([
                    'SCHEDULE_NO_FK' => $item->schedule_no_fk,
                    'DOCTOR_PERSON_NO_FK' => $item->doctor_person_no_fk,
                    'SCHEDULE_DT' => $item->schedule_dt,
                    'START_TIME' => $item->start_time,
                    'END_TIME' => $item->end_time,
                    'SCHEDULE_REASON' => $reason,
                    'STATUS' => 1,
                    'AU_ENTRY_BY' => auth()->user()->id,
                    'AU_ENTRY_AT' => now(),
                    'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                ]);
            }

            DB::commit();
            $message = ['msg' => 'Schedule Date Blocked Successfully', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollBack();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function unblockSlotShow($id = null)
    {
        return Template::loadview("admin.prescription.modal.unblock_slot_modal", compact('id'));
    }

    /**
     * Block Doctor Schedule Slot by Dates
     */
    public function unblockSlot(PrescriptionUnblockSlotRequest $request)
    {
        DB::beginTransaction();

        try {
            $schedule_id = $request->input('schedule_id');

            DoctorScheduleDayOff::where("schedule_no_fk", $schedule_id)->delete();

            DB::commit();
            $message = ['msg' => 'Schedule Date Unblocked Successfully', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollBack();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Block Slot by Dates
     */
    public function blockSlotOld(PrescriptionBlockSlotRequest $request)
    {
        /**
         * SCHEDULE_DAYOFF_NO_PK
         * SCHEDULE_NO_FK
         * DOCTOR_PERSON_NO_FK
         * SCHEDULE_DT
         * START_TIME
         * END_TIME
         * SCHEDULE_REASON
         * STATUS
         * AU_ENTRY_BY
         * AU_ENTRY_AT
         * AU_ENTRY_SESSION
         * AU_ENTRY_HOSPITAL_PK_NO
         * AU_UPDATE_BY
         * AU_UPDATE_AT
         * AU_UPDATE_SESSION
         * AU_UPDATE_HOSPITAL_PK_NO
         * AU_SYNC_HOSPITAL_PK_NO
         * AU_SYNC_AT
         */

        try {
            $appointment_id = json_decode($request->input('appointment_id'));
            $doctor_id = $request->input('doctor_id');
            $reason = $request->input('reason');

            # Get date according to selected schedule id
            $schedules = DB::table('hrms_schedule_slot_vw')->where('doctor_person_no_fk', '=', $doctor_id)
                ->when(count($appointment_id) > 0, function ($q) use ($appointment_id) {
                    return $q->whereIn('schedule_no_pk', $appointment_id);
                })
                ->where('doctor_person_no_fk', $doctor_id)
                ->select('schedule_no_pk', 'doctor_person_no_fk', 'schedule_dt', 'shift_desc', 'start_time', 'end_time', 'avg_duration', 'avg_load', 'block_load', 'total_slot')
                ->get();

            $scheduleDates = [];
            foreach ($schedules as $schedule) {
                array_push($scheduleDates, date('Y-m-d', strtotime($schedule->schedule_dt)));
            }

            // dd($scheduleDates);

            $query = DB::table('doctor_info_vw d')
                ->join('hrms_schedule p', 'p.doctor_person_no_fk', 'd.person_no_pk');
            $query->whereIn(DB::raw("trunc(p.schedule_dt)"), $scheduleDates);
            $query->where('d.person_no_pk', $doctor_id);
            $doctor_info = $query
                ->where('d.status', 1)
                ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'p.schedule_no_pk', 'p.schedule_dt')
                ->groupBy('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'p.schedule_no_pk', 'p.schedule_dt')
                ->orderBy('schedule_no_pk')
                ->get()
                ->toArray();

            // dd($doctor_info);

            $schedule = [];
            if (!empty($doctor_info)) {
                foreach ($doctor_info as $doctor) {
                    $schedule[date('Y-m-d', strtotime($doctor->schedule_dt))] =
                        DB::table('hrms_schedule_slot s')
                        ->leftJoin('patn_v1_appointment_vw app', 's.slot_no_pk', 'app.slot_no_fk')
                        ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 's.block_by')
                        ->select('s.*', "app.patient_no_pk", "app.patient_name", "app.patient_code", "app.gender_txt", "app.patient_dob", "app.blood_group", "app.age", "app.mobile1", "app.appoint_type_code", "app.ccm_client_name", "app.case_type_name", "app.appoint_no_pk", "wsec_user.user_fullname", "app.calling_note")
                        ->where('s.schedule_no_fk', $doctor->schedule_no_pk)
                        // ->groupBy('schedule_dt')
                        ->orderBy('s.slot_no_pk', 'ASC')
                        ->get();
                }
            }

            // dd($schedule);

            foreach ($schedule as $item) {
                foreach ($item as $row) {
                    $this->doctorScheduleDayOff->create([
                        // SCHEDULE_DAYOFF_NO_PK
                        'SCHEDULE_NO_FK' => $row->schedule_no_fk,
                        'DOCTOR_PERSON_NO_FK' => $row->doctor_person_no_fk,
                        'SCHEDULE_DT' => $row->schedule_dt,
                        'START_TIME' => $row->start_time,
                        'END_TIME' => $row->end_time,
                        'SCHEDULE_REASON' => $reason,
                        'STATUS' => 1,
                        'AU_ENTRY_BY' => auth()->user()->id,
                        'AU_ENTRY_AT' => now(),
                        // 'AU_ENTRY_SESSION'      => null,
                        'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                        // AU_UPDATE_BY
                        // AU_UPDATE_AT
                        // AU_UPDATE_SESSION
                        // AU_UPDATE_HOSPITAL_PK_NO
                        // AU_SYNC_HOSPITAL_PK_NO
                        // AU_SYNC_AT
                    ]);
                }
            }

            dd("Finished");
        } catch (Exception $e) {
            dd($e->getMessage());
        }



        // $this->doctorScheduleDayOff->create([
        //     SCHEDULE_DAYOFF_NO_PK
        //     // SCHEDULE_NO_FK
        //     // DOCTOR_PERSON_NO_FK
        //     // SCHEDULE_DT
        //     // START_TIME
        //     // END_TIME
        //     // SCHEDULE_REASON
        //     // STATUS
        //     // AU_ENTRY_BY
        //     // AU_ENTRY_AT
        //     // AU_ENTRY_SESSION
        //     // AU_ENTRY_HOSPITAL_PK_NO
        //     // AU_UPDATE_BY
        //     // AU_UPDATE_AT
        //     // AU_UPDATE_SESSION
        //     // AU_UPDATE_HOSPITAL_PK_NO
        //     // AU_SYNC_HOSPITAL_PK_NO
        //     // AU_SYNC_AT
        // ]);

        dd($schedule);

        # Insert data to the HRMS_SCHEDULE_DAYOFF table

        dd($request->all());
    }

    public function prescriptionEngineVideoCall()
    {
        return Template::loadview("admin.prescription.prescription_video_cl");
    }

    public function prescription_by_reception()
    {

        if ($tab_type == 1) {
            $doctors = Doctor::latest()->get();
            $specialization = $this->getLookupListByCode("DOCSPL");
            $chiefcom = $this->getLookupListByCode("CHIEFCOM");
            $priority = $this->getLookupListByCode("PRIORITY");
            $appointment_date = date("d-m-Y");

            $auth_id = Auth::id();
            $person_id = DB::table("wsec_user")->select("person_no_fk")->where("user_no_pk", $auth_id)->first();

            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select('a.*', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk')
                ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
                ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
                ->where("a.appoint_date", date("Y-m-d"))
                ->where('a.doctor_no_fk', $person_id->person_no_fk)
                ->orderBy('a.appoint_no_pk', 'DESC')
                ->get();

            $app_arr = [];
            $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->consult_ind == 1) {
                        $payment_ind++;
                    }

                    if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                        $pending_ind++;
                    }

                    if ($app_data->cancel_ind == 1) {
                        $cancel_ind++;
                    }

                    if ($app_data->prescription_no_pk != "") {
                        $prescription_ind++;
                    }
                }
            }
            $page_type = "list";
            return Template::loadView("admin.patient.appointment_list_doctor_wise", ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'specialization' => $specialization, 'doctors' => $doctors, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, "appointment_date" => $appointment_date, "page_type" => $page_type]);
        } elseif ($tab_type == 2) {
            return Template::loadview(
                "admin.prescription.prescription_by_reception",
                [
                    'pr_by_receptionists' => DB::table('prescription_receptionist_wise_vw')
                        ->where(DB::raw("trunc(prescription_date)"), '=', date('Y-m-d'))
                        ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'))
                        ->orderBy('prescription_date', 'desc')
                        ->get()
                        ->toArray(),
                ]
            );
        }

        //return Template::loadview("admin.pta.prescription_by_reception");
    }

    public function printPrescriptio()
    {
        $prescription_mst = DB::table('psn_t_prescription_vw a')
            ->select('a.doctor_name', 'a.service_number', 'a.prescription_uid', 'a.patient_name_rank', 'b.patient_type', 'b.pat_relation', 'b.ref_patient_name_rank', 'a.au_entry_at', 'b.age', 'b.gender_txt', 'b.specialization', 'b.doctor_signature', 'b.qualification', 'b.degree1', 'b.degree2', 'b.degree3', 'b.degree4', 'a.su_name', 'a.next_followup_dt', 'a.followup_num', 'a.followup_mu', 'a.ref_doctor', 'a.prescription_no_pk', 'a.unit_name', 'a.base_name', 'a.external_pres_ind', 'c.dental_ind', 'c.eye_ind')
            ->leftJoin("pat_appoint_wl_vw b", "a.appoint_no_fk", "=", "b.patapp_no_pk")
            ->leftJoin("sys_serviceunit c", "a.su_no_fk", "=", "c.su_no_pk")
            ->where('a.prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText(12345);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText(12345);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $procedure_arr = ["SERVICE", "SUR"];
            foreach ($prescription_dtl as $dtl_row) {

                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L")
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                    if ($dtl_row->left_right_ind == "R")
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookup_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }

        $pdf = PDF::loadView("admin.prescription.prescription_print_pdf_v1", ["patient_barcode" => $patient_barcode, "prescription_barcode" => $prescription_barcode]);
        return $pdf->stream("Prescription-prescription.pdf");
    }

    public function pat_appointment_list()
    {
        $type = 'Appointed & Prescribed';
        $auth_id = Auth::id();
        $doctor_id = Session::get("user.ses_person_no_fk");
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $appointment_date = date("Y-m-d");
        $appointment_rs = DB::select("SELECT pat.*
        , psn.prescription_no_pk
         FROM    patn_appointment_vw pat
           LEFT JOIN
               psn_t_prescription_vw psn
               ON pat.appoint_no_pk = psn.appoint_no_fk
         WHERE    pat.au_entry_hospital_pk_no = $hospital_id
               AND pat.doctor_no_fk = $doctor_id
               and appoint_status =2
               and trunc(appoint_date)= '$appointment_date'
      ORDER BY appoint_no_pk DESC");
        // $appointment_rs = DB::table("patn_appointment_vw")
        //     ->select("patn_appointment_vw.*", "psn_t_prescription_vw.prescription_no_pk")
        //     ->leftjoin("psn_t_prescription_vw", "patn_appointment_vw.appoint_no_pk", "=", "psn_t_prescription_vw.appoint_no_fk")
        //     ->orderBy("patn_appointment_vw.appoint_no_pk", "desc")
        //     ->where("au_entry_hospital_no_fk", $hospital_id)
        //     ->where("appoint_date", $appointment_date)
        //     ->where('appoint_status', 2)
        //     ->where('patn_appointment_vw.doctor_no_fk', $doctor_id)
        //     ->get();
        // dd($appointment_date, $appointment_rs);
        return Template::loadView("admin.prescription.apointment_list", [
            'type' => $type,
            'appointment_rs' => $appointment_rs,
        ]);
    }
    public function emergency_prescription_list()
    {
        // $appointment_date = date("Y-m-d", strtotime(date("d-m-Y")));
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $appointment_date = date("Y-m-d");
        $appointment_rs = DB::table("psn_t_prescription_vw")
            ->select("*")
            // ->where("doctor_person_no_fk", Session::get('user.ses_person_no_fk'))
            ->where("au_entry_hospital_no_fk", $hospital_id)
            ->where("appoint_no_fk", null)
            ->orderBy("prescription_no_pk", "desc")
            ->whereRaw(" trunc(au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
            ->get();

        return Template::loadView("admin.prescription.emergency_prescription_list", [
            'appointment_rs' => $appointment_rs,
        ]);
    }

    public function opd_nurse_station(Request $request)
    {

        $type = 'OPD Nurse Station';
        $auth_id = Auth::id();
        $doctor_id = Session::get("user.ses_person_no_fk");

        $appointment_date = date("Y-m-d", strtotime(date("d-m-Y")));
        $search_date_from = date('Y/m/d', strtotime($request->search_date_from)); //', 'DD/MM/YYYY')";//TO_CHAR (SYSDATE, 'DD/MM/YYYY')
        $search_date_to = date('Y/m/d', strtotime($request->search_date_to));
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select("patn_appointment_vw.*", "psn_t_prescription_vw.prescription_no_pk")
            ->leftjoin("psn_t_prescription_vw", "patn_appointment_vw.appoint_no_pk", "=", "psn_t_prescription_vw.appoint_no_fk")
            ->orderBy("patn_appointment_vw.appoint_no_pk", "desc")
            ->where("appoint_date", $appointment_date)
            ->where("patn_appointment_vw.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            //->whereBetween("appoint_date",[$search_date_from,$search_date_to])
            ->where('appoint_status', 1)
            ->where('cancel_ind', '!=', 1)
            ->where("consult_ind", 1)

            // ->where('patn_appointment_vw.doctor_no_fk', $doctor_id)
            ->get();

        return Template::loadView("admin.prescription.opd_nurse_station", [
            'type' => $type,
            'appointment_rs' => $appointment_rs,
        ]);
    }

    public function opd_nurse_station_appointed_list(Request $request)
    {
        $type = 'OPD Nurse Station';
        $auth_id = Auth::id();
        $doctor_id = Session::get("user.ses_person_no_fk");
        $pat_id = $request->patient_id;
        // dd($pat_id);

        $appointment_date = date("Y-m-d", strtotime(date("d-m-Y")));
        $search_date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $search_date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select("patn_appointment_vw.*", "psn_t_prescription_vw.prescription_no_pk")
            ->leftjoin("psn_t_prescription_vw", "patn_appointment_vw.appoint_no_pk", "=", "psn_t_prescription_vw.appoint_no_fk")
            ->orderBy("patn_appointment_vw.appoint_no_pk", "desc");
        if ($search_date_from != '' && $search_date_to != '') {
            $appointment_rs->whereBetween("appoint_date", [$search_date_from, $search_date_to]);
        } elseif ($search_date_from != '') {
            $appointment_rs->where("appoint_date", $search_date_from);
        }
        if ($pat_id != "") {
            $appointment_rs->where('patient_no_pk', $pat_id);
        }


        // ->where('patn_appointment_vw.doctor_no_fk', $doctor_id)
        $appointment_rs->where('appoint_status', 1)->where("consult_ind", 1);
        // dd($appointment_rs->get());
        return Template::loadView("admin.prescription.opd_nurse_station_all_appointment_list", [
            'type' => $type,
            'appointment_rs' => $appointment_rs->get(),
        ]);
    }

    public function all_patient_app_pres(Request $request)
    {
        // dd($request->page_type);
        $type = $request->tab_type;
        $patient_id = $request->patient_id;
        $patient_id_cond = isset($request->patient_id) ? 'and ' : '';
        $auth_id = Auth::id();
        $user_code = Session::get('user.ses_user_pk_no');
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $doctor_id = Session::get("user.ses_person_no_fk");
        $page_type = isset($request->page_type) ? $request->page_type : '';
        //        $doctor_data = [];
        //        if (!empty($doctor_id)) {
        //            foreach ($doctor_id as $id) {
        //                $doctor_data[$id->person_no_pk] = $id;
        //            }
        //        }

        // if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

        //     $date_from =date('Y-m-d', strtotime($request->search_date_from));
        //     $date_to = date('Y-m-d', strtotime($request->search_date_to));

        // } else {
        //     $date_from = "";
        //     $date_to = "";
        // }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause  pat.patient_no_pk = $patient_id" : "";
        // $clause = ($sql_cond == "") ? " and" : " and";
        // $sql_cond .= ($request->search_date_from != "") ? " $clause pat.appoint_date between '$date_from' and '$date_to'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " $clause trunc(pat.appoint_date) between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')" : "";
        // dd($page_type);
        if ($page_type != "NURSE_STATION") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($doctor_id != "") ? " $clause  pat.doctor_no_fk = $doctor_id" : "";
        }

        // dd( $sql_cond);
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($type == "Appointed & Prescribed") {

            $appointment_rs = DB::select(DB::raw("SELECT pat.*
            , psn.prescription_no_pk
             FROM    patn_appointment_vw pat
               LEFT JOIN
                   psn_t_prescription_vw psn
                   ON pat.appoint_no_pk = psn.appoint_no_fk
             WHERE    pat.au_entry_hospital_pk_no = $hospital_id
                  AND pat.consult_ind = 1
                   $sql_cond
          ORDER BY appoint_no_pk DESC"));
            // $appointment_rs = DB::select(DB::raw("select pat.*,psn.prescription_no_pk from patn_appointment_vw pat
            //             left join psn_t_prescription_vw psn
            //             on pat.appoint_no_pk = psn.appoint_no_fk where pat.au_entry_hospital_pk_no = $hospital_id $sql_cond and psn.doctor_no_fk = $doctor_id
            //             order by pat.appoint_no_pk DESC"));

            return Template::loadView("admin.prescription.all_apointment_list", ['type' => $type, 'appointment_rs' => $appointment_rs]);
        } elseif ($type == "Appointed") {

            $appointment_rs = DB::select(DB::raw(" SELECT pat.*
            , psn.prescription_no_pk
             FROM    patn_appointment_vw pat
               LEFT JOIN
                   psn_t_prescription_vw psn
                   ON pat.appoint_no_pk = psn.appoint_no_fk
             WHERE     pat.appoint_status = 1
                  AND pat.au_entry_hospital_pk_no = $hospital_id
                --    AND pat.doctor_no_fk = $doctor_id
                AND pat.consult_ind = 1
                   $sql_cond
          ORDER BY appoint_no_pk DESC"));
            // $appointment_rs = DB::select(DB::raw("select pat.*,psn.prescription_no_pk from patn_appointment_vw pat
            //             left join psn_t_prescription_vw psn
            //             on pat.appoint_no_pk = psn.appoint_no_fk where pat.appoint_status = 1  $sql_cond and pat.au_entry_hospital_pk_no = $hospital_id and psn.doctor_no_fk = $doctor_id
            //             order by appoint_no_pk DESC"));
            // dd($appointment_rs);
            return Template::loadView("admin.prescription.appointed_list", ['type' => $type, 'appointment_rs' => $appointment_rs]);
        } elseif ($type == "Prescribed") {
            // dd($type);
            $appointment_rs = DB::select(DB::raw("SELECT pat.*
            , psn.prescription_no_pk
             FROM    patn_appointment_vw pat
               LEFT JOIN
                   psn_t_prescription_vw psn
                   ON pat.appoint_no_pk = psn.appoint_no_fk
             WHERE     pat.appoint_status = 2
                  AND pat.au_entry_hospital_pk_no = $hospital_id
                --    AND pat.doctor_no_fk = $doctor_id
                   $sql_cond
          ORDER BY appoint_no_pk DESC"));
            // dd( $appointment_rs);
            // $appointment_rs = DB::select(DB::raw("select psn.*,pat.* from psn_t_prescription_vw psn
            //     left join patn_appointment_vw pat on psn.appoint_no_fk = pat.appoint_no_pk where pat.appoint_status = 2 $sql_cond and pat.au_entry_hospital_pk_no = $hospital_id and pat.doctor_no_fk = $doctor_id
            //             order by pat.appoint_no_pk DESC"));
            //             dd( $appointment_rs);
            //->where('patn_appointment_vw.au_entry_by',$auth_id)
            return Template::loadView("admin.prescription.prescribed_list", ['type' => $type, 'appointment_rs' => $appointment_rs]);
        }
    }

    public function all_emergency_patient_app_pres(Request $request)
    {
        $patient_id = $request->patient_id;
        $doctor_id = Session::get("user.ses_person_no_fk");
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($patient_id != "") ? " patient_no_fk = $patient_id" : "";

        $clause = ($sql_cond == "") ? "" : " and";

        $sql_cond .= ($request->search_date_from != "") ? " $clause trunc(prescription_date) between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')" : "";
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $appointment_rs = DB::select(DB::raw("select photo_name,gender_txt,patient_name,patient_code,age,prescription_no_pk ,patient_no_fk from psn_t_prescription_vw where $sql_cond and au_entry_hospital_no_fk = $hospital_id and appoint_no_fk is null order by prescription_date desc"));
        // and doctor_person_no_fk = $doctor_id
        return Template::loadView("admin.prescription.emergency_prescribed_list", ['appointment_rs' => $appointment_rs]);
    }

    public function opdPrintPrescription($prescription_id = "")
    {
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        // ->orderBy('prescription_dtl_no_pk', 'asc')

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('prescription_med_no_pk', 'asc')->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();

            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        if ($prescription_mst->physio_ind == 1) {
            return Template::loadview("admin.prescription.phy_prescription_print", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'acup_thy_arr' => $acup_thy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item
            ]);
        } else {
            // dd($left_side_arr);
            return Template::loadview("admin.prescription.opd_prescription_print", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item,
                'pres_med' => $pres_med
            ]);
        }
    }


    public function opdPrintPrescriptionUHL($prescription_id = "")
    {
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)
            ->orderBy('prescription_dtl_no_pk', 'asc')->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('prescription_med_no_pk', 'asc')->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();

            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : 'N/A';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : 'N/A';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $m_duration;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : 'N/A';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : 'N/A';
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $e_location . '_' . $m_duration;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : 'N/A';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : 'N/A';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $m_duration;
                    // dd($therapiu_therapy_arr);
                }
                if (in_array($dtl_row->lookupdata_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];

        foreach ($prescription_med as $med) {
            $key = $med->route . '^' . $med->dosage . '^' . $med->duration . '^' .
                $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' .
                $med->continue_ind . '^' . $med->multidose_txt;

            // unique রাখার জন্য multidose_txt এবং index ব্যবহার
            $pres_med[$med->brand_name][] = $med;
        }

        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();


        if ($prescription_mst->physio_ind == 1) {
            return Template::loadview("admin.prescription.phy_prescription_print", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'acup_thy_arr' => $acup_thy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item
            ]);
        } else {
            return Template::loadview("admin.prescription.uhl.opd_prescription_print_uhl", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item,
                'pres_med' => $pres_med,
                'vitals' => $vitals,
                'acup_thy_arr' => $acup_thy_arr
            ]);
        }
    }

    public function opdPrintPrescriptionUHLApp($prescription_id = "")
    {
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)
            ->orderBy('prescription_dtl_no_pk', 'asc')->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('prescription_med_no_pk', 'asc')->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();

            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : 'N/A';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : 'N/A';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $m_duration;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : 'N/A';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : 'N/A';
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $e_location . '_' . $m_duration;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : 'N/A';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : 'N/A';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $m_duration;
                    // dd($therapiu_therapy_arr);
                }
                if (in_array($dtl_row->lookupdata_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        if ($prescription_mst->physio_ind == 1) {
            return Template::loadview("admin.prescription.phy_prescription_print", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'acup_thy_arr' => $acup_thy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item
            ]);
        } else {
            return Template::loadview("admin.prescription.uhl.opd_prescription_print_uhl_app", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item,
                'pres_med' => $pres_med,
                'acup_thy_arr' => $acup_thy_arr
            ]);
        }
    }


    public function opdPreviewPrescriptionUHL(Request $request)
    {
        $chief_complaint_preview = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $request->prescription_id)->get();
        $prescription_med = DB::table('psn_t_prescription_med_vw')
            ->select(
                'item_name',
                'dosage',
                'route',
                'duration',
                'duration_mu',
                'item_type',
                'medicine_enddate',
                DB::raw('TRUNC(SYSDATE) - TRUNC(medicine_enddate) as date_diff')
            )
            ->where('prescription_no_fk', '=', $request->prescription_id)
            ->orderBy('prescription_med_no_pk', 'asc')
            ->get();

        $expired = $prescription_med->filter(function ($item) {
            return $item->date_diff > 0;
        });

        $not_expired = $prescription_med->filter(function ($item) {
            return $item->date_diff <= 0;
        });
        $vitals = DB::table('psn_t_patvitals')
            ->select('medical_history', 'past_history', 'complaints_history', 'family_history')
            ->where('prescription_no_fk', $request->prescription_id)->first();
        return response()->json([$chief_complaint_preview, $prescription_med, $expired, $not_expired, $vitals]);
    }


    public function opdPrintPrescription2($prescription_id = "")
    {
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $physio_others = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=', $prescription_id)->where('lookup_uid', 'PHYASSOTH')->get();
        $physio_lifestyles = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=', $prescription_id)->where('lookup_uid', 'PHYASSLIFESTYLE')->get();
        $physio_symptoms = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=', $prescription_id)->where('lookup_uid', 'PHYASSSYMPT')->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();

            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity;
                }

                // if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                //     $lookup_name = "Procedure";
                //     $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                // }
                if (in_array($dtl_row->lookupdata_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }

        if ($prescription_mst->physio_ind == 1) {
            return Template::loadview("admin.prescription.phy_prescription_print2", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'acup_thy_arr' => $acup_thy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item,
                'physio_others' => $physio_others,
                'physio_lifestyles' => $physio_lifestyles,
                'physio_symptoms' => $physio_symptoms
            ]);
        } else {
            return Template::loadview("admin.prescription.opd_prescription_print", [
                'prescription_mst' => $prescription_mst,
                "patient_barcode" => $patient_barcode,
                "prescription_barcode" => $prescription_barcode,
                "prescription_med" => $prescription_med,
                "pr_arr" => $pr_arr,
                "in_arr" => $in_arr,
                "in_find_arr" => $in_find_arr,
                "left_side_arr" => $left_side_arr,
                "dental_arr" => $dental_arr,
                "selected_dental_arr" => $selected_dental_arr,
                "ocular_exam_left_arr" => $ocular_exam_left_arr,
                "ocular_exam_right_arr" => $ocular_exam_right_arr,
                "ele_thy_arr" => $ele_thy_arr,
                "therapiu_therapy_arr" => $therapiu_therapy_arr,
                'allergy' => $allergy,
                'chronic_item' => $chronic_item
            ]);
        }
    }

    public function opdPrintvaitals($appoint_id)
    {
        return Template::loadview("admin.prescription.vitals_print_popup", ['appoint_id' => $appoint_id]);
    }


    public function opdPrintPrescriptionPdf($prescription_id, $type = "")
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        // $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_mst = DB::table('psn_t_prescription_vw')
            ->select(
                'psn_t_prescription_vw.*',
                'patn_registration.mobile1',
                DB::raw("pat_age(patn_registration.dob, NVL(psn_t_prescription_vw.prescription_date, SYSDATE)) as pat_age")
            )
            ->leftJoin('patn_registration', 'psn_t_prescription_vw.patient_no_fk', '=', 'patn_registration.patient_no_pk')
            ->where('psn_t_prescription_vw.prescription_no_pk', '=', $prescription_id)
            ->first();


        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('prescription_med_no_pk', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS", "SUR", "SERVICE"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }

                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
        $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];

        if (isset($prescription_mst) && $prescription_mst->physio_ind == 1) {
            return view("admin.prescription.phy_prescription_print_pdf", $data);
        } else {
            if (Session::get('user.ses_hospital_code') == "IMPERIAL") {

                return view("admin.prescription.opd_prescription_print_pdf_imperial", $data);
            } elseif (Session::get('user.ses_hospital_code') == "AMCSH") {

                return view("admin.prescription.opd_prescription_print_pdf_amcsh", $data);
            } elseif (Session::get('user.ses_hospital_code') == "DMHL") {
                if (Session::get('user.serviceunit_code') == "GYNOB") {
                    return view("admin.prescription.opd_prescription_print_pdf_dmgh_v2", $data);
                } else {
                    return view("admin.prescription.opd_prescription_print_pdf_dmgh", $data);
                }
            } elseif (Session::get('user.ses_hospital_code') == "SSG") {
                return view("admin.prescription.opd_prescription_print_pdf_imperial", $data);
            } elseif (Session::get('user.ses_hospital_code') == "GMC") {
                return view("admin.prescription.opd_prescription_print_pdf_gmch", $data);
            } else {

                if (count($pres_med) > 10) {

                    return view("admin.prescription.opd_prescription_print_v2", $data);
                } else {

                    return view("admin.prescription.opd_prescription_print_pdf", $data);
                }
            }
        }
    }


    public function opdPrintPrescriptionPdfUHL($prescription_id, $type = "")
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')
            ->select("psn_t_prescription_vw.*", "employee_info_vw.serviceunit_no_fk_dept_name")
            ->leftJoin('employee_info_vw', 'ref_doctor', '=', 'employee_info_vw.person_no_pk')
            ->where('prescription_no_pk', '=', $prescription_id)
            ->first();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS", "SERVICE", "PKG"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                // if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                //     $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                //     $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                //     $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;;
                // }


                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        (isset($dtl_row->e_location) ? $dtl_row->e_location : '') . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }


                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $key = $med->route . '^' . $med->dosage . '^' . $med->duration . '^' .
                $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' .
                $med->continue_ind . '^' . $med->multidose_txt;

            // unique রাখার জন্য multidose_txt এবং index ব্যবহার
            $pres_med[$med->brand_name][] = $med;
        }

        $allergy = [];
        $chronic_item = [];
        if ($prescription_mst->appoint_no_fk != '') {
            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // dd($allergy,$prescription_mst->appoint_no_fk);
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // ->where('prescription_no_fk', '=', $prescription_id)
        }
        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];
        if (isset($prescription_mst) && $prescription_mst->physio_ind == 1) {
            // return view("admin.prescription.phy_prescription_print_pdf", $data);
            // return view("admin.prescription.uhl.phy_prescription_print_pdf", $data);
            //   if (Session::get('user.ses_hospital_code') == 'DMHL'){
            // return view("admin.prescription.uhl.phy_prescription_print_pdf", $data);
            //   }else{
            return view("admin.prescription.phy_prescription_print_pdf_v2", $data);
            //   }

        } else {
            if (count($pres_med) >= 10) {
                // return view("admin.prescription.opd_prescription_print_v2", $data);
                return view("admin.prescription.uhl.opd_prescription_print_pdf_uhl_v4", $data);
            } else {
                if (Session::get('user.serviceunit') == "Obstetrics & Gynaecology") {
                    // return view("admin.prescription.opd_prescription_print_pdf_dmgh_v2", $data);
                    return view("admin.prescription.uhl.opd_prescription_print_pdf_uhl_gynae", $data);
                } else {
                    return view("admin.prescription.uhl.opd_prescription_print_pdf_uhl", $data);
                }
            }
        }
    }
    public function prescriptionPrintPdfUHLA5($prescription_id, $type = "")
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')
            ->select("psn_t_prescription_vw.*", "employee_info_vw.serviceunit_no_fk_dept_name")
            ->leftJoin('employee_info_vw', 'ref_doctor', '=', 'employee_info_vw.person_no_pk')
            ->where('prescription_no_pk', '=', $prescription_id)
            ->first();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS", "SERVICE"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                // if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                //     $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                //     $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                //     $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;;
                // }


                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        (isset($dtl_row->e_location) ? $dtl_row->e_location : '') . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }


                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type . '`' . $med->generic_name][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }

        $allergy = [];
        $chronic_item = [];
        if ($prescription_mst->appoint_no_fk != '') {
            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // dd($allergy,$prescription_mst->appoint_no_fk);
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // ->where('prescription_no_fk', '=', $prescription_id)
        }
        $data = [
            'prescription_mst' => $prescription_mst,
            'po_hospital_details' => $po_hospital_details,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];
        if (isset($prescription_mst) && $prescription_mst->physio_ind == 1) {
            // return view("admin.prescription.phy_prescription_print_pdf", $data);
            // return view("admin.prescription.uhl.phy_prescription_print_pdf", $data);
            //   if (Session::get('user.ses_hospital_code') == 'DMHL'){
            // return view("admin.prescription.uhl.phy_prescription_print_pdf", $data);
            //   }else{
            return view("admin.prescription.phy_prescription_print_pdf_v2", $data);
            //   }

        } else {
            if (count($pres_med) >= 10) {
                // return view("admin.prescription.opd_prescription_print_v2", $data);
                return view("admin.prescription.uhl.opd_prescription_print_pdf_uhl_v4", $data);
            } else {
                if (Session::get('user.serviceunit') == "Obstetrics & Gynaecology") {
                    // return view("admin.prescription.opd_prescription_print_pdf_dmgh_v2", $data);
                    return view("admin.prescription.uhl.opd_prescription_print_pdf_uhl_gynae", $data);
                } else {
                    $pdf = PDF::loadView("admin.prescription.uhl.prescription_print_pdf_a5", $data)->setPaper('a5', 'portrait');
                    // return view("admin.prescription.uhl.prescription_print_pdf_a5", $data);
                    return $pdf->stream("prescription_$prescription_mst->prescription_uid.pdf", array("Attachment" => false));
                }
            }
        }
    }


    public function opSummaryPrintPdfUHL($prescription_id)
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)
            ->orderBy('prescription_dtl_no_pk', 'asc')->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS", "SERVICE", "SERVICE"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                // if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                //     $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                //     $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                //     $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;;
                // }


                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        (isset($dtl_row->e_location) ? $dtl_row->e_location : '') . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }


                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type . '`' . $med->generic_name][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }

        $allergy = [];
        $chronic_item = [];
        if ($prescription_mst->appoint_no_fk != '') {
            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // dd($allergy,$prescription_mst->appoint_no_fk);
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // ->where('prescription_no_fk', '=', $prescription_id)
        }
        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];
        if (isset($prescription_mst) && $prescription_mst->physio_ind == 1) {
            return view("admin.prescription.phy_prescription_print_pdf", $data);
            // return view("admin.prescription.uhl.phy_prescription_print_pdf", $data);
        } else {
            // if (count($pres_med) > 10) {
            //     return view("admin.prescription.opd_prescription_print_v2", $data);
            // } else {
            return view("admin.prescription.uhl.op_summary_print_pdf_uhl", $data);
            // }
        }
    }


    public function prescriptionPrintPdfUHL($prescription_id)
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }

                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }

        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        // dd($pres_med,$prescription_med);
        $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
        $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();

        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];

        return view("admin.prescription.uhl.prescription_print_pdf_uhl", $data);
    }

    public function opdPrintPrescriptionPdf2($prescription_id)
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->get();
        // $physio_assesment = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=',$prescription_id);

        // $physio_others = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=',$prescription_id)->where('lookup_uid','PHYASSOTH')->get();
        // //dd($physio_others);
        // $physio_lifestyles = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=',$prescription_id)->where('lookup_uid','PHYASSLIFESTYLE')->get();
        // $physio_symptoms = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=',$prescription_id)->where('lookup_uid','PHYASSSYMPT')->get();
        $physio_erectiles = DB::table('erec_dysfunction_question')->where('prescription_no_fk', '=', $prescription_id)->first();
        $phyipss = DB::table('psn_t_physio_ipss')->where('prescription_no_fk', $prescription_id)->first();
        $phyiief = DB::table('psn_t_physio_shim')->where('prescription_no_fk', $prescription_id)->first();
        $patient_therapy_details = DB::table('patient_therapy_details')->where('prescription_no_fk', $prescription_id)->first();

        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();

        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];

            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {

                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                //$left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }


                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity;
                }

                if (in_array($dtl_row->lookupdata_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }


        $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
        $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
        // dd($in_find_arr);

        // dd($ele_thy_arr, $therapiu_therapy_arr);
        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "physio_erectiles" => $physio_erectiles,
            "phyipss" => $phyipss,
            "phyiief" => $phyiief,
            "patient_therapy_details" => $patient_therapy_details
        ];


        // if (isset($prescription_mst) && $prescription_mst->su_no_fk == 1099) {
        //     //return view("admin.prescription.phy_prescription_print_pdf", $data);
        //     $pdf = PDF::loadView("admin.prescription.phy_prescription_print_pdf", $data);
        // }else{
        //     //return view("admin.prescription.phy_prescription_print_pdf", $data);

        if (isset($prescription_mst) && $prescription_mst->physio_ind == 1) {
            // $pdf = PDF::loadView("admin.prescription.phy_prescription_print_pdf", $data);
            // dd($prescription_mst->physio_ind);
            return view("admin.prescription.phy_prescription_print_pdf2", $data);
        } else {
            // $pdf = PDF::loadView("admin.prescription.opd_prescription_print_pdf", $data);
            return view("admin.prescription.opd_prescription_print_pdf", $data);
        }



        // return $pdf->stream("Prescription-$prescription_id.pdf");

        // return Template::loadView("admin.prescription.opd_prescription_print_pdf", [
        //     'prescription_mst' => $prescription_mst,
        //     "patient_barcode" => $patient_barcode,
        //     "prescription_barcode" => $prescription_barcode,
        //     "prescription_med" => $prescription_med,
        //     "left_side_arr" => $left_side_arr,
        //     "pr_arr" => $pr_arr,
        //     "in_arr" => $in_arr,
        //     "dental_arr" => $dental_arr,
        //     "selected_dental_arr" => $selected_dental_arr,
        //     "ocular_exam_left_arr" => $ocular_exam_left_arr,
        //     "ocular_exam_right_arr" => $ocular_exam_right_arr,
        //     "vitals" => $vitals,
        // ]);
    }
    public function getPrevPrescriptionDtls($patient_id, $patient_code, Request $request)
    {
        // dd($patient_code);
        $bg = DB::table('pat_registration_wl_vw')->select('blood_group', 'blood_group_txt')
            ->where('patient_code', $patient_code)->first();
        $bloodg = $this->getLookupListByCode("BLOODG");

        $doctor_id = Session::get('user.ses_user_pk_no');
        $hdn_su_no = $request->hdn_su_no;
        $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $hdn_su_no); // [];
        // dd($su_info);
        $followup_num = $followup_mu_name = $template_name = "";
        $continue_med_arr = DB::table("psn_t_prescription_med_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();
        // pat_vitals_rs
        // $instructions = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='INSTRUCTION'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        // $route = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='ROUTE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        // $dose = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='DOSE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        // $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "PASTHI", "TREATMENTHISTORY"]);
        // dd($lookup_id_arr);
        $pat_pres_list_dtl = DB::table("psn_t_prescription_vw")->where("patient_no_fk", $patient_id)->orderBy("au_entry_at", "desc")->get();

        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {
                $pat_pres_list[$pat_pres->prescription_no_pk] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind . "_" . $pat_pres->patient_code;
            }
        }
        // dd($pat_pres_list);

        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)
            ->whereIn("lookup_uid", ['RAD', 'LAB'])->orderBy("lookup_uid", "asc")->get();

        $path_rad_invest = [];


        $chief_com = DB::table("patn_appointment_vw")->select('chif_complain')->where("appoint_no_pk", $request->hdn_appointment_id)->first();

        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $treatment_his_arr = $phi_arr = $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = [];
        $pat_dtls_rs = DB::table("psn_t_prescription_dtl_vw a")
            ->where("a.appointment_pk_no", $request->hdn_appointment_id)->get();
        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "PASTHI") {
                    $phi_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "TREATMENTHISTORY") {
                    $treatment_his_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }
        // dd($pat_dtls_rs);
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["PTTE", "PTET"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }
        $department_id = $su_info;

        $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
        s.SERVICEUNIT_NO_PK
    FROM sysc_serviceunit s
        JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
    WHERE p.doctor_ind = 1 AND p.employee_ind = 1
        group by s.SERVICEUNIT_NAME,
        s.SERVICEUNIT_NO_PK
        order by 1 asc");

        //          $doctor_departments = DB::select("SELECT SERVICEUNIT_NAME, SERVICEUNIT_NO_PK
        // FROM sysc_serviceunit WHERE serviceunit_name IN ('PAEDIATRICS',
        //          'CARDIOLOGY',
        //          'GESTOLOGY',
        //          'MEDICINE',
        //          'NEUROLOGY',
        //          'NEPHROLOGY',
        //          'OPTHALMOLOGY',
        //          'SURGERY',
        //          'UROFLOWMETRY',
        //          'UROLOGY')");

        if (Session::get('user.ses_hospital_code') == 'IMPALA') {
            return Template::loadview("admin.prescription.prescription_details_doctor_wise_impala", ['left_side_arr' => $left_side_arr, 'cc_arr' => $cc_arr, 'ch_arr' => $ch_arr, 'cd_arr' => $cd_arr, 'pd_arr' => $pd_arr, 'instructions' => $instructions, 'dose' => $dose, 'duration' => $duration, 'meddurmu' => $meddurmu, "continue_med_arr" => $continue_med_arr, 'followup_mu' => $followup_mu, "followup_num" => $followup_num, "lookup_id_arr" => $lookup_id_arr, "followup_mu_name" => $followup_mu_name, "template_name" => $template_name, 'path_rad_invest' => $path_rad_invest, "su_info" => $su_info, 'eye_ocular_arr' => $eye_ocular_arr, 'dental_arr' => $dental_arr, 'selected_dental_arr' => $selected_dental_arr, 'pat_pres_list' => $pat_pres_list, 'route' => $route, 'chief_com' => $chief_com, 'duration_mu_phy' => $duration_mu_phy, 'tr_lk_id_arr' => $tr_lk_id_arr, 'department_id' => $department_id]);
        } else {
            return Template::loadview("admin.prescription.prescription_details_doctor_wise", ['treatment_his_arr' => $treatment_his_arr, 'phi_arr' => $phi_arr, 'left_side_arr' => $left_side_arr, 'cc_arr' => $cc_arr, 'ch_arr' => $ch_arr, 'cd_arr' => $cd_arr, 'pd_arr' => $pd_arr, 'instructions' => $instructions, 'dose' => $dose, 'duration' => $duration, 'meddurmu' => $meddurmu, "continue_med_arr" => $continue_med_arr, 'followup_mu' => $followup_mu, "followup_num" => $followup_num, "lookup_id_arr" => $lookup_id_arr, "followup_mu_name" => $followup_mu_name, "template_name" => $template_name, 'path_rad_invest' => $path_rad_invest, "su_info" => $su_info, 'eye_ocular_arr' => $eye_ocular_arr, 'dental_arr' => $dental_arr, 'selected_dental_arr' => $selected_dental_arr, 'pat_pres_list' => $pat_pres_list, 'route' => $route, 'chief_com' => $chief_com, 'duration_mu_phy' => $duration_mu_phy, 'tr_lk_id_arr' => $tr_lk_id_arr, 'department_id' => $department_id, 'intervention' => $intervention, 'doctor_departments' => $doctor_departments, 'bg' => $bg, 'bloodg' => $bloodg, 'patient_code' => $patient_code]);
        }
    }

    public function getPrevPrescriptionDtls2($patient_id, Request $request)
    {
        $hdn_su_no = $request->hdn_su_no;
        $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $hdn_su_no); // [];
        $followup_num = $followup_mu_name = $template_name = "";
        $continue_med_arr = DB::table("psn_t_prescription_med_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();

        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $physio_others = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSOTH")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val')->get();
        $physio_lifestyles = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSLIFESTYLE")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val', 'pres_lookupdata_no_pk as id')->get();

        //$physio_lifestyle = $this->getPresLookupListByCode("PHYASSLIFESTYLE");
        $physio_symptoms = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSSYMPT")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val', 'pres_lookupdata_no_pk as id')->orderBy('serial', "asc")->get();

        $physio_present_sexual_function = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PRNTSEXFUN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_previous_evaluation = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PREVEVAL')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_previous_treatment = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PREVTREAT')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_risk_factors = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'RISKFACTERECTILEDYSFUN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $past_medical_history = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PASTMEDHIS')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $family_history = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'FAMILYHISTORY')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physical_examination = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PHYSICALEXAM')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_blood = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONBLOODTEST')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_urine = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONURINETEST')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_usg = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONUSG')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_xray_mri = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONX-RAY/MRI')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $management_plan = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'MANAGEMENTPLAN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $ipss = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYIPSS")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();
        $iief = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYSHIM")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();




        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD"]);

        $pat_pres_list_dtl = DB::table("psn_t_prescription_vw")->where("patient_no_fk", $patient_id)->orderBy("au_entry_at", "desc")->get();

        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {

                $pat_pres_list[$pat_pres->prescription_uid] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind;
            }
        }

        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)
            ->whereIn("lookup_uid", ['RAD', 'LAB'])->orderBy("lookup_uid", "asc")->get();

        $path_rad_invest = [];


        $chief_com = DB::table("patn_appointment_vw")->select('chif_complain')->where("appoint_no_pk", $request->hdn_appointment_id)->first();

        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = [];
        $pat_dtls_rs = DB::table("psn_t_prescription_dtl_vw a")
            ->where("a.appointment_pk_no", $request->hdn_appointment_id)->get();
        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["PTTE", "PTET"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }
        $department_id = $su_info;
        return Template::loadview("admin.prescription.prescription_details_doctor_wise2", ['left_side_arr' => $left_side_arr, 'iief' => $iief, 'ipss' => $ipss, 'physio_others' => $physio_others, 'physio_lifestyles' => $physio_lifestyles, 'physio_symptoms' => $physio_symptoms, 'physio_erectile_edit' => '', 'physio_present_sexual_function' => $physio_present_sexual_function, 'physio_previous_evaluation' => $physio_previous_evaluation, 'physio_previous_treatment' => $physio_previous_treatment, 'past_medical_history' => $past_medical_history, 'physio_risk_factors' => $physio_risk_factors, 'family_history' => $family_history, 'physical_examination' => $physical_examination, 'investigation_blood' => $investigation_blood, 'investigation_urine' => $investigation_urine, 'investigation_usg' => $investigation_usg, 'investigation_xray_mri' => $investigation_xray_mri, 'management_plan' => $management_plan, 'cc_arr' => $cc_arr, 'ch_arr' => $ch_arr, 'cd_arr' => $cd_arr, 'pd_arr' => $pd_arr, 'instructions' => $instructions, 'dose' => $dose, 'duration' => $duration, 'meddurmu' => $meddurmu, "continue_med_arr" => $continue_med_arr, 'followup_mu' => $followup_mu, "followup_num" => $followup_num, "lookup_id_arr" => $lookup_id_arr, "followup_mu_name" => $followup_mu_name, "template_name" => $template_name, 'path_rad_invest' => $path_rad_invest, "su_info" => $su_info, 'eye_ocular_arr' => $eye_ocular_arr, 'dental_arr' => $dental_arr, 'selected_dental_arr' => $selected_dental_arr, 'pat_pres_list' => $pat_pres_list, 'route' => $route, 'chief_com' => $chief_com, 'duration_mu_phy' => $duration_mu_phy, 'tr_lk_id_arr' => $tr_lk_id_arr, 'department_id' => $department_id]);
    }

    public function appointmentAbsent(Request $request)
    {
        $app = $request->patapp_id;
        $data = ['appoint_status' => 3];

        DB::table('patn_appointment')->where('appoint_no_pk', $app)->update($data);
    }

    public function getPrescriptionDtls($prescription_id, $patient_code, Request $request)
    {
        $doctor_id = Auth::id();
        $hdn_su_no = $request->hdn_su_no;
        $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $hdn_su_no); // [];
        $bg = DB::table('pat_registration_wl_vw')->select('blood_group', 'blood_group_txt')
            ->where('patient_code', $patient_code)->first();

        $bloodg = $this->getLookupListByCode("BLOODG");

        $pat_dtls_rs = DB::table("psn_t_prescription_vw a")
            ->leftJoin("psn_t_prescription_dtl_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_id)->get();

        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");

        $treatment_his_arr = $phi_arr = $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $ptet_arr = $ptte_arr = $acup_arr = $find_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];
        $dental_arr1 = DB::table("psn_t_prescription")->select("dental_treatement")->where("prescription_no_pk", "=", $prescription_id)->first();

        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {

                $patient_id = $dtl_row->patient_no_fk;
                $next_followup_dt = $dtl_row->next_followup_dt;
                $followup_num = $dtl_row->followup_num;
                $followup_mu_name = $dtl_row->followup_mu;
                $template_name = $dtl_row->template_name;
                $refered_doc = $dtl_row->ref_doctor;
                $refered_doc_name = $dtl_row->ref_doc_name;
                $presc_note = $dtl_row->note;
                if ($dtl_row->lookup_uid == "HISTORY") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PASTHI") {
                    $phi_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "TREATMENTHISTORY") {
                    $treatment_his_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    // dd('ok');
                    $find_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB" || $dtl_row->lookupdata_uid == "SUR" || $dtl_row->lookupdata_uid == "SERVICE") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookupdata_uid == "ACUP") {
                    $acup_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if ($dtl_row->lookupdata_uid == "PTET") {
                    $ptet_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if ($dtl_row->lookupdata_uid == "PTTE") {
                    $ptte_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }

                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        // $instructions = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='INSTRUCTION'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        // $route = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='ROUTE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        // $dose = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='DOSE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "DISPOSAL", "REFDOC", "PROCEDURE", "PASTHI", "TREATMENTHISTORY"]);
        $continue_med_arr = DB::table("psn_t_prescription_med_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();

        $pat_med_rs = DB::table("psn_t_prescription_vw a")
            ->leftJoin("psn_t_prescription_med_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_id)->orderBy('prescription_med_no_pk', 'asc')->get();
        // $pat_eye_rs = [];
        $pat_eye_rs = DB::table("psn_t_prescription_eye")
            ->leftJoin("psn_t_prescription_dtl_vw b", "psn_t_prescription_eye.prescription_no_fk", "=", "b.prescription_no_fk")
            ->where("psn_t_prescription_eye.prescription_no_fk", $prescription_id)->first();


        $pat_pres_list_dtl = DB::table("psn_t_prescription_vw")->where("patient_no_fk", $patient_id)->orderBy("au_entry_at", "desc")->get();
        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {

                $pat_pres_list[$pat_pres->prescription_no_pk] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind . "_" . $pat_pres->patient_code;
            }
        }
        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)
            ->whereIn("lookupdata_uid", ['RAD', 'LAB', 'SERVICE'])->orderBy("lookupdata_uid", "asc")
            ->get();
        $ptet_ptte_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)
            ->whereIn("lookupdata_uid", ['PTET', 'PTTE', 'ACUP'])->orderBy("lookupdata_uid", "asc")
            ->get();

        $path_rad_invest = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {

                $path_rad_invest[$path_rad->lookupdata_uid][] = $path_rad->prescrition_data . "_" . $path_rad->report_no_fk;
            }
        }
        $ptet_ptte_item = [];
        if (!empty($ptet_ptte_arr)) {
            foreach ($ptet_ptte_arr as $ptet_ptte) {

                $ptet_ptte_item[$ptet_ptte->lookupdata_uid][] = $ptet_ptte->prescrition_data . "_" . $ptet_ptte->report_no_fk;
            }
        }
        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")->where("patient_no_fk", $patient_id)->whereIn("lookupdata_uid", ['RAD', 'LAB'])->get();
        $path_arr = $rad_arr = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {
                if ($path_rad->lookupdata_uid == "RAD") {
                    $rad_arr[] = $path_rad->prescrition_data;
                } else {
                    $path_arr[] = $path_rad->prescrition_data;
                }
            }
        }

        $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
            s.SERVICEUNIT_NO_PK
        FROM sysc_serviceunit s
            JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
        WHERE p.doctor_ind = 1 AND p.employee_ind = 1
            group by s.SERVICEUNIT_NAME,
            s.SERVICEUNIT_NO_PK
            order by 1 asc");

        //          $doctor_departments = DB::select("SELECT SERVICEUNIT_NAME, SERVICEUNIT_NO_PK
        // FROM sysc_serviceunit WHERE serviceunit_name IN ('PAEDIATRICS',
        //          'CARDIOLOGY',
        //          'GESTOLOGY',
        //          'MEDICINE',
        //          'NEUROLOGY',
        //          'NEPHROLOGY',
        //          'OPTHALMOLOGY',
        //          'SURGERY',
        //          'UROFLOWMETRY',
        //          'UROLOGY')");

        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $department_id = $su_info;
        $lmp = DB::table('PSN_T_PATVITALS')
            ->select(
                'lmp',
                'lmp_remarks',
                'obs',
                'married_for',
                'para',
                'edd',
                'edd_remarks',
                'gravida',
                'age_of_lastchild',
                'sfh',
                'fm',
                'fhs',
                'pr',
                'hq',
                'hypothyroidism',
                'brochial_asthma',
                'swelling',
                'scar_work',
                'tenderness',
                'pae_note',
                'alc',
                'menstrual_cycle',
                'mp',
                'mf',
                'dysmenorrhoea',
                'contraceptive_history',
                'drug_history',
                'surgical_history',
                'medical_history',
                'perineum_and_vulva',
                'cx',
                'vaginal_wall',
                'discharge',
                'uterus',
                'adnexa',
                'bme_note',
                'd_r_e',
                'breast_examination'
            )->where("prescription_no_fk", $prescription_id)->first();

        if (Session::get('user.ses_hospital_code') == 'IMPALA') {
            return Template::loadview("admin.prescription.prescription_details_doctor_wise_impala", ['refered_doc_name' => $refered_doc_name, 'left_side_arr' => $left_side_arr, 'pat_dtls_rs' => $pat_dtls_rs, 'pat_med_rs' => $pat_med_rs, "cc_arr" => $cc_arr, "ch_arr" => $ch_arr, "cd_arr" => $cd_arr, "pd_arr" => $pd_arr, "ds_arr" => $ds_arr, "icd_arr" => $icd_arr, "ad_arr" => $ad_arr, "refdoc_arr" => $refdoc_arr, "in_arr" => $in_arr, "pr_arr" => $pr_arr, 'instructions' => $instructions, 'dose' => $dose, 'duration' => $duration, 'meddurmu' => $meddurmu, "next_followup_dt" => $next_followup_dt, "refered_doc" => $refered_doc, "presc_note" => $presc_note, "continue_med_arr" => $continue_med_arr, 'followup_mu' => $followup_mu, 'inf_arr' => $inf_arr, 'dis_arr' => $dis_arr, 'path_rad_invest' => $path_rad_invest, 'lookup_id_arr' => $lookup_id_arr, 'followup_num' => $followup_num, 'followup_mu_name' => $followup_mu_name, 'template_name' => $template_name, "su_info" => $su_info, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, 'eye_ocular_arr' => $eye_ocular_arr, "ocular_exam_left_arr" => $ocular_exam_left_arr, "ocular_exam_right_arr" => $ocular_exam_right_arr, "pat_eye_rs" => $pat_eye_rs, 'pat_pres_list' => $pat_pres_list, 'route' => $route, 'ptet_arr' => $ptet_arr, 'acup_arr' => $acup_arr, 'ptte_arr' => $ptte_arr, 'duration_mu_phy' => $duration_mu_phy, 'ptet_ptte_item' => $ptet_ptte_item, 'department_id' => $department_id, 'path_arr' => $path_arr, 'lmp' => $lmp, 'find_arr' => $find_arr]);
        } else {
            return Template::loadview(
                "admin.prescription.prescription_details_doctor_wise",
                [
                    'refered_doc_name' => $refered_doc_name,
                    'left_side_arr' => $left_side_arr,
                    'pat_dtls_rs' => $pat_dtls_rs,
                    'pat_med_rs' => $pat_med_rs,
                    "phi_arr" => $phi_arr,
                    "treatment_his_arr" => $treatment_his_arr,
                    "cc_arr" => $cc_arr,
                    "ch_arr" => $ch_arr,
                    "cd_arr" => $cd_arr,
                    "pd_arr" => $pd_arr,
                    "ds_arr" => $ds_arr,
                    "icd_arr" => $icd_arr,
                    "ad_arr" => $ad_arr,
                    "refdoc_arr" => $refdoc_arr,
                    "in_arr" => $in_arr,
                    "pr_arr" => $pr_arr,
                    'instructions' => $instructions,
                    'dose' => $dose,
                    'duration' => $duration,
                    'meddurmu' => $meddurmu,
                    "next_followup_dt" => $next_followup_dt,
                    "refered_doc" => $refered_doc,
                    "presc_note" => $presc_note,
                    "continue_med_arr" => $continue_med_arr,
                    'followup_mu' => $followup_mu,
                    'inf_arr' => $inf_arr,
                    'dis_arr' => $dis_arr,
                    'path_rad_invest' => $path_rad_invest,
                    'lookup_id_arr' => $lookup_id_arr,
                    'followup_num' => $followup_num,
                    'followup_mu_name' => $followup_mu_name,
                    'template_name' => $template_name,
                    "su_info" => $su_info,
                    "dental_arr" => $dental_arr,
                    "selected_dental_arr" => $selected_dental_arr,
                    'eye_ocular_arr' => $eye_ocular_arr,
                    "ocular_exam_left_arr" => $ocular_exam_left_arr,
                    "ocular_exam_right_arr" => $ocular_exam_right_arr,
                    "pat_eye_rs" => $pat_eye_rs,
                    'pat_pres_list' => $pat_pres_list,
                    'route' => $route,
                    'ptet_arr' => $ptet_arr,
                    'acup_arr' => $acup_arr,
                    'ptte_arr' => $ptte_arr,
                    'duration_mu_phy' => $duration_mu_phy,
                    'ptet_ptte_item' => $ptet_ptte_item,
                    'department_id' => $department_id,
                    'path_arr' => $path_arr,
                    'lmp' => $lmp,
                    'intervention' => $intervention,
                    'doctor_departments' => $doctor_departments,
                    'find_arr' => $find_arr,
                    'dental_arr1' => $dental_arr1,
                    'bg' => $bg,
                    'bloodg' => $bloodg
                ]
            );
        }
    }

    // $duration_mu_phy

    public function getPrescriptionDtlsUHL($prescription_id, $patient_code, Request $request)
    {
        $doctor_id = Auth::id();
        $hdn_su_no = $request->hdn_su_no;
        $su_info = $this->ServiceUnit->findByColumn('serviceunit_no_pk', $hdn_su_no);
        $bg = DB::table('pat_registration_wl_vw')
            ->select('blood_group', 'blood_group_txt')
            ->where('patient_code', $patient_code)
            ->first();

        $bloodg = $this->getLookupListByCode('BLOODG');

        $pat_dtls_rs = DB::table("psn_t_prescription_vw a")
            ->leftJoin("psn_t_prescription_dtl_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
            ->where("a.prescription_no_pk", $prescription_id)
            ->get();
        $pat_ot = DB::table("psn_t_prescription_vw a")
            ->select('ref_reason', 'ref_clinic_no_fk', 'management_plan_note', 'ot_date_time', 'ot_advice', 'ipd_referred_advice', 'ipd_referred_date', 'global_hidden_note', 'investigation_findings_note')
            ->where("a.prescription_no_pk", $prescription_id)
            ->first();
        $ref_reason = $pat_ot->ref_reason ?? '';
        $ref_clinic_no_fk = $pat_ot->ref_clinic_no_fk ?? '';
        $management_plan_note = $pat_ot->management_plan_note ?? '';
        $ot_date_time = $pat_ot->ot_date_time ?? '';
        $ot_advice = $pat_ot->ot_advice ?? '';
        $ipd_referred_advice = $pat_ot->ipd_referred_advice ?? '';
        $ipd_referred_date = $pat_ot->ipd_referred_date ?? '';
        $global_hidden_note = $pat_ot->global_hidden_note ?? '';
        $investigation_findings_note = $pat_ot->investigation_findings_note ?? '';
        // dd($investigation_findings_note);

        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
                       WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK AND PRES_LOOKUP_CODE = 'DISPOSAL'");

        $treatment_his_arr = $phi_arr = $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $ptet_arr = $ptte_arr = $acup_arr = $find_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];
        $dental_arr1 = DB::table("psn_t_prescription")->select("dental_treatement")->where("prescription_no_pk", "=", $prescription_id)->first();

        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                $patient_id = $dtl_row->patient_no_fk;
                $next_followup_dt = $dtl_row->next_followup_dt;
                $followup_num = $dtl_row->followup_num;
                $followup_mu_name = $dtl_row->followup_mu;
                $template_name = $dtl_row->template_name;
                $refered_doc = $dtl_row->ref_doctor;
                $refered_doc_name = $dtl_row->ref_doc_name;
                $presc_note = $dtl_row->note;
                if ($dtl_row->lookup_uid == "HISTORY") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PASTHI") {
                    $phi_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "TREATMENTHISTORY") {
                    $treatment_his_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $find_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB" || $dtl_row->lookupdata_uid == "PKG" || $dtl_row->lookupdata_uid == "SERVICE") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookupdata_uid == "ACUP") {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : '';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : '';
                    $acup_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $e_location . '_' . $m_duration;
                }
                if ($dtl_row->lookupdata_uid == "PTET") {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : '';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : '';
                    $ptet_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $e_location . '_' . $m_duration;
                }
                if ($dtl_row->lookupdata_uid == "PTTE") {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $e_location = isset($dtl_row->e_location) ? $dtl_row->e_location : '';
                    $m_duration = isset($dtl_row->m_duration) ? $dtl_row->m_duration : '';
                    $ptte_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity
                        . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $m_repetition . '_' . $e_location . '_' . $m_duration;
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }

                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "DISPOSAL", "REFDOC", "PROCEDURE", "PASTHI", "TREATMENTHISTORY"]);
        // $continue_med_arr = DB::table('psn_t_prescription_med_vw')
        //     ->where('patient_no_fk', $patient_id)
        //     ->whereRaw('(continue_ind=1 or chronic_ind=1)')
        //     ->get();

        $pat_med_rs = DB::table('psn_t_prescription_vw a')
            ->leftJoin('psn_t_prescription_med_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->where('a.prescription_no_pk', $prescription_id)
            ->orderBy('prescription_med_no_pk', 'asc')
            ->get();
        // dd($pat_med_rs);
        $pat_eye_rs = DB::table('psn_t_prescription_eye')
            ->leftJoin('psn_t_prescription_dtl_vw b', 'psn_t_prescription_eye.prescription_no_fk', '=', 'b.prescription_no_fk')
            ->where('psn_t_prescription_eye.prescription_no_fk', $prescription_id)
            ->first();

        $pat_pres_list_dtl = DB::table('psn_t_prescription_vw')
            ->where('patient_no_fk', $patient_id)
            ->orderBy('au_entry_at', 'desc')
            ->get();
        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {

                $pat_pres_list[$pat_pres->prescription_no_pk] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind . "_" . $pat_pres->patient_code;
            }
        }
        $path_rad_arr = DB::table('psn_t_prescription_dtl_vw')
            ->where('patient_no_fk', $patient_id)
            ->whereIn('lookupdata_uid', ['RAD', 'LAB'])
            ->orderBy('lookupdata_uid', 'asc')
            ->get();

        $ptet_ptte_arr = DB::table('psn_t_prescription_dtl_vw')
            ->where('patient_no_fk', $patient_id)
            ->whereIn('lookupdata_uid', ['PTET', 'PTTE', 'ACUP'])
            ->orderBy('lookupdata_uid', 'asc')
            ->get();

        $path_rad_invest = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {

                $path_rad_invest[$path_rad->lookupdata_uid][] = $path_rad->prescrition_data . "_" . $path_rad->report_no_fk;
            }
        }
        $ptet_ptte_item = [];
        if (!empty($ptet_ptte_arr)) {
            foreach ($ptet_ptte_arr as $ptet_ptte) {

                $ptet_ptte_item[$ptet_ptte->lookupdata_uid][] = $ptet_ptte->prescrition_data . "_" . $ptet_ptte->report_no_fk;
            }
        }
        $path_rad_arr = DB::table('psn_t_prescription_dtl_vw')
            ->where('patient_no_fk', $patient_id)
            ->whereIn('lookupdata_uid', ['RAD', 'LAB'])
            ->get();
        $path_arr = $rad_arr = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {
                if ($path_rad->lookupdata_uid == "RAD") {
                    $rad_arr[] = $path_rad->prescrition_data;
                } else {
                    $path_arr[] = $path_rad->prescrition_data;
                }
            }
        }

        $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
        s.SERVICEUNIT_NO_PK
    FROM sysc_serviceunit s
        JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
    WHERE p.doctor_ind = 1 AND p.employee_ind = 1
        group by s.SERVICEUNIT_NAME,
        s.SERVICEUNIT_NO_PK
        order by 1 asc");

        //          $doctor_departments = DB::select("SELECT SERVICEUNIT_NAME, SERVICEUNIT_NO_PK
        // FROM sysc_serviceunit WHERE serviceunit_name IN ('PAEDIATRICS',
        //          'CARDIOLOGY',
        //          'GESTOLOGY',
        //          'MEDICINE',
        //          'NEUROLOGY',
        //          'NEPHROLOGY',
        //          'OPTHALMOLOGY',
        //          'SURGERY',
        //          'UROFLOWMETRY',
        //          'UROLOGY')");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        // $dental_arr = $selected_dental_arr = [];
        $department_id = $su_info;
        $lmp = DB::table('PSN_T_PATVITALS')
            ->select(
                'lmp',
                'lmp_remarks',
                'obs',
                'married_for',
                'para',
                'edd',
                'edd_remarks',
                'gravida',
                'age_of_lastchild',
                'sfh',
                'fm',
                'fhs',
                'pr',
                'hq',
                'hypothyroidism',
                'brochial_asthma',
                'swelling',
                'scar_work',
                'tenderness',
                'pae_note',
                'alc',
                'menstrual_cycle',
                'mp',
                'mf',
                'dysmenorrhoea',
                'contraceptive_history',
                'drug_history',
                'surgical_history',
                'perineum_and_vulva',
                'cx',
                'vaginal_wall',
                'discharge',
                'uterus',
                'adnexa',
                'bme_note',
                'd_r_e',
                'breast_examination',
                'past_history',
                'complaints_history',
                'family_history',
                'medical_history',
                'outcome_measurement'
            )
            ->where("prescription_no_fk", $prescription_id)
            ->first();
        // dd($lmp);
        return response()->json([
            'success' => true,
            'pat_med_rs' => $pat_med_rs,
            'dose' => $dose,
            'route' => $route,
            'duration' => $duration,
            'instructions' => $instructions,
            'meddurmu' => $meddurmu,
            'cc_arr' => $cc_arr,
            'ch_arr' => $ch_arr,
            'icd_arr' => $icd_arr,
            'lmp' => $lmp,
            'in_arr' => $in_arr,
            'inf_arr' => $inf_arr,
            'find_arr' => $find_arr,
            'ad_arr' => $ad_arr,
            'pr_arr' => $pr_arr,
            'acup_arr' => $acup_arr,
            'duration_mu_phy' => $duration_mu_phy,
            'ptet_arr' => $ptet_arr,
            'ref_reason' => $ref_reason,
            'ref_clinic_no_fk' => $ref_clinic_no_fk,
            'management_plan_note' => $management_plan_note,
            'ot_date_time' => $ot_date_time,
            'ot_advice' => $ot_advice,
            'ipd_referred_advice' => $ipd_referred_advice,
            'ipd_referred_date' => $ipd_referred_date,
            'global_hidden_note' => $global_hidden_note,
            'investigation_findings_note' => $investigation_findings_note,
            'ptte_arr' => $ptte_arr
        ], 200);
    }

    public function getPrescriptionDtls2($prescription_id, Request $request)
    {
        $hdn_su_no = $request->hdn_su_no;
        $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $hdn_su_no); // [];

        $pat_dtls_rs = DB::table('psn_t_prescription_vw a')
            ->leftJoin('psn_t_prescription_dtl_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->where('a.prescription_no_pk', $prescription_id)
            ->get();

        $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = $ptet_arr = $ptte_arr = $acup_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $patient_id = $followup_num = $followup_mu = $template_name = "";
        $ocular_exam_right_arr = $ocular_exam_left_arr = [];
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                $patient_id = $dtl_row->patient_no_fk;
                $next_followup_dt = $dtl_row->next_followup_dt;
                $followup_num = $dtl_row->followup_num;
                $followup_mu_name = $dtl_row->followup_mu;
                $template_name = $dtl_row->template_name;
                $refered_doc = $dtl_row->ref_doctor;
                $presc_note = $dtl_row->note;
                if ($dtl_row->lookup_uid == "HISTORY") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookupdata_uid == "ACUP") {
                    $acup_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookupdata_uid == "PTET") {
                    $ptet_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookupdata_uid == "PTTE") {
                    $ptte_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "TEETHFIND") {
                    $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                    $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }

                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookupdata_item_no_fk] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }
                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }
        // dd($ptet_arr,$ptte_arr);
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "DISPOSAL", "REFDOC"]);
        $physio_others = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSOTH")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val')->get();

        //$physio_others = DB::table('pres_lookupdata_vw')->where('pres_lookup_code',"PHYASSOTH")->select('pres_lookupdata_code as key','pres_lookupdata_name as val')->get();
        $physio_lifestyles = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSLIFESTYLE")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val', 'pres_lookupdata_no_pk as id')->get();

        //$physio_lifestyle = $this->getPresLookupListByCode("PHYASSLIFESTYLE");
        $physio_symptoms = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYASSSYMPT")->select('pres_lookupdata_code as key', 'pres_lookupdata_name as val', 'pres_lookupdata_no_pk as id')->orderBy('serial', "asc")->get();

        $physio_others_edit = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=', $prescription_id)->where('lookup_uid', 'PHYASSOTH')->get();

        $physio_lifestyles_edit = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=', $prescription_id)->where('lookup_uid', 'PHYASSLIFESTYLE')->get();
        $physio_symptoms_edit = DB::table('psn_t_prescription_physio_assm')->where('prescription_no_fk', '=', $prescription_id)->where('lookup_uid', 'PHYASSSYMPT')->get();

        $physio_erectile_edit = DB::table('erec_dysfunction_question')->where('prescription_no_fk', '=', $prescription_id)->first();

        //dd($physio_erectile_edit->problem_duration);

        $physio_present_sexual_function = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PRNTSEXFUN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_previous_evaluation = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PREVEVAL')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_previous_treatment = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PREVTREAT')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physio_risk_factors = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'RISKFACTERECTILEDYSFUN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $past_medical_history = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PASTMEDHIS')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $family_history = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'FAMILYHISTORY')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $physical_examination = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'PHYSICALEXAM')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_blood = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONBLOODTEST')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_urine = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONURINETEST')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_usg = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONUSG')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $investigation_xray_mri = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'INVESTIGATIONX-RAY/MRI')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $management_plan = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', 'MANAGEMENTPLAN')->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', "asc")->get();
        $ipss = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYIPSS")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();
        $iief = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYSHIM")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();
        $edit_ipss = DB::table('psn_t_physio_ipss')->where('prescription_no_fk', $prescription_id)->get();
        //dd($edit_ipss);
        $edit_iief = DB::table('psn_t_physio_shim')->where('prescription_no_fk', $prescription_id)->get();
        $edit_therapy_details = DB::table('patient_therapy_details')->where('prescription_no_fk', $prescription_id)->first();

        $continue_med_arr = DB::table('psn_t_prescription_med_vw')
            ->where('patient_no_fk', $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();

        $pat_med_rs = DB::table('psn_t_prescription_vw a')
            ->leftJoin('psn_t_prescription_med_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->where('a.prescription_no_pk', $prescription_id)
            ->get();

        $pat_eye_rs = [];

        $pat_pres_list_dtl = DB::table('psn_t_prescription_vw')
            ->where('patient_no_fk', $patient_id)
            ->orderBy('au_entry_at', 'desc')
            ->get();
        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {
                $pat_pres_list[$pat_pres->prescription_uid] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind;
            }
        }
        $path_rad_arr = DB::table('psn_t_prescription_dtl_vw')
            ->where('patient_no_fk', $patient_id)
            ->whereIn('lookupdata_uid', ['RAD', 'LAB', 'SERVICE'])
            ->orderBy('lookupdata_uid', 'asc')
            ->get();

        $ptet_ptte_arr = DB::table('psn_t_prescription_dtl_vw')
            ->where('patient_no_fk', $patient_id)
            ->whereIn('lookupdata_uid', ['PTET', 'PTTE', 'ACUP'])
            ->orderBy('lookupdata_uid', 'asc')
            ->get();

        $path_rad_invest = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {

                $path_rad_invest[$path_rad->lookupdata_uid][] = $path_rad->prescrition_data . "_" . $path_rad->report_no_fk;
            }
        }
        $ptet_ptte_item = [];
        if (!empty($ptet_ptte_arr)) {
            foreach ($ptet_ptte_arr as $ptet_ptte) {

                $ptet_ptte_item[$ptet_ptte->lookupdata_uid][] = $ptet_ptte->prescrition_data . "_" . $ptet_ptte->report_no_fk;
            }
        }

        $eye_ocular_arr = []; //$this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $department_id = $su_info;
        return Template::loadview(
            "admin.prescription.prescription_details_doctor_wise2",
            [
                'left_side_arr' => $left_side_arr,
                'pat_dtls_rs' => $pat_dtls_rs,
                'pat_med_rs' => $pat_med_rs,
                'edit_therapy_details' => $edit_therapy_details,
                'iief' => $iief,
                'edit_ipss' => $edit_ipss,
                'edit_iief' => $edit_iief,
                'ipss' => $ipss,
                'physio_others' => $physio_others,
                'physio_others_edit' => $physio_others_edit,
                'physio_lifestyles' => $physio_lifestyles,
                'physio_lifestyles_edit' => $physio_lifestyles_edit,
                'physio_erectile_edit' => $physio_erectile_edit,
                'physio_symptoms' => $physio_symptoms,
                'physio_symptoms_edit' => $physio_symptoms_edit,
                'physio_present_sexual_function' => $physio_present_sexual_function,
                'physio_previous_evaluation' => $physio_previous_evaluation,
                'physio_previous_treatment' => $physio_previous_treatment,
                'past_medical_history' => $past_medical_history,
                'physio_risk_factors' => $physio_risk_factors,
                'family_history' => $family_history,
                'physical_examination' => $physical_examination,
                'investigation_blood' => $investigation_blood,
                'investigation_urine' => $investigation_urine,
                'investigation_usg' => $investigation_usg,
                'investigation_xray_mri' => $investigation_xray_mri,
                'management_plan' => $management_plan,
                'cc_arr' => $cc_arr,
                'ch_arr' => $ch_arr,
                'cd_arr' => $cd_arr,
                'pd_arr' => $pd_arr,
                'ds_arr' => $ds_arr,
                'icd_arr' => $icd_arr,
                'ad_arr' => $ad_arr,
                'refdoc_arr' => $refdoc_arr,
                'in_arr' => $in_arr,
                'pr_arr' => $pr_arr,
                'instructions' => $instructions,
                'dose' => $dose,
                'duration' => $duration,
                'meddurmu' => $meddurmu,
                'next_followup_dt' => $next_followup_dt,
                'refered_doc' => $refered_doc,
                'presc_note' => $presc_note,
                'continue_med_arr' => $continue_med_arr,
                'followup_mu' => $followup_mu,
                'inf_arr' => $inf_arr,
                'dis_arr' => $dis_arr,
                'path_rad_invest' => $path_rad_invest,
                'lookup_id_arr' => $lookup_id_arr,
                'followup_num' => $followup_num,
                'followup_mu_name' => $followup_mu_name,
                'template_name' => $template_name,
                'su_info' => $su_info,
                'dental_arr' => $dental_arr,
                'selected_dental_arr' => $selected_dental_arr,
                'eye_ocular_arr' => $eye_ocular_arr,
                'ocular_exam_left_arr' => $ocular_exam_left_arr,
                'ocular_exam_right_arr' => $ocular_exam_right_arr,
                'pat_eye_rs' => $pat_eye_rs,
                'pat_pres_list' => $pat_pres_list,
                'route' => $route,
                'ptet_arr' => $ptet_arr,
                'acup_arr' => $acup_arr,
                'ptte_arr' => $ptte_arr,
                'duration_mu_phy' => $duration_mu_phy,
                'ptet_ptte_item' => $ptet_ptte_item,
                'department_id' => $department_id,
                'prescription_id' => $prescription_id
            ]
        );
    }

    public function storeAllergy(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        $allergydata = new Allergy();
        $allergydata->patient_no_fk = $request->patient_id;
        $allergydata->appoint_no_fk = $request->hdn_appointment_id;
        $allergydata->date_of_allergies = date("Y-m-d");
        $allergydata->identified_doctor_no_fk = $request->doctor_id;
        $allergydata->category_allergies = $request->cmb_type;
        $allergydata->allergies_name = $request->allergy_name;
        $allergydata->med_item_no_fk = $request->medicine_item_id;
        $allergydata->allergie_no_fk = $request->cmb_allergy;
        $allergydata->allergies_severity_lk_no_fk = $request->cmb_severity;
        $allergydata->allergies_severity_text = $request->severity_name;
        $allergydata->remarks = $request->txt_remarks;
        $allergydata->au_entry_by = $auth_id;
        $allergydata->au_entry_hospital_no_fk = $ses_hospital_id;
        $last_id = '';
        if ($allergydata->save()) {
            $last_id = $allergydata->pat_allergies_no_pk;
        }

        return response()->json(array('success' => true, 'last_insert_id' => $last_id), 200);
    }
    public function AllergyDataDelete(Request $request)
    {
        DB::table('emr_allergies')->where("pat_allergies_no_pk", $request->allergy_id)->delete();
    }
    public function storeChronicDisease(Request $request)
    {
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $chrndata_arr = [];
        $chrn_items = explode("*", $request->chrn_item_hdn_str);
        if (!empty($chrn_items)) {
            // ChronicDisease::where('patient_no_fk', $request->patient_id)->delete();

            ChronicDisease::where('appoint_no_fk', $request->hdn_appointment_id)
                ->where('patient_no_fk', $request->patient_id)
                ->delete();

            foreach ($chrn_items as $chrn_item) {
                $chrn_item_arr = explode("_", $chrn_item);
                if (isset($chrn_item_arr[1])) {
                    $sequence = DB::getSequence();
                    $chronic_dis_no_pk = $sequence->nextValue('emr_chronic_disease_seq');
                    $chrndata = new ChronicDisease();
                    $chrndata->chronic_dis_no_pk = $chronic_dis_no_pk;
                    $chrndata->patient_no_fk = $request->patient_id;
                    $chrndata->appoint_no_fk = $request->hdn_appointment_id;
                    $chrndata->date_of_chronic_disease = date("Y-m-d");
                    $chrndata->identified_doctor_no_fk = $request->doctor_id;
                    $chrndata->chronic_dis_name = $chrn_item_arr[1];
                    $chrndata->chronic_dis_description = $request->chrn_dtls;
                    $chrndata->chronic_dis_item_pk_no_fk = $chrn_item_arr[0];
                    $chrndata->status = 1;
                    $chrndata->au_entry_by = $auth_id;
                    $chrndata->au_entry_hospital_no_fk = $ses_hospital_id;
                    $chrndata_arr[] = $chrndata->attributesToArray();
                }
            }

            DB::table('emr_chronic_disease')->insert($chrndata_arr);
        }
    }
    public function getPrescriptionTemplates($doctor_id)
    {
        $templates_rs = DB::table("psn_s_template")
            ->where("doctor_no_fk", Session::get('user.ses_person_no_fk'))
            ->get();
        if (!empty($templates_rs)) {
            $dropdown_item = "";
            $i = 1;
            // foreach ($templates_rs as $templates) {
            //     $template_id = $templates->psn_template_no_pk;
            //     $dtls_route  = route('get-prescription-dtls-from-template');
            //     $dropdown_item .= '<span class="dropdown-item cursor-pointer border-bottom" data-template="' . $template_id . '" data-template-name="' . $templates->template_name . '" data-dtls-action="' . $dtls_route . '" onclick="prescriptionFunc.patientPrescriptionTemplateDetails(this)"><span class="btn btn-outline-primary btn-sm bg-none"><i class="fa fa-prescription"></i></span> ' . $templates->template_name . '</span>';
            //     $i++;
            // }
            foreach ($templates_rs as $template) {
                $template_id = $template->psn_template_no_pk;
                $remove_template = '';



                // Generate route for template details
                $dtls_route = route('get-prescription-dtls-from-template');
                $dlt_route = route('delete-prescription-template');
                // Check if the user can delete the template
                if ($template->au_entry_by == Session::get('user.ses_user_pk_no')) {
                    $remove_template = '<span class="cursor-pointer btn btn-outline-danger btn-sm" data-template="' . htmlspecialchars($template_id) . '"
                    data-template-name="' . htmlspecialchars($template->template_name) . '"
                    data-dtls-action="' . htmlspecialchars($dlt_route) . '"
                        onclick="prescriptionFunc.prescriptionTemplateDelete(this)">
                        <i class="fa fa-trash" style="font-size:11px;color:red"></i>
                    </span>';
                } else {
                    $remove_template = '<span class="btn btn-outline-danger btn-sm" style="opacity: 0.5; cursor: not-allowed;" onclick="prescriptionFunc.prescriptionTemplateDeleteAlert(this)">
                        <i class="fa fa-trash" style="font-size:11px;color:red"></i>
                    </span>';
                }

                // Construct the dropdown item HTML
                $dropdown_item .= '<span class="dropdown-item cursor-pointer border-bottom d-flex justify-content-between align-items-center "
                    data-template="' . htmlspecialchars($template_id) . '"
                    data-template-name="' . htmlspecialchars($template->template_name) . '"
                    data-dtls-action="' . htmlspecialchars($dtls_route) . '"
                    onclick="prescriptionFunc.patientPrescriptionTemplateDetails(this)">
                    <div class="d-flex align-items-center">
                        <span class="btn btn-outline-primary btn-sm bg-none mr-2">
                            <i class="fa fa-prescription"></i>
                        </span>
                        <span>' . htmlspecialchars($template->template_name) . '</span>
                    </div>
                    ' . $remove_template . '
                </span>';
            }
        }
        return $dropdown_item;
    }
    public function deletePrescriptionTemplate(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'template_id' => 'required|integer|exists:psn_s_template,psn_template_no_pk',
        ]);

        // Attempt to delete the template
        try {
            $deleteTemplate = DB::table('psn_s_template')
                ->where('psn_template_no_pk', $request->template_id)
                ->delete();
            DB::commit();

            // Check if the deletion was successful
            if ($deleteTemplate) {
                return response()->json(['message' => 'Template deleted successfully!'], 200);
            } else {
                return response()->json(['message' => 'Template not found or could not be deleted.'], 404);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getPrescriptionTemplatesUHL($doctor_id)
    {
        $templates_rs = DB::table("psn_s_template")
            ->where("doctor_no_fk", Session::get('user.ses_person_no_fk'))
            ->get();
        if (!empty($templates_rs)) {
            $dropdown_item = "";
            $i = 1;
            foreach ($templates_rs as $templates) {
                $template_id = $templates->psn_template_no_pk;
                $dtls_route = route('get-prescription-dtls-from-template-uhl');
                $dropdown_item .= '<span class="dropdown-item cursor-pointer border-bottom" data-template="' . $template_id . '" data-template-name="' . $templates->template_name . '" data-dtls-action="' . $dtls_route . '" onclick="prescriptionFunc.patientPrescriptionTemplateDetailsUHL(this)"><span class="btn btn-outline-primary btn-sm bg-none"><i class="fa fa-prescription"></i></span> ' . $templates->template_name . '</span>';
                $i++;
            }
        }
        return $dropdown_item;
    }


    public function presOpdSaveUpdateTemplate(Request $request)
    {
        return $this->prescriptionRepository->opdPresCreateOrUpdateTemplate($request);
    }
    public function getPrescriptionDtlsFromTemplate(Request $request)
    {
        $template_id = $request->template_id;
        $template_name = $request->template_name;
        $patient_id = $request->patient_id;
        $hdn_su_no = $request->hdn_su_no;
        //$su_info = $this->ServiceUnit->findByColumn("su_no_pk", $hdn_su_no);

        $pat_dtls_rs = DB::table("psn_s_template a")
            // ->select("b.lookup_uid", "b.lookupdata_item_no_fk", "b.prescrition_data", "c.psn_lookup_no_pk", "b.lookupdata_uid")
            ->leftJoin("psn_s_template_dtl b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            ->leftJoin("psn_s_lookup c", "b.lookup_uid", "=", "c.psn_lookup_uid")
            ->where("a.psn_template_no_pk", $template_id)->get();

        $treatment_his_arr = $cc_arr = $phi_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $acup_arr = $ptet_arr = $ptte_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $followup_num = $followup_mu = $template_name = $followup_mu_name = "";

        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "TREATMENTHISTORY") {
                    $treatment_his_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PASTHI") {
                    $phi_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                    // $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }

                if ($dtl_row->lookupdata_uid == "ACUP") {
                    $acup_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookupdata_uid == "PTET") {
                    $ptet_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookupdata_uid == "PTTE") {
                    $ptte_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }

                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $pat_med_rs = DB::table("psn_s_template a")
            ->leftJoin("psn_s_template_med b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            ->where("a.psn_template_no_pk", $template_id)
            ->get();

        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "DISPOSAL", "REFDOC", "PASTHI", "TREATMENTHISTORY"]);

        $continue_med_arr = DB::table("psn_t_prescription_med_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();

        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereIn("lookup_uid", ['RAD', 'LAB'])
            ->get();
        $path_arr = $rad_arr = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {
                if ($path_rad->lookup_uid == "RAD") {
                    $rad_arr[] = $path_rad->prescrition_data;
                } else {
                    $path_arr[] = $path_rad->prescrition_data;
                }
            }
        }
        $bloodg = $this->getLookupListByCode("BLOODG");
        return Template::loadview(
            "admin.prescription.prescription_details_doctor_wise",
            [
                'pat_dtls_rs' => $pat_dtls_rs,
                'pat_med_rs' => $pat_med_rs,
                'treatment_his_arr' => $treatment_his_arr,
                'cc_arr' => $cc_arr,
                'ch_arr' => $ch_arr,
                'cd_arr' => $cd_arr,
                'icd_arr' => $icd_arr,
                'pd_arr' => $pd_arr,
                'ds_arr' => $ds_arr,
                'ad_arr' => $ad_arr,
                'refdoc_arr' => $refdoc_arr,
                'in_arr' => $in_arr,
                'pr_arr' => $pr_arr,
                'phi_arr' => $phi_arr,
                'instructions' => $instructions,
                'dose' => $dose,
                'duration' => $duration,
                'meddurmu' => $meddurmu,
                'followup_mu' => $followup_mu,
                'inf_arr' => $inf_arr,
                'dis_arr' => $dis_arr,
                'rad_arr' => $rad_arr,
                'path_arr' => $path_arr,
                'continue_med_arr' => $continue_med_arr,
                'lookup_id_arr' => $lookup_id_arr,
                'template_name' => $template_name,
                'followup_num' => $followup_num,
                'followup_mu_name' => $followup_mu_name,
                'route' => $route,
                'ptet_arr' => $ptet_arr,
                'acup_arr' => $acup_arr,
                'ptte_arr' => $ptte_arr,
                'duration_mu_phy' => $duration_mu_phy,
                'department_id' => $hdn_su_no,
                'bloodg' => $bloodg
            ]
        );
    }


    public function getPrescriptionDtlsFromTemplateUHL(Request $request)
    {
        $template_id = $request->template_id;
        $template_name = $request->template_name;
        $patient_id = $request->patient_id;
        $hdn_su_no = $request->hdn_su_no;

        $pat_dtls_rs = DB::table("psn_s_template a")
            // ->select("b.lookup_uid", "b.lookupdata_item_no_fk", "b.prescrition_data", "c.psn_lookup_no_pk", "b.lookupdata_uid")
            ->leftJoin("psn_s_template_dtl b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            ->leftJoin("psn_s_lookup c", "b.lookup_uid", "=", "c.psn_lookup_uid")
            ->where("a.psn_template_no_pk", $template_id)->get();


        $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $acup_arr = $ptet_arr = $ptte_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $followup_num = $followup_mu = $template_name = $followup_mu_name = "";

        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "DISEASE") {
                    $ds_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "ICD") {
                    $icd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }

                if ($dtl_row->lookup_uid == "ADVICE") {
                    $ad_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "RAD" || $dtl_row->lookup_uid == "LAB") {
                    // $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "INVFIND") {
                    if ($dtl_row->lookupdata_uid == "RAD" || $dtl_row->lookupdata_uid == "LAB") {
                        $in_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    } else {
                        $inf_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                    }
                }

                if ($dtl_row->lookupdata_uid == "ACUP") {
                    $acup_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookupdata_uid == "PTET") {
                    $ptet_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }
                if ($dtl_row->lookupdata_uid == "PTTE") {
                    $ptte_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid . "_" . $dtl_row->session_duration . "_" . $dtl_row->session_mu . "_" . $dtl_row->no_of_session . "_" . $dtl_row->unit_intensity;
                }

                if ($dtl_row->lookup_uid == "DISPOSAL") {
                    $dis_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "SERVICE" || $dtl_row->lookup_uid == "SUR" || $dtl_row->lookup_uid == "PROCEDURE") {
                    $pr_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "REFDOC") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $refdoc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }

        $pat_med_rs = DB::table("psn_s_template a")
            ->leftJoin("psn_s_template_med b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            ->where("a.psn_template_no_pk", $template_id)->get();

        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD", "DISPOSAL", "REFDOC", "PASTHI", "TREATMENTHISTORY"]);

        $continue_med_arr = DB::table("psn_t_prescription_med_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();

        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereIn("lookup_uid", ['RAD', 'LAB'])
            ->get();

        $path_arr = $rad_arr = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {
                if ($path_rad->lookup_uid == "RAD") {
                    $rad_arr[] = $path_rad->prescrition_data;
                } else {
                    $path_arr[] = $path_rad->prescrition_data;
                }
            }
        }

        // 'find_arr' => $find_arr, 'lmp' => $lmp,
        return response()->json([
            'success' => true,
            'pat_med_rs' => $pat_med_rs,
            'dose' => $dose,
            'route' => $route,
            'duration' => $duration,
            'instructions' => $instructions,
            'meddurmu' => $meddurmu,
            'cc_arr' => $cc_arr,
            'ch_arr' => $ch_arr,
            'icd_arr' => $icd_arr,
            'in_arr' => $in_arr,
            'inf_arr' => $inf_arr,
            'ad_arr' => $ad_arr,
            'pr_arr' => $pr_arr,
            'acup_arr' => $acup_arr,
            'duration_mu_phy' => $duration_mu_phy,
            'ptet_arr' => $ptet_arr,
            'ptte_arr' => $ptte_arr
        ], 200);
    }

    public function removeFromPresFavouritList(Request $request)
    {
        $favourit_id = $request->favourit_id;
        $favourit_type = $request->favourit_type;
        $this->favouritmodel->delete($favourit_id);

        $favourit_data = $this->preFavouritList($favourit_type);
        if (Session::get('user.ses_hospital_code') != 'UNICO') {
            return Template::loadview("admin.components.pres_favourit_list", ['favourit_data' => $favourit_data]);
        } else {
            return Template::loadview("admin.prescription.uhl.pres_favourit_list", ['favourit_data' => $favourit_data]);
        }
    }
    public function printSpecticlesPrescriptionPdf($prescription_id = "")
    {
        $prescription_mst = DB::table('psn_t_prescription_vw a')
            ->leftJoin("patn_appointment_vw b", "a.appoint_no_fk", "=", "b.appoint_no_pk")
            ->leftJoin("sysc_serviceunit c", "a.su_no_fk", "=", "c.serviceunit_no_pk")
            ->where('a.prescription_no_pk', '=', $prescription_id)
            ->first();

        $prescription_eye = DB::table('psn_t_prescription_eye')
            ->where('prescription_no_fk', '=', $prescription_id)
            ->first();
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->service_number);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        // $pdf = PDF::loadView("admin.prescription.prescription_specticles_print_pdf", ['prescription_mst' => $prescription_mst, "patient_barcode" => $patient_barcode, "prescription_barcode" => $prescription_barcode, "prescription_eye" => $prescription_eye]);
        // return $pdf->stream("Prescription-$prescription_id.pdf");

        return view(
            "admin.prescription.prescription_specticles_print_pdf",
            [
                'prescription_mst' => $prescription_mst,
                'patient_barcode' => $patient_barcode,
                'prescription_barcode' => $prescription_barcode,
                'prescription_eye' => $prescription_eye
            ]
        );
    }
    public function loadPresFavouritListForWebPortal(Request $request)
    {
        $favourit_data = $this->preFavouritList($request->item_type);

        return Template::loadview("admin.components.pres_favourit_list", ['favourit_data' => $favourit_data]);
    }
    public function getPrevPrescriptionDtlsWebPortal($patient_id, Request $request)
    {
        $hdn_su_no = $request->hdn_su_no;
        $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $hdn_su_no); // [];
        $followup_num = $followup_mu_name = $template_name = "";
        $continue_med_arr = DB::table("psn_t_prescription_med_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereRaw('(continue_ind=1 or chronic_ind=1)')
            ->get();

        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "FINDINGS", "ICD"]);

        $pat_pres_list_dtl = DB::table("psn_t_prescription_vw")
            ->where("patient_no_fk", $patient_id)
            ->orderBy("au_entry_at", "desc")
            ->get();

        $pat_pres_list = [];
        if (!empty($pat_pres_list_dtl)) {
            foreach ($pat_pres_list_dtl as $pat_pres) {

                $pat_pres_list[$pat_pres->prescription_uid] = $pat_pres->au_entry_at . "_" . $pat_pres->appoint_no_fk . "_" . $pat_pres->patient_no_fk . "_" . $pat_pres->dental_ind . "_" . $pat_pres->eye_ind;
            }
        }

        $path_rad_arr = DB::table("psn_t_prescription_dtl_vw")
            ->where("patient_no_fk", $patient_id)
            ->whereIn("lookup_uid", ['RAD', 'LAB'])
            ->orderBy("lookup_uid", "asc")
            ->get();
        $path_rad_invest = [];
        if (!empty($path_rad_arr)) {
            foreach ($path_rad_arr as $path_rad) {
                $path_rad_invest[$path_rad->lookup_uid][] = $path_rad->prescrition_data . "_" . $path_rad->report_no_fk;
            }
        }
        $chief_com = DB::table("patn_appointment_vw")
            ->select('chif_complain')
            ->where("appoint_no_pk", $request->hdn_appointment_id)
            ->first();

        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $left_side_arr = $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = $dental_arr = $selected_dental_arr = [];
        $pat_dtls_rs = DB::table("psn_t_prescription_dtl_vw a")
            ->where("a.appointment_pk_no", $request->hdn_appointment_id)->get();
        if (!empty($pat_dtls_rs)) {
            foreach ($pat_dtls_rs as $dtl_row) {
                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->lookupdata_item_no_fk . '-' . $dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }

                if ($dtl_row->lookup_uid == "CHIEFCOM") {
                    $cc_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CLINICHIST") {
                    $ch_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "CHRDISEASE") {
                    $cd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "PROVDIAG") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
                if ($dtl_row->lookup_uid == "FINDINGS") {
                    $pd_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_item_no_fk . "_" . $dtl_row->prescrition_data . "_" . $dtl_row->psn_lookup_no_pk . "_" . $dtl_row->lookupdata_uid;
                }
            }
        }
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["PTTE", "PTET"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }
        return Template::loadview(
            "iCure-Home.admin.doctor.prescription.prescription_details",
            [
                'left_side_arr' => $left_side_arr,
                'cc_arr' => $cc_arr,
                'ch_arr' => $ch_arr,
                'cd_arr' => $cd_arr,
                'pd_arr' => $pd_arr,
                'instructions' => $instructions,
                'dose' => $dose,
                'duration' => $duration,
                'meddurmu' => $meddurmu,
                'continue_med_arr' => $continue_med_arr,
                'followup_mu' => $followup_mu,
                'followup_num' => $followup_num,
                'lookup_id_arr' => $lookup_id_arr,
                'followup_mu_name' => $followup_mu_name,
                'template_name' => $template_name,
                'path_rad_invest' => $path_rad_invest,
                'su_info' => $su_info,
                'eye_ocular_arr' => $eye_ocular_arr,
                'dental_arr' => $dental_arr,
                'selected_dental_arr' => $selected_dental_arr,
                'pat_pres_list' => $pat_pres_list,
                'route' => $route,
                'chief_com' => $chief_com,
                'duration_mu_phy' => $duration_mu_phy,
                'tr_lk_id_arr' => $tr_lk_id_arr
            ]
        );
    }

    public function getPatientInfo(Request $request)
    {
        $patient_id = $request->patient_id;
        $patient_info = $this->getPatientDetails($patient_id);
        return response()->json([
            'patient_info' => $patient_info,
        ]);
    }


    public function getProstateSymptomForm()
    {
        $ipss = DB::table('pres_lookupdata_vw')->where('pres_lookup_code', "PHYIPSS")->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial', 'ASC')->get();
        return Template::loadview("admin.prescription.international_prostate_symptom_score_form", compact('ipss'));
    }
    // public function storeProstateSymptom(Request $request)
    // {
    //      $id = $request->id;
    //     // dd($request->all());
    //     $total_ipss_score = $request->total_ipss_score;
    //     $urinary_symtom_ind = $request->urinary_symptom_ind;
    //     $patient_no_fk = $request->hdn_patient_id ? $request->hdn_patient_id : $request->hdn_patient_id_edit;
    //     $patient_name = $request->patient_name;
    //     $patient = DB::table('patn_registration')->where('patient_no_pk',$patient_no_fk)->select('dob')->first();//->select('')
    //     $dob = $patient->dob != "" ? date("Y-m-d", strtotime($patient->dob)) : '';
    //     $doc = $request->doc != "" ? date("Y-m-d", strtotime($request->doc)) : '';
    //     $psn_t_physio_ipss = DB::table("psn_t_physio_ipss")->latest('physio_ipss_no_pk')->select('physio_ipss_visit_no_nuq')->first();
    //     $visit_number = $psn_t_physio_ipss ? $psn_t_physio_ipss->physio_ipss_visit_no_nuq : null;
    //     if($visit_number)
    //     {
    //         $visit_number  += 1;
    //     }
    //     else
    //     {
    //         $visit_number = 1;
    //     }
    //     //dd($visit_number);
    //     $ipss = [];
    //     if(isset($request->row1))
    //     {
    //     $ipss [] = $request->row1;
    //      }
    //     if(isset($request->row2))
    //     {
    //     $ipss [] = $request->row2;

    //     }
    //     if(isset($request->row3))
    //     {
    //     $ipss [] = $request->row3;

    //     }
    //     if(isset($request->row4))
    //     {
    //     $ipss [] = $request->row4;

    //     }
    //     if(isset($request->row5))
    //     {
    //     $ipss [] = $request->row5;

    //     }
    //     if(isset($request->row6))
    //     {
    //     $ipss [] = $request->row6;

    //     }
    //     if(isset($request->row7))
    //     {
    //     $ipss [] = $request->row7;

    //     }
    //     // $ipss [] = $request->row1;
    //     // $ipss [] = $request->row2;

    //     // $ipss [] = $request->row3;

    //     // $ipss [] = $request->row4;

    //     // $ipss [] = $request->row5;

    //     // $ipss [] = $request->row6;

    //     // $ipss [] = $request->row7;
    //     //dd($ipss);
    //     DB::beginTransaction();
    //     try {
    //         if(isset($ipss))
    //         {
    //             foreach($ipss as $row)
    //             {
    //                 $explode_row = explode("~", $row);
    //                 $score = $explode_row[0];
    //                 $pres_lookupdata_name = $explode_row[1];
    //                 $pres_lookupdata_no_pk = $explode_row[2];
    //                 $pres_lookupdata_code = $explode_row[3];
    //                 $sequence = DB::getSequence();
    //                 $physio_ipss_no_pk_seq = $sequence->nextValue('physio_ipss_no_pk_seq');
    //                 $ipss_record = [];
    //                 $auth_id = Auth::id();
    //                 $ipss_record = [
    //                     'physio_ipss_no_pk' => $physio_ipss_no_pk_seq,
    //                     'physio_ipss_code' => $pres_lookupdata_code,
    //                     'lookupdata_no_fk' => $pres_lookupdata_no_pk,
    //                     'lookupdata_name' => $pres_lookupdata_name,
    //                     'patient_no_fk' => $patient_no_fk,
    //                     'patient_name' => $patient_name,
    //                     'total_ipss_score' => $total_ipss_score,
    //                     'dob' => $dob,
    //                     'date_completed' => $doc,
    //                     'physio_ipss_visit_no_nuq' => $visit_number,
    //                 // 'not_at_all_score' => 0,
    //                     // 'less_than_1_to_5_tiems_scr' => ,
    //                     // 'less_than_half_time_score',
    //                     // 'about_half_time_score',
    //                     // 'more_than_half_time_scr',
    //                     // 'almost_always_score',
    //                     'urinary_symptoms_ind' => $urinary_symtom_ind,
    //                     'au_entry_at' => date('Y-m-d'),
    //                     'au_entry_by' => $auth_id,
    //                     'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
    //                     'au_entry_session' => 'hospital',
    //                 ];
    //                 if($score == '0')
    //                 {
    //                     $ipss_record ['not_at_all_score'] = 0;
    //                 }
    //                 elseif($score == '1')
    //                 {
    //                     $ipss_record ['less_than_1_to_5_tiems_scr'] = 1;

    //                 }
    //                 elseif($score == '2')
    //                 {
    //                     $ipss_record ['less_than_half_time_score'] = 2;

    //                 }
    //                 elseif($score == '3')
    //                 {
    //                     $ipss_record ['about_half_time_score'] = 3;

    //                 }
    //                 elseif($score == '4')
    //                 {
    //                     $ipss_record ['more_than_half_time_scr'] = 4;

    //                 }
    //                 else
    //                 {
    //                     if($score == '5')
    //                     {
    //                     $ipss_record ['almost_always_score'] = 5;
    //                     }
    //                     else
    //                     {
    //                     $ipss_record ['almost_always_score'] = '';
    //                     }

    //                 }
    //                 // if($id==null)
    //                 // {
    //                    // $ipss_record['au_entry_by']= $auth_id;
    //                     $this->ipssmodel->insert($ipss_record);
    //                 // }
    //                 // else
    //                 // {
    //                 //     $ipss_record['au_update_by'] = $auth_id;
    //                 //     DB::table('psn_t_physio_ipss')->where('physio_ipss_visit_no_nuq',$id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update($ipss_record);
    //                 // }
    //                // $this->ipssmodel->insert($ipss_record);

    //             }
    //         }
    //     DB::commit();
    //     $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
    //  } catch (\Exception $e) {
    //     DB::rollback();
    //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
    // }

    //return response()->json($message);


    // }
    public function getProstateSymptomPage()
    {
        return Template::loadview("admin.prescription.international_prostate_symptom_list");
    }
    public function getProstateSymptomedit($id)
    {
        $ipss = DB::table('pres_lookupdata_vw')
            ->where('pres_lookup_code', "PHYIPSS")
            ->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')
            ->orderBy('serial', 'ASC')
            ->get();
        $edit_ipss = DB::table('psn_t_physio_ipss')
            ->where('physio_ipss_visit_no_nuq', $id)
            ->get();
        return Template::loadview("admin.prescription.internation_prostate_symptom_score_edit_form", compact('ipss', 'edit_ipss', 'id'));
    }
    public function getProstateSymptomList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'psn_t_physio_ipss_sum';
        $primarykey = 'physio_ipss_visit_no_nuq';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob', 'dt' => 3),
            array('db' => 'date_completed', 'dt' => 4),
            array('db' => 'urinary_symptoms_ind', 'dt' => 5),
            array('db' => 'total_ipss_score', 'dt' => 6),
            array('db' => 'physio_ipss_visit_no_nuq', 'dt' => 7)

            // array('db' => 'ccm_client_email', 'dt' => 7),
            // array('db' => 'is_emp_health_checking_ind', 'dt' => 8),
            // array('db' => 'is_proosal_approval_ind', 'dt' => 9),
            // array('db' => 'is_post_bill_ind', 'dt' => 10),
            // array('db' => 'status', 'dt' => 11),
            // array('db' => 'ccm_client_no_pk', 'dt' => 12),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primarykey, $columns));
        }
    }
    // public function getIIEF_5_questionnaireForm()
    // {
    //     $iief = DB::table('pres_lookupdata_vw')->where('pres_lookup_code',"PHYSHIM")->select('pres_lookupdata_code','pres_lookupdata_name', 'pres_lookupdata_no_pk')->orderBy('serial','ASC')->get();
    //     return Template::loadview("admin.prescription.IIEF-5_questionnaire_form", compact('iief'));
    // }
    // public function storeIIEF_5_questionnaire(Request $request)
    // {

    //         //dd($request->all());
    //         $total_shim_score = $request->total_shim_score;
    //         //$urinary_symtom_ind = $request->urinary_symptom_ind;
    //         $patient_no_fk = $request->hdn_patient_id ? $request->hdn_patient_id : $request->hdn_patient_id_edit;
    //         $patient = DB::table('patn_registration')->where('patient_no_pk',$patient_no_fk)->select('dob')->first();//->select('')
    //         $dob = $patient->dob != "" ? date("Y-m-d", strtotime($patient->dob)) : '';
    //         $patient_name = $request->patient_name;
    //        // $dob = $request->dob != "" ? date("Y-m-d", strtotime($request->dob)) : '';
    //         $doc = $request->doc != "" ? date("Y-m-d", strtotime($request->doc)) : '';
    //         $psn_t_physio_shim = DB::table("psn_t_physio_shim")->latest('physio_shim_no_pk')->select('physio_shim_visit_no_nuq')->first();
    //        // dd($visit_number);
    //        $visit_number = $psn_t_physio_shim ? $psn_t_physio_shim->physio_shim_visit_no_nuq : null;
    //        if($visit_number)
    //        {
    //            $visit_number  += 1;
    //        }
    //        else
    //        {
    //            $visit_number = 1;
    //        }



    //         $shim = [];
    //         if(isset($request->row1))
    //         {
    //         $shim [] = $request->row1;
    //          }
    //         if(isset($request->row2))
    //         {
    //         $shim [] = $request->row2;

    //         }
    //         if(isset($request->row3))
    //         {
    //         $shim [] = $request->row3;

    //         }
    //         if(isset($request->row4))
    //         {
    //         $shim [] = $request->row4;

    //         }
    //         if(isset($request->row5))
    //         {
    //         $shim [] = $request->row5;

    //         }

    //         DB::beginTransaction();
    //         try {
    //             if(isset($shim))
    //             {
    //                 foreach($shim as $row)
    //                 {
    //                     $explode_row = explode("~", $row);
    //                     $score = $explode_row[0];
    //                     $pres_lookupdata_name = $explode_row[1];
    //                     $pres_lookupdata_no_pk = $explode_row[2];
    //                     $pres_lookupdata_code = $explode_row[3];
    //                     $sequence = DB::getSequence();
    //                     $physio_shim_no_pk_seq = $sequence->nextValue('physio_shim_no_pk_seq');
    //                     $shim_record = [];
    //                     $auth_id = Auth::id();
    //                     $shim_record = [
    //                         'physio_shim_no_pk' => $physio_shim_no_pk_seq,
    //                         'physio_shim_code' => $pres_lookupdata_code,
    //                         'lookupdata_no_fk' => $pres_lookupdata_no_pk,
    //                         'lookupdata_name' => $pres_lookupdata_name,
    //                         'patient_no_fk' => $patient_no_fk,
    //                         'patient_name' => $patient_name,
    //                         'total_shim_score' => $total_shim_score,
    //                         'dob' => $dob,
    //                         'date_completed' => $doc,
    //                         'physio_shim_visit_no_nuq' => $visit_number,
    //                     // 'not_at_all_score' => 0,
    //                         // 'less_than_1_to_5_tiems_scr' => ,
    //                         // 'less_than_half_time_score',
    //                         // 'about_half_time_score',
    //                         // 'more_than_half_time_scr',
    //                         // 'almost_always_score',
    //                         //'urinary_symptoms_ind' => $urinary_symtom_ind,
    //                         'au_entry_at' => date('Y-m-d'),
    //                         'au_entry_by' => $auth_id,
    //                         'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
    //                         'au_entry_session' => 'hospital',
    //                     ];
    //                     if($score == '1')
    //                     {
    //                         $shim_record ['very_low_ind'] = 1;
    //                     }
    //                     elseif($score == '2')
    //                     {
    //                         $shim_record ['low_ind'] = 2;

    //                     }
    //                     elseif($score == '3')
    //                     {
    //                         $shim_record ['moderate_ind'] = 3;

    //                     }
    //                     elseif($score == '4')
    //                     {
    //                         $shim_record ['high_ind'] = 4;

    //                     }
    //                     else
    //                     {
    //                         if($score == '5')
    //                         {
    //                         $shim_record ['very_high_ind'] = 5;
    //                         }
    //                         else
    //                         {
    //                         $shim_record ['very_high_ind'] = '';
    //                         }

    //                     }
    //                     $this->iiefmodel->insert($shim_record);

    //                 }
    //             }
    //         DB::commit();
    //         $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
    //      } catch (\Exception $e) {
    //         DB::rollback();
    //         $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
    //     }
    //    return response()->json($message);

    // }
    public function getIIEFPage()
    {
        return Template::loadview("admin.prescription.IIEF-5_questionnaire_list");
    }

    public function getIIEFEdit($id)
    {
        $iief = DB::table('pres_lookupdata_vw')
            ->where('pres_lookup_code', "PHYSHIM")
            ->select('pres_lookupdata_code', 'pres_lookupdata_name', 'pres_lookupdata_no_pk')
            ->orderBy('serial', 'ASC')
            ->get();
        $edit_iief = DB::table('psn_t_physio_shim')->where('physio_shim_visit_no_nuq', $id)->get();

        return Template::loadview("admin.prescription.IIEF-5_questionnaire_edit", compact('iief', 'edit_iief', 'id'));
    }

    public function getIIEFList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'psn_t_physio_shim_sum';
        $primarykey = 'physio_shim_visit_no_nuq';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob', 'dt' => 3),
            array('db' => 'date_completed', 'dt' => 4),
            // array('db' => 'urinary_symptoms_ind', 'dt' => 4),
            array('db' => 'total_shim_score', 'dt' => 5),
            array('db' => 'physio_shim_visit_no_nuq', 'dt' => 6),

            // array('db' => 'ccm_client_email', 'dt' => 7),
            // array('db' => 'is_emp_health_checking_ind', 'dt' => 8),
            // array('db' => 'is_proosal_approval_ind', 'dt' => 9),
            // array('db' => 'is_post_bill_ind', 'dt' => 10),
            // array('db' => 'status', 'dt' => 11),
            // array('db' => 'ccm_client_no_pk', 'dt' => 12),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primarykey, $columns));
        }
    }

    public function getTherapyDetailsPage()
    {
        return Template::loadview("admin.prescription.therapy_details_list");
    }
    public function getTherapyList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'patient_therapy_details_vw';
        $primarykey = 'patient_therapy_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'therapy_date', 'dt' => 3),
            array('db' => 'therapy_date', 'dt' => 4),
            array('db' => 'therapy_day_no', 'dt' => 5),
            array('db' => 'therapy_dosage', 'dt' => 6),
            // array('db' => 'rownum', 'dt' => 7),

        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primarykey, $columns));
        }
    }
    public function test()
    {
        $dt = new \DateTime('now', new \DateTimezone('Asia/Dhaka'));
        echo $dt->format('Y-m-d H:i');
    }
    public function addMultidose(Request $request)
    {
        $pat_med_rs = [];
        $med_dt = [];
        if ($request->pres_id != null) {
            $pat_med_rs = DB::table("psn_t_prescription_vw a")
                ->leftJoin("psn_t_prescription_med_vw b", "a.prescription_no_pk", "=", "b.prescription_no_fk")
                ->where("a.prescription_no_pk", $request->pres_id)
                ->where('b.ITEM_NO_FK', $request->item_id)
                ->first();

            $med_dt = explode(',', $pat_med_rs->multidose_txt);
        }
        $route = $request->data_route;
        $data_row_id = $request->data_row_id;
        $duration_mu = $this->getPresLookupListByCode("DURMU");
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $item_dt = DB::table('phr_serviceitem_vw')->select('item_name', 'supplier_name', 'route_name', 'item_no_pk')->where('item_no_pk', $request->item_id)->first();


        return Template::loadview("admin.prescription.multidose", [
            'duration' => $duration_mu,
            'instructions' => $instructions,
            'dose' => $dose,
            'route' => $route,
            'meddurmu' => $meddurmu,
            'item_dt' => $item_dt,
            'data_row_id' => $data_row_id,
            'pat_med_rs' => $pat_med_rs,
            'med_dt' => $med_dt,
        ]);
    }

    public function altMedicine(Request $request)
    {
        $gen_name = DB::table('sysc_serviceitem')
            ->select('generic_no_fk')
            ->where('item_no_pk', $request->item_id)
            ->first();
        $item_list = DB::table('sysc_serviceitem_vw')
            ->select('item_no_pk', 'item_name', 'supplier_name')
            ->where('sysc_serviceitem_vw.generic_no_fk', $gen_name->generic_no_fk)
            ->get();

        $data_row_id = $request->data_row_id;
        $gen = $gen_name->generic_no_fk;
        return Template::loadview("admin.prescription.alternative_madicine", [
            'item_list' => $item_list,
            'data_row_id' => $data_row_id,
            'genetic_name' => $gen
        ]);
    }

    public function presAddNewRoute(Request $request)
    {
        $new_route = $request->new_route;
        if (isset($new_route)) {
        }
    }

    //add new Chronic Deasese
    public function createNewChronicDeasese()
    {
        return Template::loadview("admin.prescription.chronic.add_new_chronic_deases");
    }

    public function StoreNewChronicDeasease(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $sequence = DB::getSequence();
        $pres_lookupdata_seq = $sequence->nextValue('pres_lookupdata_seq');
        $serial = DB::select("SELECT MAX (serial) AS sl , DT.PRES_LOOKUP_NO_FK pres_lookup_no_fk
            FROM    PRES_LOOKUP look
                 JOIN
                    pres_lookupdata dt
                 ON DT.PRES_LOOKUP_NO_FK = LOOK.PRES_LOOKUP_NO_PK
           WHERE pres_lookup_code = 'CHRONDIS' group by DT.PRES_LOOKUP_NO_FK");
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'pres_lookupdata_code' => strtoupper($request->deasese_name),
                'pres_lookupdata_name' => $request->deasese_name,
                'pres_lookup_no_fk' => $serial[0]->pres_lookup_no_fk,
                'serial' => $serial[0]->sl + 1,
                'status' => 1,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'doctor_person_no_fk' => $auth_id,
                'pres_lookupdata_no_pk' => $pres_lookupdata_seq,
            ];

            //dd($data);
            DB::table('pres_lookupdata')->insert($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }


    public function presFavoriteWorklist()
    {
        return Template::loadview("admin.prescription.favorite.pres_favorite_worklist", [
            'prescription_med_data' => []
        ]);
    }

    public function presFavoriteWorklistSearch(Request $request)
    {
        $person_id = $request->doctor_id;
        $user_no = DB::select("select USER_NO_PK  from wsec_user where PERSON_NO_FK = $person_id");
        $prescription_med_data = DB::table('psn_s_favorite_vw')
            ->select('favourite_item_no_fk', 'favourite_name', 'route', 'med_instruction', 'duration', 'duration_mu', 'item_type_lookup_code', 'user_no_fk')
            // ->where('item_type_lookup_code','MED')
            ->where('doctor_person_no_fk', $user_no[0]->user_no_pk)
            ->get();
        return Template::loadview("admin.prescription.favorite.pres_favorite_worklist_data", [
            'prescription_med_data' => $prescription_med_data
        ]);
    }
    public function presFavoriteWorklistSearchData(Request $request)
    {
        $item_data = strtoupper($request->prescriptionData);
        $item_type = $request->itemType;

        //return DB::table('pres_favorite_pysio_vw')->where('item_type_lookup_code', $item_type)->get();
        $type_arr = [];
        $item_type = explode(",", $item_type);
        foreach ($item_type as $type) {
            $type_arr[] = "'" . $type . "'";
        }
        //dd(Session::get('user.ses_person_no_fk'));
        // ->where('su_no_fk', Session::get('user.su_pk_no'))
        $favourit_data = DB::table('psn_s_favorite_vw')
            ->whereRaw("(upper(favourite_name) like '%$item_data%')")
            ->whereRaw("item_type_lookup_code in(" . implode(",", $type_arr) . ") ")
            ->where('doctor_person_no_fk', Session::get('user.ses_user_pk_no'))
            ->orderBy('favourite_name', 'asc')
            ->get();
        return Template::loadview("admin.components.pres_favourit_list", ['favourit_data' => $favourit_data]);

        // dd( Session::get('user.ses_user_pk_no'));
    }

    public function addDoctorWiseFavorite(Request $request)
    {
        $sequence = DB::getSequence();
        $pres_fav_seq = $sequence->nextValue('pres_fav_no_pk_seq');
        DB::beginTransaction();
        try {
            db::table('psn_s_favorite')->insert([
                'pres_fav_no_pk' => $pres_fav_seq,
                'favourite_name' => $request->item_name,
                'favourite_item_no_fk' => $request->hdn_medicine_item_id_0,
                'doctor_person_no_fk' => $request->hdn_doctor_id_med,
                'user_no_fk' => $request->hdn_doctor_id_med,
                'item_type_lookup_code' => 'MED',
                'route' => $request->route,
                'med_instruction' => $request->instruction,
                'duration' => $request->duration,
                'duration_mu' => 'DAY',
            ]);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function addDoctorWiseFavoriteService(Request $request)
    {
        $sequence = DB::getSequence();
        $pres_fav_seq = $sequence->nextValue('pres_fav_no_pk_seq');
        DB::beginTransaction();
        try {
            db::table('psn_s_favorite')->insert([
                'pres_fav_no_pk' => $pres_fav_seq,
                'favourite_name' => $request->description,
                'favourite_item_no_fk' => $request->hdn_medicine_item_id_0_lab,
                'doctor_person_no_fk' => $request->hdn_doctor_id_oth,
                'user_no_fk' => $request->hdn_doctor_id_med,
                'item_type_lookup_code' => $request->item_type
            ]);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function addDoctorWiseFavoriteAll(Request $request)
    {
        $user_source_no = DB::select("select USER_NO_PK  from wsec_user where PERSON_NO_FK = $request->copy_from_doctor");
        $user_dest_no = DB::select("select USER_NO_PK  from wsec_user where PERSON_NO_FK = $request->copy_id_doctor");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $procedureName = "pkg_manage_masterdata.prc_doc_favorite_copy";
            $databindingarr = [
                'in_source_analyzerattr_no_pk' => $user_source_no,
                'in_destin_analyzerattr_no_pk' => $user_dest_no,
                'in_hospital_no_pk' => $hospital_id,
            ];

            $result = DB::executeProcedure($procedureName, $databindingarr);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function presAltSearchData(Request $request)
    {

        $item_data = strtoupper($request->searchDt);
        $item_list = DB::table('sysc_serviceitem_vw')
            ->select('item_no_pk', 'item_name', 'supplier_name')
            ->where('sysc_serviceitem_vw.generic_no_fk', $request->gen_name)
            ->whereRaw("(upper(sysc_serviceitem_vw.supplier_name) like '%$item_data%')")
            ->get();

        $data_row_id = $request->data_row_id;

        return Template::loadview("admin.prescription.alternative_medicine_data", [
            'item_list' => $item_list,
            'data_row_id' => $data_row_id
        ]);
    }


    public function mostUsedMedicine()
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $data = db::table("psn_t_prescription_med as med")
            ->select('generic_name', 'brand_name', 'item_no_fk', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'med.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('item_no_fk', '!=', 0)
            ->where('OPD_IND', 1)
            ->groupby('generic_name', 'brand_name', 'item_no_fk')
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        return Template::loadview("admin.prescription.most_used_medicine_list", [
            'item_list' => $data
        ]);
    }

    public function mostUsedMedicineUhl()
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $data = db::table("psn_t_prescription_med as med")
            ->select('generic_name', 'brand_name', 'item_no_fk', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'med.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('item_no_fk', '!=', 0)
            ->where('OPD_IND', 1)
            ->groupby('generic_name', 'brand_name', 'item_no_fk')
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        return Template::loadview("admin.prescription.uhl.most_used_item_uhl", [
            'item_list' => $data
        ]);
    }

    public function mostUsedDoctor()
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $data = db::table("PSN_T_PRESCRIPTION pres")
            ->select('doctor.person_code', 'doctor.full_name', 'doctor.person_no_pk', 'doctor.su_name', DB::raw('COUNT(*) as qty'))
            ->join('DOCTOR_INFO_VW as doctor', 'pres.REF_DOCTOR', 'doctor.person_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            // ->where('pres.REF_DOCTOR', '!=', '')
            ->groupby('doctor.person_code', 'doctor.full_name', 'doctor.person_no_pk', 'doctor.su_name')
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        return Template::loadview("admin.prescription.most_used_doctors", [
            'item_list' => $data
        ]);
    }
    public function mostUsedItems($type)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $user_id = Session::get('user.ses_user_pk_no');
        $data = db::table("PSN_T_PRESCRIPTION_DTL dtl")
            ->select('PRESCRITION_DATA', 'LOOKUP_UID', 'LOOKUPDATA_ITEM_NO_FK', 'lookupdata_uid', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'dtl.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('LOOKUP_UID', $type)
            ->groupby('PRESCRITION_DATA', 'LOOKUP_UID', 'LOOKUPDATA_ITEM_NO_FK', 'lookupdata_uid',)
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        $group_template_list = DB::table("psn_s_template a")
            ->select('TEMPLATE_NAME', 'PSN_TEMPLATE_NO_PK')
            // ->leftJoin("psn_s_template_dtl b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            // ->leftJoin("psn_s_lookup c", "b.lookup_uid", "=", "c.psn_lookup_uid")
            ->where('a.AU_ENTRY_BY', $user_id)
            ->where('a.AU_ENTRY_SESSION', $type)->get();

        return Template::loadview("admin.prescription.pres_most_used_items", [
            'item_list' => $data,
            'type' => $type,
            'group_template_list' => $group_template_list
        ]);
    }


    public function mostUsedMedicineData(Request $request)
    {
        $item_id = $request->item_id;
        $doctor_id = Session::get('user.ses_person_no_fk');

        $pat_med_rs = DB::table("psn_t_prescription_med as med")
            ->select([
                'med.generic_name',
                'med.brand_name',
                'med.item_no_fk',
                DB::raw('COUNT(*) as qty'),
                'med.dosage',
                'med.route',
                'med.duration',
                DB::raw('LOWER(med.instruction_take) as instruction_take'),
                'med.duration_mu',
                'med.continue_ind',
            ])
            ->join('psn_t_prescription as pres', 'med.prescription_no_fk', '=', 'pres.prescription_no_pk')
            ->where('pres.doctor_person_no_fk', $doctor_id)
            ->where('med.item_no_fk', $item_id)
            ->groupBy(
                'med.generic_name',
                'med.brand_name',
                'med.item_no_fk',
                'med.dosage',
                'med.route',
                'med.duration',
                'med.instruction_take',
                'med.duration_mu',
                'med.continue_ind'
            )
            ->orderByDesc('med.dosage')
            ->first(); // Safer than get()[0]

        // Defensive: in case no data found
        if (!$pat_med_rs) {
            return response()->json([
                'success' => false,
                'message' => 'No medicine data found.',
            ], 404);
        }

        // Load lookup lists (consider caching if used often)
        $lookupLists = [
            'instructions' => $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name"),
            'route'        => $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name"),
            'dose'         => $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name"),
            'duration'     => $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name"),
            'meddurmu'     => $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name"),
            'duration_mu_phy' => $this->getPresLookupListByCode("DURMU"), // Seems duplicate?
        ];

        // Optional: remove unused empty arrays or move to a preset template
        $emptyArrays = [
            'cc_arr',
            'ch_arr',
            'icd_arr',
            'lmp',
            'in_arr',
            'inf_arr',
            'pr_arr',
            'find_arr',
            'ad_arr',
            'acup_arr',
            'ptet_arr',
            'ptte_arr'
        ];

        $response = [
            'success' => true,
            'data' => $pat_med_rs,
        ];

        foreach ($lookupLists as $key => $value) {
            $response[$key] = $value;
        }

        foreach ($emptyArrays as $key) {
            $response[$key] = [];
        }

        return response()->json($response, 200);
    }

    public function presMumSearchData(Request $request)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $item_data = strtoupper($request->searchDt);
        $item_list = db::table("psn_t_prescription_med as med")
            ->select('generic_name', 'brand_name', 'item_no_fk', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'med.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('item_no_fk', '!=', 0)
            ->whereRaw("(upper(brand_name) like '%$item_data%')")
            ->groupby('generic_name', 'brand_name', 'item_no_fk')
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        return Template::loadview("admin.prescription.most_used_items_data", [
            'item_list' => $item_list
        ]);
    }

    public function presMumSearchDataUhl(Request $request)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $item_data = strtoupper($request->searchDt);
        $item_list = db::table("psn_t_prescription_med as med")
            ->select('generic_name', 'brand_name', 'item_no_fk', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'med.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('item_no_fk', '!=', 0)
            ->whereRaw("(upper(brand_name) like '%$item_data%')")
            ->groupby('generic_name', 'brand_name', 'item_no_fk')
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        return Template::loadview("admin.prescription.uhl.most_used_items_data_uhl", [
            'item_list' => $item_list
        ]);
    }

    public function presMumSearchDataAll(Request $request)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $type = $request->dataType;
        $item_data = strtoupper($request->searchDt);

        $data = DB::table("PSN_T_PRESCRIPTION_DTL dtl")
            ->select('PRESCRITION_DATA', 'LOOKUP_UID', 'LOOKUPDATA_ITEM_NO_FK', 'lookupdata_uid', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'dtl.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('LOOKUP_UID', $type)
            ->whereRaw("(upper(PRESCRITION_DATA) like '%$item_data%')")
            ->groupby('PRESCRITION_DATA', 'LOOKUP_UID', 'LOOKUPDATA_ITEM_NO_FK', 'lookupdata_uid',)
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        return Template::loadview("admin.prescription.most_used_item_data_all", [
            'item_list' => $data,
            'type' => $type
        ]);
    }



    public function presGroupSave(Request $request)
    {
        DB::beginTransaction();
        $sequence = DB::getSequence();
        $template_name = $request->g_name;
        $auth_id = Auth::id();
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_id');
        $in_doctor_person_no_fk = Session::get('user.ses_person_no_fk');
        $in_service_unit_no_fk = $request->hdn_su_no;

        $pres_data = new PrescriptionTemplate();
        $pres_data->template_name = $template_name;
        $pres_data->doctor_no_fk = $in_doctor_person_no_fk;
        $pres_data->su_no_fk = $in_service_unit_no_fk;
        $pres_data->opd_ind = 1;
        $pres_data->status = 1;
        $pres_data->au_entry_by = $auth_id;
        $pres_data->au_entry_session = $request->presType;
        $pres_data->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
        $item_id = $request->item_id;



        if ($pres_data->save()) {
            $template_id = $pres_data->psn_template_no_pk;
            $pres_dtl_arr = [];

            for ($i = 0; $i < sizeof($item_id); $i++) {
                if ($item_id[$i] != "") {
                    $psn_template_dtl_no_pk = $sequence->nextValue('psn_s_template_dtl_seq');
                    $pres_dtldata = new PrescriptionTemplateDtl();

                    $pres_dtldata->psn_template_dtl_no_pk = $psn_template_dtl_no_pk;
                    $pres_dtldata->psn_template_no_fk = $template_id;
                    $pres_dtldata->lookupdata_item_no_fk = $item_id[$i];
                    $pres_dtldata->lookup_uid = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                    $pres_dtldata->lookupdata_uid = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                    $pres_dtldata->prescrition_data = $request->item_name[$i];

                    $pres_dtldata->unit_intensity = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : '';
                    $pres_dtldata->session_duration = isset($request->session_duration[$i]) ? $request->session_duration[$i] : '';
                    $pres_dtldata->no_of_session = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : '';
                    $pres_dtldata->session_mu = isset($request->session_mu[$i]) ? $request->session_mu[$i] : '';


                    $pres_dtldata->entry_serial = 0;
                    $pres_dtldata->status = 1;
                    $pres_dtldata->au_entry_by = $auth_id;
                    $pres_dtldata->au_entry_session = $request->presType;
                    $pres_dtldata->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
                    $pres_dtl_arr[] = $pres_dtldata->attributesToArray();
                }
            }
            // dd($pres_dtl_arr);
            DB::table('psn_s_template_dtl')->insert($pres_dtl_arr);
            DB::commit();
            $message = ['msg' => $request->presType . 'Save Successfully.', 'title' => 'Success'];
        }
        return response()->json($message);
    }

    public function itemLoadPrescriptionGroup(Request $request)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $type = $request->template_type;
        $template_id = $request->item_id;
        $pat_dtls_rs = DB::table("psn_s_template a")
            ->leftJoin("psn_s_template_dtl b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            ->leftJoin("psn_s_lookup c", "b.lookup_uid", "=", "c.psn_lookup_uid")
            ->where("a.psn_template_no_pk", $template_id)->get();
        $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $acup_arr = $ptet_arr = $ptte_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $followup_num = $followup_mu = $template_name = $followup_mu_name = "";


        $data = [];
        if ($type == "ADVICE") {
            foreach ($pat_dtls_rs as $item) {
                if ($item->lookup_uid == "ADVICE") {
                    $value = new stdClass();
                    $value->item = $item->prescrition_data;
                    $value->lookupdata_item_no_fk = $item->lookupdata_item_no_fk;
                    $value->psn_lookup_no_pk = $item->psn_lookup_no_pk;
                    $value->lookupdata_uid = $item->lookupdata_uid;
                    $value->type = $type;
                    array_push($data, $value);
                }
            }
        } else if ($type == "INVFIND") {
            foreach ($pat_dtls_rs as $item) {
                if ($item->lookupdata_uid == "RAD" || $item->lookupdata_uid == "LAB") {
                    $value = new stdClass();
                    $value->item = $item->prescrition_data;
                    $value->lookupdata_item_no_fk = $item->lookupdata_item_no_fk;
                    $value->psn_lookup_no_pk = $item->psn_lookup_no_pk;
                    $value->lookupdata_uid = $item->lookupdata_uid;
                    $value->type = $type;
                    array_push($data, $value);
                }
            }
        }

        return response()->json(['data' => $data], 200);
    }

    public function presDeptWiseDoctor(Request $request)
    {
        $doctor_info = DB::select("SELECT DOCTOR_IND,
                        PERSON_NO_PK,
                        SU_NAME,
                        FULL_NAME
                FROM DOCTOR_INFO_VW
                WHERE SERVICEUNIT_NO_FK = $request->deptValue AND DOCTOR_IND = 1 and employee_ind = 1");
        return Template::loadview("admin.prescription.department_wise_doctor", [
            'doctor_info' => $doctor_info
        ]);
    }



    public function opdPrintPrescriptionPdfV2($prescription_id, $type = "")
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')
            ->where('prescription_no_fk', '=', $prescription_id)
            ->orderBy('prescription_med_no_pk', 'ASC')
            ->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }

                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        $allergy = DB::table('emr_allergies')
            ->where('appoint_no_fk', $prescription_mst->appoint_no_fk)
            ->where('prescription_no_fk', '=', $prescription_id)
            ->get();
        $chronic_item = DB::table('emr_chronic_disease')
            ->where('appoint_no_fk', $prescription_mst->appoint_no_fk)
            ->where('prescription_no_fk', '=', $prescription_id)
            ->get();

        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];

        if ($data['prescription_mst']->dental_ind == 1) {

            return view("admin.prescription.prescription_pdf.opd_dental_print_pdf_v3", $data);
        } else if ($data['prescription_mst']->eye_ind == 1) {

            return view("admin.prescription.prescription_pdf.opd_eye_print_pdf_v3", $data);
        } else if (Session::get('user.serviceunit_code') == "GYNOB") {
            return view("admin.prescription.prescription_pdf.opd_gynee_print_pdf_v3", $data);
        }

        return view("admin.prescription.prescription_pdf.opd_prescription_print_pdf_v3", $data);
    }



    public function opSummaryPrintPdfUHLV2($prescription_id)
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')
            ->select('psn_t_prescription_vw.*', 'hrms_personnel.registration_no', DB::raw("pat_age(patn_registration.dob, nvl(psn_t_prescription_vw.prescription_date, sysdate)) as pat_age"))
            ->leftjoin('hrms_personnel', 'psn_t_prescription_vw.doctor_no_fk', 'hrms_personnel.person_no_pk')
            ->leftJoin('patn_registration', 'psn_t_prescription_vw.patient_no_fk', '=', 'patn_registration.patient_no_pk')
            ->where('prescription_no_pk', '=', $prescription_id)->first();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')
            ->where('prescription_no_fk', '=', $prescription_id)
            ->orderBy('prescription_dtl_no_pk', 'asc')->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        // $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        // if (!empty($prescription_dtl)) {
        //     $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS"];
        //     $investigation_find_arr = [""];
        //     $investigation_find_uid_arr = ["INVFIND"];
        //     $acup_therapy = ["ACUP"];
        //     $electro_therapy = ["PTET"];
        //     $therapeutic_exce = ["PTTE"];
        //     $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
        //     foreach ($prescription_dtl as $dtl_row) {
        //         $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
        //         $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

        //         if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
        //             $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
        //         } else {
        //             $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        //         }
        //         if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
        //             if ($dtl_row->left_right_ind == "L") {
        //                 $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        //             }

        //             if ($dtl_row->left_right_ind == "R") {
        //                 $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        //             }
        //         }

        //         if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
        //             $in_arr["INV"][] = $dtl_row->prescrition_data;
        //         }
        //         if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
        //             $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
        //         }
        //         if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
        //             $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
        //         }

        //         if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
        //             $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
        //         }
        //         if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
        //             $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
        //         }
        //         if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
        //             $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
        //             ;
        //         }

        //         if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
        //             $lookup_name = "Procedure";
        //             $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
        //         }
        //     }
        // }


        // $pres_med = [];
        // foreach ($prescription_med as $med) {
        //     $pres_med[$med->brand_name . '`' . $med->pack_type][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        // }
        // $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
        // $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();


        // $data = [
        //     'prescription_mst' => $prescription_mst,
        //     "patient_barcode" => $patient_barcode,
        //     "prescription_barcode" => $prescription_barcode,
        //     "prescription_med" => $prescription_med,
        //     "left_side_arr" => $left_side_arr,
        //     "pr_arr" => $pr_arr,
        //     "in_arr" => $in_arr,
        //     "in_find_arr" => $in_find_arr,
        //     "dental_arr" => $dental_arr,
        //     "selected_dental_arr" => $selected_dental_arr,
        //     "ocular_exam_left_arr" => $ocular_exam_left_arr,
        //     "ocular_exam_right_arr" => $ocular_exam_right_arr,
        //     "vitals" => $vitals,
        //     "acup_thy_arr" => $acup_thy_arr,
        //     "ele_thy_arr" => $ele_thy_arr,
        //     "therapiu_therapy_arr" => $therapiu_therapy_arr,
        //     "allergy" => $allergy,
        //     "chronic_item" => $chronic_item,
        //     "doc_info" => $doc_info,
        //     "pres_med" => $pres_med
        // ];
        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS", "SERVICE", "PKG"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                // if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                //     $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                //     $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                //     $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;;
                // }


                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        (isset($dtl_row->e_location) ? $dtl_row->e_location : '') . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }


                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type . '`' . $med->generic_name][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        $referedInfo = DB::table('OPD_REFF_ANESTHESIA_DEPT')->select('REFF_DATE')->where('PRESCRIPTION_NO_FK', $prescription_id)->first();

        $allergy = [];
        $chronic_item = [];
        if ($prescription_mst->appoint_no_fk != '') {
            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // dd($allergy,$prescription_mst->appoint_no_fk);
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // ->where('prescription_no_fk', '=', $prescription_id)
        }
        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "referedInfo" => $referedInfo,
            "pres_med" => $pres_med
        ];

        return view("admin.prescription.prescription_pdf.opd_op_summary_print_pdf_v2", $data);
    }



    public function opSummaryPrintPdfUHLV3($prescription_id)
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')
            ->select('psn_t_prescription_vw.*', 'hrms_personnel.registration_no', DB::raw("pat_age(patn_registration.dob, nvl(psn_t_prescription_vw.prescription_date, sysdate)) as pat_age"))
            ->leftjoin('hrms_personnel', 'psn_t_prescription_vw.doctor_no_fk', 'hrms_personnel.person_no_pk')
            ->leftJoin('patn_registration', 'psn_t_prescription_vw.patient_no_fk', '=', 'patn_registration.patient_no_pk')
            ->where('prescription_no_pk', '=', $prescription_id)->first();
        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')
            ->where('prescription_no_fk', '=', $prescription_id)
            ->orderBy('prescription_dtl_no_pk', 'asc')->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals = DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info = DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info = DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        // $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        // if (!empty($prescription_dtl)) {
        //     $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS"];
        //     $investigation_find_arr = [""];
        //     $investigation_find_uid_arr = ["INVFIND"];
        //     $acup_therapy = ["ACUP"];
        //     $electro_therapy = ["PTET"];
        //     $therapeutic_exce = ["PTTE"];
        //     $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
        //     foreach ($prescription_dtl as $dtl_row) {
        //         $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
        //         $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

        //         if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
        //             $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
        //         } else {
        //             $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        //         }
        //         if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
        //             if ($dtl_row->left_right_ind == "L") {
        //                 $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        //             }

        //             if ($dtl_row->left_right_ind == "R") {
        //                 $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        //             }
        //         }

        //         if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
        //             $in_arr["INV"][] = $dtl_row->prescrition_data;
        //         }
        //         if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
        //             $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
        //         }
        //         if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
        //             $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
        //         }

        //         if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
        //             $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
        //         }
        //         if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
        //             $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
        //         }
        //         if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
        //             $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
        //             ;
        //         }

        //         if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
        //             $lookup_name = "Procedure";
        //             $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
        //         }
        //     }
        // }


        // $pres_med = [];
        // foreach ($prescription_med as $med) {
        //     $pres_med[$med->brand_name . '`' . $med->pack_type][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        // }
        // $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
        // $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();


        // $data = [
        //     'prescription_mst' => $prescription_mst,
        //     "patient_barcode" => $patient_barcode,
        //     "prescription_barcode" => $prescription_barcode,
        //     "prescription_med" => $prescription_med,
        //     "left_side_arr" => $left_side_arr,
        //     "pr_arr" => $pr_arr,
        //     "in_arr" => $in_arr,
        //     "in_find_arr" => $in_find_arr,
        //     "dental_arr" => $dental_arr,
        //     "selected_dental_arr" => $selected_dental_arr,
        //     "ocular_exam_left_arr" => $ocular_exam_left_arr,
        //     "ocular_exam_right_arr" => $ocular_exam_right_arr,
        //     "vitals" => $vitals,
        //     "acup_thy_arr" => $acup_thy_arr,
        //     "ele_thy_arr" => $ele_thy_arr,
        //     "therapiu_therapy_arr" => $therapiu_therapy_arr,
        //     "allergy" => $allergy,
        //     "chronic_item" => $chronic_item,
        //     "doc_info" => $doc_info,
        //     "pres_med" => $pres_med
        // ];
        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS", "SERVICE", "PKG"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" || $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                // if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                //     $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                //     $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->e_location . '_' . $dtl_row->m_duration;
                // }
                // if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                //     $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode . '_' . $dtl_row->m_repetition . '_' . $dtl_row->m_duration;;
                // }


                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        (isset($dtl_row->e_location) ? $dtl_row->e_location : '') . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }

                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $m_repetition = isset($dtl_row->m_repetition) ? $dtl_row->m_repetition : '';
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' .
                        $dtl_row->session_duration . '_' .
                        $dtl_row->session_mu_text . '_' .
                        $dtl_row->no_of_session . '_' .
                        $dtl_row->unit_intensity . '_' .
                        $dtl_row->prescrition_phy_frequency . '_' .
                        $dtl_row->prescrition_phy_mode . '_' .
                        $m_repetition . '_' .
                        (isset($dtl_row->m_duration) ? $dtl_row->m_duration : '');
                }


                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type . '`' . $med->generic_name][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        $referedInfo = DB::table('OPD_REFF_ANESTHESIA_DEPT')->select('REFF_DATE')->where('PRESCRIPTION_NO_FK', $prescription_id)->first();

        $allergy = [];
        $chronic_item = [];
        if ($prescription_mst->appoint_no_fk != '') {
            $allergy = DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // dd($allergy,$prescription_mst->appoint_no_fk);
            $chronic_item = DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->get();
            // ->where('prescription_no_fk', '=', $prescription_id)
        }

        $customCss = '
    <style>
    html, body {
        -webkit-text-size-adjust: none !important;
        font-family: sans-serif !important;
        margin: 0; padding: 0;
    }
    /* Force base font */
    body { font-size: 14px !important; line-height: 1.3 !important; }
    /* fallback for all elements */
    * { font-size: 14px !important; }
    /* element specific tweaks */
    .report-data { font-size: 14px !important; }
    .item-name { font-size: 16px !important; }
    .print_footer { font-size: 10px !important; }
    </style>
';

        $data = [
            'prescription_mst' => $prescription_mst,
            'patient_barcode' => $patient_barcode,
            'prescription_barcode' => $prescription_barcode,
            'prescription_med' => $prescription_med,
            'left_side_arr' => $left_side_arr,
            'pr_arr' => $pr_arr,
            'in_arr' => $in_arr,
            'in_find_arr' => $in_find_arr,
            'dental_arr' => $dental_arr,
            'selected_dental_arr' => $selected_dental_arr,
            'ocular_exam_left_arr' => $ocular_exam_left_arr,
            'ocular_exam_right_arr' => $ocular_exam_right_arr,
            'vitals' => $vitals,
            'acup_thy_arr' => $acup_thy_arr,
            'ele_thy_arr' => $ele_thy_arr,
            'therapiu_therapy_arr' => $therapiu_therapy_arr,
            'allergy' => $allergy,
            'chronic_item' => $chronic_item,
            'doc_info' => $doc_info,
            'referedInfo' => $referedInfo,
            'pres_med' => $pres_med
        ];

        // Render header and footer views with data
        // Prepare header HTML
        $headerHtml = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-size:12px; text-align:center; margin:0; padding:0; }
        .header { border-bottom:1px solid #000; padding:5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <strong>My Header Content</strong>
    </div>
</body>
</html>';

        $headerFile = $this->htmlToTempFile($headerHtml);

        $footerHtml = view('admin.prescription.prescription_pdf.op_pres_footer', $data)->render();
        $footerFile = $this->htmlToTempFile($footerHtml);

        // Optional: log or dump paths to check if files exist and are accessible
        if (!file_exists($headerFile)) {
            throw new Exception("Header file does not exist: $headerFile");
        }
        if (!file_exists($footerFile)) {
            throw new Exception("Footer file does not exist: $footerFile");
        }

        // Render main content with CSS
        $html = view('admin.prescription.prescription_pdf.opd_op_summary_print_pdf_v3', $data)->render();
        $htmlWithCss = $customCss . $html;

        $pdf = SnappyPdf::loadHTML($htmlWithCss)
            ->setOption('encoding', 'UTF-8')
            ->setOption('enable-local-file-access', true)
            ->setOption('margin-top', '30mm')      // room for header
            ->setOption('margin-bottom', '10mm')   // room for footer
            ->setOption('margin-left', '5mm')
            ->setOption('margin-right', '5mm')
            ->setOption('header-html', $headerFile)
            ->setOption('header-spacing', 5)
            ->setOption('footer-font-size', 9)
            ->setOption('footer-right', 'Page [page] / [toPage]')
            ->setOption('load-error-handling', 'ignore')
            ->setPaper('a4');

        return $pdf->inline('opd-summary.pdf');
    }

    private function htmlToTempFile(string $html): string
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'pdf_');
        file_put_contents($tmpFile, $html);
        return $tmpFile;
    }


    public function ipdPreviewPrescriptionV1(Request $request)
    {
        $prescription_med = DB::table('psn_t_prescription_med_vw')
            ->select('item_name', 'dosage', 'route', 'duration', 'duration_mu', 'item_type', 'medicine_enddate')
            ->where('prescription_no_fk', $request->prescription_id)
            ->get();
        $investigation = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $request->prescription_id)->get();
        return response()->json(['medicine' => $prescription_med, 'investigation' => $investigation], 200);
    }


    public function doctorNameFind(Request $request)
    {
        $doctor_name = DB::table('hrms_personnel')->select('full_name')->where('person_no_pk', $request->doctor_id)->first()->full_name;
        return response()->json($doctor_name);
    }



    // For Medicine Details

    public function getPrescriptionMedicineDtlsUHL($prescription_id, $patient_code, Request $request)
    {
        $doctor_id = Auth::id();
        $hdn_su_no = $request->hdn_su_no;


        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");


        $pat_med_rs = DB::table('psn_t_prescription_vw a')
            ->leftJoin('psn_t_prescription_med_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->where('a.prescription_no_pk', $prescription_id)
            ->orderBy('prescription_med_no_pk', 'asc')
            ->get();



        return response()->json([
            'success' => true,
            'pat_med_rs' => $pat_med_rs,
            'dose' => $dose,
            'route' => $route,
            'duration' => $duration,
            'instructions' => $instructions,
            'meddurmu' => $meddurmu,
            'cc_arr' => [],
            'ch_arr' => [],
            'icd_arr' => [],
            'lmp' => [],
            'in_arr' => [],
            'inf_arr' => [],
            'pr_arr' => [],
            'find_arr' => [],
            'ad_arr' => [],
            'acup_arr' => [],
            'duration_mu_phy' => $duration_mu_phy,
            'ptet_arr' => [],
            'ptte_arr' => [],
        ], 200);
    }

    public function getPrescriptionMedicineLastDtlsUHL($prescription_id, $patient_code, Request $request)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $hdn_su_no = $request->hdn_su_no;


        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");
        $duration = $this->getPresLookupListByCode("DURATION", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");


        $pat_med_rs = DB::table('psn_t_prescription_vw a')
            ->leftJoin('psn_t_prescription_med_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->where('a.prescription_no_pk', $prescription_id)
            ->where('a.doctor_person_no_fk', $doctor_id)
            ->orderBy('prescription_med_no_pk', 'asc')
            ->get();



        return response()->json([
            'success' => true,
            'pat_med_rs' => $pat_med_rs,
            'dose' => $dose,
            'route' => $route,
            'duration' => $duration,
            'instructions' => $instructions,
            'meddurmu' => $meddurmu,
            'cc_arr' => [],
            'ch_arr' => [],
            'icd_arr' => [],
            'lmp' => [],
            'in_arr' => [],
            'inf_arr' => [],
            'pr_arr' => [],
            'find_arr' => [],
            'ad_arr' => [],
            'acup_arr' => [],
            'duration_mu_phy' => $duration_mu_phy,
            'ptet_arr' => [],
            'ptte_arr' => [],
        ], 200);
    }

    public function mostUsedItemsUhl($type)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $user_id = Session::get('user.ses_user_pk_no');
        $data = db::table("PSN_T_PRESCRIPTION_DTL dtl")
            ->select('PRESCRITION_DATA', 'LOOKUP_UID', 'LOOKUPDATA_ITEM_NO_FK', 'lookupdata_uid', DB::raw('COUNT(*) as qty'))
            ->join('psn_t_prescription as pres', 'dtl.prescription_no_fk', 'pres.prescription_no_pk')
            ->where('doctor_person_no_fk', $doctor_id)
            ->where('LOOKUP_UID', $type)
            ->groupby('PRESCRITION_DATA', 'LOOKUP_UID', 'LOOKUPDATA_ITEM_NO_FK', 'lookupdata_uid',)
            ->skip(0)->take(100)
            ->orderBy('qty', 'desc')
            ->get();

        $group_template_list = DB::table("psn_s_template a")
            ->select('TEMPLATE_NAME', 'PSN_TEMPLATE_NO_PK')
            // ->leftJoin("psn_s_template_dtl b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            // ->leftJoin("psn_s_lookup c", "b.lookup_uid", "=", "c.psn_lookup_uid")
            ->where('a.AU_ENTRY_BY', $user_id)
            ->where('a.AU_ENTRY_SESSION', $type)->get();

        return Template::loadview("admin.prescription.uhl.pres_most_used_items_uhl", [
            'item_list' => $data,
            'type' => $type,
            'group_template_list' => $group_template_list
        ]);
    }

    public function pakagesuhl()
    {
        $doctorid = session::get('user.ses_person_no_fk');
        $userid = session::get('user.ses_user_pk_no');

        // retrieve all package-type service items
        $packages = db::select("
        select item_name, item_no_pk, item_code, sales_price
        from sysc_serviceitem
        where item_type = 'PKG'
    ");
        $packageitems = [];

        foreach ($packages as $pkg) {
            // safely cast to integer
            $itemnopk = (int) $pkg->item_no_pk;
            // retrieve associated auto-items using parameter binding
            $items = db::select("
                 SELECT  PAKAGES.ITEM_NAME as AUTOITEMLST_CODE,
                item.item_name as item_name,
                SERVICE.ITEM_NO_FK,
                SERVICE.AUTO_ITEM_NO_FK
            FROM    sysc_serviceitem_auto service
                LEFT JOIN
                    sysc_serviceitem item
                ON SERVICE.AUTO_ITEM_NO_FK = item.item_no_pk
                left join sysc_serviceitem pakages
                    ON PAKAGES.ITEM_NO_pK = service.item_no_fk
                        where service.item_no_fk = :pkgid  order by SERVICE.AU_ENTRY_AT desc
                    ", ['pkgid' => $itemnopk]);

            $packageitems[$pkg->item_name . '~' . $pkg->sales_price . '~' . $pkg->item_code . '~' . $pkg->item_no_pk] = $items;
        }

        return template::loadview(
            "admin.prescription.uhl.pakage_investigation_uhl",
            [
                'packages' => $packages,
                'packageitems' => $packageitems
            ]
        );
    }


    public function itemLoadPrescriptionGroupUhl(Request $request)
    {
        $doctor_id = Session::get('user.ses_person_no_fk');
        $type = $request->template_type;
        $template_id = $request->item_id;
        $pat_dtls_rs = DB::table("psn_s_template a")
            ->leftJoin("psn_s_template_dtl b", "a.psn_template_no_pk", "=", "b.psn_template_no_fk")
            ->leftJoin("psn_s_lookup c", "b.lookup_uid", "=", "c.psn_lookup_uid")
            ->where("a.psn_template_no_pk", $template_id)->get();
        $cc_arr = $ch_arr = $cd_arr = $pd_arr = $ds_arr = $icd_arr = $acup_arr = $ptet_arr = $ptte_arr = $ad_arr = $in_arr = $inf_arr = $pr_arr = $dis_arr = $refdoc_arr = [];
        $next_followup_dt = $refered_doc = $presc_note = $followup_num = $followup_mu = $template_name = $followup_mu_name = "";

        $data = [];
        if ($type == "ADVICE") {
            foreach ($pat_dtls_rs as $item) {
                if ($item->lookup_uid == "ADVICE") {
                    $value = new stdClass();
                    $value->item = $item->prescrition_data;
                    $value->lookupdata_item_no_fk = $item->lookupdata_item_no_fk;
                    $value->psn_lookup_no_pk = $item->psn_lookup_no_pk;
                    $value->lookupdata_uid = $item->lookupdata_uid;
                    $value->type = $type;
                    array_push($data, $value);
                }
            }
        } else if ($type == "INVFIND") {
            foreach ($pat_dtls_rs as $item) {
                if ($item->lookupdata_uid == "RAD" || $item->lookupdata_uid == "LAB") {
                    $value = new stdClass();
                    $value->item = $item->prescrition_data;
                    $value->lookupdata_item_no_fk = $item->lookupdata_item_no_fk;
                    $value->psn_lookup_no_pk = $item->psn_lookup_no_pk;
                    $value->lookupdata_uid = $item->lookupdata_uid;
                    $value->type = $type;
                    array_push($data, $value);
                }
            }
        }
        return response()->json(['data' => $data], 200);
    }
    public function addAllergyUhl()
    {
        $data = $this->getPresLookupListByMultipleCode(["ALLERGY", "ALLERGYCAT", "ALLGSEVERITY"]);

        return Template::loadview("admin.prescription.v2.add_alergy_uhl", [
            'lookup_data' => $this->getPresLookupListByMultipleCode(["ALLERGY", "ALLERGYCAT", "ALLGSEVERITY", "OTHERS"]),
        ]);
    }
}
