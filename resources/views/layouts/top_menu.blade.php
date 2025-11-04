<nav class="navbar navbar-two navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-3 col-lg-3">
				<a class="navbar-brand" href="index.html">
					{{-- <h4>iCure</h4> --}}
					{{-- <img src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}"> --}}
				</a>
			</div>

			<div class="col-12 col-md-9 col-lg-9">
				<div class="navbar-toggle-btn">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item"><a class="nav-link" href="#">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Network</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">List</a>
							<div class="dropdown-menu">
								<ul>
									<li><a class="dropdown-item" href="#">Registered Center</a></li>
									<li><a class="dropdown-item" href="#">Registered Patient</a></li>
									<li><a class="dropdown-item" href="#">Registered Therapist</a></li>
								</ul>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Appoinment</a>
							<div class="dropdown-menu">
								<ul>
									<li><a class="dropdown-item" href="appoinment.html">Patient Appontment</a></li>
									<li><a class="dropdown-item" href="appoinment-list.html">Apponted Patient</a></li>
								</ul>
							</div>
						</li>

						<li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
						<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
						<li class="nav-item"><a class="nav-link" href="{{ route('patientPortal.showLoginForm') }}">Patient Portal</a></li>
						<li class="nav-item"><a class="nav-link" href="{{ route('cover.signin') }}">Guest Login</a></li>
						<li class="nav-item"><a class="nav-link" href="{{ route('cover.signup') }}">Registration</a></li>

                         {{--
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Registration</a>
						
							<div class="dropdown-menu">
								<ul>
									<li><a class="dropdown-item" href="#">Physiotherapist</a></li>
									<li><a class="dropdown-item" href="#">Center Registration</a></li>
									<li><a class="dropdown-item" href="#">Patient Registration</a></li>
									<li><a class="dropdown-item" href="#">Referral/Agent</a></li>
								</ul>
							</div>
							
						</li>
						--}}
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>
