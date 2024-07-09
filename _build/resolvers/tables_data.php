<?php

/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx->addPackage('mssimpleremains', MODX_CORE_PATH . 'components/mssimpleremains/model/');

            $mssr = $modx->getService('mssimpleremains', 'mssimpleremains', MODX_CORE_PATH . 'components/mssimpleremains/model/');

            $manager = $modx->getManager();
            $objects = [];

            if (!$modx->getCount('msSimpleRemainsDefault')) {
                if ($mssr->newSettings()) {
                    $modx->log(xPDO::LOG_LEVEL_INFO, '[Tables] Successfully add Default fields!');
                }
            } else {
                if ($mssr->updateSettings()) {
                    $modx->log(xPDO::LOG_LEVEL_INFO, '[Tables] Successfully update Default fields!');
                }
            }

            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;