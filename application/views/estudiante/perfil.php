<?php include_once('header.php') ?>
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
	
	
	<div class="container">
		<div class="jumbotron" style="background: url('../KmgCR/assets/images/pelea.png') center; background-size: cover;">
		  <div class="row">
		  <?php if ($estudiante->nivel_kmg != 'Aspirante'): ?>
		  	<div class="col-md-2">
		  		<img src="<?= base_url('assets/images/'. $estudiante->nivel_kmg .'.png');?>" width="100" class="img-fluid rounded mx-auto d-block">
		  	</div>
		  <?php endif; ?>
		  	<div class="col-md-10">
		  		<h1 class="display-3"><?=$individuo->nombre . ' ' . $individuo->apellido1 ?></h1>
		  		<p class="lead">Nivel actual: <?=$estudiante->nivel_kmg ?></p>
	  			<p>Fecha de inicio: <?=$estudiante->fecha_inscripcion ?></p>
		  	</div>
		  </div>
		</div>
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
					  	<?php endif; ?>
					<?php endforeach; ?>
					<?php else: echo "No hay paquetes."; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<br>
<?php include_once('footer.php') ?>