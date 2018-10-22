<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
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

	public function configuracion()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 2) {
			redirect(base_url().'login');
		}


		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));
		$this->load->view('estudiante/configuracion', ['estudiante'=>$estudiante, 'individuo'=>$individuo]);
	}

}

/* End of file estudiante.php */
/* Location: ./application/controllers/estudiante.php */