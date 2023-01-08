<?php
    namespace App\Controllers;
    use CodeIgniter\API\ResponseTrait;  // Necesario para envío de respuestas para las API.
    use App\Models\UsuarioModel;
    use Firebase\JWT\JWT;  // Necesario para implementar tokens JWT.
    use Config\Services;  // Necesario para la llave secreta del token.
    class Autenticacion extends BaseController {
        use ResponseTrait;  // Necesario para envío de respuestas para las API.
        public function __construct() {
            helper('seguridad_pass');  // No es necesario colocar el nombre completo del archivo helper. Necesario para llamar a las funciones helpers.
        }
        public function login() {
            try {
                $usuario = $_POST['usuario'];
                $pass = $_POST['pass'];
                $usuarioModel = new UsuarioModel();                
                $validarUsuario = $usuarioModel->where('usuario', $usuario)->first();
                if ($validarUsuario == null)
                    return $this->failNotFound('Usuario no encontrado.');
                if (verificarPass($pass, $validarUsuario['pass'])) {
                    $token = $this->generarToken($validarUsuario);
                    return $this->respond(['Token' => $token], 201);
                } else
                    return  $this->failValidationError('Contraseña incorrecta.');
            } catch (\Exception $e) {
                //return $this->failServerError('Ha ocurrido un error en el servidor.');
                return $this->failServerError($e);
            }
        }
        protected function generarToken($usuario) {
            $llave = $llave = getenv('JWT_SECRETO');
            $tiempo = time(); // Devuelve la fecha y la hora actual en un número entero.
            $payload = [
                'aud'   => base_url(),
                'iat'   => $tiempo,  // Fecha de creación del token.
                'exp'   => $tiempo + 3600,  // Fecha de creación del token más 3600 segundos.
                'data'  => [
                    'nombre'    => $usuario['nombre'],
                    'usuario'   => $usuario['usuario'],
                    'rol'       => $usuario['rol_id']
                ]
            ];
            $token = JWT::encode($payload, $llave, 'HS256');
            return $token;
        }
    }
?>