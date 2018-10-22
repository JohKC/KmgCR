<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<div class="alert alert-dismissible alert-success">
			<?=$mensaje; ?>
		</div>
	<?php endif; ?>
	<h3>Lista de estudiantes</h3>

	<?php echo anchor('instructor/nuevoEstudiante', 'Agregar nuevo estudiante', ['class'=>'btn btn-primary']); ?>
	<?php echo anchor('instructor/asistencias', 'Paquetes y asistencias', ['class'=>'btn btn-primary']); ?>
	<hr>

	<!-- Tabla  -->
	<table class="table table-hover tabla_estudiantes">
	  <thead>
	    <tr>
	      <th scope="col">Identificación</th>
	      <th scope="col">Nombre</th>
	      <th scope="col">Correo electrónico</th>
	      <th scope="col">Fecha de inscripción</th>
	      <th scope="col">Nivel KMG</th>
	      <th scope="col">Activo</th>
	      <th scope="col">Fecha de nacimiento</th>
	      <th scope="col">Nacionalidad</th>
	      <th scope="col">Paquetes activos</th>
	      <th scope="col">Opciones</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php if (count($listaEstudiantes)): ?>
	  		<?php foreach ($listaEstudiantes as $item): ?>
		    <tr class="table-light">
		    	<td><?=$item->id_individuo ?></td>
		      	<td><?=$item->Estudiante ?></td>
		      	<td><?=$item->correo_electronico?></td>
		      	<td><?=$item->fecha_inscripcion ?></td>
		      	<td><?=$item->nivel_kmg ?></td>
		      	<td><?=$item->es_activo ?></td>
		      	<td><?=$item->fecha_nacimiento ?></td>
		      	<td><?=$item->nacionalidad ?></td>
		      	<td><?=$item->paquetes ?></td>
		        <td>
		      	<?php echo anchor("instructor/editarEstudiante/{$item->id_usuario}", 'Editar', ['class'=>'btn btn-success']); ?>
		      </td>

		    </tr>
		<?php endforeach; ?>
	    <?php else: ?>
	    	<tr>No se encontraron resultados.</tr>
	    <?php endif; ?>
	  </tbody>
	</table> 

	<!-- Tarjetas responsive -->
	<?php if (count($listaEstudiantes)): ?>
		<?php foreach ($listaEstudiantes as $item): ?>
			<div class="card border-secondary mb-3 info_estudiantes">
			  <div class="card-header">Identificación: <?=$item->id_individuo ?>
			  	<?php echo anchor("instructor/editarEstudiante/{$item->id_estudiante}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
			  </div>
			  <div class="card-body">
			    <h4 class="card-title"><?=$item->Estudiante ?></h4>
			    Correo electrónico: <?=$item->correo_electronico ?><br>
			    Fecha de inscripción: <?=$item->fecha_inscripcion ?><br>
			    Nivel KMG: <?=$item->nivel_kmg ?><br>
			    Activo: <?=$item->es_activo ?><br>
			    Nacionalidad: <?=$item->nacionalidad ?><br>
			    Paquetes activos: <?=$item->paquetes ?><br>
			  </div>
			</div>
		<?php endforeach; ?>
		<?php else: ?>
			<h3>No se encontraron resultados.</h3>
		<?php endif; ?>
</div>
<?php include_once('footer.php') ?>