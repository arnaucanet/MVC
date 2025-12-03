<?php
include_once 'database/database.php';
include_once 'model/Producto.php';

class ProductoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::connect();
    }

    public function getProductos()
    {
        $result = $this->db->query("SELECT * FROM producto");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function getProductoDestacado()
    {
        $sqlCat = "SELECT id_categoria FROM producto WHERE activo = 1 ORDER BY stock DESC LIMIT 1";
        $resCat = $this->db->query($sqlCat);
        if ($resCat && $row = $resCat->fetch_assoc()) {
            $catId = $row['id_categoria'];
            $sql = "SELECT * FROM producto WHERE activo = 1 AND id_categoria = $catId ORDER BY RAND() LIMIT 1";
            return $this->db->query($sql)->fetch_assoc();
        }
        $sql = "SELECT * FROM producto WHERE activo = 1 ORDER BY stock DESC LIMIT 1";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function getProductosRecomendados($limit = 12)
    {
        $sql = "SELECT * FROM producto WHERE activo = 1 AND id_categoria != 12 ORDER BY RAND() LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductosTop10()
    {
        $sql = "SELECT * FROM producto WHERE activo = 1 ORDER BY stock DESC LIMIT 10";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductosExtranjeros($limit = 12)
    {
        $sql = "
            SELECT p.*
            FROM producto p
            INNER JOIN categoria c ON p.id_categoria = c.id_categoria
            WHERE c.id_categoria IN (5, 6, 7, 9, 10, 11, 13)
            ORDER BY RAND()
            LIMIT ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results;
    }

    public function getProductoById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM producto WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results->fetch_assoc();
    }

    public function getProductoByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM producto WHERE nombre LIKE '%?%'");
        $stmt->bind_param("i", $name);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results;
    }

    public function searchProductos($query, $categoriaId = null)
    {
        // sin filtro
        if (empty($query) && empty($categoriaId)) {
            return $this->getProductos();
        }

        // filtro por categoria y producto
        if (!empty($query) && !empty($categoriaId)) {
            $sql = "SELECT * FROM producto WHERE activo = 1 AND (nombre LIKE ? OR descripcion LIKE ?) AND id_categoria = ?";
            $stmt = $this->db->prepare($sql);
            $term = "%" . $query . "%";
            $stmt->bind_param("ssi", $term, $term, $categoriaId);
        }
        // solamente producto
        elseif (!empty($query)) {
            $sql = "SELECT * FROM producto WHERE activo = 1 AND (nombre LIKE ? OR descripcion LIKE ?)";
            $stmt = $this->db->prepare($sql);
            $term = "%" . $query . "%";
            $stmt->bind_param("ss", $term, $term);
        }
        //solamente categoria
        else {
            $sql = "SELECT * FROM producto WHERE activo = 1 AND id_categoria = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $categoriaId);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create(Producto $p){
        $stmt = $this->db->prepare("INSERT INTO producto (nombre, descripcion, precio, imagen, stock, activo, id_categoria) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt) return false;
        $nombre = $p->getNombre();
        $descripcion = $p->getDescripcion();
        $precio = $p->getPrecio();
        $imagen = $p->getImagen();
        $stock = $p->getStock();
        $activo = $p->getActivo() ?: 0;
        $categoriaId = $p->getId_categoria();
        // s: string, d: double, i: integer
        // nombre(s), descripcion(s), precio(d), imagen(s), stock(i), activo(i), categoriaId(i)
        $stmt->bind_param('ssdsiii', $nombre, $descripcion, $precio, $imagen, $stock, $activo, $categoriaId);
        $ok = $stmt->execute();
        if($ok) return $this->db->insert_id;
        return false;
    }

    public function update(Producto $p){
        $stmt = $this->db->prepare("UPDATE producto SET nombre=?, descripcion=?, precio=?, imagen=?, stock=?, activo=?, id_categoria=? WHERE id_producto=?");
        if(!$stmt) return false;
        $nombre = $p->getNombre();
        $descripcion = $p->getDescripcion();
        $precio = $p->getPrecio();
        $imagen = $p->getImagen();
        $stock = $p->getStock();
        $activo = $p->getActivo() ?: 0;
        $categoriaId = $p->getId_categoria();
        $productoId = $p->getId_producto();
        
        // nombre(s), descripcion(s), precio(d), imagen(s), stock(i), activo(i), categoriaId(i), productoId(i)
        $stmt->bind_param('ssdsiiii', $nombre, $descripcion, $precio, $imagen, $stock, $activo, $categoriaId, $productoId);
        return $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->db->prepare("DELETE FROM producto WHERE id_producto = ?");
        if(!$stmt) return false;
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
