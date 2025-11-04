<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Summery</h5>
            <small>Accounts / Reports / Summery</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="#" id="day_book_search_frm">
                @csrf
            <div class="form-row justify-content-center">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="voucher_date_from">From Year / To Year</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="from_year" id="from_year" required value="{{date("Y")}}">
                            <input type="text" class="form-control" name="to_year" id="to_year" required value="{{date("Y")}}">
                            <input type="hidden" name="action_link" id="action_link" value="{{route('accounts.accounts-summery-print')}}"/>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-4">
                    <div class="btn-group btn-block mt-4" role="group">
                        <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0 day_book_pdf" id="jobCard"
                            onclick=""> <i class="fas fa-search"></i> Search</button>
                        <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                            value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
                    </div>
                    {{-- <div class="btn-group btn-block mt-4">
                        <button type="button" class="btn btn-md btn-success day_book_pdf"><i class="fa fa-search"></i>&nbsp;Search</button>
                        <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                                    value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
                    </div> --}}
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

        document.querySelector('.day_book_pdf').addEventListener("click", function(){
            const formid = document.querySelector('#day_book_search_frm');
            formid.action = "{{route('accounts.accounts-summery-print')}}"
            formid.target = '__blank'
            formid.submit();
        })


        $(document).on("click", ".print", function(e) {
            var print = $(this).val();

            if (print == 2) {
                const formid = document.querySelector('#day_book_search_frm');
                formid.action = "{{route('accounts.accounts-summery-excel')}}"
                formid.target = '__blank'
                formid.submit();
            }
        });

    })
</script>