<?php

    class Examen{
        protected $id;
        protected $descripcion;
        protected $duracion;
        protected $id_preguntas;

        public function getId(){return $this->id;}
        public function getDesripcion(){return $this->descripcion;}
        public function getDuracion(){return $this->duracion;}
        public function getId_Preguntas(){return $this->id_preguntas;}
        public function getActivo(){return $this->activo;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->descripcion = $row['descripcion'];
            $this->duracion = $row['duracion'];
            $this->id_preguntas = $row['id_preguntas'];
        }

    }

?>