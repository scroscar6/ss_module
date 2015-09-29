<?php
use \configuracion\ClsConexion as Conexion;
use \controlador\Router as Router;
$Conexion = new Conexion();
$Router = new Router();
if(!$Conexion->Mantenimiento()){
	if($Conexion->Conectar()){

		if(isset($_SESSION['NOMBRE']) && isset($_SESSION['NIVEL'])){
			require('opciones.php');
			require('plantilla.php');
			$Conexion->Desconectar();
			exit();
		}else{
			//header('location: login/');
		}
	}
}else{
	$ConfigFromName = $Conexion->ConfigFromName();
	require_once('plantilla/error/mantenimiento.php');
	exit();
}
?>