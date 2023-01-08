<?php 
	function verificarPass($textoPlano, $hash): bool {
		return password_verify($textoPlano, $hash);  // Devuelve un booleano.
	}
?>