<?php

    class Tematica{
        protected $id;
        protected $tema;

        public function getId(){return $this->id;}
        public function getTema(){return $this->tema;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->tema = $row['tema'];
        }
    }

?>