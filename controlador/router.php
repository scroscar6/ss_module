<?php
    namespace controlador;
    class Router{
        protected $parametros = [];
        public function __construct(){
            $this->parseURL();
        }
        public function parseURL(){
            if(isset($_GET['url'])){
                echo $_GET['url'];
            }
        }
    }
?>