<?php
namespace Piv\Guestbook\App\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

class Bootstrap
{

    private $entityManager;

    public function __construct()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/app/entity/"], $isDevMode);

        $connection = [
            'driver' => 'pdo_mysql',
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'dbname' => $_ENV['DB_NAME'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
        ];
        $this->entityManager = EntityManager::create($connection, $config);
        ConsoleRunner::createHelperSet($this->entityManager);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

}
