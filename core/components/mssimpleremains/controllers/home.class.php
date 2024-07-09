<?php

require_once __DIR__ . "/../index.class.php";

/**
 * The home manager controller for mssimpleremains.
 *
 */
class msSimpleRemainsHomeManagerController extends msSimpleRemainsIndexManagerController
{
    /** @var mssimpleremains $mssimpleremains */
    public $mssimpleremains;


    /**
     *
     */
    public function initialize()
    {
        $this->mssimpleremains = $this->modx->getService('msSimpleRemains', 'mssimpleremains', MODX_CORE_PATH . 'components/mssimpleremains/model/');
        parent::initialize();

        $q = $this->modx->newQuery('msSimpleRemainsDefault');
        $q->limit(1);
        $settings = $this->modx->getObject('msSimpleRemainsDefault', $q);

        $this->fields = $settings->toArray();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['mssimpleremains:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('mssimpleremains');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->mssimpleremains->config['jsUrl'] . 'mgr/sections/main.js');
        $this->addJavascript($this->mssimpleremains->config['jsUrl'] . 'mgr/widgets/panel.home.js');
        $this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
		    mssimpleremains.data = '.$this->modx->toJSON($this->fields).';
			MODx.load({xtype: "mssimpleremains-page-home"});
		});
		</script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        //$this->content .= '<div id="mssimpleremains-panel-home-div"></div>';

        return '';
    }
}