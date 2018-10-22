<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio de sesión</title>
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.css');?>">
</head>
<body>
	<?php 
		$correo = array('name'=>'correo_electronico');
		$contrasena = array('name'=>'contrasena');
		$submit = array('name'=>'submit', 'value'=>'Iniciar sesión');
	?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<h1>Krav Maga Global Costa Rica</h1>
	</nav>

	<div class="container">
		<?php if ($mensaje = $this->session->flashdata('usuario_incorrecto')): ?>
			<div class="alert alert-dismissible alert-danger">
				<?=$mensaje; ?>
			</div>
		<?php endif; ?>
		<?=form_open(base_url().'login/iniciarSesion', ['class'=>'form-horizontal']); ?>
		  <fieldset>
		    <legend>Inicio de sesión</legend>
		    <div class="form-group">
		      <label for="">Correo electrónico</label>
		      <?=form_input(['name'=>'correo_electronico', 'class'=>'form-control']); ?>
		      <?=form_error('correo_electronico', '<div class="text-danger">','</div>'); ?>
		    </div>
		    <div class="form-group">
		      <label for="">Contraseña</label>
		      <?=form_password(['name'=>'contrasena', 'class'=>'form-control']); ?>
		      <?=form_error('contrasena', '<div class="text-danger">','</div>'); ?>
		    </div>
		    <?=form_hidden('token', $token); ?>
		    <?=form_submit(['name'=>'submit', 'value'=>'Iniciar sesión', 'class'=>'btn btn-primary']); ?>
		  </fieldset>
		<?=form_close(); ?>
	</div>
</body>
</html>