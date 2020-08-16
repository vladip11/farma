<?php 
require_once 'global.php';

// llamamos a las constantes definidad
$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

mysqli_query($conexion, 'SET NAMES "' .DB_ENCODE.'"');


//comprobaremos si tenemos algun error en la conexion y lo mostramos 

if (mysqli_connect_errno()) {
	# code...
	printf("Fallo de conexion a la base de datos: ",mysqli_connect_error());
	exit();
}

if(!function_exists('ejecutarConsulta'))
{
	function ejecutarConsulta($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $query;
	}

	function ejcutarConsultaSimpleFila($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$row = $query->fetch_assoc();
		return $row;
	}

	function ejecutarConsulta_retornarID($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $conexion->insert_id;
	}

	function limpiarCadena($str){
		global $conexion;
		$str = mysqli_real_escape_string($conexion, trim($str));   // borra espacion adelante y  al final 
		$str = stripcslashes($str);  //remueve las  diagonales \

		return htmlspecialchars($str);  //carateres especiales en entidades html   como <h1> 
	}



}


 ?>
