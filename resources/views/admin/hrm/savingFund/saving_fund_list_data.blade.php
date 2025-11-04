<div class="col-md-12 table-responsive" id="sample-container">
    <table class="data-table table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">#SL</th>
                <th class="text-center" scope="col">Employee Id</th>
                <th class="text-center" scope="col">Name</th>
                <th class="text-center" scope="col">Department</th>
                <th class="text-center" scope="col">Designation</th>
                <th class="text-center" scope="col">Year/Month</th>
                <th class="text-center" scope="col">Amount</th>
                <th class="text-center" scope="col">Finalize</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="saving-container">
            @if(isset($saving_fund))
            @foreach($saving_fund as $sample_row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $sample_row->person_code}}</td>
                <td>{{ $sample_row->full_name}}</td>
                <td>{{ $sample_row->designation_name}}</td>
                <td>{{ $sample_row->serviceunit_name}}</td>
                <td>{{ $sample_row->salary_yyyymm}}</td>
                <td>{{ $sample_row->personal_savings_amount}}</td>
                <td class="text-center">
                    @if($sample_row->finalyzed_by_ind == 1)
                    <i class="fas fa-check-square"></i>
                    @endif
                </td>
                <td>
                    @if( !$sample_row->finalyzed_by_ind == 1 )
                    <button class="btn btn-md open-modal" data-modal="common-modal-md"
                    data-action="{{ route('hrm.edit-saving-fund',$sample_row->monthly_save_fund_no_pk) }}"
                    data-title="Edit saving fund" title="Edit Saving Fund"
                    id="editsavingFund"><i
                    class="fa fa-edit"></i></button>

                    <span onclick="deleteSavingFund(this)" class="btn-danger btn btn-sm delete_fund" id="delete_fund" ><i class="fa fa-trash" aria-hidden="true"></i>
                    </span>
                    <input type="hidden" name="fund_hdn_id" id="fund_hdn_id" value="{{$sample_row->monthly_save_fund_no_pk}}">
                    @endif
                </td>

            </tr>

            @endforeach
            @else
            <tr>
                <td colspan="8">
                    <div class="alert alert-warning m-2 border">No Data Found</div>
                </td>
            </tr>
            @endif


        </tbody>
        <tr>
            <th class="text-center" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-left" scope="col"></th>
            <th class="text-center" scope="col">
                @php
                $response_action = route('hrm.saving-fund-list');
                @endphp
                <form action="{{ route('hrm.update-saving-fund') }}" method="post"
                id="saving-create">
                <button type="submit" class="btn btn-md btn-success uhl_common_btn"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Finalize
            </button>
        </form>
    </th>
</tr>

</table>
</div>
