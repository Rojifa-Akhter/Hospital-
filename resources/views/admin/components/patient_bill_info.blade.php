<style>
    .patient_info_card .info_table tr th {
        font-size: 16px !important;
        color: #0077c1;
    }

    .patient_info_card .info_table tr td {
        font-size: 16px !important
    }

    .patient_info_card .patient_info_img img {
        height: 95px;
        width: 95px;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_info_img img {
        border: 5px solid #0077c13b;
        float: left;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_infos {
        float: left;
        margin-left: 10px;
    }
    .patient-img{
        width: 65px;
    }
</style>
@php 
$currentRouteName = Route::currentRouteName();

@endphp
<div class="card">
    <div class="card-header"><h5><i class="fa fa-user"></i>&nbsp; Patient & Account Information</h5>



    </div>
    <div class="card-body p-2 d-flex align-items-center justify-content-between">
        <div class="patient-infos w-50">
            <table class="table mb-0 table-borderless " style="border:2px solid #F7F7F7;">
                <tbody>
                <tr>
                    <th>Name</th>
                    <td id="patient_name">{{isset ($account_info->patient_name) ? $account_info->patient_name : ''}}</td>
                    <th class="text-left">UHID</th>
                    <td class="text-left" id="patient_code"> : {{ isset($account_info->patient_code) == '' ? '' : $account_info->patient_code}}</td>

                </tr>
                <tr>
                    <th class="text-left">Age</th>
                    <td class="text-left" id="patient_age">: {{isset($account_info->age) == '0' ? '' : $account_info->age }}</td>
                    <th class="text-left">Gender</th>
                    <td class="text-left" id="patient_gender"> : {{ isset($account_info->gender_txt) == '' ? '' : $account_info->gender_txt}}</td>


                </tr>
                <tr>

                    <th class="text-left">Mobile Number</th>
                    <td class="text-left" id="patient_ms"> :{{ isset($account_info->mobile1)== '0' ? '' : $account_info->mobile1}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="patient-img text-center w-50">
            <table class="table mb-0 table-borderless" style="border:2px solid #F7F7F7;float: right;">
                <tbody>
                <tr>
                    <th class="text-left">Amount</th>
                    <td class="text-left" id="amount">: {{isset($account_info->amount) == '0' ? '0' : $account_info->amount }}</td>
                    <th class="text-left">Payable</th>
                    <td class="text-left" id="payable"> {{isset($account_info->payable) == '0' ? '0' : $account_info->payable }}</td>
                </tr>
                <tr>
                    <th class="text-left">Paid</th>
                    <td class="text-left" id="paid"> : {{ isset($account_info->paid) == '0' ? '0' : $account_info->paid}}</td>
                    <th class="text-left">Discount</th>
                    <td class="text-left" id="discount">: {{isset($account_info->discount) == '0' ? '0' : $account_info->discount }}</td>
                </tr>
                @if($currentRouteName != 'ipd-patient-report-delivery')
                    <tr style="background-color: crimson;color:#F7F7F7;">
                        <th class="text-left">Due</th>
                        <td class="text-left" id="due">: <span class="badge badge-danger">{{isset($account_info->due) == '0' ? '0' : $account_info->due }}</span></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                 @endif
                </tbody>
            </table>

        </div>
    </div>
</div>
