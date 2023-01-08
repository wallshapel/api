<?php 
    namespace App\Controllers\API;
    use App\Models\CuentaModel;
    use CodeIgniter\RESTful\ResourceController;
    class Cuentas extends ResourceController {
        public function __construct() {
            $this->model = $this->setModel(new CuentaModel());
        }
        public function index() {
            $cuentas = $this->model->findAll();
            return $this->respond($cuentas);
        }
        public function editar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $cuenta = $this->model->find($id);
                if ($cuenta == null)  
                    return $this->failNotFound('No se ha encontrado una cuenta con el Id = '. $id);
                return $this->respond($cuenta);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function crear() {
            try {
                $cuenta = $this->request->getJSON();
                if ($this->model->insert($cuenta))
                    return $this->respondCreated($cuenta);
                else
                    return $this->failValidationError($this->model->validation->listErrors());
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function actualizar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $cuentaVerificada = $this->model->find($id);
                if ($cuentaVerificada == null)  
                    return $this->failNotFound('No se ha encontrado una cuenta con el Id = '. $id);
                $cuenta = $this->request->getJSON();  
                if ($this->model->update($id, $cuenta)) { 
                    $cuenta->id = $id;
                    return $this->respondUpdated($cuenta);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
                return $this->respond($cuenta);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function eliminar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $cuenta = $this->model->find($id);
                if ($cuenta == null)  
                    return $this->failNotFound('No se ha encontrado una cuenta con el Id = '. $id);
                if ($this->model->delete($id))  
                    return $this->respondDeleted($cuenta);
                else
                    return $this->failServerError('No se pudo eliminar el registro.');
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
    }
?>