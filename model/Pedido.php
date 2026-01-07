<?php

class Pedido {
    private $id_pedido;
    private $id_usuario;
    private $id_oferta;
    private $fecha_pedido;
    private $estado;
    private $total;
    private $moneda;
    private $nombre_destinatario;
    private $direccion_envio;
    private $cp;
    private $ciudad;
    private $telefono_contacto;

    /**
     * Get the value of id_pedido
     */ 
    public function getId_pedido()
    {
            return $this->id_pedido;
    }

    /**
     * Set the value of id_pedido
     *
     * @return  self
     */ 
    public function setId_pedido($id_pedido)
    {
            $this->id_pedido = $id_pedido;

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
     * Get the value of id_oferta
     */ 
    public function getId_oferta()
    {
            return $this->id_oferta;
    }

    /**
     * Set the value of id_oferta
     *
     * @return  self
     */ 
    public function setId_oferta($id_oferta)
    {
            $this->id_oferta = $id_oferta;

            return $this;
    }

    /**
     * Get the value of fecha_pedido
     */ 
    public function getFecha_pedido()
    {
            return $this->fecha_pedido;
    }

    /**
     * Set the value of fecha_pedido
     *
     * @return  self
     */ 
    public function setFecha_pedido($fecha_pedido)
    {
            $this->fecha_pedido = $fecha_pedido;

            return $this;
    }

    /**
     * Get the value of estado
     */ 
    public function getEstado()
    {
            return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */ 
    public function setEstado($estado)
    {
            $this->estado = $estado;

            return $this;
    }

    /**
     * Get the value of total
     */ 
    public function getTotal()
    {
            return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */ 
    public function setTotal($total)
    {
            $this->total = $total;

            return $this;
    }

    /**
     * Get the value of moneda
     */ 
    public function getMoneda()
    {
            return $this->moneda;
    }

    /**
     * Set the value of moneda
     *
     * @return  self
     */ 
    public function setMoneda($moneda)
    {
            $this->moneda = $moneda;

            return $this;
    }

    /**
     * Get the value of nombre_destinatario
     */ 
    public function getNombre_destinatario()
    {
        return $this->nombre_destinatario;
    }

    /**
     * Set the value of nombre_destinatario
     *
     * @return  self
     */ 
    public function setNombre_destinatario($nombre_destinatario)
    {
        $this->nombre_destinatario = $nombre_destinatario;

        return $this;
    }

    /**
     * Get the value of direccion_envio
     */ 
    public function getDireccion_envio()
    {
        return $this->direccion_envio;
    }

    /**
     * Set the value of direccion_envio
     *
     * @return  self
     */ 
    public function setDireccion_envio($direccion_envio)
    {
        $this->direccion_envio = $direccion_envio;

        return $this;
    }

    /**
     * Get the value of cp
     */ 
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set the value of cp
     *
     * @return  self
     */ 
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get the value of ciudad
     */ 
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     *
     * @return  self
     */ 
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get the value of telefono_contacto
     */ 
    public function getTelefono_contacto()
    {
        return $this->telefono_contacto;
    }

    /**
     * Set the value of telefono_contacto
     *
     * @return  self
     */ 
    public function setTelefono_contacto($telefono_contacto)
    {
        $this->telefono_contacto = $telefono_contacto;

        return $this;
    }
}