<?php include_once('header.php') ?>
<div class="container">
	<hr>
	<h3>Bitácora</h3>

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
		      <th scope="col">ID</th>
		      <th scope="col">Fecha</th>
		      <th scope="col">Descripción</th>
		      <th style="display: none;" scope="col">Descripción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (count($bitacora)): ?>
		  		<?php foreach ($bitacora as $item): ?>
			    <tr class="table-light">
			    	<td><?=$item->id_bitacora ?></td>
			      	<td><?=$item->fecha?></td>
			      	<td><?=$item->descripcion ?></td>
			      	<td style="display: none;"><?="$item->nombre $item->apellido1 $item->apellido2"; ?></td>
			    </tr>
			<?php endforeach; ?>
		    <?php endif; ?>
		  </tbody>
		</table> 

		<!-- Tarjetas responsive, se muestran al reducir tamaño de pagina -->
		<?php if (count($bitacora)): ?>
			<hr>
			<?php foreach ($bitacora as $item): ?>
				<div style="border: none;" class="card border-secondary mb-3 info_estudiantes" id="contenido">
				  <div id="contenido">
						<div class="card-header">ID: <?=$item->id_bitacora ?>
					  </div>
					  <div class="card-body" id="">
					    <h4 class="card-title">Fecha: <?=$item->fecha ?></h4>
					    Descripción: <?=$item->descripcion ?><br>
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