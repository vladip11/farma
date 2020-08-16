<?php 
// importamos categoria
require_once '../modelos/Categoria.php';

$categoria = new Categoria();


$idcategoria = isset($_POST['idcategoria'])?limpiarCadena($_POST['idcategoria']):"";
$nombre = isset($_POST['nombre'])?limpiarCadena($_POST['nombre']):"";
$descripcion = isset($_POST['descripcion'])?limpiarCadena($_POST['descripcion']):"";





switch ($_GET['opcion']) {

	case 'insertar':
		$respuesta = $categoria->insertar($nombre, $descripcion);	
		if ($respuesta) 
				echo "Se inserto correctamente";
		else 
			echo "no se inserto";



	break;

	case 'editar':
		$respuesta = $categoria->editar($idcategoria, $nombre, $descripcion);
		echo $respuesta?"Se edito la categoria $nombre": "no se edito";
	break;

	

	case 'desactivar':
		$respuesta = $categoria->desactivar($idcategoria);
		echo $respuesta? "Se desactivo " :"no se pudo desactivar";
	break;


	case 'activar':
		$respuesta = $categoria->activar($idcategoria);
		echo $respuesta? "Se activo ":"no se pudo activar";
	break;

	case 'mostrar':
		$respuesta = $categoria->mostrar($idcategoria);
		//investigar 
		echo json_encode($respuesta);
	break;

	case 'listar':
		
		$respuesta = $categoria->listar();
		$data=Array();
		
		while($fila=$respuesta->fetch_object()){
			
			//ARRAY ASOCIATIVO 
			// con fetch_assoc
			// $data=['0' => $fila['idcategoria'],
			// 	   '1' => $fila['nombre'],
			// 	   '2' => $fila['descripcion'],
			// 	   '3' => $fila['condicion']];

			$data[]=array("0" => $fila->condicion?'<button class="btn btn-warning" onclick="mostrar('.$fila->idcategoria.')"><i class="fa fa-pencil"></i></button> '.
				'<button class="btn btn-danger" onclick="desactivar('.$fila->idcategoria.')"><i class="fa fa-close"></i></button> ':'<button class="btn btn-warning" onclick="mostrar('.$fila->idcategoria.')"><i class="fa fa-pencil"></i></button> '.
				'<button class="btn btn-success" onclick="activar('.$fila->idcategoria.')"><i class="fa fa-check"></i></button>',
					"1" => $fila->nombre,
					"2" => $fila->descripcion,
					"3" => $fila->condicion?'<small class="label bg-green">Activado</small>':'<small class="label bg-red">Desactivado</small>'
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