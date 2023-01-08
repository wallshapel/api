<?php namespace App\Models;
	use CodeIgniter\Model;
	class TipoTransaccionModel extends Model {
		protected $table 			= 'tipo_transaccion';
		protected $primaryKey 		= 'id';
		protected $returnType 		= 'array';
		protected $allowedFields	= ['descripcion'];
		protected $useTimestamps	= true;
		protected $createdField		= 'created_at';
		protected $updatedField		= 'updated_at';
		protected $validationRules 	= [
			'descripcion' => 'required|string|min_length[4]|max_length[65]'
		];
		protected $skipValidation = false;
	}
?>