<?php
namespace MyApi;
require_once 'DataBase.php'; 

class Products extends DataBase {
    private $data = []; 

    public function __construct(string $db, string $user = 'root', string $pass = 'aarr2004', string $host = 'localhost') {

        parent::__construct($db, $user, $pass, $host);
        $this->conexion->set_charset("utf8"); 
    }

    public function list(): void {
        $sql = "SELECT * FROM productos WHERE eliminado = 0";
        if ( $result = $this->conexion->query($sql) ) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!is_null($rows)) {
                $this->data = $rows; 
            } else {
                 $this->data = [];
            }
            $result->free();
        } else {
            $this->data = ['status' => 'error', 'message' => 'Query Error: ' . $this->conexion->error];
        }
    }

    public function single(string $id): void {
        $id_safe = $this->conexion->real_escape_string($id);
        $sql = "SELECT * FROM productos WHERE id = {$id_safe}";
        
        if ( $result = $this->conexion->query($sql) ) {
            $row = $result->fetch_assoc();
            $this->data = (!is_null($row)) ? $row : [];
            $result->free();
        } else {
             $this->data = ['status' => 'error', 'message' => 'Query Error: ' . $this->conexion->error];
        }
    }

    public function search(string $query): void {
        $search_safe = $this->conexion->real_escape_string($query);
        $sql = "SELECT * FROM productos WHERE (id = '{$search_safe}' OR nombre LIKE '%{$search_safe}%' OR marca LIKE '%{$search_safe}%' OR detalles LIKE '%{$search_safe}%') AND eliminado = 0";
        
        if ( $result = $this->conexion->query($sql) ) {
			$rows = $result->fetch_all(MYSQLI_ASSOC);
            $this->data = (!is_null($rows)) ? $rows : [];
			$result->free();
		} else {
            $this->data = ['status' => 'error', 'message' => 'Query Error: ' . $this->conexion->error];
        }
    }
    
    public function singleByName(string $name, int $id = 0): void {
        $nombre_safe = $this->conexion->real_escape_string($name);
    
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre_safe}' AND eliminado = 0 AND id != {$id}";
        
        if ($result = $this->conexion->query($sql)) {
            $existe = ($result->num_rows > 0);
            $this->data = [
                'status' => 'success',
                'existe' => $existe,
                'message' => 'Verificación completa'
            ];
            $result->free();
        } else {
            $this->data = ['status' => 'error', 'message' => 'Error en la consulta: ' . $this->conexion->error];
        }
    }

    public function add(\stdClass $jsonOBJ): void {
        $nombre_safe = $this->conexion->real_escape_string($jsonOBJ->nombre);
        $check_sql = "SELECT id FROM productos WHERE nombre = '{$nombre_safe}' AND eliminado = 0";
        $check_result = $this->conexion->query($check_sql);
        
        if ($check_result && $check_result->num_rows == 0) {
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if($this->conexion->query($sql)){
                $this->data = ['status' => 'success', 'message' => 'Producto agregado'];
            } else {
                $this->data = ['status' => 'error', 'message' => "ERROR: No se ejecuto la inserción. " . $this->conexion->error];
            }
            $check_result->free();
        } else {
            $this->data = ['status' => 'error', 'message' => 'Ya existe un producto con ese nombre'];
        }
    }

    public function edit(\stdClass $jsonOBJ): void {
        $sql =  "UPDATE productos SET nombre='{$jsonOBJ->nombre}', marca='{$jsonOBJ->marca}',";
        $sql .= "modelo='{$jsonOBJ->modelo}', precio={$jsonOBJ->precio}, detalles='{$jsonOBJ->detalles}',"; 
        $sql .= "unidades={$jsonOBJ->unidades}, imagen='{$jsonOBJ->imagen}' WHERE id={$jsonOBJ->id}";

        if ( $this->conexion->query($sql) ) {
            $this->data = ['status' => 'success', 'message' => 'Producto actualizado'];
		} else {
            $this->data = ['status' => 'error', 'message' => "ERROR: No se ejecuto la actualización. " . $this->conexion->error];
        }
    }

    public function delete(string $id): void {
        $id_safe = $this->conexion->real_escape_string($id);
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id_safe}";
        if ( $this->conexion->query($sql) ) {
            $this->data = ['status' => 'success', 'message' => 'Producto eliminado'];
		} else {
            $this->data = ['status' => 'error', 'message' => "ERROR: No se ejecuto el borrado. " . $this->conexion->error];
        }
    }

    public function getData(): string {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}