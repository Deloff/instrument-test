<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 14.12.17
 * Time: 1:13
 */
require __DIR__ . '/../vendor/autoload.php';
ini_set('display_errors', true);
error_reporting(E_ALL);

$configFiles = glob(__DIR__ . '/../config/{,*.}{global,local}.php', GLOB_BRACE);
$config = [];
foreach ($configFiles as $file) {
    $arr = require_once $file;
    $config = array_merge_recursive($config, $arr);
}

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions($config['DI']);
$container = $containerBuilder->build();
$container->set('config', $config);
/** @var \Core\Application $app */
$app = $container->get(\Core\Application::class);
$app->run();