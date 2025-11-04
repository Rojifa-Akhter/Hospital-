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
        <p style="font-style:bold;" class="text-center">Appointment Letter. </p>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    {{-- <div class="text-center"> --}}

                    {{-- </div> --}}
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
                            <p class="" style="float:left;">To,</p>
                            <p style="float:right;">Date: {{ date('m.d.Y') }}</p>
                        </div>
                        <div class="employee-info" style="clear:both;">
                            <p style="font-style:bold;">
                                {{ isset($candidateInfo->full_name) ? $candidateInfo->full_name : '' }}</p>
                            {{-- <p>Designation: {{ isset($candidateInfo->designation) ? $candidateInfo->designation : '' }} --}}
                            {{-- <p>Designation:</p> --}}
                            {{-- <p>Department: {{ isset($candidateInfo->su_name) ? $candidateInfo->su_name : '' }}</p>
                            <p>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </p> --}}
                            {{-- <p>East West Medical College & Hospital.</p> --}}
                            <p>{{ isset($candidateInfo->pe_address) ? $candidateInfo->pe_address : '' }}</p>
                            <p>Appointed as ({{ $candidateInfo->designation }})</p>
                        </div>
                        <div class="subject">
                            {{-- <p style="font-style:bold;">Subject: Appointment Letter. </p> --}}
                        </div>
                        <div class="letter-body">
                            <p>Dear {{ isset($candidateInfo->full_name) ? $candidateInfo->full_name : '' }},</p>
                            {{-- <p>We refer to your recent interview for the above position and are pleased to inform that
                                we are offering you the position with our company effective from (Date) under the
                                following terms and conditions:
                            </p> --}}
                            <p> We thank you for deciding to be a part of the
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                family. Congratulations and welcome onboard a dynamic and winning team!
                            </p>
                            <p>Further to your acceptance of the offer letter dated
                                {{ isset($candidateInfo->letterissued_date) ? date('d.m.Y', strtotime($candidateInfo->letterissued_date)) : '' }},
                                we are pleased
                                to confirm your appointment as
                                <b>{{ isset($candidateInfo->designation) ? $candidateInfo->designation : '' }} </b> for
                                our
                                {{ isset($candidateInfo->serviceunit_name) ? $candidateInfo->serviceunit_name : '' }}
                                at {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                in
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}.
                            </p>
                            <p> Please make note of the following important terms and conditions of your employment:
                            </p>

                            <ul> <b>. Salary:</b> Your gross monthly salary will be Tk ______/-</ul>
                            <ul> <b>. Probationary Period:</b> 6 months, after joining the job.</ul>
                            <ul> <b>. Working Hours:</b> Daily 8 hours, Sunday to Thursday working, Lunch Break 1 hour.
                            </ul>
                            <ul><b>. Holiday:</b> Weekly 2 holidays Friday &
                                Saturday and Government Holidays.</ul>
                            <ul><b>. Leave Policy: </b> 15 days paid leaves per year. 5 days sick leaves.</ul>
                            <ul><b>. Notice Period Clause:</b> After confirmation the employment may be terminated by
                                either side giving notice of one month or payment equivalent to one month’s salary in
                                lieu of notice.</ul>


                            <p>Wish you a successful professional stint with
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}.
                                We look forward to a mutually beneficial and enriching experience having you on board.
                                All the best!
                            </p>
                            <p>Please sign the duplicate copy of this letter as a token of appreciation of the same.
                                Congratulations again and I wish you every success in your role. </p>
                            <p>Thanking you, </p><br><br><br>
                        </div>
                        <p>
                        <div style="float:right;width:30%;">I have read the above terms and conditions of my
                            appointment. I accept the same.<br />
                            _____________________ <br />
                            <br />
                            {{ isset($candidateInfo->full_name) ? $candidateInfo->full_name : '' }}
                        </div>
                        </p>
                        <div class="letter_footer_wrap" style="border-top:1px solid black; width:35%;">
                            <p style="margin:0px;">Brig Gen (Retd) Dr. Md. Abdullah Al Jobair</p>
                            <p style="margin:0px;">Director</p>
                            <p style="margin:0px;">
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </p>
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
            style="">Printing
            Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
