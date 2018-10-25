<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndividuoModel extends CI_Model {

	public function existe($correo, $id)
	{
		$query1 = $this->db->query("SELECT * FROM T_USUARIO WHERE correo_electronico = '$correo';");
		$query2 = $this->db->query("SELECT * FROM T_INDIVIDUO WHERE id_individuo = '$id';");

		// $log = fopen("logEstudiante.txt", "w") or die("Unable to open file!");
		// $txt = $error['message'] . '<br>' . $this->db->last_query() . '<br>';
		// fwrite($log, $txt);
		// fclose($log);

		if (($query1->num_rows() > 0) || ($query2->num_rows() > 0)) {
			return true;
		} else {
			return false;
		}

	}

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

	public function obtenerListaIndividuos()
	{
		$query = $this->db->query("SELECT U.id_usuario, I.id_individuo, I.nombre, I.apellido1, I.apellido2, U.correo_electronico, I.nacionalidad, I.condicion_medica, I.fecha_nacimiento FROM t_usuario U 
			INNER JOIN t_individuo I ON U.id_usuario = I.id_usuario;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function insertar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac, $idUsuario)
	{
		$this->db->query("INSERT INTO T_INDIVIDUO VALUES ('$id','$nombre','$apellido1','$apellido2','$nacionalidad','$condicion','$fechaNac', $idUsuario);");

		$error = $this->db->error();
		// return $error['message'] . ' ' . $this->db->last_query() . '<br>';

		// $log = fopen("logIndividuo.txt", "w") or die("Unable to open file!");
		// $txt = $error['message'] . '<br>' . $this->db->last_query() . '<br>';
		// fwrite($log, $txt);
		// fclose($log);

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function editar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac)
	{
		$this->db->query("UPDATE T_INDIVIDUO SET nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', nacionalidad = '$nacionalidad', condicion_medica = '$condicion', fecha_nacimiento = '$fechaNac' WHERE id_individuo = '$id';");

		$error = $this->db->error();

		// $log = fopen("logIndividuo.txt", "w") or die("Unable to open file!");
		// $txt = $error['message'] . '<br>' . $this->db->last_query() . '<br>';
		// fwrite($log, $txt);
		// fclose($log);

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

}

/* End of file individuoModel.php */
/* Location: ./application/models/individuoModel.php */