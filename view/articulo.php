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

if ($_SESSION['almacen']==1)
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
                                    <h4 class="mb-sm-0">Artículos y Productos &nbsp; 
                                        <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="bx bx-add-to-queue"></i> Nuevo</button></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Escritorio</a></li>
                                            <li class="breadcrumb-item active">Artículos</li>
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
                                    <h4 class="card-title">Listado de </h4>
                                    <table id="tbllistado" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Categoría</th>
                                                <th>Código</th>
                                                <th>Stock</th>
                                                <th>Imagen</th>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Stock</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control mayusculas" type="number" placeholder="Stock Inicial" min="0" id="stock" name="stock" required>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Stock</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control mayusculas" type="number" placeholder="Stock Inicial" min="0" id="stock" name="stock" required>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Stock</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control mayusculas" type="number" placeholder="Stock Inicial" min="0" id="stock" name="stock" required>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Descripción</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control mayusculas" type="text" placeholder="Descripción y características del artículo" maxlength="500" id="descripcion" name="descripcion" required>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Imágen</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
                                                            <input type="hidden" name="imagenactual" id="imagenactual">
                                                            <img src="" width="150px" height="120px" id="imagenmuestra">
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Código de Artículo</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control mayusculas" type="number" placeholder="Stock Inicial" min="1" id="codigo" name="codigo" required>
                                                            <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                                                            <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                                                            <div id="print">
                                                                <svg id="barcode"></svg>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>                        
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="bx bx-save"></i> Guardar</button>
                                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->   
                        
                        

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
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="script/articulo.js"></script>    
<?php 
}
ob_end_flush();
?>