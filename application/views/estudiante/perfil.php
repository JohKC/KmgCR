<?php include_once('header.php') ?>
	<div class="jumbotron">
	  <h1 class="display-3"><?=$individuo->nombre . ' ' . $individuo->apellido1 ?></h1>
  		<h1>Nivel: <?=$estudiante->nivel_kmg ?></h1>
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