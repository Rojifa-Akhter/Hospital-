 <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
 <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
 <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

 <style>
     /*nav var css*/
     .sidebar {
         position: fixed;
         height: 100%;
         width: 319px;
         background: #1c7da3;
         background: -webkit-linear-gradient(to right, #1c7da3, #2eb5a7);
         background: linear-gradient(to right, #1c7da3, #2eb5a7);
         z-index: 100;
         transition: all 0.5s ease;
     }



     .sidebar .nav-links {
         height: 100%;
         padding: 0 0 150px 0;
         overflow: auto;
     }

     .sidebar.close .nav-links {
         overflow: visible;
     }

     .sidebar .nav-links::-webkit-scrollbar {
         display: none;
     }

     .sidebar .nav-links li {
         position: relative;
         list-style: none;
         transition: all 0.4s ease;
     }

     .sidebar .nav-links li:hover {
         background: #1d1b31;
     }

     .sidebar .nav-links li .icon-link {
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding-left: 15px;
         border-bottom: 2px solid #1c7da3;
     }

     .sidebar.close .nav-links li .icon-link {
         display: block;
     }

     .sidebar .nav-links li i {
         height: 50px;
         min-width: 78px;
         text-align: center;
         line-height: 50px;
         color: #fff;
         font-size: 20px;
         cursor: pointer;
         transition: all 0.3s ease;
     }

     .sidebar .nav-links li.showMenu i.arrow {
         transform: rotate(-180deg);
     }

     .sidebar.close .nav-links i.arrow {
         display: none;
     }

     .sidebar .nav-links li a {
         display: flex;
         align-items: center;
         text-decoration: none;
     }

     .sidebar .nav-links li a .link_name {
         font-size: 14px;
         font-weight: 600;
         color: #fff;
         transition: all 0.4s ease;
     }

     .sidebar.close .nav-links li a .link_name {
         opacity: 0;
         pointer-events: none;
     }

     .sidebar .nav-links li .sub-menu {
         padding: 6px 6px 14px 6px;
         margin-top: -10px;
         background: #1d1b31;
         display: none;
     }

     .sidebar .nav-links li.showMenu .sub-menu {
         display: block;
     }

     .sidebar .nav-links li .sub-menu a {
         color: #fff;
         font-size: 13px;
         padding: 5px 0;
         font-weight: 400;
         opacity: 0.8;
         transition: all 0.3s ease;
     }

     .sidebar .nav-links li .sub-menu a:hover {
         opacity: 1;
     }

     .sidebar.close .nav-links li .sub-menu {
         position: absolute;
         left: 100%;
         top: -10px;
         margin-top: 0;
         padding: 10px 20px;
         border-radius: 0 6px 6px 0;
         opacity: 0;
         display: block;
         pointer-events: none;
         transition: 0s;
     }

     .sidebar.close .nav-links li:hover .sub-menu {
         top: 0;
         opacity: 1;
         pointer-events: auto;
         transition: all 0.4s ease;
     }

     .sidebar .nav-links li .sub-menu .link_name {
         display: none;
     }

     .sidebar.close .nav-links li .sub-menu .link_name {
         font-size: 18px;
         opacity: 1;
         display: block;
     }

     .sidebar .nav-links li .sub-menu.blank {
         opacity: 1;
         pointer-events: auto;
         padding: 3px 20px 6px 16px;
         opacity: 0;
         pointer-events: none;
     }

     .sidebar .nav-links li:hover .sub-menu.blank {
         top: 50%;
         transform: translateY(-50%);
     }

     .sidebar .profile-details {
         position: fixed;
         bottom: 0;
         width: 260px;
         display: flex;
         align-items: center;
         justify-content: space-between;
         background: #1d1b31;
         padding: 12px 0;
         transition: all 0.5s ease;
     }

     .sidebar.close .profile-details {
         background: none;
     }

     .sidebar.close .profile-details {
         width: 78px;
     }

     .sidebar .profile-details .profile-content {
         display: flex;
         align-items: center;
     }

     @media (max-width: 420px) {
         .sidebar.close .nav-links li .sub-menu {
             display: none;
         }
     }

     /*nav var css*/
 </style>
 <main id="page-content">
     {{-- <form action="#"> --}}
     <section class="hospital_fiancial_reports">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <div class="row bg-white border-bottom sticky-top shadow-sm">
                         <div class="col-md-10">
                             <h5 class="mt-2 mb-0">Hospital Financial Reports</h5>
                             <small>Reports / Hospital Financial Reports</small>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="row">
                 {{-- <div class="col-md-3">
                     @include('admin.uhl.finacial_report_sidebar')
                 </div> --}}


                 <div class="col-md-12">
                     <form action="{{ route('v1.hospital-financial-report-print-pdf') }}" id="searchFormId"
                         method="post" target="_blank">
                         @csrf
                         <div class="card">
                             <div class="card-body p-2">
                                 <div class="form-row">
                                     {{-- <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="major_group" class="col-form-label">Major Group</label>
                                             <select name="major_group" id="major_group"
                                                 class="form-control form-control-sm" disabled>
                                                 <option value="">Select Major Group</option>
                                                 @if (!empty($major_group_list))
                                                     @foreach ($major_group_list as $rd)
                                                         <option value="{{ $rd->itemtype_no_pk }}">
                                                             {{ $rd->item_type_name }}</option>
                                                     @endforeach
                                                 @endif
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="minor_group" class="col-form-label">Minor Group</label>
                                             <select name="minor_group" id="minor_group"
                                                 class="form-control form-control-sm" disabled>
                                                 <option value="">Select Minor Group</option>
                                                 @if (!empty($minor_group_list))
                                                     @foreach ($minor_group_list as $rd)
                                                         <option value="{{ $rd->itemtype_no_pk }}">
                                                             {{ $rd->item_type_name }}</option>
                                                     @endforeach
                                                 @endif
                                             </select>
                                         </div>
                                     </div> --}}
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
                                                     id="allowed-dates" name="allowed_dates" value=""
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

                                     {{-- <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="department" class="col-form-label ">Department</label>
                                             <select name="department" id="department"
                                                 class="form-control form-control-sm select2" dissabled>
                                                 <option value="">Select Department</option>
                                                 @if (!empty($requestDepts))
                                                     @foreach ($requestDepts as $rd)
                                                         <option value="{{ $rd->serviceunit_name }}">
                                                             {{ $rd->serviceunit_name }}</option>
                                                     @endforeach
                                                 @endif


                                             </select>
                                         </div>
                                     </div>

                                     <div class="col-lg-3 col-md-6 col-12">
                                         <div class="form-group">
                                             <label for="modules" class="col-form-label">Modules</label>
                                             <select name="modules" id="modules" class="form-control form-control-sm"
                                                 disabled>
                                                 <option value="">Select Module</option>
                                                 @if (!empty($modules))
                                                     @foreach ($modules as $rd)
                                                         <option value="{{ $rd->module_no_pk }}">
                                                             {{ $rd->module_name }}</option>
                                                     @endforeach
                                                 @endif
                                             </select>
                                         </div>
                                     </div> --}}

                                     <div class="col-lg-6 col-md-6 col-12">
                                         <div class="form-group">
                                             {{-- <button type="button" id="searchItem"
                                                 class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i>
                                                 Search</button> --}}

                                             {{-- <button type="button" id="pdf"  class="btn btn-info btn-md mt-4"
                                                 onclick="exportPDF()"><i class="fa fa-print"></i> Export in
                                                 PDF</button> --}}

                                             <button type="button" id="IPD" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFIPD()"><i class="fa fa-print"></i>
                                                 IPD
                                                 Report</button>

                                             {{-- <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                                 class="btn btn-primary btn-md mt-4"><i
                                                     class="fa
                                                     fa-file-excel"></i>
                                                 Export in
                                                 Excel</button> --}}

                                             <button type="button" id="OPD" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFOPD()"><i class="fa fa-print"></i>
                                                 OPD
                                                 Report</button>

                                             <button type="button" id="OT" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFOT()"><i class="fa fa-print"></i> OT
                                                 Report</button>

                                             <button type="button" id="Pharmacy" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFPharmacy()"><i
                                                     class="fa fa-print"></i> Pharmacy Details
                                                 Report</button>
                                             <button type="button" id="Pharmacy" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFSummaryPharmacy()"><i
                                                     class="fa fa-print"></i> Pharmacy Summary
                                                 Report</button>
                                             <button type="button" id="PATHOLOGY" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFPathology()"><i
                                                     class="fa fa-print"></i> Pathology
                                                 Report</button>
                                             <button type="button" id="RADIOLOGY" class="btn btn-info btn-md mt-4"
                                                 onclick="exportPDFRadiology()"><i class="fa fa-print"></i> Radiology
                                                 Report</button>

                                             <button type="button" id="ICU" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFIcu()"><i class="fa fa-print"></i>
                                                 ICU
                                                 Report</button>

                                             <button type="button" id="NICU" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFNicu()"><i class="fa fa-print"></i>
                                                 NICU
                                                 Report</button>

                                             <button type="button" id="CCU" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFCcu()"><i class="fa fa-print"></i>
                                                 CCU
                                                 Report</button>

                                            <button type="button" id="CCU" class="btn btn-info btn-md mt-4"
                                                target="_blank" onclick="exportPDFPicu()"><i class="fa fa-print"></i>
                                                PICU Report</button>

                                             <button type="button" id="DAILYSTATEMENT"
                                                 class="btn btn-info btn-md mt-4" target="_blank"
                                                 onclick="exportPDFDailyStatement()"><i class="fa fa-print"></i> Daily
                                                 Statement-Hospital
                                             </button>

                                             <hr/>

                                            <button type="button" id="IPD" class="btn btn-info btn-md"
                                                target="_blank" onclick="exportExcelIPD()"><i class="fa fa-print"></i>
                                                IPD Report Excel</button>

                                            <button type="button" id="OPD" class="btn btn-info btn-md"
                                                target="_blank" onclick="exportExcelOPD()"><i class="fa fa-print"></i>
                                                OPD Report Excel</button>

                                            <button type="button" id="OT" class="btn btn-info btn-md"
                                                target="_blank" onclick="exportExcelOT()"><i class="fa fa-print"></i> 
                                                OT Report Excel</button>
                                            
                                            <button type="button" id="Pharmacy" class="btn btn-info btn-md mt-1"
                                                target="_blank" onclick="exportExcelPharmacy()"><i class="fa fa-print"></i> 
                                                Pharmacy Details Report Excel</button>
                                            
                                            <button type="button" id="Pharmacy" class="btn btn-info btn-md mt-1"
                                                target="_blank" onclick="exportExcelSummaryPharmacy()"><i class="fa fa-print"></i> 
                                                Pharmacy Summary Report Excel</button>
                                            
                                            <button type="button" id="PATHOLOGY" class="btn btn-info btn-md mt-1"
                                                target="_blank" onclick="exportExcelPathology()"><i class="fa fa-print"></i> 
                                                Pathology Report Excel</button>

                                            {{-- <button type="button" id="RADIOLOGY" class="btn btn-info btn-md mt-4"
                                                 onclick="exportPDFRadiology()"><i class="fa fa-print"></i> Radiology
                                                 Report</button>

                                             <button type="button" id="ICU" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFIcu()"><i class="fa fa-print"></i>
                                                 ICU
                                                 Report</button>

                                             <button type="button" id="NICU" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFNicu()"><i class="fa fa-print"></i>
                                                 NICU
                                                 Report</button>

                                             <button type="button" id="CCU" class="btn btn-info btn-md mt-4"
                                                 target="_blank" onclick="exportPDFCcu()"><i class="fa fa-print"></i>
                                                 CCU
                                                 Report</button>

                                            <button type="button" id="CCU" class="btn btn-info btn-md mt-4"
                                                target="_blank" onclick="exportPDFPicu()"><i class="fa fa-print"></i>
                                                PICU Report</button>

                                             <button type="button" id="DAILYSTATEMENT"
                                                 class="btn btn-info btn-md mt-4" target="_blank"
                                                 onclick="exportPDFDailyStatement()"><i class="fa fa-print"></i> Daily
                                                 Statement-Hospital
                                             </button> --}}

                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                         <input type="hidden" value="" name="hdn_download_type" id="hdn_download_type">
                     </form>

                     {{-- <div class="row">
                         <div class="col-md-12">
                             <div class="card mb-2">
                                 <div class="card-body p-2" id="hospitalListData">
                                     @include('admin.uhl.financial_report.hospital_financial_list')
                                 </div>
                             </div>
                         </div>
                     </div> --}}
                 </div>
             </div>






         </div>
     </section>
     {{-- </form> --}}
     <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
     <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
     @include('admin.uhl.finacial_report_sidebar_js')
     <script>
         $('.select2').select2({})
         $(function() {
             $('.date-picker').datepicker({
                 todayHighlight: true,
                 clearBtn: true,
                 autoclose: true,
                 endDate: '+0d',
                 'format': 'dd/mm/yyyy'
             });
         });

         // Print
         $(document).on("click", "#searchItem", function(e) {
             var formID = $("#searchFormId").attr("id");
             var formMethod = $("#searchFormId").attr("method");
             $("#searchItem").attr('action', "{{ url('v1/hospital2-financial-report-print-search') }}");
             $.ajax({
                 data: $('#' + formID).serialize(),
                 url: "{{ url('v1/hospital2-financial-report-print-search') }}",
                 type: formMethod,
                 beforeSend: function() {
                     blockUI();
                 },
                 success: function(data) {
                     $("#hospitalListData").html(data);
                     $("#searchFormId").attr('action',
                         "{{ route('v1.hospital-financial-report-print-pdf') }}");
                 },
                 complete: function() {
                     $.unblockUI();
                 }
             });
         });

         function exportexcel(element) {
             $("#hdn_report_type").val("EXCEL");
             $("#searchFormId").submit();
         }

         function exportPDF(element) {
             $("#hdn_report_type").val("PDF");
             $("#searchFormId").submit();
         }

        // IPD
         function exportPDFIPD(element) {
             $("#hdn_report_type").val("IPD");
            $("#hdn_download_type").val("PDF");
             $("#searchFormId").submit();
         }

        function exportExcelIPD(element) {
            $("#hdn_report_type").val("IPD");
            $("#hdn_download_type").val("EXCEL");
            $("#searchFormId").submit();
        }

        // OPD
         function exportPDFOPD(element) {
             $("#hdn_report_type").val("OPD");
            $("#hdn_download_type").val("PDF");
             $("#searchFormId").submit();
         }

        function exportExcelOPD(element) {
            $("#hdn_report_type").val("OPD");
            $("#hdn_download_type").val("EXCEL");
            $("#searchFormId").submit();
        }

        // OT
         function exportPDFOT(element) {
             $("#hdn_report_type").val("OT");
             $("#hdn_download_type").val("PDF");
             $("#searchFormId").submit();
         }
         
        function exportExcelOT(element) {
            $("#hdn_report_type").val("OT");
            $("#hdn_download_type").val("EXCEL");
            $("#searchFormId").submit();
        }

        // Pharmacy Details
         function exportPDFPharmacy(element) {
             $("#hdn_report_type").val("PHARMACY");
            $("#hdn_download_type").val("PDF");
             $("#searchFormId").submit();
         }

        function exportExcelPharmacy(element) {
            $("#hdn_report_type").val("PHARMACY");
            $("#hdn_download_type").val("EXCEL");
            $("#searchFormId").submit();
        }

        // Pharmacy Summary
         function exportPDFSummaryPharmacy(element) {
             $("#hdn_report_type").val("PHARMACYSUMMARY");
            $("#hdn_download_type").val("PDF");
             $("#searchFormId").submit();
         }
        
        function exportExcelSummaryPharmacy(element) {
            $("#hdn_report_type").val("PHARMACYSUMMARY");
            $("#hdn_download_type").val("EXCEL");
            $("#searchFormId").submit();
        }

        // Pathology
         function exportPDFPathology(element) {
             $("#hdn_report_type").val("PATHOLOGY");
            $("#hdn_download_type").val("PDF");
             $("#searchFormId").submit();
         }

        function exportExcelPathology(element) {
            $("#hdn_report_type").val("PATHOLOGY");
            $("#hdn_download_type").val("EXCEL");
            $("#searchFormId").submit();
        }

         function exportPDFRadiology(element) {
             $("#hdn_report_type").val("RADIOLOGY");
             $("#searchFormId").submit();
         }

         function exportPDFIcu(element) {
             $("#hdn_report_type").val("ICU");
             $("#searchFormId").submit();
         }

         function exportPDFNicu(element) {
             $("#hdn_report_type").val("NICU");
             $("#searchFormId").submit();
         }

         function exportPDFCcu(element) {
             $("#hdn_report_type").val("CCU");
             $("#searchFormId").submit();
         }

        function exportPDFPicu(element) {
            $("#hdn_report_type").val("PICU");
            $("#searchFormId").submit();
        }

         function exportPDFDailyStatement(element) {
             $("#hdn_report_type").val("DAILYSTATEMENT");
             $("#searchFormId").submit();
         }

         // key customize
         $("#major_group").on('keyup', function(e) {
             if (e.key === 'Enter' || e.keyCode === 13) {
                 $('#searchItem').focus()
             }
         });

         $("#minor_group").on('keyup', function(e) {
             if (e.key === 'Enter' || e.keyCode === 13) {
                 $('#searchItem').focus()
             }
         });

         $("#department").on('keyup', function(e) {
             if (e.key === 'Enter' || e.keyCode === 13) {
                 $('#searchItem').focus()
             }
         });

         $("#modules").on('keyup', function(e) {
             if (e.key === 'Enter' || e.keyCode === 13) {
                 $('#searchItem').focus()
             }
         });

         $("#searchItem").on('keyup', function(e) {
             if (e.key === 'Enter' || e.keyCode === 13) {
                 $('#pdf').focus()
             }
         });

         $("#pdf").on('keyup', function(e) {
             if (e.key === 'Enter' || e.keyCode === 13) {
                 $('#exportinexcel').focus()
             }
         });
     </script>

 </main>
