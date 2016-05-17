<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="form-group">
    <?php echo $form->label('openclose', t('Is this the Opening or Closing Block?'));?>
    <?php echo $form->select('openclose', array("open"=>t("Open"),"close"=>t("Close")), $openclose); ?>
</div>

<div class="form-group">
    <?php echo $form->label('tabTitle', t('If opening, enter a Tab Title:'));?>
    <?php echo $form->text('tabTitle', $tabTitle);?>
</div>

<div class="form-group">
    <?php echo $form->label('semantic', t('For semantics, which tag would you like for the Tab Title:'));?>
    <?php echo $form->select('semantic', array("h2"=>"H2","h3"=>"H3","H4"=>"H4","p"=>"Paragraph","span"=>"Span"),$semantic);?>
</div>
