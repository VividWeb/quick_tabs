<?php
defined('C5_EXECUTE') or die('Access Denied.');

$c = Page::getCurrentPage();
//add class depending on what type of block
if ($openclose === 'open'){
    $class = 'simpleTabsOpen';
    $state = 'opening';
    $tag = $semantic;
} else {
    $class = 'simpleTabsClose';
    $state = 'closing';
    $tag = 'div';
}
if ($c->isEditMode()) {
    $class .= ' editmode';
    $editingStyle = '';
    $status = $tabTitle . ' ' . $state . ' block';
    $editingStyle = " style='padding: 15px; background: #ccc; color: #444; border: 1px solid #999;'";
}
else {
    $editingStyle = '';
    $status = $tabTitle;
}
?>
<<?php echo $tag; ?> data-tab-title="<?php echo $tabTitle; ?>" class="<?php echo $class; ?>"<?php echo $editingStyle; ?>><?php echo $status; ?></<?php echo $tag; ?>>
