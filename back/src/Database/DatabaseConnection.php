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

            if (getenv('MYSQL_URL')) {
                // Use the connection URL directly if available
                $connectionParams = [
                    'url' => getenv('MYSQL_URL'),
                    'driver' => 'pdo_mysql',
                ];
            } else if (getenv('MYSQLHOST')) {
                // Use individual Railway MySQL environment variables
                $connectionParams = [
                    'driver' => 'pdo_mysql',
                    'host' => getenv('MYSQLHOST'),
                    'port' => getenv('MYSQLPORT'),
                    'dbname' => getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE'),
                    'user' => getenv('MYSQLUSER'),
                    'password' => getenv('MYSQLPASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD'),
                ];
            } else {
                // Fall back to local .env variables
                $connectionParams = [
                    'driver' => 'pdo_mysql',
                    'host' => $_ENV['DB_HOST'] ?? 'localhost',
                    'port' => $_ENV['DB_PORT'] ?? 3306,
                    'dbname' => $_ENV['DB_DATABASE'] ?? 'product_catalog',
                    'user' => $_ENV['DB_USERNAME'] ?? 'root',
                    'password' => $_ENV['DB_PASSWORD'] ?? '',
                ];
            }

            $connection = DriverManager::getConnection($connectionParams);
            self::$entityManager = new EntityManager($connection, $config);
        }

        return self::$entityManager;
    }
}