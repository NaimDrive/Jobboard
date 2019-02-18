$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll >= 500) {
        $("header").addClass("active");
    } else {
        $("header").removeClass("active");
    }
});