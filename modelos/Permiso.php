<?php 

require '../config/conexion.php';

// Soo necesitamos mostrar los permisos que existen no podremos editar eliminar o hacer 
//alguna otra opreacion

Class Permiso{
	public function __construct(){}

	public function listar(){
		$sql = "SELECT * FROM permiso";
		return ejecutarConsulta($sql);


	}

}

 ?>