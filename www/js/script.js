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

$.fn.handleTooltipTerminator = function(){
    $(this).click(function(){
        $(this).parents(".bravo-tooltip").first().remove();
    });
};
var tooltipCallback = function (response) {
    console.log(response);
    $(".bravo-tooltip").remove();
    var tooltip = $("<div></div>")
        .attr("class","bravo-tooltip")
        .css({
            "left": response.x+"px",
            "top": response.y+"px"
        });
    $("<span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>")
        .appendTo(tooltip)
        .handleTooltipTerminator();
    for(var i = 0; i < response.articles.length; i++){
        $("<p></p>").html(
            $("<a></a>").attr("href", response.articles[i].href).html(response.articles[i].title)
        ).appendTo(tooltip);
    }
    tooltip.appendTo($("body"));
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

    $(".main-content .article-card .panel-body p").dblclick(function(event){
        console.log(event.clientX);
        var url = "/news";
        var data = {
            search  :    $.getSelectionText(),
            x       :   event.originalEvent.pageX,
            y       :   event.originalEvent.pageY
        };
        url = url + "?" + $.serializeObject(data);
        $.get(url, tooltipCallback);
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
                    alert(response.message);
                    $(".rating[data-article="+response.article+"]").hide();
                    $(".rate[data-article="+response.article+"]").css("width", (100*response.rating/5)+"%")
                }
            });
    });

    $("a.bravo-image-link").click(function(event){
        ga('send', 'event', "Site departure", "Image click", $(this).attr("href"));
    });
    $("a.bravo-title-link").click(function(event){
        ga('send', 'event', "Site departure", "Title click", $(this).attr("href"));
    });
});