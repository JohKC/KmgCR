<?php include_once('header.php') ?>
<div class="container">
	<h1>Nueva sede</h1>
	<?=form_open(base_url().'instructor/nuevaSede', ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <div class="form-group">
	    	<label for="">Nombre de sede *</label>
	    	<?=form_input(['name'=>'nombre_sede', 'class'=>'form-control']); ?>
	    	<?=form_error('nombre_sede', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
	    	<label for="">Ubicación *</label>
	    	<?=form_input(['name'=>'ubicacion', 'class'=>'form-control', 'type'=>'text']); ?>
	    	<?=form_error('ubicacion', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Sede activa</label>
	    	<select name="es_activo" class="form-control custom-select">
	    		<option value="1">Sí</option>
	    		<option value="0">No</option>
	    	</select>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Insertar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<?php include_once('footer.php') ?>