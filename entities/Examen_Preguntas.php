<?php

    class Examen_Preguntas{
        protected $id;
        protected $id_examen;
        protected $id_pregunta;
        protected $fecha;
        protected $calificacion;
        protected $ejecucion;

        public function getId(){return $this->id;}
        public function getId_examen(){return $this->id_examen;}
        public function getId_pregunta(){return $this->id_pregunta;}
        public function getFecha(){return $this->fecha;}
        public function getCalificacion(){return $this->calificacion;}
        public function getEjecucion(){return $this->ejecucion;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->id_examen = $row['id_examen'];
            $this->id_pregunta = $row['id_pregunta'];
            $this->fecha = $row['fecha'];
            $this->calificacion = $row['calificacion'];
            $this->ejecucion = $row['ejecucion'];
        }

    }

?>