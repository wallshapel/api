<?php namespace App\Models;
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
		public function transaccionesXCliente($id = null) {  // Busca las transacciones del cliente relacionando las tablas: cliente, cuenta, transacción y tipo_transaccion.
	        $builder = $this->db->table($this->table);
	        $builder->select('cuenta.id As NumeroCuenta, cliente.nombre, cliente.apellido');
	        $builder->select('tipo_transaccion.descripcion AS Tipo, transaccion.monto, transaccion.created_at AS FechaTransaccion');
	        $builder->join('cuenta',            'transaccion.cuenta_id  = cuenta.id');
	        $builder->join('tipo_transaccion',  'transaccion.tipo_transaccion_id  = tipo_transaccion.id');
	        $builder->join('cliente',           'cuenta.cliente_id      = cliente.id');
	        $builder->where('cliente_id', $id);
	        $query = $builder->get();
	        return $query->getResult();
	    }  
	}
?>