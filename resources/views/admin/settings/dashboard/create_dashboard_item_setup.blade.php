@php
$items = isset($item) && !empty($item) ? $item : [];

$id = $items ? $items->dash_board_item_set_no_pk : '';
$dashboard_items = $items ? $items->dashboard_items : '';
$dashboard_value = $items ? $items->dashboard_value : '';
$card_ind = $items ? $items->card_ind : '';
$chart_ind = $items ? $items->chart_ind : '';
$text_ind = $items ? $items->text_ind : '';
$drill_down_ind = $items ? $items->drill_down_ind : '';

$status = $items ? $items->status : '';
// {{ dd($serviceunit) }}
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('dashboard-item-setup.store') }}" method="post" id="dashboard-item-create">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Item Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="dashboard_item_name"
                    name="dashboard_item_name" value="{{ $dashboard_items }}" placeholder="Enter Item Name" required>
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="dashboard_value" class="col-sm-12 col-form-label col-form-label-sm">Item Value </label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="dashboard_item_value"
                    name="dashboard_item_value" value="{{ $dashboard_value }}" placeholder="Enter Item Name" >
                <span class="focus_input"></span>
            </div>

        </div>



        <div class="form-row">
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="card_ind" id="card_ind" value="1"
                        {{ $card_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="card_ind">Card</label>
                </div>

            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="chart_ind" id="chart_ind" value="1"
                        {{ $chart_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="chart_ind">Chart</label>
                </div>

            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="text_ind" id="text_ind" value="1"
                        {{ $text_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="text_ind">Text </label>
                </div>
            </div>

            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="drill_down_ind" id="drill_down_ind" value="1"
                        {{ $drill_down_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="drill_down_ind">Drill Down Ind </label>
                </div>
            </div>
            <div class="col-md-4 mb-2">

                <div class="form-check form-check-inline">
                    <input class="form-check-input ml-1" type="checkbox" name="status" id="status" value="1"
                        {{ $status == '1' ? 'checked' : '' }}>
                    <label for="status" class="form-check-label">Status</label>

                </div>
            </div>
        </div>

        <div class="modal-footer float-right mt-1">
            <button type="button" class="btn  btn-md btn-danger mr-auto" data-dismiss="modal">Cancel</button>

            @php
                $response_action = route('dashboard-item-setup.index');
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
        </div>
    </form>
</div>
