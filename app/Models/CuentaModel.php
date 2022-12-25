<?php namespace App\Models;
	use CodeIgniter\Model;
	class CuentaModel extends Model {
		protected $table 			= 'cuenta';
		protected $primaryKey 		= 'id';
		protected $returnType 		= 'array';
		protected $allowedFields	= ['moneda', 'fondo', 'cliente_id'];
		protected $useTimestamps	= true;
		protected $createdField		= 'created_at';
		protected $updatedField		= 'updated_at';
		protected $validationRules 	= [
			'moneda'		=> 'required|alpha_space|min_length[2]|max_length[3]',
			'fondo'			=> 'required|numeric|min_length[1]',
			'cliente_id'	=> 'required|integer|cliente_valido|min_length[1]'
		];
		protected $validationMessages = [
			'cliente_id'	=> [
				'cliente_valido' => 'El Id del cliente no existe.'
			]
		];
		protected $skipValidation = false;
	}
?>