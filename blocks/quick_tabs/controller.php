<?php

namespace Concrete\Package\QuickTabs\Block\QuickTabs;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Page\Page;
use Exception;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends BlockController
{
    /**
     * @var string
     */
    const OPENCLOSE_OPEN = 'open';

    /**
     * @var string
     */
    const OPENCLOSE_CLOSE = 'close';

    public $openclose;

    public $tabTitle;

    public $semantic;

    public $tabHandle;

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

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::ignorePageThemeGridFrameworkContainer()
     */
    public function ignorePageThemeGridFrameworkContainer()
    {
        $c = Page::getCurrentPage();

        return $c && !$c->isError() && $c->isEditMode() ? false : true;
    }
    
    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::registerViewAssets()
     */
    public function registerViewAssets($outputContent = '')
    {
        $this->requireAsset('javascript', 'jquery');
    }

    public function view()
    {
        $this->set('closeOption', static::OPENCLOSE_CLOSE);
    }

    public function add()
    {
        $this->set('openclose', '');
        $this->set('tabTitle', '');
        $this->set('semantic', '');
        $this->set('opencloseOptions', array('' => '') + $this->getOpencloseOptions());
        $this->set('tabHandle', '');
        $this->addOrEdit();
    }

    public function edit()
    {
        // Previous version defined 'H4' instead of 'h4'
        $semanticOptions = $this->getSemanticOptions();
        if (!isset($semanticOptions[$this->semantic]) && $this->semantic === 'H4' && isset($semanticOptions['h4'])) {
            $this->set('semantic', 'h4');
        }
        $this->set('opencloseOptions', $this->getOpencloseOptions());
        $this->addOrEdit();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::validate()
     */
    public function validate($args)
    {
        $result = $this->normalizeArgs($args);

        return is_array($result) ? true : $result;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::save()
     */
    public function save($args)
    {
        $result = $this->normalizeArgs($args);
        if (!is_array($result)) {
            throw new Exception(implode("\n", $result->getList()));
        }
        parent::save($result);
    }

    protected function addOrEdit()
    {
        $app = isset($this->app) ? $this->app : \Core::make('app');
        $json = $app->make('helper/json');
        $this->set('semanticOptions', $this->getSemanticOptions());
        $this->set('closeOptionJSON', $json->encode(static::OPENCLOSE_CLOSE));
    }

    /**
     * @param mixed $args
     *
     * @return array|object error object in case of errors
     */
    protected function normalizeArgs($args)
    {
        if (!is_array($args)) {
            $args = array();
        }
        $args += array(
            'openclose' => '',
            'tabTitle' => '',
            'semantic' => '',
            'tabHandle' => '',
        );
        $app = isset($this->app) ? $this->app : \Core::make('app');
        $errors = $app->make('helper/validation/error');
        $result = array('openclose' => $args['openclose']);
        $opencloseOptions = $this->getOpencloseOptions();
        if ($result['openclose'] === '' || !isset($opencloseOptions[$result['openclose']])) {
            $errors->add(t('Is this the Opening or Closing Block?'));
        } elseif ($result['openclose'] === static::OPENCLOSE_OPEN) {
            $result['tabTitle'] = is_string($args['tabTitle']) ? $args['tabTitle'] : '';
            if ($result['tabTitle'] === '') {
                $errors->add(t('Please specify the Tag Title.'));
            }
            $result['semantic'] = is_string($args['semantic']) ? $args['semantic'] : '';
            $semanticOptions = $this->getSemanticOptions();
            if ($result['semantic'] === '' || !isset($semanticOptions[$result['semantic']])) {
                $errors->add(t('Please specify the Semantic Tag for the Tab Title.'));
            }
            $result['tabHandle'] = is_string($args['tabHandle']) ? trim($args['tabHandle']) : '';
            $invalidChars = ':#|';
            if ($result['tabHandle'] !== '' && strpbrk($result['tabHandle'], $invalidChars) !== false) {
                $errors->add(
                    t(
                        "Tab Handle can't contain these characters: %s",
                        '"' . implode('", "', str_split($invalidChars, 1)) . '"'
                    )
                );
            }
        }

        return $errors->has() ? $errors : $result;
    }

    /**
     * Get the list of allowed values for the openclose field.
     *
     * @return array
     */
    protected function getOpencloseOptions()
    {
        return array(
            static::OPENCLOSE_OPEN => t('Open'),
            static::OPENCLOSE_CLOSE => t('Close'),
        );
    }

    /**
     * Get the list of allowed HTML tags.
     *
     * @return array
     */
    protected function getSemanticOptions()
    {
        $app = isset($this->app) ? $this->app : \Core::make('app');
        $config = $app->make('config');
        $tags = preg_split('/\W+/', (string) $config->get('quick_tabs::options.custom_tags'), -1, PREG_SPLIT_NO_EMPTY);
        if ($tags !== array()) {
            return array_combine($tags, $tags);
        }

        return array(
            'h2' => h('Title 2'),
            'h3' => h('Title 3'),
            'h4' => h('Title 4'),
            'p' => t('Paragraph'),
            'span' => tc('HTML Element', 'Span'),
        );
    }
}
