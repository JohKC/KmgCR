<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SedeModel extends CI_Model {

	public function obtenerInfo($idSede)
	{
		$query = $this->db->query("SELECT * FROM T_SEDE WHERE id_sede = $idSede;");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function seleccionar()
	{
		$query = $this->db->query("SELECT * FROM T_SEDE;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

}

/* End of file sedeModel.php */
/* Location: ./application/models/sedeModel.php */