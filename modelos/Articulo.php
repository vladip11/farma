<?php 
require '../config/conexion.php';

// REALIZAMOS LAS CONSULTAS DE ARTICULOS TOOOOODOOOO EL ---CRUD----

Class Articulo{
	public function __construct(){}

	public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen,$ubicacion){
		$sql = "INSERT INTO articulo(idcategoria, codigo, nombre, stock, descripcion, imagen, ubicacion, condicion) VALUES($idcategoria, '$codigo','$nombre','$stock', '$descripcion', '$imagen', '$ubicacion', '1')";
		return ejecutarConsulta($sql);
	}

	public function editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){

		$sql = "UPDATE articulo SET idcategoria = '$idcategoria', codigo='$codigo', nombre = '$nombre', stock='$stock', descripcion= '$descripcion', imagen='$imagen' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idarticulo){
		$sql = "UPDATE articulo SET condicion= '0' WHERE idarticulo = '$idarticulo'";
		return ejecutarConsulta($sql);
	}


	public function activar($idarticulo){
		$sql = "UPDATE articulo SET condicion= '1' WHERE idarticulo = '$idarticulo'";
		return ejecutarConsulta($sql);
	}


	public function mostrar($idarticulo){
		$sql = "SELECT * FROM articulo WHERE idarticulo = '$idarticulo'";
		return ejcutarConsultaSimpleFila($sql);

	}

	public function listar(){
		$sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre, a.stock, a.descripcion, a.imagen,a.ubicacion, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria";
		return ejecutarConsulta($sql);


	}

	public function articuloXcategoria(){
		$sql = "SELECT categoria.idcategoria, categoria.nombre as categoria FROM categoria WHERE categoria.condicion = '1' ";
		return ejecutarConsulta($sql);
	}

	public function listarActivos(){
		$sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre, a.stock, a.descripcion, a.imagen, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria WHERE a.condicion = '1'" ;
		return ejecutarConsulta($sql);


	}
	public function listarActivosVenta(){
		$sql = "SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalles_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);


	}



}

 ?>