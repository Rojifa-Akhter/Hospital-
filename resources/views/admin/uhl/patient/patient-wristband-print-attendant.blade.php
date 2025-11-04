<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
             size: 13in 30mm;            
            margin: 0mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: bold;
        }
        #contantData {
            margin-left: 240px;
        }
    </style>
</head>

<body>
    <table width="100%" id="contantData">
        <tr>
    
            {{-- <td style="text-align: left;width:20px">
                @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="70px" />
                @endif
            </td> --}}
            <td style="vertical-align: middle; text-align:left;">             
                <table>
                    <tr>
                        <td rowspan="3" style="text-align: center;">
                            <!-- QR Code SVG -->
                            <div style="width:100px; height:55px; vartical-align:middle">
                                {!! (string) $qrcontent !!}
                            </div>
                        </td>
                        <td>Name</td>
                        <td colspan="3">: {{ $patien_info->patient_name }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        
                    </tr>
                    <tr>
                        <td>UHID</td>
                        <td>: {{ $patien_info->patient_code }}</td>
                        <td>Date of Birth</td>
                        <td>: {{ date('d/m/Y', strtotime($patien_info->dob)) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>: {{ $patien_info->gender_txt }}</td>
                        <td> Pat. Type</td>
                        <td>: {{ ucfirst(strtolower($pat_type))}} </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>       
            
           
          
        </tr>
        <tr> 
            
            <td colspan="14" style="padding-left:60px; !important; padding-top:12px"> <small> Printed Date & Time: {{date('d/m/Y h:i a')}} </small>, <small >Expiry : {{date('Y-m-d h:i:s a', strtotime('+5 hours'))}} </small></td>
            
        </tr>
    </table>
   
   
</body>

</html>