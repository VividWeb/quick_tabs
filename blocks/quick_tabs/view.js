/* jshint unused:vars, undef:true, browser:true, jquery:true */
(function() {
'use strict';

var WINDOW_WIDTH_STOP = 768;

function QuickTabs($container) {
    var my = this,
        $openTags = $container.find('>.simpleTabsOpen'),
        $firstOpenTag = $openTags.first(),
        wrapperOpen = ($firstOpenTag.data('wrapper-open') || '').toString(),
        wrapperClose = ($firstOpenTag.data('wrapper-close') || '').toString()
    ;
    my.$headersContainer = $('<ul class="simpleTabs clearfix" />');
    my.$contentsContainer = $('<div class="simpleTabsContainer" />');
    if (wrapperOpen === '' && wrapperClose === '') {
        $firstOpenTag
            .before(my.$headersContainer)
            .before(my.$contentsContainer)
        ;
    } else {
        var $wrapper = $(wrapperOpen + '<div class="simpleTabsTemporaryWrapper"></div>' + wrapperClose);
        $firstOpenTag.before($wrapper);
        $wrapper.find('.simpleTabsTemporaryWrapper')
            .before(my.$headersContainer)
            .before(my.$contentsContainer)
            .remove()
        ;
    }
    $openTags.each(function() {
        var $openTag = $(this),
            title = $openTag.attr('data-tab-title'),
            $header = $('<li />'),
            $contents = $('<div class="simpleTabsContent clearfix" />')
        ;
        $header
            .data('quick_tabs.contents', $contents)
            .append($('<a href="#" />')
                .html(title)
                .on('click', function(e) {
                    e.preventDefault();
                    my.showTab($header);
                })
            )
        ;
        my.$contentsContainer.append($contents);
        my.$headersContainer.append($header);
        $openTag.after($('<h2 class="tab-title" />').html(title));
        $contents.append($openTag.nextUntil('.simpleTabsClose'));
    });
    $openTags.remove();
    $container.find('.simpleTabsClose').remove();
    my.showTab(my.$headersContainer.find('li:first-child'));
}
QuickTabs.prototype = {
    showTab: function($header) {
        this.$headersContainer.find('>li').removeClass('active');
        $header.addClass('active');
        this.$contentsContainer.find('>.simpleTabsContent').hide();
        $header.data('quick_tabs.contents').show();
    }
};

(function() {
    var parsedContainers = [];
    $('.simpleTabsOpen:not(.editmode)').each(function() {
        var $container = $(this).parent();
        if ($container.length === 0) {
            return;
        }
        var container = $container[0];
        if (parsedContainers.indexOf(container) < 0) {
            new QuickTabs($container);
            parsedContainers.push(container);
        }
    });
})();

function windowSizeState(){
    if($(window).width() < WINDOW_WIDTH_STOP) {
        $('.simpleTabsContent').show();
    }
    else{
        $('.simpleTabsContent').hide();
        $('.simpleTabs li.active').data('quick_tabs.contents').show();
    }
}
$(window).resize(function(){
    windowSizeState();
});
windowSizeState();

})();
