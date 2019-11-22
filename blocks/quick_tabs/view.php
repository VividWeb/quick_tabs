<?php

use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * @var Concrete\Core\Area\Area $a
 * @var Concrete\Package\QuickTabs\Block\QuickTabs\Controller $controller
 * @var string $openclose
 * @var string $closeOption
 * @var string $semantic
 * @var string $tabTitle
 */
$page = Page::getCurrentPage();
if (!$page || $page->isError()) {
    $page = null;
}
$isEditMode = $page !== null && $page->isEditMode();

//add class depending on what type of block
if ($openclose !== $closeOption){
    $class = 'simpleTabsOpen';
    $tag = $semantic;
    $tagContents = t('Opening Tab "%s"', $tabTitle);
} else {
    $class = 'simpleTabsClose';
    $tag = 'div';
    $tagContents = t('Closing Tab');
    $tabTitle = '';
}
$openWrapper = '';
$closeWrapper = '';
if ($isEditMode) {
    $class .= ' editmode';
    $editingStyle = ' style="padding: 15px; background: #ccc; color: #444; border: 1px solid #999;"';
}
else {
    $editingStyle = '';
    $tagContents = $tabTitle;
    if (!empty($a) && $a->isGridContainerEnabled()) {
        if ($page !== null) {
            $theme = $page->getCollectionThemeObject();
            if ($theme !== null && $theme->supportsGridFramework()) {
                $gridFramework = $theme->getThemeGridFrameworkObject();
                if ($gridFramework !== null) {
                    $openWrapper = $gridFramework->getPageThemeGridFrameworkContainerStartHTML() .
                        $gridFramework->getPageThemeGridFrameworkRowStartHTML() .
                        sprintf(
                            '<div class="%s">',
                            $gridFramework->getPageThemeGridFrameworkColumnClassesForSpan(
                                min($a->getAreaGridMaximumColumns(), $gridFramework->getPageThemeGridFrameworkNumColumns())
                            )
                        );

                    $closeWrapper = '</div>' .
                        $gridFramework->getPageThemeGridFrameworkRowEndHTML() .
                        $gridFramework->getPageThemeGridFrameworkContainerEndHTML()
                    ;
                }
            }
        }
    }
}
printf(
    '<%1$s data-tab-title="%2$s" data-wrapper-open="%3$s" data-wrapper-close="%4$s" class="%5$s"%6$s>%7$s</%1$s>',
    $tag, // %1$s
    h($tabTitle), // %2$s
    h($openWrapper), // %3$s
    h($closeWrapper), // %4$s
    $class, // %5$s
    $editingStyle, // %6$s
    $tagContents // %7$s
);
