<input type="hidden" value="" name="patient_id" id="hdn_patient_id">
<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs" id="my_tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active cursor-pointer" href="#receive" id="receive-tab-show" data-toggle="tab"  role="tab" aria-controls="receive-tab-show" onclick="DeliveryFunc.getReceptionData(this)"  data-tab-type="1" data-action="{{route('delivery.report-data')}}" aria-selected="false">Receive</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#delivery-pending" class="nav-link cursor-pointer" id="delivery-pending-show" data-toggle="tab" aria-controls="delivery-pending-show" onclick="DeliveryFunc.getReceptionData(this)" data-tab-type="2" data-action="{{route('delivery.report-data')}}" aria-selected="false">Delivery Pending</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#delivered" class="nav-link cursor-pointer" id="delivered-show" aria-controls="delivered-show" data-toggle="tab" onclick="DeliveryFunc.getReceptionData(this)" data-tab-type="3" data-action="{{route('delivery.report-data')}}" aria-selected="false">Delivered</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#report-status" class="nav-link cursor-pointer" id="status-show" aria-controls="status-show" data-toggle="tab" onclick="DeliveryFunc.getReceptionData(this)" data-tab-type="4" data-action="{{route('delivery.report-data')}}" aria-selected="false">Status Show</a>
        </li>
    </ul>


{{--    tabs --}}
    <div class="tab-content" id="my_tab_content">
        <div class="tab-pane fade active show" id="receive" role="tabpanel" aria-labelledby="receive-tab">
            @include('admin.radiology.process.delivery_receive')
        </div>
        <div class="tab-pane fade" role="tabpanel" id="delivery-pending" aria-labelledby="delivery-pending-tab">
            @include('admin.radiology.process.delivery_pending')
        </div>
        <div class="tab-pane fade" role="tabpanel" id="delivered" aria-labelledby="delivered-tab">
            @include('admin.radiology.process.report_delivered')
        </div>
        <div class="tab-pane fade" role="tabpanel" id="report-status" aria-labelledby="report-status-tab">
            @include('admin.radiology.process.report_status')
        </div>
    </div>
</div>
