<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/1/30
 * Time: 下午10:14
 */

return [
	// 公共模块
	'common' => [
		'__file__' => ['common.php', 'config.php'],
		'__dir__' => ['controller'],
		'controller' => ['Uploads'],
	],

	// 根域名-api
	'root' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['Index', 'Test'],
		'model' => ['Index'],
		'view' => ['index/index'],
	],

	// 子域名-open
	'open' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['Index', 'Test'],
		'model' => ['Index'],
		'view' => ['index/index'],
	],

	// 子域名-blog
	'blog' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['User', 'Article', 'Mind', 'Linked'],
		'model' => ['User', 'Article', 'Mind', 'Linked'],
		'view' => ['index/index'],
	],

	// 子域名-slsadmin
	'sls_admin' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['User', 'Article', "Order"],
		'model' => ['User', 'Article'],
		'view' => ['index/index'],
	],

	// 子域名-github
	'github' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['Index'],
		'model' => [],
		'view' => [],
	],

	// 子域名-coding
	'coding' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['Index'],
		'model' => [],
		'view' => [],
	],

	// 子域名-oschina
	'oschina' => [
		'__file__' => ['common.php', 'config.php', 'database.php'],
		'__dir__' => ['behavior', 'controller', 'model', 'view'],
		'controller' => ['Index'],
		'model' => [],
		'view' => [],
	],
];