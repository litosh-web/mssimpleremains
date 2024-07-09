<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('mssimpleremains_core_path', null, $modx->getOption('core_path') . 'components/mssimpleremains/');
require_once $corePath . 'model/mssimpleremains.class.php';
$modx->mssimpleremains = new mssimpleremains($modx);

$modx->lexicon->load('mssimpleremains:default');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->mssimpleremains->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));