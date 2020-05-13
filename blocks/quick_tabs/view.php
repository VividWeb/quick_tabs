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
 * @var string $tabHandle
 */
$page = Page::getCurrentPage();
if (!$page || $page->isError()) {
    $page = null;
}
$isEditMode = $page !== null && $page->isEditMode();

$tagAttributes = array();
if ($isEditMode) {
    $tagAttributes['style'] = 'padding: 15px; background: #ccc; color: #444; border: 1px solid #999;';
}

if ($openclose !== $closeOption){
    $tagAttributes['class'] = 'simpleTabsOpen';
    $tag = $semantic;
    if ($isEditMode) {
        $tagContents = t('Opening Tab "%s"', $tabTitle);
        $tagAttributes['class'] .= ' editmode';
    }
    else {
        $tagContents = $tabTitle;
        $tagAttributes['data-tab-title'] = $tabTitle;
        $tabHandle = (string) $tabHandle;
        if ($tabHandle !== '') {
            $tagAttributes['data-tab-handle'] = $tabHandle;
        }
        if (!empty($a) && $a->isGridContainerEnabled()) {
            if ($page !== null) {
                $theme = $page->getCollectionThemeObject();
                if ($theme !== null && $theme->supportsGridFramework()) {
                    $gridFramework = $theme->getThemeGridFrameworkObject();
                    if ($gridFramework !== null) {
                        $tagAttributes['data-wrapper-open'] =
                            $gridFramework->getPageThemeGridFrameworkContainerStartHTML() .
                            $gridFramework->getPageThemeGridFrameworkRowStartHTML() .
                            sprintf(
                                '<div class="%s">',
                                $gridFramework->getPageThemeGridFrameworkColumnClassesForSpan(
                                    min($a->getAreaGridMaximumColumns(), $gridFramework->getPageThemeGridFrameworkNumColumns())
                                    )
                                )
                        ;
                        $tagAttributes['data-wrapper-close'] =
                            '</div>' .
                            $gridFramework->getPageThemeGridFrameworkRowEndHTML() .
                            $gridFramework->getPageThemeGridFrameworkContainerEndHTML()
                        ;
                    }
                }
            }
        }
    }
} else {
    $tagAttributes['class'] = 'simpleTabsClose';
    $tag = 'div';
    $tagContents = t('Closing Tab');
}
$tagAttributesString = '';
foreach ($tagAttributes as $tagAttributeName => $tagAttributeValue) {
    $tagAttributesString .= ' ' . h($tagAttributeName) . '="' . h($tagAttributeValue) . '"'; 
}
printf(
    '<%1$s%2$s>%3$s</%1$s>',
    $tag, // %1$s
    $tagAttributesString,
    $tagContents
);
