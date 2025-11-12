<?php

class DataBase{
    public static function connect($host='localhost', $user='root', $pass='', $db='netflixeats'){
        $con = new mysqli($host, $user, $pass, $db);

    if ($con->connect_errno) {
        die('Error al conectar a la base de datos: ' . $con->connect_error);
    } else{
            return $con;
        }
    }
}