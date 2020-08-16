<?php

// Almacenamiento en el buffer
ob_start();

session_start();

if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{
require 'header.php';

if($_SESSION['escritorio']==1)
{
  require_once '../modelos/Consultas.php';
  $consulta = new Consultas();
  $repuestaC = $consulta->totalComprashoy();  
  $fila = $repuestaC->fetch_object();
  $totalc= $fila->total_compra;

  $repuestaV = $consulta->totalVentahoy();
  $fila = $repuestaV->fetch_object();
  $totalv= $fila->total_venta;

  // DATOS PARA MOSTRAR EL GRAFICO DE LAS BARRAS DE LAS COMPRAS 
  $compras10=$consulta->comprasultimos_10dias();
  $fechac='';
  $totalesc='';
  while($filafecha = $compras10->fetch_object()){
    $fechac = $fechac.'"'.$filafecha->fecha.'",';
    $totalesc=$totalesc.$filafecha->total .',';
  }
  // QUITAMOS LA ULTIMA COMA
  $fechac=substr($fechac,0,-1);
  $totalesc=substr($totalesc,0,-1);

  // DATOS PARA MOSTRAR EL GRAFICO DE LAS BARRAS DE LAS VENTAS 
  $ventas12=$consulta->ventasultimos_12meses();
  $fechav='';
  $totalesv='';
  while($filafecha = $ventas12->fetch_object()){
    $fechav = $fechav.'"'.$filafecha->fecha.'",';
    $totalesv=$totalesv.$filafecha->total .',';
  }
  // QUITAMOS LA ULTIMA COMA
  $fechav=substr($fechav,0,-1);
  $totalesv=substr($totalesv,0,-1);
  

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
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body" >
                      <div class="col-sm-6">
                        <div class="small-box bg-aqua">
                          <div class="inner">
                            <h4 style="font-size: 17px;">
                              <strong>S/ <?php
                                echo $totalc;
                              ?></strong>
                            </h4>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="ingreso.php" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i> </a>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="small-box bg-green">
                          <div class="inner">
                            <h4 style="font-size: 17px;">
                              <strong>S/ <?php
                                echo $totalv;?></strong>
                            </h4>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="ingreso.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i> </a>
                        </div>

                        
                      </div>

                    </div>

                    <div class="panel-body">
                         <div class="col-sm-6 col-xs-12">
                           <div class="box box-primary">
                             <div class="box-header with-border">
                               Compras de los Ultimos 10 dias
                             </div>
                             <!-- la etiqueta canvas se utiliza para mostrar graficos -->
                            <canvas id="compras" width="400" height="300"></canvas>
                           </div>
                         </div> 

                         <div class="col-sm-6 col-xs-12">
                           <div class="box box-primary">
                             <div class="box-header with-border">
                               Ventas de los ultimos 12 meses
                             </div>
                             <!-- la etiqueta canvas se utiliza para mostrar graficos -->
                            <canvas id="ventas" width="400" height="300"></canvas>
                           </div>
                         </div>

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
  
  <script src="../public/js/Chart.min.js"></script>
  <script src="../public/js/Chart.bundle.min.js">  </script>

  <script>
var ctx = document.getElementById('compras').getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechac;?>],
        datasets: [{
            label: '# Compras S/ de los ultimos 10 dias',
            data: [<?php echo $totalesc;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById('ventas').getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechav;?>],
        datasets: [{
            label: '# Ventas S/ de los ultimos 12 meses',
            data: [<?php echo $totalesv;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


</script>

<?php
  }
  ob_end_flush();
?>