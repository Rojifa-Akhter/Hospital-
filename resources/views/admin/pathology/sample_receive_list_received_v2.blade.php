<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Pathology Sample Receive</h5>
            <small>Pathology / Pathology Sample Receive</small>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Pending Sample" aria-selected="true" onclick="pathologyFunc.getReceiveSamples(this)" data-action="{{ route('path.get-received-sample-v2') }}" rel="tab">Pending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Received Sample" aria-selected="false" href="{{ route('path.get-received-sample-list') }}" rel="tab">Received</a>
                </li>
            </ul>
            @if(Session::get('user.ses_hospital_code')=="DMHL")
                <div class="row mt-3">
                    <div class="col-lg-3 col-md-3 col-sm-12">           
                            <input type="text" class="form-control" name="lab_id" id="lab_id" placeholder="Enter Sample ID" autocomplete="off">           
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">           
                        <span id="show_message" style="color: blue;font-width:bold;font-size:26px"></span>          
                    </div>
                </div>
            @else
            <div class="tab-content">
                <div class="tab-pane fade show active" id="result-entry" role="tabpanel" aria-labelledby="received-by-challan-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            @include("admin.pathology.sample_receive_search_panel")
                        </div>
                    </div>
                    <div class="sample_content">
                        @include('admin.pathology.sample_receive_list_pending')

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Function to be called when barcode is scanned
        function handleBarcodeScan() {
            var barcodeValue = $('#lab_id').val();
            console.log('Barcode scanned:', barcodeValue);

            // Optionally clear the input field
            $('#lab_id').val('');
        }

        $('#lab_id').on('keydown', function(event) {
            // Check if Enter key is pressed
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent form submission if inside a form
                let lab_id=$(this).val();
                $.ajax({
                    async: true,
                    data: {lab_id : lab_id},
                    url: "{{route('path.store-sample-receive-v2')}}",
                    type: 'post',
                    cache: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        let meg=data.msg;    
                        $('#show_message').html(meg);        
                        if (data.title=='Error') {
                            $('#show_message').css('color', 'red');
                        }else{
                             $('#show_message').css('color', 'blue');
                        }
                    },
                    complete: function() {

                    },
                    error: function(data) {
                     

                        $.unblockUI();
                    }
                }).done(function() {
                    $.unblockUI();
                });
                handleBarcodeScan();
            }
        });
    });
</script>



