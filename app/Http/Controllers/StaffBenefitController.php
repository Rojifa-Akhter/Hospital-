<?php
namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Library\Template;
use App\Models\GrantUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use NumberToWords\NumberToWords;
use PDO;

class StaffBenefitController extends Controller
{
    public function index()
    {
        $corporate_info = DB::table('ccm_corporateclient_vw')
            ->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')
            ->where('active_status', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)
            ->where("GRANTSU_STATUS", "1")
            ->where("cash_counter_ind", "1")
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')
            ->orderBy('serviceunit_name', 'asc')
            ->get();

        return Template::loadView("admin.accounts.staff_benefits.index", [
            'corporate_info' => $corporate_info,
            'service_point'  => $service_point,
        ]);
    }

    public function opdList(Request $request)
    {
        $invoice_id      = $request->invoice_id;
        $patient_id      = $request->hdn_patient_id;
        $doctor_code     = $request->hdn_doctor_id;
        $admission_id    = $request->admission_id;
        $corporate_name  = $request->corporate_name;
        $full_bill       = $request->full_paid;
        $due_bill        = $request->due_bill;
        $all_paid        = $request->all_paid;
        $patient_type_no = $request->patient_type_no;

        $opd = 'due > 1'; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to   = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause   = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $patient_type_no != "" ? " $clause patient_type = $patient_type_no " : "";
        $sql_cond .= " $clause patient_type = '41' ";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $doctor_code != "" ? " $clause person_no_fk = $doctor_code " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 1" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk') : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= ($request->bill_type) != "" ? "$clause " . $request->bill_type . " > 0" : "";

        $table = 'finc_v1_opd_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';
        // $to_date = date('Y-m-d');
        // $hospital_id =  Session::get('user.ses_hospital_no_pk');
        // $where = "trunc(INVOICE_DATE) = '$to_date' and au_entry_hospital_pk_no =$hospital_id  "; //and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')

        $columns = [
            ['db' => 'invoice', 'dt' => 0],
            ['db' => 'invoice_no_pk', 'dt' => 1],
            ['db' => 'invoice_code', 'dt' => 2],
            ['db' => 'invoice_date', 'dt' => 3],
            ['db' => 'patient_code', 'dt' => 4],
            ['db' => 'patient_name', 'dt' => 5],
            ['db' => 'patient_gender', 'dt' => 6],
            ['db' => 'mobile1', 'dt' => 7],
            ['db' => 'patient_no_pk', 'dt' => 8],
            ['db' => 'person_no_fk', 'dt' => 9],
            ['db' => 'full_name', 'dt' => 10],
            ['db' => 'doctor_gender', 'dt' => 11],
            ['db' => 'specialization', 'dt' => 12],
            ['db' => 'phone_mobile', 'dt' => 13],
            ['db' => 'collection', 'dt' => 14],
            ['db' => 'due', 'dt' => 15],
            ['db' => 'refund', 'dt' => 16],
            ['db' => 'photo_name', 'dt' => 17],
            ['db' => 'person_code', 'dt' => 18],
            ['db' => 'degree1', 'dt' => 19],
            ['db' => 'degree2', 'dt' => 20],
            ['db' => 'degree3', 'dt' => 21],
            ['db' => 'degree4', 'dt' => 22],
            ['db' => 'au_entry_at', 'dt' => 23],
            ['db' => 'au_update_at', 'dt' => 24],
            ['db' => 'discount', 'dt' => 25],
            ['db' => 'ledger_amt_sales', 'dt' => 26],
            ['db' => 'appoint_service_no_fk', 'dt' => 27],
            ['db' => 'admission_no_pk', 'dt' => 28],
            ['db' => 'ccm_client_name', 'dt' => 29],
            ['db' => 'contact_no', 'dt' => 30],
            ['db' => 'contact_person', 'dt' => 31],
            ['db' => 'module_code', 'dt' => 32],
            ['db' => 'invoice_trn_list', 'dt' => 33],
            ['db' => 'sales_cancel', 'dt' => 34],
            ['db' => 'sales', 'dt' => 35],
            ['db' => 'bill_type', 'dt' => 36],

        ];

        if (! empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function ipdList(Request $request)
    {
        $patient_id      = $request->hdn_patient_id;
        $admission_id    = $request->admission_id;
        $corporate_name  = $request->corporate_name;
        $full_bill       = $request->full_paid;
        $due_bill        = $request->due_bill;
        $all_paid        = $request->all_paid;
        $patient_type_no = $request->patient_type_no;

        $ipd = 'due > 5'; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to   = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $ipd;
        $clause   = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_fk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $patient_type_no != "" ? " $clause patient_type_no_fk = $patient_type_no " : "";
        $sql_cond .= " $clause patient_type_no_fk = '41' ";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_pk  = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 1" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";

        $table      = 'finc_ipdpatientlist_vw';
        $primaryKey = 'patient_no_fk';

        $columns = [
            ['db' => 'admission_date', 'dt' => 0],
            ['db' => 'patient_no_fk', 'dt' => 1],
            ['db' => 'patient_name', 'dt' => 2],
            ['db' => 'admission_no_pk', 'dt' => 3],
            ['db' => 'dis_date', 'dt' => 4],
            ['db' => 'sales', 'dt' => 5],
            ['db' => 'payment', 'dt' => 6],
            ['db' => 'due', 'dt' => 7],
            ['db' => 'discount', 'dt' => 8],
            ['db' => 'patient_code', 'dt' => 9],
            ['db' => 'bed_name', 'dt' => 10],
            ['db' => 'ccm_client_name', 'dt' => 11],
        ];

        if (! empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $rows = $request->rows ?? [];

            // ================= PREPARE ARRAY VALUES =================
            $admissionIds   = array_column($rows, 'admission_id');
            $invoiceIds     = array_column($rows, 'invoice_id');
            $servicePoints  = array_column($rows, 'service_point');
            $paymentAmounts = array_column($rows, 'payment_amount');

            $recordCount = count($admissionIds);

            // ================= AUDIT INFO =================
            $authId       = Auth::id();
            $entrySession = 'STAFF_BENEFIT';
            $hospitalId   = Session::get('user.ses_hospital_no_pk');
            $outError     = '';

            $numelems = 500;

            // ================= PDO CALL =================
            $pdo  = DB::getPdo();
            $stmt = $pdo->prepare("
                BEGIN pkg_billing_ipd_v0.prc_ipd_staffbeneffit_array(
                    :in_admission_no_fk,
                    :in_invoice_no_fk,
                    :in_counter_su_no_fk,
                    :in_payment_amt,
                    :in_record_count,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :out_error
                );
                END;
            ");

            // ================= ARRAY BINDINGS =================
            $stmt->bindArray(':in_admission_no_fk', $admissionIds, count($admissionIds), $numelems, SQLT_INT);
            $stmt->bindArray(':in_invoice_no_fk', $invoiceIds, count($invoiceIds), $numelems, SQLT_INT);
            $stmt->bindArray(':in_counter_su_no_fk', $servicePoints, count($servicePoints), $numelems, SQLT_INT);
            $stmt->bindArray(':in_payment_amt', $paymentAmounts, count($paymentAmounts), $numelems, SQLT_FLT);

            // ================= SCALAR BINDINGS =================
            $stmt->bindParam(':in_record_count', $recordCount, PDO::PARAM_INT);
            $stmt->bindParam(':in_au_entry_by', $authId, PDO::PARAM_INT);
            $stmt->bindParam(':in_au_entry_session', $entrySession, PDO::PARAM_STR);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospitalId, PDO::PARAM_INT);

            // ================= OUTPUT =================
            $stmt->bindParam(':out_error', $outError, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 500);

            // ================= EXECUTE =================
            $stmt->execute();

            $staffInvoiceNoPk = (int) DB::table('finc_arstaffledgerdtl')
                ->orderByDesc('arstaffledgerdtl_date')
                ->value('ar_invoice_no_pk') ?? 0;

            $staffInvoiceNoPk++;

            foreach ($rows as $row) {
                DB::table('finc_arstaffledgerdtl')->insert([
                    'arstaffledgerdtl_no_pk'  => DB::getSequence()->nextValue('arstaffledgerdtl_no_pk_seq'),
                    'ar_invoice_no_pk'        => $staffInvoiceNoPk,
                    'arstaffledgerdtl_date'   => Carbon::now(),
                    'patient_no_fk'           => $row['patient_id'],
                    'admission_no_fk'         => $row['admission_id'],
                    'invoice_no_fk'           => $row['invoice_id'],
                    'cor_client_no_fk'        => $row['corporate_client_id'],
                    'amount'                  => $row['payment_amount'],
                    'status'                  => true,
                    'au_entry_by'             => $authId,
                    'au_entry_session'        => "STAFF_COLLECTION",
                    'au_entry_hospital_pk_no' => $hospitalId,
                ]);
            }

            if (! empty($outError) && $outError !== '000') {
                DB::rollBack();
                return response()->json([
                    'msg'   => $outError,
                    'title' => 'Error',
                ], 400);
            }

            DB::commit();
            return response()->json([
                'msg'        => 'Staff Benefits Save Successfully',
                'title'      => 'Success',
                'invoice_no' => $staffInvoiceNoPk,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg'   => $e->getMessage(),
                'title' => 'Staff Benefits Save Failed',
            ], 500);
        }
    }

    public function list(Request $request)
    {
        $fincSbLedgerDetals     = DB::table('finc_arstaffledger_vw')->orderByDesc('arstaffledgerdtl_date')->get();
        $staffBenefitsDtlGroups = DB::table('finc_arstaffledger_groupvw')
            ->select('debtor_code', 'debtor_name')
            ->orderByDesc('arstaffledgerdtl_date')
            ->get();

        return Template::loadView('admin.accounts.staff_benefits.list', compact('fincSbLedgerDetals', 'staffBenefitsDtlGroups'));
    }

    public function staffBenefitsListData(Request $request)
    {
        $debtor_code = $request->debtor_code;
        $debtor_name = $request->debtor_name;

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to   = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : '';

        $sql_cond = "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $debtor_code != "" ? " $clause debtor_code = '$debtor_code'" : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $debtor_name != "" ? " $clause debtor_code = '$debtor_name'" : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(arstaffledgerdtl_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";

        $table      = 'finc_arstaffledger_groupvw';
        $primaryKey = 'ar_invoice_no_pk';

        $columns = [
            ['db' => 'ar_invoice_no_pk', 'dt' => 0],
            ['db' => 'arstaffledgerdtl_date', 'dt' => 1],
            ['db' => 'amount', 'dt' => 2],
            ['db' => 'debtor_code', 'dt' => 3],
            ['db' => 'debtor_name', 'dt' => 4],
        ];

        if (! empty($sql_cond)) {
            return json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            return json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function staffBenefitsListDetails($id)
    {
        $fincStaffBenefitsDetals = DB::table('finc_arstaffledger_vw')->where('ar_invoice_no_pk', $id)->get();

        if (count($fincStaffBenefitsDetals) == 0) {
            abort(404, 'Not Found!');
        }

        $totalAmount = $fincStaffBenefitsDetals->sum('amount');

        $numberToWords     = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $amountInWords = $numberTransformer->toWords($totalAmount);
        $amountInWords = ucwords(str_replace('-', ' ', $amountInWords));

        $firstData = $fincStaffBenefitsDetals->first();

        return view('admin.accounts.staff_benefits.details', compact('fincStaffBenefitsDetals', 'totalAmount', 'amountInWords', 'firstData'));
    }
}
