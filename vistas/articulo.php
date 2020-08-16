<?php

// Almacenamiento en el buffer
ob_start();

session_start();

if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{
require 'header.php';
if($_SESSION['almacen']==1)
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
                          <h1 class="box-title">Producto <button class="btn btn-success" id="btnagregar" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button><!-- <a href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info">Reporte</button></a>--></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado-articulo" class="table table-striped table-bordered table-hover">
                          <thead>
                            <th>Opciones</th>
                            
                            <th>Categoria</th>
                            <th>Composicion</th>
                            <th>nombre</th>
                            <th>Stock</th>
                            <th>Descripcion</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Condicion</th>
                          </thead>
                          
                          <tbody>
                              
                          </tbody>

                          <tfoot>
                            <th>Opciones</th>
                            
                            <th>Categoria</th>
                            <th>Composicion</th>
                            <th>nombre</th>
                            <th>Stock</th>
                            <th>Descripcion</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Condicion</th>
                          </tfoot>

                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                          
                        <form action="POST" name="formulario-articulo" id="formulario-articulo">
                        	<div class="form-group  col-xs-12 col-sm-6">
                        	<label for="nombre">Categoria:</label>
                            <input type="hidden" name="idarticulo" id="idarticulo">
                            <select name="idcategoria" id="idcategoria" class="form-control selectpicker"> 
                            		
                                <?php
                            			require '../modelos/Articulo.php';
                            			$articulo = new Articulo();
                            			$respuesta = $articulo->articuloXcategoria();
                                    while($fila=$respuesta->fetch_assoc()){
                                    echo '<option value="'.$fila['idcategoria'].'">';
                                    echo $fila['categoria'];
                                    echo "</option>";
                                  }
                            		?>
                            </select>
                        	</div>	

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="stock">Stock</label>
                            <input type="text" class="form-control" name="stock" id="stock">
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion" max="300">
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="imagen">Fecha de Vencimiento</label>
                            <input type="date" class="form-control" name="imagen" id="imagen" placeholder="" max="300">
                            <!--<input type="hidden" name="imagenactual" id="imagenActual">
                            <img src="" alt="" width="150px" height="120px;" id="imagenmuestra">-->
                          </div>
                          
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="codigo">Composicion:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" maxlength="50" placeholder="composicion" required>

                            <!-- GENERAR CODIGO DE BARRAS 
                            <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                            <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                            <div id="print">
                              <svg id="barcode">
                                
                              </svg>
                            </div>-->
                          </div>
                          <div class="form-group col-12">
                            <button class="btn btn-primary" type="submit" id="btn-guardar" onclick="insertarForm(event);">Guardar</button>
                            
                            <button class="btn btn-warning" type="submit" id="btn-editar" onclick="editarForm(event);">Editar</button>
                            
                            
                            <button class="btn btn-danger" type="submit" id="btn-cerrar" onclick="cancelarForm();">Cerrar </button>
                            
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

  <?php
  }
  else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?> 
  <!-- libreria para codigo de barrar -->
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <!-- libreria para imprimir -->
  <script src="../public/js/jquery.PrintArea.js"></script>
  <script src="scripts/articulo.js"> 
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
  <?php
  }
  ob_end_flush();
?>