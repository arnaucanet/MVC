<?php
include_once 'model/EquipoDAO.php';

class EquipoController{
    public function show(){
        $equipo = EquipoDAO::getEquipoByID(1);
        $view = 'view/equipo/show.php';
        include_once 'view/main.php';
    }
    
    public function index(){
        $listaEquipos = EquipoDAO::getEquipos();
        $view = 'view/equipo/index.php';
        include_once 'view/main.php';
    }
}