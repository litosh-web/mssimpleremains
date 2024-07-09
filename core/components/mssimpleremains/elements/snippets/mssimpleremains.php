<?php

$msSimpleRemains = $modx->getService('msSimpleRemains', 'msSimpleRemains', MODX_CORE_PATH . 'components/mssimpleremains/model/', $scriptProperties);
if (!$msSimpleRemains) {
    return 'Could not load msSimpleRemains class!';
}

$modx->addPackage('mssimpleremains', MODX_CORE_PATH . 'components/mssimpleremains/model/');

if (!$id) {
    $id = $modx->resource->id;
}

if (!$msSimpleRemains->checkProduct($id)) {
    return;
}

$obj = $modx->getObject('msSimpleRemainsItems', ['id' => $id]);
$remains = $obj->get('remains');

$modx->setPlaceholders(array(
    'remains' => $remains,
));
?>