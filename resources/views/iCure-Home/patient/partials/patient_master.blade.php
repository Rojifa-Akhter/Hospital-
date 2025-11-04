
@include('iCure-Home.patient.partials.patient_head')
@include('iCure-Home.patient.partials.patient_preloader')

<!-- Page -->
<div class="page">
    <div class="page-main">
        <!--aside open-->
        <!--    --><?php //include('../partials/patient_partials/sidebar.php');?>
        @section('patient_content')

    @include('iCure-Home.patient.partials.patient_sidebar')
    <!--aside closed-->

        <!-- App-Content -->
        <div class="app-content main-content">
            <div class="side-app">
                <!--app header-->
                <!--            --><?php //include('../partials/patient_partials/header.php');?>
            @include('iCure-Home.patient.partials.patient_header')
            <!--/app header-->
                @yield('patient_content')





            {{--Patient Details--}}

{{--            @include('iCure-Home.patient.patient_details_data')--}}

            </div>
        </div>
        <!-- End app-content-->
    </div>



@include('admin.components.modal_popup')

    <!--Footer-->
<?php //include('../partials/patient_partials/footer.php');?>
@include('iCure-Home.patient.partials.patient_footer')
<!-- End Footer-->
</div>
<!-- End Page -->
<?php //include('../partials/patient_partials/foot.php');?>
@include('iCure-Home.patient.partials.patient_foot')
