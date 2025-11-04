<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <style>
        .ui-autocomplete-loading {
            background: url("{{ asset('demo_images/ui-anim_basic_16x16.gif') }}") no-repeat right center;
        }

    </style>
<style>
<style>
    .ui-autocomplete {
        height: 300px;
        overflow-y: scroll;
    }
    </style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Supplier Ledger Statement</h5>
            <small>Accounts / Reports / Ledger Statement</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="{{route('accounts.show-supplier-ledger-statement')}}" target="__blank" id="day_book_search_frm">
                @csrf
            <div class="form-row justify-content-center">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="received_form" class="col-form-label">Select supplier</label>
                        <div class="input-group">

                            <input type="text" class="form-control"  name="acc_code" id="acc_code" placeholder="Supplier" style="margin-bottom:0px!important" required>
                            <input type="hidden" class="form-control"  name="hid_acc_code" id="hid_acc_code">
                            <input type="hidden" class="form-control"  name="hid_acc_name" id="hid_acc_name">
                        </div>

                    </div>
                </div>
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
                        {{-- <button type="button" class="btn btn-md btn-success day_book_pdf"><i class="fa fa-file-pdf"></i>&nbsp;Export PDF</button> --}}
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){

        $("#acc_code").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-supplier-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {
                            

                            return {

                                value: row.supplier_name+"-"+row.supplier_no_pk,

                                label: row.supplier_name,

                                item_id: row.supplier_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {
                
                $('#hid_acc_code').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        // $.ajax({
        //         url: "{{route('accounts.autocomplete-transection-head')}}",
        //         method:"get",
        //         success: function(response) {
        //             let availableTags = [];
        //             Array.from(response.data).forEach(accounthead => {
                        
        //                 availableTags.push(
        //                     accounthead
        //                 )
                        
        //             })
        //             $( "#acc_code" ).autocomplete({
        //                 source: availableTags,
        //                 select: function(event, ui) {
                            
        //                     let account_info = ui.item.value.split('-');
        //                     //$('#cash_cr_account_code').val(account_info[0]);
        //                     //$('#cash_cr_account_name').val(account_info[1]);
        //                     $('#cash_account_description').attr('data-acc_code',account_info[0]);
        //                     $('#cash_account_description').attr('data-acc_name',account_info[1]);
                            
        //                 },
        //             });


        //             $('body').on('blur',"#acc_code", function(){
        //                 let account_info = $(this).val().split('-');
                        
        //                 $('#hid_acc_code').val(account_info[0]);
        //                 $('#hid_acc_name').val(account_info[1]);
        //             });
        //         }
                
        // });
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

        // document.querySelector('.day_book_pdf').addEventListener("click", function(){
        //     const formid = document.querySelector('#day_book_search_frm');
        //     formid.action = "{{route('accounts.show-day-book')}}"
        //     formid.target = '__blank'
        //     formid.submit();
        // })

    })
</script>