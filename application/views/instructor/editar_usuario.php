<?php include_once('header.php') ?>
<div class="container">
	<h1>Editar usuario</h1>
	<?=form_open(base_url()."instructor/editarUsuario/{$usuario->id_usuario}", ['class'=>'form-horizontal']); ?>
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
	    	<p><?=$individuo->id_individuo ?></p>
	    	<?=form_input(['name'=>'id_individuo', 'class'=>'form-control', 'value'=>$individuo->id_individuo, 'type'=>'hidden']); ?>
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

	    <?php if ($existeEstudiante == FALSE && $existeInstructor == FALSE): ?>
	    	<legend>Información de estudiante e instructor</legend>
	    	<div class="form-group">
	    		<label for="">¿El usuario será estudiante?</label>
			    <select name="es_estudiante" class="form-control">
			    	<option value="0">No</option>
			    	<option value="1">Sí</option>
			    </select>
	    	</div>
	    	<div class="form-group">
	    		<label for="">¿El usuario será instructor?</label>
			    <select name="es_instructor" class="form-control">
			    	<option value="0">No</option>
			    	<option value="1">Sí</option>
			    </select>
	    	</div>
		<?php elseif ($existeEstudiante == FALSE && $existeInstructor == TRUE): ?>
			<legend>Información de estudiante</legend>
		    <div class="form-group">
	    		<label for="">¿El usuario será estudiante?</label>
			    <select name="es_estudiante" class="form-control">
			    	<option value="0">No</option>
			    	<option value="1">Sí</option>
			    </select>
	    	</div>
		<?php elseif ($existeEstudiante == TRUE && $existeInstructor == FALSE): ?>
			<div class="form-group">
	    		<label for="">¿El usuario será instructor?</label>
			    <select name="es_instructor" class="form-control">
			    	<option value="0">No</option>
			    	<option value="1">Sí</option>
			    </select>
	    	</div>
		<?php endif; ?>
	    <?=form_submit(['name'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<script>
	// Selecciona automaticamente el nivel que tenga el estudiante en la lista de niveles
	// var nivelKmg = document.getElementById('nivelKmg').value;
	// document.getElementById('listaNiveles').value = nivelKmg;
</script>
<?php include_once('footer.php') ?>