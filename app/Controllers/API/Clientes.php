<?php 
    namespace App\Controllers\API;
    use App\Models\ClienteModel;
    use CodeIgniter\RESTful\ResourceController;
    class Clientes extends ResourceController {
        public function __construct() {
            $this->model = $this->setModel(new ClienteModel());
            helper('validar_rol');
        }
        public function index() {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                $clientes = $this->model->findAll();
                return $this->respond($clientes);    
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');    
            }            
        }
        public function editar($id = null) {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $cliente = $this->model->find($id);
                if ($cliente == null)  
                    return $this->failNotFound('No se ha encontrado un cliente con el Id = '. $id);
                return $this->respond($cliente);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function crear() {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                $cliente = $this->request->getJSON();
                if ($this->model->insert($cliente))
                    return $this->respondCreated($cliente);
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
                $clienteVerificado = $this->model->find($id);
                if ($clienteVerificado == null)  
                    return $this->failNotFound('No se ha encontrado un cliente con el Id = '. $id);
                $cliente = $this->request->getJSON();  // Obtenemos los nuevos datos del cliente.
                if ($this->model->update($id, $cliente)) { // Actualizamos los datos del cliente y preguntamos si todo ha ido ok. 
                    $cliente->id = $id;
                    return $this->respondUpdated($cliente);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
                return $this->respond($cliente);
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
                $cliente = $this->model->find($id);
                if ($cliente == null)  
                    return $this->failNotFound('No se ha encontrado un cliente con el Id = '. $id);
                if ($this->model->delete($id))  
                    return $this->respondDeleted($cliente);
                else
                    return $this->failServerError('No se pudo eliminar el registro.');
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
    }
?>