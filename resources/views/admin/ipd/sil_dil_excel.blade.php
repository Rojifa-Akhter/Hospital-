<style>
    @page {
        margin: 1cm 0.3cm;
        /*width: 450px;*/
        padding:8px;
    }
    body {
        /*margin-top: 5.5cm;*/
        margin-left: .5cm;
        margin-right: .5cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
    }

    .bg-black{
        background-color: #222;
        color: #fff;
    }

    table{
        border-collapse:collapse;

    }

    table tr td,
    table tr th{
        font-size: 11px;
        border:1px solid #222;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        padding: 2px;
        /*border-width: thin;*/
    }
    .border-0{
        border:0px;
    }
    .text-center{
        text-align: center!important;
    }
    .text-left{
        text-align: left!important;
    }
    .text-right{
        text-align: right!important;
    }
    .w-100{
        width: 100%;
    }

    .w-5{
        width: 5%;
    }
    .w-10{
        width: 10%;
    }

    .w-25{
        width: 25%;
    }

    .w-50{
        width: 50%;
    }
    .mb-10{margin-bottom: 10px;}
    .mt-5 { margin-top: 5px; }
    .mt-10 { margin-top: 10px; }
    .mt-20 { margin-top: 20px; }
    .mb-0{ margin-bottom: 0; }
    .mb-15{ margin-bottom: 15px; }
    .pb-0{ padding-bottom: 0; }


    .logo{
        width: 80px;
        display: inline-block;
    }
    .d-flex{
        display: flex;
    }

    .align-items-center{
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 20px;
        padding-bottom: 0;
    }

    .hospital-logo-info .hospital_info .hospital-address{
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    .hospital-logo-info .hospital_info .hospital-contact{
        font-weight: 500;
        display: block;
        line-height: 1.2;
        width: 480px;
    }

    .hospital_info{
        margin-left: 10px;
    }
    .text-uppercase{
        text-transform: uppercase;
    }
    .title{
        /*background-color: #444;*/
        /*display: inline-block;*/
        font-size: 14px;
        color: #000;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
    }
</style>


<div class="row mb-10">

    <table class="w-100">
        <tr>
            <td colspan="2" class="text-center border-0">
                <span class="text-uppercase title">Current SIL/DIL Report </span>
            </td>
            <td class="text-right border-0">
                Date: {{ date('d/m/Y') }}
            </td>
        </tr>
    </table>
</div>

@if(!empty($sildilList))
        <div>
            <table class="w-100" >
                <tr>
                    <td class="text-left border-0">
                      
                    </td>

                    <td class="text-right border-0">
                        Total Record: {{ !empty($sildilList)? count($sildilList): 0 }}
                    </td>
                </tr>
            </table>
            <table class="w-100 m-0" border="1">
                <thead class="bg-black">
                <tr>
                    <th width="" class="text-center"><strong>SL#</strong></th>
                    <th width="" class="text-center"><strong>Date</strong></th>
                    <th width="" class="text-center"><strong>Patient Name</strong></th>
                    <th width="" class="text-center"><strong>Service Number</strong></th>
                    <th width="" class="text-center"><strong>Age</strong></th>
                    <th width="" class="text-center"><strong>Organization</strong></th>
                    <th width="" class="text-center"><strong>Listing</strong></th>
                </tr>
                </thead>
                <tbody> 
                    @if(!empty($sildilList))
                        @php
                        $totalItems = !empty($sildilList)?count($sildilList):0;
                        @endphp 
                        @foreach($sildilList as $record)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-left">{{!empty($record->sil_dil_date)?date('d/m/Y',strtotime($record->sil_dil_date)):null}}</td>
                                <td class="text-left">{{!empty($record->patient_name_rank)?$record->patient_name_rank:''}}</td>
                                <td class="text-left">{{!empty($record->service_number)?$record->service_number:''}}</td>
                                <td class="text-left">{{!empty($record->age)?$record->age :''}}</td>
                                <td class="text-left">{{!empty($record->service_organization)?$record->service_organization:''}}</td>
                                <td class="text-left">{{!empty($record->sil_dil_ind)?$record->sil_dil_ind :''}}</td>
                            </tr>
                        @endforeach
                    @else
                        Sorry !!! No Data Found.
                    @endif
                </tbody>
            </table>
        </div>
@endif



