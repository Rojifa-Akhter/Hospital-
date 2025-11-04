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
                            <h1>Terms and Condition</h1>
                            <b>Home <i class="fas fa-angle-double-right"> </i> <span>Terms and Condition</span> </b>
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
                        {{-- <h3 class="section_title">Terms and Condition</h3> --}}
                        <p class="mt-3"> Please read these terms of use carefully. By continuing to access and use
                            this application you confirm that you accept our terms and conditions described herein. If you
                            do not agree with the terms of use, do not use this application.</p>
                        <br> <br>
                        <h4>Preface</h4>
                        <hr>
                        <ul class="theme_list_item mt-3">
                            <li>1. This Website www.M-care.com (“Website”) and M-care
                                (“Mobile Application”) (collectively
                                referred to as Digital Platform) is coined, adopted, maintained and operated by ECL System
                            </li>
                            <li>2. M-care is set up to leverage the power of digital
                                technology to empower healthcare
                                providers and consumers in Bangladesh
                            </li>


                        </ul>
                        <br> <br>
                        <h4>Changes</h4>
                        <hr>
                        <p>M-care reserves its rights to modify, update, change, edit, alter, amend, revise or substitute
                            (collectively “Revisions”) the Agreement from time to time. Any Revisions made will be effective
                            immediately upon their posting on the Digital Platform.

                            Any material changes will be notified to the User(s) either through the Services, email(s), SMS
                            or in-app push notifications. User(s) are encouraged to review these Terms periodically for any
                            updates or Revisions. User(s) continued use of the services consequent to any Revisions, shall
                            be deemed acceptance of such Revisions/revised terms and conditions.
                        </p>
                        <br> <br>
                        <h4>Acknowledgement</h4>
                        <hr>
                        <p>Before accessing or creating a User Account (hereinafter defined) on the Digital Platform,
                            User(s) are advised to carefully read these Terms and the Digital Platform’s Privacy Policy
                            available at www.M-care.com. The Terms and the Privacy Policy are collectively referred to as
                            “Agreement” herein. By accessing/browsing the Website/ Mobile Application for any information
                            and/or availing the Services, the User(s) hereby acknowledge that they have read, understood and
                            accept all the terms and conditions of the Agreement and agree to abide by the same. If the
                            User(s) do not consent or accept the terms and conditions of the Agreement they are advised to
                            forthwith disengage from the Website/Mobile Application and stop the access/use thereof.
                        </p>
                        <p>
                            M-care reserves the right to accept or reject the request of the User(s) to create an account,
                            terminate the account of registered User(s) for unauthorized use, or refuse the Services offered
                            through this Digital Platform due to non-availability of Services.
                        </p>

                        <br> <br>
                        <h4>Eligibility for accessing and availing the available Services on the Digital Platform</h4>
                        <hr>
                        <p>

                            Any person aged 18 years or above and capable of entering into a contract and subject to
                            acceptance by M-care is permitted to create/ access User account to avail the available
                            Services. Minors are prohibited from accessing or creating User Account; however Legal Guardian
                            of the Minors can avail the available Services for Minors. Services are available only for the
                            citizens of Bangladesh. Users’ may please note that certain Services may be available or limited
                            to only particular areas within the country.
                        </p>
                        <br> <br>
                        <h4>Access to Usage of Digital Platform</h4>
                        <hr>
                        <p>

                            The Digital Platform can be browsed and accessed by Unregistered User(s) as well as User(s)
                        </p>
                        <p>
                            User(s) agree to read, understand and accept all the terms and conditions website/mobile
                            application(s) before booking/ordering/availing Services from such Third Party Service
                            Provider(s).

                        </p>
                        <br> <br>
                        <h4>
                            User Account</h4>
                        <hr>
                        <p>
                            1. For availing any Services on the Platform, the User(s) need to create a User Account by
                            entering
                            certain information including but not limited to (a) Name, (b) Age, (c) Gender, (d) valid
                            Email-Id &
                            password.
                            <br>
                            2. M-care subject to the terms of this Agreement may accept the User Account creation request.
                            The
                            creation of User(s) Account shall be at the sole discretion of M-care. User(s) can create
                            multiple
                            accounts for their family members using the same credentials and avail the available Services.
                            <br>
                            3. The User(s) are requested to carefully read the terms of use before browsing or accessing the
                            contents, or creating a User Account, on the Digital Platform and gain knowledge as to how the
                            information shared by them may be stored, protected, processed, used, shared and disseminated by
                            M-care.
                            <br>
                            4. User(s) can rectify any discrepancies (except for change in Mobile Number) in their User
                            Account
                            information by reporting the same to M-care. Notwithstanding the foregoing, M-care may reject
                            the
                            request of the User to edit, update or modify the User’s Account if such request is violative of
                            applicable laws or in breach of these Terms.
                        </p>
                        <br> <br>
                        <h4>
                            Services
                        </h4>
                        <p>
                            1) The Registered User(s) may access or avail the following Services,
                            <br>
                            &nbsp; i) Online appointment with Healthcare Professionals; <br>
                            &nbsp; ii) Medical Tourism Service for better treatment abroad. <br>
                            &nbsp; iii) Online Pharmacy Services <br>
                            <br>
                            2) At the time of availing the Services the User(s) will be made available the information
                            regarding
                            the services on the digital platform and the User(s) may opt the services from the desired Third
                            Party Service Providers.
                            <br>
                            3) User(s) are required to make requisite payment of Service Fees/Charges as are fixed and
                            hosted on
                            the Platform for availing the Services as per the specified payment mechanism.
                            <br>
                            4) M-care at its discretion can provide or facilitate the Services in the following manner,
                            <br>
                            &nbsp; i) Against payment of Service Fees/Charges, <br>
                            &nbsp; ii) Free of charge <br>
                            &nbsp; iii) By offering some discounts/concessions, <br>
                        </p>
                        <br> <br>
                        <h4>
                            Video Consultation with Healthcare Professionals (HCPs)
                        </h4>
                        <hr>
                        <p>
                            1. M-care lists the profile of Healthcare Professionals on its Platform.
                            2. User(s) may search the Platform for Healthcare Professionals for the available specialties/
                            therapeutic areas.
                            3. From the results displayed the User(s) may book an appointment on the Platform for the
                            Services
                            of Healthcare Professionals as per the available times slot.
                            4. Pursuant to booking, M-care will send a notification to the User(s) informing the booking
                            details.
                            5. The User(s) is required to log in at the scheduled time.
                        </p>
                        <br> <br>
                        <h4>
                            Medical Tourism Service
                        </h4>
                        <hr>
                        <p>
                            1. Depending on the disease you have, MCARE will provide you with multiple options along with
                            accurate and precise information. <br>
                            2. Using direct video conferencing with your doctor, you can receive detailed information about
                            your
                            treatment and necessary advice before you travel to India.<br>

                            3. MCARE will provide visas, train or air tickets, and all kinds of interim directions.
                            <br>
                            4. Upon arrival in the foreign country, we'll assist you with hospital, hotel, travel, or
                            language
                            needs.
                            <br>
                            5. follow up by the same doctor after treatment from abroad. <br>
                        </p>
                        <br> <br>
                        <h4>
                            Online Pharmacy Services
                        </h4>
                        <hr>
                        <p>
                            1. M-care lists numerous medicine & healthcare items on its Platform. <br>
                            2. User(s) can simply search and select necessary items for the list. <br>
                            3. In order to purchase Medicine, user(s) are required to upload a copy of the prescription on
                            the
                            Platform. <br>
                            4. Upon receiving your prescription, our pharmacist will verify it and should they find any
                            discrepancies in it, our pharmacist will cancel the order right away. <br>
                            5. When our pharmacist finds that the prescription is valid, he/she will call the user(s) to
                            confirm
                            the order. <br>
                            6. Unregistered user(s) are required to provide name, age, gender, email, mobile number and
                            their
                            address and such other details as may be required, for providing the Services. <br>
                            7. User(s) are required to make payment as generated based on medicine(s) ordered. Payments can
                            be
                            made through the available payment options. <br>
                            8. User(s) will receive the ordered medicines at the address specified by them. <br>
                        </p>
                        <br> <br>
                        <h4>
                            Payments
                        </h4>
                        <hr>
                        <p>
                            Payments towards Services available online Payment Mechanisms on the Platform (Like debit
                            cards,
                            credit cards, mobile banking, e-wallets etc.) through payment gateways and payments are
                            processed as
                            per the terms and conditions of respective payment gateway service provider(s). User(s) are
                            advised
                            to read and understand those terms and proceed with making payment only if such terms and
                            conditions
                            are acceptable to them.
                        </p>
                        <br> <br>
                        <h4>
                            FORCE MAJEURE
                        </h4>
                        <hr>
                        <p>
                            M-care shall not be liable to the User(s) for any delay or non-performance of its obligations
                            arising from any cause beyond its reasonable control including but not limited to any act of
                            God,
                            governmental act, act of any regulatory authority, supervening illegality, war, malicious
                            damage,
                            fire, flood, epidemics, pandemic(s), including but not limited to coronavirus (COVID-19) or any
                            other health risk outbreaks, explosion, power blackout, breakdown of any equipment, loss of
                            utility,
                            civil commotion, industrial dispute, acts or omissions of telecommunications or data
                            communications
                            operators or carriers or of any other third parties or, in relation to the Services any
                            technical or
                            other problems affecting any operation of the Services (a "Force Majeure Event"). M-care shall
                            as
                            practicable as possible shall promptly notify the User(s) orally or in writing, as the
                            circumstances
                            warrant, of the cause and the Force Majeure Event and its likely duration.
                        </p>
                        <br> <br>
                        <h4>
                            Termination of User(s) Account
                        </h4>
                        <hr>
                        <p>
                            M-care reserves its right to terminate/block the User Account, <br>

                            1. If User(s) furnishes false information, <br>
                            2. without assigning any reason, by written notice of 30 (thirty) days, <br>
                            3. if User(s) is in breach of its material obligations under this Agreement,<br>
                            4. if User(s) frequently cancels the Services or frequently returns the ordered products without
                            any
                            justifiable reasons, <br>
                            5. if the User(s) is engaged in any fraudulent transactions/activities,<br>
                            6. if the User(s) misuses, abuses, indulges in activities causing service disruptions,<br>
                            7. if the User(s) (i) is adjudicated insolvent; (ii) makes a general assignment for the benefit
                            of
                            creditors; or (iii) has a receiver or official liquidator appointed for the whole or any
                            substantial
                            part of its assets and such appointment is not dismissed, reversed, vacated or stayed within 60
                            (sixty) business days of such appointment,<br>
                            8. The termination of User(s) Account shall be without prejudice to any rights which have
                            already
                            accrued to M-care.
                            <br>
                        </p>
                        <br> <br>
                        <h4>
                            GENERAL
                        </h4>
                        <hr>
                        <p>
                            1. If any provision of these Terms is determined to be invalid or unenforceable in whole or in
                            part,
                            such invalidity or unenforceability shall attach only to such provision or part of such
                            provision
                            and the remaining part of such provision and all other provisions of these Terms shall continue
                            to
                            remain in full force and effect. <br>
                            2. A failure to exercise or delay in exercising a right or remedy by M-care provided for in
                            these
                            Terms or by law does not constitute a waiver of that or any other right or remedy. No single or
                            partial exercise of a right or remedy provided by these Terms or by law shall prevent a further
                            exercise of the right or remedy or the exercise of any other right or remedy. <br>
                            3. Except as specifically provided, no person who is not a party to these Terms shall be
                            entitled to
                            enforce any term of it. <br>
                            4. Save as expressly provided in this Agreement, nothing in these Terms is intended or shall be
                            construed to confer upon or give any User(s), any rights or remedies under or by reason of these
                            Terms or any transaction contemplated by these Terms. <br>
                            5. Nothing in these Terms is intended to, or shall be deemed to, establish any partnership or
                            joint
                            venture between any of the Parties, nor authorize any Party to make or enter into any
                            commitments
                            for or on behalf of any other party. <br>
                            6. User(s) are responsible for creating and maintaining their User Account. M-care shall not be
                            liable for unauthorized use of the User Account, including but not limited to the misuse, loss,
                            non-availability of User(s) data, the User(s) should secure their credentials safely and prevent
                            from giving/letting unauthorized access. <br>
                            7. If the User(s) delete any of their User information, the same may be still available in the
                            backup servers or storage devices/medium/peripherals /copies. <br>
                            8. M-care does not warrant that the Services available through its Platform will be available
                            without any disruption or errors. The availability of the Services on this Platform may be
                            disrupted
                            due to down time, maintenance, updates, bugs/virus or any other system related issues, internet
                            service issues, access related issues, connectivity issues, force majeure situations,
                            non-availability of healthcare professionals or for any other reasons beyond the reasonable
                            control
                            of M-care and M-care hereby disclaims all liability for the losses or damages caused or suffered
                            by
                            healthcare professionals on this account. <br>

                            12. User(s)/Visitors to this platform are proscribed from the following Prohibited use<br>

                            1. host, display, upload, modify, publish, transmit, update or share any information that
                            I. belongs to another person and to which the user does not have any right;
                            II. is defamatory, obscene, pornographic, pedophilic, invasive of another’s privacy, including
                            bodily privacy, insulting or harassing on the basis of gender, libelous, racially or ethnically
                            objectionable, relating or encouraging money laundering or gambling, or otherwise inconsistent
                            with
                            or contrary to the laws in force;
                            III. is harmful to child;
                            IV. infringes any patent, trademark, copyright or other proprietary rights;
                            V. violates any law for the time being in force;
                            VI. deceives or misleads the addressee about the origin of the message or knowingly and
                            intentionally communicates any information which is patently false or misleading in nature but
                            may
                            reasonably be perceived as a fact;
                            VII. impersonates another person;
                            VIII. threatens the unity, integrity, defense, security or sovereignty of Bangladesh, friendly
                            relations with foreign States, or public order, or causes incitement to the commission of any
                            cognizable offense or prevents investigation of any offense or is insulting other nation;
                            IX. contains software virus or any other computer code, file or program designed to interrupt,
                            destroy or limit the functionality of any computer resource;
                            X. is patently false and untrue, and is written or published in any form, with the intent to
                            mislead
                            or harass a person, entity or agency for financial gain or to cause any injury to any person


                            2. furnishing false or incomplete information and making unsolicited statements,<br>
                            3. In the event of any prohibited use by the User(s) on this Digital Platform, M-care or Third
                            Party
                            Service Provider(s) may file appropriate complaints or inform the law enforcement agencies for
                            further necessary action.<br>

                            13. M-care reserves the right to delete any document or record which the User(s) may upload on
                            this
                            Digital Platform containing virus(s), Trojans or such other malware and User(s) agree that it
                            shall
                            not hold M-care responsible or liable in any way for deleting or restricting upload access to
                            their
                            documents or records.<br>

                            14. User(s)/Healthcare Professionals hereby acknowledge and agree that they shall not,<br>

                            1. recreate, duplicate, reverse engineer, decompile, recompile, disassemble or otherwise
                            reproduce
                            directly or indirectly, any part or whole of the Platform in or any materials relating thereto,<br>
                            2. design around M-care’s proprietary projects, materials and products,<br>
                            3. use the M-care’s Services, Content of the Platform, Confidential Information as a basis upon
                            which to develop or have a Third Party develop a competing or similar product. Further the
                            User(s)/HCPs/HSPs or any Third Party/Parties shall not contact or attempt to contact the Third
                            Party
                            Service Provider(s) on this Platform in any form either to promote its business or lure them to
                            enter into a business relationship with them or with the M-care’s competitors’,
                            4. copy the content on this Platform,<br>
                            5. use any software, tool or engine or any kind of device/mechanism, including but not limited
                            to
                            robots, spiders, artificial intelligence tools/agents to crawl, spy, navigate, to search,
                            scramble,
                            copy, duplicate, steal the Platform or the contents therein,<br>
                            <br>
                            15. In case of non-receipt of any SMS (es), messages, communications or notices by the User(s),
                            regarding the status of the Services booked/canceled/ordered/availed, User(s) are advised to
                            contact
                            M-care’s Customer Care number and request for the same
                            <br>
                            18. Users’ please note that the Internet is inherently insecure or may be prone to various types
                            of
                            phishing attacks or other forms of attacks and that the data including but not limited to
                            User(s)/Healthcare Professionals may be prone to such attacks or can become corrupted, or any
                            communications may not always be delivered promptly or not delivered at all, electronic
                            communications are also prone to various forms of contamination including but not limited to
                            viruses. Users acknowledge and agree that it shall not hold M-care liable for any loss,
                            expenses,
                            damages, or omission in any way that it may incur due to the Users’ interaction with the M-care
                            Digital Platform
                            <br>
                            21. User(s) may post their feedback, including but not limited to ratings, reviews, suggestions
                            and
                            any other content relating to Services of M-care ("Feedback") on M-care’s Platform, M-care’s
                            domain
                            or any other platforms including on social media pages/platforms or mobile app stores (social
                            media
                            pages/platforms or mobile app stores are collectively referred to as “Social Media”).
                            <br>
                            24. Further all Parties accessing, visiting this platform or availing the services available on
                            M-care beware that there are/might be entities or persons (Imposters) pretending or imitating to
                            be
                            like M-care or associated with/partner of M-care and may trick or lure You/Parties demanding
                            payments towards services or otherwise and these Imposters may fraudulently/unauthorized use
                            M-care’s intellectual property, name, logo to deceit or cheat You. All Parties are therefore
                            advised
                            to cross verify with M-care in case they find any activity to be fraudulent or suspicious.
                            <br>
                            25. M-care requests the general public and strongly recommends not to rely on any unauthentic
                            information. Please beware of false messages being circulated on social media under M-care’s
                            brand
                            name and logo. M-care requests you to consult any professional doctor or utilize the Services on
                            the
                            Digital Platform to seek clarifications on any health related queries.
                            <br>
                            26. User(s) shall refrain from posting false, frivolous, baseless, unauthentic information on
                            social
                            media platforms regarding M-care and the Services provided by M-care.
                            <br>
                            27. User(s)/ Healthcare Professionals herein may please note that under no circumstances, M-care
                            will be responsible or liable for claims, losses, damages, expenses or for any other form of
                            compensation or otherwise on account of, resulting from or in any way connected to the acts of
                            the
                            Imposters or due to the unauthorized use of its Intellectual Property.<br>
                        </p>
                        <br> <br>

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
