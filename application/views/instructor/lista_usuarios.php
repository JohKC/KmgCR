<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Usuario añadido correctamente' || $mensaje == 'Usuario editado correctamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No es posible añadir datos de usuario' || $mensaje == 'No es posible editar datos de usuario'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<h3>Lista de usuarios</h3>

	<?php echo anchor('instructor/nuevoUsuario', 'Agregar nuevo usuario', ['class'=>'btn btn-primary']); ?>
	<hr>
		<input type="text" id="busqueda" placeholder="Buscar..." class="form-control">
		<table class="table table-hover tabla_estudiantes small" id="tabla">
		  <thead>
		    <tr>
		      <th scope="col">Identificación</th>
		      <th scope="col">Nombre</th>
		      <th scope="col">Correo electrónico</th>
		      <th scope="col">Nacionalidad</th>
		      <th scope="col">Condición médica</th>
		      <th scope="col">Fecha de nacimiento</th>
		      <th scope="col">Opciones</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (count($listaUsuarios)): ?>
		  		<?php foreach ($listaUsuarios as $item): ?>
			    <tr class="table-light">
			    	<td><?=$item->id_individuo ?></td>
			      	<td><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></td>
			      	<td><?=$item->correo_electronico?></td>
			      	<td><?=$item->nacionalidad ?></td>
			      	<td><?=$item->condicion_medica ?></td>
			      	<td><?=$item->fecha_nacimiento ?></td>
			      	
			        <td>
			      	<?php echo anchor("instructor/editarUsuario/{$item->id_usuario}", 'Editar', ['class'=>'btn btn-success']); ?>
			      </td>

			    </tr>
			<?php endforeach; ?>
		    <?php endif; ?>
		  </tbody>
		</table> 

		<!-- Tarjetas responsive, se muestran al reducir tamaño de pagina -->
		<?php if (count($listaUsuarios)): ?>
			<hr>
			<?php foreach ($listaUsuarios as $item): ?>
				<div style="border: none;" class="card border-secondary mb-3 info_estudiantes" id="contenido">
				  <div id="contenido">
						<div class="card-header" id="">Identificación: <?=$item->id_individuo ?>
					  	<?php echo anchor("instructor/editarUsuario/{$item->id_usuario}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
					  </div>
					  <div class="card-body" id="">
					    <h4 class="card-title"><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></h4>
					    Correo electrónico: <?=$item->correo_electronico ?><br>
					    Nacionalidad: <?=$item->nacionalidad ?><br>
					    Condición médica: <?=$item->condicion_medica ?><br> 
					    Fecha de nacimiento: <?=$item->fecha_nacimiento ?><br>
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