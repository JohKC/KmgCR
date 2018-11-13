<?php include_once('header.php') ?>
<div class="container">
	<h1>Nuevo paquete</h1>
	<?=form_open(base_url().'instructor/nuevoPaquete', ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <div class="form-group">
	    	<label for="">Nombre del paquete *</label>
	    	<?=form_input(['name'=>'nombre_paquete', 'class'=>'form-control']); ?>
	    	<?=form_error('nombre_paquete', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
	    	<label for="">Cantidad de clases *</label>
	    	<?=form_input(['name'=>'cantidad_clases', 'class'=>'form-control', 'type'=>'number']); ?>
	    	<?=form_error('cantidad_clases', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Precio *</label>
	    	<?=form_input(['name'=>'monto_precio', 'class'=>'form-control', 'type'=>'number', 'step'=>'.01', 'min'=>'0']); ?>
	    	<?=form_error('monto_precio', '<div class="text-danger">','</div>'); ?>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Insertar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<?php include_once('footer.php') ?>