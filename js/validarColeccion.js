<script language="JavaScript">

	var letrasConAcentos = /^[A-Za-z0-9áéíóúÁÉÍÓÚüÜñÑ' ']+$/;
	var alfanumerico = /^[A-Za-z0-9\_\-\.]+$/;

	function validarColeccion(){
	
		
		var nombreColeccion = document.getElementById('billing_nombre_coleccion').value;
		if (!alfanumerico.test(nombreColeccion)){
			alert("El nombre de la coleccion puede tener caracteres alfanuméricos y/o '.', '_','-'");
			return false;
		}
		var nombreColeccionCorrecto = document.getElementById('billing_nombre2_coleccion').value;
		if (!letrasConAcentos.test(nombreColeccionCorrecto)){
			alert("El nombre correcto de la coleccion tiene caracteres no validos.");
			return false;
		}
		var temaColeccion = document.getElementById('billing_tema_coleccion').value;
		if (!letrasConAcentos.test(temaColeccion)){
			alert("El tema tiene caracteres no validos.");
			return false;
		}
		var claveColeccion = document.getElementById('billing_tema').value;
		if (!alfanumerico.test(claveColeccion)){
			alert("La clave de la coleccion puede tener caracteres alfanuméricos y/o '.', '_','-'");
			return false;
		}
		
		// Vamos a validar la imagen
		var fileSize = $('#billing_imagen')[0].files[0].size;
		//console.log(fileSize);				// 1MB -> 1048576 bytes
		var siezekiloByte = parseInt(fileSize / 1048576);
		//console.log(siezekiloByte);	
		if (siezekiloByte >  $('#billing_imagen').attr('size')) {
			alert("La imagen de demasiado grande, tiene que ser menor de 2MB");
			return false;
		}
		
		
		return true;
	}
	
</script>