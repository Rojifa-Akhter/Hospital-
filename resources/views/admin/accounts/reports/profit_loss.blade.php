<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Profit & Loss Statment</h5>
            <small>Accounts / Reports / Profit & Loss Statement</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="{{route('accounts.show-profit-loss')}}" target="__blank" id="day_book_search_frm">
                @csrf
            <div class="form-row justify-content-center">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="voucher_date_from">From Date / To Date</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="from_date" id="from_date" required value="{{date("Y-m-d")}}">
                            <input type="date" class="form-control" name="to_date" id="to_date" required value="{{date("Y-m-d")}}">
                            <input type="hidden" name="action_link" id="action_link" value="{{route('accounts.daybook_search')}}"/>
                        </div>
                    </div>
                </div>

                

                

                <div class="col-md-4">
                    <div class="btn-group btn-block mt-4">
                        <button type="submit" class="btn btn-md btn-success day_book_search"><i class="fa fa-search"></i>&nbsp;Search</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>


    {{-- <div class="card">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12 table-responsive daybook_search" style="padding:10px;">
                    <div class="voucher_loader pl-3 text-success" style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;position:relative;z-index:999;"><i class="fas fa-stroopwafel fa-spin"></i>
                                                   
                    </div>
                    <table class="table mb-0">
                        <thead>
                            <tr class="bg-primary">
                                <th class="text-center w-5">SL</th>
                                <th class="text-center w-10">Date</th>
                                <th class="text-left w-10">Voucher No</th>
                                <th class="text-left">Particulars</th>
                                <th class="text-center w-10">Debit</th>
                                <th class="text-center w-10">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6"><h4 style="text-align:center;">No Data Found</h4></td>
                            </tr>
                            

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}


</div>
<script>
    $(document).ready(function(){})
</script>