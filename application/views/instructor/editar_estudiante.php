<?php include_once('header.php') ?>
<div class="container">
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<div class="alert alert-dismissible alert-danger">
			<?=$mensaje; ?>
		</div>
	<?php endif; ?>
	<h1>Editar estudiante</h1>
	<?=form_open(base_url()."instructor/editarEstudiante/{$usuario->id_usuario}", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <legend>Información de usuario</legend>
	    <div class="form-group">
	      <label for="">Correo electrónico *</label>
	      <?=form_input(['name'=>'correo_electronico', 'class'=>'form-control', 'value'=>$usuario->correo_electronico]); ?>
	      <?=form_error('correo_electronico', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <legend>Información personal</legend>
	    <div class="form-group">
	    	<label for="">Identificación *</label>
	    	<?=form_input(['name'=>'id_individuo', 'class'=>'form-control', 'value'=>$individuo->id_individuo]); ?>
	    	<?=form_error('id_individuo', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
	    	<label for="">Nombre *</label>
	    	<?=form_input(['name'=>'nombre', 'class'=>'form-control', 'value'=>$individuo->nombre]); ?>
	    	<?=form_error('nombre', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Primer Apellido *</label>
	    	<?=form_input(['name'=>'apellido1', 'class'=>'form-control', 'value'=>$individuo->apellido1]); ?>
	    	<?=form_error('apellido1', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Segundo Apellido</label>
	    	<?=form_input(['name'=>'apellido2', 'class'=>'form-control', 'value'=>$individuo->apellido2]); ?>
	    	<?=form_error('apellido2', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Fecha de nacimiento *</label>
	    	<?=form_input(['name'=>'fecha_nacimiento', 'class'=>'form-control', 'type'=>'date', 'value'=>$individuo->fecha_nacimiento]); ?>
	    	<?=form_error('fecha_nacimiento', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
			<label for="">Nacionalidad *</label>
			<?=form_input(['name'=>'nacionalidad', 'class'=>'form-control', 'value'=>$individuo->nacionalidad]); ?>
			<?=form_error('nacionalidad', '<div class="text-danger">','</div>'); ?>
		</div>
		<div class="form-group">
	    	<label for="">Condición médica</label>
	    	<?=form_input(['name'=>'condicion_medica', 'class'=>'form-control', 'value'=>$individuo->condicion_medica]); ?>
	    	<?=form_error('condicion_medica', '<div class="text-danger">','</div>'); ?>
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
	    	<select name="activo" class="form-control custom-select">
	    		<option value="1">Sí</option>
	    		<option value="0">No</option>
	    	</select>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Insertar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<script>
	// Selecciona automaticamente el nivel que tenga el estudiante en la lista de niveles
	var nivelKmg = document.getElementById('nivelKmg').value;
	document.getElementById('listaNiveles').value = nivelKmg;
</script>
<?php include_once('footer.php') ?>