<?php
session_start();
require '../modelos/Usuario.php';

$usuario = new Usuario();

$idusuario=isset($_POST['idusuario'])?limpiarCadena($_POST['idusuario']):"";
$nombre=isset($_POST['nombre'])?limpiarCadena($_POST['nombre']):""; 
$tipo_documento=isset($_POST['tipo_documento'])?limpiarCadena($_POST['tipo_documento']):""; 
$num_documento=isset($_POST['num_documento'])?limpiarCadena($_POST['num_documento']):""; 
$direccion=isset($_POST['direccion'])?limpiarCadena($_POST['direccion']):""; 
$telefono=isset($_POST['telefono'])?limpiarCadena($_POST['telefono']):""; 
$email=isset($_POST['email'])?limpiarCadena($_POST['email']):""; 
$cargo=isset($_POST['cargo'])?limpiarCadena($_POST['cargo']):""; 
$login=isset($_POST['login'])?limpiarCadena($_POST['login']):""; 
$password=isset($_POST['password'])?limpiarCadena($_POST['password']):""; 
$imagen=isset($_POST['imagen'])?limpiarCadena($_POST['imagen']):"";


$opcion=$_GET['opcion'];

$passwordHash= hash("SHA256", $password);
switch ($opcion) {
	case 'insertar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) 
		{
			$imagen="";
		}
		else{
			$extension = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type']=="image/jpg"|| $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") 
			{
				$imagen = round(microtime(true)) . '.' . end($extension);
				move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/" . $imagen);
			}

		}
		$respuesta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $passwordHash, $imagen, $_POST['permiso']);
		echo $respuesta? "El usuario se ha registrado correctamente":"El usuario no se ha registrado correctamente";
	break;
	
	case 'editar':
	if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) 
		{
			$imagen=$_POST["imagenactual"];
		}
		else{
			$extension = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type']=="image/jpg"|| $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") 
			{
				$imagen = round(microtime(true)) . '.' . end($extension);
				move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/" . $imagen);
			}

		}	
		$respuesta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $passwordHash, $imagen, $_POST['permiso']);
		echo $respuesta? "Se edito correctamente":"El usuario no puedo editarse";
	break;

	case 'desactivar':
		$respuesta = $usuario->desactivar($idusuario);
		echo $respuesta? "EL Usuario se desactivo": "No se pudo desactivar";
	break;

	case 'activar':
		$respuesta = $usuario->activar($idusuario);
		echo $respuesta? "EL Usuario se activo": "No se pudo activar";
	break;

	case 'mostrar':
		$respuesta = $usuario->mostrar($idusuario);
		 
		echo json_encode($respuesta); 
	break;

		case 'listar':
		
		$respuesta = $usuario->listar();
		$data=Array();
		
		while($fila=$respuesta->fetch_object()){
			
			//ARRAY ASOCIATIVO 
			// con fetch_assoc
			// $data=['0' => $fila['idcategoria'],
			// 	   '1' => $fila['nombre'],
			// 	   '2' => $fila['descripcion'],
			// 	   '3' => $fila['condicion']];

			$data[]=array("0" => $fila->condicion?'<button class="btn btn-warning" onclick="mostrar('.$fila->idusuario.')"><i class="fa fa-pencil"></i></button> '.
				'<button class="btn btn-danger" onclick="desactivar('.$fila->idusuario.')"><i class="fa fa-close"></i></button> ':'<button class="btn btn-warning" onclick="mostrar('.$fila->idusuario.')"><i class="fa fa-pencil"></i></button> '.
				'<button class="btn btn-success" onclick="activar('.$fila->idusuario.')"><i class="fa fa-check"></i></button>',
							"1" => $fila->nombre, 
							"2" => $fila->tipo_documento,
							"3" => $fila->num_documento,
							// "4" => $fila->direccion,
							"4" => $fila->telefono,
							"5" => $fila->email,
							// "5" => $fila->cargo,
							"6" => $fila->login,
							"7" => "<img src='../files/usuarios/".$fila->imagen."' height='50px' width = '50px'>",
							"8" => $fila->condicion?'<small class="label bg-green">Activado</small>':'<small class="label bg-red">Desactivado</small>'
						);
		}

		$results = array(
		"sEcho"=>1,  //informacion para datatable
		"iTotalRecords"=>count($data), //el total de registros para el datatable
		"iTotalDisplayRecords"=>count($data),  //total de registros para visualizar
		"aaData"=>$data);

		echo json_encode($results);

	break;


// PERMISOS DE LOS USUARIOS
	case 'permiso':
		require_once '../modelos/Permiso.php';
		$permiso = new Permiso();
		$respuesta = $permiso->listar();

		// Obtenemos los permisos asignados al un usuario especifico

		 $id = $_GET['id'];
		 $marcados = $usuario->listamarcados($id);

		 // aarray para almacenar valores
		 $valores = array();

		 // Alamacenamos los valores asignados en este caso seran los permisos asignados
		 while($fila = $marcados->fetch_assoc()){

		 	array_push($valores, $fila['idpermiso']);
		 }



		//Mostramos todos los permisos que exiten en la tabla Permiso  
		while($fila = $respuesta->fetch_assoc()){


			// in_array busca el valor de $fila->idpermiso en el array $valores 
			$sw=in_array($fila['idpermiso'], $valores)?'checked':'';
			echo '<li> <input type="checkbox" '.$sw.' name="permiso[]" value="'.$fila["idpermiso"].'"> '.$fila['nombre'].' </li>';
		}
	break;

	case 'verificar':
		$logina=$_POST['loginAcceso'];
		$clavea=$_POST['passwordAcceso'];
		
		$clavehash=hash("SHA256",$clavea);

		$respuesta=$usuario->verificar($logina, $clavehash);

		$fila = $respuesta->fetch_object();

		//si el usuario si existe hace esto
		if(isset($fila)){
			// Variables de SESION 
			$_SESSION['idusuario']=$fila->idusuario;
			$_SESSION['nombre']=$fila->nombre;
			
			$_SESSION['imagen']=$fila->imagen;
			$_SESSION['login']=$fila->login;

			// Obtenemos todos los permisos del idusuario

			$marcados = $usuario->listamarcados($fila->idusuario);

			// Declaramos un array para almacenar todos los permisos

			$valores=array();

			while($permiso = $marcados->fetch_object()){
				array_push($valores, $permiso->idpermiso);
			}
			
			// Determinamos los accesos del usuario

			in_array(1, $valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;

			in_array(2, $valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;

			in_array(3, $valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;

			in_array(4, $valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;

			in_array(5, $valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;

			in_array(6, $valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;

			in_array(7, $valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;


				
		}
		echo json_encode($fila);
	break;

	case'salir':
		// Limpiamos las varaibles de session
		session_unset();

		// Destriumo la sesion
		session_destroy();

		// redireccionamos al login
		header('Location: ../index.php');
	break;

	default:
		# code...
		break;
}


?>