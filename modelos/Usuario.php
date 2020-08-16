<?php 

require '../config/conexion.php';

// REALIZAMOS LAS CONSULTAS DE CATEGORIA TOOOOODOOOO EL ---CRUD----

Class Usuario{
	public function __construct(){}

	public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $password, $imagen, $permisos){
		$sql = "INSERT INTO usuario(nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, password, imagen, condicion) VALUES('$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email', '$cargo', '$login', '$password', '$imagen', '1')";
		// return ejecutarConsulta($sql);
		// REGISTRAR LOS PERMISOS DE LOS USUARIOS
		// AGREGAMOS EL USUARIO PERO  obtenemos el id para poder registrar en la tabla usuario_permiso
		$idusuarionew = ejecutarConsulta_retornarID($sql);
		$numeroPermisos = 0;
		$sw = true;

		while($numeroPermisos<count($permisos)){
			$sql2 = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', $permisos[$numeroPermisos])";
			ejecutarConsulta($sql2) or $sw=false;
			$numeroPermisos +=1;
		}

		return $sw;

	}

	public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $password, $imagen, $permisos){

		$sql = "UPDATE usuario SET nombre = '$nombre', tipo_documento = '$tipo_documento', num_documento = '$num_documento', direccion ='$direccion', telefono = '$telefono', email = '$email', cargo ='$cargo', login ='$login', password = '$password', imagen='$imagen' WHERE idusuario='$idusuario'";
		
		ejecutarConsulta($sql);

		// eleminamos los registros de la tabla ususario_permiso para llenarlo de nuevo pero con los nuevos valores
		$sqlDelete = "DELETE FROM usuario_permiso WHERE idusuario = '$idusuario'";
		ejecutarConsulta($sqlDelete);


		// llenamos los nuevos permisos
		$numeroPermisos = 0;
		$sw = true;

		while($numeroPermisos<count($permisos)){
			$sql2 = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', $permisos[$numeroPermisos])";
			ejecutarConsulta($sql2) or $sw=false;
			$numeroPermisos +=1;
		}
		return $sw;
	}

	public function desactivar($idusuario){
		$sql = "UPDATE usuario SET condicion= '0' WHERE idusuario = '$idusuario'";
		return ejecutarConsulta($sql);
	}


	public function activar($idusuario){
		$sql = "UPDATE categoria SET condicion= '1' WHERE idusuario = '$idusuario'";
		return ejecutarConsulta($sql);
	}


	public function mostrar($idusuario){
		$sql = "SELECT * FROM usuario WHERE idusuario = '$idusuario'";
		return ejcutarConsultaSimpleFila($sql);

	}

	public function listar(){
		$sql = "SELECT * FROM usuario";
		return ejecutarConsulta($sql);


	}

// Mostramos los permisos asignados a un usuario 
	public function listamarcados($idusuario){
		$sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";
		return ejecutarConsulta($sql);
	}

// VERIFICAR EL ACCESO AL SISTEMA 

public function verificar($login, $password){

	$sql ="SELECT * FROM usuario WHERE login='$login' AND password='$password' AND condicion=1";
	return ejecutarConsulta($sql);
}
}
 ?>
