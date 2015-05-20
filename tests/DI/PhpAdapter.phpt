<?php

/**
 * Test: Nette\DI\Config\Adapters\PhpAdapter
 */

use Nette\DI\Config,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';

define('TEMP_FILE', TEMP_DIR . '/cfg.php');


// Load INI
$config = new Config\Loader;
$data = $config->load('files/phpAdapter.php');
Assert::same( [
	'webname' => 'the example',
	'database' => [
		'adapter' => 'pdo_mysql',
		'params' => [
			'host' => 'db.example.com',
			'username' => 'dbuser',
			'password' => 'secret',
			'dbname' => 'dbname',
		],
	],
], $data );


$config->save($data, TEMP_FILE);
Assert::match( <<<EOD
<?php // generated by Nette
return [
	'webname' => 'the example',
	'database' => [
		'adapter' => 'pdo_mysql',
		'params' => [
			'host' => 'db.example.com',
			'username' => 'dbuser',
			'password' => 'secret',
			'dbname' => 'dbname',
		],
	],
];
EOD
, file_get_contents(TEMP_FILE) );
