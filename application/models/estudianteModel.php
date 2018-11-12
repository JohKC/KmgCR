<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EstudianteModel extends CI_Model {

	public function existeEstudiante($idIndividuo)
	{
		$query = $this->db->query("SELECT * FROM T_ESTUDIANTE WHERE id_individuo = '$idIndividuo';");

		// $log1 = fopen("logExiste.txt", "w") or die("Unable to open file!");
		// $txt = $this->db->last_query();
		// fwrite($log1, $txt);
		// fclose($log1);

		if (($query->num_rows() > 0)) {
			return true;
		} else {
			return false;
		}
	}

	public function estaActivo($idIndividuo)
	{
		$query = $this->db->query("SELECT * FROM T_ESTUDIANTE WHERE id_individuo = '$idIndividuo' AND es_activo = 1;");

		// $log1 = fopen("logExiste.txt", "w") or die("Unable to open file!");
		// $txt = $this->db->last_query();
		// fwrite($log1, $txt);
		// fclose($log1);

		if (($query->num_rows() > 0)) {
			return true;
		} else {
			return false;
		}
	}

	public function obtenerInfo($idUsuario)
	{
		$query = $this->db->query("SELECT E.id_estudiante, E.fecha_inscripcion, E.nivel_kmg, E.es_activo FROM t_usuario U 
			INNER JOIN t_individuo I ON U.id_usuario = I.id_usuario
			INNER JOIN t_estudiante E ON I.id_individuo = E.id_individuo WHERE U.id_usuario = $idUsuario;");

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function obtenerInfoPaquetes($idEstudiante)
	{
		$query = $this->db->query("SELECT II.nombre, II.apellido1, S.nombre_sede, P.nombre_paquete, P.cantidad_clases, EP.fecha_inicio, EP.dias_restantes, EP.asistencias, EP.es_activo, DATE_FORMAT(EP.fecha_inicio, '%d/%m/%Y') AS fecha_ini FROM T_ESTUDIANTE_PAQUETE EP
			INNER JOIN t_instructor INS ON EP.id_instructor = INS.id_instructor
			INNER JOIN t_sede S ON EP.id_sede = S.id_sede
			INNER JOIN t_paquete P ON EP.id_paquete = P.id_paquete
			INNER JOIN t_individuo II ON INS.id_individuo = II.id_individuo
			where EP.id_estudiante = $idEstudiante AND S.es_activo = 1;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function obtenerListaEstudiantes()
	{
		$query = $this->db->query("SELECT I.nombre, I.apellido1, I.apellido2, I.id_individuo, E.id_estudiante FROM T_ESTUDIANTE E INNER JOIN T_INDIVIDUO I ON E.id_individuo = I.id_individuo;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function seleccionar()
	{
		$query = $this->db->query("SELECT * FROM T_ESTUDIANTE;");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function insertar($idIndividuo, $esActivo)
	{
		$this->db->query("INSERT INTO T_ESTUDIANTE VALUES (null, NOW(), 'Aspirante', $esActivo, '$idIndividuo');");

		$error = $this->db->error();

		// return $error['message'] . ' ' . $this->db->last_query() . '<br>';

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function editar($idIndividuo, $fechaInsc, $nivelKmg, $activo)
	{
		$this->db->query("UPDATE T_ESTUDIANTE SET fecha_inscripcion = '$fechaInsc', nivel_kmg = '$nivelKmg', es_activo = $activo WHERE id_individuo = '$idIndividuo';");

		$error = $this->db->error();

		// $log = fopen("logEstudiante.txt", "w") or die("Unable to open file!");
		// $txt = $error['message'] . '<br>' . $this->db->last_query() . '<br>';
		// fwrite($log, $txt);
		// fclose($log);

		// return $error['message'] . ' ' . $this->db->last_query() . '<br>';

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function editarEstudianteInstructor($idIndividuo, $esActivo)
	{
		$this->db->query("UPDATE T_ESTUDIANTE SET es_activo = $esActivo WHERE id_individuo = '$idIndividuo';");

		$error = $this->db->error();

		// return $error['message'] . ' ' . $this->db->last_query() . '<br>';

		$error = $this->db->error();

		// $log1 = fopen("log.txt", "w") or die("Unable to open file!");
		// $txt = $this->db->last_query() . '<br>';
		// fwrite($log1, $txt);
		// fclose($log1);

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

}

/* End of file estudianteModel.php */
/* Location: ./application/models/estudianteModel.php */