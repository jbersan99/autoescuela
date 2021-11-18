<?php

    class Preguntas{
        protected $id;
        protected $enunciado;
        protected $respuesta_correcta;
        protected $recurso;
        protected $id_tematica;

        public function getId(){return $this->id;}
        public function getEnunciado(){return $this->enunciado;}
        public function getRespuesta_correcta(){return $this->respuesta_correcta;}
        public function getRecurso(){return $this->recurso;}
        public function getId_tematica(){return $this->id_tematica;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->enunciado = $row['enunciado'];
            $this->respuesta_correcta = $row['respuesta_correcta'];
            $this->recurso = $row['recurso'];
            $this->id_tematica = $row['id_tematica'];
        }

    }

?>