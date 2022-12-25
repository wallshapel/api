<?php 
	function verificarPass($textoPlano, $hash) {
		return password_verify($textoPlano, $hash);  // Devuelve un booleano.
	}
?>