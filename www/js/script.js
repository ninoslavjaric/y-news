$.getSelectionText = function () {
    var text = "";
    var activeEl = document.activeElement;
    var activeElTagName = activeEl ? activeEl.tagName.toLowerCase() : null;
    if (
        (activeElTagName == "textarea") || (activeElTagName == "input" &&
            /^(?:text|search|password|tel|url)$/i.test(activeEl.type)) &&
        (typeof activeEl.selectionStart == "number")
    ) {
        text = activeEl.value.slice(activeEl.selectionStart, activeEl.selectionEnd);
    } else if (window.getSelection) {
        text = window.getSelection().toString();
    }
    return text;
};
$.serializeObject = function(obj) {
    var str = [];
    for(var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
};
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
    });
    $(".main-content .article-card .panel-body p").dblclick(function(){
        var url = "/news";
        var data = {
            search :    $.getSelectionText()
        };
        location = url + "?" + $.serializeObject(data);
    });
    $("[data-article]").mouseleave(function (event) {
            $(">i",this).addClass("fa-star-o").siblings().addClass("fa-star-o");
    }).find("i").mouseenter(function (event) {
        $(this).prevAll().removeClass("fa-star-o");
        $(this).removeClass("fa-star-o");
        $(this).nextAll().addClass("fa-star-o");
    }).click(function (event) {
        $.post("/news/rate/"+$(this).parents(".rating").first().data("article"),
            {
                rate    :   $(this).data("rate")
            },
            function (response) {
                if(response.ok){
                    $("[data-article="+response.article+"]").hide();
                }
            });
    });
});