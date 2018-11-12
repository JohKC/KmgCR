<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuarioModel');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
	}

	public function index()
	{
		switch ($this->session->userdata('id_rol')) {
			case '':
				$data['token'] = $this->token();
				$data['titulo'] = 'Inicio de sesion';
				$this->load->view('loginView', $data);
				break;
			case 1:
				redirect(base_url().'instructor');
				break;
			case 2:
				redirect(base_url().'estudiante');
				break;
			case 3: // si el rol es 3, devolverse a login, pues no se ha asignado un rol de estudiante o instructor
				$data['token'] = $this->token();
				$data['titulo'] = 'Inicio de sesion';
				$this->load->view('loginView', $data);
				break;
			default:
				$data['titulo'] = 'Inicio de sesion';
				$this->load->view('loginView', $data);
				break;
		}
	}

	public function iniciarSesion()
	{
		if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {

			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('contrasena', 'contrasena', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->index();
			} else {
				$correo = $this->input->post('correo_electronico');
				$contrasena = $this->input->post('contrasena');
				$verificacion = $this->usuarioModel->iniciarSesion($correo, $contrasena);

				if ($verificacion == TRUE) {
					$data = array (
						'logged_in' => TRUE,
						'id_usuario' => $verificacion->id_usuario,
						'id_rol' => $verificacion->id_rol,
						'correo_electronico' => $verificacion->correo_electronico
					);
					
					$this->session->set_userdata($data);
					$this->index();
				} 
			}
		} else {
			redirect(base_url().'login');
		}
	}

	public function token()
	{
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token', $token);
		return $token;
	}

	public function cerrarSesion()
	{
		$this->session->sess_destroy();
		$this->index();
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */