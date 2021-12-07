<?php
namespace Departamentos;

use Faker;
use PDO;
use PDOException;

class Profesores extends Conexion {
    private $id;
    private $nom_prof;
    private $sueldo;
    private $img;
    private $dep_id;


    //--------------------------CRUD------------------------
    public function create() {
        $q = "insert into profesores(nom_prof, sueldo, img, dep_id) values(:n, :s, :i, :d)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nom_prof,
                ':s'=>$this->sueldo,
                ':i'=>$this->img,
                ':d'=>$this->dep_id
            ]);
        } catch (PDOException $ex) {
            die("Error al crear el profesor, ".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    public function read() {
        $q = "select * from profesores where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el profesor:  ".$ex->getMessage());
        }
        parent::$conexion = null;

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update() {
        $q = "update profesores set nom_prof = :n, sueldo = :s, img = :im, dep_id = :d where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nom_prof,
                ':s'=>$this->sueldo,
                ':im'=>$this->img,
                ':d'=>$this->dep_id,
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar el profesor, ".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    public function delete() {
        $q = "delete from profesores where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el profesor:  ".$ex->getMessage());
        }
        parent::$conexion = null;
    }
    //--------------------------Otros metodos-------------------
    public function crearProfesores($cant) {
        if (!$this->hayProfesores()) {
            $URL_APP = "http://127.0.0.1/public/2do%20año/Segundo_Anio/Entorno%20Servidor/CrudDepartamentos/public/";
            $faker = Faker\Factory::create('es_ES');
            $ids = (new Departamentos)->devolverID();
            for ($i=0; $i < $cant; $i++) {

                (new Profesores)->setNom_prof($faker->firstName())
                ->setSueldo($faker->randomFloat(2, 0, 99999))
                ->setImg($URL_APP. "img/default.png")
                ->setDep_id($ids[random_int(0, count($ids) - 1)])
                ->create();
            }
        }
    }

    public function hayProfesores() {
        $q = "select * from profesores";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay profesores: ".$ex->getMessage());
        }
        parent::$conexion = null;

        return ($stmt->rowCount() != 0);
    }

    public function readAll() {
        $q = "select * from profesores order by nom_prof";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer los profesores: ".$ex->getMessage());
        }
        parent::$conexion = null;

        return $stmt;
    }
    public function devolverImagen($id) {
        $q = "select img from profesores where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el profesor:  ".$ex->getMessage());
        }
        parent::$conexion = null;

        return $stmt->fetch(PDO::FETCH_OBJ)->img;
    }

    public function devolverProfesores($id) {
        $q = "select * from profesores where dep_id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el profesor:  ".$ex->getMessage());
        }
        parent::$conexion = null;

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    //----------------------------------------------------------
    /**
     * Set the value of dep_id
     *
     * @return  self
     */ 
    public function setDep_id($dep_id)
    {
        $this->dep_id = $dep_id;

        return $this;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */ 
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Set the value of sueldo
     *
     * @return  self
     */ 
    public function setSueldo($sueldo)
    {
        $this->sueldo = $sueldo;

        return $this;
    }

    /**
     * Set the value of nom_prof
     *
     * @return  self
     */ 
    public function setNom_prof($nom_prof)
    {
        $this->nom_prof = $nom_prof;

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