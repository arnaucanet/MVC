<?php

class Categoria{
    private $id_categoria;
    private $nombre_categoria;
    private $descripcion;
    private $imagen_categoria;
    private $activa;

    /**
     * Get the value of id_categoria
     */ 
    public function getId_categoria()
    {
        return $this->id_categoria;
    }

    /**
     * Set the value of id_categoria
     *
     * @return  self
     */ 
    public function setId_categoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;

        return $this;
    }

    /**
     * Get the value of nombre_categoria
     */ 
    public function getNombre_categoria()
    {
        return $this->nombre_categoria;
    }

    /**
     * Set the value of nombre_categoria
     *
     * @return  self
     */ 
    public function setNombre_categoria($nombre_categoria)
    {
        $this->nombre_categoria = $nombre_categoria;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of imagen_categoria
     */ 
    public function getImagen_categoria()
    {
        return $this->imagen_categoria;
    }

    /**
     * Set the value of imagen_categoria
     *
     * @return  self
     */ 
    public function setImagen_categoria($imagen_categoria)
    {
        $this->imagen_categoria = $imagen_categoria;

        return $this;
    }

    /**
     * Get the value of activa
     */ 
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Set the value of activa
     *
     * @return  self
     */ 
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }
}