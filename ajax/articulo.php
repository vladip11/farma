<?php 
// importamos categoria
require_once "../modelos/Articulo.php";

$articulo = new Articulo();

$idarticulo= isset($_POST['idarticulo'])?limpiarCadena($_POST['idarticulo']):"";
$idcategoria = isset($_POST['idcategoria'])?limpiarCadena($_POST['idcategoria']):"";
$codigo = isset($_POST['codigo'])?limpiarCadena($_POST['codigo']):"";
$nombre = isset($_POST['nombre'])?limpiarCadena($_POST['nombre']):"";
$stock = isset($_POST['stock'])?limpiarCadena($_POST['stock']):"";
$descripcion = isset($_POST['descripcion'])?limpiarCadena($_POST['descripcion']):"";
$imagen = isset($_POST['imagen'])?limpiarCadena($_POST['imagen']):"";
$ubicacion = isset($_POST['ubicacion'])?limpiarCadena($_POST['ubicacion']):"";

switch ($_GET['opcion']) {
	case 'insertar':

	//CODIGO PARA VALIDAD LAS IMAGENES
		/*if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) 
		{
			$imagen="";
		}
		else{
			$extension = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type']=="image/jpg"|| $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") 
			{
				$imagen = round(microtime(true)) . '.' . end($extension);
				move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/" . $imagen);
			}

		}*/
		$respuesta = $articulo->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen,$ubicacion);	
		if ($respuesta) 
				echo "Se inserto correctamente";
		else 
			echo "no se inserto";
	break;

	case 'editar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen=$_POST["imagenactual"];
		}else{
			$extension = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type']=="image/jpg"|| $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
				$imagen = round(microtime(true)) . '.'. end($extension);
				move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/" . $imagen);
			}

		}
		$respuesta = $articulo->editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
		echo $respuesta?"Se edito el articulo $nombre": "no se edito";
	break;

	case 'desactivar':
		$respuesta = $articulo->desactivar($idarticulo);
		echo $respuesta? "Se desactivo " :"no se pudo desactivar";
	break;


	case 'activar':
		$respuesta = $articulo->activar($idarticulo);
		echo $respuesta? "Se activo ":"no se pudo activar";
	break;

	case 'mostrar':
		$respuesta = $articulo->mostrar($idarticulo);
		//investigar 
		echo json_encode($respuesta);
	break;

	case 'listar':
		
		$respuesta = $articulo->listar();
		$data=Array();
		
		while($fila=$respuesta->fetch_object()){
			
			//ARRAY ASOCIATIVO 
			// con fetch_assoc
			// $data=['0' => $fila['idcategoria'],
			// 	   '1' => $fila['nombre'],
			// 	   '2' => $fila['descripcion'],
			// 	   '3' => $fila['condicion']];

			$data[]=array("0" => $fila->condicion?'<button class="btn btn-warning" onclick="mostrar('.$fila->idarticulo.')"><i class="fa fa-pencil"></i></button> '.
				'<button class="btn btn-danger" onclick="desactivar('.$fila->idarticulo.')"><i class="fa fa-close"></i></button> ':'<button class="btn btn-warning" onclick="mostrar('.$fila->idarticulo.')"><i class="fa fa-pencil"></i></button> '.
				'<button class="btn btn-success" onclick="activar('.$fila->idarticulo.')"><i class="fa fa-check"></i></button>',
							"1" => $fila->categoria, 
							"2" => $fila->codigo,
							"3" => $fila->nombre,
							"4" => $fila->stock,
							"5" => $fila->descripcion,
							"6" => $fila->imagen,
							"7" => $fila->ubicacion,
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

	
	default:
		# code...
		break;
}


 ?>