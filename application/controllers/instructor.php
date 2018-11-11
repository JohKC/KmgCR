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


		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		// Si el instructor es estudiante, se cargara el perfil de estudiante
		$existeEstudiante = $this->estudianteModel->existeEstudiante($logueado->id_individuo);

		if ($existeEstudiante) { // Si es estudiante, cargar informacion de estudiante
			$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));
			$infoPaquetes = $this->estudianteModel->obtenerInfoPaquetes($estudiante->id_estudiante);

			if ($logueado != FALSE) {
				$this->load->view('instructor/perfil', ['logueado'=>$logueado, 'estudiante'=>$estudiante, 'infoPaquetes'=>$infoPaquetes, 'existeEstudiante'=>$existeEstudiante]);

			} else {
				echo "No hay nada";
			}
		} else { // Si no es estudiante, no cargar informacion de estudiante
			if ($logueado != FALSE) {
				$this->load->view('instructor/perfil', ['logueado'=>$logueado, 'existeEstudiante'=>$existeEstudiante]);
			} else {
				echo "No hay nada";
			}
		}
		
		// TODO: Si el instructor NO esta activo, mostrar solo un mensaje de que no esta activo

		
	}

	// Interfaz de usuarios
	public function usuarios()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		$listaUsuarios = $this->individuoModel->obtenerListaIndividuos();

		$this->load->view('instructor/lista_usuarios', ['logueado'=>$logueado, 'listaUsuarios'=>$listaUsuarios]);
	}

	public function nuevoUsuario()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

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

				$existe = $this->individuoModel->existe($correo, $id);

				if ($existe == FALSE) {
					$this->usuarioModel->insertar($correo, 3);
					$idUsuario = $this->usuarioModel->obtenerEspecifico($correo)->id_usuario;
					$this->individuoModel->insertar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac, $idUsuario);
					$this->session->set_flashdata('mensaje', 'Usuario añadido correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible añadir datos de usuario');
				}

				return redirect('instructor/usuarios');
			} else {
				$this->load->view('instructor/crear_usuario', ['logueado'=>$logueado]);
			}

			

		} else {
			$this->load->view('instructor/crear_usuario', ['logueado'=>$logueado]);
		}
	}

	// Editar un usuario
	public function editarUsuario($idUsuario)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$usuario = $this->usuarioModel->obtenerInfo($idUsuario);
		$individuo = $this->individuoModel->obtenerInfo($idUsuario);
		$estudiante = $this->estudianteModel->obtenerInfo($idUsuario);
		$existeEstudiante = $this->estudianteModel->existeEstudiante($individuo->id_individuo);
		$existeInstructor = $this->instructorModel->existeInstructor($individuo->id_individuo);

		if ($this->input->post()) {
			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('id_individuo', 'identificacion', 'required');
			$this->form_validation->set_rules('nombre', 'nombre', 'required');
			$this->form_validation->set_rules('apellido1', 'primer apellido', 'required');
			$this->form_validation->set_rules('nacionalidad', 'nacionalidad', 'required');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required');
			// $this->form_validation->set_rules('fecha_inscripcion', 'fecha de inscripción', 'required');
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
				$esInstructor = $this->input->post('es_instructor');

				$idRol = 3;

				if ($esInstructor == 1 && $esEstudiante == 1) {
					$idRol = 1; // Si es instructor y estudiante, tendra el rol 1 para login
				} elseif ($esInstructor == 1 && $esEstudiante == 0) {
					$idRol = 1; // Si es instructor pero NO estudiante, tendra el rol 1 para login
				} elseif ($esInstructor == 0 && $esEstudiante == 1) {
					$idRol = 2; // Si solo es estudiante, tendra el rol 2 para login
				}


				if ($this->usuarioModel->editar($idUsuario, $correo, $idRol)) {
					if ($this->individuoModel->editar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac)) {

						if ($existeEstudiante == FALSE) {
							if ($esEstudiante == 1) {
								// insertar estudiante
								$this->estudianteModel->insertar($id, 1);
							}
						}

						if ($existeInstructor == FALSE) {
							if ($esInstructor == 1) {
								// insertar instructor
								$this->instructorModel->insertar($id, 1);
							}
						}

						$this->session->set_flashdata('mensaje', 'Usuario editado correctamente');
					} else {
						$this->session->set_flashdata('mensaje', 'No se ha podido editar el usuario');
					}
				} else {
					$this->session->set_flashdata('mensaje', 'No se ha podido editar el usuario');
				}
			
				return redirect('instructor/usuarios');
			} else {
				$this->load->view('instructor/editar_usuario', ['logueado'=>$logueado, 'usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante, 'existeInstructor'=>$existeInstructor, 'existeEstudiante'=>$existeEstudiante]);
			}

		} else {
			$this->load->view('instructor/editar_usuario', ['logueado'=>$logueado, 'usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante, 'existeInstructor'=>$existeInstructor, 'existeEstudiante'=>$existeEstudiante]);
		}
	}

	// Interfaz de estudiantes
	public function estudiantes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$listaEstudiantes = $this->instructorModel->obtenerListaEstudiantes($instructor->id_instructor);
		$listaEstudiantesGeneral = $this->instructorModel->obtenerListaEstudiantesTotal();

		if ($logueado != FALSE) {
			$this->load->view('instructor/lista_estudiantes', ['logueado'=>$logueado, 'listaEstudiantes'=>$listaEstudiantes, 'listaEstudiantesGeneral'=>$listaEstudiantesGeneral]);
		} else {
			echo "No hay nada";
		}
	}

	// Editar informacion de estudiante, usuario e individuo
	public function editarEstudiante($idUsuario)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$usuario = $this->usuarioModel->obtenerInfo($idUsuario);
		$individuo = $this->individuoModel->obtenerInfo($idUsuario);
		$estudiante = $this->estudianteModel->obtenerInfo($idUsuario);


		if ($this->input->post()) {
			$this->form_validation->set_rules('fecha_inscripcion', 'fecha de inscripción', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$id = $this->input->post('id_individuo');
				$fechaInsc = $this->input->post('fecha_inscripcion');
				$nivelKmg = $this->input->post('nivel_kmg');
				$activo = $this->input->post('activo');

				if ($this->estudianteModel->editar($id, $fechaInsc, $nivelKmg, $activo)) {
					$this->session->set_flashdata('mensaje', 'Estudiante editado correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible editar datos de estudiante');
				}

				return redirect('instructor/estudiantes');
			} else {
				$this->load->view('instructor/editar_estudiante', ['logueado'=>$logueado, 'individuo'=>$individuo, 'estudiante'=>$estudiante]);
			}

		} else {
			$this->load->view('instructor/editar_estudiante', ['logueado'=>$logueado, 'usuario'=>$usuario, 'individuo'=>$individuo, 'estudiante'=>$estudiante]);
		}
	}


	// Interfaz de paquetes y asisterncias
	public function asistencias()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$infoPaquetesActivos = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor, 1);
		$infoPaquetesInactivos = $this->instructorModel->obtenerInfoAsistencias($instructor->id_instructor, 0);


		$this->load->view('instructor/gestor_asistencias', ['logueado'=>$logueado, 'infoPaquetesActivos'=>$infoPaquetesActivos, 'infoPaquetesInactivos'=>$infoPaquetesInactivos]);
	}

	// Asigna rapidamente una asistencia a un estudiante
	public function asignarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
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

	public function editarPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $esActivo)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
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
				$esActivoNuevo = $this->input->post('es_activo'); 
				$esPagado = $this->input->post('es_pagado'); 

				// Si el paquete cambiará a activo, verificar que no exista ya un paquete activo con las mismas condiciones (sede, estudiante e instructor)
				if ($esActivoNuevo == 1 && $esActivo == 0) {
					if ($this->instructorModel->verificarPaqueteActivo($idInstructor, $idEstudiante, $idSede) == FALSE) {
						if ($this->instructorModel->editarPaqueteEstudiante($idPaqNuevo, $idSedeNuevo, $idEstNuevo, $idInstNuevo, $fechaInicioNuevo, $diasRestantes, $asistencias, $esActivoNuevo, $idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $esPagado)) {
							$this->session->set_flashdata('mensaje', 'Paquete de estudiante editado correctamente');
						} else {
							$this->session->set_flashdata('mensaje', 'No se pudo editar paquete de estudiante');
						}
					} else {
						$this->session->set_flashdata('mensaje', 'Ya existe un paquete activo con el mismo estudiante, sede e instructor');
					}

				} else {
					if ($this->instructorModel->editarPaqueteEstudiante($idPaqNuevo, $idSedeNuevo, $idEstNuevo, $idInstNuevo, $fechaInicioNuevo, $diasRestantes, $asistencias, $esActivoNuevo, $idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $esPagado)) {
						$this->session->set_flashdata('mensaje', 'Paquete de estudiante editado correctamente');
					} else {
						$this->session->set_flashdata('mensaje', 'No se pudo editar paquete de estudiante');
					}
				}


				
				return redirect('instructor/asistencias');

			} else {
				$this->load->view('instructor/editar_paq_est', ['logueado'=>$logueado, 'estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes, 'infoActual'=>$infoActual]);
			}

		} else {
			$this->load->view('instructor/editar_paq_est', ['logueado'=>$logueado, 'estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes, 'infoActual'=>$infoActual]);
		}

	}

	public function asignarPaquete()
	{
		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
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
			$esActivo = $this->input->post('es_activo'); 
			$esPagado = $this->input->post('es_pagado'); 

			$this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				if ($this->instructorModel->verificarNoPagados($idEstudiante) == FALSE) {
					if ($this->instructorModel->crearPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $esActivo, $esPagado)) {
						$this->session->set_flashdata('mensaje', 'Paquete asignado correctamente');
					} else {
						$this->session->set_flashdata('mensaje', 'No se pudo asignar el paquete');
					}
				} else {
					$this->session->set_flashdata('mensaje', 'El estudiante no ha pagado su paquete actual');
				}


					

				return redirect('instructor/asistencias');
			} else {
				$this->load->view('instructor/crear_paq_est', ['logueado'=>$logueado, 'estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes]);
			}
		} else {
			$this->load->view('instructor/crear_paq_est', ['logueado'=>$logueado, 'estudiantes'=>$estudiantes, 'paquetes'=>$paquetes, 'instructores'=>$instructores, 'sedes'=>$sedes]);

		}

	}

	// Pagina de gestion de informacion de instructores
	public function instructores()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$instructor = $this->instructorModel->obtenerInfo($this->session->userdata('id_usuario'));
		$listaInstructores = $this->instructorModel->obtenerListaInstructores();

		if ($logueado != FALSE) {
			$this->load->view('instructor/lista_instructores', ['logueado'=>$logueado, 'listaInstructores'=>$listaInstructores]);
		} else {
			echo "No hay nada";
		}
	}

	public function editarInstructor($idUsuario)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$usuario = $this->usuarioModel->obtenerInfo($idUsuario);
		$individuo = $this->individuoModel->obtenerInfo($idUsuario);
		$instructor = $this->instructorModel->obtenerInfo($idUsuario);


		if ($this->input->post()) {
			$this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$id = $this->input->post('id_individuo');
				$fechaInicio = $this->input->post('fecha_inicio');
				$activo = $this->input->post('es_activo');

				if ($this->instructorModel->editar($id, $fechaInicio, $activo)) {
					$this->session->set_flashdata('mensaje', 'Instructor editado correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible editar datos de instructor');
				}

				return redirect('instructor/instructores');
			} else {
				$this->load->view('instructor/editar_instructor', ['usuario'=>$usuario, 'logueado'=>$logueado, 'individuo'=>$individuo, 'instructor'=>$instructor]);
			}

		} else {
			$this->load->view('instructor/editar_instructor', ['usuario'=>$usuario, 'logueado'=>$logueado, 'individuo'=>$individuo, 'instructor'=>$instructor]);
		}
	}

	public function paquetes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		$listaPaquetes = $this->paqueteModel->seleccionar();

		$this->load->view('instructor/lista_paquetes', ['logueado'=>$logueado, 'listaPaquetes'=>$listaPaquetes]);
	}

	// Inserta un nuevo tipo de paquete
	public function nuevoPaquete()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		if ($this->input->post()) {
			$this->form_validation->set_rules('nombre_paquete', 'nombre del paquete', 'required');
			$this->form_validation->set_rules('cantidad_clases', 'cantidad de clases', 'required');
			$this->form_validation->set_rules('monto_precio', 'precio', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$nombre = $this->input->post('nombre_paquete');
				$cantClases = $this->input->post('cantidad_clases');
				$precio = $this->input->post('monto_precio');

				if ($this->paqueteModel->insertar($nombre, $cantClases, $precio)) {
					$this->session->set_flashdata('mensaje', 'Paquete añadido correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible añadir datos de paquete');
				}

				return redirect('instructor/paquetes');
			} else {
				$this->load->view('instructor/crear_paquete', ['logueado'=>$logueado]);
			}
		} else {
			$this->load->view('instructor/crear_paquete', ['logueado'=>$logueado]);
		}
	}

	public function editarPaquete($idPaquete)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$paquete = $this->paqueteModel->obtenerInfo($idPaquete);

		if ($this->input->post()) {
			$this->form_validation->set_rules('nombre_paquete', 'nombre del paquete', 'required');
			$this->form_validation->set_rules('cantidad_clases', 'cantidad de clases', 'required');
			$this->form_validation->set_rules('monto_precio', 'precio', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$nombre = $this->input->post('nombre_paquete');
				$cantClases = $this->input->post('cantidad_clases');
				$precio = $this->input->post('monto_precio');

				if ($this->paqueteModel->editar($nombre, $cantClases, $precio, $idPaquete)) {
					$this->session->set_flashdata('mensaje', 'Paquete editado correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible editar datos de paquete');
				}

				return redirect('instructor/paquetes');
			} else {
				$this->load->view('instructor/editar_paquete', ['logueado'=>$logueado, 'paquete'=>$paquete]);
			}
		} else {
			$this->load->view('instructor/editar_paquete', ['logueado'=>$logueado, 'paquete'=>$paquete]);
		}
	}

	public function sedes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		$listaSedes = $this->sedeModel->seleccionar();

		$this->load->view('instructor/lista_sedes', ['logueado'=>$logueado, 'listaSedes'=>$listaSedes]);
	}

	public function nuevaSede()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		if ($this->input->post()) {
			$this->form_validation->set_rules('nombre_sede', 'nombre de sede', 'required');
			$this->form_validation->set_rules('ubicacion', 'ubicación', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$nombre = $this->input->post('nombre_sede');
				$ubicacion = $this->input->post('ubicacion');
				$esActivo = $this->input->post('es_activo');

				if ($this->sedeModel->insertar($nombre, $ubicacion, $esActivo)) {
					$this->session->set_flashdata('mensaje', 'Sede añadida correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible añadir datos de sede');
				}

				return redirect('instructor/sedes');
			} else {
				$this->load->view('instructor/crear_sede', ['logueado'=>$logueado]);
			}
		} else {
			$this->load->view('instructor/crear_sede', ['logueado'=>$logueado]);
		}
	}

	public function editarSede($idSede)
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));
		$sede = $this->sedeModel->obtenerInfo($idSede);

		if ($this->input->post()) {
			$this->form_validation->set_rules('nombre_sede', 'nombre de sede', 'required');
			$this->form_validation->set_rules('ubicacion', 'ubicación', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				$nombre = $this->input->post('nombre_sede');
				$ubicacion = $this->input->post('ubicacion');
				$esActivo = $this->input->post('es_activo');

				if ($this->sedeModel->editar($nombre, $ubicacion, $esActivo, $idSede)) {
					$this->session->set_flashdata('mensaje', 'Sede añadida correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible añadir datos de Sede');
				}

				return redirect('instructor/sedes');
			} else {
				$this->load->view('instructor/editar_sede', ['logueado'=>$logueado, 'sede'=>$sede]);
			}
		} else {
			$this->load->view('instructor/editar_sede', ['logueado'=>$logueado, 'sede'=>$sede]);
		}
	}

}

/* End of file instructor.php */
/* Location: ./application/controllers/instructor.php */