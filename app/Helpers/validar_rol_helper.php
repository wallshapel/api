<?php
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use App\Models\RolModel;
	function validarRol($roles, $cabeza): bool {
		if ($roles == null)
       		return false;
		$llave = getenv('JWT_SECRETO');
		$token = null;  
        preg_match('/Bearer\s(\S+)/', $cabeza, $coincidencias);  // Extrae el token de la cabecera. 
       	$token = $coincidencias[1];
       	$token = JWT::decode($token, new Key($llave, 'HS256'));
       	$modeloRol = new RolModel();
       	$rol = $modeloRol->find($token->data->rol);
       	if ($rol == null || (!in_array($rol['nombre'], $roles)))  // Verifica si el rol del token coincide con el rol del usuario obtenido de la DB.
       		return false;
       	return true;
	}
?>