<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Sede añadida correctamente' || $mensaje == 'Sede editada correctamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No es posible añadir datos de sede' || $mensaje == 'No es posible editar datos de sede'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<h3>Lista de sedes</h3>

	<?php echo anchor('instructor/nuevaSede', 'Agregar nueva sede', ['class'=>'btn btn-primary']); ?>
	<hr>
		<input type="text" id="busqueda" placeholder="Buscar..." class="form-control">
		<table class="table table-hover tabla_estudiantes" id="tabla">
		  <thead>
		    <tr>
		      <th scope="col">Nombre de sede</th>
		      <th scope="col">Ubicación</th>
		      <th scope="col">Activa</th>
		      <th scope="col">Opciones</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (count($listaSedes)): ?>
		  		<?php foreach ($listaSedes as $item): ?>
			    <tr class="table-light">
			    	<td><?=$item->nombre_sede ?></td>
			      	<td><?=$item->ubicacion?></td>
			      	<td><?=$item->es_activo ?></td>
			      	
			        <td>
			      	<?php echo anchor("instructor/editarSede/{$item->id_sede}", 'Editar', ['class'=>'btn btn-success']); ?>
			      </td>

			    </tr>
			<?php endforeach; ?>
		    <?php endif; ?>
		  </tbody>
		</table> 

		<!-- Tarjetas responsive -->
		<?php if (count($listaSedes)): ?>
			<hr>
			<?php foreach ($listaSedes as $item): ?>
				<div style="border: none;" class="card border-secondary mb-3 info_estudiantes" id="contenido">
				  <div id="contenido">
						<div class="card-header">Tipo de sede

					  	<?php echo anchor("instructor/editarSede/{$item->id_sede}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
					  </div>
					  <div class="card-body" id="">
					    <h4 class="card-title"><?=$item->nombre_sede ?></h4>
					    Ubicación: <?=$item->ubicacion ?><br>
					    Activa: <?=$item->es_activo ?><br>
					  </div>
				  </div>
				</div>
			<?php endforeach; ?>
			<?php else: ?>
				<h3>No se encontraron resultados.</h3>
			<?php endif; ?>
</div>
<script>
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