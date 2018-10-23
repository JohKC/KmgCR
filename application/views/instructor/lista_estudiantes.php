<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Estudiante añadido correctamente' || $mensaje == 'Estudiante editado correctamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No es posible añadir datos de estudiante' || $mensaje == 'No es posible editar datos de estudiante'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<h3>Lista de estudiantes</h3>

	<?php echo anchor('instructor/nuevoEstudiante', 'Agregar nuevo estudiante', ['class'=>'btn btn-primary']); ?>
	<?php echo anchor('instructor/asistencias', 'Paquetes y asistencias', ['class'=>'btn btn-primary']); ?>
	<hr>

	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active show" data-toggle="tab" href="#mis_estudiantes">Mis estudiantes</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#estudiantes_general">Todos los estudiantes</a>
	  </li>
	</ul>

	<div id="myTabContent" class="tab-content">
	  <div class="tab-pane fade active show" id="mis_estudiantes">
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
		    <?php endif; ?>
		  </tbody>
		</table> 

		<!-- Tarjetas responsive -->
		<?php if (count($listaEstudiantes)): ?>
			<?php foreach ($listaEstudiantes as $item): ?>
				<div class="card border-secondary mb-3 info_estudiantes">
				  <div class="card-header">Identificación: <?=$item->id_individuo ?>
				  	<?php echo anchor("instructor/editarEstudiante/{$item->id_usuario}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
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
	  	<div class="tab-pane fade" id="estudiantes_general">
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
			      <th scope="col">Opciones</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php if (count($listaEstudiantesGeneral)): ?>
			  		<?php foreach ($listaEstudiantesGeneral as $item): ?>
				    <tr class="table-light">
				    	<td><?=$item->id_individuo ?></td>
				      	<td><?=$item->Estudiante ?></td>
				      	<td><?=$item->correo_electronico?></td>
				      	<td><?=$item->fecha_inscripcion ?></td>
				      	<td><?=$item->nivel_kmg ?></td>
				      	<td><?=$item->es_activo ?></td>
				      	<td><?=$item->fecha_nacimiento ?></td>
				      	<td><?=$item->nacionalidad ?></td>
				        <td>
				      	<?php echo anchor("instructor/editarEstudiante/{$item->id_usuario}", 'Editar', ['class'=>'btn btn-success']); ?>
				      </td>

				    </tr>
				<?php endforeach; ?>
			    <?php endif; ?>
			  </tbody>
			</table> 

		<!-- Tarjetas responsive -->
		<?php if (count($listaEstudiantesGeneral)): ?>
			<?php foreach ($listaEstudiantesGeneral as $item): ?>
				<div class="card border-secondary mb-3 info_estudiantes">
				  <div class="card-header">Identificación: <?=$item->id_individuo ?>
				  	<?php echo anchor("instructor/editarEstudiante/{$item->id_usuario}", 'Editar', ['class'=>'btn-sm btn-success', 'style'=>'float:right;']); ?>
				  </div>
				  <div class="card-body">
				    <h4 class="card-title"><?=$item->Estudiante ?></h4>
				    Correo electrónico: <?=$item->correo_electronico ?><br>
				    Fecha de inscripción: <?=$item->fecha_inscripcion ?><br>
				    Nivel KMG: <?=$item->nivel_kmg ?><br>
				    Activo: <?=$item->es_activo ?><br>
				    Nacionalidad: <?=$item->nacionalidad ?><br>
				  </div>
				</div>
			<?php endforeach; ?>
			<?php else: ?>
				<h3>No se encontraron resultados.</h3>
			<?php endif; ?>
		</div>
	</div>

</div>
<?php include_once('footer.php') ?>