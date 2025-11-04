 <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
 </style>
 <main id="page-content">
     <form action="#">
         <section class="hospital_fiancial_reports">
             <div class="container-fluid">
                 <div class="row">
                     <div class="col-md-12">
                         <div class="row bg-white border-bottom sticky-top shadow-sm">
                             <div class="col-md-10">
                                 <h5 class="mt-2 mb-0">Pharmacy Stock Report</h5>
                                 <small>Reports / Pharmacy Stock Report</small>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-md-3">

                          @include('admin.uhl.finacial_report_sidebar')

                     </div>
                     <div class="col-md-9">
                         <div class="card">
                             <div class="card-body p-2">
                                 <div class="form-row">
                                     <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="major_group" class="col-form-label">Major Group</label>
                                             <select name="major_group" id="major_group"
                                                 class="form-control form-control-sm">
                                                 <option value="">Select</option>
                                                 <option value="">INVESTIGATION</option>
                                                 <option value="">PHARMACY</option>
                                                 <option value="">HOSPITAL SERVICES</option>
                                                 <option value="">CONSULTATION</option>
                                                 <option value="">IPD SERVICES</option>
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="minor_group" class="col-form-label">Minor Group</label>
                                             <select name="minor_group" id="minor_group"
                                                 class="form-control form-control-sm">
                                                 <option value="">Select</option>
                                                 <option value="">PATHOLOGY</option>
                                                 <option value="">RADIOLOGY</option>
                                                 <option value="">MEDICINE</option>
                                                 <option value="">NONMEDICINE</option>
                                                 <option value="">PROCEDURE</option>
                                                 <option value="">SURGERY</option>
                                                 <option value="">OPD</option>
                                                 <option value="">IPD</option>
                                                 <option value="">BED CHARGE</option>
                                                 <option value="">CANNULLA</option>
                                                 <option value="">OXYGEN</option>
                                                 <option value="">NABULIZATION</option>
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-lg-6 col-md-6 col-12">
                                         <div class="form-group">
                                             <label class="col-form-label col-form-label-sm"
                                                 for="allowed-dates">Date</label>
                                             <div class="input-group">
                                                 <div class="input-group-prepend">
                                                     <div class="input-group-text">From</div>
                                                 </div>
                                                 <input type="text"
                                                     class="form-control form-control-sm m-0 date-picker"
                                                     id="allowed-dates" name="allowed-dates" value=""
                                                     placeholder="dd-mm-yyyy" />
                                                 <div class="input-group-prepend">
                                                     <div class="input-group-text">To</div>
                                                 </div>
                                                 <input type="text"
                                                     class="form-control form-control-sm m-0 date-picker"
                                                     id="allowed_dates_to" name="allowed_dates_to" value=""
                                                     placeholder="dd-mm-yyyy" />
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="department" class="col-form-label">Department</label>
                                             <select name="department" id="department"
                                                 class="form-control form-control-sm">
                                                 <option value="">Select</option>
                                                 <option value="">OPD</option>
                                                 <option value="">IPD</option>
                                                 <option value="">EMERGENCY</option>
                                             </select>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="card mb-2">
                                     <div class="card-body p-2">
                                         <div class="form-group">
                                             <ul class="list-inline btn__box">
                                                 <li class="list-inline-item">
                                                     <button type="button" class="btn btn-secondary uhl_save_btn">
                                                         Show Report
                                                     </button>
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <button type="button" class="btn btn-secondary uhl_common_btn">
                                                         Export Excel
                                                     </button>
                                                 </li>
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

     <script>
         let arrow = document.querySelectorAll(".arrow");
         for (var i = 0; i < arrow.length; i++) {
             arrow[i].addEventListener("click", (e) => {
                 let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                 arrowParent.classList.toggle("showMenu");
             });
         }
     </script>

 </main>


 <script>
     $("body").addClass("sidebar-collapse");
 </script>
