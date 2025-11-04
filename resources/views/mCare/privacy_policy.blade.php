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
                            <h1>Privacy Policy</h1>
                            <b>Home <i class="fas fa-angle-double-right"> </i> <span>Privacy Policy</span> </b>
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
                        {{-- <h4 class="section_title">Privacy Policy</h4> --}}
                        <p class="mt-3">Your privacy is very important to us. This Privacy Policy explains how
                            MCARE handles personal information that we collect online, through our websites, applications
                            (apps), and offline interactions with you. Please read this Privacy Policy before using the
                            MCARE Services or submitting personal information to us.</p>


                        <br> <br>

                        <h4>Usage</h4>
                        <hr>
                        <p>
                            This Policy conveys the mode, method and manner in which MCARE collects stores and disseminates
                            the Personal Information (“Information”) from the Users (hereinafter referred to as “User”
                            “Users” or “you”). For the purpose of this Policy User(s) shall mean such individuals who wish
                            to subscribe to the Services (offered by MCARE by itself or through third party service
                            providers) on this Digital Platform by visiting this Digital Platform, MCARE therefore requests
                            the Users on this Digital Platform, to carefully and comprehensively read and understand the
                            Policy before they consent to the terms herein and start using or accessing this Digital
                            Platform or subscribing to any of the Services offered through this Digital Platform. In the
                            event of any disagreement or Users do not accept to the terms of this Policy or the Terms of Use
                            of this Digital Platform herein they are advised to forthwith disengage and leave this Digital
                            Platform.
                        </p>
                        <br> <br>
                        <h4>Modification </h4>
                        <hr>
                        <p>
                            Notwithstanding anything contained herein or the Terms of Use, MCARE reserves its right to add,
                            update, change, edit, alter, amend, modify, review, revise, vary or substitute this Policy with
                            or without prior notice. By using or accessing this Digital Platform, the Users categorically
                            agree to have read and understood this Policy/Terms of Use and acknowledge that they shall be
                            bound by the terms of this Policy/Terms of Use including any addition, update, change,
                            amendment, revision, modification and substitution. MCARE reserves its right to terminate the
                            services of any user who does not subscribe or violate the terms of this Policy.

                        </p>
                        <br> <br>
                        <h4>
                            Collection and Processing of Information
                        </h4>
                        <hr>
                        <p>
                            MCARE does not disclose or share any information which it collects from Users with Third
                            Party/Parties, save and except those mentioned in this Privacy Policy and, in accordance with
                            its Privacy Policy or as per procedure prescribed by law, or in compliance with legal
                            obligations
                        </p>
                        <br> <br>
                        <h4>
                            Information we collect from User(s)/you
                        </h4>
                        <hr>
                        <p>
                            Identity Details, Contact Details, Personal Health Information (PHI), Personal Data, Sensitive
                            Personal Data, Technical Information (such as IP address etc), Security Details (such as User
                            Name, Password), Other Details (as may be required for providing the Services), data from Google
                            Fit, and Apple Health and other fitness devices. We do not share any Identifiable Personal
                            Information with any individuals, organizations and other companies. User(s) information is
                            securely stored and utmost confidentiality is maintained and may be accessed/used/disseminated
                            by us as per the terms specified herein.
                        </p>
                        <br><br>
                        <h4>
                            Purpose for which information is collected from User(s)/you:
                        </h4>
                        <hr>
                        <p>
                            The Information provided by User(s)/you and collected by us on this Digital Platform may be
                            accessed/used/disseminated for the following purposes and the User(s) explicitly consent to the
                            same: <br>
                            a. Communicating with the User(s) <br>
                            b. Providing the Services contemplated under this Digital Platform<br>
                            c. Offering new Services<br>
                            d. Analytical purposes in anonymous form or as de-identified data and for this purpose we may
                            take assistance of our affiliates and trusted business partners for research, development,
                            studies, betterment of services, understanding the User(s) Experience, serving the individual
                            needs of the User(s) and improving the overall health delivery services/health outcome of the
                            User(s). MCARE may disclose aggregated information, but it will never contain Information that
                            will identify a single User.<br>
                            e. Obtaining feedback<br>
                            f. Record their telephonic, Video and chat conversations and/or consultations during their
                            interaction with HCPs and other support staff and MCARE can use it for legal, training and
                            quality purposes<br>
                            g. Customizing User(s) needs and send personalized communications<br>
                            h. To send messages including but not limited to emailers, bulk emailers, SMS etc intimating the
                            User(s) about MCARE ’s healthcare services, offers and other promotional content. These messages
                            may be sent using various third-party service providers<br>

                            When User(s) interact with or respond to an email campaign shared by MCARE, User(s) may be
                            redirected to third party website(s). The third-party website may collect information about
                            User(s) device, browser, IP address, operating system, interaction with an email etc. The
                            third-party websites may also use cookies or other tracking technologies to identify the
                            behavioural pattern of the User(s).<br>

                        </p>
                        <br><br>
                        <h4>
                            Processing, Disclosure and Sharing of information collected from the User (s)/you:
                        </h4>
                        <hr>
                        <p>
                            a. Information collected from the User(s)/HCPs/HSPs on the Digital Platform forms an essential
                            part
                            of business structure and may be shared/used as described herein below and User(s) hereby
                            consent to
                            the same:<br>
                            (i) Third Party Service Provider(s),
                            Information including but not limited to contact details, email ID will be shared with Third
                            Party
                            Service Provider(s), retailers, logistics service providers, E-mail Service Providers and other
                            providers for providing the Services for the User(s) pursuant to the User(s) requests,
                            especially
                            while facilitating the Pharmacy and Laboratory Services. Information is likely to be exchanged
                            while
                            fulfilling orders, delivering medicines, etc. and for sending communications through e-mailers.
                            <br>(ii) Analytics Purpose(s), User(s) Information/data in de-identified form may be used by
                            MCARE
                            or
                            shared with Third Party(ies) for Analytical Purposes for improving User(s) experience and
                            User(s)
                            use of the Platform.
                            <br>(iii) Other Associated Services, User(s) Information/Data may also be used for providing (a)
                            assistance, (b) effective search results and links (including listings and paid services) and
                            (c)
                            customer experience/service. MCARE assures that any information exchanged herein shall be in
                            accordance with its Privacy Policy.
                            <br>(iv) Information required by law, MCARE may share the information given by the User(s) if
                            directed
                            by any judicial or a statutory authority or against receipt of judicial or statutory order or to
                            comply with applicable law. Please be assured that no such information will be provided to any
                            Third
                            Party for any commercial purpose in any such way which is contrary to the commitments made under
                            the
                            Privacy Policy.
                            <br>(v) Information required for investigation, MCARE may share information in order to
                            investigate,
                            prevent, or take action regarding illegal activities, suspected fraud, situations involving
                            potential threats to the physical safety of any person, violations of these Terms and/or privacy
                            policy, or as otherwise required law.
                            In the event, if there is any information which has to be provided outside the scope of this
                            Privacy
                            Policy, a prior notification and request for consent /approval will be shared with the User(s).
                            <br>(vii) Any data/information supplied by the User(s)/you and collected by us shall be securely
                            stored
                            for the duration required under applicable law. In the event any User(s)/you are deleting their
                            account or a User account becomes inactive, the concerned User(s)/you shall have no access to
                            the
                            data/information supplied and collected by us and the same shall be deleted from our servers
                            after
                            the duration for which it is required to be stored
                            Editing Information:
                            After User(s) create the account and if there is any change in the Information provided earlier,
                            the
                            User(s) can edit their profile and make necessary modifications. User(s) are solely responsible
                            for
                            the Information provided by them.
                        </p>
                        <br>
                        <br>
                        <h4>
                            Cookie Policy:
                        </h4>
                        <hr>
                        <p>
                            Cookies are small pieces of text used to store information on web browsers. Cookies are used to
                            store and receive identifiers and other information on computers, phones and other devices.
                            Other
                            technologies, including data we store on your web browser or device, identifiers associated with
                            your device, and other software, are used for similar purposes. This Website and Mobile
                            Application
                            uses cookies to store certain data (that is not sensitive personal data or information) that is
                            used
                            to provide customized information when the User(s) or Unregistered User(s) returns to the
                            Website.
                            "Cookies" are used to store User(s) or Unregistered User(s) preferences and to track User(s) or
                            Unregistered User(s) trends, so as to enhance their interactive experience and generally improve
                            the
                            website’s services to them. In the course of serving advertisements or optimizing services to
                            its
                            User(s), MCARE may allow authorized third parties including but not limited Google Inc, E-Mail
                            Service Providers for analytical and statistical purposes and to place or recognize a unique
                            cookie
                            on the User’s or Unregistered User’s browser.
                        </p>
                        <br>
                        <br>
                        <h4>
                            Creation of User Account on behalf of third party:
                        </h4>
                        <hr>
                        <p>
                            If any User(s) creates an account on this Digital Platform for and on behalf of any other Party/
                            third party (other than for his use) like their family member(s)/friend(s) such User(s)
                            acknowledge
                            that they are duly authorized by the other Party/third party to create an account on this
                            Digital
                            Platform by furnishing such details as may be required for availing the Services, In case any
                            User(s) is/are creating account on behalf of a minor, such User(s) acknowledge that they are
                            legally
                            authorized to act on behalf of such minors. User(s) acknowledge that MCARE shall in no case be
                            held
                            responsible/liable for any third party claims/damages if any arising from any action in this
                            regard.
                        </p>
                        <br>
                        <br>
                        <h4>
                            Promotions:
                        </h4>
                        <hr>
                        <p>
                            With a view to provide better Services MCARE may send various communications to the User(s)
                            regarding its Products/Services If the User(s) do not wish to receive such communications they
                            may
                            unsubscribe to such communications as per the procedure set out in those communications.
                        </p>
                        <br>
                        <br>
                        <h4>
                            Financial Information:
                        </h4>
                        <hr>
                        <p>
                            For availing certain Services/Products the User(s) may be required to subscribe/purchase such
                            Services by entering requisite payment details. The payment details are captured by third party
                            service providers and the User(s) are advised to read the terms and conditions of such third
                            party
                            service providers before making any payment. For the purpose of this section it is clarified
                            that
                            the Digital Platform does not collect sensitive personal or security related information like
                            passwords etc., which are totally under encryption. User(s) may note the Third Party Service
                            Providers are not under the direction, supervision and control of MCARE and MCARE expressly
                            disclaims any and all liabilities associated, therewith. User(s) are advised to note this while
                            providing their personal or security related information.
                        </p>
                        <br>
                        <br>
                        <h4>
                            Access to the Digital Platform:
                        </h4>
                        <hr>
                        <p>
                            a. Registered User(s) will have complete access to the Digital Platform <br>
                            b. Unregistered User(s) will have restricted access to the Digital Platform
                            Unregistered User(s) please note that you shall also be bound by the terms of this Policy as
                            well as
                            the Terms of Use of this Digital Platform
                        </p>
                        <br>
                        <br>
                        <h4>
                            USER INFORMATION
                        </h4>
                        <hr>
                        <p>
                            ‘User information’ for the purpose of this Policy includes the User’s personally identifiable
                            information including but not limited to name, email address, residential address, phone number,
                            photograph, identity and address proof and other information collected by MCARE to provide its
                            Services/Products to the User through their Digital Platform. User(s) have the option not to
                            provide
                            any information if they do not intend to avail any Service/Product. If any User(s) are providing
                            information on behalf of any legal entity or third party, such User(s) should be authorized to
                            provide the information.
                        </p>
                        <br>
                        <br>
                        <h4>
                            SECURITY AND RESTRICTIONS
                        </h4>
                        <hr>
                        <p>
                            To protect your privacy and security, MCARE takes steps to verify Users’ identity before
                            granting
                            Users access to accounts or before Users can make corrections to their information. Users are
                            advised to maintain a strong password to help ensure the security of user accounts.
                            MCARE implements high standard security measures to protect User(s) Information from and against
                            unauthorized access. To this effect, MCARE uses certain, physical, managerial, technical and
                            operational safeguards as per industry standards and established best practices to protect
                            information of Users which is collected by MCARE.
                            Notwithstanding the above, User(s) may note that no online platform can fully eliminate the
                            security
                            risks. MCARE shall take all possible measures to protect the data, security, confidentiality and
                            integrity of the User(s) information from unauthorised access. User(s) may also note that
                            internet
                            where the Digital Platform is hosted is not completely a secure environment, therefore MCARE
                            does
                            not warrant a 100% security of the User(s) Information/data from being
                            hacked/misused/copied/used
                            unauthorizedly and in such cases User(s) agree not to hold MCARE responsible for any
                            consequences
                            arising therefrom.
                            Notwithstanding anything contained in this Policy or elsewhere, MCARE shall not be held
                            responsible
                            for any loss, damage or misuse of the User Information, if such loss, damage or misuse is
                            attributable to a Force Majeure Event. A "Force Majeure Event" means any event that is beyond
                            the
                            reasonable control of MCARE and includes, without limitation, fire, flood, explosion, acts of
                            God,
                            civil commotion, strikes, lock outs or industrial action of any kind, riots, insurrection, war,
                            acts
                            of government, power failure, sabotage, computer hacking, unauthorized access to computer data
                            and
                            storage device, system failure, virus, attacks, bugs, computer crashes, breach of security and
                            encryption.
                        </p>
                        <br>
                        <br>
                        <h4>
                            GENERAL TERMS
                        </h4>
                        <hr>
                        <p>
                            This Policy is to be read in conjunction with and shall be deemed to be part of the Digital
                            Platform
                            Terms of Use
                            The User Information resides in MCARE ’s database for a certain period of time even after the
                            User
                            ceases to use or access the Digital Platform and in such cases MCARE is not liable for any usage
                            of
                            the User Information after the User ceases to use or access the Digital Platform.
                            The Users hereby agree, consent and acknowledge that User Information shared by them, collected
                            or
                            collated through the Digital Platform could be stored, processed and handled by MCARE or through
                            its
                            trusted third party service providers as set out in this Privacy Policy.
                            The User should be aware that the User Information or other data, the User provides to the
                            Digital
                            Platform for availing the services or transacting through the Digital Platform could be read,
                            collected, or used by other users or third parties in which case the User Information might be
                            used
                            for sending messages or communications.
                            The User agrees and acknowledges MCARE’s right to utilize the User’s posts, contents,
                            information
                            and other personal data for the purpose of providing services through the Digital Platform. The
                            contents on the Digital Platform may contain comments, post and reviews posted by the Users
                            which
                            may be public and searchable on the internet in which case the User’s comments, post reviews and
                            information and personal data provided to the Digital Platform may be viewed by other users and
                            MCARE cannot guarantee that other users or third parties have not made copies of or used the
                            ideas
                            and information that the User has shared on the Digital Platform.
                            If User(s) unsubscribe from the Services and again intends to avail/subscribe to the Services,
                            he/she is authorizing MCARE to send such information as may be required, including but not
                            limited
                            to SMS, emails for enabling the User(s) to continue to avail the Services. User(s) hereby
                            explicitly
                            consent and agree that any request pursuant to this clause will override any opt-out/ override
                            any
                            opt-out unsubscribe request given by them earlier.
                        </p>
                        <br>
                        <br>
                        <h4>
                            GRIEVANCE OFFICER
                        </h4>
                        <hr>
                        <p>
                            In case of any complaints or grievances, the User may contact the Grievance Officer as under:
                            Head Customer Care
                            Wasi Tower, 572/K (13th Floor), Mirpur DOHS Road (ECB Chattar), Matikata, Dhaka Cantonment,
                            Dhaka-1206, Bangladesh
                        </p>



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
