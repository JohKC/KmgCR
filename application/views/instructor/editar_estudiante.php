<?php include_once('header.php') ?>
<div class="container">
	<h1>Editar estudiante</h1>
	<?=form_open(base_url()."instructor/editarEstudiante/{$usuario->id_usuario}", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <legend>Información personal</legend>
	    <div class="form-group">
	    	<label for="">Identificación: <?=$individuo->id_individuo ?></label>
	    	<?=form_input(['name'=>'id_individuo', 'class'=>'form-control', 'value'=>$individuo->id_individuo, 'type'=>'hidden']); ?>
	    	<?=form_input(['name'=>'correo_electronico', 'class'=>'form-control', 'value'=>$usuario->correo_electronico, 'type'=>'hidden']); ?>
	    	<input type="hidden" id="esActivo" value="<?=$estudiante->es_activo ?>">
	    </div>
	    <div class="form-group">
	      <label for="">Nombre de estudiante: <?=$individuo->nombre . ' ' . $individuo->apellido1 . ' ' . $individuo->apellido2 ?></label>
	    </div>

	    <legend>Información de estudiante</legend>
	    <div class="form-group">
	    	<label for="">Fecha de inscripción *</label>
	    	<?=form_input(['name'=>'fecha_inscripcion', 'class'=>'form-control', 'type'=>'date', 'value'=>$estudiante->fecha_inscripcion]); ?>
	    	<?=form_error('fecha_inscripcion', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<input type="hidden" id="nivelKmg" value="<?=$estudiante->nivel_kmg ?>">
	    	<label for="">Nivel KMG * - <i>Nivel actual: <?=$estudiante->nivel_kmg ?></i></label>
	    	<select id="listaNiveles" name="nivel_kmg" class="form-control custom-select">
	    		<option value="Aspirante">Aspirante</option>
	    		<option value="P1">P1</option>
	    		<option value="P2">P2</option>
	    		<option value="P3">P3</option>
	    		<option value="P4">P4</option>
	    		<option value="P5">P5</option>
	    		<option value="G1">G1</option>
	    		<option value="G2">G2</option>
	    		<option value="G3">G3</option>
	    		<option value="G4">G4</option>
	    		<option value="G5">G5</option>
	    	</select>
	    </div>
	    <div class="form-group">
	    	<label for="">Estudiante activo</label>
	    	<select name="activo" class="form-control custom-select" id="activo">
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
	// Selecciona automaticamente el nivel que tenga el estudiante en la lista de niveles
	var nivelKmg = document.getElementById('nivelKmg').value;
	var esActivo = document.getElementById('esActivo').value;
	document.getElementById('listaNiveles').value = nivelKmg;
	document.getElementById('activo').value = esActivo;
</script>
<?php include_once('footer.php') ?>