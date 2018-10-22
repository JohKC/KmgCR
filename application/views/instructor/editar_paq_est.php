<?php include_once('header.php') ?>
<div class="container">
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<div class="alert alert-dismissible alert-danger">
			<?=$mensaje; ?>
		</div>
	<?php endif; ?>
	<h1>Editar paquete de estudiante</h1>
	<?=form_open(base_url()."instructor/editarPaqueteEstudiante/{$infoActual->id_paquete}/{$infoActual->id_sede}/{$infoActual->id_estudiante}/{$infoActual->id_instructor}", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	  	<input type="hidden" id="idEstudiante" value="<?=$infoActual->id_estudiante ?>">
	  	<input type="hidden" id="idInstructor" value="<?=$infoActual->id_instructor ?>">
	  	<input type="hidden" id="idPaquete" value="<?=$infoActual->id_paquete ?>">
	  	<input type="hidden" id="idSede" value="<?=$infoActual->id_sede ?>">
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
	    	<?=form_input(['name'=>'asistencias', 'class'=>'form-control', 'type'=>'number', 'value'=>$infoActual->asistencias]); ?>
	    	<?=form_error('asistencias', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Paquete activo</label>
	    	<select name="activo" class="form-control custom-select">
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
	// Selecciona automaticamente los id a las listas
	var idEstudiante = document.getElementById('idEstudiante').value;
	var idInstructor = document.getElementById('idInstructor').value;
	var idSede = document.getElementById('idSede').value;
	var idPaquete = document.getElementById('idPaquete').value;
	document.getElementById('listaEstudiantes').value = idEstudiante;
	document.getElementById('listaPaquetes').value = idPaquete;
	document.getElementById('listaSedes').value = idSede;
	document.getElementById('listaInstructores').value = idInstructor;
</script>
<?php include_once('footer.php') ?>