<?php

namespace Concrete\Package\QuickTabs\Block\QuickTabs;

use Concrete\Core\Block\BlockController;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends BlockController
{
    public $openclose;

    public $tabTitle;

    public $semantic;

    protected $btTable = 'btQuickTabs';

    protected $btWrapperClass = 'ccm-ui';

    protected $btInterfaceHeight = 365;

    protected $btInterfaceWidth = 400;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::getBlockTypeName()
     */
    public function getBlockTypeName()
    {
        return t('Quick Tabs');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::getBlockTypeDescription()
     */
    public function getBlockTypeDescription()
    {
        return t('Add Tabs to the Page');
    }

    public function add()
    {
        $this->set('openclose', '');
        $this->set('tabTitle', '');
        $this->set('semantic', '');
    }
}
