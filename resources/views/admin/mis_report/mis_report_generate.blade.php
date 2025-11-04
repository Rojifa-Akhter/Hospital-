
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .error {
        color: red !important;
        font-size: 14px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Report Generate</h5>
            <small>MIS Reports / Report Generate</small>
        </div>
    </div>


    <div class="card">
        <div class="card-header">Reports</div>
        <div class="card-body px-2 pt-2">
                <div class="row">
                    <div class="col-md-4 col-12" > 
                        <ol>
                            @foreach($data as $key => $item)
                                @if($item->status == 1)
                                <li>
                                    <div class="alert {{ $key % 2 == 0 ? 'alert-primary' : 'alert-success'}}" role="alert" title="click on Next Button to show Report">
                                        <div class="d-flex justify-content-between">
                                                <div type="div" onclick="MISReportRequest({{$item->report_no_pk}})">{{$item->report_name}}</div>
                                                <div type="div" class="btn btn-md w-25 {{ $key % 2 == 0 ? 'btn-success' : 'btn-primary'}}" onclick="MISReportRequest({{$item->report_no_pk}})">Show</div>
                                        </div>
                                    </div>
                                </li>
                                @endif                
                            @endforeach
                        </ol>
                    </div>
                    <div class="col-md-8 col-12">
                        <div id="report">
                            <div style="border:1px dashed #B4B5B6;border-radius:4px;height:30vh">
                                <h5 style="padding-top:14vh" class="text-center"><b>Preview not available.</b></h5>
                                <h6 class="text-center">Please click on show button to preview</h6>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</div>

<script>


    // function changeStore(id){
    //     $.ajax({
    //         url:"{{route('reports.get-report-list','')}}/"+id,
    //         method: 'get',
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success:function(res){
    //             $('#report').html(res);
    //         },
    //         error:function(err){
    //             $.unblockUI();
    //             var error = err.responseJSON;
    //             $('.common-modal-notify-error').modal('show');
    //             $('.common-modal-notify-error .modal-title').html('Failed');
    //             $('.common-modal-notify-error .modal-body').html(error.message);
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     })
    // }


    function MISReportRequest(id){
        $.ajax({
            url:"{{route('reports.generate-mis-report-request','')}}/"+id,
            method: 'get',
            beforeSend: function() {
                blockUI();
            },
            success:function(res){
                $.unblockUI();
                $('#report').html(res);
            },
            error:function(err){
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }
    


    function checkedAll(val){
        if($("#selectAll").is(":checked")){
            $('.all').prop('checked', true);
        }
        else
        {
            $('.all').prop('checked', false);
        }
    }

    function checkedAllChecked(){
        $('#selectAll').prop('checked', false);
    }


    function exportExcelReportGenerate(){
        let isValid = true;

        $("#reportGenerateForm").find('[required]').each(function() {
        if ($(this).val().trim() === '') {
            isValid = false;
            $(this).css('border', '1px solid red'); // Highlight the field with an error
        } else {
            $(this).css('border', ''); // Remove error highlight if valid
        }
        });

        if (!isValid) {
            alert('Please fill in all required fields.');
            return; // Stop the function if validation fails
        }
        const formData = $("#reportGenerateForm").serialize();
        var url = '{{route('reports.report-generate-excel')}}';
            $.ajax({
            url: url,
            method: 'post',
            data:formData,
            xhrFields: {
                responseType: 'blob' 
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                downloadLink.setAttribute('download', 'report.xls');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $.unblockUI();
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            },
            complete: function() {
                $.unblockUI();
            }
            });
    
    }

</script> 