<?php

use Cake\Core\Plugin;
use Cake\Log\Log;

if (!defined('LOCALE')) {
	define('LOCALE', ROOT . DS . 'locales' . DS);
}

$className = Plugin::isLoaded('DatabaseLog') ? 'DatabaseLog.Database' : 'Cake\Log\Engine\FileLog';

$log = [
	'translate' => [
		'className' => $className,
		'type' => 'translate',
		'levels' => ['info'],
		'scopes' => ['import'],
	],
];
Log::setConfig($log);
