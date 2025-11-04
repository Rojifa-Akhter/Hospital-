<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-9">
			<h5 class="mt-2 mb-0">Demand Entry</h5>
			<small>Edit Demand Entry</small>
		</div>
        <div class="col-md-3">
            <div id="top-action">

                <a  rel="tab" href="{{ route('demand_worklist') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;Demand Worklist</a>

            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5>Demand Entry</h5>
						</div>

						<div class="card-body mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="date">Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker" id="date" name="date"
                                                    value="{{ !empty($demand_items[0]->demand_date)? date('Y-m-d', strtotime($demand_items[0]->demand_date)):'' }}" placeholder="dd-mm-yyyy" >
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="fiscal_year" class="col-form-label col-form-label-sm">Fiscal Year <span class="text-danger">*</span></label>
                                                <select class="form-control dropdown " id="fiscal_year" name="fiscal_year" >
                                                 @if(!empty($fiscal_years))
                                                        @foreach($fiscal_years as $key => $fy)
                                                            <option value="{{ $key }}"
                                                                    @if(!empty($demand_items[0]->fiscal_year)
                                                                    && $demand_items[0]->fiscal_year == $key)
                                                                        selected
                                                                    @endif
                                                                    >{{ $fy['data'] }}</option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="item_category" class="col-form-label col-form-label-sm">Item Category <span class="text-danger">*</span></label>
                                            <select class="form-control dropdown" id="category_id" name="category_id" >
                                                @if(!empty($item_categories))
                                                    @foreach($item_categories as $key => $ic)
                                                        <option value="{{ $ic['data'] }}"
                                                                @if(!empty($demand_items[0]->item_category)
                                                                && $demand_items[0]->item_category == strtoupper($ic['data']))
                                                                selected
                                                                @endif
                                                                >{{ $ic['data'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 table-responsive mt-3" >
                                    <table class="table data-table  table-striped table-bordered table-hover">
                                        <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center ">SL</th>
                                            <th class="text-center">PVMS No</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">UOM</th>
                                            <th class="text-center ">Rate</th>
                                            <th class="text-center ">Item Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody id="demand_items">
                                            @if(!empty($demand_items))
                                                @foreach($demand_items as $di)
                                                    <tr>
                                                        <td class="sl-td">{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $di->pvms_no }}
                                                        </td>
                                                        <td>
                                                            {{ $di->item_name }}
                                                        </td>
                                                        <td>
                                                            {{ $di->uom_text }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $di->item_rate?: 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{$di->entry_qty?: 0 }}
                                                        </td>
                                                        </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>

    $(document).ready(function () {

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            startDate: new Date()
        });
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false,
            "searching":false
        });

        $(".dropdown").attr("disabled", "disabled");
        $("input").attr("disabled", "disabled");

    })










</script>
