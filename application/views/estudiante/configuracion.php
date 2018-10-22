<?php include_once('header.php') ?>
<div class="container">
	<form>
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
      <input type="password" class="form-control" id="" placeholder="********">
    </div>
    <div class="form-group">
      <label for="">Confirmar ontraseña</label>
      <input type="password" class="form-control" id="" placeholder="********">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </fieldset>
</form>
</div>
<?php include_once('footer.php') ?>