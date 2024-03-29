<?php 
    namespace App\Controllers\API;
    use App\Models\TransaccionModel;
    use App\Models\CuentaModel;
    use App\Models\ClienteModel;
    use CodeIgniter\RESTful\ResourceController;
    class Transaccion extends ResourceController {
        public function __construct() {
            $this->model = $this->setModel(new TransaccionModel());
            helper('validar_rol');
        }
        public function index() {
            if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                return $this->failServerError('Acceso denegado.');
            try {
                $transacciones = $this->model->findAll();
                return $this->respond($transacciones);       
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
                $transaccion = $this->model->find($id);
                if ($transaccion == null)  
                    return $this->failNotFound('No se ha encontrado una transacción con el Id = '. $id);
                return $this->respond($transaccion);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function cliente($id = null) {
            try {
                if (!validarRol(['Administrador', 'Cliente'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                $modeloCliente = new ClienteModel();
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $cliente = $modeloCliente->find($id);
                if ($cliente == null)  
                    return $this->failNotFound('No se ha encontrado un cliente con el Id = '. $id);
                $transacciones = $this->model->transaccionesXCliente($id);
                return $this->respond($transacciones);
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
        public function crear() {
            try {
                if (!validarRol(['Administrador', 'Cliente'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                $transaccion = $this->request->getJSON();
                if ($this->model->insert($transaccion)) {
                    $transaccion->id = $this->model->insertID();  // insertID() devuelve el id recien ingresado a la base de datos.
                    $transaccion->resultado = $this->actualizarFondoCuenta($transaccion->tipo_transaccion_id, $transaccion->monto, $transaccion->cuenta_id);
                    return $this->respondCreated($transaccion);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
            } catch (\Exception $e) {
                return $this->failServerError($e);
            }
        }
        private function actualizarFondoCuenta($tipoTransaccionId, $monto, $cuentaId) {
            $modeloCuenta = new CuentaModel();
            $cuenta = $modeloCuenta->find($cuentaId);
            switch ($tipoTransaccionId) {
                case 1:
                    $cuenta['fondo'] += $monto;
                    break;
                case 2:
                    $cuenta['fondo'] -= $monto;
                    break;
            }
            if ($modeloCuenta->update($cuentaId, $cuenta)) 
                return array('TransaccionExitosa' => true, 'fondoActual' => $cuenta['fondo']);
            else
                return array('TransaccionFallida' => false, 'fondoActual' => $cuenta['fondo']);
        }
        public function actualizar($id = null) {
            try {
                if (!validarRol(['Administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
                    return $this->failServerError('Acceso denegado.');
                if ($id == null) 
                    return $this->failValidationError('Id no válido.');
                $transaccionVerificada = $this->model->find($id);
                if ($transaccionVerificada == null)  
                    return $this->failNotFound('No se ha encontrado una transacción con el Id = '. $id);
                $transaccion = $this->request->getJSON();  
                if ($this->model->update($id, $transaccion)) { 
                    $transaccion->id = $id;
                    return $this->respondUpdated($transaccion);
                } else
                    return $this->failValidationError($this->model->validation->listErrors());
                return $this->respond($transaccion);
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
                $transaccion = $this->model->find($id);
                if ($transaccion == null)  
                    return $this->failNotFound('No se ha encontrado una transacción con el Id = '. $id);
                if ($this->model->delete($id))  
                    return $this->respondDeleted($transaccion);
                else
                    return $this->failServerError('No se pudo eliminar el registro.');
            } catch (\Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }
    }
?>