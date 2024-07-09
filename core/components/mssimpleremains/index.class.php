<?php

class msSimpleRemainsIndexManagerController extends modExtraManagerController
{

    public $mssimpleremains;

    public function initialize()
    {
        $corePath = $this->modx->getOption('mssimpleremains_core_path', null, $this->modx->getOption('core_path') . 'components/mssimpleremains/');

        $this->mssimpleremains = $this->modx->getService('msSimpleRemains', 'msSimpleRemains', MODX_CORE_PATH . 'components/mssimpleremains/model/');
        $this->addJavascript($this->mssimpleremains->config['jsUrl'] . 'mgr/index.js');

        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            mssimpleremains.config = ' . $this->modx->toJSON($this->mssimpleremains->config) . ';
        });
        </script>');
    }

    public function getLanguageTopics()
    {
        return array('mssimpleremains:default');
    }

    public function checkPermissions()
    {
        return true;
    }
}
