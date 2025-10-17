<?php
include_once 'model/EquipoDAO.php';

class EquipoController{
    public function show(){
        $idequipo=$_GET['idequipo'];
        $equipo = EquipoDAO::getEquipoByID($idequipo);
        $view = 'view/equipo/show.php';
        include_once 'view/main.php';
    }
    
    public function index(){
        $listaEquipos = EquipoDAO::getEquipos();
        $view = 'view/equipo/index.php';
        include_once 'view/main.php';
    }
}