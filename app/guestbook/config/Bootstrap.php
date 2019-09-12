<?php
namespace Piv\Guestbook\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Piv\Guestbook\Config\Config;

class Bootstrap
{
    private $entityManager;

    /**
     * Bootstrap constructor
     */
    public function __construct()
    {
        $config = $this->setConfigEntityManager();

        $connection = [
            'driver' => 'pdo_mysql',
            'user' => Config::getGlobalVariableEnv('DB_USER'),
            'password' => Config::getGlobalVariableEnv('DB_PASSWORD'),
            'dbname' => Config::getGlobalVariableEnv('DB_NAME'),
            'host' => Config::getGlobalVariableEnv('DB_HOST'),
            'port' => Config::getGlobalVariableEnv('DB_PORT'),
        ];
        try {
            $this->entityManager = $this->createEntityManager($connection, $config);
        } catch (ORMException $e) {
            $this->entityManager = null;
        }
        $this->createHelperSet();
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    private function setConfigEntityManager()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/src/entity/"], $isDevMode);

        return $config;
    }

    private function createEntityManager($connection, $config)
    {
        return EntityManager::create($connection, $config);
    }

    private function createHelperSet()
    {
        ConsoleRunner::createHelperSet($this->entityManager);
    }
}
