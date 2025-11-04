@extends("mCare.layouts.master")
@push('mcare_customcss')
    <link rel="shortcut icon" href="{{ asset('coverpage/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('coverpage/favicon.ico') }}" type="image/x-icon" />
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@300;400;500;700&family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <!-- icofont -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/icofont.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/all.min.css') }}" />
    <!-- Slick slider -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick-theme.css') }}" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/bootstrap.min.css') }}" />
    <!-- Style css-->

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    {{-- @include("mCare.layouts.css") --}}

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        .hero_section {
            padding: 100px 0;
            background: url(coverpage/img/about_us.png) center center no-repeat;
            background-size: cover;
            position: relative;
            z-index: 1;
        }

        .small_section_title {
            font-size: 14px;
            padding: 9px 20px;
            background-color: #e0fff0;
            display: inline-block;
            border-radius: 30px;
        }

        .section_title {
            font-size: 45px;
            font-weight: 600;
            position: relative;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        h3 {
            font-size: 28px;
            font-family: "Roboto", sans-serif;
            color: #025730;
        }

        h4 {
            font-size: 18px;
            font-weight: 600;
            font-family: "Roboto", sans-serif;
            color: #025730;
        }

        .about_us {
            padding: 100px 0px;
        }

        .mission_goals {
            padding: 0px 0px 75px 0px;
        }

    </style>

@endpush
@section('content')
    <!-- Slider Start -->
    <div class="about_hero_section">
        <div class="hero_section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="hero_text">
                            <h1>Return & Refund Policy</h1>
                            <b>Home <i class="fas fa-angle-double-right"> </i> <span>Return & Refund Policy</span> </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider end -->

    <!-- About us start -->
    <div class="about_us" style="background-color: #fff;">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-md-12">
                    <div class="about_us_section">
                        <h4 class="section_title">For Video Consultation with Healthcare Professionals (HCPs)</h4>
                        <p class="mt-3">In the event, any scheduled appointment is subsequently canceled by
                            Healthcare Professional or He/She is not available for providing the Services on the scheduled
                            date and time of appointment. MCARE may arrange for a fresh appointment for the User(s) and this
                            shall be the sole remedy for the User(s) herein. In case the User(s) has prepaid for an
                            appointment with a concerned Healthcare Professional and does not intend to avail the fresh
                            appointment pursuant to the events occurred under clause above, the prepaid amount shall be
                            refunded to the User(s) account.</p>


                        <p class="mt-3">In the event, the User(s) chooses any wrong speciality or therapeutic area
                            for consultation, or the User(s) gives wrong or unauthorized information, MCARE shall not be
                            responsible or liable for any consequences arising therefrom.</p>
                        <p class="mt-3">In the event there are disruptions, blurring, call break down or any other
                            connectivity issues, during the consultation resulting in non-completion of the service, MCARE
                            although under no obligation, shall make reasonable efforts to arrange for a fresh consultation
                            appointment for the User(s). In case the User(s) has prepaid for the consultation with concerned
                            Healthcare Professional and does not intend to avail the fresh consultation pursuant to the
                            events occurred under this clause, the prepaid amount shall be refunded to the User(s) account.

                            User(s) acknowledge and agree that the concerned HCP from whom Services are
                            booked/ordered/availed shall alone be liable and responsible for any act or omission or
                            commission on part of the HCP, including but not limited to (i) the treatment, prescription,
                            medication (collectively referred to as “Healthcare Professional services'') or (ii) for medical
                            negligence arising out of such HCP services. User(s) acknowledge that MCARE shall not be liable
                            in any way for any claims with respect to HCP Services and confirm that it shall not make any
                            claim on MCARE or any other person/party.
                        </p>

                        <br> <br>

                        <h4>Medical Tourism Service</h4>
                        <hr>
                        <p>MCARE wouldn't receive any direct payment for overseas treatment. All treatment related payments
                            will be received by the concerned hospital from which services are booked/ordered/availed. So
                            user(s) acknowledge and agree that only the concerned Hospital shall alone be liable and
                            responsible for any act or omission or commission on part of the Hospital, including but not
                            limited to (i) the treatment, prescription, medication (collectively referred to as “Healthcare
                            Professional services'') or (ii) for medical negligence arising out of such HCP services.
                            User(s) acknowledge that MCARE shall not be liable in any way for any claims with respect to
                            Hospital related services and confirm that it shall not make any claim on MCARE or any other
                            person/party.
                        </p>
                        <br> <br>
                        <h4>For Pharmacy Services </h4>
                        <hr>
                        <p>
                            MCARE team facilitates processing correct medicines as per order and prescription and strives to
                            service the medicines and products in the right conditions/ without any damage every time a
                            consumer places an order. We also strongly recommend the items are checked at the time of
                            delivery.<br>

                            Definition: 'Return' means an action of giving back the product ordered at MCARE platform by the
                            consumer. The following situations may arise which may cause the action of return of product:
                            Product(s) delivered do not match your order;<br>

                            Product(s) delivered are past or near to its expiry date (medicines with an expiry date of less
                            than 03 months shall be considered as near expiry);<br>

                            Product(s) delivered were damaged in transit (do not accept any product which has a tampered
                            seal).
                            <br>
                            Note: If the product that you have received is damaged, then do not accept the delivery of that
                            product. If after opening the package you discover that the product is damaged, the same may be
                            returned for a refund. Please note that we cannot promise a replacement for all products as it
                            will depend on the availability of the particular product, in such cases we will offer a refund.
                            <br>
                            In the aforesaid unlikely situations, if there is something wrong with the order, we'd be happy
                            to assist and resolve your concern. You may raise a return request with our customer care within
                            07 (Seven) days from the delivery of the product. MCARE reserves the right to cancel the Return
                            request, if the customer reaches out to MCARE after 7 days of delivery.
                            <br>
                            Upon receiving your Return/Refund request, MCARE shall verify the authenticity and the nature of
                            the request. If MCARE finds that the request is genuine, it will initiate the Return and Refund
                            process. MCARE shall process the refund only once it has received the confirmation from the
                            vendor concerned in respect of the contents of the product relating to that refund.
                            <br>
                            In the event of frivolous and unjustified complaints regarding the quality and content of the
                            products, MCARE reserves the right to pursue necessary legal actions against you and you will be
                            solely liable for all costs incurred by MCARE in this regard.
                            <br>
                            The returns are subject to the below conditions:<br> -

                            i. Any wrong ordering of product doesn’t qualify for Return;<br>

                            ii. Batch number of the product being returned should match as mentioned on the invoice;
                            <br>
                            iii. Return requests arising due to change in prescription do not qualify for Return;
                            <br>
                            iv. Product being returned should only be in their original manufacturer's packaging i.e. with
                            original price tags, labels, bar-code and invoice; and
                            <br>
                            v. Partially consumed strips or products do not qualify for Return, only fully unopened strips
                            or products can be returned.
                            <br>

                        </p>
                        <br> <br>
                        <h4>
                            Return Process:
                        </h4>
                        <p>
                            For Return intimation, please visit www.mcare.com.bd/help or alternatively call us at
                            01938861474
                            (Open 10 AM - 6 PM from Saturday – Thursday).

                            MCARE customer care team will verify the claim. Once the claim is verified as genuine and
                            reasonable, MCARE will take necessary steps.
                        </p>
                        <br> <br>
                        <h4>
                            Refund Process:
                        </h4>
                        <p>
                            In all the above cases, if the claim is found to be valid, refund will be credited to users’
                            wallet.

                        </p>
                        <br>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection




{{-- Custom Js --}}

@push('mcare_customjs')
    <script src="{{ asset('coverpage/js/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <!-- scripts -->
    <script src="{{ asset('coverpage/js/scripts.js') }}"></script>
    <script src="{{ asset('coverpage/js/bootstrap.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
    </script>
    <script type="application/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script type="application/javascript"
        src="{{ asset('node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script>
        $(document).on("click", ".image_show", function() {
            $('.img_class').addClass('d-none');
            $('.image_show').removeClass(' shadow-none bg-light rounded');
            var id = $(this).attr("id")
            $('#' + id).addClass(' shadow-none bg-light rounded');
            $('#img_' + id).removeClass('d-none');
        });
    </script>
@endpush
