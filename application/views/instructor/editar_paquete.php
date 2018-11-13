<?php include_once('header.php') ?>
<div class="container">
	<h1>Editar paquete</h1>
	<?=form_open(base_url()."instructor/editarPaquete/{$paquete->id_paquete}", ['class'=>'form-horizontal']); ?>
	  <fieldset>
	    <div class="form-group">
	    	<label for="">Nombre del paquete *</label>
	    	<?=form_input(['name'=>'nombre_paquete', 'class'=>'form-control', 'value'=>$paquete->nombre_paquete]); ?>
	    	<?=form_error('nombre_paquete', '<div class="text-danger">','</div>'); ?>
	    </div>
		<div class="form-group">
	    	<label for="">Cantidad de clases *</label>
	    	<?=form_input(['name'=>'cantidad_clases', 'class'=>'form-control', 'type'=>'number', 'value'=>$paquete->cantidad_clases]); ?>
	    	<?=form_error('cantidad_clases', '<div class="text-danger">','</div>'); ?>
	    </div>
	    <div class="form-group">
	    	<label for="">Precio *</label>
	    	<?=form_input(['name'=>'monto_precio', 'class'=>'form-control', 'type'=>'number', 'value'=>$paquete->monto_precio, 'step'=>'.01', 'min'=>'0']); ?>
	    	<?=form_error('monto_precio', '<div class="text-danger">','</div>'); ?>
	    </div>
	    </fieldset>
	    <?=form_submit(['name'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary']); ?>
	  </fieldset>
	<?=form_close(); ?>
</div>
<?php include_once('footer.php') ?>