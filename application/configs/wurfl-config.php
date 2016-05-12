<?php
echo "Loaded";
die;
$resourcesDir            = dirname(__FILE__) . '/../../data/wurlf/';
$wurfl['main-file']      = $resourcesDir  . 'wurfl-latest.zip';
$wurfl['patches']        = array($resourcesDir . 'web_browsers_patch.xml');
$persistence['provider'] = 'file';
$persistence['dir']      = CACHE_ROOT . "/wurfl/";
$cache['provider']       = null;

$configuration['wurfl']       = $wurfl;
$configuration['persistence'] = $persistence;
$configuration['cache']       = $cache;