<?php

/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 12/19/2015
 * Time: 12:50 PM
 */
class Tables
{


    public static function createTables()
    {
        $users_table_query = "CREATE TABLE users (
                    ID INTEGER AUTO_INCREMENT PRIMARY KEY,
                    Username VARCHAR (30),
                    Password VARCHAR (70),
                    Ipaddress VARCHAR (30),
                    Salt VARCHAR (32)
        )";

        $visitors_ip_address="CREATE TABLE visitors (
                    ID INTEGER AUTO_INCREMENT PRIMARY KEY ,
                    Ipaddress VARCHAR (30)
        )";


        $con = new mysqli(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'), Config::get('mysql/db'));
        if (!$con->connect_error) {
            try {
                $con->query($users_table_query);
                $con->query($visitors_ip_address);
            } catch (Exception $e) {

            }
        }
        $con->close();

    }


}