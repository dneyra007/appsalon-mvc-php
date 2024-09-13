<?php

namespace Model;

class Servicio extends ActiveRecord {

    // base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

public function __construct($args = [])

{
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->precio = $args['precio'] ?? '';
}

public function validar() {
    if(!$this->nombre) {
        self::$alertas['error'][] = 'Name of the service is required';
    }
    if(!$this->precio) {
        self::$alertas['error'][] = 'Price of the service is required';
    }
    if(!is_numeric($this->precio)) {
        self::$alertas['error'][] = 'Price must be a number';
    }

    return self::$alertas;
}

}