<?php 
	namespace App\Models;
	use CodeIgniter\Model;
	class UsuarioModel extends Model {
		protected $table 			= 'usuario';
		protected $primaryKey 		= 'id';
		protected $returnType 		= 'array';
		protected $allowedFields	= ['nombre', 'usuario', 'pass', 'rol_id'];
		protected $useTimestamps	= true;
		protected $createdField		= 'created_at';
		protected $updatedField		= 'updated_at';
		protected $validationRules 	= [
			'nombre'	=> 'required|string|min_length[3]|max_length[65]',
			'usuario'	=> 'required|alpha_numeric_space|min_length[8]|max_length[10]',
			'pass'		=> 'required|string',
			'rol_id'	=> 'required|integer|rol_valido'
		];
		protected $validationMessages = [
			'rol_id'	=> [
				'rol_valido'	=> 'El Id del rol no existe.'
			]
		];
		protected $skipValidation = false;
	}
?>