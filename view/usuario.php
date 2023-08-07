<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["personanombre"]))
{
  header("Location: login.php");
}
else
{
require 'header.php';

if ($_SESSION['acceso']==1)
{
?> 
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content" id="miniaresult">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Clientes &nbsp; 
                                        <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="bx bx-add-to-queue"></i> Nuevo</button></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Escritorio</a></li>
                                            <li class="breadcrumb-item active">Clientes</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                <div class="card-body" id="listadoregistros">
                                    <h4 class="card-title">Listado de Registros</h4>
                                    <table id="tbllistado" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                            <th>Opciones</th>
                                            <th>Nombres y Apellidos</th>
                                            <th>Documento</th>
                                            <th>Número</th>
                                            <th>Email</th>
                                            <th>Login</th>
                                            <th>Foto</th>
                                            <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-body" id="formularioregistros">
                                    <form name="formulario" id="formulario" method="POST">
                                        <h4 class="card-title">Registro de Datos</h4>                                            
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" name="idusuario" id="idusuario">
                                                <input type="text" class="form-control mayusculas" name="nombre" id="nombre" maxlength="70" placeholder="Nombre" required>
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Apellido Paterno</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="text" class="form-control mayusculas" name="apellidop" id="apellidop" maxlength="70" placeholder="Apellido Paterno">
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Apellido Materno</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="text" class="form-control mayusculas" name="apellidom" id="apellidom" maxlength="70" placeholder="Apellido Materno" required>
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Documento de Identidad</label>
                                            <div class="col-sm-10">                                                    
                                            <select class="form-control" data-live-search="true" name="tipo_documento" id="tipo_documento" required>
                                                <option value="1">DNI</option>
                                                <option value="2">PASAPORTE</option>
                                                <option value="3">CEDULA DE IDENTIDAD</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Número</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="text" class="form-control mayusculas" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" required>
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Dirección</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="text" class="form-control mayusculas" name="direccion" id="direccion" placeholder="Dirección" maxlength="70">
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Nombre de Usuario</label>
                                            <div class="col-sm-10">                                                    
                                            <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required>
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Contraseña</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Clave" required>
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Rol de Usuario</label>
                                            <div class="col-sm-10">                                                    
                                            <select id="rol" name="rol" class="form-control selectpicker" data-live-search="true" required></select>
                                            </div>
                                        </div> 
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Imágen</label>
                                            <div class="col-sm-10">                                                    
                                                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
                                                <input type="hidden" name="imagenactual" id="imagenactual">
                                                <img src="" width="150px" height="120px" id="imagenmuestra">
                                            </div>
                                        </div>                            
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="bx bx-save"></i> Guardar</button>
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->   
                    </div>         
                </div>
            </div>    
            <?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="script/usuario.js"></script>   
<?php 
}
ob_end_flush();
?>     
 