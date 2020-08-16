var table;

function init(){

	mostrarForm(false);
	listar();

	$("#imagenmuestra").hide();

};

//LIMPIAR LAS CAJITAS 
function limpiar(){
	// document.getElementById('idcategoria').value = " ";
	// document.getElementById('nombre').value=" ";

	// USANDO JQUERY
	$("#idarticulo").val("");
	$("#codigo").val("");
	$("#nombre").val("");
	$("#stock").val("");
	$("#descripcion").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#print").hide();
	
	
};

function mostrarForm(flag){

	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();

		// prop  es para la propiedad
		$("#btn-guardar").prop("disabled",false);
		$("#btn-editar").hide();
		
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btn-editar").hide();

	}

}

//cancelar FOrm
function cancelarForm(){
	limpiar();
	mostrarForm(false);
}


// listar con data Table
function listar(){
	table= $("#tbllistado-articulo").dataTable({
		"aProcessing": true, //activamos el procesamiento del datatable
		"aServerSide":true, //Paginacion y filtrado realizados por el servidor 
		dom:'Bfrtip', //Definimos los elementos del control de tabla
		
		buttons:[
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],

		//ajax 

		"ajax":{
			url:'../ajax/articulo.php?opcion=listar',
			type : "get",
			dataType: "json",
			error: function(e){
				console.log(e.responseText);
			}

		},

		"bDestroy": true,
		"iDisplayLength": 5, //paginacion
		"order": [[0, "desc"]]  //ordenar los datos   columna 0 y de que forma


	}).DataTable();
}


function insertarForm(e){

	e.preventDefault();
	$("#btn-guardar").prop("disabled", true);
	
	var formData = new FormData($("#formulario-articulo")[0]);

	$.ajax({
		url:"../ajax/articulo.php?opcion=insertar",
		type:"POST",
		data: formData,
		contentType: false, 
		processData: false,

		success:function(datos){
			bootbox.alert(datos);
			mostrarForm(false);
			table.ajax.reload();
		} 
	});
	limpiar();
}

function mostrar(idarticulo){
	$("#btn-editar").show();
	$("#btn-guardar").hide();
		                                                          		// obtenemos \|/ el resultado de json_encode
	$.post("../ajax/articulo.php?opcion=mostrar",{idarticulo : idarticulo}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarForm(true);

		$("#idcategoria").val(data.idcategoria);

		// $("#idcategoria").selectpicker('refresh');

		$("#codigo").val(data.codigo);
		$("#nombre").val(data.nombre);
		$("#stock").val(data.stock);
		$("#descripcion").val(data.descripcion);
		$("#imagenmuestra").show();
		$("imagenmuestra").attr("src", "../files/articulos/"+data.imagen);
		$("imagenactual").val(data.imagen);
		$("#idarticulo").val(data.idarticulo);
		generarbarcode();


	});
}

function editarForm(e){

	e.preventDefault();
	
	var formData = new FormData($("#formulario-articulo")[0]);

	$.ajax({
		url:"../ajax/articulo.php?opcion=editar",
		type:"POST",
		data: formData,
		contentType: false, 
		processData: false,

		success:function(datos){
			bootbox.alert(datos);
			mostrarForm(false);
			table.ajax.reload();
		} 
	});

	limpiar();

}



//function desactivar una categoria

function desactivar(idarticulo){
	bootbox.confirm("Esta seguro de desactivar el articulo", function(result){
		if(result){
			$.post("../ajax/articulo.php?opcion=desactivar", {idarticulo: idarticulo}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}

function activar(idarticulo){
	bootbox.confirm("Esta seguro de activar el articulo", function(result){
		if(result){
			$.post("../ajax/articulo.php?opcion=activar", {idarticulo: idarticulo}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}

// GENERAR EL CODIGO DE BARRAS 

function generarbarcode(){
	codigo = $('#codigo').val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

// BOTON IMPRIMIR 

function imprimir(){
	$("#print").printArea();
}



init();