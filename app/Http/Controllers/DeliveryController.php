<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use DB;
use App\Repositories\BaseRepository;
use Auth;
use App\Models\DeliveryService;
use Session;
use App\Http\Requests\DeliveryServiceRequest;



class DeliveryController extends Controller
{
	private $model;
	public function __construct(DeliveryService $model)
	{
		$this->middleware('auth');
		$this->model = new BaseRepository($model);
	}
	public function getDeliveryManList()
	{
		$delivery_mans = DB::table('employee_info_vw')
		->where('user_type', 'dmn')
		->select('person_no_pk','person_code','full_name', 'phone_mobile', 'status')
		->get();
		return Template::loadview("admin.settings.delivery.delivery_man_list",[
			'delivery_mans'  => $delivery_mans
		]);
	}
	public function getAssignedOrderList()
	{
		$order_list = DB::table('ecom_order_list_vw')
		->select('ecom_delivery_no','order_no', 'customer_name', 'phone_mobile', 'order_date', 'address_name','delivery_men_no_fk', 'delivery_date', 'tot_amount', 'assign_name')->orderBy('order_no','ASC','delivery_date','ASC')->where('delivery_status', 0)->get();
		return Template::loadview("admin.settings.delivery.assigned_delivery_order_list",[
			'order_list'  => $order_list
		]);
		
	}
	public function getUnassignedOrderList()
	{
		$order_list = DB::table('ecom_order_list_vw')
		->select('order_no', 'customer_name', 'phone_mobile', 'order_date', 'address_name','tot_amount', 'assign_name')->orderBy('order_no','ASC')->where('delivery_status', null)->get();
		return Template::loadview("admin.settings.delivery.unassigned_delivery_order_list",[
			'order_list'  => $order_list
		]);
		
	}
	public function getPickedOrderList()
	{
		$order_list = DB::table('ecom_order_list_vw')
		->select('ecom_delivery_no','order_no', 'customer_name', 'phone_mobile', 'order_date', 'address_name','delivery_men_no_fk', 'delivery_date', 'tot_amount', 'assign_name')->orderBy('order_no','ASC','delivery_date','ASC')->where('delivery_status', 1)->get();
		return Template::loadview("admin.settings.delivery.picked_delivery_order_list",[
			'order_list'  => $order_list
		]);
	}

	public function getDeliveryInfo($id)
	{

		$delivery_mans = DB::table('employee_info_vw')
		->where('user_type', 'dmn')
		->select('person_no_pk','full_name')
		->get();
		return Template::loadview("admin.settings.delivery.delivery_info_form",[
			'delivery_mans'  => $delivery_mans,
			'order_id' => $id
		]);


	}
	public function updateDeliveryInfo($delivery_no)
	{
		$delivery_man_info = DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $delivery_no)->first();
		$delivery_mans = DB::table('employee_info_vw')
		->where('user_type', 'dmn')
		->select('person_no_pk','full_name')
		->get();
		return Template::loadview("admin.settings.delivery.delivery_info_update_form",[
			'delivery_mans'  => $delivery_mans,
			'delivery_id' => $delivery_no,
			'delivery_man_info' => $delivery_man_info
		]);


	}

	public function createDelivery(DeliveryServiceRequest $request)
	{
		DB::beginTransaction();
		try{
			$sequence = DB::getSequence();
			$delivery_service_no_pk_seq = $sequence->nextValue('delivery_service_no_pk_seq');
			$delivery_info = [];
			$delivery_info = [
				'delivery_service_no_pk' => $delivery_service_no_pk_seq,
				'order_no_fk' => $request->order_id,
				'delivery_men_no_fk' => $request->delivery_man,
				'status' => 0,
				'delivery_assigned' => date('Y-m-d'),
				'delivery_date' => date('Y-m-d', strtotime($request->date_pic)),
				'au_entry_at' => date('Y-m-d'),
				'au_entry_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
				'au_entry_session' => 'hospital',
				'au_entry_by'=> Auth::id()
			];
			$this->model->insert($delivery_info);

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		}
		catch (\Exception $e)
		{
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);

	}
	public function updateDelivery(DeliveryServiceRequest $request)
	{
		DB::beginTransaction();
		try{
			$id = $request->delivery_id;
			$delivery_info = [];
			$delivery_info = [
				'delivery_men_no_fk' => $request->delivery_man,
				'delivery_assigned' => date('Y-m-d'),
				'delivery_date' => date('Y-m-d', strtotime($request->date_pic)),
				'au_entry_at' => date('Y-m-d'),
				'au_entry_by'=> Auth::id()
			];
			DB::table('ecom_delivery_service')->where('delivery_service_no_pk',$id)->update($delivery_info);

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		}
		catch (\Exception $e)
		{
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);

	}
	public function getCancelledOrderList()
	{
		$order_list = DB::table('ecom_order_list_vw')
		->select('ecom_delivery_no','order_no', 'customer_name', 'phone_mobile', 'order_date', 'address_name','delivery_men_no_fk', 'canceled_date', 'tot_amount', 'assign_name')->orderBy('order_no','ASC','delivery_date','ASC')->where('delivery_status', 3)->get();
		return Template::loadview("admin.settings.delivery.cancelled_delivery_order_list",[
			'order_list'  => $order_list
		]);
	}
	public function getDeliveredOrderList()
	{
		$order_list = DB::table('ecom_order_list_vw')
		->select('ecom_delivery_no','order_no', 'customer_name', 'phone_mobile', 'order_date','address_name', 'delivery_men_no_fk', 'delivered_date', 'tot_amount', 'assign_name')->orderBy('order_no','ASC','delivery_date','ASC')->where('delivery_status', 2)->get();
		return Template::loadview("admin.settings.delivery.delivered_order_list",[
			'order_list'  => $order_list
		]);
	}
	public function getItemInfo($id)
	{
		$item_details = DB::table('ecom_order_items')
		->where('order_no_fk', $id)
		->select('product_name','quantity', 'product_price')
		->get();
		return Template::loadview("admin.settings.delivery.item_details",[
			'item_details'  => $item_details
		]);


	}


}
