<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createXMLMetadataConfiguration(
    paths: [__DIR__ . "/../infra/mapping"],
    isDevMode: true,
);

$connectionParams = [
    'driver' => 'pdo_pgsql',
    'host'   => 'praticien.db',
    'user'   => 'prati',
    'password' => 'prati',
    'dbname' => 'prati',
];

$connection = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($connection, $config);