$("#frmAcceso").on('submit', function(e){
	e.preventDefault();
	loginAcceso=$("#loginAcceso").val();
	passwordAcceso = $("#passwordAcceso").val();
	
	$.post("../ajax/usuario.php?opcion=verificar",
		{"loginAcceso":loginAcceso,"passwordAcceso":passwordAcceso},
	 function(data){
		if(data != null)
		{
			$(location).attr("href", "escritorio.php");
		}else{
			bootbox.alert("Usuario y/o Password icorrectos");
		}
	});
})