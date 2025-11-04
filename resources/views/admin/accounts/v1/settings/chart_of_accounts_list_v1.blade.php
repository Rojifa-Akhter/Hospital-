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
                            <h5 class="mt-2 mb-0">Chart Of Accounts</h5>
                            <small>Accounts / Setup / Chart Of Accounts</small>
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
                                  </ul>
                            </div>
                            <div class="table-responsive" >
                                <table class="table table-striped table-bordered table-hover" id="chartOfAccountV1DataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th style="width:10%">Account Group</th>
                                            <th style="width:18%">Account Sub Group</th>
                                            <th style="width:18%">Account Group Type</th>
                                            <th style="width:25%">Type Name</th>
                                            <th style="width:29%">Account Description </th>                       
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($chart_of_account_list->getData()->data as $key => $item)
                                            <tr>
                                                <td>{{$item->acc_1group_name}}</td>
                                                <td>{{$item->acc_2subgroup_name}}</td>
                                                <td><a href="{{route('v1.accounts.get-type-list-by-group-type',$item->acc_3grouptype_no_pk)}}" target="_blank">{{$item->acc_3grouptype_name}}</a></td>
                                                <td><a href="{{route('v1.accounts.get-account-description-list-by-account-type',$item->acc_4type_no_pk)}}" target="_blank">{{$item->acc_4type_name}}</a></td>
                                                <td><a href="{{route('v1.accounts.get-gl-list-by-account-description',$item->acc_5typedescription_no_pk)}}" target="_blank">{{$item->acc_5type_description}}</a></td>
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
        $('#chartOfAccountV1DataTable').DataTable({
            searching: true,
            paging:true,
            columnDefs: [{ targets: [0, 1, 2, 3, 4], className: 'text-left' }],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                "pageLength": 10 
        });  
     })

     function download(type){
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-chart-of-account-excel')}}'
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-chart-of-account-pdf')}}'
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
                        downloadLink.setAttribute('download', 'chart_of_account_list.xls');
                    }
                    else if(type == 'pdf')
                    {                       
                        downloadLink.setAttribute('download', 'chart_of_account_list.pdf');
                    }
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.log('AJAX request error:', error);
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }


</script>


