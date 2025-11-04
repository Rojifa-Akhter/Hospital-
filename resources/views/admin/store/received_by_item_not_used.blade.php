<div class="tab-pane fade show active" id="received-by-item">

    <div class="row">
        <div class="col-12 px-0">
            <div class="card">
                <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="#" method="POST" id="item-receive-search">
                        <input type="hidden" name="receive_type" value="item">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="received-by-item-challan-no">Challan No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="received-by-item-challan-no" name="search_chalan_no" value="" placeholder="Challan No">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="received-by-item-date-from">Challan Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Form</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-item-date-from" name="search_chalan_date_from" value="" placeholder="yyyy-mm-dd" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-item-date-to" name="search_chalan_date_to" value="" placeholder="yyyy-mm-dd" >
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="received-by-item-year">Year</label>
                                <select class="form-control " id="received-by-item-year" name="search_year">
                                    <option value="">Select Year</option>
                                    @if(!empty($search_fiscal_year))
                                        @foreach($search_fiscal_year as $key => $sfy)
                                            <option value="{{ $key }}">{{ $sfy['data'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="received-by-item-year-quarter">Quarter</label>
                                <select class="form-control " id="received-by-item-year-quarter" name="search_quarter">
                                    <option value="">Select Quarter</option>
                                    @if(!empty($search_quarter))
                                        @foreach($search_quarter as $key => $sq)
                                            <option value="{{ $key }}">{{ $sq['data'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" onclick="generateSearch( this, 'item-receive-search', '{{ route('serach_receive') }}', 'irl' )" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                    <a  href="{{ route('item_receive_by_item') }}" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" id="irl">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive" >
                            <table class="table data-table table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Challan Date</th>
                                    <th class="text-center">Challan No</th>
                                    <th class="text-center">PVMS</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">A/U</th>
                                    <th class="text-center">Received Quantity</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($received_by_item))
                                        @foreach($received_by_item as $rbi)
                                            @php
                                                $badgeStatus = '';
                                                switch($rbi->receive_status_text){
                                                case "Partial Received":
                                                $badgeStatus = 'badge-primary';
                                                break;
                                                case "Received":
                                                $badgeStatus = 'badge-success';
                                                break;
                                                case "Closed":
                                                $badgeStatus = 'badge-danger';
                                                break;
                                                default:
                                                $badgeStatus = 'badge-warning';
                                                }

                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ !empty($rbi->challan_date)? date('d/m/Y', strtotime($rbi->challan_date)): 'N/A' }}</td>
                                                <td class="text-left">{{ $rbi->challan_no ?: 'N/A' }}</td>
                                                <td class="text-left">{{ $rbi->pvms_no ?: 'N/A' }}</td>
                                                <td class="text-left">{{ $rbi->item_name ?: 'N/A'}}</td>
                                                <td class="text-left">{{ $rbi->uom_short ?: 'N/A'}}</td>
                                                <td class="text-right">{{ $rbi->received_quantity ?: 'N/A'}}</td>
                                                <td class="text-center"><span class="badge {{ $badgeStatus }}">{{ $rbi->receive_status_text ?: 'N/A'}}</span> </td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-sm btn-info" title="Details"><i class="fas fa-book-open"></i></a>
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