<?php include_once('header.php') ?>
<div class="container">
	<h1>Nuevo paquete de estudiante</h1>
	<?=form_open(base_url()."instructor/asignarPaquete", ['class'=>'form-horizontal']); ?>
	  <fieldset>
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
	    	<?=form_input(['name'=>'fecha_inicio', 'class'=>'form-control', 'type'=>'date']); ?>
	    	<?=form_error('fecha_inicio', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Paquete pagado</label>
	    	<select name="es_pagado" class="form-control custom-select">
	    		<option value="1">Sí</option>
	    		<option value="0">No</option>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Paquete activo</label>
	    	<select name="es_activo" class="form-control custom-select">
	    		<option value="1">Sí</option>
	    		<option value="0">No</option>
	    	</select>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<?php include_once('footer.php') ?>