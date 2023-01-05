<?php
// bootstrap.php

// Include Composer Autoload (relative to project root).
require_once "vendor/autoload.php";

use Laminas\Stdlib\ArrayUtils;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;


use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Tools\Console\Command;


$paths = array("./module/Application/src/Entity");
$isDevMode = true;

// Retrieve configuration
$config = require __DIR__ . '/../config/autoload/doctrine.global.php';

// Merge development config
if ($isDevMode === true) {
    $config = ArrayUtils::merge($config, require __DIR__ . '/../config/autoload/doctrine.local.php');
}

// the connection configuration
$connection = $config['doctrine']['connection']['orm_default']['params'];


// doctrine entity manager configuration
$config = new Configuration;
$config->setMetadataCache(new ArrayAdapter());
$config->setMetadataDriverImpl(new AttributeDriver($paths));
$config->setQueryCache(new ArrayAdapter());

//  Add DBAL Types
\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($connection, $config);

