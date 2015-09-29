<?php
function __autoload($class){
    $class = ROOT.DIR.str_replace('\\',DIR,$class).'.php';
    if (!file_exists($class)){
        throw new Exception("Ruta del Archivo path '{$class}' no encontrada.");
    }
    require_once($class);
}
 ?>