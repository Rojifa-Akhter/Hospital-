<!DOCTYPE html>
<html lang="en">
<head>
    <title>iCure - Medical, Health Care and Doctor Clinic</title>
    @include('layouts.head')
</head>

<body data-spy="scroll" data-offset="70">
    <!-- Start Preloader Area -->
    <div class="preloader-area">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Navbar Area -->
    @include('layouts.top_menu')
    <!-- End Navbar Area -->

    <!-- Start Page Title Area -->
    <div class="page-title bg-f9faff">
        <div class="container">
            <h3>Appointed Patient List (Physio Center)</h3>
        </div>
    </div>
    <!-- End Page Title Area -->

    <section id="patient-list" class="mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="table-header">
                                <tr>
                                    <th class="text-center">SL#</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-left">Patient Name</th>
                                    <th class="text-center">Age</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Mobile</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Appoint Date</th>
                                    <th class="text-center">Pref. Center/Physio</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">PAT-0021</td>
                                    <td class="text-left">Patient-1</td>
                                    <td class="text-center">75</td>
                                    <td class="text-center">Male</td>
                                    <td class="text-center">Dhaka</td>
                                    <td class="text-center">+880 172 6320002</td>
                                    <td class="text-center">example@mail.com</td>
                                    <td class="text-center">12-07-2020</td>
                                    <td class="text-center">Center-1</td>
                                    <td class="text-center">Status-2</td>
                                    <td class="text-center"><button type="button" class="btn btn-sm">Response</button></td>
                                </tr>


                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">PAT-0021</td>
                                    <td class="text-left">Patient-1</td>
                                    <td class="text-center">75</td>
                                    <td class="text-center">Male</td>
                                    <td class="text-center">Dhaka</td>
                                    <td class="text-center">+880 172 6320002</td>
                                    <td class="text-center">example@mail.com</td>
                                    <td class="text-center">12-07-2020</td>
                                    <td class="text-center">Center-1</td>
                                    <td class="text-center">Status-2</td>
                                    <td class="text-center"><button type="button" class="btn btn-sm">Response</button></td>
                                </tr>


                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">PAT-0021</td>
                                    <td class="text-left">Patient-1</td>
                                    <td class="text-center">75</td>
                                    <td class="text-center">Male</td>
                                    <td class="text-center">Dhaka</td>
                                    <td class="text-center">+880 172 6320002</td>
                                    <td class="text-center">example@mail.com</td>
                                    <td class="text-center">12-07-2020</td>
                                    <td class="text-center">Center-1</td>
                                    <td class="text-center">Status-2</td>
                                    <td class="text-center"><button type="button" class="btn btn-sm">Response</button></td>
                                </tr>


                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('layouts.footer')
</body>
</html>
