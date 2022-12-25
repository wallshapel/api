<?php namespace App\Controllers\API;
    use App\Models\RolModel;
    use CodeIgniter\RESTful\ResourceController;
    class Roles extends ResourceController {
        public function __construct() {
            $this->model = $this->setModel(new RolModel());
        }
        public function index() {
            $roles = $this->model->findAll();
            return $this->respond($roles);
        }
        public function crear() {
            try {
                $rol = $this->request->getJSON();
                if ($this->model->insert($rol))
                    return $this->respondCreated($rol);
                else
                    return $this->failValidationError($this->model->validation->listErrors());
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function editar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $rol = $this->model->find($id);
                if ($rol == null)  
                    return $this->failNotFound('No se ha encontrado un rol con el Id = '. $id);
                return $this->respond($rol);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function actualizar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $clienteVerificado = $this->model->find($id);
                if ($clienteVerificado == null)  
                    return $this->failNotFound('No se ha encontrado un rol con el Id = '. $id);
                $rol = $this->request->getJSON();  // Obtenemos los nuevos datos del rol.
                if ($this->model->update($id, $rol)) { // Actualizamos los datos del rol y preguntamos si todo ha ido ok. 
                    $rol->id = $id;
                    return $this->respondUpdated($rol);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
                return $this->respond($rol);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function eliminar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $rol = $this->model->find($id);
                if ($rol == null)  
                    return $this->failNotFound('No se ha encontrado un rol con el Id = '. $id);
                if ($this->model->delete($id))  
                    return $this->respondDeleted($rol);
                else
                    return $this->failServerError('No se pudo eliminar el registro.');
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
    }
?>