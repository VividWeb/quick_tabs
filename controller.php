<?php      

namespace Concrete\Package\QuickTabs;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

	protected $pkgHandle = 'quick_tabs';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0';
	
	
	
	public function getPackageDescription()
	{
		return t("Add Tabs to your site");
	}

	public function getPackageName()
	{
		return t("Quick Tabs");
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('quick_tabs', $pkg); 
        
	}
}
?>