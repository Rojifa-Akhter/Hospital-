<style>
    /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
        }*/
    @page {
        /*margin-top: 150px;*/
        /*margin-bottom: 120px*/
    }

    .header {
        position: fixed;
        left: 0px;
        top: -140px;
        right: 0px;
        height: 100px;
        text-align: center;
    }

    /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/

    footer {
        position: fixed;
        z-index: 999999999;

        left: 0;
        right: 0;
        height: 3cm;
        text-align: center;
        font-size: 9px;
        bottom: -100px;

        padding-top: 10px;
    }

    body {
        /*margin-top: 5.5cm;*/
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 12px;
    }


</style>


<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="form-content">
                        <!-- <div class="form-heading text-center border-bottom pb-3">
                            <div class="hospital-address">
                                <h1 class="mb-0 text-center">Khwaja Badrudduja Modern Hospital</h1> <br>
                                <p class="mb-0 text-center">Aziz Mansion, Shufipur, Kaliakair, Gazipur.</p> <br>
                                <p class="mb-0 text-center">Phone : 01776-606262, 01687-625565</p> <br>
                            </div>
                        </div> -->
                        {{-- <div class="form-heading  border-bottom pb-3" style="">
                            <div id="logo" style="display:inline-block !important; ">
                                @if (!empty($po_hospital_details->logo))
                                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                        width="80px" />
                                @endif
                            </div>
                            <div class="hospital-address" style="display:inline-block !important; ">
                                <h1 class="mb-0 ">
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h1>
                                <br>
                                <p class="mb-0 ">
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                </p>
                                <br>
                                <p class="mb-0 ">
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                </p>
                                <br>
                            </div>
                        </div> --}}

                        <div style="align-items: center;" class="letter_header_wrap">
                            <p class="" style="float:left;">To</p>
                            <p style="float:right;">Date: {{ date('m.d.Y') }}</p>
                        </div>
                        <div class="employee-info" style="clear:both;">
                            <p style="font-style:bold;">{{ isset($empIncApproveInfo->full_name) ? $empIncApproveInfo->full_name : '' }}</p>
                            <p>Designation: {{ isset($empIncApproveInfo->designation) ? $empIncApproveInfo->designation : '' }}</p>
                            <p>Department: {{ isset($empIncApproveInfo->su_name) ? $empIncApproveInfo->su_name : '' }}</p>
                            <p>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</p>
                            {{-- <p>East West Medical College & Hospital.</p> --}}
                        </div>
                        <div class="subject">
                            <p style="font-style:bold;">Subject:  Letter of Salary Increment. </p>
                        </div>
                        <div class="letter-body">
                            <p>Dear {{ isset($empIncApproveInfo->full_name) ? $empIncApproveInfo->full_name : '' }}</p>
                            <p>Consequent to the review of your performance the Management of {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} is pleased to increase your salary from {{ isset($empIncApproveInfo->gross_salary) ? $empIncApproveInfo->gross_salary : '' }} Tk. To {{ isset($empIncApproveInfo->increment_salary) ? $empIncApproveInfo->increment_salary : '' }} Tk. with effect from {{ isset($empIncApproveInfo->date_of_effective) ? date('d/m/Y', strtotime($empIncApproveInfo->date_of_effective)) : '' }}. </p>
                            <p>We look forward to your valuable contributions and wish you all the very best for a rewarding career with the {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}.
                            </p>
                            <p>Please sign the duplicate copy of this letter as a token of appreciation of the same. Congratulations again and I wish you every success in your role. </p>
                            <p>Thanking you, </p><br><br><br>
                        </div>
                        <div class="letter_footer_wrap" style="border-top:1px solid black; width:35%;">
                            <p style="margin:0px;">Brig Gen (Retd) Dr. Md. Abdullah Al Jobair</p>
                            <p style="margin:0px;">Director</p>
                            <p style="margin:0px;">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </p>
                        </div>


                    </div>
                </div>


            </div>


        </div>


    </div>
</div>
<footer>

    <!-- <hr style="border: 0.5px solid #000000"> -->
    <!-- <div class="">
        <span style="float:left">Printing Date & Time: {{ date('d/m/Y H:i:s') }} &nbsp;
            <span style="float:right">Powered By: NEXTGEN IT</span>
    </div> -->
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>

    <div class="" style=" border-top: 1px solid black;">
        <span style="float:left;">Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span
            style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
