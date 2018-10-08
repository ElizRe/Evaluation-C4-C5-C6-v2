<?php

class Database //Connexion à la base de données
{

    private static $dbHost = "localhost";
    private static $dbName = "eval_C2_C3;charset=utf8;";
    private static $dbUser = "root";
    private static $dbUserPassword = "simplonco";
    
    private static $connection = null;

    public static function connect()
    {
        try {
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbUserPassword);
        } catch (PDOExeption $e) {
            die($e->getMessage());
        }
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}
