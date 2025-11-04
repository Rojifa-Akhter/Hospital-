<!-- End Page -->
<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fe fe-chevrons-up"></i></a>

<!-- Jquery js-->
<script src="{{ asset('coverpage/assets/js/jquery-3.5.1.min.js') }}"></script>

<!-- Bootstrap4 js-->
<script src="{{ asset('coverpage/assets/plugins/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('coverpage/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!--Othercharts js-->
<script src="{{ asset('coverpage/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

<!-- Circle-progress js-->
<script src="{{ asset('coverpage/assets/js/circle-progress.min.js') }}"></script>

<!-- Jquery-rating js-->
<script src="{{ asset('coverpage/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!--Sidemenu js-->
<script src="{{ asset('coverpage/assets/plugins/sidemenu/sidemenu.js') }}"></script>

<!-- P-scroll js-->
<script src="{{ asset('coverpage/assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
<script src="{{ asset('coverpage/assets/plugins/p-scrollbar/p-scroll1.js') }}"></script>
<script src="{{ asset('coverpage/assets/plugins/p-scrollbar/p-scroll.js') }}"></script>


<!--INTERNAL Peitychart js-->
<script src="{{ asset('coverpage/assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
<script src="{{ asset('coverpage/assets/plugins/peitychart/peitychart.init.js') }}"></script>

<!--INTERNAL Apexchart js-->
<script src="{{ asset('coverpage/assets/js/apexcharts.js') }}"></script>

<!--INTERNAL ECharts js-->
<script src="{{ asset('coverpage/assets/plugins/echarts/echarts.js') }}"></script>

<!--INTERNAL Chart js -->
<script src="{{ asset('coverpage/assets/plugins/chart/chart.bundle.js') }}"></script>
<script src="{{ asset('coverpage/assets/plugins/chart/utils.js') }}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{ asset('coverpage/assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('coverpage/assets/js/select2.js') }}"></script>

<!--INTERNAL Moment js-->
<script src="{{ asset('coverpage/assets/plugins/moment/moment.js') }}"></script>

<!--INTERNAL Index js-->
<script src="{{ asset('coverpage/assets/js/index1.js') }}"></script>

<!--INTERNAL Clipboard js -->
<script src="{{ asset('coverpage/assets/plugins/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('coverpage/assets/plugins/clipboard/clipboard.js') }}"></script>


<!--INTERNAL Accordion js-->
<script src="{{ asset('coverpage/assets/plugins/accordion/accordion.min.js') }}"></script>
<script src="{{ asset('coverpage/assets/js/accordion.js') }}"></script>

<!-- Simplebar JS -->
<script src="{{ asset('coverpage/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>


<!-- Custom js-->
<script src="{{ asset('coverpage/assets/js/custom.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript"
src="{{ asset('node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>

{{-- <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script> --}}
<script type="application/javascript" src="{{ asset('js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

@include('admin.layouts.autocomplete_js')
@stack('admin_js')
</body>

</html>
