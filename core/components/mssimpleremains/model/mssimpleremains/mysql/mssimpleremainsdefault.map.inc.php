<?php
$xpdo_meta_map['msSimpleRemainsDefault']= array (
  'package' => 'mssimpleremains',
  'version' => '1.1',
  'table' => 'mssimpleremains_default',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'file' => '',
    'tv_name' => '',
    'ident' => 'article',
    'ident_tv' => '',
    'skip_first' => 0,
  ),
  'fieldMeta' => 
  array (
    'file' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'tv_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ident' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => 'article',
    ),
    'ident_tv' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'skip_first' => 
    array (
      'dbtype' => 'boolean',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
  ),
);
