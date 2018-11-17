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

	public function seleccionar()
	{
		$query = $this->db->query("SELECT id_bitacora, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, descripcion FROM T_BITACORA ORDER BY id_bitacora DESC;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}

/* End of file bitacoraModel.php */
/* Location: ./application/models/bitacoraModel.php */