<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioModel extends CI_Model {

	public function iniciarSesion($correo, $contrasena)
	{
		$this->db->where('correo_electronico', $correo);
		$this->db->where('contrasena', $contrasena);
		$query = $this->db->get('T_USUARIO');

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			$this->session->set_flashdata('usuario_incorrecto', 'El usuario o contrasena son incorrectos');
			redirect(base_url().'login','refresh');
		}
	}

	public function obtenerInfo($idUsuario)
	{
		$query = $this->db->query("SELECT * FROM T_USUARIO WHERE id_usuario = '$idUsuario';");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function obtenerEspecifico($correo)
	{
		$query = $this->db->query("SELECT * FROM T_USUARIO WHERE correo_electronico = '$correo';");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function insertar($correo, $idRol)
	{
		$this->db->query("INSERT INTO T_USUARIO VALUES (null, '$correo', '1234', $idRol);");

		$error = $this->db->error();

		// return $error['message'] . ' ' . $this->db->last_query() . '<br>';

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function editar($idUsuario, $correo, $idRol)
	{
		return $this->db->query("UPDATE T_USUARIO SET correo_electronico = '$correo', id_rol = $idRol WHERE id_usuario = $idUsuario;");
	}

	public function seleccionar()
	{
		$query = $this->db->query("SELECT * FROM T_USUARIO;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

}

/* End of file usuarioModel.php */
/* Location: ./application/models/usuarioModel.php */