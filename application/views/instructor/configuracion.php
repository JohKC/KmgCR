<?php include_once('header.php') ?>
<?php if ($mensaje = $this->session->flashdata('mensaje')): ?>
    <?php if ($mensaje == 'La contraseñas no coinciden'): ?>
      <div class="alert alert-dismissible alert-danger">
        <?=$this->session->flashdata('mensaje') ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<div class="container">
	<?=form_open(base_url().'instructor/configuracion', ['class'=>'form-horizontal']); ?>
  <fieldset>
    <legend>Cambiar contraseña</legend>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Correo electrónico</label>
      <div class="col-sm-10">
        <input type="text" readonly="" class="form-control-plaintext" id="staticEmail" value="<?=$this->session->userdata('correo_electronico') ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="">Contraseña</label>
      <?=form_password(['name'=>'contrasena', 'class'=>'form-control', 'placeholder'=>'********']); ?>
      <?=form_error('contrasena', '<div class="text-danger">','</div>'); ?>
    </div>
    <div class="form-group">
      <label for="">Confirmar contraseña</label>
      <?=form_password(['name'=>'conf_contrasena', 'class'=>'form-control', 'placeholder'=>'********']); ?>
      <?=form_error('conf_contrasena', '<div class="text-danger">','</div>'); ?>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </fieldset>
<?=form_close(); ?>
</div>
<?php include_once('footer.php') ?>