/* jshint unused:vars, undef:true, browser:true, jquery:true */
(function() {
'use strict';

var WINDOW_WIDTH_STOP = 768;

var LocationHash = (function() {
    var CHUNK_SEPARATOR = '|';
    var SUPPORTED = window.location && typeof window.location.hash === 'string';
    function getCurrent() {
        if (!SUPPORTED) {
            return null;
        }
        var result = {
            others: null,
            tabs: [],
        };
        var hash = window.decodeURIComponent(window.location.hash.replace(/^#/, '')).replace(/^#/, '');
        $.each(hash.split(CHUNK_SEPARATOR), function (_, chunk) {
            var match = chunk.match(/^qt(\d+):(\d+)$/);
            if (match === null) {
            	if (result.others === null) {
                    result.others = chunk;
                } else {
                    result.others += '|' + chunk;
                }
            } else {
                result.tabs[parseInt(match[1], 10)] = parseInt(match[2], 10);
            }
        });
        return result;
    }
    function setCurrent(data) {
        if (!SUPPORTED || !data) {
            return;
        }
        var chunks = [];
        if (typeof data.others === 'string' && data.others !== '') {
            chunks.push(data.others);
        }
        $.each(data.tabs, function(index, value) {
            if (typeof value === 'number') {
                chunks.push('qt' + index + ':' + value);
            }
        });
        var hash = chunks.join('|');
        if (hash === '') {
            try {
                window.history.replaceState(null, '', ' ');
            } catch (e) {
                var x = window.document.body.scrollLeft,
                    y = window.document.body.scrollTop;
                window.location.hash = '';
                window.document.body.scrollLeft = x;
                window.document.body.scrollTop = y;
            }
        } else {
            window.location.hash = hash;
        }
    }
    return {
        get: function(quickTabsIndex) {
            var data = getCurrent();
            return data === null || !data.tabs[quickTabsIndex] ? 0 : data.tabs[quickTabsIndex];
        },
        set: function(quickTabsIndex, headerIndex) {
            var data = getCurrent();
            if (data === null) {
                return;
            }
            data.tabs[quickTabsIndex] = headerIndex;
            setCurrent(data);
        }
    };
})();

function QuickTabs($container, index) {
    var my = this,
        $openTags = $container.find('>.simpleTabsOpen'),
        $firstOpenTag = $openTags.first(),
        wrapperOpen = ($firstOpenTag.data('wrapper-open') || '').toString(),
        wrapperClose = ($firstOpenTag.data('wrapper-close') || '').toString()
    ;
    my.index = index;
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
                    my.showTab($header, true);
                })
            )
        ;
        my.$contentsContainer.append($contents);
        my.$headersContainer.append($header);
        $openTag.after($('<h2 class="tab-title" />').html(title));
        $contents.append($openTag.nextUntil('.simpleTabsClose'));
    });
    $openTags.remove();
    $container.find('>.simpleTabsClose').remove();
    var headerIndex = LocationHash.get(my.index),
        selectedHeader = my.$headersContainer.find('>li')[headerIndex];
    my.showTab(selectedHeader ? $(selectedHeader) : my.$headersContainer.find('>li:first-child'));
}
QuickTabs.prototype = {
    showTab: function($header, saveHash) {
        var $headers = this.$headersContainer.find('>li');
        $headers.removeClass('active');
        $header.addClass('active');
        this.$contentsContainer.find('>.simpleTabsContent').hide();
        $header.data('quick_tabs.contents').show();
        if (saveHash) {
            LocationHash.set(this.index, $headers.index($header));
        }
    }
};

(function() {
    var parsedContainers = [],
        count = 0;
    $('.simpleTabsOpen:not(.editmode)').each(function() {
        var $container = $(this).parent();
        if ($container.length === 0) {
            return;
        }
        var container = $container[0];
        if (parsedContainers.indexOf(container) < 0) {
            new QuickTabs($container, count++);
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
        $('.simpleTabs li.active').each(function() {
            $(this).data('quick_tabs.contents').show();
        });
    }
}
$(window).resize(function(){
    windowSizeState();
});
windowSizeState();

})();
