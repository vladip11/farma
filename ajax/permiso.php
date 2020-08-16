<?php 
// importamos categoria
require_once '../modelos/Permiso.php';

$permiso = new Permiso();

switch ($_GET['opcion']) {

	case 'listar':
		
		$respuesta = $permiso->listar();
		$data=Array();
		
		while($fila=$respuesta->fetch_object()){
			
			//ARRAY ASOCIATIVO 
		//SOLO MOSTRAREMOS EL NOMBRE DEL PERMISO
			
			$data[]=array("0" => $fila->nombre);
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