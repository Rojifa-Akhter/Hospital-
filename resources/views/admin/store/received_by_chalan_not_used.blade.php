<div class="tab-pane fade show active" id="received-by-challan" >
    <div class="row">
        <div class="col-12 px-0">
            <div class="card">
                <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('serach_receive') }}" method="POST" id="chalan-receive-search">
                        <input type="hidden" name="receive_type" value="chalan">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="received-by-challan-challan-no">Challan No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="received-by-challan-challan-no" name="search_chalan_no" value="" placeholder="Challan No" >
                            </div>

                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="received-by-challan-date-form">Challan Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Form</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-challan-date-from" name="search_chalan_date_from" value="" placeholder="yyyy-mm-dd" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-challan-date-to" name="search_chalan_date_to" value="" placeholder="yyyy-mm-dd" >
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="received-by-challan-year">Year</label>
                                <select class="form-control select2" id="received-by-challan-year" name="search_year">
                                    <option value="">Select Year</option>
                                    @if(!empty($search_fiscal_year))
                                        @foreach($search_fiscal_year as $key => $sfy)
                                            <option value="{{ $key }}">{{ $sfy['data'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="received-by-challan-quarter">Quarter</label>
                                <select class="form-control select2" id="received-by-challan-quarter" name="search_quarter">
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
                                    <button type="button" onclick="generateSearch( this, 'chalan-receive-search', '{{ route('serach_receive') }}', 'crl' )" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                    <a href="{{ route('item_receive') }}" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" id="crl">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive" >
                            <table class="table data-table table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Challan Date</th>
                                    <th class="text-center">Challan No</th>
                                    <th class="text-center">Fiscal Year </th>
                                    <th class="text-center">Quarter</th>
                                    <th class="text-center">No of Item</th>
                                    <th class="text-center">Received Item</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(!empty($received_by_chalan))
                                    @foreach($received_by_chalan as $rbc)
                                        @php
                                            $badgeStatus = '';
                                            switch($rbc->receive_status_text){
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
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ !empty($rbc->challan_date)? date('d/m/Y', strtotime($rbc->challan_date)): 'N/A' }}</td>
                                            <td class="text-left"> {{ $rbc->challan_no ?: 'N/A'}}</td>
                                            <td class="text-left"> {{ $rbc->fiscal_year ?: 'N/A'}}</td>
                                            <td class="text-left"> {{ $rbc->year_quarter ?: 'N/A'}}</td>
                                            <td class="text-right"> {{ $rbc->no_of_item ?: 'N/A'}}</td>
                                            <td class="text-right"> {{ $rbc->sum_received_item_qty ?: 'N/A'}}</td>
                                            <td class="text-center"> <span class="badge {{ $badgeStatus }}">{{ $rbc->receive_status_text ?: 'N/A'}}</span></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-info" title="Details"><i class="fas fa-book-open"></i></a>
                                                <a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a>
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