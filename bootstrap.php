<?php

declare(strict_types=1);
// bootstrap.php
require_once 'vendor/autoload.php';

use Fulll\Infra\Doctrine\ORM\EntityManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$entityManager = (new EntityManager())->getEntityManager();

// DI Container
$container = new ContainerBuilder();
$loader    = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('config/services.yaml');
