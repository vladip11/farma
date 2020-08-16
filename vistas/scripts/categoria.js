var table;

function init(){

	mostrarForm(false);
	listar();

};

// LIMPIAR LAS CAJITAS 
function limpiar(){
	// document.getElementById('idcategoria').value = " ";
	// document.getElementById('nombre').value=" ";

	// USANDO JQUERY
	$("#categoria").val("");
	$("#nombre").val("");
	$("#descripcion").val("");

};

function mostrarForm(flag){

	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		// prop  es para la propiedad
		$("#btn-guardar").prop("disabled",false);
		$("btn-editar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btn-editar").hide();

	}

}

// cancelar FOrm
function cancelarForm(){
	limpiar();
	mostrarForm(false);
}


// listar con data Table
function listar(){
	table= $("#tbllistado").dataTable({
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
			url:'../ajax/categoria.php?opcion=listar',
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
	
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url:"../ajax/categoria.php?opcion=insertar",
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

function mostrar(idcategoria){
	$("#btn-guardar").hide();
	$("#btn-editar").show();
			                                                                // obtenemos \|/ el resultado de json_encode
	$.post("../ajax/categoria.php?opcion=mostrar",{idcategoria : idcategoria}, function(data, status)
	{

		data = JSON.parse(data);
		mostrarForm(true);

		$("#nombre").val(data.nombre);
		$("#descripcion").val(data.descripcion);
		$("#idcategoria").val(data.idcategoria);


	});
}

function editarForm(e){

	e.preventDefault();
	$("#btn-editar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url:"../ajax/categoria.php?opcion=editar",
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

function desactivar(idcategoria){
	bootbox.confirm("Esta seguro de desactivar la categoria", function(result){
		if(result){
			$.post("../ajax/categoria.php?opcion=desactivar", {idcategoria: idcategoria}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}

function activar(idcategoria){
	bootbox.confirm("Esta seguro de activar la categoria", function(result){
		if(result){
			$.post("../ajax/categoria.php?opcion=activar", {idcategoria: idcategoria}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}


init();