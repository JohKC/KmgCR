<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Paquete añadido correctamente' || $mensaje == 'Paquete editado correctamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No es posible añadir datos de paquete' || $mensaje == 'No es posible editar datos de paquete'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<h3>Lista de paquetes</h3>

	<?php echo anchor('instructor/nuevoPaquete', 'Agregar nuevo paquete', ['class'=>'btn btn-primary']); ?>
	<hr>
		<div class="row">
			<div class="col-md-5">
				<input type="text" id="busqueda" placeholder="Buscar..." class="form-control">
			</div>
		</div>
		<hr>
		<table class="table table-hover tabla_estudiantes" id="tabla">
		  <thead>
		    <tr>
		      <th scope="col">Tipo de paquete</th>
		      <th scope="col">Cantidad de clases</th>
		      <th scope="col">Precio</th>
		      <th scope="col">Opciones</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (count($listaPaquetes)): ?>
		  		<?php foreach ($listaPaquetes as $item): ?>
			    <tr class="table-light">
			    	<td><?=$item->nombre_paquete ?></td>
			      	<td><?=$item->cantidad_clases?></td>
			      	<td><?=$item->monto_precio ?></td>
			      	
			        <td>
			      	<?php echo anchor("instructor/editarPaquete/{$item->id_paquete}", 'Editar', ['class'=>'btn btn-success']); ?>
			      </td>

			    </tr>
			<?php endforeach; ?>
		    <?php endif; ?>
		  </tbody>
		</table> 

		<!-- Tarjetas responsive, se muestran al reducir tamaño de pagina -->
		<?php if (count($listaPaquetes)): ?>
			<hr>
			<?php foreach ($listaPaquetes as $item): ?>
				<div style="border: none;" class="card border-secondary mb-3 info_estudiantes" id="contenido">
				  <div id="contenido">
						<div class="card-header">Tipo de paquete

					  	<?php echo anchor("instructor/editarPaquete/{$item->id_paquete}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
					  </div>
					  <div class="card-body" id="">
					    <h4 class="card-title"><?=$item->nombre_paquete ?></h4>
					    Cantidad de clases: <?=$item->cantidad_clases ?><br>
					    Precio: <?=$item->monto_precio ?><br>
					  </div>
				  </div>
				</div>
			<?php endforeach; ?>
			<?php else: ?>
				<h3>No se encontraron resultados.</h3>
			<?php endif; ?>
</div>
<script>
// Permite filtrar los resultados de las tablas, al escribir en el campo de busqueda
$(document).ready(function(){
  $("#busqueda").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabla tbody tr, #contenido #contenido").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?php include_once('footer.php') ?>