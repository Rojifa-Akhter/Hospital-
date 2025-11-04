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
                            <h5 class="mt-2 mb-0">Account Description</h5>                         
                            <small>Accounts / Setup / {{$page_info->getData()->data->acc_1group_name}} / {{$page_info->getData()->data->acc_2subgroup_name}}  / {{$page_info->getData()->data->acc_3grouptype_name}}/  <a href="{{ route('v1.accounts.chart-of-accounts-list')}}" rel="tab">{{$page_info->getData()->data->acc_4type_name}}</a> Account Description</small>
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
                                    <li class="list-group-item"><span onclick="download('pdf')" style="cursor:pointer"><i class="fas fa-file-pdf pdf-icon"></i></span></li>
                                    <li class="list-group-item"><span onclick="download('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>
                                    <input type="hidden" value="{{$id}}" id="txtTypeID">
                                </ul>
                            </div>
                            <div class="table-responsive" >
                                <table class="table table-striped table-bordered table-hover" id="typeListByGroupTypeTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>Account Description</th>                     
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($get_type_list->getData()->data as $item)
                                            <tr>
                                                <td><a href="{{route('v1.accounts.get-gl-list-by-account-description',$page_info->getData()->data->acc_5typedescription_no_pk)}}">{{$item->acc_5type_description}} @if(!empty($item->acc_code_range_5_start)) Group No-{{$item->acc_code_range_5_start}} @endif</a></td>                                            
                                            </tr>
                                        @endforeach
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
     $(document).ready(function(){
        $('#typeListByGroupTypeTable').DataTable({
            searching: true,
            paging:true,
            columnDefs: [{ targets: [0], className: 'text-left' }],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                "pageLength": 10 
        });  
     })

     function download(type){

        var id = $('#txtTypeID').val();
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-chart-of-account-description-excel','')}}/'+id;
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-chart-of-account-description-pdf','')}}/'+id;
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
                        downloadLink.setAttribute('download', 'account_description.xls');
                    }
                    else if(type == 'pdf')
                    {                       
                        downloadLink.setAttribute('download', 'account_description.pdf');
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


