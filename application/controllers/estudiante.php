<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante extends CI_Controller {

	// Constructor del controlador, carga modelos y librerías de Codeigniter esenciales
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuarioModel');
		$this->load->model('estudianteModel');
		$this->load->model('individuoModel');
		$this->load->model('instructorModel');
		$this->load->model('paqueteModel');
		$this->load->model('sedeModel');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
	}

	public function index()
	{
		// Mantiene la sesion abierta
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 2) {
			redirect(base_url().'login');
		}

		// Carga datos personales y academicos del estudiante logueado
		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));
		// Carga informacion esencial de los paquetes
		$infoPaquetes = $this->estudianteModel->obtenerInfoPaquetes($estudiante->id_estudiante);
		$this->load->view('estudiante/perfil', ['estudiante'=>$estudiante, 'individuo'=>$individuo, 'infoPaquetes'=>$infoPaquetes]);
	}

	// Sirve para cambiar de contraseña
	public function configuracion()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 2) {
			redirect(base_url().'login');
		}


		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));

		if ($this->input->post()) {
			// El sistema valida que se haya escrito dos veces la contraseña, como medida de seguridad
			$this->form_validation->set_rules('contrasena', 'contraseña', 'required');
			$this->form_validation->set_rules('conf_contrasena', 'contraseña confirmada', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$contrasena = $this->input->post('contrasena');
				$contrasenaConfirmada = $this->input->post('conf_contrasena');
				$idUsuario = $this->session->userdata('id_usuario');

				// Si la contraseña es igual en los dos campos de texto, que se proceda al proceso de cambio
				if ($contrasena == $contrasenaConfirmada) {
					// Encripta la contraseña
					$hash = password_hash($contrasena, PASSWORD_DEFAULT);
					if ($this->usuarioModel->cambiarContrasena($idUsuario, $hash)) {
						$this->session->set_flashdata('mensaje', 'Contraseña actualizada exitosamente');
					} else {
						$this->session->set_flashdata('mensaje', 'No se pudo actualizar la contraseña');
					}

					return redirect('estudiante/configuracion');
				} else {
					$this->session->set_flashdata('mensaje', 'La contraseñas no coinciden');
					return redirect('estudiante/configuracion');
				}


			} else {
				$this->load->view('estudiante/configuracion', ['estudiante'=>$estudiante, 'individuo'=>$individuo]);
			}

		} else {
			$this->load->view('estudiante/configuracion', ['estudiante'=>$estudiante, 'individuo'=>$individuo]);
		}		
	}

}

/* End of file estudiante.php */
/* Location: ./application/controllers/estudiante.php */