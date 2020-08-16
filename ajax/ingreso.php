<?php 
// importamos categoria
require_once '../modelos/Ingreso.php';

// validamos si tenemos alguna session
if(strlen(session_id())<1)
session_start();

$ingreso = new Ingreso();


$idingreso = isset($_POST['idingreso'])?limpiarCadena($_POST['idingreso']):"";

$idproveedor = isset($_POST['idproveedor'])?limpiarCadena($_POST['idproveedor']):"";

$idusuario = $_SESSION['idusuario'];

$tipo_comprobante = isset($_POST['tipo_comprobante'])?limpiarCadena($_POST['tipo_comprobante']):"";

$serie_comprobante = isset($_POST['serie_comporbante'])?limpiarCadena($_POST['serie_comporbante']):"";

$num_comprobante = isset($_POST['num_comprobante'])?limpiarCadena($_POST['num_comprobante']):"";

$fecha_hora = isset($_POST['fecha_hora'])?limpiarCadena($_POST['fecha_hora']):"";

$impuesto = isset($_POST['impuesto'])?limpiarCadena($_POST['impuesto']):"";

$total_compra = isset($_POST['total_compra'])?limpiarCadena($_POST['total_compra']):"";


switch ($_GET['opcion']) {
	case 'insertar':
		$respuesta = $ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);	
		echo $respuesta? "Ingreso Registrado":"No se pudieron registrar todos los datos del ingreso";
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
		$respuesta = $ingreso->anular($idingreso);
		echo $respuesta? "Ingreso Anulado ":"Ingreso no se puede anular";
	break;

	case 'mostrar':
		$respuesta = $ingreso->mostrar($idingreso);
		//investigar 
		echo json_encode($respuesta);
	break;

	case 'listarDetalle':
		// recibimos el id ingreso 
		$id=$_GET['id'];

		$respuesta = $ingreso->listarDetalle($id);
		$total=0.0;
		// echo $respuesta? "todo bien ":"todo mal";
		echo '<thead style="background: #a9d0f5">
                                <th>Opciones</th>
                                <th>Articulo</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Subtotal</th>
                              </thead>';
		while($fila=$respuesta->fetch_object()){
			echo '<tr class="filas">
				<td></td><td>'.$fila->nombre.'</td><td>'.$fila->cantidad.'</td><td>'.$fila->precio_compra.'</td><td>'.$fila->precio_venta.'</td><td>'.$fila->precio_compra*$fila->cantidad.'</td>
				</tr>' ;
				$total +=($fila->cantidad*$fila->precio_compra);
		}
		echo '<tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                  <h4 id="total">'.$total.'</h4>
                                  <input type="hidden" name="total_compra" id="total_compra">
                                </th>
                              </tfoot>';
	break;

	case 'listar':
		
		$respuesta = $ingreso->listar();
		$data=Array();
		
		while($fila=$respuesta->fetch_object()){
			
			//ARRAY ASOCIATIVO 
			// con fetch_assoc
			// $data=['0' => $fila['idcategoria'],
			// 	   '1' => $fila['nombre'],
			// 	   '2' => $fila['descripcion'],
			// 	   '3' => $fila['condicion']];

			$data[]=array(
				"0" => ($fila->estado == 'Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$fila->idingreso.')"><i class="fa fa-eye"></i></button> '.
				'<button class="btn btn-danger" onclick="anular('.$fila->idingreso.')"><i class="fa fa-close"></i></button> ':'<button class="btn btn-warning" onclick="mostrar('.$fila->idingreso.')"><i class="fa fa-eye"></i></button> ',
					"1" => $fila->fecha,
					"2" => $fila->proveedor,
					"3" => $fila->usuario,
					"4" => $fila->tipo_comprobante,
					"5" => $fila->serie_comprobante.'-'.$fila->num_comprobante,
					"6" => $fila->total_compra,
					"7" => ($fila->estado == 'Aceptado')?'<small class="label bg-green">Aceptado</small>':'<small class="label bg-red">Anulado</small>'
					 );
		}

		$results = array(
		"sEcho"=>1,  //informacion para datatable
		"iTotalRecords"=>count($data), //el total de registros para el datatable
		"iTotalDisplayRecords"=>count($data),  //total de registros para visualizar
		"aaData"=>$data);

		echo json_encode($results);

	break;

	case'selectProveedor':
		require_once "../modelos/Persona.php";

		$persona = new Persona();

		$respuesta = $persona->listarProveedores();

		while($fila=$respuesta->fetch_object()){
				echo '<option value="'.$fila->idpersona.'">'.$fila->nombre.' </option>';

		}

	break;

	case 'listarArticulos':
		require_once '../modelos/Articulo.php';
		$articulo=new Articulo();
		$respuesta = $articulo->listarActivos();
		$data=Array();
		
		while($fila=$respuesta->fetch_object()){

			$data[]=array("0" => '<button class="btn btn-warning" onclick="agregarDetalle('.$fila->idarticulo.',\''.$fila->nombre.'\')"><span class="fa fa-plus"></span></button>',
							"1" => $fila->nombre, 
							"2" => $fila->categoria,
							"3" => $fila->codigo,
							"4" => $fila->stock,
							
							"5" => "<img src='../files/articulos/".$fila->imagen."' height='50px' width = '50px'>",
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