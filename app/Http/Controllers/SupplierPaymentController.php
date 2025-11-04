<?php

namespace App\Http\Controllers;
use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use PDF;
use App;
use Session;
class SupplierPaymentController extends Controller
{
    public function supplierInfoAutocomplete(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $supplier_info = db::table("inv_supplier")
            ->select('supplier_no_pk', 'supplier_name', 'company_name', 'supplier_uid', 'cp_phone', 'mobile1')
            ->where('au_entry_hospital_pk_no', $hospital_id )
            ->whereraw(db::raw("(upper(supplier_uid) like '%$keyword%' or upper(supplier_name) like '%$keyword%' or cp_phone like '%$keyword%' )"))->get();

        $supplier_info_data = [];
        if (!empty($supplier_info)) {
            foreach ($supplier_info as $supplier) {
                $supplier_info_data[] = array(
                    'supplier_no_pk' => $supplier->supplier_no_pk,
                    'supplier_name' => $supplier->supplier_name,
                    'company_name' => $supplier->company_name,
                    'supplier_uid' => $supplier->supplier_uid,
                    'cp_phone' => $supplier->cp_phone,
                    'mobile1' => $supplier->mobile1,
                );
            }
            return $supplier_info_data;
        }
    }

    public function supplierPaymentWorklist()
    {
        $type = "payment";
        $toDate=date('Y-m-d');
        $payment_data = DB::table('inv_supplierpayment_po_vw')->whereDate('payment_date', '=', date('Y-m-d'))->where('payment_regular_ind',1)->get();
        $supplier_payment_arr=[];
        if (!empty($payment_data)) {
          foreach ($payment_data as $key => $value) {
            $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
          }
        }
        // dd($supplier_payment_arr);
        return Template::loadView('admin.supplier_payment.supplier_payment_worklist', [
            'type' => $type,
            'payment_data' => $supplier_payment_arr
        ]);
    }

    public function supplierFinalizeWorklist()
    {
        $type = "finalize";
        $finalize_data = DB::table('inv_supplierpayment_mst_vw')->get();
        return Template::loadView('admin.supplier_payment.supplier_payment_worklist', [
            'type' => $type,
            'finalize_data' => $finalize_data
        ]);
    }


    public function supplierDisbursementWorklist()
    {
        $type = "disbursement";
        $disbursement_data = DB::table('inv_supplierpayment_mst_vw')->get();
        return Template::loadView('admin.supplier_payment.supplier_payment_worklist', [
            'type' => $type,
            'disbursement_data' => $disbursement_data
        ]);
    }



