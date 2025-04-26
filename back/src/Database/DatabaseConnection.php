<?php

namespace App\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class DatabaseConnection
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager === null) {

            // Configuration for ORM
            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__ . '/../Model'],
                isDevMode: true
            );

            // Check if the MySQL connection URL is set (for Railway or similar platforms)
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
                // Fallback to local environment (this won't be used in Railway, but for local testing)
                $connectionParams = [
                    'driver' => 'pdo_mysql',
                    'host' => $_ENV['DB_HOST'] ?? 'localhost',
                    'port' => $_ENV['DB_PORT'] ?? 3306,
                    'dbname' => $_ENV['DB_DATABASE'] ?? 'product_catalog',
                    'user' => $_ENV['DB_USERNAME'] ?? 'root',
                    'password' => $_ENV['DB_PASSWORD'] ?? '',
                ];
            }

            // Create the database connection
            $connection = DriverManager::getConnection($connectionParams);
            self::$entityManager = new EntityManager($connection, $config);
        }

        return self::$entityManager;
    }
}
