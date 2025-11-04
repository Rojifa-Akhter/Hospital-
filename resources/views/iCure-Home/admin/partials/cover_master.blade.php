@include("iCure-Home.admin.partials.head")
@include("iCure-Home.admin.partials.preloder")

<!-- Page -->
<div class="page">
    <div class="page-main">
        <!--aside open-->

        @if (Auth::user()->user_type == 'doc')
            @include("iCure-Home.admin.partials.sidebar")
        @else
        @include('iCure-Home.patient.partials.patient_sidebar')
        @endif
        <!--aside closed-->

        <!-- App-Content -->
        <div class="app-content main-content">
            <div class="side-app">
                <!--app header-->
                @include("iCure-Home.admin.partials.header")
                <!--/app header-->

                @yield('admin_content')

                {{-- content end --}}

            </div>
        </div>
        <!-- End app-content-->
    </div>

    <!--Footer-->
    @include('admin.components.modal_popup')
    @include("iCure-Home.admin.partials.footer")
    <!-- End Footer-->
</div>
<!-- End Page -->
@include("iCure-Home.admin.partials.foot")
