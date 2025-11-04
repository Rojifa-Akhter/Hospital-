<?php

namespace App\Http\Controllers;
use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Requests\DrugDiseaseRequest;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository AS Repo;
use App\Models\Room;
use App\Models\ServiceUnit;
use App\Models\DrugDisseaseInteract;
use App\Models\DrugDrugInteraction;
use App\Models\PrescriptionFavourit;
use Auth;
use DB;

class PrescriptionInteractionSetupController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    protected $model2;

    public function __construct(DrugDisseaseInteract $DrugDisseaseInteract,DrugDrugInteraction $company, PrescriptionFavourit $PrescriptionFavourit)
    {
        $this->middleware('auth');       
        
        $this->model3 = new Repo($DrugDisseaseInteract);
        $this->model = new Repo($company);
        $this->model2 = new Repo($PrescriptionFavourit);
    }
    
    public function drugDrugInteraction()
    {
      return Template::loadview("admin.settings.prescription_interaction.drug_drug_interaction");
  }
  public function favouriteItemTable()
  {


    $department=DB::table('sys_serviceunit_vw')->where('clinical_su_ind', '=', 1 )->get();
    $lookup_id_arr = $this->getPresLookupIDByCode(["CHIEFCOM","CLINICHIST","PROVDIAG","DISEASE", "ADVICE", "INSTRUCTION"]);       

    return Template::loadview("admin.settings.prescription_interaction.favourite_item", ['department'=>$department, 'lookup_id_arr'=>$lookup_id_arr]);
}
public function favouriteItemAutocom(Request $request)
{
    $lookup_code= $request->lookup_code;
    return $this->getPresLookupDataAutocompleteList($request);
}





    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function drugDrugInteractionForm()
    {
        $severity = $this->getPresLookupListByCode('ALLGSEVERITY');
        return Template::loadview("admin.settings.prescription_interaction.drug_drug_interaction_form", ['severity' => $severity]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function drugDiseaseInteraction()
    {
        return Template::loadview("admin.settings.prescription_interaction.drug_disease_interaction");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    // public function drugDiseaseInteractionForm()
    // {
    // 	return Template::loadview("admin.settings.prescription_interaction.drug_disease_interaction_form");
    // }
    public function drugDiseaseInteractionForm()
    {
        $severity= $this->getPresLookupListByCode( "ALLGSEVERITY" );
        // dd($severity);
         $drugDiseaseInteractionForm=DB::table('PSN_S_LOOKUP_VW')->where('PRES_LOOKUP_CODE', 'DISEASE')->orderBy ('serial', 'asc')->get();
        return Template::loadview("admin.settings.prescription_interaction.drug_disease_interaction_form", ['drugDiseaseInteractionForm'=>$drugDiseaseInteractionForm,'severity'=>$severity]);
    }

    public function storeDrugDisseaseInteract(DrugDiseaseRequest $request){

        $id = $request->id;
        $diseas_name=$request->interaction_disease_name;
        // dd($diseas_name);
        $disease= explode("_", $diseas_name);
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [

                'drug_item_no_fk' => $request->hdn_drug_name,
                'drug_name' => $request->drug_name,                
                'dissease_prs_lookuplist_no_fk' => $disease[0],
                'dissease_name' => $disease[1],                
                'interaction_alert_msg' => $request->interaction_alert_message,               
                'severiaty_text' => $request->severity_department,
                'status' => 1,
            ];
            
            if($id == null || $id == "")
            {

                $data['au_entry_by'] = $auth_id;
                $this->model3->create($data);
            }
            else
            {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model3->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        }
        catch (\Exception $e)
        {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);

    }

    public function getAllDrugDiseaseInteract(Request $request)
    {
        // dd("bellal");
        $columns = array(
            'sl',
            'item_code',
            'drug_name',
            'pres_lookupdata_code',
            'dissease_name',          
            'severiaty_text',
            'interaction_alert_msg',
            'drug_dissease_interact_no_pk'
        );

        $sql = "SELECT '' as sl, sv.item_code, dd.drug_name, dis.PRES_LOOKUPDATA_CODE, dd.dissease_name,dd.severiaty_text,dd.interaction_alert_msg, dd.drug_dissease_interact_no_pk,  rownum rownumber, dd.au_update_at, dd.au_entry_at
        from EMR_DRUG_DISSEASE_INTERACT dd LEFT JOIN sysc_serviceItem_vw sv ON sv.item_no_pk = dd.DRUG_ITEM_NO_FK 
        LEFT JOIN PSN_S_LOOKUP_VW dis  ON dis.pres_lookupdata_no_pk = dd.DISSEASE_PRS_LOOKUPLIST_NO_FK";
        
        $order_by_column = "DRUG_DISSEASE_INTERACT_NO_PK";

        $json_data = $this->datatable( $request, $sql, $order_by_column, 'ASC', $columns);
        echo json_encode($json_data);
// dd( $json_data);
    }

    public function editDrugDiseaseInteract($id){
        // dd($id);
        $drugDiseaseInteract = $this->model3->show($id);

         $drugDiseaseInteractionForm=DB::table('PSN_S_LOOKUP_VW')->where('PRES_LOOKUP_CODE', 'DISEASE')->orderBy ('serial', 'asc')->get();
        $severity= $this->getPresLookupListByCode( "ALLGSEVERITY" );    
        return Template::loadview("admin.settings.prescription_interaction.drug_disease_interaction_form",["drugDiseaseInteract"=>$drugDiseaseInteract, "severity"=>$severity, 'drugDiseaseInteractionForm'=>$drugDiseaseInteractionForm] );
    }
    public function favouriteItemEdit($id){
        // dd($id);
        $drugDiseaseInteract = $this->model3->show($id);

        $drugDiseaseInteractionForm=DB::table('PSN_S_LOOKUP_VW')->where('PSN_LOOKUP_UID', 'DISEASE')->orderBy ('SL_NO', 'asc')->get();
        $severity= $this->getPresLookupListByCode( "ALLGSEVERITY" );    
        return Template::loadview("admin.settings.prescription_interaction.drug_disease_interaction_form",["drugDiseaseInteract"=>$drugDiseaseInteract, "severity"=>$severity, 'drugDiseaseInteractionForm'=>$drugDiseaseInteractionForm] );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


//    Insert
    public function store(Request $request)
    {

        $id = $request->id;
        $auth_id = Auth::id();
//        dd( $id );
        DB::beginTransaction();
        try {

            $data = [
                'drug_name' => $request->drug_name,
                'interact_drug_name' => $request->interaction_drug_name,
                'interaction_alert_msg' => $request->interaction_alert_message,
                'severiaty_text' => $request->severity_department

            ];
//            dd($data);

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $this->model->create($data);

            } else {

                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);

    }
    public function favouriteItemStore(Request $request)
    {

        $id = $request->id;
        $auth_id = Auth::id();
//        dd( $id );
        DB::beginTransaction();
        try {
            if(isset($request->hdn_medicine_item_id)){
                $data = [
                    'su_no_fk'               => $request->department_name,
                    'user_no_fk'            => $request->doctor_id,
                    'item_type_lookup_code' => 'MED',                  
                    'favourite_name'        => $request->medicine_item_0,    
                    'favourite_item_no_fk'   =>  $request->hdn_medicine_item_id ,        
                    'status'     => 1
                ];
            }
            else{
                $data = [
                    'su_no_fk'               => $request->department_name,
                    'user_no_fk'            => $request->doctor_id,
                    'item_type_lookup_code' => $request->hdn_lookup_code,
                    'psn_lookupdata_no_fk'        => $request->hdn_item_id,
                    'favourite_name'        => $request->hdn_item_name,
                    'pres_lookup_no_fk'     => $request->hdn_lookup_id,
                    'status'     => 1


                ];

            }




            if ($id == '') {
                $data['au_entry_by'] = $auth_id;
                $this->model2->create($data);

            } else {

                $data['au_update_by'] = $auth_id;
                $this->model2->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);

    }

//    alldata
    public function drugDrugAllData(Request $request)
    {
        $columns = array(
            'sl',
            'drug_name',
            'interact_drug_name',
            'interaction_alert_msg',
            'severiaty_text',
            'drug_drug_interact_no_pk',
        );

        $sql = "select  '' as sl,drug_name, interact_drug_name, interaction_alert_msg, severiaty_text,drug_drug_interact_no_pk, rownum rownumber, au_update_at, au_entry_at from emr_drug_drug_interact ";
        $order_by_column = "drug_drug_interact_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }
    public function favouriteItemList(Request $request)
    {
        $columns = array(
            'sl',
            'drug_name',
            'interact_drug_name',
            'interaction_alert_msg',
            'severiaty_text',
            'drug_drug_interact_no_pk',
        );

        $sql = "select  '' as sl,drug_name, interact_drug_name, interaction_alert_msg, severiaty_text,drug_drug_interact_no_pk, rownum rownumber, au_update_at, au_entry_at from emr_drug_drug_interact ";
        $order_by_column = "drug_drug_interact_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }

//    Edit

    public function prescriptionInteractionDrugDiseaseEdit($id)
    {
        $data = $this->model->show($id);
        $severity = $this->getPresLookupListByCode('ALLGSEVERITY');
        return Template::loadview("admin.settings.prescription_interaction.drug_drug_interaction_form", ['data' => $data, 'severity' => $severity]);

    }
}
