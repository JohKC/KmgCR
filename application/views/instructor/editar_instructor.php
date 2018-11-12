<?php include_once('header.php') ?>
<div class="container">
	<h1>Editar instructor</h1>
	<?=form_open(base_url()."instructor/editarInstructor/{$usuario->id_usuario}", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <legend>Información personal</legend>
	    <div class="form-group">
	    	<label for="">Identificación: <?=$individuo->id_individuo ?></label>
	    	<?=form_input(['name'=>'id_individuo', 'class'=>'form-control', 'value'=>$individuo->id_individuo, 'type'=>'hidden']); ?>
	    </div>
	    <div class="form-group">
	      <label for="">Nombre de instructor: <?=$individuo->nombre . ' ' . $individuo->apellido1 . ' ' . $individuo->apellido2 ?></label>
	    </div>

	    <legend>Información de instructor</legend>
	    <div class="form-group">
	    	<label for="">Fecha de inicio *</label>
	    	<?=form_input(['name'=>'fecha_inicio', 'class'=>'form-control', 'type'=>'date', 'value'=>$instructor->fecha_inicio]); ?>
	    	<?=form_error('fecha_inicio', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Instructor activo</label>
	    	<select name="es_activo" class="form-control">
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