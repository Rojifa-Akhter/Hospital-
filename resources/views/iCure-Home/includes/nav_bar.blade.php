@php
$po_hospital_details = (isset($po_hospital_details) && (!empty($po_hospital_details))) ? $po_hospital_details : [];
$telephone = ($po_hospital_details) ? $po_hospital_details->telephone1 : '';
$email = ($po_hospital_details) ? $po_hospital_details->email : '';
$logo = ($po_hospital_details) ? $po_hospital_details->logo: '';
$hospital_code = strtoupper($po_hospital_details->hospital_code);
@endphp
<header>
    <!-- top bar -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ul class="information d-flex">
                        <li>
                            <i class="fas fa-phone"></i><span>{{ $telephone}}</span>
                        </li>
                        <li><i class="far fa-envelope-open"></i><a
                                href="#">{{ $email }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="top_bar_user d-flex justify-content-end">
                        <li><a href="{{ route('cover.signup') }}">Register</a></li>
                        <li><a href="{{ route('cover.signin') }}">Sign in</a></li>
                @if($hospital_code != "CHPC")

                        <li>
                            <a href="#"><i class="fab fa-gratipay"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <span>0.00</span>
                        </li>
                @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- top bar -->

    <!-- nav  -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img class="ml-1" src="{{ asset('images/uploads/hospital_images/'.$logo) }}" alt="logo" />
        @if($hospital_code != "CHPC")
            <a class="navbar-brand" href="{{ route('cover-page-v2') }}"><img
                    src="{{ asset('images/uploads/hospital_images/'.$logo) }}" alt="logo" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mcare.about-us') }}">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ ENV('ECOMMERCE') }}">Medicine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ENV('ECOMMERCE') }}">Health & Beauty</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cover.doctor-list') }}">Doctor List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cover.hospital-list') }}">Hospital</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mcare.contact-us') }}">Contact Us</a>
                    </li>
                </ul>
                <form class="upprescription form-inline my-2 my-lg-0">
                    <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal"><i
                            class="fas fa-upload"></i>Upload Pescription</button>
                </form>
            </div>
            @endif
        </div>
    </nav>
    <!-- nav  -->
</header>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form action="/action_page.php">
                    <label for="myfile">Upload pescription</label>
                    <input class="file_up" type="file" id="myfile" name="myfile" /><br />
                    <br />
                    <input class="submit" type="submit" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
