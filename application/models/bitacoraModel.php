<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BitacoraModel extends CI_Model {

	public function insertar($nombreInstructor, $nombreEstudiante, $nombreSede, $nombrePaquete, $fechaInicio, $mensaje)
	{
		$this->db->query("INSERT INTO t_bitacora VALUES (null, '$nombreInstructor', '$nombreEstudiante', '$nombreSede', '$nombrePaquete', '$fechaInicio', NOW(), '$mensaje');");

		$error = $this->db->error();

		if ($error['message'] == '') {
			return true;
		} else {
			return false;
		}
	}

	public function seleccionarEspecifico($nombreInstructor, $nombreEstudiante, $nombreSede, $nombrePaquete, $fechaInicio)
	{
		$query = $this->db->query("SELECT id_bitacora, nombre_instructor, nombre_estudiante, nombre_sede, nombre_paquete, DATE_FORMAT(fecha_inicio, '%d/%m/%Y') AS fecha_inicio, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, descripcion FROM T_BITACORA WHERE nombre_instructor = '$nombreInstructor' AND nombre_estudiante = '$nombreEstudiante' AND nombre_sede = '$nombreSede' AND nombre_paquete = '$nombrePaquete' AND fecha_inicio = '$fechaInicio' ORDER BY id_bitacora DESC;");

		return $query->result();
	}
}

/* End of file bitacoraModel.php */
/* Location: ./application/models/bitacoraModel.php */