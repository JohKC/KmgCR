<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('individuoModel');
		$this->load->model('instructorModel');
		$this->load->model('usuarioModel');
		$this->load->model('estudianteModel');
		$this->load->model('paqueteModel');
		$this->load->model('sedeModel');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}


		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));
		$infoPaquetes = $this->estudianteModel->obtenerInfoPaquetes($estudiante->id_estudiante);
		
		if ($individuo != FALSE) {
			$this->load->view('instructor/perfil', ['individuo'=>$individuo, 'estudiante'=>$estudiante, 'infoPaquetes'=>$infoPaquetes]);
		} else {
			echo "No hay nada";
		}
	}

	public function estudiantes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($individuo->id_individuo);
		$listaEstudiantes = $this->instructorModel->obtenerListaEstudiantes($instructor->id_instructor);

		if ($individuo != FALSE) {
			$this->load->view('instructor/lista_estudiantes', ['individuo'=>$individuo, 'listaEstudiantes'=>$listaEstudiantes]);
		} else {
			echo "No hay nada";
		}
	}

	public function nuevoEstudiante()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('id_individuo', 'identificacion', 'required');
			$this->form_validation->set_rules('nombre', 'nombre', 'required');
			$this->form_validation->set_rules('apellido1', 'primer apellido', 'required');
			$this->form_validation->set_rules('nacionalidad', 'nacionalidad', 'required');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$correo = $this->input->post('correo_electronico');
				$id = $this->input->post('id_individuo');
				$nombre = $this->input->post('nombre');
				$apellido1 = $this->input->post('apellido1');
				$apellido2 = $this->input->post('apellido2');
				$fechaNac = $this->input->post('fecha_nacimiento');
				$nacionalidad = $this->input->post('nacionalidad');
				$condicion = $this->input->post('condicion_medica');

				if ($this->usuarioModel->insertar($correo)) {
					$idUsuario = $this->usuarioModel->obtenerEspecifico($correo)->id_usuario;

					if ($this->individuoModel->insertar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac, $idUsuario)) {
						if ($this->estudianteModel->insertar($id)) {
							$this->session->set_flashdata('mensaje', 'Estudiante añadido correctamente');
						} else {
							$this->session->set_flashdata('mensaje', 'No es posible añadir datos de estudiante');
						}
					} else {
						$this->session->set_flashdata('mensaje', 'No es posible añadir datos de individuo');
					}
				}
				return redirect('instructor');
			} else {
				$this->load->view('instructor/crear_estudiante');
			}

			

		} else {
			$this->load->view('instructor/crear_estudiante');
		}
	}

	public function editarEstudiante($idUsuario)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$usuario = $this->usuarioModel->obtenerInfo($idUsuario);
		$individuo = $this->individuoModel->obtenerInfo($idUsuario);
		$estudiante = $this->estudianteModel->obtenerInfo($idUsuario);

		if ($this->input->post()) {
			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('id_individuo', 'identificacion', 'required');
			$this->form_validation->set_rules('nombre', 'nombre', 'required');
			$this->form_validation->set_rules('apellido1', 'primer apellido', 'required');
			$this->form_validation->set_rules('nacionalidad', 'nacionalidad', 'required');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required');
			$this->form_validation->set_rules('fecha_inscripcion', 'fecha de inscripción', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$correo = $this->input->post('correo_electronico');
				$id = $this->input->post('id_individuo');
				$nombre = $this->input->post('nombre');
				$apellido1 = $this->input->post('apellido1');
				$apellido2 = $this->input->post('apellido2');
				$fechaNac = $this->input->post('fecha_nacimiento');
				$nacionalidad = $this->input->post('nacionalidad');
				$condicion = $this->input->post('condicion_medica');
				$fechaInsc = $this->input->post('fecha_inscripcion');
				$nivelKmg = $this->input->post('nivel_kmg');
				$activo = $this->input->post('activo');

				if ($this->usuarioModel->editar($idUsuario, $correo)) {

					if ($this->individuoModel->editar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac)) {
						if ($this->estudianteModel->editar($id, $fechaInsc, $nivelKmg, $activo)) {
							$this->session->set_flashdata('mensaje', 'Estudiante editado correctamente');
						} else {
							$this->session->set_flashdata('mensaje', 'No es posible editar datos de estudiante');
						}
					} else {
						$this->session->set_flashdata('mensaje', 'No es posible editar datos de individuo');
					}
				}
				return redirect('instructor/estudiantes');
			} else {
				$this->load->view('instructor/editar_estudiante', ['usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante]);
			}

		} else {
			$this->load->view('instructor/editar_estudiante', ['usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante]);
		}
	}

	public function asistencias()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($individuo->id_individuo);
		$infoAsistencias = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor);
		$this->load->view('instructor/gestor_asistencias', ['infoAsistencias'=>$infoAsistencias]);
	}

	public function asignarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($individuo->id_individuo);
		$infoAsistencias = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor);

		$suma = $this->instructorModel->sumarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor);

		if ($suma) {
			$this->session->set_flashdata('mensaje', 'Asistencia añadida');
		} else {
			$this->session->set_flashdata('mensaje', 'No se pudo añadir la asistencia');
		}

		$this->asistencias();
	}

	public function editarPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$estudiantes = $this->estudianteModel->obtenerListaEstudiantes();
		$paquetes = $this->paqueteModel->seleccionar();
		$instructores = $this->instructorModel->obtenerListaInstructores();
		$sedes = $this->sedeModel->seleccionar();
		$infoActual = $this->instructorModel->obtenerPaqEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor);

		$this->load->view('instructor/editar_paq_est', ['estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes, 'infoActual'=>$infoActual]);

	}

}

/* End of file instructor.php */
/* Location: ./application/controllers/instructor.php */