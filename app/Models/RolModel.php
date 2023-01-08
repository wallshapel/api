<?php namespace App\Models;
	use CodeIgniter\Model;
	class RolModel extends Model {
		protected $table 			= 'rol';
		protected $primaryKey 		= 'id';
		protected $returnType 		= 'array';
		protected $allowedFields	= ['nombre'];
		protected $useTimestamps	= true;
		protected $createdField		= 'created_at';
		protected $updatedField		= 'updated_at';
		protected $validationRules 	= [
			'nombre' => 'required|string|min_length[6]|max_length[45]'
		];
		protected $skipValidation = false;
		public function rolesXUsuario($id = null) {  // Busca el rol de un usuario por su id.
	        $builder = $this->db->query('
				SELECT
				    usuario.usuario, rol.nombre 
				FROM
				    banco.usuario
				JOIN banco.rol on
				    usuario.rol_id = rol.id
				WHERE usuario.id = '. $id);
			$query = $builder->getResultArray();
	        return $query;
	    }  
	}	
?>