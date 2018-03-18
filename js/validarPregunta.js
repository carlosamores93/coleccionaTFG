<script language="JavaScript">

	function validarPreguntaRespuestas(){
		var comilla = /'/;
		var enunciado = document.getElementById('billing_enunciado').value;
		if (comilla.test(enunciado)){
			alert("La enunciado no puede contener comillas simples(')");
			return false;
		}
		var correcta = document.getElementById('billing_correcta').value;
		if (comilla.test(correcta)){
			alert("La respuesta no puede contener comillas simples(')");
			return false;
		}
		var incorrecta1 = document.getElementById('billing_incorrecta1').value;
		if (comilla.test(incorrecta1)){
			alert("La respuesta no puede contener comillas simples(')");
			return false;
		}
		var incorrecta2 = document.getElementById('billing_incorrecta2').value;
		if (comilla.test(incorrecta2)){
			alert("La respuesta no puede contener comillas simples(')");
			return false;
		}
		var incorrecta3 = document.getElementById('billing_incorrecta3').value;
		if (comilla.test(incorrecta3)){
			alert("La respuesta no puede contener comillas simples(')");
			return false;
		}
		return true;
	}

		
</script>