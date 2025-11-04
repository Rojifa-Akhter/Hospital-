<?php
/**
 * Created by Nazim.
 * User: Nazim
 * Date: 8/10/2020
 * Time: 6:21 PM
 */

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
trait HospitalStoreData
{

    protected function receiveByChalanOrItem(Request $request)
    {
        $receives = [];

        if ($request->has('type') && $request->type == 'chalan') {

            $receives = $this->receiveByChalan($request);

        }
        if ($request->has('type') && $request->type == 'item') {

            $receives = $this->receiveByItem($request);
        }



        return $receives;
    }
    protected function pharmacy_receiveByChalanOrItem(Request $request)
    {
        $receives = [];

        if ($request->has('type') && $request->type == 'chalan') {
           
            $receives = $this->pharmacy_receiveByChalan($request);

        }
        if ($request->has('type') && $request->type == 'item') {

            $receives = $this->pharmacy_receiveByItem($request);
        }



        return $receives;
    }
    protected function cafe_optical_receiveByChalanOrItem(Request $request)
    {
        $receives = [];           
            $receives = $this->cafe_optical_receiveByChalan($request);
        return $receives;
    }

    protected function receiveByItem(Request $request)
    {
        $query = DB::table('phr_itemreceive_item_vw')->where('au_entry_hospital_no_fk',Session::get('user.ses_hospital_no_pk'))->where('module_code','INVENTORY');

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no','like', '%'.$request->search_chalan_no.'%');
        }
        if (!empty($request->po_data)) {
            $query->where('fiscal_year', $request->po_data);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('challan_date', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('challan_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }

        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }

        return $query->get()->toArray();

    }

    protected function receiveByChalan(Request $request)
    {

        $query = DB::table('phr_itemreceive_challan_vw')->where('au_entry_hospital_no_fk',Session::get('user.ses_hospital_no_pk'))->where('module_code','INVENTORY');

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no','like', '%'.$request->search_chalan_no.'%');
        }
        if (!empty($request->search_year)) {
            $query->where('fiscal_year', $request->search_year);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('challan_date', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('challan_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }

        if (!empty($request->po_data)) {
            $query->where('demand_no_fk','like', '%'.$request->po_data.'%');
        }



        if (!empty($request->search_po_date)) {
            $query->whereDate('au_entry_at', '=', date('Y-m-d', strtotime($request->search_po_date)));
        }

        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }


        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }

        return $query->get()->toArray();
    }
       protected function pharmacy_receiveByItem(Request $request)
    {
        $query = DB::table('phr_itemreceive_item_vw')->where('au_entry_hospital_no_fk',Session::get('user.ses_hospital_no_pk'))->where('module_code','PHR');

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no','like', '%'.$request->search_chalan_no.'%');
        }
        if (!empty($request->po_data)) {
            $query->where('fiscal_year', $request->po_data);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('challan_date', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('challan_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }

        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }

        return $query->get()->toArray();

    }

    protected function pharmacy_receiveByChalan(Request $request)
    {

        $query = DB::table('phr_itemreceive_challan_vw')->where('au_entry_hospital_no_fk',Session::get('user.ses_hospital_no_pk'))->where('module_code','PHR');

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no','like', '%'.$request->search_chalan_no.'%');
        }
        if (!empty($request->search_year)) {
            $query->where('fiscal_year', $request->search_year);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('au_entry_at', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('au_entry_at', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to.' +1 day')));
        }

        if (!empty($request->po_data)) {
            $query->where('demand_no_fk','like', '%'.$request->po_data.'%');
        }



        if (!empty($request->search_po_date)) {
            $query->whereDate('au_entry_at', '=', date('Y-m-d', strtotime($request->search_po_date)));
        }

        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }


        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }

        return $query->get()->toArray();
    }
    protected function cafe_optical_receiveByChalan(Request $request)
    {       
        $query = DB::table('phr_itemreceive_challan_vw')->where('au_entry_hospital_no_fk',Session::get('user.ses_hospital_no_pk'))->whereIn('module_code',['CAFE','OPTICAL']);

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no','like', '%'.$request->search_chalan_no.'%');
        }
        if (!empty($request->search_year)) {
            $query->where('fiscal_year', $request->search_year);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('au_entry_at', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('au_entry_at', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to.' +1 day')));
        }
        if (!empty($request->po_data)) {
            $query->where('demand_no_fk','like', '%'.$request->po_data.'%');
        }
        if (!empty($request->grn_no)) {
            $query->where('itemreceive_no_pk',$request->grn_no);
        }
        if (!empty($request->search_po_date)) {
            $query->whereDate('au_entry_at', '=', date('Y-m-d', strtotime($request->search_po_date)));
        }
        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }

        return $query->orderBy('au_entry_at','desc')->get()->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getItemAutocompleteList($serchWord)
    {
        $keyword = strtoupper($serchWord);
        $item_info = DB::table("sys_serviceitem")
            ->select('item_no_pk','item_uid','item_name','barcode_no','pvms_no')
            ->where('item_name', 'like', '%'.$keyword.'%')
            ->orWhere('pvms_no', 'like', '%'.$keyword.'%')
            ->orWhere('barcode_no', 'like', '%'.$keyword.'%')
            ->orWhere('item_uid', 'like', '%'.$keyword.'%')
            ->get();

        $item_data = [];
        if(!empty($item_info))
        {
            foreach ($item_info as $item) {
                $item_data[] =  [
                    'item_id'        => $item->item_no_pk,
                    'item_uid'    => $item->item_uid,
                    'item_name'      => $item->item_name,
                    'barcode_no'      => $item->barcode_no,
                    'pvms_no' => $item->pvms_no
                ];
            }
            return $item_data;
        }

    }
}
