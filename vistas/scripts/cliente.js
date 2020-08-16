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
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#correo").val("");
	$("#idpersona").val("");

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
			url:'../ajax/persona.php?opcion=listarClientes',
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
		url:"../ajax/persona.php?opcion=insertar",
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

function mostrar(idpersona){
	$("#btn-editar").show();
	$("#btn-guardar").hide();
		                                                                    // obtenemos \|/ el resultado de json_encode
	$.post("../ajax/persona.php?opcion=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);
		
		mostrarForm(true);

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#idpersona").val(data.idpersona);



	});
}

function editarForm(e){

	e.preventDefault();
	// $("#btn-editar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	

	$.ajax({
		url:"../ajax/persona.php?opcion=editar",
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



//function ELIMINAR una PERSONA

function eliminar(idpersona){
	bootbox.confirm("Esta seguro de eliminar el Cliente", function(result){
		if(result){
			$.post("../ajax/persona.php?opcion=eliminar", {idpersona: idpersona}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}



init();