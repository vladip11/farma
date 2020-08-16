var table;

function init(){

	mostrarForm(false);
	listar();

	$("#imagenmuestra").hide();

	// MOSTRAMOS PERMISOS 
	$.post("../ajax/usuario.php?opcion=permiso&id=", function(r){

			// la respuesta almacenada en R se pondra al id permisos 
		$("#permisos").html(r);
	})

};

//LIMPIAR LAS CAJITAS 
function limpiar(){
	// document.getElementById('idcategoria').value = " ";
	// document.getElementById('nombre').value=" ";

	// USANDO JQUERY

	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#password").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#idusario").val("");
	
	
};

function mostrarForm(flag){

	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();

		// prop  es para la propiedad
		$("#btn-guardar").prop("disabled",false);
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();

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
			url:'../ajax/usuario.php?opcion=listar',
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
		url:"../ajax/usuario.php?opcion=insertar",
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

function mostrar(idusuario){
		                                                          		// obtenemos \|/ el resultado de json_encode
	$.post("../ajax/usuario.php?opcion=mostrar", {idusuario : idusuario}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarForm(true);

		$("#idusario").val(data.idusario);

		// $("#idcategoria").selectpicker('refresh');

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#cargo").val(data.cargo);
		$("#login").val(data.login);
		$("#password").val(data.password);

		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		


	});
	$.post("../ajax/usuario.php?opcion=permiso&id="+idusuario, function(r){

			// la respuesta almacenada en R se pondra al id permisos 
		$("#permisos").html(r);
	})
}

function editarForm(e){

	e.preventDefault();
	
	var formData = new FormData($("#formulario-articulo")[0]);

	$.ajax({
		url:"../ajax/usuario.php?opcion=editar",
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

function desactivar(idusuario){
	bootbox.confirm("Esta seguro de desactivar el usuario", function(result){
		if(result){
			$.post("../ajax/usuario.php?opcion=desactivar", {idusuario: idusuario}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}

function activar(idusuario){
	bootbox.confirm("Esta seguro de activar el usuario", function(result){
		if(result){
			$.post("../ajax/usuario.php?opcion=activar", {idusuario: idusuario}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}



init();