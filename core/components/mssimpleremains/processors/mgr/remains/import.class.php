<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportmsSimpleRemainsDefault extends modProcessor
{

    private $sleep = 0;
    private $count = 0;

    private $settings;

    private $messages = MODX_CORE_PATH . 'cache/registry/mgr/mssimpleremains';
    private $access_types = ['xlsx', 'xls', 'csv'];

    public function process()
    {
        $this->clearOldMessages();

        $this->modx->log(modX::LOG_LEVEL_INFO, $this->modx->lexicon('mssimpleremains_preparing'));
        $this->modx->addPackage('mssimpleremains', MODX_CORE_PATH . 'components/mssimpleremains/model/');

        $s = $this->modx->newQuery('msSimpleRemainsDefault');
        $s->limit(1);
        $settings = $this->modx->getObject('msSimpleRemainsDefault', $s);
        $this->settings = $settings->toArray();

        $extFile = mb_strtolower(pathinfo($this->settings['file'], PATHINFO_EXTENSION));

        //check file
        $file = file_exists(MODX_BASE_PATH . $this->settings['file']);
        if (!$file || empty($this->settings['file'])) {
            return $this->sendError($this->modx->lexicon('mssimpleremains_import_file_is_empty'));
        }

        //check tv
        $tv = $this->modx->getObject('modTemplateVar', [
            'name' => $this->settings['tv_name']
        ]);
        if (!$tv) {
            return $this->sendError($this->modx->lexicon('mssimpleremains_error_tv_name'));
        }

        //check extensions
        if (!in_array($extFile, $this->access_types)) {
            return $this->sendError($this->modx->lexicon('mssimpleremains_import_file_type_is_wrong'));
        }

        //check ident
        $ident = $this->settings['ident'];
        if (!$ident) {
            return $this->sendError($this->modx->lexicon('mssimpleremains_error_ident'));
        }

        if ($ident == 'tv') {
            $ident_tv = $this->modx->getObject('modTemplateVar', [
                'name' => $this->settings['ident_tv']
            ]);

            if (!$ident_tv) {
                return $this->sendError($this->modx->lexicon('mssimpleremains_error_ident_tv'));
            }
        }

        $filepath = MODX_BASE_PATH . $this->settings['file'];
        $skip_first = $this->settings['skip_first'];

        $spreadsheet = IOFactory::load($filepath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        foreach ($sheetData as $data) {

            $product = false;

            //update counter
            if ($this->count % 100 == 0) {
                $this->modx->log(modX::LOG_LEVEL_INFO, $this->modx->lexicon('mssimpleremains_remains_updated') . $this->count);
            }

            //skip first
            if ($this->count == 0 && $skip_first == 1) {
                $this->count++;
                continue;
            }

            //get product
            switch ($ident) {
                default:
                    $product = $this->modx->getObject('msProduct', [$this->settings['ident'] => $data[0]]);
                    break;
                case 'tv':
                    $s_tv = $this->modx->getObject('modTemplateVarResource', [
                        'tmplvarid' => $ident_tv->get('id'),
                        'value' => $data[0]
                    ]);

                    if (!$s_tv) {
                        //$this->modx->log(1, "[MSSR] Product with " . strtoupper($ident) . ": $data[0] doesn't EXIST");
                        //$this->count++;
                        break;
                    }

                    $product = $this->modx->getObject('msProduct', $s_tv->get('contentid'));
                    break;
            }


            if (!$product) {
                $ident_2 = ($ident == 'tv') ? 'tv value' : $ident;
                $this->modx->log(1, "[MSSR] Product with " . strtoupper($ident_2) . ": $data[0] doesn't EXIST");
                $this->count++;
                continue;
            }

            if (!$product->setTVValue($this->settings['tv_name'], $data[1])) {
                $this->modx->log(1, "[MSSR] Product with " . strtoupper($ident) . ": $data[0] doesn't CHANGE");
                $this->count++;
                continue;
            }
            $product->save();

            $this->count++;
            usleep($this->sleep);
        }


        $this->modx->log(modX::LOG_LEVEL_WARN, $this->modx->lexicon('mssimpleremains_import_completed'));
        $this->modx->log(modX::LOG_LEVEL_INFO, 'COMPLETED');
        //return $this->success();
    }

    private function clearOldMessages()
    {
        if (is_dir($this->messages)) {
            array_map('unlink', glob($this->messages . '/*'));
        }
    }

    private function sendError($msg)
    {
        $this->modx->log(modX::LOG_LEVEL_ERROR, "[MSSR] " . $msg);
        $this->modx->log(modX::LOG_LEVEL_INFO, 'COMPLETED');
        return $this->failure();
    }
}

return 'ImportmsSimpleRemainsDefault';