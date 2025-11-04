<script src="{{ asset('mcare/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('mcare/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('mcare/js/slick.min.js') }}"></script>
<script>
    $(".medproduct").slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoPlay: true,
        dots: true,
        arrows: false,

        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                    arrows: false,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                },
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ],
    });

    $(" .discount_m").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoPlay: true,
        dots: true,
        arrows: false,

        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                    arrows: false,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                },
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ],
    });
</script>

@stack('customjs')
