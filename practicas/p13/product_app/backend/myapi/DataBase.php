<?php
namespace TECWEB\MYAPI;

abstract class DataBase {
    protected $conexion;
    protected $data;

    // Según el UML: user, pass, db
    public function __construct($user, $pass, $db) {
        $this->data = array();
        // mysqli_connect usa: Host, User, Pass, DB
        $this->conexion = @mysqli_connect(
            'localhost',
            $user, 
            $pass, 
            $db
        );
    
        if(!$this->conexion) {
            die('¡Base de datos NO conectada! Error: ' . mysqli_connect_error());
        }
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}