<?php

class UpdatemsSimpleRemainsDefault extends modObjectUpdateProcessor
{
    public $objectType = 'msSimpleRemainsDefault';
    public $classKey = 'msSimpleRemainsDefault';

    //public $permission = 'edit_document';

    public function beforeSet()
    {
        foreach (array('file', 'skip_first') as $v) {
            if (!$this->getProperty($v)) {
                $this->addFieldError($v);
            }

            if ($v == 'file') {
                $val = $this->getProperty($v);
                $extFile = mb_strtolower(pathinfo($val, PATHINFO_EXTENSION));
                $access_types = ['xlsx', 'xls', 'csv'];

                if (!in_array($extFile, $access_types)) {
                    $this->addFieldError($v);
                }
            }
        }

        $props = $this->getProperties();
        foreach ($props as $p => $v) {
            switch ($v) {
                case 'true':
                case 'false':
                    $this->setCheckbox($p, true);
                    break;
            }
        }

        return parent::beforeSet();
    }
}

return 'UpdatemsSimpleRemainsDefault';