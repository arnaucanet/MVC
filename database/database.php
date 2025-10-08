<?php

class DataBase{
    public static function connect($host='localhost', $user='root', $pass='', $db='liga'){
        $con = new mysqli($host, $user, $pass, $db);

        if($con == false){
            die('Error al connectar a la bd');
        } else{
            return $con;
        }
    }
}