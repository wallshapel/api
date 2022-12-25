<?php 
	namespace App\Models\ReglasPropias;
	use App\Models\ClienteModel;
	use App\Models\CuentaModel;
	use App\Models\TipoTransaccionModel;
	use App\Models\RolModel;
	class ReglasPropias {		
		public function cliente_valido(int $id): bool {  // Este método devuelve un booleano.
			$modelo = new ClienteModel();
			$cliente = $modelo->find($id);
			return $cliente == null ? false : true;
		}
		public function cuenta_valida(int $id): bool {
			$modelo = new CuentaModel();
			$cuenta = $modelo->find($id);
			return $cuenta == null ? false : true;
		}
		public function tipo_transaccion_valida(int $id): bool {
			$modelo = new TipoTransaccionModel();
			$tipo_transaccion = $modelo->find($id);
			return $tipo_transaccion == null ? false : true;	
		}
		public function rol_valido(int $id): bool {
			$modelo = new RolModel();
			$rol = $modelo->find($id);
			return $rol == null ? false : true;	
		}
	}
?>