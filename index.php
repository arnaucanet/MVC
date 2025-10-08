<?php
include_once 'model/EquipoDAO.php';


$equipo = EquipoDAO::getEquipoByID(1);

var_dump($equipo);

?>