<?php 

require '../config/conexion.php';

// REALIZAMOS LAS CONSULTAS DE CATEGORIA TOOOOODOOOO EL ---CRUD----

Class Persona{
	public function __construct(){}

	public function insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $correo){
		$sql = "INSERT INTO persona(tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, correo) VALUES('$tipo_persona', '$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$correo')";
		return ejecutarConsulta($sql);
	}

	public function editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $correo){

		$sql = "UPDATE persona SET tipo_persona = '$tipo_persona', nombre = '$nombre', tipo_documento = '$tipo_documento', num_documento= '$num_documento', direccion = '$direccion', telefono = '$telefono', correo = '$correo' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}
// FUNCTION PARA ELIMINAR UNA PERSONA
	public function eliminar($idpersona){
		$sql = "DELETE FROM persona WHERE idpersona = '$idpersona'";
		return ejecutarConsulta($sql);
	}

	// MOSTRAR LOS DATOS  DE UNA PERSONA
	public function mostrar($idpersona){
		$sql = "SELECT * FROM persona WHERE idpersona = '$idpersona'";
		return ejcutarConsultaSimpleFila($sql);

	}



	public function listarProveedores(){
		$sql = "SELECT * FROM persona  WHERE tipo_persona='Proveedor'";
		return ejecutarConsulta($sql);
	}

	public function listarClientes(){
		$sql = "SELECT * FROM persona  WHERE tipo_persona='Cliente'";
		return ejecutarConsulta($sql);
	}

}

 ?>