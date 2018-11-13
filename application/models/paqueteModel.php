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

	public function insertar($nombre, $cantClases, $precio)
	{
		$query = $this->db->query("INSERT INTO T_PAQUETE VALUES (null, '$nombre', $cantClases, $precio);");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}

	}

	public function editar($nombre, $cantClases, $precio, $idPaquete)
	{
		$query = $this->db->query("UPDATE T_PAQUETE SET nombre_paquete = '$nombre', cantidad_clases = $cantClases, monto_precio = $precio WHERE id_paquete = $idPaquete;");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}

	}

}

/* End of file paqueteModel.php */
/* Location: ./application/models/paqueteModel.php */