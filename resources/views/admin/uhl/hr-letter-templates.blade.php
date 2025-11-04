<style>
    .redactor_.redactor_editor {
        color: #222 !important;
    }
</style>
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">HR Letter Templates</h5>
                        <small>HRM / HR Letter Templates</small>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav flex-column">
                                    <h5>List Of Letters</h5>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Invite for Interview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Appointment Letter</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Employee Evaluation Letter</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Employee Confirmation Letter (6 Months
                                            Completed)</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Employee Clearance Letter</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Notification (Award Letter) of Promotion</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Notification (Award Letter) of Increment</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Termination Letter</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template-code" class="col-form-label">Template Code</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="template-code" name="template-code" placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template-name" class="col-form-label">Tempalte Name</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="template-name" name="template-name" placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template-type" class="col-form-label">Tempalte Type</label>
                                            <select class="form-control form-control-sm" id="template-type"
                                                name="template-type">
                                                <option>Letter</option>
                                                <option>SMS</option>
                                                <option>Email</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            {{-- <textarea class="form-control" id="" rows="12"></textarea> --}}
                                            {{-- <div class="container" style="border: 2px solid #000; padding: 20px;">
												<h2 class="text-center">Interview Invitation</h2>
												<p class="text-center">Applicant ID: <span id="applicantId">$$applicantid$$</span></p>
												<p class="text-center">Name: <span id="applicantName">$$applicantname$$</span></p>
												<p>Further to your application for the position of <span id="position">$$position$$</span>,</p>
												<p>I would be delighted if you could attend an interview on <span id="date">$$date$$</span> at <span id="time">$$time$$</span></p>
												<p>at <span id="address">$$address$$</span>.</p>
												<p>Please write to the above address or email (<span id="email">$$address$$</span>) to confirm that you can attend.</p>
												<p>(You may want to include a map for the location of the interview.)</p>
											</div> --}}
                                            <textarea class="form-control" rows="12" id="signature" name="signature" placeholder="Write Content Here"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Active</label>
                                            </div>
                                            <ul class="list-inline btn__box">

                                                <li class="list-inline-item mb-0 mt-0">
                                                    <button type="button" class="btn btn-secondary uhl_save_btn"
                                                        id="">Save</button>
                                                </li>

                                                <li class="list-inline-item"><button type="button"
                                                        class="btn btn-danger">Cancel</button></li>
                                            </ul>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>







            </div>
        </section>
    </form>
</main>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");

    loadEditor("signature");
</script>
