<footer>
    {{-- <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="subscribe-text mb-15">
                    <h2>GET OFFER</h2>
                </div>
            </div>
            <div class="col-md-8">
                <div class="subscribe-wrapper">
                    <div class="subscribe-form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Your email here"
                                aria-label="Recipient's username" aria-describedby="button-addon2" />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">SUBSCRIBE
                                    NOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container py-4">
        <div class="row gy-4 gx-5 justify-content-center padd">
            <!-- widget -->
            <div class="col-md-4 col-sm-4">
                <div class="widget1">
                    <h5>About Us</h5>
                    <p><span> MCARE </span> exists to provide a better customer experience. We are a one-stop-shop
                        for your healthcare products, medicine, offering caring doctors, hospitals and much more.</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-4">
                <div class="widget2">
                    <ul class="">
                        <li><a href="{{ route('mcare.about-us') }}">About Us</a></li>
                        <li><a href="{{ route('mcare.privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('mcare.terms-condition') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('mcare.refund-policy') }}">Refund Policy</a></li>
                        <li><a href="{{ route('mcare.contact-us') }}">Contact Us</a></li>
                    </ul>
                   <!--  <a href="#"><img src="images/googleplay.png" alt="" /></a> -->
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="widget3 text-right">
                    <h5 class="mb-3">Contacts</h5>
                    <ul>
                        <li>
                            <a
                                href="#">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</a>
                        </li>
                        <li>
                            <a
                                href="#">{{ isset($po_hospital_details->email) ? $po_hospital_details->email : '' }}</a>
                        </li>
                        <li>
                            <span>Wasi Tower (13th Floor) , 572/K , ECB Chattar, Matikata, <br>Dhaka Cantonment,
                                Dhaka-1206,
                                Bangladesh</span>
                        </li>
                    </ul>
                    <ul class="payment_img d-flex">
                        <li>
                            <a href="#"><img src="{{ asset('images/nagad.png') }}" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('images/bkas.png') }}" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('images/visa.png') }}" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('images/master.png') }}" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('images/amex2.jpg') }}" alt="" /></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- widget -->

    <div class="bottom-footer text-center">
        <p class="copyright">Copyright &copy; {{ date('Y') }} All rights reserved | <span> MCARE </span></p>
    </div>
</footer>
