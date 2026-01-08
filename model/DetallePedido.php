<?php

class DetallePedido
{
    private $id_detalle;
    private $id_pedido;
    private $id_producto;
    private $cantidad;
    private $precio_unitario;
    private $subtotal;

    /**
     * Get the value of id_detalle
     */
    public function getId_detalle()
    {
        return $this->id_detalle;
    }

    /**
     * Set the value of id_detalle
     *
     * @return  self
     */
    public function setId_detalle($id_detalle)
    {
        $this->id_detalle = $id_detalle;

        return $this;
    }

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
     * Get the value of cantidad
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     *
     * @return  self
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get the value of precio_unitario
     */
    public function getPrecio_unitario()
    {
        return $this->precio_unitario;
    }

    /**
     * Set the value of precio_unitario
     *
     * @return  self
     */
    public function setPrecio_unitario($precio_unitario)
    {
        $this->precio_unitario = $precio_unitario;

        return $this;
    }

    /**
     * Get the value of subtotal
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set the value of subtotal
     *
     * @return  self
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }
}
