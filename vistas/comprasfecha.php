<?php

// Almacenamiento en el buffer
ob_start();

session_start();

if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{
require 'header.php';

if($_SESSION['consultac']==1)
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
                          <h1 class="box-title">Consulta de Compras por Fecha</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <div class="form-group col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input class="form-control"type="date" id="fecha_inicio" name="fecha_inicio" value="<?php
                          echo date("Y-m-d");
                          ?>">
                        </div>

                        <div class="form-group col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input class="form-control"type="date" id="fecha_fin" name="fecha_fin" value="<?php
                          echo date("Y-m-d");
                          ?>">
                        </div>

                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                          <thead>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Proveedor</th>
                            <th>Comprobante</th>
                            <th>Numero</th>
                            <th>Total Compra</th>
                            <th>Impuesto</th>
                            <th>Estado</th>
                          </thead>
                          
                          <tbody>
                              
                          </tbody>

                          <tfoot>
                            <th>Fecha</th>   
                            <th>Usuario</th>
                            <th>Proveedor</th>
                            <th>Comprobante</th>
                            <th>Numero</th>
                            <th>Total Compra</th>
                            <th>Impuesto</th>
                            <th>Estado</th>
                          </tfoot>

                        </table>
                    </div>
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <?php
  }
  else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?> 

  <script src="scripts/comprasfecha.js"> 
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<?php
  }
  ob_end_flush();
?>