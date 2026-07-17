<?php

$pluginRoot = dirname(__DIR__);
$appRoot = getenv('LECONFE_APP_PATH') ?: dirname($pluginRoot, 2);

if (! file_exists($appRoot.'/vendor/autoload.php')) {
    throw new RuntimeException(sprintf(
        'LECONFE_APP_PATH is invalid. Expected vendor/autoload.php at [%s].',
        $appRoot,
    ));
}

require_once $appRoot.'/vendor/autoload.php';
require_once $pluginRoot.'/vendor/autoload.php';
