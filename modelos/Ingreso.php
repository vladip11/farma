<?php 

require '../config/conexion.php';

// REALIZAMOS LAS CONSULTAS DE CATEGORIA TOOOOODOOOO EL ---CRUD----

Class Ingreso{
	public function __construct(){}

	public function insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_compra, $idarticulo, $cantidad, $precio_compra, $precio_venta){
		$sql = "INSERT INTO ingreso(idproveedor, idusuario, tipo_comprobante, serie_comprobante, num_comprobante, fecha_hora, impuesto, total_compra, estado) VALUES('$idproveedor', '$idusuario', '$tipo_comprobante', '$serie_comprobante', '$num_comprobante', '$fecha_hora', '$impuesto', '$total_compra', 'Aceptado')";
		// return ejecutarConsulta($sql);
		// REGISTRAR LOS PERMISOS DE LOS USUARIOS
		// AGREGAMOS EL USUARIO PERO  obtenemos el id para poder registrar en la tabla usuario_permiso
		$idingresonew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;

		while($num_elementos<count($idarticulo)){

			$sql2 = "INSERT INTO detalles_ingreso(idingreso, idarticulo, cantidad, precio_compra, precio_venta) VALUES('$idingresonew', '$idarticulo[$num_elementos]', '$cantidad[$num_elementos]', '$precio_compra[$num_elementos]', '$precio_venta[$num_elementos]')";

			ejecutarConsulta($sql2) or $sw=false;
			$num_elementos +=1;
		}

		return $sw;

	}


	public function anular($idingreso){
		$sql = "UPDATE ingreso SET estado= 'Anulado' WHERE idingreso = '$idingreso'";
		return ejecutarConsulta($sql);
	}


	public function mostrar($idingreso){
		$sql = "SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor, p.nombre as proveedor, u.idusuario, u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra, i.idingreso, i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor= p.idpersona INNER JOIN usuario u ON i.idusuario = u.idusuario WHERE idingreso = '$idingreso'";
		return ejcutarConsultaSimpleFila($sql);

	}


	// LISTAMOS DETALLES 
	public function listarDetalle($idingreso){
		$sql = " SELECT di.idingreso, di.idarticulo, a.nombre, di.cantidad, di.precio_compra, di.precio_venta FROM detalles_ingreso di INNER JOIN articulo a on di.idarticulo=a.idarticulo WHERE di.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}




	public function listar(){
		$sql = "SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor, p.nombre as proveedor, u.idusuario, u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra, i.idingreso, i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor= p.idpersona INNER JOIN usuario u ON i.idusuario = u.idusuario";
		return ejecutarConsulta($sql);


	}
}
 ?>
