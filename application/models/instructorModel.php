<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstructorModel extends CI_Model {

	public function obtenerListaEstudiantes($idInstructor)
	{
		$query = $this->db->query("SELECT EP.id_estudiante, I.id_individuo, CONCAT(I.nombre, ' ', I.apellido1, ' ', I.apellido2) AS Estudiante, E.fecha_inscripcion, E.nivel_kmg, E.es_activo, I.fecha_nacimiento, I.nacionalidad, I.condicion_medica, U.id_usuario, U.correo_electronico, COUNT(EP.id_paquete) as 'paquetes'
			FROM t_estudiante_paquete EP
			INNER JOIN t_estudiante E ON EP.id_estudiante = E.id_estudiante
			INNER JOIN t_individuo I ON E.id_individuo = I.id_individuo
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
			INNER JOIN t_sede S ON EP.id_sede = S.id_sede
			WHERE EP.id_instructor = $idInstructor AND EP.es_activo = 1 AND S.es_activo = 1
            GROUP BY EP.id_estudiante;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function obtenerListaEstudiantesTotal()
	{
		$query = $this->db->query("SELECT E.id_estudiante, I.id_individuo, CONCAT(I.nombre, ' ', I.apellido1, ' ', I.apellido2) AS Estudiante, E.fecha_inscripcion, E.nivel_kmg, E.es_activo, I.fecha_nacimiento, I.nacionalidad, I.condicion_medica, U.id_usuario, U.correo_electronico
			FROM t_estudiante E
			INNER JOIN t_individuo I ON E.id_individuo = I.id_individuo
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
            GROUP BY E.id_estudiante;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function obtenerInfo($idIndividuo)
	{
		$query = $this->db->query("SELECT * FROM T_INSTRUCTOR WHERE id_individuo = $idIndividuo;");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function obtenerInfoAsistencias($idInstructor, $esActivo)
	{
		$query = $this->db->query("SELECT U.id_usuario, I.id_individuo, EP.id_estudiante, EP.id_instructor, EP.id_sede, EP.id_paquete, I.nombre, I.apellido1, I.apellido2, EP.fecha_inicio, EP.es_activo, P.cantidad_clases, EP.dias_restantes, EP.asistencias, S.nombre_sede, P.nombre_paquete
			FROM t_estudiante_paquete EP
			INNER JOIN t_estudiante E ON EP.id_estudiante = E.id_estudiante
			INNER JOIN t_individuo I ON E.id_individuo = I.id_individuo
			INNER JOIN t_sede S ON EP.id_sede = S.id_sede
			INNER JOIN t_paquete P ON EP.id_paquete = P.id_paquete
			INNER JOIN t_usuario U ON I.id_usuario = U.id_usuario
			WHERE EP.id_instructor = $idInstructor AND EP.es_activo = $esActivo AND S.es_activo = 1;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function sumarAsistencia($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		return $query = $this->db->query("UPDATE T_ESTUDIANTE_PAQUETE SET asistencias = (asistencias + 1) WHERE id_paquete = $idPaquete AND id_sede = $idSede AND id_estudiante = $idEstudiante AND id_instructor = $idInstructor AND fecha_inicio = '$fechaInicio'; ");
	}

	// Asignar un nuevo paquete a un estudiante
	public function crearPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		$this->db->query("INSERT INTO T_ESTUDIANTE_PAQUETE VALUES ($idEstudiante, $idPaquete, $idSede, $idInstructor, '$fechaInicio', 45, 0, 1);");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	// Actualizar los nuevos datos WHERE datos sean los antiguos
	public function editarPaqueteEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio, $diasRestantes, $asistencias, $esActivo, $idPaqAntiguo, $idSedeAntiguo, $idEstAntiguo, $idInstAntiguo, $fechaIniAntiguo)
	{
		$this->db->query("UPDATE T_ESTUDIANTE_PAQUETE SET id_paquete = $idPaquete, id_sede = $idSede, id_estudiante = $idEstudiante, id_instructor = $idInstructor, fecha_inicio = '$fechaInicio', dias_restantes = $diasRestantes, asistencias = $asistencias, es_activo = $esActivo WHERE id_paquete = $idPaqAntiguo AND id_sede = $idSedeAntiguo AND id_estudiante = $idEstAntiguo AND id_instructor = $idInstAntiguo AND fecha_inicio = '$fechaIniAntiguo'; ");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function obtenerPaqEstudiante($idPaquete, $idSede, $idEstudiante, $idInstructor, $fechaInicio)
	{
		$query = $this->db->query("SELECT * FROM T_ESTUDIANTE_PAQUETE WHERE id_paquete = $idPaquete AND id_sede = $idSede AND id_estudiante = $idEstudiante AND id_instructor = $idInstructor AND fecha_inicio = '$fechaInicio'; ");

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function obtenerListaInstructores()
	{
		$query = $this->db->query("SELECT I.nombre, I.apellido1, I.apellido2, I.id_individuo, Ins.id_instructor FROM T_INSTRUCTOR Ins INNER JOIN T_INDIVIDUO I ON Ins.id_individuo = I.id_individuo;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function seleccionar()
	{
		$query = $this->db->query("SELECT * FROM T_INSTRUCTOR;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}

/* End of file instructorModel.php */
/* Location: ./application/models/instructorModel.php */