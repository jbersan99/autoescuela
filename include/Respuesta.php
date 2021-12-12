<?php

    class Respuesta{
        protected $id;
        protected $enunciado_respuesta;
        protected $id_pregunta;
        
        public function getId(){return $this->id;}
        public function getEnunciado_respuesta(){return $this->enunciado_respuesta;}
        public function getId_pregunta(){return $this->id_pregunta;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->enunciado_respuesta = $row['enunciado_respuesta'];
            $this->id_pregunta = $row['id_pregunta'];
        }
    }

?>