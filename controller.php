<?php 

namespace Concrete\Package\QuickTabs;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Package\Package;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Controller extends Package
{
	protected $pkgHandle = 'quick_tabs';

	protected $appVersionRequired = '5.7.1';

	protected $pkgVersion = '1.0';

	/**
	 * {@inheritdoc}
	 *
	 * @see \Concrete\Core\Package\Package::getPackageName()
	 */
	public function getPackageName()
	{
		return t('Quick Tabs');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @see \Concrete\Core\Package\Package::getPackageDescription()
	 */
	public function getPackageDescription()
	{
	    return t('Add Tabs to your site');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @see \Concrete\Core\Package\Package::install()
	 */
	public function install()
	{
		$pkg = parent::install();
		BlockType::installBlockType('quick_tabs', $pkg);
	}
}
