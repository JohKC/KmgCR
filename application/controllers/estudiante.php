<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante extends CI_Controller {

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
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 2) {
			redirect(base_url().'login');
		}


		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));
		$infoPaquetes = $this->estudianteModel->obtenerInfoPaquetes($estudiante->id_estudiante);
		$this->load->view('estudiante/perfil', ['estudiante'=>$estudiante, 'individuo'=>$individuo, 'infoPaquetes'=>$infoPaquetes]);
	}

	// Sirve para cambiar de contrasena
	public function configuracion()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 2) {
			redirect(base_url().'login');
		}


		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));

		if ($this->input->post()) {
			$this->form_validation->set_rules('contrasena', 'contraseña', 'required');
			$this->form_validation->set_rules('conf_contrasena', 'contraseña confirmada', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$contrasena = $this->input->post('contrasena');
				$contrasenaConfirmada = $this->input->post('conf_contrasena');
				$idUsuario = $this->session->userdata('id_usuario');

				if ($contrasena == $contrasenaConfirmada) {
					$hash = password_hash($contrasena, PASSWORD_DEFAULT);
					if ($this->usuarioModel->cambiarContrasena($idUsuario, $hash)) {
						$this->session->set_flashdata('mensaje', 'Contraseña actualizada exitosamente');
					} else {
						$this->session->set_flashdata('mensaje', 'No se pudo actualizar la contraseña');
					}

					return redirect('estudiante');
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