<?php

use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * @var Concrete\Package\QuickTabs\Block\QuickTabs\Controller $controller
 * @var string $openclose
 * @var string $closeOption
 * @var string $semantic
 * @var string $tabTitle
 */
$c = Page::getCurrentPage();
$isEditMode = $c->isEditMode();

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
if ($isEditMode) {
    $class .= ' editmode';
    $editingStyle = ' style="padding: 15px; background: #ccc; color: #444; border: 1px solid #999;"';
}
else {
    $editingStyle = '';
    $tagContents = $tabTitle;
}
printf(
    '<%1$s data-tab-title="%2$s" class="%3$s"%4$s>%5$s</%1$s>',
    $tag, // %1$s
    h($tabTitle), // %2$s
    $class, // %3$s
    $editingStyle, // %4$s
    $tagContents // %5$s
);
