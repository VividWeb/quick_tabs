var i=1;
$(".simpleTabsOpen").each(function(){
    if(i==1){
        $(".simpleTabsOpen:first").before("<ul class='simpleTabs clearfix'></ul><div class='simpleTabsContainer'></div>");  
    }
    var tabTitle = $(this).attr("data-tab-title");
    $(this).after("<h2 class='tab-title'>"+tabTitle+"</h2>").nextUntil(".simpleTabsClose").wrapAll("<div class='simpleTabsContent clearfix' data-tab-id='"+i+"'>");
    $(".simpleTabs").append("<li data-tab-id="+i+"><a href='javascript:showSimpleTab("+i+");'>"+tabTitle+"</a></li>");
    i++;        
});
$(".simpleTabsOpen:not(.editmode), .simpleTabsClose:not(.editmode)").remove();
$('.simpleTabsContent').appendTo($('.simpleTabsContainer'));
$('.simpleTabs li:first-child').addClass('active');
function showSimpleTab(tabID){
    $(".simpleTabsContent").hide();
    $('.simpleTabsContent[data-tab-id="'+tabID+'"]').show();  
    $('.simpleTabs li').removeClass('active');
    $('.simpleTabs li[data-tab-id="'+tabID+'"]').addClass('active');
}
function windowSizeState(){
    if($(window).width() < 768){        
        $(".simpleTabsContent").show();
    }
    else{
        $(".simpleTabsContent").hide();
        var activeID = $(".simpleTabs li.active").attr("data-tab-id");
        $(".simpleTabsContent[data-tab-id='"+activeID+"']").show();
    }
}
$(window).resize(function(){
    windowSizeState();
});
windowSizeState();
