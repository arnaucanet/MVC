<?php

class MiComida
{
    private $id_usuario;
    private $id_producto;
    private $fecha_agregado;

    /**
     * Get the value of id_usuario
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of id_producto
     */
    public function getId_producto()
    {
        return $this->id_producto;
    }

    /**
     * Set the value of id_producto
     *
     * @return  self
     */
    public function setId_producto($id_producto)
    {
        $this->id_producto = $id_producto;

        return $this;
    }

    /**
     * Get the value of fecha_agregado
     */
    public function getFecha_agregado()
    {
        return $this->fecha_agregado;
    }

    /**
     * Set the value of fecha_agregado
     *
     * @return  self
     */
    public function setFecha_agregado($fecha_agregado)
    {
        $this->fecha_agregado = $fecha_agregado;

        return $this;
    }
}
