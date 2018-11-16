<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BitacoraModel extends CI_Model {

	public function insertar($nombreInstructor, $nombreEstudiante, $mensaje)
	{
		$this->db->query("INSERT INTO t_bitacora VALUES (null, '$nombreInstructor', '$nombreEstudiante', NOW(), 'Asistencia', '$mensaje');");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

}

/* End of file bitacoraModel.php */
/* Location: ./application/models/bitacoraModel.php */