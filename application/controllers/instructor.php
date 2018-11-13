<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends CI_Controller {

	// Constructor del controlador, carga modelos y librerías de Codeigniter esenciales
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
		$this->load->database('default'); // Carga la base de datos
	}


	// Interfaz de instructor
	public function index()
	{
		// Procura que la sesion este activa con el rol correspondiente
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}


		// Datos del usuario logueado
		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		// Si el instructor es estudiante, se cargara el perfil de estudiante
		$existeEstudiante = $this->estudianteModel->existeEstudiante($logueado->id_individuo);

		if ($existeEstudiante) { // Si es estudiante, cargar informacion de estudiante
			$estudiante = $this->estudianteModel->obtenerInfo($this->session->userdata('id_usuario'));
			$infoPaquetes = $this->estudianteModel->obtenerInfoPaquetes($estudiante->id_estudiante);

			// Si esta logueado, que muestre la pantalla principal de instructor al cargar la pantalla principal
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
		
	}

	// Interfaz de usuarios
	public function usuarios()
	{
		// Mantiene la sesion abierta
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		// Datos del usuario logueado
		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		// Carga la lista de todos los usuarios, para mostrarlos en la tabla
		$listaUsuarios = $this->individuoModel->obtenerListaIndividuos();

		// Carga la vista con todos los datos suministrados
		$this->load->view('instructor/lista_usuarios', ['logueado'=>$logueado, 'listaUsuarios'=>$listaUsuarios]);
	}

	// Para crear un nuevo usuario
	public function nuevoUsuario()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		// Si se presionó el botón de submit, se hará lo siguiente
		if ($this->input->post()) {

			// Procura que los campos de texto no estén vacios
			$this->form_validation->set_rules('correo_electronico', 'correo electronico', 'required');
			$this->form_validation->set_rules('id_individuo', 'identificacion', 'required');
			$this->form_validation->set_rules('nombre', 'nombre', 'required');
			$this->form_validation->set_rules('apellido1', 'primer apellido', 'required');
			$this->form_validation->set_rules('nacionalidad', 'nacionalidad', 'required');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required');
			// Mensaje de advertencia, por si no se llena un campo de texto
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			// Si se llenaron todos los campos, hacer lo siguiente
			if ($this->form_validation->run()) {
				// Capturan los datos de los campos de texto
				$correo = $this->input->post('correo_electronico');
				$id = $this->input->post('id_individuo');
				$nombre = $this->input->post('nombre');
				$apellido1 = $this->input->post('apellido1');
				$apellido2 = $this->input->post('apellido2');
				$fechaNac = $this->input->post('fecha_nacimiento');
				$nacionalidad = $this->input->post('nacionalidad');
				$condicion = $this->input->post('condicion_medica');

				// Verifica que exista el individuo en la base de datos
				$existe = $this->individuoModel->existe($correo, $id);

				if ($existe == FALSE) { // Si el individuo no existe, crearlo
					$contraDefecto = "1234"; // Contrasena por defecto
					$contraEncriptada = password_hash($contraDefecto, PASSWORD_DEFAULT);

					$this->usuarioModel->insertar($correo, $contraEncriptada, 3);
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
				$restablecerContra = $this->input->post('restablecerContra');

				$idRol = 3; // Rol genérico, que impedirá que se inicie sesión

				if ($esInstructor == 1 && $esEstudiante == 1) {
					$idRol = 1; // Si es instructor y estudiante, tendra el rol 1 para login
				} elseif ($esInstructor == 1 && $esEstudiante == 0) {
					$idRol = 1; // Si es instructor pero NO estudiante, tendra el rol 1 para login
				} elseif ($esInstructor == 0 && $esEstudiante == 1) {
					$idRol = 2; // Si solo es estudiante, tendra el rol 2 para login
				}


				if ($this->usuarioModel->editar($idUsuario, $correo, $idRol)) {
					// Si se pidio restablecer la contraseña, asignar contraseña por defecto (1234)
					if ($restablecerContra == 1) {
						$hash = password_hash("1234", PASSWORD_DEFAULT);
						$this->usuarioModel->cambiarContrasena($idUsuario, $hash);
					}

					if ($this->individuoModel->editar($id, $nombre, $apellido1, $apellido2, $nacionalidad, $condicion, $fechaNac)) {

						// Si el usuario no es estudiante, pero lo será
						if ($existeEstudiante == FALSE) {
							if ($esEstudiante == 1) {
								// insertar estudiante
								$this->estudianteModel->insertar($id, 1);
							}
						}

						// Si el usuario no es instructor, pero lo será
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
	public function editarEstudiante($idUsuario) // Se recibe como parametro el id del usuario a editar
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
				$correo = $this->input->post('correo_electronico');
				$activo = $this->input->post('activo');

				if ($this->estudianteModel->editar($id, $fechaInsc, $nivelKmg, $activo)) {
					// Si el estudiante se inactivará pero es instructor:
					if ($activo == 0 && $this->instructorModel->existeInstructor($id)) {
						if ($this->instructorModel->estaActivo($id)) {
							// Si es instructor activo, quedará con rol de instructor
							$this->usuarioModel->editar($idUsuario, $correo, 1);
						} else {
							// Si no es instructor activo, quedará con rol genérico
							$this->usuarioModel->editar($idUsuario, $correo, 3);
						}
					}  elseif ($activo == 1 && $this->instructorModel->existeInstructor($id)) {
						if ($this->instructorModel->estaActivo($id)) {
							// Si es instructor activo, quedará con rol de instructor
							$this->usuarioModel->editar($idUsuario, $correo, 1);
						} else {
							// Si no es instructor activo, quedará con rol de estudiante
							$this->usuarioModel->editar($idUsuario, $correo, 2);
						}
					} elseif ($activo == 0 && $this->instructorModel->existeInstructor($id) == FALSE) {
						$this->usuarioModel->editar($idUsuario, $correo, 3);
					} else {
						$this->usuarioModel->editar($idUsuario, $correo, 2);
					}
					$this->session->set_flashdata('mensaje', 'Estudiante editado correctamente');
				} else {
					$this->session->set_flashdata('mensaje', 'No es posible editar datos de instructor');
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

		// Suma una asistencia (asistencia = asistencia + 1)
		$suma = $this->instructorModel->sumarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio);

		if ($suma) {
			$this->session->set_flashdata('mensaje', 'Asistencia añadida');
		} else {
			$this->session->set_flashdata('mensaje', 'No se pudo añadir la asistencia');
		}

		$this->asistencias(); // Carga la interfaz de asistencias
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

	// Asisgna un nuevo paquete a estudiante
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
			$diasRestantes = $this->input->post('dias_restantes');
			$esActivo = $this->input->post('es_activo'); 
			$esPagado = $this->input->post('es_pagado'); 

			$this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio.');

			if ($this->form_validation->run()) {
				// Si existen paquetes no pagados, no podra asignar uno nuevo
				if ($this->instructorModel->verificarNoPagados($idEstudiante) == FALSE) {
					// Verifica que no hayan paquetes activos del estudiante
					if ($this->instructorModel->verificarPaqueteActivo($idInstructor, $idEstudiante, $idSede) == FALSE) {
						if ($this->instructorModel->crearPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $esActivo, $esPagado, $diasRestantes)) {
							$this->session->set_flashdata('mensaje', 'Paquete asignado correctamente');
						} else {
							$this->session->set_flashdata('mensaje', 'No se pudo asignar el paquete');
						}
					} else {
						$this->session->set_flashdata('mensaje', 'Ya existe un paquete activo con el mismo estudiante, sede e instructor');
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
				$correo = $this->input->post('correo_electronico');
				$activo = $this->input->post('es_activo');

				if ($this->instructorModel->editar($id, $fechaInicio, $activo)) {

					if ($activo == 0 && $this->estudianteModel->existeEstudiante($id)) {
						if ($this->estudianteModel->estaActivo($id)) {
							// Si se inactivara al instructor, pero es estudiante, entonces que solo se muestre la interfaz de estudiante
							$this->usuarioModel->editar($idUsuario, $correo, 2);
						} else {
							// Si se inactivara al instructor, y no es estudiante, que se le asigne el rol generico 3
							$this->usuarioModel->editar($idUsuario, $correo, 3);
						}
					} elseif ($activo == 0 && $this->estudianteModel->existeEstudiante($id) == FALSE) {
						$this->usuarioModel->editar($idUsuario, $correo, 3);
					} else {
						$this->usuarioModel->editar($idUsuario, $correo, 1);
					}
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

	// Interfaz de paquetes
	public function paquetes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		// Carga la lista de paquetes disponibles
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

	// Edita informacion de un paquete
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

	// Interfaz de sedes
	public function sedes()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}

		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

		$listaSedes = $this->sedeModel->seleccionar();

		$this->load->view('instructor/lista_sedes', ['logueado'=>$logueado, 'listaSedes'=>$listaSedes]);
	}

	// Crear nueva sede
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

	// Editar sede
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

	// Para cambiar la contraseña
	public function configuracion()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != 1) {
			redirect(base_url().'login');
		}


		$logueado = $this->individuoModel->obtenerInfo($this->session->userdata('id_usuario'));

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

					return redirect('instructor/configuracion');
				} else {
					$this->session->set_flashdata('mensaje', 'La contraseñas no coinciden');
					return redirect('instructor/configuracion');
				}


			} else {
				$this->load->view('instructor/configuracion', ['logueado'=>$logueado]);
			}

		} else {
			$this->load->view('instructor/configuracion', ['logueado'=>$logueado]);
		}		
	}

}

/* End of file instructor.php */
/* Location: ./application/controllers/instructor.php */