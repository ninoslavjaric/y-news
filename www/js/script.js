$(function(){
    $(window).scroll(function (e) {
        var scrolltop = $(document).scrollTop();
        if(scrolltop>64){
            $("body>.container").addClass("top-margin-extra");
            $(".navbar-y").addClass("fixed");
        }else{
            $("body>.container").removeClass("top-margin-extra");
            $(".navbar-y").removeClass("fixed");
        }
    })
});