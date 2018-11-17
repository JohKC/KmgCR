<?php include_once('header.php') ?>
<div class="container">
	<h1>Editar paquete de estudiante</h1>
	<?=form_open(base_url()."instructor/editarPaqueteEstudiante/{$infoActual->id_paquete}/{$infoActual->id_sede}/{$infoActual->id_estudiante}/{$infoActual->id_instructor}/{$infoActual->fecha_inicio}/{$infoActual->es_activo}/$estudiante->id_usuario", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	  	<input type="hidden" id="idEstudiante" value="<?=$infoActual->id_estudiante ?>">
	  	<input type="hidden" id="idInstructor" value="<?=$infoActual->id_instructor ?>">
	  	<input type="hidden" id="idPaquete" value="<?=$infoActual->id_paquete ?>">
	  	<input type="hidden" id="idSede" value="<?=$infoActual->id_sede ?>">
	  	<input type="hidden" id="esPagado" value="<?=$infoActual->es_pagado ?>">
	  	<input type="hidden" id="esActivo" value="<?=$infoActual->es_activo ?>">
	    <div class="form-group">
	    	<label for="">Estudiante</label>
	    	<select id="listaEstudiantes" name="id_estudiante" class="form-control custom-select">
	    		<?php foreach ($estudiantes as $item): ?>
	    			<option value="<?=$item->id_estudiante ?>"><?=$item->id_individuo . ' - ' . $item->nombre . ' ' . $item->apellido1 ?></option>
	    		<?php endforeach; ?>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Paquete</label>
	    	<select id="listaPaquetes" name="id_paquete" class="form-control custom-select">
	    		<?php foreach ($paquetes as $item): ?>
	    			<option value="<?=$item->id_paquete ?>"><?=$item->nombre_paquete ?></option>
	    		<?php endforeach; ?>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Instructor</label>
	    	<select id="listaInstructores" name="id_instructor" class="form-control custom-select">
	    		<?php foreach ($instructores as $item): ?>
	    			<option value="<?=$item->id_instructor ?>"><?=$item->id_individuo . ' - ' . $item->nombre . ' ' . $item->apellido1 ?></option>
	    		<?php endforeach; ?>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Sede</label>
	    	<select id="listaSedes" name="id_sede" class="form-control custom-select">
	    		<?php foreach ($sedes as $item): ?>
	    			<option value="<?=$item->id_sede ?>"><?=$item->nombre_sede ?></option>
	    		<?php endforeach; ?>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Fecha de inicio</label>
	    	<?=form_input(['name'=>'fecha_inicio', 'class'=>'form-control', 'type'=>'date', 'value'=>$infoActual->fecha_inicio]); ?>
	    	<?=form_error('fecha_inicio', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Días restantes</label>
	    	<?=form_input(['name'=>'dias_restantes', 'class'=>'form-control', 'type'=>'number', 'value'=>$infoActual->dias_restantes]); ?>
	    	<?=form_error('dias_restantes', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Asistencias</label>
	    	<?=form_input(['name'=>'asistencias', 'class'=>'form-control', 'type'=>'number', 'value'=>$infoActual->asistencias, 'min'=>'0', 'id'=>'asistencias']); ?>
	    	<?=form_error('asistencias', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <!-- Si el valor cambia a 1, se añadira a bitacora un cambio en asistencias -->
	    <input type="hidden" value="0" id="cambioAsistencia" name="cambio_asistencia">
	    <div class="form-group">
	    	<label for="">Paquete pagado</label>
	    	<select name="es_pagado" class="form-control custom-select" id="pagado">
	    		<option value="1">Sí</option>
	    		<option value="0">No</option>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Paquete activo</label>
	    	<select name="es_activo" class="form-control custom-select" id="activo">
	    		<option value="1">Sí</option>
	    		<option value="0">No</option>
	    	</select>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<script>
	// Obtiene los valores actuales y los coloca en los select, para evitar actualizaciones no deseadas
	var idEstudiante = document.getElementById('idEstudiante').value;
	var idInstructor = document.getElementById('idInstructor').value;
	var idSede = document.getElementById('idSede').value;
	var idPaquete = document.getElementById('idPaquete').value;
	var esPagado = document.getElementById('esPagado').value;
	var esActivo = document.getElementById('esActivo').value;
	document.getElementById('listaEstudiantes').value = idEstudiante;
	document.getElementById('listaPaquetes').value = idPaquete;
	document.getElementById('listaSedes').value = idSede;
	document.getElementById('listaInstructores').value = idInstructor;
	document.getElementById('pagado').value = esPagado;
	document.getElementById('activo').value = esActivo;

	// Verifica si el select de asistencias cambio, para añadir a la bitacora una modificacion de asistencias
	 $("#asistencias").on("change paste keyup", function() {
	   document.getElementById('cambioAsistencia').value = 1;
	});
</script>
<?php include_once('footer.php') ?>