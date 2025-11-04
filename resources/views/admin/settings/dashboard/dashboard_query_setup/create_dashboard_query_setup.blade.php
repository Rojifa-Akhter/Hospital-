@php
$items = isset($item) && !empty($item) ? $item : [];

$id = $items ? $items->dash_board_item_query_no_pk : '';
$dash_board_item_query = $items ? $items->dash_board_item_query : '';
$db_item_no_fk = $items ? $items->db_item_no_fk : '';
$where_clause = $items ? $items->where_clause : '';
$where_clause_column = $items ? $items->where_clause_column : '';
$detail_query = $items ? $items->detail_query : '';
$no_of_detail_column = $items ? $items->no_of_detail_column : '';
$compariso_query = $items ? $items->compariso_query : '';

// {{ dd($serviceunit) }}

@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('dashboard-item-query-setup.store') }}" method="post" id="dashboard-item-create">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Item Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <select name="db_item_no_fk" class="form-control" id="">
                    <option value="">Selec One</option>
                    @if (!empty($item_list))
                        @foreach ($item_list as $data)
                            <option value="{{ $data->dash_board_item_set_no_pk }}"
                                {{ $db_item_no_fk == $data->dash_board_item_set_no_pk ? 'selected' : '' }}>
                                {{ $data->dashboard_items }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">SQL Query<span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <textarea class="form-control form-control-sm" rows="10" id="dash_board_item_query" name="dash_board_item_query"
                    placeholder="Enter SQL Query" required>{{ $dash_board_item_query }}</textarea>
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Comparison SQL Query</label>
            <div class="col-sm-12">
                <textarea class="form-control form-control-sm" rows="10" id="compariso_query" name="compariso_query"
                    placeholder="Enter SQL Query" >{{ $compariso_query }}</textarea>
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Where Clause</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="where_clause" name="where_clause"
                    value="{{ $where_clause }}" placeholder="Enter Where Clause" >
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Where Clause Column
               </label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="where_clause_column"
                    name="where_clause_column" value="{{ $where_clause_column }}" placeholder="Enter Where Clause Column"
                    >
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Detail Query</label>
            <div class="col-sm-12">
                <textarea type="text" class="form-control form-control-sm" id="detail_query" name="detail_query"
                    placeholder="Enter Detail Query">{{ $detail_query }}</textarea>
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">No Of Columns </label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="no_of_detail_column"
                    name="no_of_detail_column" value="{{ $no_of_detail_column }}" placeholder="Enter No Of Columns"
                    >
                <span class="focus_input"></span>
            </div>

        </div>




        <div class="modal-footer float-right mt-1">
            <button type="button" class="btn  btn-md btn-danger mr-auto" data-dismiss="modal">Cancel</button>

            @php
                $response_action = route('dashboard-item-query-setup.index');
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
        </div>
    </form>
</div>
