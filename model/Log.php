<?php

class Log
{
    private $id_log;
    private $id_usuario;
    private $accion;
    private $fecha;
    private $ip_usuario;

    /**
     * Get the value of id_log
     */
    public function getId_log()
    {
        return $this->id_log;
    }

    /**
     * Set the value of id_log
     *
     * @return  self
     */
    public function setId_log($id_log)
    {
        $this->id_log = $id_log;

        return $this;
    }

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
     * Get the value of accion
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set the value of accion
     *
     * @return  self
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of ip_usuario
     */
    public function getIp_usuario()
    {
        return $this->ip_usuario;
    }

    /**
     * Set the value of ip_usuario
     *
     * @return  self
     */
    public function setIp_usuario($ip_usuario)
    {
        $this->ip_usuario = $ip_usuario;

        return $this;
    }
}
