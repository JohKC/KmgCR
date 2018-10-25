<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Instructor añadido correctamente' || $mensaje == 'Instructor editado correctamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No es posible añadir datos de instructor' || $mensaje == 'No es posible editar datos de instructor'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<h3>Lista de instructores</h3>
	<input type="text" id="busqueda" placeholder="Buscar..." class="form-control">

	<hr>
		<table class="table table-hover tabla_estudiantes small" id="tabla">
		  <thead>
		    <tr>
		      <th scope="col">Identificación</th>
		      <th scope="col">Nombre</th>
		      <th scope="col">Correo electrónico</th>
		      <th scope="col">Fecha de inscripción</th>
		      <th scope="col">Activo</th>
		      <th scope="col">Fecha de nacimiento</th>
		      <th scope="col">Nacionalidad</th>
		      <th scope="col">Opciones</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (count($listaInstructores)): ?>
		  		<?php foreach ($listaInstructores as $item): ?>
			    <tr class="table-light">
			    	<td><?=$item->id_individuo ?></td>
			      	<td><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></td>
			      	<td><?=$item->correo_electronico?></td>
			      	<td><?=$item->fecha_inicio ?></td>
			      	<td><?=$item->es_activo ?></td>
			      	<td><?=$item->fecha_nacimiento ?></td>
			      	<td><?=$item->nacionalidad ?></td>
			        <td>
			      	<?php echo anchor("instructor/editarInstructor/{$item->id_usuario}", 'Editar', ['class'=>'btn btn-success']); ?>
			      </td>

			    </tr>
			<?php endforeach; ?>
		    <?php endif; ?>
		  </tbody>
		</table> 

		<!-- Tarjetas responsive -->
		<?php if (count($listaInstructores)): ?>
			<?php foreach ($listaInstructores as $item): ?>
				<div style="border: none;" class="card border-secondary mb-3 info_estudiantes" id="contenido">
				  <div id="contenido">
					  <div class="card-header">Identificación: <?=$item->id_individuo ?>
					  <?php echo anchor("instructor/editarInstructor/{$item->id_usuario}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
					  </div>
					  <div class="card-body">
					    <h4 class="card-title"><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></h4>
					    Correo electrónico: <?=$item->correo_electronico ?><br>
					    Fecha de inicio: <?=$item->fecha_inicio ?><br>
					    Activo: <?=$item->es_activo ?><br>
					    Nacionalidad: <?=$item->nacionalidad ?><br>
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
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});
</script>
<?php include_once('footer.php') ?>