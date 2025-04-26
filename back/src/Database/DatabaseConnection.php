<?php

namespace App\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

class DatabaseConnection
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager === null) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
            $dotenv->load();

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__ . '/../Model'],
                isDevMode: true
            );

            $connectionParams = [
                'driver' => 'pdo_mysql',
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'dbname' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['DB_PASSWORD'],
                
            ];

            $connection = DriverManager::getConnection($connectionParams);
            self::$entityManager = new EntityManager($connection, $config);
        }

        return self::$entityManager;
    }
}