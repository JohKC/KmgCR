<?php include_once('header.php') ?>
<div class="container">
	<h1>Nuevo estudiante</h1>
	<?=form_open(base_url().'instructor/nuevoEstudiante', ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <legend>Información de usuario</legend>
	    <div class="form-group">
	      <label for="">Correo electrónico *</label>
	      <?=form_input(['name'=>'correo_electronico', 'class'=>'form-control']); ?>
	      <?=form_error('correo_electronico', '<div class="text-danger">','</div>'); ?>
	    </div>

	    <legend>Información personal</legend>
	    <div class="form-group">
	    	<label for="">Identificación *</label>
	    	<?=form_input(['name'=>'id_individuo', 'class'=>'form-control']); ?>
	    	<?=form_error('id_individuo', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
	    	<label for="">Nombre *</label>
	    	<?=form_input(['name'=>'nombre', 'class'=>'form-control']); ?>
	    	<?=form_error('nombre', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Primer Apellido *</label>
	    	<?=form_input(['name'=>'apellido1', 'class'=>'form-control']); ?>
	    	<?=form_error('apellido1', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Segundo Apellido</label>
	    	<?=form_input(['name'=>'apellido2', 'class'=>'form-control']); ?>
	    	<?=form_error('apellido2', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Fecha de nacimiento *</label>
	    	<?=form_input(['name'=>'fecha_nacimiento', 'class'=>'form-control', 'type'=>'date']); ?>
	    	<?=form_error('fecha_nacimiento', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
			<label for="">Nacionalidad *</label>
			<?=form_input(['name'=>'nacionalidad', 'class'=>'form-control']); ?>
			<?=form_error('nacionalidad', '<div class="text-danger">','</div>'); ?>
		</div>
		<div class="form-group">
	    	<label for="">Condición médica</label>
	    	<?=form_input(['name'=>'condicion_medica', 'class'=>'form-control']); ?>
	    	<?=form_error('condicion_medica', '<div class="text-danger">','</div>'); ?>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Insertar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<?php include_once('footer.php') ?>