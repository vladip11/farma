<?php 

require_once '../modelos/Consultas.php';

$consulta = new Consultas();



switch ($_GET['opcion']) {

	case 'comprasfecha':

		$fecha_inicio=$_REQUEST['fecha_inicio'];
		$fecha_fin=$_REQUEST['fecha_fin'];

		
		$respuesta = $consulta->comprasfecha($fecha_inicio, $fecha_fin);

		$data=Array();

		// echo $respuesta?'todo bien':'todo mal';
		
		while($fila=$respuesta->fetch_object()){
			
			$data[]=array("0" => $fila->fecha,
					"1" => $fila->usuario,
					"2" => $fila->proveedor,
					"3" => $fila->tipo_comprobante,
					"4" => $fila->serie_comprobante.' '.$fila->num_comprobante,
					"5" => $fila->total_compra,
					"6" => $fila->impuesto,
					"7" => ($fila->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
					 );
		}

		$results = array(
		"sEcho"=>1,  //informacion para datatable
		"iTotalRecords"=>count($data), //el total de registros para el datatable
		"iTotalDisplayRecords"=>count($data),  //total de registros para visualizar
		"aaData"=>$data);

		echo json_encode($results);

	break;

	case 'ventasfechacliente':

		$fecha_inicio=$_REQUEST['fecha_inicio'];
		$fecha_fin=$_REQUEST['fecha_fin'];
		$idcliente=$_REQUEST['idcliente'];
		
		$respuesta = $consulta->ventasfechacliente($fecha_inicio, $fecha_fin, $idcliente);
		
		$data=Array();

		// echo $respuesta?'todo bien':'todo mal';
		
		while($fila=$respuesta->fetch_object()){
			
			$data[]=array("0" => $fila->fecha,
					"1" => $fila->usuario,
					"2" => $fila->cliente,
					"3" => $fila->tipo_comprobante,
					"4" => $fila->serie_comprobante.' '.$fila->num_comprobante,
					"5" => $fila->total_venta,
					"6" => $fila->impuesto,
					"7" => ($fila->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
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