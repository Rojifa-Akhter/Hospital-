
<style>
    .fs-12{
        font-size: 12px;
    }
</style>
<section>
    <div class="row">
        <div class="col-md-6">
            <h6 class="text-left fs-12"><b>Voucher Type:</b> {{$integration_details[0]->voucher_type_name}}</h6>
            <h6 class="text-left fs-12"><b>Module :</b> {{$integration_details[0]->module_name}}</h6>  
            <h6 class="text-left fs-12"><b>TRN Type:</b> {{$integration_details[0]->trn_type_name}}</h6>  
           
        </div>
        <div class="col-md-6">
            <h6 class="text-right fs-12"><b>Store Name:</b> {{$integration_details[0]->serviceunit_name}}</h6>
            <h6 class="text-right fs-12"><b>Account SU Name:</b> {{$integration_details[0]->mserviceunit_name}}</h6>          
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-left">General Ledger</th>
                        <th class="text-left">Item Group</th>
                        <th>Dr/Cr</th>
                        <th class="text-left">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($integration_details as $item)
                            <tr>
                                <td class="text-left">{{$item->account_code}} - {{$item->account_name}}</td>
                                <td class="text-left">{{$item->item_type_name}}</td>
                                <td class="text-left">{{$item->trn_crdr_type}}</td>
                                <td class="text-left">{{$item->trn_dr_cr_account_percent}}</td>
                            </tr>
                        @empty
                            <tr colspan="4" class="text-center text-danger">Data Not Found</tr>
                        @endforelse                          
                </tbody>
            </table>
        </div>
    </div>
</section>
