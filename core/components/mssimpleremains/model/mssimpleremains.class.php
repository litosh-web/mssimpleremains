<?php

class msSimpleRemains
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/mssimpleremains/';
        $assetsUrl = MODX_ASSETS_URL . 'components/mssimpleremains/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('mssimpleremains', $this->config['modelPath']);
        $this->modx->lexicon->load('mssimpleremains:default');
    }

    public function checkProduct($id)
    {
        if ($this->modx->getObject('msProduct', $id)) {
            return true;
        } else {
            $this->modx->log(1, $this->modx->lexicon('mssimpleremains_error_not_a_product') . '. ID: ' . $id);
            return false;
        }
    }

    public function newSettings($arr = [])
    {
        $default = $this->modx->newObject('msSimpleRemainsDefault', $arr);
        if ($default->save()) {
            return true;
        }
    }

    public function updateSettings()
    {
        $q = $this->modx->newQuery('msSimpleRemainsDefault');
        $q->limit(1);

        $settings = $this->modx->getObject('msSimpleRemainsDefault', $q);
        $arr = $settings->toArray();

        //remove old
        $this->modx->removeCollection('msSimpleRemainsDefault', []);

        if ($this->newSettings($arr)) {
            return true;
        }
    }

}