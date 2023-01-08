<?php 
    namespace App\Filters;
    use CodeIgniter\Filters\FilterInterface;
    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\ResponseInterface;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use \Firebase\JWT\ExpiredException;  // Necesario anteponer el \
    use Config\Services;
    class AutFiltro implements FilterInterface {
        public function before(RequestInterface $request, $arguments = null) {
            $llave = getenv('JWT_SECRETO');
            $cabeza = $request->getHeader('Authorization');
            $token = null;             
            if (!empty($cabeza)) {  // Extraemos el token de la cabecera.
                if (preg_match('/Bearer\s(\S+)/', $cabeza, $coincidencias)) 
                    $token = $coincidencias[1];
            } 
            if (is_null($token) || empty($token))
                return Services::response()->setJSON(['Validación' => 'Token requerido.'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            try {
                $decodificado = JWT::decode($token, new Key($llave, 'HS256'));
            } catch (ExpiredException $e) {   
                return Services::response()->setJSON(['Validación' => 'Token expirado.'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);     
            } catch (\Exception $e) {                  
                return Services::response()->setJSON(['Error' => 'Ha ocurrido un error en el servidor.'])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);  
            }
        }
        public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {

        }
    }
?>