<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/msSimpleRemains/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/mssimpleremains')) {
            $cache->deleteTree(
                $dev . 'assets/components/mssimpleremains/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/mssimpleremains/', $dev . 'assets/components/mssimpleremains');
        }
        if (!is_link($dev . 'core/components/mssimpleremains')) {
            $cache->deleteTree(
                $dev . 'core/components/mssimpleremains/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/mssimpleremains/', $dev . 'core/components/mssimpleremains');
        }
    }
}

return true;