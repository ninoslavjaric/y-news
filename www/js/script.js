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

    $(".share-count").each(function(){
        var url = "http://graph.facebook.com/?fields=share&id={url}";
        $.get(url.replace("{url}", $(this).data("url")),function(response){
            $("[data-url*='"+response.id+"']").html(response.share.share_count);
        });
    });

    $(".share-button").click(function (event) {
        event.preventDefault();
        djes = window.open($(this).attr("href"), "", "width=200,height=100");
    });
});
var djes;