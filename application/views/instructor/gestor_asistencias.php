<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Paquete de estudiante editado correctamente' || $mensaje == 'Paquete asignado correctamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No se pudo editar paquete de estudiante' || $mensaje == 'No se pudo asignar el paquete'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php else: ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<h3>Gestor de asistencias</h3>

	<?php echo anchor('instructor/asignarPaquete', 'Asignar nuevo paquete', ['class'=>'btn btn-primary']); ?>
	<hr>
	<legend>Paquetes activos</legend>
	<!-- Tabla  -->
	<table class="table table-hover tabla_estudiantes">
	  <thead>
	    <tr>
	      <th scope="col">Identificación</th>
	      <th scope="col">Nombre</th>
	      <th scope="col">Paquete</th>
	      <th scope="col">Sede</th>
	      <th scope="col">Asistencias</th>
	      <th scope="col">Días restantes</th>
	      <th scope="col">Fecha de inicio</th>
	      <th scope="col">Opciones</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php if (count($infoPaquetesActivos)): ?>
	  		<?php foreach ($infoPaquetesActivos as $item): ?>
		    <tr class="table-light">
		    	<td><?=$item->id_individuo ?></td>
		      	<td><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></td>
		      	<td><?=$item->nombre_paquete?></td>
		      	<td><?=$item->nombre_sede ?></td>
		      	<td><?=$item->asistencias ?> de <?=$item->cantidad_clases ?></td>
		      	<td><?=$item->dias_restantes ?></td>
		      	<td><?=$item->fecha_inicio ?></td>
		        <td>
		        	<?php
		        	 $clase = '';
		        	 if ($item->asistencias == $item->cantidad_clases) {
		        	 	$clase = 'disabled';
		        	 }

		        	?>
		      	<?php echo anchor("instructor/editarPaqueteEstudiante/{$item->id_paquete}/{$item->id_sede}/{$item->id_estudiante}/{$item->id_instructor}/{$item->fecha_inicio}", 'Editar', ['class'=>"btn btn-success"]); ?>
		      	<?php echo anchor("instructor/asignarAsistencia/{$item->id_paquete}/{$item->id_sede}/{$item->id_estudiante}/{$item->id_instructor}/{$item->fecha_inicio}", 'Asignar asistencia', ['class'=>"btn btn-warning $clase"]); ?>
		      </td>

		    </tr>
		<?php endforeach; ?>
	    <?php endif; ?>
	  </tbody>
	</table> 

	<!-- Tarjetas responsive -->
	<?php if (count($infoPaquetesActivos)): ?>
		<?php foreach ($infoPaquetesActivos as $item): ?>
			<div class="card border-secondary mb-3 info_estudiantes">
			  <div class="card-header">Identificación: <?=$item->id_individuo ?>
			  	<?php echo anchor("instructor/editarPaqueteEstudiante/{$item->id_paquete}/{$item->id_sede}/{$item->id_estudiante}/{$item->id_instructor}/{$item->fecha_inicio}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
			  	<?php echo anchor("instructor/asignarAsistencia/{$item->id_paquete}/{$item->id_sede}/{$item->id_estudiante}/{$item->id_instructor}/{$item->fecha_inicio}", 'Asignar asistencia', ['class'=>'btn-sm btn-warning', 'style'=>'float:right; margin-right: 5px;']); ?>
			  </div>
			  <div class="card-body">
			    <h4 class="card-title"><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></h4>
			    Identificación: <?=$item->id_individuo ?><br>
			    Paquete: <?=$item->nombre_paquete ?><br>
			    Sede: <?=$item->nombre_sede ?><br>
			    Asistencias: <?=$item->asistencias ?> de <?=$item->cantidad_clases ?><br>
			    Días restantes: <?=$item->dias_restantes ?><br>
			    Fecha de inicio: <?=$item->fecha_inicio ?><br>
			  </div>
			</div>
		<?php endforeach; ?>
		<?php else: ?>
			<h3>No se encontraron resultados.</h3>
		<?php endif; ?>

	<hr>
	<!-- Paquetes inactivos -->
	<legend>Paquetes inactivos</legend>
	<!-- Tabla  -->
	<table class="table table-hover tabla_estudiantes">
	  <thead>
	    <tr>
	      <th scope="col">Identificación</th>
	      <th scope="col">Nombre</th>
	      <th scope="col">Paquete</th>
	      <th scope="col">Sede</th>
	      <th scope="col">Asistencias</th>
	      <th scope="col">Días restantes</th>
	      <th scope="col">Fecha de inicio</th>
	      <th scope="col">Opciones</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php if (count($infoPaquetesInactivos)): ?>
	  		<?php foreach ($infoPaquetesInactivos as $item): ?>
		    <tr class="table-light">
		    	<td><?=$item->id_individuo ?></td>
		      	<td><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></td>
		      	<td><?=$item->nombre_paquete?></td>
		      	<td><?=$item->nombre_sede ?></td>
		      	<td><?=$item->asistencias ?> de <?=$item->cantidad_clases ?></td>
		      	<td><?=$item->dias_restantes ?></td>
		      	<td><?=$item->fecha_inicio ?></td>
		        <td>
		        	<?php
		        	 $clase = '';
		        	 if ($item->asistencias == $item->cantidad_clases) {
		        	 	$clase = 'disabled';
		        	 }

		        	?>
		      	<?php echo anchor("instructor/editarPaqueteEstudiante/{$item->id_paquete}/{$item->id_sede}/{$item->id_estudiante}/{$item->id_instructor}/{$item->fecha_inicio}", 'Editar', ['class'=>"btn btn-success"]); ?>
		      </td>

		    </tr>
		<?php endforeach; ?>
	    <?php endif; ?>
	  </tbody>
	</table> 

	<!-- Tarjetas responsive -->
	<?php if (count($infoPaquetesInactivos)): ?>
		<?php foreach ($infoPaquetesInactivos as $item): ?>
			<div class="card border-secondary mb-3 info_estudiantes">
			  <div class="card-header">Identificación: <?=$item->id_individuo ?>
			  	<?php echo anchor("instructor/editarPaqueteEstudiante/{$item->id_paquete}/{$item->id_sede}/{$item->id_estudiante}/{$item->id_instructor}/{$item->fecha_inicio}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
			  </div>
			  <div class="card-body">
			    <h4 class="card-title"><?=$item->nombre . ' ' . $item->apellido1 . ' ' . $item->apellido2 ?></h4>
			    Identificación: <?=$item->id_individuo ?><br>
			    Paquete: <?=$item->nombre_paquete ?><br>
			    Sede: <?=$item->nombre_sede ?><br>
			    Asistencias: <?=$item->asistencias ?> de <?=$item->cantidad_clases ?><br>
			    Días restantes: <?=$item->dias_restantes ?><br>
			    Fecha de inicio: <?=$item->fecha_inicio ?><br>
			  </div>
			</div>
		<?php endforeach; ?>
		<?php else: ?>
			<h3>No se encontraron resultados.</h3>
		<?php endif; ?>
</div>
<?php include_once('footer.php') ?>