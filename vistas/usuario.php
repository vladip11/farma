<?php

// Almacenamiento en el buffer
ob_start();

session_start();

if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{
require 'header.php';

if($_SESSION['acceso']==1)
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
                          <h1 class="box-title">USUARIO <button class="btn btn-success" id="btnagregar" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado-articulo" class="table table-striped table-bordered table-hover">
                          <thead>
                            <th>Opciones</th>
                            
                            <th>Nombre</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </thead>
                          
                          <tbody>
                              
                          </tbody>

                          <tfoot>
                            <th>Opciones</th>
                            
                            <th>Nombre</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>

                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                          
                        <form action="POST" name="formulario-articulo" id="formulario-articulo">
                        	<div class="form-group  col-xs-12 col-sm-6">
                        	<label for="nombre">Nombre:</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" name="nombre" id="nombre" class="form-control" max="100" placeholder="Nombre" required="">
                        	</div>	

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="tipo_documento">Tipo Documento *:</label>
                            
                            <select name="tipo_documento" id="tipo_documento" required class="form-control">
                              <option value="DNI">DNI</option>
                              <option value="CI">CI</option>
                            </select>
                          </div>

                          <div class="form-group col-sm-12 col-xs-12">
                            <label for="num_documento">Numero Documento *</label>
                            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" required>
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="descripcion">Direccion</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" max="70">
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="telefono">Telefono</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono" max="20">
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="correo@gmail.com" maxlength="50">
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="cargo">Cargo</label>
                            <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo" maxlength="20">
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Login" maxlength="20" required>
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="password" maxlength="20" required>
                          </div>
                          
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Permisos:</label>
                            <ul style="list-style: none" name="permisos" id="permisos">
                                
                            </ul>
                          </div>
                          


                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Introducir Imagen" max="300">

                            <input type="hidden" name="imagenactual" id="imagenActual">
                            
                            <img src="" alt="" width="150px" height="120px;" id="imagenmuestra">
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
    
  <script src="scripts/usuario.js"> 
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
  <?php
  }
  ob_end_flush();
?>