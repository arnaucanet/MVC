<?php

include_once 'database/database.php';
include_once 'model/Equipo.php';

class EquipoDAO{
    public static function getEquipoByID($id){
        $con = DataBase::connect();
        //preparacion consulta
        $stmt = $con->prepare("SELECT * FROM equipos WHERE id = ?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $results = $stmt->get_result();

        $equipo = $results->fetch_object('Equipo');
        $con->close();
        return $equipo;
    }

    public static function getEquipos(){
        $con = DataBase::connect();
        //preparacion consulta
        $stmt = $con->prepare("SELECT * FROM equipos");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaEquipos = [];

        while($equipo = $results->fetch_object('Equipo')){
            $listaEquipos[]=$equipo;
        }

        
        $con->close();
        return $listaEquipos;
    }
}