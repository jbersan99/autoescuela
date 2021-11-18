<?php

    class Respuesta{
        protected $id;
        protected $enunciado;
        protected $id_pregunta;
        
        public function getId(){return $this->id;}
        public function getEnunciado(){return $this->enunciado;}
        public function getId_pregunta(){return $this->id_pregunta;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->enunciado = $row['enunciado'];
            $this->id_pregunta = $row['id_pregunta'];
        }
    }

?>