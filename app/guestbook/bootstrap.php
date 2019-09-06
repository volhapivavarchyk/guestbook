<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/vendor/autoload.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__."/src/entities/"], $isDevMode);

$connection = [
    'driver' => 'pdo_mysql',
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname' => $_ENV['DB_NAME'],
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
];

$entityManager = EntityManager::create($connection, $config);
