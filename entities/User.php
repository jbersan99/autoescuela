<?php

    class User{
        protected $id;
        protected $email;
        protected $nombre;
        protected $apellidos;
        protected $password;
        protected $nacimiento;
        protected $rol;
        protected $foto;

        public function getId(){return $this->id;}
        public function getEmail(){return $this->email;}
        public function getNombre(){return $this->nombre;}
        public function getApellidos(){return $this->apellidos;}
        public function getPassword(){return $this->password;}
        public function getNacimiento(){return $this->nacimiento;}
        public function getRol(){return $this->rol;}
        public function getFoto(){return $this->foto;}

        public function __construct($row){
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->nombre = $row['nombre'];
            $this->apellidos = $row['apellidos'];
            $this->password = $row['password'];
            $this->nacimiento = $row['nacimiento'];
            $this->rol = $row['rol'];
            $this->foto = $row['foto'];
        }
    }

?>