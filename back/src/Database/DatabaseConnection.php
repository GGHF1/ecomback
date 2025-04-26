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

            // connect to Railway MySQL database
            if (getenv('MYSQL_URL')) {
                $connectionParams = [
                    'url' => getenv('MYSQL_URL'),
                    'driver' => 'pdo_mysql',
                ];
            } else if (getenv('MYSQLHOST')) {
                $connectionParams = [
                    'driver' => 'pdo_mysql',
                    'host' => getenv('MYSQLHOST'),
                    'port' => getenv('MYSQLPORT'),
                    'dbname' => getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE'),
                    'user' => getenv('MYSQLUSER'),
                    'password' => getenv('MYSQLPASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD'),
                ];
            } 
            // Create the database connection
            $connection = DriverManager::getConnection($connectionParams);
            self::$entityManager = new EntityManager($connection, $config);
        }

        return self::$entityManager;
    }
}
