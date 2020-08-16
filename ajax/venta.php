<?php 
// importamos categoria
require_once '../modelos/Venta.php';

// validamos si tenemos alguna session
if(strlen(session_id())<1)
session_start();

$venta = new Venta();


$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";


switch ($_GET['opcion']) {
	case 'insertar':
		$respuesta = $venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);	
		echo $respuesta? "La venta se ha Registrado":"No se pudieron registrar todos los datos de la venta";
		//if ($respuesta) 
	///			echo "Se inserto EL ingreso correctamente";
	//	else 
	//		echo "no se inserto";
	break;

	// case 'editar':
	// 	$respuesta = $categoria->editar($idcategoria, $nombre, $descripcion);
	// 	echo $respuesta?"Se edito la categoria $nombre": "no se edito";
	// break;




	case 'anular':
		$respuesta = $venta->anular($idventa);
		echo $respuesta? "Venta Anulada ":"La Venta no se puede anular";
	break;

	case 'mostrar':
		$respuesta = $venta->mostrar($idventa);

		// echo $respuesta?'todo bien' : 'todo mal';
		echo json_encode($respuesta);
	break;

	case 'listarDetalle':
		// recibimos el id ingreso 
		$id=$_GET['id'];

		$respuesta = $venta->listarDetalle($id);
		$total=0.0;
		// echo $respuesta? "todo bien ":"todo mal";
		echo '<thead style="background: #a9d0f5">
                                <th>Opciones</th>
                                <th>Articulo</th>
                                <th>Cantidad</th>
                                <th>Precio Venta</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                              </thead>';
		while($fila=$respuesta->fetch_object()){
			echo '<tr class="filas">
			<td></td>
			<td>'.$fila->nombre.'</td>
			<td>'.$fila->cantidad.'</td>
			<td>'.$fila->precio_venta.'</td>
			<td>'.$fila->descuento.'</td>
			<td>'.$fila->subtotal.'</td></tr>';
			$total=$total+($fila->precio_venta*$fila->cantidad-$fila->descuento);
		}
		echo '<tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                  <h4 id="total">'.$total.'</h4>
                                  <input type="hidden" name="total_venta" id="total_venta">
                                </th>
                              </tfoot>';
	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($fila=$rspta->fetch_object()){
 			if($fila->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}else{
 				$url='../reportes/exFactura.php?id=';
 			}

 			$data[]=array(

 				"0"=>(($fila->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$fila->idventa.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$fila->idventa.')"><i class="fa fa-close"></i></button> '.'<a target="_blank" href="'.$url.$fila->idventa.'"><button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$fila->idventa.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$fila->fecha,
 				"2"=>$fila->cliente,
 				"3"=>$fila->usuario,
 				"4"=>$fila->tipo_comprobante,
 				"5"=>$fila->serie_comprobante.'-'.$fila->num_comprobante,
 				"6"=>$fila->total_venta,
 				"7"=>($fila->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




	case'selectCliente':
		require_once "../modelos/Persona.php";

		$persona = new Persona();

		$respuesta = $persona->listarClientes();

		while($fila=$respuesta->fetch_object()){
				echo '<option value="'.$fila->idpersona.'">'.$fila->nombre.' </option>';

		}

	break;

	case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
 				"5"=>$reg->precio_venta,
 				"6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'anular':
		$respuesta = $venta->anular($idventa);
		echo $respuesta? "Venta Anulada ":"Venta no se puede anular";
	break;
	
	default:
		# code...
		break;
}


 ?>