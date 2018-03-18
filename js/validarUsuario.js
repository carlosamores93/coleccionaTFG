<script language="JavaScript">

	var letrasConAcentos = /^[A-Za-záéíóúÁÉÍÓÚüÜñÑ' ']+$/;
	var alfanumerico = /^[A-Za-z0-9\_\-\.]+$/;

	function validarUsuario(){

		var tipo = document.getElementById('billing_tipo').value;
		if (!(tipo == "Profesor" || tipo == "Alumno")){
			alert("El tipo de usuario no es correcto.");
			return false;
		}

		var nombre = document.getElementById('billing_first_name').value;
		if (!letrasConAcentos.test(nombre)){
			alert("El nombre tiene caracteres no validos.");
			return false;
		}

		var apellidos = document.getElementById('billing_last_name').value;
		if (!letrasConAcentos.test(apellidos)){
			alert("Los apellidos tienen caracteres no validos.");
			return false;
		}

		var usuario = document.getElementById('billing_user').value;
		if (!alfanumerico.test(usuario)){
			alert("El usuario puede tener caracteres alfanuméricos y/o '.', '_','-'");
			return false;
		}

		var pass1 = document.getElementById('billing_pass1').value;
		var pass2 = document.getElementById('billing_pass2').value;
		if (pass1 != pass2){
			alert("Las contraseñas no coinciden.");
			return false;
		}
		if (!alfanumerico.test(pass1)){
			alert("La contraseña puede tener caracteres alfanuméricos y/o '.', '_','-'");
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