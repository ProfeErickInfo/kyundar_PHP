<?php
session_start();
$id_usu = (int)@$_SESSION['id_usuario'];
$idSocio = (int)@$_GET['idSocio'];
$idBeneficiario = (int)@$_GET['idBeneficiario'];

// Aquí iría la consulta a la base de datos para obtener los datos del beneficiario
// $row = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM beneficiarios WHERE id = $idBeneficiario"));

$row = [
  'TipoDocumento' => 1,
  'Documento' => '12345678',
  'Nombres' => 'Ejemplo',
  'Apellidos' => 'Beneficiario',
  'Sexo' => 1,
  'FechaNac' => '2005-01-01',
  'LugarNac' => 'Ciudad',
  'Barrio' => 'Barrio',
  'Direccion' => 'Calle 123',
  'Tpsalud' => 1,
  'Salud' => 'EPS',
  'Celular' => '3001234567',
  'Email' => 'beneficiario@email.com',
  'Parentesco' => 'Hijo(a)'
];
?>
<!-- ...estilos y scripts igual que reg_beneficiario.php... -->
<div class="container-fluid registro-form">
  <h5>Editar Beneficiario</h5>
  <form id="formEditBenef" name="formEditBenef" method="post" action="#">
    <input type="hidden" name="idSocio" value="<?= $idSocio ?>">
    <input type="hidden" name="idBeneficiario" value="<?= $idBeneficiario ?>">
    <div class="row">
      <div class="col-md-6"><label>Socio titular</label>
        <input type="text" class="form-control" value="ID Socio: <?= $idSocio ?>" disabled />
      </div>
      <div class="col-md-2"><label>Tipo Doc.</label>
        <select class="form-select" name="TipoDocumento" id="TipoDocumento" required>
          <option value="1" <?= $row['TipoDocumento']==1?'selected':'' ?>>CC</option>
          <option value="2" <?= $row['TipoDocumento']==2?'selected':'' ?>>TI</option>
          <option value="3" <?= $row['TipoDocumento']==3?'selected':'' ?>>CE</option>
        </select>
      </div>
      <div class="col-md-2"><label>Número</label>
        <input type="number" name="txtDocumento" id="txtDocumento" class="form-control" value="<?= $row['Documento'] ?>" required />
      </div>
      <div class="col-md-2"><label>Género</label>
        <select name="Sexo" id="Sexo" class="form-control" required>
          <option value="1" <?= $row['Sexo']==1?'selected':'' ?>>Masculino</option>
          <option value="2" <?= $row['Sexo']==2?'selected':'' ?>>Femenino</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3"><label>Nombre(s)</label>
        <input type="text" name="txtNombres" id="txtNombres" class="form-control" value="<?= $row['Nombres'] ?>" />
      </div>
      <div class="col-md-3"><label>Apellido(s)</label>
        <input type="text" name="txtApellidos" id="txtApellidos" class="form-control" value="<?= $row['Apellidos'] ?>" />
      </div>
      <div class="col-md-3"><label>Fecha de Nacimiento</label>
        <input type="date" name="txtFechaNac" id="txtFechaNac" class="form-control" value="<?= $row['FechaNac'] ?>" required />
      </div>
      <div class="col-md-3"><label>Lugar de Nacimiento</label>
        <input type="text" name="LugarNac" id="LugarNac" class="form-control" value="<?= $row['LugarNac'] ?>" />
      </div>
    </div>
    <div class="row">
      <div class="col-md-3"><label>Barrio</label>
        <input type="text" name="Barrio" id="Barrio" class="form-control" value="<?= $row['Barrio'] ?>" />
      </div>
      <div class="col-md-3"><label>Dirección</label>
        <input type="text" name="txtDireccion" id="txtDireccion" class="form-control" value="<?= $row['Direccion'] ?>" />
      </div>
      <div class="col-md-3"><label>Tipo. Serv</label>
        <select name="Tpsalud" id="Tpsalud" class="form-control">
          <option value="1" <?= $row['Tpsalud']==1?'selected':'' ?>>Contributivo</option>
          <option value="2" <?= $row['Tpsalud']==2?'selected':'' ?>>Subsidiado</option>
        </select>
      </div>
      <div class="col-md-3"><label>Serv. de salud</label>
        <input type="text" name="txtSalud" id="txtSalud" class="form-control" value="<?= $row['Salud'] ?>" />
      </div>
    </div>
    <div class="row">
      <div class="col-md-3"><label>Celular</label>
        <input type="text" name="txtCelular" id="txtCelular" class="form-control" value="<?= $row['Celular'] ?>" />
      </div>
      <div class="col-md-3"><label>Email</label>
        <input type="text" name="txtEmail" id="txtEmail" class="form-control" value="<?= $row['Email'] ?>" />
      </div>
      <div class="col-md-3"><label>Parentesco</label>
        <select name="Parentesco" id="Parentesco" class="form-control" required>
          <option value="Hijo(a)" <?= $row['Parentesco']=='Hijo(a)'?'selected':'' ?>>Hijo(a)</option>
          <option value="Esposo(a)" <?= $row['Parentesco']=='Esposo(a)'?'selected':'' ?>>Esposo(a)</option>
          <option value="Padre/Madre" <?= $row['Parentesco']=='Padre/Madre'?'selected':'' ?>>Padre/Madre</option>
          <option value="Otro" <?= $row['Parentesco']=='Otro'?'selected':'' ?>>Otro</option>
        </select>
      </div>
      <div class="col-md-3" style="display:flex;align-items:end;">
        <button class="btn btn-primary" type="button" name="btnActualizar" id="btnActualizar">Actualizar Beneficiario</button>
      </div>
    </div>
  </form>
</div>