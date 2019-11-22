<?php
    defined('C5_EXECUTE') or die(_("Access Denied.")); 
	
    $c = Page::getCurrentPage();
	//add class depending on what type of block
	if($openclose=="open"){
		$class='simpleTabsOpen';
		$state="opening";
		$tag = $semantic;
	}else{
		$class="simpleTabsClose";	
		$state="closing";
		$tag = "div";
	}
	if ($c->isEditMode()){
		$class=$class." editmode";	
		$editingStyle = "";
		$status = $tabTitle." ".$state." block";
		$editingStyle=" style='padding: 15px; background: #ccc; color: #444; border: 1px solid #999;'";
	}
	else {  
		$editingStyle = "";
		$status = $tabTitle;
	}
?>


<<?=$tag?> data-tab-title="<?=$tabTitle?>" class="<?=$class?>"<?=$editingStyle?>><?=$status?></<?=$tag?>>
