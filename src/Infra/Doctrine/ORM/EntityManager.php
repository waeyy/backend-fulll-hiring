<?php

declare(strict_types=1);

namespace Fulll\Infra\Doctrine\ORM;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\ORMSetup;

class EntityManager
{
    private \Doctrine\ORM\EntityManager $entityManager;

    public function __construct()
    {
        $dsnParser        = new DsnParser();
        $connectionParams = $dsnParser
            ->parse('mysqli://root@127.0.0.1:3306/fulll_hiring?serverVersion=5.7.28')
        ;

        $config     = ORMSetup::createAttributeMetadataConfiguration(['src/Domain/Entity']);
        $connection = DriverManager::getConnection($connectionParams, $config);

        $this->entityManager = new \Doctrine\ORM\EntityManager($connection, $config);
    }

    public function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        return $this->entityManager;
    }
}
