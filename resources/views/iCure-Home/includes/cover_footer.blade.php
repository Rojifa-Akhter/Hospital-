
<!-- jQuery -->
<script src="{{asset('coverpage/js/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap JS -->
<!-- scripts -->
<script src="{{asset('coverpage/js/scripts.js')}}"></script>
<script src="{{asset('coverpage/js/bootstrap.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
{{--<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>--}}
<script type="application/javascript" src="{{ asset('js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("body").addClass("sidebar-collapse");

    $('body').on('focus', ".timepicker", function() {
        $(this).timepicker();
    });

    $(".doctor_list_slider").click({
        infinite: false,
        slidesToShow: 7,
        slidesToScroll: 2,
        autoplay: false,
        autoplaySpeed: 2000,
        infinite: true,
        arrows:true,
        prevArrow: '<i class="fas fa-chevron-right"></i>',
        nextArrow: '<i class="fas fa-chevron-left"></i>',
        responsive: [{

            breakpoint: 1500,
            settings: {
                slidesToShow: 6,
                infinite: true
            }

        }, {

            breakpoint: 1201,
            settings: {
                slidesToShow: 5,
                dots: true
            }

        }, {

            breakpoint: 991,
            settings: {
                slidesToShow: 4,
                dots: true,
                arrows:false,
            }

        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
                dots: true,
                arrows:false
            }

        }]
    });

</script>
@include('admin.layouts.autocomplete_js')
@stack('custom_js')
</body>
</html>
