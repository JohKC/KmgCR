<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstructorModel extends CI_Model {

	// Verifica que exista el instructor
	public function existeInstructor($idIndividuo)
	{
		$query = $this->db->query("SELECT * FROM T_INSTRUCTOR WHERE id_individuo = '$idIndividuo';");

		if (($query->num_rows() > 0)) {
			return true;
		} else {
			return false;
		}
	}

	// Verifica que el instructor este activo
	public function estaActivo($idIndividuo)
	{
		$query = $this->db->query("SELECT * FROM T_INSTRUCTOR WHERE id_individuo = '$idIndividuo' AND es_activo = 1;");

		if (($query->num_rows() > 0)) {
			return true;
		} else {
			return false;
		}
	}

	// Obtener lista de estudiantes que tienen un paquete con el instructor que esta logueado
	public function obtenerListaEstudiantes($idInstructor)
	{
		$query = $this->db->query("SELECT EP.id_estudiante, I.id_individuo, CONCAT(I.nombre, ' ', I.apellido1, ' ', I.apellido2) AS Estudiante, E.fecha_inscripcion, E.nivel_kmg, E.es_activo, I.fecha_nacimiento, I.nacionalidad, I.condicion_medica, U.id_usuario, U.correo_electronico, COUNT(EP.id_paquete) as 'paquetes'
			FROM t_estudiante_paquete EP
			INNER JOIN t_estudiante E ON EP.id_estudiante = E.id_estudiante
			INNER JOIN t_individuo I ON E.id_individuo = I.id_individuo
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
			INNER JOIN t_sede S ON EP.id_sede = S.id_sede
			WHERE EP.id_instructor = $idInstructor AND EP.es_activo = 1 AND S.es_activo = 1
            GROUP BY EP.id_estudiante
            ORDER BY E.fecha_inscripcion DESC;");

		$error = $this->db->error();

		return $query->result();
	}

	// Obtener lista total de estudiantes, para poder asignarles un paquete
	public function obtenerListaEstudiantesTotal()
	{
		$query = $this->db->query("SELECT E.id_estudiante, I.id_individuo, CONCAT(I.nombre, ' ', I.apellido1, ' ', I.apellido2) AS Estudiante, E.fecha_inscripcion, E.nivel_kmg, E.es_activo, I.fecha_nacimiento, I.nacionalidad, I.condicion_medica, U.id_usuario, U.correo_electronico
			FROM t_estudiante E
			INNER JOIN t_individuo I ON E.id_individuo = I.id_individuo
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
            GROUP BY E.id_estudiante
            ORDER BY E.fecha_inscripcion DESC;");

		return $query->result();
	}


	// Obtener lista de instructores
	public function obtenerListaInstructores()
	{
		$query = $this->db->query("SELECT Ins.id_instructor, I.id_individuo, I.nombre, I.apellido1, I.apellido2, Ins.fecha_inicio, Ins.es_activo, I.fecha_nacimiento, I.nacionalidad, I.condicion_medica, U.id_usuario, U.correo_electronico
			FROM t_instructor Ins
			INNER JOIN t_individuo I ON Ins.id_individuo = I.id_individuo
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
            GROUP BY Ins.id_instructor;");

		return $query->result();
	}

	// Obtener informacion de instructor
	public function obtenerInfo($idUsuario)
	{
		$query = $this->db->query("SELECT Ins.id_instructor, Ins.fecha_inicio, Ins.es_activo FROM t_usuario U 
			INNER JOIN t_individuo I ON U.id_usuario = I.id_usuario
			INNER JOIN t_instructor Ins ON I.id_individuo = Ins.id_individuo WHERE U.id_usuario = $idUsuario;");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	// Obtener informacion de paquetes y asistencias
	public function obtenerInfoAsistencias($idInstructor, $esActivo)
	{
		$query = $this->db->query("SELECT U.id_usuario, I.id_individuo, EP.id_estudiante, EP.id_instructor, EP.id_sede, EP.id_paquete, I.nombre, I.apellido1, I.apellido2, EP.fecha_inicio, DATE_ADD(EP.fecha_inicio, INTERVAL EP.dias_restantes DAY) as fecha_venc, EP.es_activo, P.cantidad_clases, EP.dias_restantes, EP.asistencias, S.nombre_sede, P.nombre_paquete, EP.es_pagado
			FROM t_estudiante_paquete EP
			INNER JOIN t_estudiante E ON EP.id_estudiante = E.id_estudiante
			INNER JOIN t_individuo I ON E.id_individuo = I.id_individuo
			INNER JOIN t_sede S ON EP.id_sede = S.id_sede
			INNER JOIN t_paquete P ON EP.id_paquete = P.id_paquete
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
			WHERE EP.id_instructor = $idInstructor AND EP.es_activo = $esActivo AND S.es_activo = 1
			ORDER BY EP.fecha_inicio DESC;");

		return $query->result();
	}

	// Asignar rapidamente una asistencia
	public function sumarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		return $query = $this->db->query("UPDATE T_ESTUDIANTE_PAQUETE SET asistencias = (asistencias + 1) WHERE id_paquete = $idPaquete AND id_sede = $idSede AND id_estudiante = $idEstudiante AND id_instructor = $idInstructor AND fecha_inicio = '$fechaInicio'; ");
	}


	// Averigua si existe un paquete activo, y en caso de no haber, se puede activar un paquete nuevo e inactivo
	public function verificarPaqueteActivo($idInstructor, $idEstudiante, $idSede)
	{
		$query = $this->db->query("SELECT id_estudiante, id_sede, id_instructor FROM t_estudiante_paquete WHERE id_estudiante = $idEstudiante AND id_sede = $idSede AND id_instructor = $idInstructor AND es_activo = 1;");

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Asignar un nuevo paquete a un estudiante
	public function crearPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $esActivo, $esPagado, $diasRestantes)
	{
		$this->db->query("INSERT INTO T_ESTUDIANTE_PAQUETE VALUES ($idEstudiante, $idPaquete, $idSede, $idInstructor, '$fechaInicio', $diasRestantes, 0, $esActivo, $esPagado);");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	// Actualizar los nuevos datos WHERE datos sean los antiguos
	public function editarPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $diasRestantes, $asistencias, $esActivo, $idPaqAntiguo, $idSedeAntiguo, $idEstAntiguo, $idInstAntiguo, $fechaIniAntiguo, $esPagado)
	{
		$this->db->query("UPDATE T_ESTUDIANTE_PAQUETE SET id_paquete = $idPaquete, id_sede = $idSede, id_estudiante = $idEstudiante, id_instructor = $idInstructor, fecha_inicio = '$fechaInicio', dias_restantes = $diasRestantes, asistencias = $asistencias, es_activo = $esActivo, es_pagado = $esPagado WHERE id_paquete = $idPaqAntiguo AND id_sede = $idSedeAntiguo AND id_estudiante = $idEstAntiguo AND id_instructor = $idInstAntiguo AND fecha_inicio = '$fechaIniAntiguo'; ");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	// Obtener paquete de estudiante
	public function obtenerPaqEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		$query = $this->db->query("SELECT * FROM T_ESTUDIANTE_PAQUETE WHERE id_paquete = $idPaquete AND id_sede = $idSede AND id_estudiante = $idEstudiante AND id_instructor = $idInstructor AND fecha_inicio = '$fechaInicio'; ");

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	// Verificar si hay paquetes no pagados de estudiante
	public function verificarNoPagados($idEstudiante)
	{
		$query = $this->db->query("SELECT * FROM t_estudiante_paquete WHERE es_pagado = 0 AND id_estudiante = $idEstudiante;");

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function insertar($idIndividuo, $esActivo)
	{
		$this->db->query("INSERT INTO T_INSTRUCTOR VALUES (null, NOW(), $esActivo, '$idIndividuo');");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function editar($idIndividuo, $fechaInicio, $activo)
	{
		$this->db->query("UPDATE T_INSTRUCTOR SET fecha_inicio = '$fechaInicio', es_activo = $activo WHERE id_individuo = '$idIndividuo';");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

}

/* End of file instructorModel.php */
/* Location: ./application/models/instructorModel.php */