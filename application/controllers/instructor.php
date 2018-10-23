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


	// Interfaz de instructor
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

	// Interfaz de estudiantes
	public function estudiantes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$listaEstudiantes = $this->instructorModel->obtenerListaEstudiantes($instructor->id_instructor);
		$listaEstudiantesGeneral = $this->instructorModel->obtenerListaEstudiantesTotal();

		if ($individuo != FALSE) {
			$this->load->view('instructor/lista_estudiantes', ['individuo'=>$individuo, 'listaEstudiantes'=>$listaEstudiantes, 'listaEstudiantesGeneral'=>$listaEstudiantesGeneral]);
		} else {
			echo "No hay nada";
		}
	}


	// Crear nuevo estudiante (usuario, individuo y estudiante)
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

				$existe = $this->instructorModel->existe($correo, $id);

				if ($existe == FALSE) {
					$this->usuarioModel->insertar($correo);
					$idUsuario = $this->usuarioModel->obtenerEspecifico($correo)->id_usuario;
					$this->individuoModel->insertar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac, $idUsuario);
					$this->estudianteModel->insertar($id, 1);

					$this->session->set_flashdata('mensaje', 'Estudiante añadido correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible añadir datos de estudiante');
				}

				return redirect('instructor/estudiantes');
			} else {
				$this->load->view('instructor/crear_estudiante');
			}

			

		} else {
			$this->load->view('instructor/crear_estudiante');
		}
	}


	// Editar informacion de estudiante, usuario e individuo
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
						$this->session->set_flashdata('mensaje', 'No es posible editar datos de estudiante');
					}
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible editar datos de estudiante');
				}
				return redirect('instructor/estudiantes');
			} else {
				$this->load->view('instructor/editar_estudiante', ['usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante]);
			}

		} else {
			$this->load->view('instructor/editar_estudiante', ['usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante]);
		}
	}


	// Interfaz de paquetes y asisterncias
	public function asistencias()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$infoPaquetesActivos = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor, 1);
		$infoPaquetesInactivos = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor, 0);
		$this->load->view('instructor/gestor_asistencias', ['infoPaquetesActivos'=>$infoPaquetesActivos, 'infoPaquetesInactivos'=>$infoPaquetesInactivos]);
	}

	// Asigna rapidamente una asistencia a un estudiante
	public function asignarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$infoAsistencias = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor, 1);

		$suma = $this->instructorModel->sumarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio);

		if ($suma) {
			$this->session->set_flashdata('mensaje', 'Asistencia añadida');
		} else {
			$this->session->set_flashdata('mensaje', 'No se pudo añadir la asistencia');
		}

		$this->asistencias();
	}

	public function editarPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$estudiantes = $this->estudianteModel->obtenerListaEstudiantes();
		$paquetes = $this->paqueteModel->seleccionar();
		$instructores = $this->instructorModel->obtenerListaInstructores();
		$sedes = $this->sedeModel->seleccionar();
		$infoActual = $this->instructorModel->obtenerPaqEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio);

		
		if ($this->input->post()) {
			$this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
			$this->form_validation->set_rules('dias_restantes', 'días restantes', 'required');
			$this->form_validation->set_rules('asistencias', 'asistencias', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$idPaqNuevo = $this->input->post('id_paquete');
				$idSedeNuevo = $this->input->post('id_sede');
				$idEstNuevo = $this->input->post('id_estudiante');
				$idInstNuevo = $this->input->post('id_instructor');
				$fechaInicioNuevo = $this->input->post('fecha_inicio');
				$diasRestantes = $this->input->post('dias_restantes');
				$asistencias = $this->input->post('asistencias');
				$esActivo = $this->input->post('es_activo'); 

				if ($mensaje = $this->instructorModel->editarPaqueteEstudiante($idPaqNuevo, $idSedeNuevo, $idEstNuevo, $idInstNuevo, $fechaInicioNuevo, $diasRestantes, $asistencias, $esActivo, $idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)) {
					$this->session->set_flashdata('mensaje', 'Paquete de estudiante editado correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No se pudo editar paquete de estudiante');
				}

				return redirect('instructor/asistencias');

			} else {
				$this->load->view('instructor/editar_paq_est', ['estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes, 'infoActual'=>$infoActual]);
			}

		} else {
			$this->load->view('instructor/editar_paq_est', ['estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes, 'infoActual'=>$infoActual]);
		}

	}

	// Considerar usar un ID unico para la relacion de muchos a muchos, ya que 
	public function asignarPaquete()
	{
		$estudiantes = $this->estudianteModel->obtenerListaEstudiantes();
		$paquetes = $this->paqueteModel->seleccionar();
		$instructores = $this->instructorModel->obtenerListaInstructores();
		$sedes = $this->sedeModel->seleccionar();

		if ($this->input->post()) {
			$idEstudiante = $this->input->post('id_estudiante');
			$idPaquete = $this->input->post('id_paquete');
			$idSede = $this->input->post('id_sede');
			$idInstructor = $this->input->post('id_instructor');
			$fechaInicio = $this->input->post('fecha_inicio');

			$this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				if ($this->instructorModel->crearPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)) {
					$this->session->set_flashdata('mensaje', 'Paquete asignado correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No se pudo asignar el paquete');
				}

				return redirect('instructor/asistencias');
			} else {
				$this->load->view('instructor/crear_paq_est', ['estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes]);
			}
		}

		$this->load->view('instructor/crear_paq_est', ['estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes]);
	}

	// Pagina de gestion de informacion de instructores
	public function instructores()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$individuo = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$listaInstructores = $this->instructorModel->obtenerListaInstructores();

		if ($individuo != FALSE) {
			$this->load->view('instructor/lista_instructores', ['individuo'=>$individuo, 'listaInstructores'=>$listaInstructores]);
		} else {
			echo "No hay nada";
		}
	}

	// Añadir nuevo instructor
	public function nuevoInstructor()
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
				$esEstudiante = $this->input->post('es_estudiante');

				$existe = $this->instructorModel->existe($correo, $id);

				if ($existe == FALSE) {
					$this->usuarioModel->insertar($correo);
					$idUsuario = $this->usuarioModel->obtenerEspecifico($correo)->id_usuario;
					$this->individuoModel->insertar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac, $idUsuario);
					$this->instructorModel->insertar($id);

					if ($esEstudiante == 1) {
						$this->estudianteModel->insertar($id, 1);
					}

					$this->session->set_flashdata('mensaje', 'Instructor añadido correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible añadir datos de instructor');
				}

				return redirect('instructor/instructores');
			} else {
				$this->load->view('instructor/crear_instructor');
			}
		} else {
			$this->load->view('instructor/crear_instructor');
		}
	}

	public function editarInstructor($idUsuario)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$usuario = $this->usuarioModel->obtenerInfo($idUsuario);
		$individuo = $this->individuoModel->obtenerInfo($idUsuario);
		$instructor = $this->instructorModel->obtenerInfo($idUsuario);


		if ($this->input->post()) {
			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('id_individuo', 'identificacion', 'required');
			$this->form_validation->set_rules('nombre', 'nombre', 'required');
			$this->form_validation->set_rules('apellido1', 'primer apellido', 'required');
			$this->form_validation->set_rules('nacionalidad', 'nacionalidad', 'required');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required');
			$this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
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
				$fechaInicio = $this->input->post('fecha_inicio');
				$activo = $this->input->post('es_activo');
				$esEstudiante = $this->input->post('es_estudiante');

				if ($this->usuarioModel->editar($idUsuario, $correo)) {

					if ($this->individuoModel->editar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac)) {
						if ($this->instructorModel->editar($id, $fechaInicio, $activo)) {
							if ($esEstudiante == 1) { // Si es estudiante, verificar si existe, y sino, crear nuevo estudiante
								if ($this->estudianteModel->existeEstudiante($id)) {
									$this->estudianteModel->editarEstudianteInstructor($id, 1);
								} else {
									$this->estudianteModel->insertar($id, 1);
								}
							} elseif ($esEstudiante == 0) {
								if ($this->estudianteModel->existeEstudiante($id)) {
									$this->estudianteModel->editarEstudianteInstructor($id, 0);
								}
							}
							$this->session->set_flashdata('mensaje', 'Instructor editado correctamente');
						} else {
							$this->session->set_flashdata('mensaje', 'No es posible editar datos de instructor');
						}
					} else {
						$this->session->set_flashdata('mensaje', 'No es posible editar datos de instructor');
					}
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible editar datos de instructor');
				}
				return redirect('instructor/instructores');
			} else {
				$this->load->view('instructor/editar_instructor', ['usuario'=>$usuario, 'individuo'=>$individuo, 'instructor'=>$instructor]);
			}

		} else {
			$this->load->view('instructor/editar_instructor', ['usuario'=>$usuario, 'individuo'=>$individuo, 'instructor'=>$instructor]);
		}
	}

}

/* End of file instructor.php */
/* Location: ./application/controllers/instructor.php */