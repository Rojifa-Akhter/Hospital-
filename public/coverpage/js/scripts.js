!(function (e) {
    "use strict";
    e(window).on("load", function () {
        e(".preloader-wrap").fadeOut(1e3);
    });

    //animation scroll js
    var html_body = $('html, body');
    $('nav a').on('click', function () {
    	if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    		var target = $(this.hash);
    		target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    		if (target.length) {
    			html_body.animate({
    				scrollTop: target.offset().top - 100
    			}, 1500);
    			return false;
    		}
    	}
    });

    //for sticky
    $(window).scroll(function () {
    	var scroll = $(this).scrollTop();
    	if (scroll >= 100) {
    		$("#full_nav").addClass("sticky");
    	} else {
    		$("#full_nav").removeClass("sticky");
    	}
    });








$(document).ready(function(){

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var current = 1;
var steps = $("fieldset").length;

setProgressBar(current);

$(".next").click(function(){

current_fs = $(this).parent();
next_fs = $(this).parent().next();

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
next_fs.show();
//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 500
});
setProgressBar(++current);
});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 500
});
setProgressBar(--current);
});

function setProgressBar(curStep){
var percent = parseFloat(100 / steps) * curStep;
percent = percent.toFixed();
$(".progress-bar")
.css("width",percent+"%")
}

$(".submit").click(function(){
return previous_fs-1 ;
})

$(".reset").click(()=>{
    alert('Your fill-up form going to reset')
});
$(".pay").click(()=>{
    alert(' Please Wait for Pay');
})
});
















})(jQuery);
