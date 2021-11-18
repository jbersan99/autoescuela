<?php

    class Examen{
        protected $id;
        protected $descripcion;
        protected $duracion;
        protected $numero_preguntas;
        protected $activo;

        public function getId(){return $this->id;}
        public function getDesripcion(){return $this->descripcion;}
        public function getDuracion(){return $this->duracion;}
        public function getNumero_Preguntas(){return $this->numero_preguntas;}
        public function getActivo(){return $this->activo;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->descripcion = $row['descripcion'];
            $this->duracion = $row['duracion'];
            $this->numero_preguntas = $row['numero_preguntas'];
            $this->activo = $row['activo'];
        }

    }

?>