<?php include_once('header.php') ?>
<div class="container">
	<h1>Editar sede</h1>
	<?=form_open(base_url()."instructor/editarSede/{$sede->id_sede}", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	  	<input type="hidden" id="esActivo" value="<?=$sede->es_activo ?>">
	    <div class="form-group">
	    	<label for="">Nombre de sede *</label>
	    	<?=form_input(['name'=>'nombre_sede', 'class'=>'form-control', 'value'=>$sede->nombre_sede]); ?>
	    	<?=form_error('nombre_sede', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
	    	<label for="">Ubicación *</label>
	    	<?=form_input(['name'=>'ubicacion', 'class'=>'form-control', 'value'=>$sede->ubicacion]); ?>
	    	<?=form_error('ubicacion', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Sede activa</label>
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
	var esActivo = document.getElementById('esActivo').value;
	document.getElementById('activo').value = esActivo;
</script>
<?php include_once('footer.php') ?>