@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-area-chart" aria-hidden="true"></i> Reporte de participantes
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li>Reporte</li>
    <li class="active">Reporte Participantes</li>
  </ol>
  
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
         <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a excel</a>

       </div> 
       <div class="box-body table-responsive no-padding">
        <div class="col-md-8">
          <table class="table table-bordered table-hover text-center">
            <thead>
              <tr>                            
                <th>DNI</th>              
                <th>APELLIDO PATERNO</th>
                <th>APELLIDO MATERNO</th>
                <th>NOMBRES</th>
                <th>CARGO</th>                    
                <th>CONDICIÓN</th>                  
              </tr>
            </thead>
            <tbody>
              @php
                $aprobados = 0;
                $desaprobados = 0;
                $faltantes = 0;
              @endphp
              @foreach ($participants as $participant)

              if($participant->point > 13){
                $aprobados = $aprobados +1;
              }elseif($participant->condition >= 0 && $participant->condition == 'A'){
                $desaprobados = $desaprobados +1;
              }

              if($participant->condition == 'F')
              {
                $faltantes = $faltantes+1;
              }
              ?>

              <tr>
                <td>{{$participant->dni}}</td>
                <td>{{$participant->firstLastName}}</td>
                <td>{{$participant->secondLastName}}</td>
                <td>{{$participant->name}}</td>
                <td>{{$participant->position}}</td>
                <td>
                  @if ($participant->point > 13)
                    <span>APROBADO</span>
                    @elseif($participant->point == 0 && $participant->condition == 'F')
                  <span>FALTO</span>
                  @elseif($participant->point == 0 && $participant->condition == 0)
                  <span>-</span>
                  
                  @else
                    <span>DESAPROBADO</span>
                  @endif
                </td> 
              </tr>
              @endforeach
            </tbody>              
          </table>
          {{$participants->render()}}
        </div>

        <div class="col-md-4">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><strong>Gráfico de Condiciones</strong></h3>
            </div>            
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                    <canvas id="salesChart" style="display:none;"></canvas>
                  </div>                  
                </div>              
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">                  
                    <li><i class="fa fa-circle-o text-green"></i> Aprobados</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> Desaprobados</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> Faltantes</li>                    
                  </ul>
                </div>              
              </div>            
            </div>          
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="#">Total Inscritos
                  <span class="pull-right text-blue"> 
                    @php 
                      echo count($participants) 
                    @endphp
                  </span></a></li>
                  <li><a href="#">Total Aprobados
                    <span class="pull-right text-green">
                      @php
                        echo $aprobados;
                      @endphp
                    </span></a></li>
                    <li><a href="#">Total Desaprobados 
                      <span class="pull-right text-red"> 
                      @php
                        echo $desaprobados;
                      @endphp
                    </span></a>
                    </li>
                    <li><a href="#">Total Faltantes
                      <span class="pull-right text-yellow"> 
                      @php
                        echo $faltantes;
                      @endphp
                    </span></a></li>
                    </ul>
                  </div>            
                </div>
              </div>
            </div>      
          </div>  
        </div>
      </div>
    </section> 

    @endsection

    @section('script')
    <script>
      $(function () {
    
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [      
    {
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'Aprobados'
    },
    {
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'Desaprobados'
    },
    {
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'Faltantes'
    }      
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)

  })
</script>
@endsection