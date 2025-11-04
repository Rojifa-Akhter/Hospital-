<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Pharmacy</h5>
            <small>Pharmacy / Profit & Loss / Report</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="#" id="phar_profit_loss_search_frm">
                @csrf
            <div class="form-row justify-content-center">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="voucher_date_from">From Date / To Date</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="from_date" id="from_date" required value="{{date("Y-m-d")}}">
                            <input type="date" class="form-control" name="to_date" id="to_date" required value="{{date("Y-m-d")}}">
                            <input type="hidden" name="action_link" id="action_link" value="{{route('report.pharmacy-profit-loss')}}"/>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-4">
                    <div class="btn-group btn-block mt-4">
                        <button type="button" class="btn btn-md btn-success phar_profit_loss_html"><i class="fa fa-search"></i>&nbsp;Search</button>
                        <button type="button" class="btn btn-md btn-success phar_profit_loss_pdf"><i class="fa fa-search"></i>&nbsp;PDF</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12 table-responsive phar_profit_loss_search" style="padding:10px;">
                    <div class="voucher_loader pl-3 text-success" style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;position:relative;z-index:999;"><i class="fas fa-stroopwafel fa-spin"></i>
                                                   
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $(document).ready(function(){

        // document.querySelector('.day_book_search').addEventListener("click",function(){
        //     const from_date = document.querySelector('#from_date').value;
        //     const to_date = document.querySelector('#to_date').value;
        //     const action_link = document.querySelector('#action_link').value;
            
        //     document.querySelector('.daybook_search table').style.display = 'none';
        //     document.querySelector('.voucher_loader').style.display = 'block';

        //     const data = {
        //         _token: "{{ csrf_token() }}",
        //         from_date:from_date,
        //         to_date:to_date
        //     }
        //     fetch(action_link,{
        //         method: "POST",
        //         headers: {
        //             'Content-Type': 'application/json'
        //         },
        //         body: JSON.stringify(data)
        //     }).then(response => response.text()).then(data => {
        //         document.querySelector('.daybook_search').innerHTML = data;
        //         document.querySelector('.voucher_loader').style.display = 'none';
        //         document.querySelector('.daybook_search table').style.display = 'block';
        //     });

        // });

        document.querySelector('.phar_profit_loss_html').addEventListener("click", function(){
            const formid = document.querySelector('#phar_profit_loss_search_frm');
            formid.action = "{{route('report.profit_loss_rpt_html')}}"
            formid.target = '__blank'
            formid.submit();
        });

        document.querySelector('.phar_profit_loss_pdf').addEventListener("click", function(){
            const formid = document.querySelector('#phar_profit_loss_search_frm');
            formid.action = "{{route('report.profit_loss_rpt_pdf')}}"
            formid.target = '__blank'
            formid.submit();
        });

    })
</script>