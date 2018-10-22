<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndividuoModel extends CI_Model {

	public function obtenerInfo($idUsuario)
	{
		$query = $this->db->query("SELECT I.id_individuo, I.nombre, I.apellido1, I.apellido2, I.nacionalidad, I.condicion_medica, I.fecha_nacimiento FROM t_usuario U 
			INNER JOIN t_individuo I ON U.id_usuario = I.id_usuario
			WHERE U.id_usuario = $idUsuario;");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function seleccionar()
	{
		$query = $this->db->query("SELECT * FROM T_INDIVIDUO;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function insertar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac, $idUsuario)
	{
		return $this->db->query("INSERT INTO T_INDIVIDUO VALUES ('$id','$nombre','$apellido1','$apellido2','$nacionalidad','$condicion','$fechaNac', $idUsuario);");
	}

	public function editar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac)
	{
		$this->db->query("UPDATE T_INDIVIDUO SET nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', nacionalidad = '$nacionalidad', condicion_medica = '$condicion', fecha_nacimiento = '$fechaNac' WHERE id_individuo = '$id';");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

}

/* End of file individuoModel.php */
/* Location: ./application/models/individuoModel.php */