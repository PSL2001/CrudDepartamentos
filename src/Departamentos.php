<?php
namespace Deparatamentos;

use PDOException;

class Deparatamentos extends Conexion {
    private $id;
    private $nom_dep;


    public function __construct() {
        parent::__construct();
    }

    //---------------------------CRUD-----------------------
    public function create() {

    }
    public function read() {

    }
    public function update() {

    }
    public function delete() {

    }

    //--------------------------Otros Metodos-------------------
    public function crearDepartamentos($cant) {
        if (!$this->hayDepartamentos()) {
            # code...
        }
    }

    public function hayDepartamentos() {
        $q = "select * from departamentos";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay departamentos: ".$ex->getMessage());
        }
        parent::$conexion = null;
        
    }

    //---------------------------Setters-------------------------

    /**
     * Set the value of nom_dep
     *
     * @return  self
     */ 
    public function setNom_dep($nom_dep)
    {
        $this->nom_dep = $nom_dep;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}