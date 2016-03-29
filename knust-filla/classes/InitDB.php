<?php

/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/14/2015
 * Time: 1:22 PM
 *
 */
class InitDB
{
    private static $_dbQuery;

    private static function isDBExisting()
    {
        $db = Config::get('mysql/db');
        if (self::connect()) {
            if (!mysql_select_db($db, self::connect())) {
                return false;
            }
            return true;
        }
        return false;
    }

    private static function connect()
    {
        $host = Config::get('mysql/host');
        $username = Config::get('mysql/username');
        $password = Config::get('mysql/password');

        $con = mysql_connect($host, $username, $password);
        if (!$con) {
            die('Error connecting to localhost');
        }

        return $con;
    }

    private static function createDb()
    {

        $dbName = Config::get('mysql/db');
        $connection = self::connect();

        self::$_dbQuery = 'CREATE DATABASE ' . $dbName;

        $_created = mysql_query(self::$_dbQuery, $connection);
        if ($_created) {

            return $_created;
        }

        die("Error in creating database ");
    }


    public static function testDB()
    {

        if (!self::isDBExisting()) {
            self::createDb();
            Tables::createTables();
            return;
        }
        Tables::createTables();
    }
}