<style>
    .center{
        display: flex;
        justify-content: center;
    }
    .preview-border{
        border: 1px dotted #B4B5B6;
        border-radius: 5px;
    }
    .datepicker-dropdown{
        width: 200px !important;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Finalize Voucher</h5>
            <small>Accounts / Verification / Finalize Voucher</small>
        </div>
    </div>


    <div class="card">
        <form method="post" id="voucher_list" action="{{route('accounts.show-journals-finalize')}}">
            @csrf
            <div class="card-body p-2">
                <div class="row gx-1">
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="voucher_date_from">Voucher Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control search_date" name="date_from" id="date_from">
                                <input type="text" class="form-control search_date" name="date_to" id="date_to">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="voucher_no">Voucher No</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="voucher_no" id="voucher_no" placeholder="Voucher No">
                                <select class="form-control" id="voucher_type" name="voucher_type">
                                    <option value="">All Voucher Type</option>
                                    @foreach($voucher_type->getData()->data as $type)
                                        @if($type->status == 1)
                                            <option value="{{$type->voucher_type_no_pk}}">{{$type->voucher_type_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label for="cheque_no">Cheque No</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="Cheque No">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label for="cheque_date">Cheque Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control cheque_date" name="cheque_date" id="cheque_date" placeholder="Cheque Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-6">
                        <div class="form-group">
                            <label for="cheque_date">Status</label>                
                            <select type="text" class="form-control" name="status" id="status">
                                <option value="">All</option>
                                <option value="1">Finalized</option>
                                <option value="0">Not Finalized</option>
                            </select>
                           
                        </div>
                    </div>

                    <div class="col-md-1 col-6" >
                        <div class="form-group">
                            <label for="cheque_date"></label>  <br>              
                            <button class="btn btn-md btn-success" id="search_voucher_finalize" type="button">Search</button>
                           
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <div class="voucher_loader pl-3 text-success" style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;position:relative;z-index:999;"><i class="fas fa-stroopwafel fa-spin"></i>
                                                   
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive show_vouchers_info" style="padding:10px; text-align:center; font-weight:bold;">
                    NO DATA FOUND
                </div>
            </div>
        </div>
    </div>

    <div class="card p-2" id="journal_preview_card">
        <div class="card-body center preview-border" id="preview_journal">
            <div class="my-5" id="prevShow">
                <div class="text-center"><strong>Preview not available.</strong></div>
                <div class="text-center"> Please click on voucher no to preview</div>
            </div>
        </div>
    </div>


</div>

<script>

    $(document).ready(function(){
        var currentDate = new Date();
        $('.search_date').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
        }).datepicker('setDate', currentDate);
        
        $('.cheque_date').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
        });
    })
    

    document.querySelector('#search_voucher_finalize').addEventListener("click",function(){
    
        const action_link = document.querySelector('#voucher_list').getAttribute('action')
        const date_from = document.querySelector('#date_from').value
        const date_to = document.querySelector('#date_to').value
        const voucher_no = document.querySelector('#voucher_no').value
        const voucher_type = document.querySelector('#voucher_type').value
        const cheque_no = document.querySelector('#cheque_no').value
        const cheque_date = document.querySelector('#cheque_date').value
        const status = document.querySelector('#status').value;

        document.querySelector('.voucher_loader').style.display = 'block'
        document.querySelector('.show_vouchers_info').style.display = 'none'

        const data = {
            _token: "{{ csrf_token() }}",
            date_from: date_from,
            date_to: date_to,
            voucher_no: voucher_no,
            voucher_type: voucher_type,
            cheque_no: cheque_no,
            cheque_date: cheque_date,
            status: status
        }


        fetch(action_link, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        }).then(response => response.text()).then(data => {
            document.querySelector('.show_vouchers_info').style.display = 'block'
            document.querySelector('.show_vouchers_info').innerHTML = data;
            document.querySelector('.voucher_loader').style.display = 'none';

            const voucher_active_inactive = document.querySelectorAll('.voucher_active_inactive')
            Array.from(voucher_active_inactive).forEach(function(voucher){
                voucher.addEventListener("click", function(e){
                    
                    const voucher_no = e.target.getAttribute('data-voucher_no')
                    const url_link = e.target.getAttribute('action-link')
                    const finalized_ind = e.target.getAttribute('data-active')
                    const voucher_type = e.target.getAttribute('data-voucher_type')
                    const voucher_date = e.target.getAttribute('data-voucher_date')

                    e.target.nextElementSibling.style.display = 'block'
                    const data = {
                        finalized_ind: finalized_ind,
                        voucher_code: voucher_no
                    }
                    fetch(url_link+ '?'+ new URLSearchParams(data)
                    ).then(response => response.text()).then(data => {
                        const get_data = JSON.parse(data)
                        
                        if (get_data.data[0].finalized_ind == 0) {
                            e.target.setAttribute('data-active', get_data.data[0].finalized_ind)
                            e.target.classList.remove('badge-success')
                            e.target.classList.add('badge-danger');
                            e.target.textContent = 'NOT FINALIZED'
                            e.target.nextElementSibling.style.display = 'none'                       }

                        if (get_data.data[0].finalized_ind == 1) {
                            e.target.setAttribute('data-active', get_data.data[0].finalized_ind)
                            e.target.classList.remove('badge-danger');
                            e.target.classList.add('badge-success')
                            e.target.textContent = 'FINALIZED'
                            e.target.nextElementSibling.style.display = 'none'                        }
                    });

                });
            })
            

        })
    })

    function fetchJournal(journal_code,sl){
                $('td').removeClass('selected');
                $('.selectedCell'+sl).addClass('selected');
                $.ajax({
                        url:"{{route('v1.accounts.preview_journal','')}}/"+journal_code,
                        method: 'get',
                        beforeSend: function() {
                                blockUI();
                        },
                        success:function(res){
                            $('#preview_journal').removeClass('preview-border');
                            $('#journal_preview_card').show();
                            $('#preview_journal').html(res.html);
                        },
                        error:function(err){
                            $.unblockUI();
                            var error = err.responseJSON;
                            $('#prevShow').show();
                            $('#preview_journal').addClass('preview-border');
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html('Failed');
                            $('.common-modal-notify-error .modal-body').html(error.message);
                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    })
    }
    $('#search_voucher_finalize').click();
</script>