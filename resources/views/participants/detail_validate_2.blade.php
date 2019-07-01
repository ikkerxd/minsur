
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-check-circle-o"></i> Validar Participante
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Validar usuario</li>
  </ol>
  
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">    
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">              
              <h3>{{ $histories[0]->participante }}<br>
              <small>DNI {{ $histories[0]->dni }}</small>
              </h3>
            </div>
          </div>
          <div class="row"> 
            <div class="col-md-12">           
              <table class="table">
                <thead>
                  <tr>     
                  <th>FECHA</th>
                   <th>SEDE</th>
                   <th>CURSO</th>
                   <th>EMPRESA</th> 
                   <th>FECHA</th>
                   <th>VENCE</th>
                   <th>NOTA</th>
                   <th>ASISTENCIA</th>
                 </tr>
               </thead>
               <tbody>
                @foreach ($data_generals as $element)
                <tr>
                  <td>{{ $element->fecha }}</td>
                  <td>{{ $element->nameLocation }}</td>
                  <td>{{ $element->nameCourses }}</td>
                  <td>{{ $element->businessName }}</td>
                  <td><?php echo date("Y-m-d",strtotime($element->fecha."+ 1 year")); ?></td>
                  <?php
                  $nuevafecha = strtotime ( '+365 day' , strtotime ( $element->fecha ) ) ; 
                  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                  $datetime1 = new DateTime("now");
                  $datetime2 = new DateTime($nuevafecha);
                  $interval = $datetime1->diff($datetime2);
                  if ($interval->format('%R%a') >180 && $interval->format('%R%a') <=400) {
                    echo '<td style="background:green;color:white;font-weight:bold;">'.$interval->format('%R%a dias').'</td>';
                  }elseif ($interval->format('%R%a') >30 && $interval->format('%R%a') <=180){
                    echo '<td class="info">'.$interval->format('%R%a dias').'</td>';
                  }elseif ($interval->format('%R%a') >0 && $interval->format('%R%a') <=30){
                    echo '<td style="background:orange;color:white;font-weight:bold;">'.$interval->format('%R%a dias').'</td>';
                  }else{
                    echo '<td style="background:red;color:white;font-weight:bold;">'.$interval->format('%R%a dias').'</td>';
                  }
                  ?>

                  <td class="text-center">{{ $element->nota }}</td>
                  <td class="text-center">{{ $element->asistencia }}</td>
                </tr>
                @endforeach

              </tbody>              
            </table>
          </div>
        </div>   
        
          <div class="row"> 
            <div class="col-md-12">           
              <table class="table">
                <thead>
                  <tr>     
                  <th>FECHA</th>
                   <th>SEDE</th>
                   <th>CURSO</th>
                   <th>EMPRESA</th> 
                   <th>FECHA</th>
                   <th>VENCE</th>
                   <th>NOTA</th>
                   <th>ASISTENCIA</th>
                 </tr>
               </thead>
               <tbody>
                @foreach ($histories as $element)
                <tr>
                  <td>{{ $element->fecha }}</td>
                  <td>{{ $element->nameLocation }}</td>
                  <td>{{ $element->nameCourses }}</td>
                  <td>{{ $element->businessName }}</td>
                  <td><?php echo date("Y-m-d",strtotime($element->fecha."+ 1 year")); ?></td>
                  <?php
                  $nuevafecha = strtotime ( '+365 day' , strtotime ( $element->fecha ) ) ; 
                  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                  $datetime1 = new DateTime("now");
                  $datetime2 = new DateTime($nuevafecha);
                  $interval = $datetime1->diff($datetime2);
                  if ($interval->format('%R%a') >180 && $interval->format('%R%a') <=400) {
                    echo '<td style="background:green;color:white;font-weight:bold;">'.$interval->format('%R%a dias').'</td>';
                  }elseif ($interval->format('%R%a') >30 && $interval->format('%R%a') <=180){
                    echo '<td class="info">'.$interval->format('%R%a dias').'</td>';
                  }elseif ($interval->format('%R%a') >0 && $interval->format('%R%a') <=30){
                    echo '<td style="background:orange;color:white;font-weight:bold;">'.$interval->format('%R%a dias').'</td>';
                  }else{
                    echo '<td style="background:red;color:white;font-weight:bold;">'.$interval->format('%R%a dias').'</td>';
                  }
                  ?>

                  <td class="text-center">{{ $element->nota }}</td>
                  <td class="text-center">{{ $element->asistencia }}</td>
                </tr>
                @endforeach

              </tbody>              
            </table>
          </div>
        </div>                 
      </div>
    </div> 
  </div>
</div>
</section>
@endsection
