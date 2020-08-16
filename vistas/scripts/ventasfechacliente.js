var table;

function init(){
	listar();
	// Cargamos los items al select idcliente

};



// listar con data Table
function listar(){

	var fecha_inicio=$("#fecha_inicio").val();
	var fecha_fin=$("#fecha_fin").val();
	var idcliente=$("#idcliente").val();


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
			url:'../ajax/consultas.php?opcion=ventasfechacliente',
			data:{fecha_inicio: fecha_inicio, fecha_fin: fecha_fin, idcliente: idcliente},
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




init();