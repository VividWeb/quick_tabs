<?php
namespace Concrete\Package\QuickTabs\Block\QuickTabs;
use \Concrete\Core\Block\BlockController;
use Loader;
use \File;
use Page;
use \Concrete\Core\Block\View\BlockView as BlockView;

defined('C5_EXECUTE') or die(_("Access Denied.")); 
class Controller extends BlockController
{
    protected $btTable = 'btQuickTabs';
    protected $btInterfaceWidth = "400";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "365";

    public function getBlockTypeDescription()
    {
        return t("Add Tabs to the Page");
    }

    public function getBlockTypeName()
    {
        return t("Quick Tabs");
    }
}