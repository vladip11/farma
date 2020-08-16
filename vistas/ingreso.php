<?php

// Almacenamiento en el buffer
ob_start();

session_start();

if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{
require 'header.php';

if($_SESSION['compras']==1)
{
?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">INGRESO <button class="btn btn-success" id="btnagregar" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Numero Documento</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </thead>
                          
                          <tbody>
                              
                          </tbody>

                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Numero Documento</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </tfoot>

                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                          
                        <form action="POST" name="formulario" id="formulario">
                          <div class="form-group col-sm-8 col-xs-12">
                            <label for="nombre">Proveedor:</label>
                            <input type="hidden" name="idingreso" id="idcategoria">
                            <select name="idproveedor" id="idproveedor" class="form-control selectpicker" required="">
                              

                            </select>
                          </div>
                          <div class="form-group col-sm-4 col-xs-12">
                            <label for="">Fecha</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora"  required="">
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Tipo Comprobante(*)</label>
                             <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option value="Boleta">Boleta</option>
                               <option value="Factura">Factura</option>
                               <option value="Ticket">Ticket</option>
                             </select> 

                          </div>

                          <div class="form-group col-sm-2 col-xs-12">
                            <label for="">Serie:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                          </div>

                          <div class="form-group col-sm-2 col-xs-12">
                            <label for="">Numero:</label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante"  required="" maxlength="10" placeholder="Numero">
                          </div>

                          <div class="form-group col-sm-2 col-xs-12">
                            <label for="">Impuesto:</label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto"  required="">
                          </div>

                          <div class="form-group col-sm-3 col-xs-12">
                            <a href="#myModal" data-toggle="modal">
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Articulos</button>
                            </a>
                          </div>
                          
                          <div class="form-group col-sm-12 col-xs-12">
                            
                            <table class="table table-striped table-border table-hover" id="detalles">
                              <thead style="background: #a9d0f5">
                                <th>Opciones</th>
                                <th>Articulo</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Subtotal</th>
                              </thead>

                              <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                  <h4 id="total">S/. 0.00</h4>
                                  <input type="hidden" name="total_compra" id="total_compra">
                                </th>
                              </tfoot>

                              <tbody>
                                

                              </tbody>

                            </table>

                          </div>

                            
                          <div class="form-group col-12" id="guardar">
                            <button class="btn btn-primary" type="submit" id="btnGuardar" onclick="insertarForm(event);">Guardar</button>
                            
                            <button id="btnEditar" class="btn btn-warning" type="submit" id="btnEditar" onclick="editarForm(event);">Editar</button>
                            
                            
                            <button class="btn btn-danger" id="btnCancelar"type="submit" id="btn-cerrar" onclick="cancelarForm();">Cerrar </button>
                          </div>
                        </form>        

                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->



  <!-- MODAL -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
          <h4 class="modal-title">Seleccione un Articulo</h4>
        </div>
        <div class="modal-body">
            <table id="tblarticulos" class="table table-striped table-hover">
                <thead>
                  <th>Opciones</th>
                  <th>Nombre</th>
                  <th>Categoria</th>
                  <th>Codigo</th>
                  <th>Stock</th>
                  <th>Image</th>
                </thead>

                <tbody>
                  
                </tbody>

                <tfoot>
                  <th>Opciones</th>
                  <th>Nombre</th>
                  <th>Categoria</th>
                  <th>Codigo</th>
                  <th>Stock</th>
                  <th>Image</th>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
          <button type= "button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Fin MODAL -->

  <?php
  }
  else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?> 

  <script src="scripts/ingreso.js"> 
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<?php
  }
  ob_end_flush();
?>