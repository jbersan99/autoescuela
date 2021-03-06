<?php

    class User{
        protected $id;
        protected $email;
        protected $nombre;
        protected $password;
        protected $nacimiento;
        protected $rol;
        protected $foto;
        protected $confirmado;

        public function getId(){return $this->id;}
        public function getEmail(){return $this->email;}
        public function getNombre(){return $this->nombre;}
        public function getPassword(){return $this->password;}
        public function getNacimiento(){return $this->nacimiento;}
        public function getRol(){return $this->rol;}
        public function getFoto(){return $this->foto;}
        public function getConfirmado(){return $this->confirmado;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->nombre = $row['nombre'];
            $this->password = $row['password'];
            $this->nacimiento = $row['nacimiento'];
            $this->rol = $row['rol'];
            $this->foto = $row['foto'];
            $this->confirmado = $row['confirmado'];
        }
    }

?>