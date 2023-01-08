<?php 
    namespace App\Controllers\API;
    use App\Models\UsuarioModel;
    use CodeIgniter\RESTful\ResourceController;
    class Usuarios extends ResourceController {
        public function __construct() {
            $this->model = $this->setModel(new UsuarioModel());
            helper('validar_rol');
        }
        public function index() {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                $usuarios = $this->model->findAll();
                return $this->respond($usuarios);    
            } catch (\Exception $e) {      
                return $this->failServerError('Ha ocurrido un error en el servidor.');     
            }            
        }
        public function editar($id = null) {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $usuario = $this->model->find($id);
                if ($usuario == null)  
                    return $this->failNotFound('No se ha encontrado un usuario con el Id = '. $id);
                return $this->respond($usuario);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function crear() {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                $usuario = $this->request->getJSON();
                if ($this->model->insert($usuario))
                    return $this->respondCreated($usuario);
                else
                    return $this->failValidationError($this->model->validation->listErrors());
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }        
        public function actualizar($id = null) {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $cuentaVerificada = $this->model->find($id);
                if ($cuentaVerificada == null)  
                    return $this->failNotFound('No se ha encontrado un usuario con el Id = '. $id);
                $usuario = $this->request->getJSON();  
                if ($this->model->update($id, $usuario)) { 
                    $usuario->id = $id;
                    return $this->respondUpdated($usuario);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
                return $this->respond($usuario);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function eliminar($id = null) {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $usuario = $this->model->find($id);
                if ($usuario == null)  
                    return $this->failNotFound('No se ha encontrado un usuario con el Id = '. $id);
                if ($this->model->delete($id))  
                    return $this->respondDeleted($usuario);
                else
                    return $this->failServerError('No se pudo eliminar el registro.');
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
    }
?>