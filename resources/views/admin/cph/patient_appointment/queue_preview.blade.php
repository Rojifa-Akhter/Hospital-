{{-- <form action="" method="post" id="" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-2 col-sm-12">
        
        </div>
        <div class="col-md-5 col-sm-12">
            <span>Central Police Hospital <br>
                2, Rajarbag, Dhaka
            </span> <br> <br>
            <span>Karim <br>
                এসআই (নিরস্ত্র)
            </span>
            <p><img src="https://img.freepik.com/free-psd/barcode-illustration-isolated_23-2150584086.jpg?size=626&ext=jpg&ga=GA1.1.875157874.1707290762&semt=ais" alt="" width="150"></p>
            <span>Token No. 256387459625</span>
            <span>Patient ID. AF8106</span>
            <span>Location: Out Door Building (2nd Floor) Room-210 Serial: 100</span>

        </div>
    </div>
    
    <div class="mt-3">
        @php
        $response_action = "";
        @endphp
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <ul class="list-inline btn__box">
                    <li class="list-inline-item mb-0 mt-0">
                    </li>
                    <li class="list-inline-item"><button type="button" class="btn btn-info">Print</button></li>
                </ul>
            </div>
        </div>
    </div>
    </div>       
    </form> --}}



    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <a  Class="btn btn-sm btn-info" data-id="" href="{{route('queue_print')}}" target="_blank" title="Print Packet Barcode"><i class="fa fa-file-pdf"></i> Print</a>
                </div>
                <div class="col-md-12">
                    <div style="font-size: 14px">
                      <P style="margin-top:-5px !important; color:black">Central Police Hospital</P>
                        <p class="mb-0"><strong></strong> 2, Rajarbag, Dhaka</p>
                        <p class="mb-0"><strong></strong> Mohammad Karim</p>
                        <p class="mb-0"><strong></strong>এসআই (নিরস্ত্র)</p>
                        <img style="" src="data:image/png;base64, {{ $barcode_no }} " width="30%"
                        height="50px" />
                        <p class="mb-0"><strong>Token No: </strong>256387459625</p>
                        <p class="mb-0"><strong>Patient ID: </strong>AF8106</p>
                        <p class="mb-0"><strong>Location: </strong>Out Door Building (2nd Floor) Room-210 Serial: 100</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script>
        $(".timepicker").timepicker({
            defaultTime: new Date(),
            interval: false,
            // 'timeFormat': '24'
            // showInputs: false,
            showMeridian: false,
            minuteStep:1,
            // setTime: null
        });
    </script>


