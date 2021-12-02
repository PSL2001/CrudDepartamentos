<?php
namespace Departamentos;

use Faker;
use PDO;
use PDOException;

class Departamentos extends Conexion {
    private $id;
    private $nom_dep;


    public function __construct() {
        parent::__construct();
    }

    //---------------------------CRUD-----------------------
    public function create() {
        $q = "insert into departamentos(nom_dep) values(:n)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nom_dep
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar departamento: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }
    public function read() {
        $q = "select * from departamentos where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al leer departamento: ".$ex->getMessage());
        }
        parent::$conexion = null;

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function update() {
        $q = "update departamentos set nom_dep=:n where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nom_dep,
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar departamento: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }
    public function delete() {
        $q = "delete from departamentos where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar departamento: ".$ex->getMessage());
        }

        parent::$conexion = null;
    }

    //--------------------------Otros Metodos-------------------
    public function crearDepartamentos($cant) {
        if (!$this->hayDepartamentos()) {
            $faker = Faker\Factory::create('es_ES');
            for ($i=0; $i < $cant; $i++) { 
                (new Departamentos)->setNom_dep($faker->word())
                ->create();
            }
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
        
        return ($stmt->rowCount() != 0);
    }

    public function readAll() {
        $q = "select * from departamentos";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer los departamentos: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
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