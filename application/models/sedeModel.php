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

	public function insertar($nombre, $ubicacion, $esActivo)
	{
		$query = $this->db->query("INSERT INTO T_SEDE VALUES (null, '$nombre', '$ubicacion', $esActivo);");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}

	}

	public function editar($nombre, $ubicacion, $esActivo, $idSede)
	{
		$query = $this->db->query("UPDATE T_SEDE SET nombre_sede = '$nombre', ubicacion = '$ubicacion', es_activo = $esActivo WHERE id_sede = $idSede;");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}

	}

}

/* End of file sedeModel.php */
/* Location: ./application/models/sedeModel.php */