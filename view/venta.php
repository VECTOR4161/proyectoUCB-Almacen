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

if ($_SESSION['ventas']==1)
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
                                    <h4 class="mb-sm-0">Venta de Productos &nbsp; 
                                        <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="bx bx-add-to-queue"></i> Nuevo</button></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Escritorio</a></li>
                                            <li class="breadcrumb-item active">Ventas</li>
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
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Usuario</th>
                                                <th>Documento</th>
                                                <th>Número</th>
                                                <th>Total Venta</th>
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
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Cliente</label>
                                                            <input type="hidden" name="idventa" id="idventa">
                                                            <select id="cliente" name="cliente" class="form-control" data-live-search="true" required>
                                                            </select>
                                                        </div>                                                  
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mt-3 mt-lg-0">
                                                        <div class="mb-3">
                                                            <label for="example-date-input" class="form-label">Fecha</label>
                                                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" value="<?php date_default_timezone_set('America/La_Paz'); $fcha = date("Y-m-d"); echo $fcha;?>" required>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Tipo Comprobante</label>
                                                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                                                                <option value="1">Boleta</option>
                                                                <option value="2">Factura</option>
                                                                <option value="3">Ticket</option>
                                                            </select>
                                                        </div>                                                  
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="mt-3 mt-lg-0">
                                                        <div class="mb-3">
                                                            <label for="example-date-input" class="form-label">Serie</label>
                                                            <input type="number" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie" min="0" value="0">
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mt-3 mt-lg-0">
                                                        <div class="mb-3">
                                                            <label for="example-date-input" class="form-label">Número</label>
                                                            <input type="number" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" value="0" min="0" required>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mt-3 mt-lg-0">
                                                        <div class="mb-3">
                                                            <label for="example-date-input" class="form-label">Impuesto</label>
                                                            <input type="number" class="form-control" name="impuesto" id="impuesto" placeholder="Impuesto" value="0" min="0" required>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">     
                                                <button id="btnAgregarArt" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"><span class="fa fa-plus"></span> Agregar Artículos</button>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                                <thead style="background-color:#A9D0F5">
                                                        <th>Opciones</th>
                                                        <th>Artículo</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Venta</th>
                                                        <th>Descuento</th>
                                                        <th>Subtotal</th>
                                                    </thead>
                                                    <tfoot>
                                                        <th>TOTAL</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><h4 id="total">Bs/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                                    </tfoot>
                                                    <tbody>
                                                    
                                                    </tbody>
                                                </table>
                                            </div>                  
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="bx bx-save"></i> Guardar</button>
                                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                            </div>
                                        </form>
                                        <!-- Modal -->
                                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Seleccione un Artículo</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
                                                                    <thead>
                                                                        <th>Opciones</th>
                                                                        <th>Nombre</th>
                                                                        <th>Categoría</th>
                                                                        <th>Código</th>
                                                                        <th>Stock</th>
                                                                        <th>Imagen</th>
                                                                    </thead>
                                                                    <tbody>                                                                    
                                                                    </tbody>
                                                                    <tfoot>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>  
                                                <!-- Fin modal -->
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
<script type="text/javascript" src="script/venta.js"></script>       
<?php 
}
ob_end_flush();
?>     