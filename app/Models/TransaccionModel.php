<?php 
	namespace App\Models;
	use CodeIgniter\Model;
	class TransaccionModel extends Model {
		protected $table 			= 'transaccion';
		protected $primaryKey 		= 'id';
		protected $returnType 		= 'array';
		protected $allowedFields	= ['cuenta_id', 'tipo_transaccion_id', 'monto'];
		protected $useTimestamps	= true;
		protected $createdField		= 'created_at';
		protected $updatedField		= 'updated_at';
		protected $validationRules 	= [
			'cuenta_id' 			=> 	'required|integer|min_length[1]|cuenta_valida',
			'tipo_transaccion_id'	=>	'required|integer|min_length[1]|tipo_transaccion_valida',
			'monto'					=>	'required|numeric|min_length[1]'
		];
		protected $validationMessages = [
			'cuenta_id'				=> [
				'cuenta_valida' 			=> 'El Id de la cuenta no existe.'
			],
			'tipo_transaccion_id' 	=> [
				'tipo_transaccion_valida'	=> 'El Id del tipo de transacción no existe.'
			]
		];
		protected $skipValidation = false;
		public function transaccionesXCliente($id = null) {  // Busca las transacciones de un cliente por su id.
	        $builder = $this->db->query('
				SELECT 
				    cuenta.id AS NumeroCuenta, cliente.nombre, cliente.apellido, tipo_transaccion.descripcion AS Tipo, transaccion.monto, 
				    transaccion.created_at AS FechaTransaccion
				FROM
				    banco.tipo_transaccion
				JOIN banco.transaccion ON
				    tipo_transaccion.id = transaccion.tipo_transaccion_id
				JOIN banco.cuenta ON
				    transaccion.cuenta_id = cuenta.id
				JOIN banco.cliente ON
				    cuenta.cliente_id = cliente.id
				WHERE
				cuenta.cliente_id = '. $id);
			$query = $builder->getResultArray();
	        return $query;
	    }  
	}
?>