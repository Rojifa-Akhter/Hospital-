<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
    /* .export-option{
        margin-bottom: -10px !important;
    } */
    .center{
        display: flex;
        justify-content: center;
    }
    .list-group-item{
        border:none !important;
        padding: 5px 5px !important;
        padding-bottom: 0px !important
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }

</style>
@php 
@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">General Ledger</h5>
                            @if($id != 'all')
                            <small>Accounts / Setup / {{$page_info->getData()->data->acc_1group_name}} / {{$page_info->getData()->data->acc_2subgroup_name}}  / <a href="{{ route('v1.accounts.chart-of-accounts-list')}}" rel="tab">{{$page_info->getData()->data->acc_5type_description}}</a> / General Ledger </small>
                            @else
                            <small>Accounts / Setup / General Ledger</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="center export-option">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadGL('pdf')" style="cursor:pointer"><i class="fas fa-file-pdf pdf-icon"></i></span></li>
                                    <li class="list-group-item"><span onclick="downloadGL('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>
                                    <input type="hidden" value="{{$id}}" id="txtTypeID">
                                </ul>
                            </div>
                            <div class="table-responsive" >
                                <table class="table table-striped table-bordered table-hover" id="chartOfAccountV1DataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-left" style="width: 3%">SL</th>
                                            <th class="text-left" style="width: 3%">GL Code</th>
                                            <th class="text-left" style="width: 7%">GL Description </th>
                                            <th class="text-left w-5" style="width: 5%">Status</th>
                                            <th class="text-left w-10" style="width: 11%" >Mapped Report</th>
                                            <th class="text-left w-15" style="width: 10%">Report Header</th>
                                            <th class="text-left w-5" style="width: 7%">Cost Center</th>
                                            <th class="text-left w-10" style="width: 9%">Recurring Cost</th>
                                            <th class="text-left w-5" style="width: 9%">Control Account</th>
                                            <th class="text-left w-5" style="width: 5%">GL For</th>
                                            <th class="text-left w-10" style="width: 11%">Cash Flow Report</th>
                                            <th class="text-left w-15" style="width: 8%">Report Header</th>
                                            <th class="text-left w-15" style="width: 3%">DR/CR</th>
                                            <th class="text-left w-15" style="width: 3%">Depreciation</th>
                                            <th class="text-left w-5" style="width: 5%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($gl_list->getData()->data as $key => $item)
                                            <tr>
                                                <td class="text-center">{{++$key}}</td>
                                                <td class="text-center">{{$item->account_code}}</td>
                                                <td>{{$item->account_name}}</td>

                                                
                                                <td class="text-center">{{$item->status == 1 ? 'Active' : 'Inactive'}}</td>
                                                <td>@if($item->mapped_report == 'INCOME') {{ 'Income Statement ' }} @elseif($item->mapped_report == 'BALANCE') {{ 'Balance Statement' }} @endif</td>
                                                <td>
                                                    {{$item->report_header}}
                                                </td>
                                                <td class="text-center">{{$item->cost_center_ind == 1 ? 'Yes' : 'No'}}</td>
                                                <td class="text-center">{{$item->recurring_cost_ind == 1 ? 'Yes' : 'No'}}</td>
                                                <td class="text-center">{{$item->control_acc_ind == 1 ? 'Yes' : 'No'}}</td>
                                                
                                                <td class="text-center">
                                                    {{$item->bank_ind == 1 ? 'Bank' : ''}}
                                                    {{$item->bank_ind == 2 ? 'Cash' : ''}}
                                                    {{$item->bank_ind == 3 ? 'Others' : ''}}
                                                </td>
                                                <td>Cash Flow Report</td>
                                                <td>
                                                    @if($item->cash_flow_ind == 1)
                                                        {{$item->cashflow_report_header}}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{$item->default_dr_cr}}</td>
                                                <td class="text-center">
                                                    @if($item->depreciation_ind == 1)
                                                        {{ 'Yes' }}
                                                    @else
                                                        {{ 'No' }}
                                                    @endif
                                                </td>  
                                                <td>
                                                    <a href="{{route('v1.accounts.edit-accounts-level',$item->account_no_pk)}}" rel="tab" class="btn btn-sm btn-info btn-block text-capitalize">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
                                                </td>   
                                                                                        
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="14">No Data Found!</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
     $(document).ready(function(){
        $('#chartOfAccountV1DataTable').DataTable({
            searching: true,
            paging:true,
            columnDefs: [{ targets: [0, 1, 2, 3, 4], className: 'text-left' }],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                "pageLength": 10 
        });  
     })

     function downloadGL(type){
            var id = $('#txtTypeID').val();
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-gl-list-excel','')}}/'+id;
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-gl-list-pdf','')}}/'+id;
            }
            $.ajax({
            url: url,
            method: 'GET',
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;

                if(type == 'excel')
                    {
                        downloadLink.setAttribute('download', 'general_ledger.xls');
                    }
                    else if(type == 'pdf')
                    {                       
                        downloadLink.setAttribute('download', 'general_ledger.pdf');
                    }
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }


</script>


