var table;

function init(){

	mostrarForm(false);
	listar();

	$.post("../ajax/ingreso.php?opcion=selectProveedor", function(r){
		$("#idproveedor").html(r);
		
	})


};

//LIMPIAR LAS CAJITAS 
function limpiar(){
	// document.getElementById('idcategoria').value = " ";
	// document.getElementById('nombre').value=" ";

	// USANDO JQUERY
	$("#idproveedor").val("");
	$("#proveedor").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#fecha_hora").val("");
	$("#impuesto").attr("src", "");
	
	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	
	
};

function mostrarForm(flag){

	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		// prop  es para la propiedad
		$("#btnGuardar").prop("disabled",false);
		listarArticulos();

		// $("#guardar").hide();
		// $("#btnGuardar").show();
		// $("#btnCancelar").show();
		// $("#btnAgregarArt").show();
		$("#btnEditar").hide();
		// $(".filas").remove();
		$("#btnAgregarArt").show();
		detalles=0;
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btnEditar").hide();
	}

}

//cancelar FOrm
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
			url:'../ajax/ingreso.php?opcion=listar',
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


// listar los Articulos que vamos a obtener desde el archivo ingreso php con data Table
function listarArticulos(){
	table= $("#tblarticulos").dataTable({
		"aProcessing": true, //activamos el procesamiento del datatable
		"aServerSide":true, //Paginacion y filtrado realizados por el servidor 
		dom:'Bfrtip', //Definimos los elementos del control de tabla
		
		buttons:[
			
		],
		//ajax 

		"ajax":{
			url:'../ajax/ingreso.php?opcion=listarArticulos',
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
	// $("#btn-guardar").prop("disabled", true);
	
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url:"../ajax/ingreso.php?opcion=insertar",
		type:"POST",
		data: formData,
		contentType: false, 
		processData: false,

		success:function(datos){
			bootbox.alert(datos);
			mostrarForm(false);
			listar();
		} 
	});
	limpiar();
}

function mostrar(idingreso){
		                                                          		// obtenemos \|/ el resultado de json_encode
	$.post("../ajax/ingreso.php?opcion=mostrar",{idingreso : idingreso}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarForm(true);

		$("#idproveedor").val(data.idproveedor);

		// $("#idproveedor").selectpicker('refresh');

		$("#tipo_comprobante").val(data.tipo_comprobante);

		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);

		// OCULTAR BOTONES
	
		$("#btnGuardar").hide();
		// $("btnCancelar").show();
		$("#btnAgregarArt").hide();


	});

	$.post("../ajax/ingreso.php?opcion=listarDetalle&id="+idingreso, function(r){
		$("#detalles").html(r);
	});
}

// function editarForm(e){

// 	e.preventDefault();
	
// 	var formData = new FormData($("#formulario-articulo")[0]);

// 	$.ajax({
// 		url:"../ajax/ingreso.php?opcion=editar",
// 		type:"POST",
// 		data: formData,
// 		contentType: false, 
// 		processData: false,

// 		success:function(datos){
// 			bootbox.alert(datos);
// 			mostrarForm(false);
// 			table.ajax.reload();
// 		} 
// 	});

// 	limpiar();

// }



//function desactivar una categoria

function anular(idingreso){
	bootbox.confirm("Esta seguro de Anular el ingreso", function(result){
		if(result){
			$.post("../ajax/ingreso.php?opcion=anular", {idingreso: idingreso}, function(e){
				bootbox.alert(e);
				table.ajax.reload();
			});
		}
	})
}

var impuesto=18;
var cont=0;
var detalles=0;

$("#btnGuardar").hide();
// Cuando el id tipo conprobante cambie de valor (change) llamamos a la funcion marcarImpuesto;
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto(){
	var tipo_comprobante = $("#tipo_comprobante option:selected").text();
	if(tipo_comprobante=='Factura') 
		$("#impuesto").val(impuesto);
	else
		$("#impuesto").val("0");
}

function agregarDetalle(idarticulo, articulo){
	var cantidad=1;
	var precio_compra=1;
	var precio_venta=1;

	if(idarticulo!=""){
		var subtotal=cantidad*precio_compra;
		var fila = '<tr class="filas" id="fila'+cont+'">'+
		'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
		'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
		'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
		'<td><input type="number" name="precio_compra[]" id="precio_compra[]" value="'+precio_compra+'"></td>'+
		'<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
		'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
		'<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
		'</tr>';
		cont++;
		detalles++;
		$("#detalles").append(fila);
		modificarSubtotales();	
	}else{
		alert("Error al ingresar el detalle Revizar los datos del articulo");
	}
}
	function modificarSubtotales(){
		// como son array se trabaja con el document.getElementsByName
		var cant = document.getElementsByName('cantidad[]');
		var prec = document.getElementsByName('precio_compra[]');
		var sub = document.getElementsByName('subtotal'); 

		for(var i = 0 ; i<cant.length; i++){
			var inpC=cant[i];
			var inpP=prec[i];
			var inpS=sub[i];

			inpS.value=inpC.value*inpP.value;
			document.getElementsByName("subtotal")[i].innerHTML=inpS.value;
		}
		calcularTotales();
	}

function calcularTotales(){
	var sub = document.getElementsByName("subtotal");
	var total=0.0;
	for(var i = 0 ; i<sub.length; i++){
		total +=document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("S/. "+total);
	$("#total_compra").val(total);
	evaluar();
}

function evaluar(){
	if(detalles>0){
		$("#btnGuardar").show();
	}
	else{
		$("btnGuardar").hide();
		cont=0;
	}
}
function eliminarDetalle(indice){
		 
	$("#fila" +indice).remove();
	calcularTotales();
	detalles =detalles-1;

}


init();