<?php

    class Examen_Hechos{
        protected $id_examen;
        protected $id_usuario;

        public function getId_Examen(){return $this->id_examen;}
        public function getId_Usuario(){return $this->id_usuario;}

        public function __construct($row){
            $this->id_examen = $row['id_examen'];
            $this->id_usuario = $row['id_usuario'];
        }
    }

?>