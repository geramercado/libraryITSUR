<?php
    class Usuario{
        public $id=0;
        public $nombre="";
        public $apellido1="";
        public $apellido2="";
        public $fecha_nac;//->format('Y-m-d');
        public $email="";
        public $genero="M";
        public $password="";
        public $puesto="";
        public function __construct(){
            $this->fecha_nac=new DateTime();
        }
    }
?>