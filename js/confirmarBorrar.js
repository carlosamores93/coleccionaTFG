<script language="JavaScript"> 
	function confirmarBorrarUsuario(){ 
		var agree=confirm("¿Realmente desea eliminar este usuario? ");
		if (agree){
			//alert("SIIIIIIIIII");
			return true;
			//window.location ="eliminarUsuario.php";
		}else{
			//alert("Cancelado");
			//window.location ="superVerProfesores.php";
			return false;
		}
	}

	function confirmarBorrarColeccion(){ 
			var agree=confirm("¿Realmente desea eliminar esta coleccion? ");
			if (agree){
				//alert("SIIIIIIIIII");
				return true;
			}else{
				//alert("Cancelado");
				return false;
			}
		}	
	
	function confirmarBorrarFicha(){ 
			var agree=confirm("¿Realmente desea eliminar esta ficha? ");
			if (agree){
				//alert("SIIIIIIIIII");
				return true;
			}else{
				//alert("Cancelado");
				return false;
			}
		}
	function confirmarBorrarPregunta(){ 
			var agree=confirm("¿Realmente desea eliminar esta pregunta? ");
			if (agree){
				//alert("SIIIIIIIIII");
				return true;
			}else{
				//alert("Cancelado");
				return false;
			}
		}
	
		
</script>