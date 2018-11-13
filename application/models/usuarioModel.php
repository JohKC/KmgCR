<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioModel extends CI_Model {

	// Metodo para iniciar sesion
	public function iniciarSesion($correo, $contrasena)
	{
		// Verifica que exista un usuario con estos credenciales
		$this->db->where('correo_electronico', $correo);
		$query = $this->db->get('T_USUARIO');

		// Encripta la contraseña introducida
		$hash = $this->db->query("SELECT contrasena FROM T_USUARIO WHERE correo_electronico = '$correo';")->row()->contrasena;
		
		// Si la contraseña coincide y si existe el usuario, que se inicie sesion
		if ($query->num_rows() == 1 && password_verify($contrasena, $hash)) {
			return $query->row();
		} else {
			$this->session->set_flashdata('usuario_incorrecto', 'El usuario o contraseña son incorrectos');
			redirect(base_url().'login','refresh');
		}
	}

	// Actualiza la contraseña del usuario
	public function cambiarContrasena($idUsuario, $hash)
	{
		return $this->db->query("UPDATE T_USUARIO SET contrasena = '$hash' WHERE id_usuario = $idUsuario;");
	}

	// Obtener informacion de usuario
	public function obtenerInfo($idUsuario)
	{
		$query = $this->db->query("SELECT * FROM T_USUARIO WHERE id_usuario = '$idUsuario';");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	// Obtener a un usuario especifico basado en su correo
	public function obtenerEspecifico($correo)
	{
		$query = $this->db->query("SELECT * FROM T_USUARIO WHERE correo_electronico = '$correo';");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function insertar($correo, $contraEncriptada, $idRol)
	{
		$this->db->query("INSERT INTO T_USUARIO VALUES (null, '$correo', '$contraEncriptada', $idRol);");

		$error = $this->db->error();

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