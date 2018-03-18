<script language="JavaScript">

	function validarImagenDescripcion(){
		// Vamos a validar la imagen
		var fileSize = $('#billing_imagen')[0].files[0].size;
		//console.log(fileSize);				// 1MB -> 1048576 bytes
		var siezekiloByte = parseInt(fileSize / 1048576);
		//console.log(siezekiloByte);	
		if (siezekiloByte >  $('#billing_imagen').attr('size')) {
			alert("La imagen de demasiado grande, tiene que ser menor de 2MB");
			return false;
		}
		
		var comilla = /'/;
		var descripcion = document.getElementById('billing_descripcion').value;
		if (comilla.test(descripcion)){
			alert("La descripción no puede contener comillas simples(')");
			return false;
		}
		return true;
	}

		
</script>