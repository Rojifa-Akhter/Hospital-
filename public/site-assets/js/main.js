! function(t) {
    "use strict";
    jQuery(document).on("ready", function() {
        t(".navbar .navbar-nav li a, .navbar .appointment-btn").on("click", function(o) {
            var n = t(this);
            t("html, body").stop().animate({
                scrollTop: t(n.attr("href")).offset().top - 50
            }, 1500), o.preventDefault()
        }),

        t(document).on("click", ".navbar-collapse.in", function(o) {
            t(o.target).is("a") && "dropdown-toggle" != t(o.target).attr("class") && t(this).collapse("hide")
        }),

        t(".navbar .navbar-nav li a").on("click", function() {
            t(".navbar-collapse").collapse("hide")
        }),


        // For Back to top
        t(window).on("scroll", function() {
            t(this).scrollTop() > 120 ? t(".navbar-light").addClass("is-sticky") : t(".navbar-light").removeClass("is-sticky")
        }),


        // For Slider
        t(".hero-slides").owlCarousel({
            items: 1,
            nav: !1,
            dots: !0,
            touchDrag: !1,
            mouseDrag: !1,
            autoplay: !0,
            smartSpeed: 700,
            loop: !0,
            navText: ["<i class='icofont-rounded-left'></i>", "<i class='icofont-rounded-right'></i>"]
        }),

        // For Our Department Tab
        function(t) {
            t(".tab ul.tabs").addClass("active").find("> li:eq(0)").addClass("current"), t(".tab ul.tabs li a").on("click", function(o) {
                var n = t(this).closest(".tab"),
                a = t(this).closest("li").index();
                n.find("ul.tabs > li").removeClass("current"), t(this).closest("li").addClass("current"), n.find(".tab_content").find("div.tabs_item").not("div.tabs_item:eq(" + a + ")").slideUp(), n.find(".tab_content").find("div.tabs_item:eq(" + a + ")").slideDown(), o.preventDefault()
            })
        }(jQuery),


        // For Datepicker
        t(function() {
            t("#datepicker").datepicker()
        }),


        // For Counter
        t(".count").counterUp({
            delay: 20,
            time: 1500
        }),


        // For smooth scroll
        t(function() {
            t(window).on("scroll", function() {
                var o = t(window).scrollTop();
                o > 300 && t(".go-top").fadeIn("slow"), o < 300 && t(".go-top").fadeOut("slow")
            }), t(".go-top").on("click", function() {
                t("html, body").animate({
                    scrollTop: "0"
                }, 500)
            })
        })
    }),

    jQuery(window).on("load", function() {
        t(".preloader-area").fadeOut()
    })
}(jQuery);