    public function supplierPaymentWorklistVoucherSearch(Request $request)
    {
        // dd($request->all());
        $data = $request->data;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;


        $draft = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';

        if ($data == 'Draft') {
            $draft = 1;
        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        }

        // $sql_cond = "";
        $sql_cond = "where payment_regular_ind = 1";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($draft != "") ? " $clause prepared_ind= $draft" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = $challan_no" : "";
        // dd($sql_cond);
        if ($request->type == 'payment') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond"));
            // $payment_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
            // echo "select * from inv_supplierpayment_mst_vw $sql_cond";
            // die;
            // $payment_data = DB::table('inv_supplierpayment_po_vw')->whereDate('payment_date', '=', date('Y-m-d'))->where('payment_regular_ind',1)->get();

            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            // dd($supplier_payment_arr);
            return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
                'payment_data' => $supplier_payment_arr, 'type' => $type
            ]);
        }
        // elseif ($request->type == 'finalize') {
        //     $type = $request->type;
        //     $finalize_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'finalize_data' => $finalize_data, 'type' => $type
        //     ]);
        // } elseif ($request->type == 'disbursement') {
        //     $type = $request->type;
        //     $disbursement_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'disbursement_data' => $disbursement_data, 'type' => $type
        //     ]);
        // }
    }
    public function suppilerPaymentPrint(Request $request)
    {
        $data = $request->payment_status;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;

        $prepared = '';
        $issue = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';
        $toDate=date('Y-m-d');
        if ($data == 'Prepare') {
            $prepared = 1;
        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        }elseif ($data == 'issue') {
            $issue = 1;
        }

        // $sql_cond = "";
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($prepared != "") ? " $clause prepared_ind= $prepared" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($issue != "") ? " $clause issue_ind= $issue" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = '$challan_no'" : "";
        $sql_cond_date=  $sql_cond !="" ? "$sql_cond and payment_regular_ind = 1" : "where payment_date = '$toDate'  and  payment_regular_ind = 1";
        // dd($sql_cond);
        if ($request->type == 'payment') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond_date"));
            // $payment_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
            // echo "select * from inv_supplierpayment_mst_vw $sql_cond";
            // die;
            // $payment_data = DB::table('inv_supplierpayment_po_vw')->whereDate('payment_date', '=', date('Y-m-d'))->where('payment_regular_ind',1)->get();

            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            $barcode = new BarcodeGenerator();
            $barcode->setText(date('d/m/Y'));
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.supplier_payment.supplier_payment_worklist_print', [
                   'payment_data' => $supplier_payment_arr, 'type' => $type,'barcode_no'=>$barcode_no,'po_hospital_details'=>$po_hospital_details,'from_date'=>$from_date,'to_date'=>$to_date
                ])->setPaper('a4', 'portrait');
            return $pdf->download("supplier payment report.pdf", array("Attachment" => false));

        }
        // elseif ($request->type == 'finalize') {
        //     $type = $request->type;
        //     $finalize_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'finalize_data' => $finalize_data, 'type' => $type
        //     ]);
        // } elseif ($request->type == 'disbursement') {
        //     $type = $request->type;
        //     $disbursement_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'disbursement_data' => $disbursement_data, 'type' => $type
        //     ]);
        // }
    }

    public function suppilerPaymentSearchWorklist(Request $request)
    {

        //dd($request->all());
        $data = $request->payment_status;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;


        $prepared = '';
        $issue = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';

        if ($data == 'Prepare') {

            $prepared = 1;

        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        } elseif ($data == 'issue') {
            $issue = 1;
        }

        // $sql_cond = "";
        $sql_cond = "where payment_regular_ind = 1";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($prepared != "") ? " $clause prepared_ind= $prepared" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($issue != "") ? " $clause issue_ind= $issue" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = '$challan_no'" : "";
        // dd($sql_cond);
        if ($request->type == 'payment') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond"));
            // $payment_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
            // echo "select * from inv_supplierpayment_mst_vw $sql_cond";
            // die;
            // $payment_data = DB::table('inv_supplierpayment_po_vw')->whereDate('payment_date', '=', date('Y-m-d'))->where('payment_regular_ind',1)->get();
            // dd($payment_data);
            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            //dd('test');
            return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
                'payment_data' => $supplier_payment_arr, 'type' => $type,'payment_status'=>$data
            ]);
        }


        //dd($request->all());

        // $type = $request->type;
        // $hdn_supplier_id = $request->hdn_supplier_id;
        // $search_po = $request->search_po;
        // $search_bill = $request->search_bill;

        // if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
        //     $date_from = "$request->search_chalan_date_from"; //date('Y/m/d', strtotime($request->date_from));
        //     $date_to = "$request->search_chalan_date_to"; //date('Y/m/d', strtotime($request->date_to));
        // } else {
        //     $date_from = "";
        //     $date_to = "";
        // }

        // $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($hdn_supplier_id != "") ? " $clause supplier_no_fk=$hdn_supplier_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($search_po != "") ? " $clause purchaseorder_no_pk = $search_po" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($search_bill != "") ? " $clause bill_challan_number = $search_bill" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($date_from != "") ? " $clause trunc(supledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        // if ($request->type == 'payment') {
        //     $type = $request->type;
        //     $payment_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     // echo "select * from inv_supplierpayment_mst_vw $sql_cond";
        //     // die;
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'payment_data' => $payment_data, 'type' => $type
        //     ]);
        // } elseif ($request->type == 'finalize') {
        //     $type = $request->type;
        //     $finalize_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'finalize_data' => $finalize_data, 'type' => $type
        //     ]);
        // } elseif ($request->type == 'disbursement') {
        //     $type = $request->type;
        //     $disbursement_data = db::select(db::raw("select * from inv_supplierpayment_mst_vw $sql_cond"));
        //     return template::loadview('admin.supplier_payment.supplier_payment_worklist_table', [
        //         'disbursement_data' => $disbursement_data, 'type' => $type
        //     ]);
        // }
    }
    public function supplierAdvanceWorklist()
    {
        $type = "advance";
        $toDate=date('Y-m-d');
        $payment_data = DB::table('inv_supplierpayment_po_vw')->whereDate('payment_date', '=', date('Y-m-d'))->where('payment_advance_ind',1)->get();
        $supplier_payment_arr=[];
        if (!empty($payment_data)) {
          foreach ($payment_data as $key => $value) {
            $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
          }
        }
        // dd($supplier_payment_arr);
        return Template::loadView('admin.supplier_payment.supplier_advance_worklist', [
            'type' => $type,
            'payment_data' => $supplier_payment_arr
        ]);
    }
    public function suppilerAdvanceSearchWorklist(Request $request)
    {


        $data = $request->payment_status;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;
        $prepared = '';
        $issue = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';

        if ($data == 'Prepare') {
            $prepared = 1;
        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        } elseif ($data == 'issue') {
            $issue = 1;
        }

        $sql_cond = "where payment_advance_ind = 1";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($prepared != "") ? " $clause prepared_ind= $prepared" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($issue != "") ? " $clause issue_ind= $issue" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = '$challan_no'" : "";
        // dd($sql_cond);
        if ($request->type == 'advance') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond"));
            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            // dd($supplier_payment_arr);
            return template::loadview('admin.supplier_payment.supplier_advance_worklist_table', [
                'payment_data' => $supplier_payment_arr, 'type' => $type,'payment_status'=>$data
            ]);
        }

    }
    public function suppilerAdvancePrint(Request $request)
    {
        $data = $request->payment_status;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;

        $prepared = '';
        $issue = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';
        $toDate=date('Y-m-d');
        if ($data == 'Prepare') {
            $prepared = 1;
        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        }elseif ($data == 'issue') {
            $issue = 1;
        }

        // $sql_cond = "";
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($prepared != "") ? " $clause prepared_ind= $prepared" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($issue != "") ? " $clause issue_ind= $issue" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = '$challan_no'" : "";
        $sql_cond_date=  $sql_cond !="" ? "$sql_cond and payment_advance_ind = 1" : "where payment_date = '$toDate'  and  payment_advance_ind = 1";
        // dd($sql_cond);
        if ($request->type == 'advance') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond_date"));

            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            // dd($supplier_payment_arr);
            $barcode = new BarcodeGenerator();
            $barcode->setText(date('d/m/Y'));
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.supplier_payment.supplier_advance_worklist_print', [
                   'payment_data' => $supplier_payment_arr, 'type' => $type,'barcode_no'=>$barcode_no,'po_hospital_details'=>$po_hospital_details,'from_date'=>$from_date,'to_date'=>$to_date
                ])->setPaper('a4', 'portrait');
            return $pdf->download("supplier payment report.pdf", array("Attachment" => false));

        }
    }
    public function supplierDeductWorklist()
    {
        $type = "deduct";
        $toDate=date('Y-m-d');
        $payment_data = DB::table('inv_supplierpayment_po_vw')->whereDate('payment_date', '=', date('Y-m-d'))->where('payment_deduct_ind',1)->get();
        $supplier_payment_arr=[];
        if (!empty($payment_data)) {
          foreach ($payment_data as $key => $value) {
            $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
          }
        }
        // dd($supplier_payment_arr);
        return Template::loadView('admin.supplier_payment.supplier_deduct_worklist', [
            'type' => $type,
            'payment_data' => $supplier_payment_arr
        ]);
    }
    public function suppilerDeductSearchWorklist(Request $request)
    {
                $data = $request->payment_status;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;
        $prepared = '';
        $issue = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';

        if ($data == 'Prepare') {
            $prepared = 1;
        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        } elseif ($data == 'issue') {
            $issue = 1;
        }

        $sql_cond = "where payment_deduct_ind = 1";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($prepared != "") ? " $clause prepared_ind= $prepared" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($issue != "") ? " $clause issue_ind= $issue" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = '$challan_no'" : "";
        // dd($sql_cond);
        if ($request->type == 'deduct') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond"));
            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            // dd($supplier_payment_arr);
            return template::loadview('admin.supplier_payment.supplier_deduct_worklist_table', [
                'payment_data' => $supplier_payment_arr, 'type' => $type,'payment_status'=>$data
            ]);
        }

    }
    public function suppilerDeductPrint(Request $request)
    {
        $data = $request->payment_status;
        $supplier_id=$request->hdn_supplier_id;
        $from_date=$request->search_chalan_date_from ? date('Y-m-d',strtotime($request->search_chalan_date_from)) : "";
        $to_date=$request->search_chalan_date_to ? date('Y-m-d',strtotime($request->search_chalan_date_to)) : "";
        $po_no=$request->search_po;
        $challan_no=$request->search_bill;

        $prepared = '';
        $issue = '';
        $Finalize = '';
        $Paid = '';
        $Cancelled = '';
        $All = '';
        $toDate=date('Y-m-d');
        if ($data == 'Prepare') {
            $prepared = 1;
        } elseif ($data == 'Finalize') {
            $Finalize = 1;
        } elseif ($data == 'Paid') {
            $Paid = 1;
        } elseif ($data == 'Cancelled') {
            $Cancelled = 1;
        } elseif ($data == 'All') {
            $All = 1;
        }elseif ($data == 'issue') {
            $issue = 1;
        }

        // $sql_cond = "";
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($prepared != "") ? " $clause prepared_ind= $prepared" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($issue != "") ? " $clause issue_ind= $issue" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Finalize != "") ? " $clause finalized_ind = $Finalize" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Paid != "") ? " $clause po_fullpaid_ind= $Paid" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($Cancelled != "") ? " $clause cancel_ind = $Cancelled" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date !="") ? " $clause  payment_date between '$from_date' and  '$to_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date =="") ? " $clause payment_date = '$from_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($po_no != "" ) ? " $clause purchase_uid = $po_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($challan_no != "" ) ? " $clause bill_challan_number = '$challan_no'" : "";
        $sql_cond_date=  $sql_cond !="" ? "$sql_cond and payment_deduct_ind = 1" : "where payment_date = '$toDate'  and  payment_deduct_ind = 1";
        // dd($sql_cond);
        if ($request->type == 'deduct') {
            $type = $request->type;
            $payment_data = db::select(db::raw("select * from inv_supplierpayment_po_vw $sql_cond_date"));

            $supplier_payment_arr=[];
            if (!empty($payment_data)) {
              foreach ($payment_data as $key => $value) {
                $supplier_payment_arr[$value->supplier_no_pk.'_'.$value->supplier_name.'_'.$value->supplier_uid][]=$value;
              }
            }
            // dd($supplier_payment_arr);
            $barcode = new BarcodeGenerator();
            $barcode->setText(date('d/m/Y'));
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.supplier_payment.supplier_deduct_worklist_print', [
                   'payment_data' => $supplier_payment_arr, 'type' => $type,'barcode_no'=>$barcode_no,'po_hospital_details'=>$po_hospital_details,'from_date'=>$from_date,'to_date'=>$to_date
                ])->setPaper('a4', 'portrait');
            return $pdf->download("supplier payment report.pdf", array("Attachment" => false));

        }
    }

    public function supplierPaymentBill(){
        return Template::loadView("admin.supplier_payment.supplier_payment_bill");
    }
    public function supplierPaymentBillList(Request $request){

        $table = 'inv_supplierpayment_mst_vw';
        // Table's primary key
        $primaryKey = 'supledger_no_pk';
        // $where = "module_code = 'OPD' or module_code = 'OPDC'";

        $columns = array(
            array('db' => 'supledger_no_pk', 'dt' => 0),
            array('db' => 'supplier_name', 'dt' => 1),
            array('db' => 'supledger_no_uid', 'dt' => 2),
            array('db' => 'payment_amount', 'dt' => 3),
            array('db' => 'payment_deduct', 'dt' => 4),
            array('db' => 'payment_regular_ind', 'dt' => 5),
            array('db' => 'payment_advance_ind', 'dt' => 6),
            array('db' => 'payment_deduct_ind', 'dt' => 7),
            array('db' => 'payment_note', 'dt' => 8),
            array('db' => 'bill_challan_number', 'dt' => 9),
            array('db' => 'bill_challan_date', 'dt' => 10),
            array('db' => 'pay_mode', 'dt' => 11),
            array('db' => 'pay_cqcc_number', 'dt' => 12),
            array('db' => 'pay_cqcc_holder_name', 'dt' => 13),
            array('db' => 'pay_bank_name', 'dt' => 14),
            array('db' => 'payment_date', 'dt' => 15),
            array('db' => 'supplier_uid', 'dt' => 16),
            array('db' => 'po_amount', 'dt' => 17),
            array('db' => 'payment_discount', 'dt' => 18),

        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
        // return Template::loadView("admin.supplier_payment.supplier_payment_bill");
    }

    public function supplierPaymentBillListSearch(Request $request){

        $supp_id = $request->supp_id;
        $led_id = $request->ledger_id;
        // dd($led_id);
        // $full_bill = $request->full_paid;
        // $due_bill = $request->due_bill;
        // $all_paid = $request->all_paid;
        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $supp_id != "" ? " $clause supplier_no_pk = $supp_id" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $led_id != "" ? " $clause supledger_no_uid = $led_id" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(payment_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        //  dd($sql_cond);

        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $full_bill != "" ? "$clause ((urgent_fee + ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment = 0" : "";
        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";


        $table = 'inv_supplierpayment_mst_vw';
        // Table's primary key
        $primaryKey = 'supledger_no_pk';
        // $where = "module_code = 'OPD' or module_code = 'OPDC'";

        $columns = array(
            array('db' => 'supledger_no_pk', 'dt' => 0),
            array('db' => 'supplier_name', 'dt' => 1),
            array('db' => 'supledger_no_uid', 'dt' => 2),
            array('db' => 'payment_amount', 'dt' => 3),
            array('db' => 'payment_deduct', 'dt' => 4),
            array('db' => 'payment_regular_ind', 'dt' => 5),
            array('db' => 'payment_advance_ind', 'dt' => 6),
            array('db' => 'payment_deduct_ind', 'dt' => 7),
            array('db' => 'payment_note', 'dt' => 8),
            array('db' => 'bill_challan_number', 'dt' => 9),
            array('db' => 'bill_challan_date', 'dt' => 10),
            array('db' => 'pay_mode', 'dt' => 11),
            array('db' => 'pay_cqcc_number', 'dt' => 12),
            array('db' => 'pay_cqcc_holder_name', 'dt' => 13),
            array('db' => 'pay_bank_name', 'dt' => 14),
            array('db' => 'payment_date', 'dt' => 15),
            array('db' => 'supplier_uid', 'dt' => 16),
            array('db' => 'po_amount', 'dt' => 17),
            array('db' => 'payment_discount', 'dt' => 18),

        );
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }




}
