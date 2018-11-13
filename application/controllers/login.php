<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	// Constructor del controlador, carga modelos y librerías de Codeigniter esenciales
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
		// Redirige a una interfaz, basado en el rol del usuario logueado
		switch ($this->session->userdata('id_rol')) {
			case '': // Si no hay rol, que se mantenga en la pantalla de inicio de sesion
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

	// Inicio de sesion
	public function iniciarSesion()
	{
		if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {

			// Valida que se hayan escrito el usuario y la contraseña
			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('contrasena', 'contrasena', 'required');
			// Mensaje de advertencia, por si se dejo en blanco alguno de los campos de texto
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			// Si se dejaron en blanco los campos, que se devuelva a la pagina
			if ($this->form_validation->run() == FALSE) {
				$this->index();
			} else {
				// Se guardan los datos de los campos de texto
				$correo = $this->input->post('correo_electronico');
				$contrasena = $this->input->post('contrasena');
				// Verifica que el usuario exista
				$verificacion = $this->usuarioModel->iniciarSesion($correo, $contrasena);

				if ($verificacion == TRUE) {
					// Si la verificacion es exitosa, crear sesion nueva y asignar datos a la sesion
					$data = array (
						'logged_in' => TRUE,
						'id_usuario' => $verificacion->id_usuario,
						'id_rol' => $verificacion->id_rol,
						'correo_electronico' => $verificacion->correo_electronico
					);
					
					// Creacion de sesion
					$this->session->set_userdata($data);
					$this->index();
				} 
			}
		} else {
			redirect(base_url().'login');
		}
	}

	// Genera un token aleatorio, para poder iniciar sesion de forma segura
	public function token()
	{
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token', $token);
		return $token;
	}

	// Para cerrar sesion, se destruye esta y se devuelve a la pagina de inicio de sesion
	public function cerrarSesion()
	{
		$this->session->sess_destroy();
		$this->index();
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */