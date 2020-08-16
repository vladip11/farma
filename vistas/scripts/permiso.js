var table;

function init(){

	mostrarForm(false);
	listar();

};


function mostrarForm(flag){

	// limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		// prop  es para la propiedad
		$("#btn-guardar").prop("disabled",false);
		$("#btn-agregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btn-agregar").hide();

	}

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
			url:'../ajax/permiso.php?opcion=listar',
			type : "get",
			dataType: "json",
			error: function(e){
				console.log(e.responseText);
			}

		},

		"bDestroy": true,
		"iDisplayLength": 7, //paginacion
		"order": [[0, "desc"]]  //ordenar los datos   columna 0 y de que forma


	}).DataTable();
}


init();