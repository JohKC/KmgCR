<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaqueteModel extends CI_Model {

	public function obtenerInfo($idPaquete)
	{
		$query = $this->db->query("SELECT * FROM T_PAQUETE WHERE id_paquete = $idPaquete;");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function seleccionar()
	{
		$query = $this->db->query("SELECT * FROM T_PAQUETE;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

}

/* End of file paqueteModel.php */
/* Location: ./application/models/paqueteModel.php */