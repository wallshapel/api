<?php namespace App\Models;
	use CodeIgniter\Model;
	class ClienteModel extends Model {
		protected $table 			= 'cliente';
		protected $primaryKey 		= 'id';
		protected $returnType 		= 'array';
		protected $allowedFields	= ['nombre', 'apellido', 'telefono', 'correo'];
		protected $useTimestamps	= true;
		protected $createdField		= 'created_at';
		protected $updatedField		= 'updated_at';
		protected $validationRules 	= [
			'nombre'	=> 'required|string|min_length[3]|max_length[75]',
			'apellido'	=> 'required|string|min_length[3]|max_length[75]',
			'telefono'	=> 'required|string|min_length[10]|max_length[10]',
			'correo'	=> 'permit_empty|valid_email|max_length[85]'  // permit_empty significa que no es un campo obligatorio.
		];
		protected $validationMessages = [
			'correo'	=> [
				'valid_email' => 'Correo inválido.'
			]
		];
		protected $skipValidation = false;  // No se puede saltar ninguna regla de validación.
	}
?>