<script language="JavaScript">

	function validarDescripcion(){
		var comilla = /'/;
		var descripcion = document.getElementById('billing_descripcion').value;
		if (comilla.test(descripcion)){
			alert("La descripción no puede contener comillas simples(')");
			return false;
		}
		return true;
	}

		
</script>