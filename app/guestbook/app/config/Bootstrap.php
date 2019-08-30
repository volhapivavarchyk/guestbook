<?php
namespace Piv\Guestbook\App\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

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
            'user' => $this->getGlobalVariableEnv('DB_USER'),
            'password' => $this->getGlobalVariableEnv('DB_PASSWORD'),
            'dbname' => $this->getGlobalVariableEnv('DB_NAME'),
            'host' => $this->getGlobalVariableEnv('DB_HOST'),
            'port' => $this->getGlobalVariableEnv('DB_PORT'),
        ];
        try {
            $this->entityManager = $this->createEntityManager($connection, $config);
        } catch (ORMException $e) {
            $this->entityManager = Null;
        }
        $this->createHelperSet();
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function getGlobalVariableEnv(string $param)
    {
        return $_ENV[$param];
    }

    private function setConfigEntityManager()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/app/entity/"], $isDevMode);

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
