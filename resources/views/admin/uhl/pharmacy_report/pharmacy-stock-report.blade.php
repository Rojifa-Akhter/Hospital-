 <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
 <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

 <main id="page-content">
     <form action="{{ route('v1.search-pharmacy-stock-report') }}" method="post" target="_blank">
         @csrf
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
                                             <label for="major_group" class="col-form-label">Store Name</label>
                                             <select name="major_group" id="major_group" name="store_id"
                                                 class="form-control form-control-sm">
                                                 @if (!empty($stores))

                                                     @foreach ($stores as $store)
                                                         <option value="{{ $store->serviceunit_no_pk }}">
                                                             {{ $store->serviceunit_name }}</option>
                                                     @endforeach

                                                 @endif
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
                                                     class="form-control form-control-sm m-0 date_picker"
                                                     id="allowed-dates" name="from_date" autocomplete="off"
                                                     value="" placeholder="dd-mm-yyyy" />
                                                 <div class="input-group-prepend">
                                                     <div class="input-group-text">To</div>
                                                 </div>
                                                 <input type="text"
                                                     class="form-control form-control-sm m-0 date_picker"
                                                     autocomplete="off" id="allowed_dates_to" name="to_date"
                                                     value="" placeholder="dd-mm-yyyy" />
                                             </div>
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
                                                     <button type="submit" class="btn btn-secondary uhl_save_btn">
                                                         Show Report
                                                     </button>
                                                 </li>
                                                 {{-- <li class="list-inline-item">
                                                     <button type="button" class="btn btn-secondary uhl_common_btn">
                                                         Export Excel
                                                     </button>
                                                 </li> --}}
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

 @include('admin.uhl.finacial_report_sidebar_js')
 <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

 <script>
     $("body").addClass("sidebar-collapse");
     $(function() {
         $('.date_picker').datepicker({
             todayHighlight: true,
             clearBtn: true,
             autoclose: true,
             format: 'dd-mm-yyyy'
         });
     });
 </script>
