<?php 
// importamos persona
require_once '../modelos/Persona.php';

$persona = new Persona();



$idpersona=isset($_POST['idpersona'])?limpiarCadena($_POST['idpersona']):"";
$tipo_persona=isset($_POST['tipo_persona'])?limpiarCadena($_POST['tipo_persona']):"";
$nombre=isset($_POST['nombre'])?limpiarCadena($_POST['nombre']):"";
$tipo_documento=isset($_POST['tipo_documento'])?limpiarCadena($_POST['tipo_documento']):"";
$num_documento=isset($_POST['num_documento'])?limpiarCadena($_POST['num_documento']):""; 
$direccion=isset($_POST['direccion'])?limpiarCadena($_POST['direccion']):""; 
$telefono=isset($_POST['telefono'])?limpiarCadena($_POST['telefono']):""; 
$correo=isset($_POST['correo'])?limpiarCadena($_POST['correo']):"";


switch ($_GET['opcion']) {
	case 'insertar':
	$respuesta = $persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $correo);	
	if ($respuesta) 
		echo "Se inserto correctamente";
	else 
		echo "no se inserto";
	break;

	case 'editar':
	$respuesta = $persona->editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $correo);
	echo $respuesta?"Se edito la persona $nombre": "no se edito";
	break;

	case 'eliminar':
	$respuesta = $persona->eliminar($idpersona);
	echo $respuesta? "Se elimino la persona $nombre " :"no se pudo eliminar";
	break;

	case 'mostrar':
	$respuesta = $persona->mostrar($idpersona);
		//investigar 
	echo json_encode($respuesta);
	break;

	case 'listarProveedores':

	$respuesta = $persona->listarProveedores();
	$data=Array();

	while($fila=$respuesta->fetch_object()){

			//ARRAY ASOCIATIVO 
			// con fetch_assoc
			// $data=['0' => $fila['idpersona'],
			// 	   '1' => $fila['nombre'],
			// 	   '2' => $fila['descripcion'],
			// 	   '3' => $fila['condicion']];

		$data[]=array("0" => '<button class="btn btn-warning" onclick= "mostrar('.$fila->idpersona.')"><i class="fa fa-pencil"></i></button> '.
			'<button class="btn btn-danger" onclick="eliminar('.$fila->idpersona.')"><i class="fa fa-trash"></i></button>',
			"1" => $fila->nombre,
			"2" => $fila->tipo_documento,
			"3" => $fila->num_documento, 
			"4" => $fila->direccion,
			"5" => $fila->telefono,
			"6" => $fila->correo
		);
	}

	$results = array(
		"sEcho"=>1,  //informacion para datatable
		"iTotalRecords"=>count($data), //el total de registros para el datatable
		"iTotalDisplayRecords"=>count($data),  //total de registros para visualizar
		"aaData"=>$data);

	echo json_encode($results);

	break;

	case 'listarClientes':

	$respuesta = $persona->listarClientes();
	$data=Array();

	while($fila=$respuesta->fetch_object()){

			//ARRAY ASOCIATIVO 
			// con fetch_assoc
			// $data=['0' => $fila['idpersona'],
			// 	   '1' => $fila['nombre'],
			// 	   '2' => $fila['descripcion'],
			// 	   '3' => $fila['condicion']];

		$data[]=array("0" => '<button clas="btn btn-info" onclick= "mostrar('.$fila->idpersona.')"><i class="fa fa-pencil"></i></button> '.
			'<button class="btn btn-danger" onclick="eliminar('.$fila->idpersona.')"><i class="fa fa-trash"></i></button>',
			"1" => $fila->nombre,
			"2" => $fila->tipo_documento,
			"3" => $fila->num_documento, 
			"4" => $fila->direccion,
			"5" => $fila->telefono,
			"6" => $fila->correo
		);
	}

	$results = array(
		"sEcho"=>1,  //informacion para datatable
		"iTotalRecords"=>count($data), //el total de registros para el datatable
		"iTotalDisplayRecords"=>count($data),  //total de registros para visualizar
		"aaData"=>$data);

	echo json_encode($results);

	break;



	
	default:
		# code...
	break;
}


?>