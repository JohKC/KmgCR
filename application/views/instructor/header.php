<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Perfil de instructor</title>
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/instructor/estilos.css');?>">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="<?=base_url() ?>">KMG Costa Rica</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarColor03">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="<?=base_url().'instructor/estudiantes' ?>">Estudiantes</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?=base_url().'instructor/instructores' ?>">Instructores</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?=base_url().'instructor/sedes' ?>">Sedes</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?=base_url().'instructor/paquetes' ?>">Paquetes</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?=base_url().'instructor/configuracion' ?>">Cambiar contraseña</a>
	      </li>

	    </ul>
	    <form class="form-inline my-2 my-lg-0">
	      <?=anchor(base_url().'login/cerrarSesion', 'Cerrar sesión', ['class'=>'btn btn-secondary my-2 my-sm-0']); ?>
	    </form>
	  </div>
	</nav>