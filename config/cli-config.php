<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 16:17
 */

// cli-config.php

require __DIR__ . '/../vendor/autoload.php';


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

$entityManager = $container->get(\Doctrine\ORM\EntityManager::class);
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);