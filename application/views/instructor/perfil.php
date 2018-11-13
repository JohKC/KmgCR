<?php include_once('header.php') ?>
<div class="container">
	<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
		<?php if ($mensaje == 'Contraseña actualizada exitosamente'): ?>
			<div class="alert alert-dismissible alert-success">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php elseif ($mensaje == 'No se pudo editar paquete de estudiante' || $mensaje == 'No se pudo asignar el paquete' || $mensaje == 'No se pudo actualizar la contraseña'): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$this->session->flashdata('mensaje') ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<hr>
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active show" data-toggle="tab" href="#instructor">Instructor</a>
	  </li>
	  <?php if ($existeEstudiante): ?>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#estudiante">Estudiante</a>
	  </li>
	<?php endif; ?>
	</ul>
	<div id="myTabContent" class="tab-content">
	  <div class="tab-pane fade active show" id="instructor">
	    <div class="container">
	    	<hr>
	    	<div class="row">
		    	<div class="col-md-6">
		    		<a href="<?=base_url().'instructor/estudiantes' ?>" style="color: inherit; text-decoration: none;">
			    		<div class="jumbotron text-center">
			    			<h1 class="fas fa-user-graduate" style="font-size: 100px"></h1>
			    			<h3>Estudiantes</h2>
			    		</div>
		    		</a>
		    	</div>
		    	<div class="col-md-6">
		    		<a href="<?=base_url().'instructor/instructores' ?>" style="color: inherit; text-decoration: none;">
			    		<div class="jumbotron text-center">
			    			<h1 class="fas fa-brain" style="font-size: 100px"></h1>
			    			<h3>Instructores</h3>
			    		</div>
		    		</a>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="col-md-6">
		    		<a href="<?=base_url().'instructor/sedes' ?>" style="color: inherit; text-decoration: none;">
			    		<div class="jumbotron text-center">
			    			<h1 class="fas fa-school" style="font-size: 100px"></h1>
			    			<h3>Sedes</h3>
			    		</div>
		    		</a>
		    	</div>
		    	<div class="col-md-6">
		    		<a href="<?=base_url().'instructor/paquetes' ?>" style="color: inherit; text-decoration: none;">
			    		<div class="jumbotron text-center">
							<h1 class="fas fa-box" style="font-size: 100px"></h1>
			    			<h3>Paquetes</h3>
			    		</div>
		    		</a>
		    	</div>
		    </div>
	    </div>
	  </div>
	  <?php if ($existeEstudiante): ?>
	  <div class="tab-pane fade" id="estudiante">
		<div class="jumbotron" style="background: url('../KmgCR/assets/images/pelea.png') center; background-size: cover;">
		  <div class="row">
		  	<div class="col-md-2">
		  		<img src="<?= base_url('assets/images/'. $estudiante->nivel_kmg .'.png');?>" width="100" class="img-fluid rounded mx-auto d-block">

		  	</div>
		  	<div class="col-md-10">
		  		<h1 class="display-3"><?=$logueado->nombre . ' ' . $logueado->apellido1 ?></h1>
		  		<p class="lead">Nivel actual: <?=$estudiante->nivel_kmg ?></p>
	  			<p>Fecha de inicio: <?=$estudiante->fecha_inscripcion ?></p>
		  	</div>
		  </div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">	
					<h2>Paquetes activos</h2>	
					<div class="list-group">
						<?php if ($infoPaquetes): ?>
					  	<?php foreach ($infoPaquetes as $item): ?>
						  	<?php if ($item->es_activo == 1): ?>
						  		<div href="#" class="list-group-item list-group-item-action flex-column align-items-start">
								  	<div class="d-flex w-100 justify-content-between">
								      <h5 class="mb-1">Tipo de paquete: <?=$item->nombre_paquete ?></h5>
								      <h5 class="mb-1">Instructor: <?=$item->nombre . ' ' . $item->apellido1 ?></h5>
								      <small>Fecha de inicio: <?= $item->fecha_ini ?></small>
								    </div>
								    <div class="d-flex w-100 justify-content-between">
								      <h5 class="mb-1">Sede: <?=$item->nombre_sede ?></h5>
								    </div>
								    <div class="d-flex w-100 justify-content-between">
								      <h5 class="mb-1">Días restantes: <?=$item->dias_restantes ?></h5>
								    </div>

								    <small class="text-muted">Lecciones asistidas: <?=$item->asistencias . ' de ' . $item->cantidad_clases  ?></small>
							  </div>
							<?php else: ?>
								<p>No hay paquetes activos.</p>
						  	<?php endif; ?>
						<?php endforeach; ?>
					<?php else: echo "No hay paquetes."; ?>
					<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">	
					<h2>Paquetes inactivos</h2>	
					<div class="list-group">
						<?php if ($infoPaquetes): ?>
					  	<?php foreach ($infoPaquetes as $item): ?>
						  	<?php if ($item->es_activo == 0): ?>
						  		<div href="#" class="list-group-item list-group-item-action flex-column align-items-start">
								  	<div class="d-flex w-100 justify-content-between">
								      <h5 class="mb-1">Tipo de paquete: <?=$item->nombre_paquete ?></h5>
								      <h5 class="mb-1">Instructor: <?=$item->nombre . ' ' . $item->apellido1 ?></h5>
								      <small>Fecha de inicio: <?= $item->fecha_ini ?></small>
								    </div>
								    <div class="d-flex w-100 justify-content-between">
								      <h5 class="mb-1">Sede: <?=$item->nombre_sede ?></h5>
								    </div>
								    <div class="d-flex w-100 justify-content-between">
								      <h5 class="mb-1">Días restantes: <?=$item->dias_restantes ?></h5>
								    </div>

								    <small class="text-muted">Lecciones asistidas: <?=$item->asistencias . ' de ' . $item->cantidad_clases  ?></small>
							  </div>
							<?php else: ?>
								<p>No hay paquetes activos.</p>
						  	<?php endif; ?>
						<?php endforeach; ?>
						<?php else: echo "No hay paquetes."; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<br>
	  </div>
	<?php endif; ?>
	</div>
	<hr>
</div>
<?php include_once('footer.php') ?>