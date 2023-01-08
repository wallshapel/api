<?php 
    namespace App\Controllers\API;
    use App\Models\TipoTransaccionModel;
    use CodeIgniter\RESTful\ResourceController;
    class TipoTransaccion extends ResourceController {
        public function __construct() {
            $this->model = $this->setModel(new TipoTransaccionModel());
        }
        public function index() {
            $tipoTransacciones = $this->model->findAll();
            return $this->respond($tipoTransacciones);
        }
        public function editar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $tipoTransaccion = $this->model->find($id);
                if ($tipoTransaccion == null)  
                    return $this->failNotFound('No se ha encontrado un tipo de transacción con el Id = '. $id);
                return $this->respond($tipoTransaccion);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function crear() {
            try {
                $tipoTransaccion = $this->request->getJSON();
                if ($this->model->insert($tipoTransaccion))
                    return $this->respondCreated($tipoTransaccion);
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
                $tipoTransaccionVerificado = $this->model->find($id);
                if ($tipoTransaccionVerificado == null)  
                    return $this->failNotFound('No se ha encontrado un tipo de transacción con el Id = '. $id);
                $tipoTransaccion = $this->request->getJSON(); 
                if ($this->model->update($id, $tipoTransaccion)) {
                    $tipoTransaccion->id = $id;
                    return $this->respondUpdated($tipoTransaccion);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
                return $this->respond($tipoTransaccion);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function eliminar($id = null) {
            try {
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $tipoTransaccion = $this->model->find($id);
                if ($tipoTransaccion == null)  
                    return $this->failNotFound('No se ha encontrado un tipo de transacción con el Id = '. $id);
                if ($this->model->delete($id))  
                    return $this->respondDeleted($tipoTransaccion);
                else
                    return $this->failServerError('No se pudo eliminar el registro.');
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
    }
?>